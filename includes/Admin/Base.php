<?php
namespace Fardin\Autonova\Admin;

if (!defined('ABSPATH')) {
    exit;
}

class Base
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
        $this->admin_enqueue_scripts();
        $this->load_dep();
    }

    public function load_dep(){
        GlobalHeaderContent::instance();
    }

    public function admin_enqueue_scripts()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }


    public function enqueue_scripts($hook)
    {

        if ($hook !== 'toplevel_page_theme-options') {
            return;
        }

        wp_enqueue_style(
            'autonova-admin-style',
            AUTONOVA_PLUGIN_URL . './assets/css/admin.css',
            [],
            AUTONOVA_PLUGIN_VERSION
        );
    }

}