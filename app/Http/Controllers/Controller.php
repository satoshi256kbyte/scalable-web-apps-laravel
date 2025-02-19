<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

require_once __DIR__ . '/../../../vendor/autoload.php';

abstract class Controller
{
    /**
     * リクエストヘッダーからJWTを取得するメソッド
     * @see https://docs.aws.amazon.com/ja_jp/elasticloadbalancing/latest/application/listener-authenticate-users.html
     * */
    protected function getCognitoPayload(Request $request)
    {

        // Step 1: Validate the signer
        // $expected_alb_arn = 'arn:aws:elasticloadbalancing:region-code:account-id:loadbalancer/app/load-balancer-name/load-balancer-id';

        // Assuming the JWT is in the 'x-amzn-oidc-data' header (you will need to extract it from the request headers)
        $encoded_jwt = $request->header('x-amzn-oidc-data');
        echo $encoded_jwt;
        if ($encoded_jwt === null) {
            return 'No JWT found in headers';
        }

        // Decode the JWT header (first part of the JWT)
        $jwt_headers = $encoded_jwt.split('.')[0]
        $decoded_jwt_headers = base64.b64decode($jwt_headers)
        $decoded_jwt_headers = $decoded_jwt_headers.decode("utf-8")
        var_dump($decoded_jwt_headers);
        $decoded_json = json.loads($decoded_jwt_headers)
        var_dump($decoded_json);
        $kid = decoded_json['kid']
        var_dump($kid);
        // $region = 'ap-northeast-1'; // AWS リージョン
        // $url = "https://public-keys.auth.elb.$region.amazonaws.com/$kid";

        // $client = new Client();
        // $response = $client->request('GET', $url);
        // $pub_key = $response->getBody()->getContents();

        // $decoded_payload = JWT::decode($encoded_jwt, $pub_key, ['ES256']);

        // return json_encode($decoded_payload, JSON_PRETTY_PRINT);
    }
}
