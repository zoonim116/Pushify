<?php
if (! defined('ABSPATH')) {
    exit;
}

require_once PUSHIFY_PATH.'templates/dashboard_tabs.php';
?>

<div class="nav-tab-content">
    <div class="nav-tab-inside">
        <h3><?php esc_html_e('Test and debug', 'pushify') ?></h3>
        <form action="options.php" method="POST">
            <?php settings_fields('hi_fcm_settings_group') ?>
            <?php do_settings_sections('hi_fcm_settings_group') ?>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e('Save Changes', 'wp') ?>">
            </p>
        </form>
    </div>
    <?php do_action('hi_fcm/dashboard/tabs/contents') ?>
</div>