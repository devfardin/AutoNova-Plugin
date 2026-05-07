<?php
namespace Fardin\Autonova\Widgets;

if (!defined("ABSPATH")) {
    exit;
}

class WidgetsBase
{
    use \Fardin\Autonova\App\Traits\Singletion;

    public function init()
    {
        add_action('elementor/widgets/register', [$this, "register_new_widgets"]);
        add_action("wp_enqueue_scripts", [$this, 'enqueue_scripts']);
        add_action("elementor/editor/before_enqueue_styles", [$this, 'enqueue_scripts']);
        add_action('elementor/frontend/after_register_styles', [$this, "register_scripts"]);

    }

    public function register_new_widgets($widgets_manager) {
        $widgets_manager->register(BasicWidget::instance());
        $widgets_manager->register(WhatsappBtn::instance());
    }
    public function register_scripts()
    {
        
        // wp_register_script('autonova_whatsappBtn', AUTONOVA_PLUGIN_URL . 'assets/js/....', array('jquery'), AUTONOVA_PLUGIN_VERSION, true);
    }
    public function enqueue_scripts()
    {
        // wp_register_style('autonova_whatsapp', AUTONOVA_PLUGIN_URL . 'assets/css/whatsappBtn.css', array(), AUTONOVA_PLUGIN_VERSION, 'all');

        wp_enqueue_style('autonova_whatsapp', AUTONOVA_PLUGIN_URL . 'assets/css/whatsappBtn.css', array(), AUTONOVA_PLUGIN_VERSION, 'all');
        
    }
} 