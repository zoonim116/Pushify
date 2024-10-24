<?php

namespace Pushify\Admin;

class Filters
{
    public static function init() {
        add_filter('pushify_title_credentials', array(self::class, 'pushify_title_credentials'), 10, 1);
        add_filter('pushify_post_title', array(self::class, 'pushify_post_title'), 10, 1);
        add_filter('pushify_post_content', array(self::class, 'pushify_post_content'), 10, 1);
        add_filter('pushify_post_thumbnail', array(self::class, 'pushify_post_thumbnail'), 10, 1);
        add_filter('pushify_notification_data', array(self::class, 'pushify_notification_data'), 10, 2);
        add_filter('pushify_custom_fields', array(self::class, 'pushify_custom_fields'), 20, 1);
        add_filter('pushify_post_types', array(self::class, 'pushify_post_types'), 10, 1);
    }

    public static function pushify_title_credentials($credentials)
    {
        return $credentials->project_id ?? '';
    }

    public static function pushify_post_title($post)
    {
        return $post->post_title;
    }

    public static function pushify_post_content($post)
    {
        return _mb_strlen($post->post_excerpt) == 0 ? _mb_substr(esc_html(wp_strip_all_tags(preg_replace( "/\r|\n/", " ", $post->post_content))), 0, 55) . '...' : $post->post_excerpt;
    }

    public static function pushify_post_thumbnail($post)
    {
        return wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')[0];
    }

    public static function pushify_custom_fields($post)
    {
        return [];
    }

    public static function pushify_notification_data($post, $data)
    {
        return $data;
    }

    public static function pushify_post_types($types)
    {

    }
}