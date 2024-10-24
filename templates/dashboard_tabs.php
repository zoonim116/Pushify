<?php
if (! defined('ABSPATH')) {
    exit;
}
?>

<h1><?php esc_html_e('Pushify Settings', 'pushify') ?> for <?php esc_html_e(apply_filters('pushify_title_credentials', \Pushify\Admin\Settings::get_credentials())) ?></h1>

<h2 class="nav-tab-wrapper">
    <a href="<?php echo esc_url(admin_url('admin.php?page=pushify_settings')) ?>" class="nav-tab <?php esc_html_e($_GET['page'] == 'pushify_settings' ? 'nav-tab-active' : '') ?>">
        <?php esc_html_e('General Settings', 'pushify') ?>
    </a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=pushify_additional_settings')) ?>" class="nav-tab <?php esc_html_e($_GET['page'] == 'pushify_additional_settings' ? 'nav-tab-active' : '') ?>">
        <?php esc_html_e('Additional Settings', 'pushify') ?>
    </a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=pushify_testing_settings')) ?>" class="nav-tab <?php esc_html_e($_GET['page'] == 'pushify_testing_settings' ? 'nav-tab-active' : '') ?>">
        <?php esc_html_e('Testing and debug', 'pushify') ?>
    </a>
</h2>
