<?php
namespace Fardin\Autonova\Frontend;
if (!defined('ABSPATH')) {
    exit;
}

class FrontendEnqueue
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'style_enqueue']);
    }

    public function style_enqueue($hook)
    {
        wp_enqueue_style(
            'autonova-global-page-header-style',
            AUTONOVA_PLUGIN_URL . 'assets/css/page-hero.css',
            [],
            AUTONOVA_PLUGIN_VERSION,
            'all'
        );

        wp_enqueue_style(
            'autonova-main-style',
            AUTONOVA_PLUGIN_URL . 'assets/css/main.css',
            [],
            AUTONOVA_PLUGIN_VERSION,
            'all'
        );

        wp_enqueue_style(
            'autonova-theme-style',
            AUTONOVA_PLUGIN_URL . 'assets/css/theme.css',
            [],
            AUTONOVA_PLUGIN_VERSION,
            'all'
        );

        wp_register_style(
            'autonova-team-member',
            AUTONOVA_PLUGIN_URL . 'assets/css/team-member.css',
            [],
            AUTONOVA_PLUGIN_VERSION,
            'all'
        );

        wp_register_style(
            'autonova-featue-car',
            AUTONOVA_PLUGIN_URL . 'assets/css/feature-car.css',
            [],
            AUTONOVA_PLUGIN_VERSION,
            'all'
        );

        // Page style
        if (is_page('about-us')) {
            wp_enqueue_style(
                'autonova-about-us-page-style',
                AUTONOVA_PLUGIN_URL . 'assets/css/about-us.css',
                [],
                AUTONOVA_PLUGIN_VERSION,
                'all'
            );
        }
        // Page style
        if (is_page('services')) {
            wp_enqueue_style(
                'autonova-services-page-style',
                AUTONOVA_PLUGIN_URL . 'assets/css/services.css',
                [],
                AUTONOVA_PLUGIN_VERSION,
                'all'
            );
        }

        if (is_singular('car')) {
            wp_enqueue_style(
                'autonova-single-car-style',
                AUTONOVA_PLUGIN_URL . 'assets/css/single-car.css',
                [],
                AUTONOVA_PLUGIN_VERSION,
                'all'
            );
            wp_enqueue_script(
                'autonova-car-gallery',
                AUTONOVA_PLUGIN_URL . 'assets/js/car-gallery.js',
                [],
                AUTONOVA_PLUGIN_VERSION,
                true
            );  
        }
         wp_register_style(
            'autonova-footer',
            AUTONOVA_PLUGIN_URL . 'assets/css/footer.css',
            [],
            AUTONOVA_PLUGIN_VERSION
        );
        
        wp_register_style(
            'autonova-cars-inventory',
            AUTONOVA_PLUGIN_URL . 'assets/css/cars-inventory.css',
            [],
            AUTONOVA_PLUGIN_VERSION
        );



        // Get Elementor glogal container width
        $kit_id = get_option('elementor_active_kit');
        $content_width = get_post_meta($kit_id, '_elementor_page_settings', true)['container_width']['size'] ?? 1280;
        $content_width_tablet = get_post_meta($kit_id, '_elementor_page_settings', true)['container_width_tablet']['size'] ?? 1024;
        $content_width_mobile = get_post_meta($kit_id, '_elementor_page_settings', true)['container_width_mobile']['size'] ?? 767;

        wp_add_inline_style('autonova-main-style', "
            :root {
                --autonova-container-width: {$content_width}px;
            }
            @media (max-width: 1024px) {
                :root { --autonova-container-width: {$content_width_tablet}px; }
            }
            @media (max-width: 767px) {
                :root { --autonova-container-width: {$content_width_mobile}px; }
            }
        ");

    }
}
