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
}