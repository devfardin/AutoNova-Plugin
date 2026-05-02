<?php
namespace Fardin\Autonova\Admin;

if (!defined('ABSPATH')) {
    die('Direct access not allowed!');
}

class GlobalHeaderContent
{
    use \Fardin\Autonova\App\Traits\Singletion;

    public function __construct()
    {
        add_action('acf/init', [$this, 'register_page_header_fields']);
        add_filter('theme_mod_page_title', [$this, 'disable_page_title']);
        add_action('kadence_before_content', [$this, 'render_custom_page_header'], 5);
    }

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

    public function render_custom_page_header()
    {
        if (!is_page() || !function_exists('get_field') || !get_field('enable_custom_header')) {
            return;
        }

        $title = get_field('page_title') ?: get_the_title();
        $subtitle = get_field('page_subtitle');
        $description = get_field('page_description');
        $bg_image = get_field('page_background');

        ?>
        <div style="background-image: url(' <?php echo esc_url($bg_image) ?> ');">

            <?php if ($subtitle): ?>
                <p class="custom-page-subtitle"> <?php echo esc_html($subtitle) ?> </p>
            <?php endif; ?>
            <?php if ($title): ?>
                <h1 class="custom-page-title"> <?php echo esc_html($title) ?> </h1>
            <?php endif; ?>
            <?php if ($description): ?>
                <p class="custom-page-description"> <?php echo esc_html($description) ?> </p>
            <?php endif; ?>
            

            <div>
                <!-- header breadcome -->
                <div class="breadcrumb">
                    <span><a href="/">Home</a></span>
                    <span> / </span>
                    <span><?php echo esc_html(get_the_title()) ?></span>
                </div>
            </div>

        </div>

        <?php

        // echo '<div class="custom-page-header ' . esc_attr(get_the_title()) . '">';

        // if ( ($bg_type === 'video' && $bg_video) || ($bg_type === 'url' && $bg_video_url) ) {
        //     $video_src = $bg_type === 'url' ? $bg_video_url : $bg_video;
        //     $embed_url = $this->get_embed_url($video_src);

        //     if ($embed_url !== $video_src) {
        //         echo '<iframe src="' . esc_url($embed_url) . '" frameborder="0" allow="autoplay; fullscreen" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;"></iframe>';
        //     } else {
        //         echo '<video autoplay muted loop playsinline style="position:absolute;top:0;left:0;width:100%;height:100%;"><source src="' . esc_url($video_src) . '" type="video/mp4"></video>';
        //     }
        // } elseif ( $bg_type === 'image' && $bg_image ) {
        //     echo '<div class="custom-page-header-bg" style="background-image: url(' . esc_url($bg_image) . ');"></div>';
        // }
        // echo '<div class="custom-page-header-overlay"></div>';
        // echo '<div class="entry-content-wrap">';
        // echo '<h1 class="custom-page-title">' . esc_html($title) . '</h1>';
        // if ( $subtitle ) {
        //     echo '<p class="custom-page-subtitle">' . esc_html($subtitle) . '</p>';
        // }
        // echo '</div></div>';
    }
}