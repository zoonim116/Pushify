<?php

namespace Pushify\Admin;

use Pushify\Helper;

class Menu
{
    public static function register_menu() {
        global $menu, $submenu;
        add_menu_page(
            __('Pushify', 'pushify'),
            __('Pushify', 'pushify'),
            'manage_options',
            'pushify_settings',
            'Pushify\Admin\Menu::draw_settings_screen',
            'data:image/svg+xml;base64,' . base64_encode(file_get_contents(PUSHIFY_PATH.'/assets/notification_icon.svg')),
            16
        );
        add_submenu_page(
            null,
            'Additional Settings',
            'Additional Settings',
            'manage_options',
            'pushify_additional_settings',
            'Pushify\Admin\Menu::draw_additional_settings_screen',
        );
        add_submenu_page(
            null,
            'Testing and debug',
            'Testing and debug',
            'manage_options',
            'pushify_testing_settings',
            'Pushify\Admin\Menu::draw_testing_settings_screen',
        );
    }

    public static function draw_settings_screen() {
        $post_types = Helper::get_post_types();
        ob_start();
        require_once PUSHIFY_PATH . '/templates/settings.php';
        echo ob_get_clean();
    }

    public static function draw_additional_settings_screen()
    {
        ob_start();
        require_once PUSHIFY_PATH . '/templates/additional_settings.php';
        echo ob_get_clean();
    }

    public static function draw_testing_settings_screen() {
        ob_start();
        require_once PUSHIFY_PATH . '/templates/testing_settings.php';
        echo ob_get_clean();
    }
}