<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;

require_once __DIR__ . '/../../../vendor/autoload.php';

abstract class Controller
{
    /**
     * リクエストヘッダーからJWTを取得するメソッド
     * @see https://docs.aws.amazon.com/ja_jp/elasticloadbalancing/latest/application/listener-authenticate-users.html
     * */
    protected function getCognitoPayload()
    {

        // Step 1: Validate the signer
        // $expected_alb_arn = 'arn:aws:elasticloadbalancing:region-code:account-id:loadbalancer/app/load-balancer-name/load-balancer-id';

        // Assuming the JWT is in the 'x-amzn-oidc-data' header (you will need to extract it from the request headers)
        $encoded_jwt = $_SERVER['HTTP_X_AMZN_OIDC_DATA'] ?? null;
        if (!$encoded_jwt) {
            return 'No JWT found in the request';
        }

        // Decode the JWT header (first part of the JWT)
        $jwt_parts = explode('.', $encoded_jwt);
        $jwt_headers = base64_decode($jwt_parts[0]);
        $decoded_jwt_headers = json_decode($jwt_headers, true);

        // $received_alb_arn = $decoded_jwt_headers['signer'];

        // if ($expected_alb_arn !== $received_alb_arn) {
        //     throw new Exception("Invalid Signer");
        // }

        $kid = $decoded_jwt_headers['kid'];

        $region = 'ap-northeast-1'; // AWS リージョン
        $url = "https://public-keys.auth.elb.$region.amazonaws.com/$kid";

        $client = new Client();
        $response = $client->request('GET', $url);
        $pub_key = $response->getBody()->getContents();

        $decoded_payload = JWT::decode($encoded_jwt, $pub_key, ['ES256']);

        return json_encode($decoded_payload, JSON_PRETTY_PRINT);
    }
}
