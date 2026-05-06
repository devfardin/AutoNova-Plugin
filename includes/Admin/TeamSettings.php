<?php
namespace Fardin\Autonova\Admin;
if (!defined('ABSPATH')) {
    exit;
}
class TeamSettings
{
    use \Fardin\Autonova\App\Traits\Singletion;

    public function init()
    {
        add_action('acf/init', [$this, 'register_options_page']);
        add_action('acf/init', [$this, 'register_fields']);
    }

    public function register_options_page()
    {
       
        acf_add_options_sub_page([
            'page_title' => 'Team Members',
            'menu_title' => 'Team Members',
            'parent_slug' => 'theme-options',
            'capability' => 'manage_options',
            'menu_slug' => 'team-members',
        ]);
    }

    public function register_fields()
    {
        if (!function_exists('acf_add_local_field_group'))
            return;

        acf_add_local_field_group([
            'key' => 'group_team_members',
            'title' => 'Team Members',
            'fields' => [
                [
                    'key' => 'field_team_members',
                    'name' => 'team_members',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Team Member',
                    'sub_fields' => [
                        [
                            'key' => 'field_team_member_name',
                            'label' => 'Name',
                            'name' => 'name',
                            'type' => 'text',
                        ],
                        [
                            'key' => 'field_team_member_role',
                            'label' => 'Role',
                            'name' => 'role',
                            'type' => 'text',
                        ],
                        [
                            'key' => 'field_team_member_bio',
                            'label' => 'Bio',
                            'name' => 'bio',
                            'type' => 'textarea',
                            'rows' => 3,
                        ],
                        [
                            'key' => 'field_team_member_photo',
                            'label' => 'Photo',
                            'name' => 'photo',
                            'type' => 'image',
                            'return_format' => 'url',
                            'preview_size' => 'thumbnail',
                        ],
                    ],
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'team-members',
                    ],
                ]
            ],
        ]);
    }
}
