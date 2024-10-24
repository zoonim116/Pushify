<?php
use Pushify\Admin\Settings;
if (! defined('ABSPATH')) {
    exit;
}

require_once PUSHIFY_PATH.'templates/dashboard_tabs.php';
?>

<div class="nav-tab-content">
    <div class="nav-tab-inside">
        <h3><?php esc_html_e('General Settings', 'pushify') ?></h3>
        <form action="options.php" method="POST" enctype="multipart/form-data">
            <?php settings_fields('pushify_settings') ?>
            <?php do_settings_sections('pushify_settings') ?>
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">
                        <label for="pushify_conf_credentials"><?php esc_html_e('Service Account json file', 'pushify') ?><span class="required">*</span></label>
                    </th>
                    <td>
                        <input type="file" id="pushify_conf_credentials" accept="application/json" name="pushify_conf_credentials" <?php echo !get_option('pushify_conf_credentials') ? 'required' : ''; ?>>
                        <?php if (get_option('pushify_conf_credentials')): ?>
                            <span class="filename"><?php echo pathinfo(get_option('pushify_conf_credentials'))['filename'].'.json'; ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="pushify_conf_channel"><?php esc_html_e('Channel ID', 'pushify') ?><span class="required">*</span></label>
                    </th>
                    <td>
                        <input id="pushify_conf_channel" name="pushify_conf_channel" type="text" value="<?php esc_attr_e(get_option('pushify_conf_channel')) ?>" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="pushify_conf_sound"><?php esc_html_e('Sound', 'pushify') ?><span class="required">*</span></label>
                    </th>
                    <td>
                        <input id="pushify_conf_sound" name="pushify_conf_sound" type="text" value="<?php esc_attr_e(get_option('pushify_conf_sound', 'default')) ?>" required>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e('Save Changes', 'wp') ?>">
            </p>
        </form>
    </div>
</div>