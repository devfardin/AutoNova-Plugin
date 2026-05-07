<?php
namespace Fardin\Autonova\Admin;

if (!defined('ABSPATH')) {
    exit;
}

class AdminBase
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
        $this->load_dep();
        add_action('elementor/init', [$this, 'register_global_colors']);
    }

    public function register_global_colors()
    {
        $kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
        if (!$kit_id) return;

        $meta_key = '_elementor_page_settings';
        $settings = get_post_meta($kit_id, $meta_key, true) ?: [];

        $overrides = [
            'primary'   => '#ed7d37',
            'secondary' => '#000000',
            'primary-hover' => '#ff9a5c',
            'heading' => '#ffffff',
            'text' => '#a0a0a0',
            'bg-main' => '#050505',
            'bg-section-dark' => '#0a0a0a',
            'bg-section' => '#0d0d0d',
            'bg-section-light' => '#111111',
            'bg-card' => '#141414',
            'border' => 'rgba(255, 255, 255, 0.4)',
            'border-hover' => 'rgba(237, 125, 55, 0.3)',

        ];

        $existing_ids = array_column($settings['system_colors'] ?? [], '_id');

        foreach ($settings['system_colors'] as &$color) {
            if (isset($overrides[$color['_id']])) {
                $color['color'] = $overrides[$color['_id']];
            }
        }

        foreach ($overrides as $id => $value) {
            if (!in_array($id, $existing_ids)) {
                $settings['system_colors'][] = [
                    '_id'   => $id,
                    'title' => ucwords(str_replace('-', ' ', $id)),
                    'color' => $value,
                ];
            }
        }

        update_post_meta($kit_id, $meta_key, $settings);
    }


    public function load_dep()
    {
        PageHeroSettings::instance();
        AdminEnqueue::instance()->init();
        TeamSettings::instance()->init();
        AdminPage::instance()->init();
        FAQSettings::instance()->init();
    }

}
