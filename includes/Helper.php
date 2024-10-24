<?php

namespace Pushify;

class Helper
{
    public static function is_request($type) {
        switch ($type) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined('DOING_AJAX');
            case 'frontend' :
                return (!is_admin() || defined('DOING_AJAX')) && ! defined('DOING_CRON');
        }
    }

    public static function can($post) {
        if ($post instanceof \WP_Post_Type) {
            return get_option('pushify_post_type_' . $post->name) == '1';
        }
        return false;
    }

    public static function get_post_types()
    {
        $all_post_types = get_post_types([
            'public'   => true,
            '_builtin' => true,
        ], 'object');
        return apply_filters('pushify_post_types', $all_post_types);
    }
}