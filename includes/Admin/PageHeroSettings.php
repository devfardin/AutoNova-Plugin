<?php
namespace Fardin\Autonova\Admin;

if (!defined('ABSPATH')) {
    die('Direct access not allowed!');
}

class PageHeroSettings
{
    use \Fardin\Autonova\App\Traits\Singletion;

    public function __construct()
    {
        add_action('acf/init', [$this, 'register_page_header_fields']);
        add_filter('theme_mod_page_title', [$this, 'disable_page_title']);

        // Remove Editor opton
        add_action('init', [$this, 'remove_editor_from_pages'], 999);
    }

    // Remove Editor opton
    function remove_editor_from_pages()
    {
        remove_post_type_support('page', 'editor');
    }

    // Register Custom ACF Fields
    public function register_page_header_fields()
    {
        if (!function_exists('acf_add_local_field_group'))
            return;

        acf_add_local_field_group([
            'key' => 'group_custom_page_header',
            'title' => 'Custom Page Header',
            'fields' => [
                [
                    'key' => 'field_enable_custom_header',
                    'label' => 'Enable Custom Header',
                    'name' => 'enable_custom_header',
                    'type' => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                ],
                [
                    'key' => 'field_page_title',
                    'label' => 'Page Title',
                    'name' => 'page_title',
                    'type' => 'text',
                    'placeholder' => 'Leave empty to use page name',
                    'conditional_logic' => [[['field' => 'field_enable_custom_header', 'operator' => '==', 'value' => '1']]],
                ],
                [
                    'key' => 'field_page_subtitle',
                    'label' => 'Page Subtitle',
                    'name' => 'page_subtitle',
                    'type' => 'text',
                    'conditional_logic' => [[['field' => 'field_enable_custom_header', 'operator' => '==', 'value' => '1']]],
                ],
                [
                    'key' => 'field_page_description',
                    'label' => 'Page Description',
                    'name' => 'page_description',
                    'type' => 'textarea',
                    'conditional_logic' => [[['field' => 'field_enable_custom_header', 'operator' => '==', 'value' => '1']]],
                ],
                [
                    'key' => 'field_page_background',
                    'label' => 'Background Image',
                    'name' => 'page_background',
                    'type' => 'image',
                    'return_format' => 'url',
                    'conditional_logic' => [[['field' => 'field_enable_custom_header', 'operator' => '==', 'value' => '1']]],
                ],
            ],
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]],
        ]);
    }

    public function disable_page_title($value)
    {
        if (is_page() && function_exists('get_field') && get_field('enable_custom_header')) {
            return false;
        }
        return $value;
    }

}