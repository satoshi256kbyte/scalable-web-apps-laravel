<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

require_once __DIR__ . '/../../../vendor/autoload.php';

abstract class Controller
{
    /**
     * リクエストヘッダーからJWTを取得して解析するメソッド
     * コントローラーの基底クラスに実装して、他のコントローラーで継承して利用する想定
     * @param Request $request HTTPリクエスト
     * @see https://docs.aws.amazon.com/ja_jp/elasticloadbalancing/latest/application/listener-authenticate-users.html
     * */
    protected function getCognitoPayload(Request $request)
    {
        // Step 1: ALB から送られる JWT を取得
        $encoded_jwt = $request->header('x-amzn-oidc-data');

        if (!$encoded_jwt) {
            return response()->json(['error' => 'No JWT found in headers'], 400);
        }

        // Step 2: JWT のヘッダー部分をデコードして "kid" を取得
        $jwt_headers = explode('.', $encoded_jwt);
        $jwt_head = json_decode(base64_decode(strtr($jwt_headers[0], '-_', '+/')), true);

        if (!isset($jwt_head['kid'])) {
            return response()->json(['error' => '"kid" not found in JWT headers'], 400);
        }

        $kid = $jwt_head['kid'];
        $region = 'ap-northeast-1'; // ALB のリージョン

        // Step 3: ALB の公開鍵を取得
        $url = "https://public-keys.auth.elb.$region.amazonaws.com/$kid";
        $client = new Client();
        try {
            $response = $client->get($url);
            $pub_key = $response->getBody()->getContents();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch public key', 'message' => $e->getMessage()], 500);
        }

        // Step 4: JWT を検証
        try {
            $decoded_payload = JWT::decode($encoded_jwt, new Key($pub_key, 'ES256'));
            return response()->json($decoded_payload, 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return response()->json(['error' => 'JWT verification failed', 'message' => $e->getMessage()], 400);
        }
    }
}
