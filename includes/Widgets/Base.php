<?php
namespace Fardin\Autonova\Widgets;

if (!defined("ABSPATH")) {
    exit;
}

class Base
{
    use \Fardin\Autonova\App\Traits\Singletion;

    public function init()
    {
        add_action('elementor/widgets/register', [$this, "register_new_widgets"]);
        
        add_action("wp_enqueue_scripts", [$this, 'enqueue_scripts']);

        add_action('elementor/frontend/after_register_styles', [$this, "register_scripts"]);

        // add admin page
        // add_action('admin_menu', [$this, 'add_admin_page']);

    }
    function add_admin_page(){
        // add_menu_page(
        //     __('Autonova', 'autonova'),
        //     __('Autonova', 'autonova'),
        //     'manage_options',
        //     'autonova',
        //     [$this, 'render_admin_page'],
        //     'dashicons-car',
        //     58
        // );
    }

    function render_admin_page(){
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Autonova Settings', 'autonova'); ?></h1>
            <p><?php echo esc_html__('Welcome to Autonova plugin settings.', 'autonova'); ?></p>
        </div>
        <?php
    }


    public function register_new_widgets($widgets_manager) {
        $widgets_manager->register(BasicWidget::instance());
    }
    public function register_scripts()
    {
        wp_register_style('ele_addon_style', AUTONOVA_PLUGIN_URL . 'assets/css/main.css', array(), AUTONOVA_PLUGIN_VERSION, 'all');
    }
    public function enqueue_scripts()
    {
        wp_enqueue_style('ele_addon_style');
    }
} 