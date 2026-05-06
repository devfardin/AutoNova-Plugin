<?php
namespace Fardin\Autonova\Frontend;
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Plugin;
class PageHero
{
    use \Fardin\Autonova\App\Traits\Singletion;

    function __construct()
    {
        add_action('kadence_before_content', [$this, 'render_custom_page_header'], 5);
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
        <div class="custom-page-header">
            <div class="overlay"></div>
            <div class="header-content-wrapper" style="background-image: url(' <?php echo esc_url($bg_image) ?>');">
                <div class="container autonova-container">
                    <div class="header-content">
                        <?php if ($subtitle): ?>
                            <div class="sub-heading-wrapper">
                                <span class="divider"></span>
                                <p class="custom-page-subtitle"> <?php echo esc_html($subtitle) ?> </p>
                                <span class="divider"></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($title): ?>
                            <h1 class="custom-page-title"> <?php echo esc_html($title) ?> </h1>
                        <?php endif; ?>
                        <?php if ($description): ?>
                            <p class="custom-page-description"> <?php echo esc_html($description) ?> </p>
                        <?php endif; ?>

                        <!-- header breadcome -->
                        <div class="breadcrumb">
                            <span><a href="/">Home</a></span>
                            <span> / </span>
                            <span><?php echo esc_html(get_the_title()) ?></span>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <?php
    }

}
