<?php
namespace Fardin\Autonova\Admin;
if (!defined('ABSPATH')) {
    exit;
}
class AdminEnqueue
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
       add_action('admin_enqueue_scripts', [$this,'style_enqueue']);
    }

    public function style_enqueue($hook)
    {
         if ($hook !== 'toplevel_page_theme-options') {
            return;
        }

        wp_enqueue_style(
            'autonova-admin-style',
            AUTONOVA_PLUGIN_URL . 'assets/css/admin.css',
            [],
            AUTONOVA_PLUGIN_VERSION,
            'all'
        );

    }


}