<?php

namespace Pushify\Admin;

use Pushify\Helper;

class Settings
{
    public static function register() {
        register_setting('pushify_settings', 'pushify_conf_credentials', [
            'sanitize_callback' => [static::class, 'sanitize_credentials'],
        ]);
        register_setting('pushify_settings', 'pushify_conf_channel');
        register_setting('pushify_settings', 'pushify_conf_sound');
        foreach (Helper::get_post_types() as $post_type) {
            register_setting('pushify_settings', "pushify_post_type_{$post_type->name}");
        }
    }

    public static function sanitize_credentials()
    {
        if ($file = $_FILES['pushify_conf_credentials']['tmp_name']) {
            $file_name = $_FILES['pushify_conf_credentials']['name'];
            $upload_path = wp_upload_dir()['basedir'] . '/pushify/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path);
            }
            $file_content = file_get_contents($file);
            if (!empty($file_content)) {
                $file_data = json_decode($file_content, true);
                if (array_key_exists('private_key', $file_data)) {
                    move_uploaded_file($file, $upload_path . $file_name);
                    return $upload_path . $file_name;
                }
            }
        } else {
            return get_option('pushify_conf_credentials');
        }
    }

    public static function get_credentials()
    {
        $path = get_option('pushify_conf_credentials');
        if ($path) {
            return json_decode(file_get_contents($path));
        }
        return null;
    }

    public static function get($option) {
        return get_option($option);
    }
}