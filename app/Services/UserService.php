<?php

namespace App\Services;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Exception;

class UserService
{
    protected $cognitoClient;
    protected $userPoolId;

    public function __construct()
    {
        $this->cognitoClient = new CognitoIdentityProviderClient([
            'region'  => env('AWS_DEFAULT_REGION'),
            'version' => '2016-04-18',
            // 'credentials' => [
            //     'key'    => env('AWS_ACCESS_KEY_ID'),
            //     'secret' => env('AWS_SECRET_ACCESS_KEY'),
            // ],
        ]);

        $this->userPoolId = env('AWS_COGNITO_USER_POOL_ID');
    }

    /**
     * ユーザー情報を DB & Cognito の両方に更新
     * @param User $user Laravelのユーザーモデル
     * @param array $data 更新するユーザー情報
     */
    public function syncUser(User $user, array $data)
    {
        DB::beginTransaction(); // トランザクション開始

        try {
            // 1. DBのユーザー情報を更新、なければ作成
            $user->updateOrInsert([
                'cognito_sub' => $data['sub'],
            ], [
                'email' => $data['email'],
                'username' => $data['username'] ?? '',
                'first_name' => $data['first_name'] ?? '',
                'last_name' => $data['last_name'] ?? '',
                'phone_number' => $data['phone_number'] ?? '',
            ]);

            // 2. Cognito のユーザー情報を更新
            $updateAttributes = [];
            if (!empty($data['username'])) {
                $updateAttributes[] = ['Name' => 'preferred_username', 'Value' => $data['username']];
            }

            if (!empty($updateAttributes)) {
                $response = $this->cognitoClient->listUsers([
                    'UserPoolId' => $this->userPoolId,
                    'Filter'     => 'sub = "' . $data['sub'] . '"',
                ]);

                if (empty($response['Users'])) {
                    throw new Exception("User not found.");
                }

                $this->cognitoClient->adminUpdateUserAttributes([
                    'UserPoolId' => $this->userPoolId,
                    'Username'   => $response['Users'][0]['Username'],
                    'UserAttributes' => $updateAttributes,
                ]);
            }

            // 3. 両方の更新が成功してはじめてコミット
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("ユーザー更新に失敗しました: " . $e->getMessage());
        }
    }
}
