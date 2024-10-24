<?php

namespace Pushify\Admin;

class Assets
{
    public static function init() {
        add_action( 'admin_enqueue_scripts', function () {
            wp_enqueue_style( 'pushify_styles', PUSHIFY_URL . 'assets/css/pushify_admin.css', array(), PUSHIFY_VERSION );
        });
    }
}