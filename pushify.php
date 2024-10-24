<?php
/**
 * Pushify
 *
 * @package   Pushify
 * @author    Maxim Nepomniashchiy
 * @link      https://github.com/zoonim116/Pushify
 *
 * @wordpress-plugin
 * Plugin Name: Pushify - Firebase Cloud Messaging
 * Plugin URI:  https://github.com/zoonim116/Pushify
 * Description: Notify your app users using Firebase Cloud Messaging about new content published at your Wordpress site!
 * Version:     1.0.0
 * Author:      Maxim Nepomniashchiy
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: pushify
 * Domain Path: /i18n/
 */

use Pushify\Admin\Assets;
use Pushify\Admin\Filters;
use Pushify\Core\Sender;
use Pushify\Helper;
use Pushify\Rest\RestEndpoints;

if (!defined('ABSPATH')) {
    exit;
}

define('PUSHIFY_PATH', plugin_dir_path(__FILE__));
define('PUSHIFY_URL', plugin_dir_url(__FILE__));
define('PUSHIFY_VERSION', '1.0.0');

require_once plugin_dir_path(__FILE__) . './vendor/autoload.php';

class Pushify
{
    public function __construct()
    {
        global $wpdb;
        $this->init_hooks();
        do_action('pushify_loaded');
    }

    public function init_hooks()
    {
        $t = new RestEndpoints();
        Assets::init();
        Filters::init();
        $t->register_endpoints();
        if (Helper::is_request('admin')) {
            add_action('admin_init', 'Pushify\Admin\Settings::register');
            add_action('admin_menu', 'Pushify\Admin\Menu::register_menu');
        }

        add_action('wp_insert_post', function ($post_id, $post, $updated) {
            if ( wp_is_post_revision( $post_id ) || get_post_status( $post_id ) !== 'publish' )
                return;
            $sender = Sender::getInstance();
            $sender->forge($post);
            $sender->send();
        }, 10, 3);
    }
}

new Pushify();