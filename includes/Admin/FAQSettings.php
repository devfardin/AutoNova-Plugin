<?php
namespace Fardin\Autonova\Admin;
if (!defined('ABSPATH')) {
    exit;
}
class FAQSettings
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
        add_action('acf/init', [$this, 'register_admin_submenu_page']);
        add_action('acf/init', [$this, 'register_acf_field_group']);
    }
    public function register_admin_submenu_page()
    {
        acf_add_options_sub_page([
            'page_title' => 'FAQ Settings',
            'menu_title' => 'FAQ Settings',
            'parent_slug' => 'theme-options',
            'capability' => 'manage_options',
            'menu_slug' => 'faq-settings',
        ]);
    }
    public function register_acf_field_group()
    {
        if (!function_exists('acf_add_local_field_group'))
            return;

        acf_add_local_field_group(
            [
                'key' => 'group_faq_settings',
                'title' => 'FAQ Contents',
                'fields' => [
                    [
                        'key' => 'field_faq_settings',
                        'name' => 'faq_settings',
                        'type' => 'repeater',
                        'layout' => 'block',
                        'button_label' => 'Add Faq',
                        'sub_fields' => [
                            [
                                'key' => 'field_faq_question',
                                'label' => 'Question',
                                'name' => 'faq_question',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_faq_answear',
                                'label' => 'Answear',
                                'name' => 'faq_answear',
                                'type' => 'textarea',
                            ],
                        ]
                    ]

                ],
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'faq-settings',
                        ),
                    ),
                ),
            ]
        );
    }

}