<?php

namespace Pushify\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Pushify\Admin\Settings;

class Sender
{
    private $url = 'https://fcm.googleapis.com/v1/projects/';
    private $credentials;
    private $notification_data = [];
    private static $instance = null;

    private function __construct()
    {
    }

    static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function forge($post)
    {
        $this->credentials = Settings::get_credentials();

        $notification_data = [
            'message' => [
                'token' => 'fhkTUElgTjaY3YQnVp-9E9:APA91bE1e5Jg3Rqh_vlQsW0sZI4VavJ2GivO7WTxYh3m9TTMbyje2takWsehMhtaUi-N1bWbWGv_KD48QsQFRxzlyoT_xQeFJDVkfEMUFrJgs2XfEZBzOGtfKkXcORoAR7bue3LqQTrO',
                //'topic' => 'weather',
                'notification' => [
                    'title' => apply_filters('pushify_post_title', $post),
                    'body' => apply_filters('pushify_post_content', $post),
                    'image' => apply_filters('pushify_post_thumbnail', $post),
                ],
                'data' => [
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'show_in_notification' => 'true', // Convert to string
                    'sound' => 'default',
                    'custom_fields' => json_encode(apply_filters('pushify_custom_fields', $post)) // Convert array to JSON string
                ],
            ]
        ];

        $this->notification_data = apply_filters('pushify_notification_data', $post, $notification_data);
    }

    public function send() {
        $auth = new Auth();
        $token = $auth->get_token();

        if ($token) {
            $headers = [
                'Authorization' => ' Bearer ' . $token,
                'Content-Type' => ' application/json'
            ];
            $client = new Client();
            $promise = $client->postAsync("{$this->url}{$auth->get_project_id()}/messages:send", [
                'headers' => $headers,
                'json' => $this->notification_data
            ]);
            Utils::settle($promise)->wait();
        }
    }
}