<?php

namespace Pushify\Core;

use Pushify;

class Auth
{
    private function base64UrlEncode($text)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }

    private function generate_firebase_jwt($authConfig)
    {
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'RS256'
        ]);
        $time = time();
        $payload = json_encode([
            "iss" => $authConfig->client_email,
            "scope" => "https://www.googleapis.com/auth/firebase.messaging",
            "aud" => "https://oauth2.googleapis.com/token",
            "exp" => $time + 3600,
            "iat" => $time
        ]);
        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        $secret = openssl_get_privatekey($authConfig->private_key);
        if ($secret === false) {
            error_log('Failed to read private key.');
            return null;
        }

        openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $secret, OPENSSL_ALGO_SHA256);
        if ($signature === false) {
            error_log('Failed to sign JWT.');
            return null;
        }

        $base64UrlSignature = $this->base64UrlEncode($signature);
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        // Request token

        $options = array('http' => array(
            'method' => 'POST',
            'content' => 'grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&assertion=' . $jwt,
            'header' => "Content-Type: application/x-www-form-urlencoded"
        ));

        $context = stream_context_create($options);
        $responseText = file_get_contents("https://oauth2.googleapis.com/token", false, $context);
        if ($responseText === false) {
            error_log('Failed to get a response from Google OAuth.');
            return null;
        }

        $response = json_decode($responseText);
        return $response->access_token ?? null;
    }

    public function get_token()
    {
        $config = Pushify\Admin\Settings::get_credentials();
        return $this->generate_firebase_jwt($config);
    }

    public function get_project_id()
    {
        $config = Pushify\Admin\Settings::get_credentials();
        return $config->project_id;
    }
}