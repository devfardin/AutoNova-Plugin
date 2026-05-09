<?php
namespace Fardin\Autonova\Shortcodes;
if (!defined('ABSPATH')) {
    exit;
}
class FeatureCars
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
        add_shortcode('features_cars', [$this, 'rander_features_cars']);
    }

    public function rander_features_cars()
    {
        ob_start();
        $args = array(
            'post_type' => 'car',
            'post_status' => 'publish',
            'posts_per_page' => 3,
        );
        $query = new \WP_Query($args);
        if (!$query->have_posts()) {
            return "<p>No Cars found.</p>";
        }
        wp_enqueue_style('autonova-featue-car');
        if ($query->have_posts()): ?>
            <div class="feature-cars__wrapper">
                <div class="feature-cars__grid">
                    <?php while ($query->have_posts()):
                        $query->the_post();
                        $year = get_post_meta(get_the_ID(), 'car_year', true);
                        $mileage = get_post_meta(get_the_ID(), 'car_mileage', true);
                        $fuel = get_the_terms(get_the_ID(), 'car_fuel_type');
                        $car_status = get_the_terms(get_the_ID(), 'car_status');
                        $price = get_post_meta(get_the_ID(), 'car_sale_price', true);
                        $price = str_replace(['$', ',', ' ', 'USD'], '', $price);
                        ?>
                        <div class="feature-car__card">
                            <a class="feature-car__thumb" href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large', ['class' => 'feature-car__img']); ?>
                                <?php endif; ?>
                                <div class="feature-car__thumb-overlay"></div>
                                <?php if ($car_status): ?>
                                    <span class="feature-car__badge"><?php echo esc_html(strtoupper($car_status[0]->name)); ?></span>
                                <?php endif; ?>
                                <div class="feature-car__hover-cta">
                                    <span>VIEW DETAILS</span>
                                </div>
                            </a>
                            <div class="feature-car__info">
                                <a href="<?php the_permalink(); ?>">
                                    <h3 class="feature-car__title"><?php the_title(); ?></h3>
                                </a>
                                <div class="feature-car__meta">
                                    <?php if ($year): ?>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                <path
                                                    d="M5.625 0.625V1.875H9.375V0.625H10.625V1.875H13.125C13.4702 1.875 13.75 2.15482 13.75 2.5V12.5C13.75 12.8452 13.4702 13.125 13.125 13.125H1.875C1.52982 13.125 1.25 12.8452 1.25 12.5V2.5C1.25 2.15482 1.52982 1.875 1.875 1.875H4.375V0.625H5.625ZM12.5 6.875H2.5V11.875H12.5V6.875ZM4.375 3.125H2.5V5.625H12.5V3.125H10.625V4.375H9.375V3.125H5.625V4.375H4.375V3.125Z"
                                                    fill="#ED7D37" />
                                            </svg>

                                            <?php echo esc_html($year); ?></span>
                                    <?php endif; ?>
                                    <?php if ($mileage): ?>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                <path
                                                    d="M7.5 8.33337L1.73584 12.1761C1.59224 12.2719 1.39822 12.2331 1.30248 12.0895C1.26826 12.0381 1.25 11.9778 1.25 11.9161V3.08395C1.25 2.91136 1.38991 2.77145 1.5625 2.77145C1.62419 2.77145 1.68451 2.78972 1.73584 2.82394L7.5 6.66669V3.08395C7.5 2.91136 7.63994 2.77145 7.8125 2.77145C7.87419 2.77145 7.9345 2.78972 7.98588 2.82394L14.61 7.24C14.7536 7.33575 14.7924 7.52981 14.6966 7.67337C14.6738 7.70769 14.6443 7.73718 14.61 7.76006L7.98588 12.1761C7.84225 12.2719 7.64825 12.2331 7.5525 12.0895C7.51825 12.0381 7.5 11.9778 7.5 11.9161V8.33337ZM6.4965 7.50006L2.5 4.83569V10.1644L6.4965 7.50006ZM8.75 4.83569V10.1644L12.7465 7.50006L8.75 4.83569Z"
                                                    fill="#ED7D37" />
                                            </svg>
                                            <?php echo esc_html($mileage); ?> km</span>
                                    <?php endif; ?>
                                    <?php if ($fuel): ?>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                <path
                                                    d="M8.75 11.875H9.375V13.125H1.25V11.875H1.875V2.5C1.875 2.15482 2.15482 1.875 2.5 1.875H8.125C8.47019 1.875 8.75 2.15482 8.75 2.5V7.5H10C10.6904 7.5 11.25 8.05963 11.25 8.75V11.25C11.25 11.5952 11.5298 11.875 11.875 11.875C12.2202 11.875 12.5 11.5952 12.5 11.25V6.875H11.25C10.9048 6.875 10.625 6.59519 10.625 6.25V4.00888L9.58944 2.97335L10.4734 2.08947L13.5669 5.18306C13.689 5.3051 13.75 5.46505 13.75 5.625V11.25C13.75 12.2856 12.9106 13.125 11.875 13.125C10.8394 13.125 10 12.2856 10 11.25V8.75H8.75V11.875ZM3.125 11.875H7.5V8.125H3.125V11.875ZM3.125 3.125V6.875H7.5V3.125H3.125Z"
                                                    fill="#ED7D37" />
                                            </svg>
                                            <?php echo esc_html($fuel[0]->name); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="feature-car__divider"></div>
                                <div class="feature-car__footer">
                                    <span class="feature-car__price"><?php echo $price ? '$' . number_format($price) : ''; ?></span>
                                    <a class="feature-car__btn" href="<?php the_permalink(); ?>">DETAILS</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="feature-cars__cta">
                    <a href="<?php echo esc_url(site_url('/inventory')); ?>">
                        VIEW ALL VEHICLES
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11" fill="none">
                            <path
                                d="M7.75724 4.44851L4.40474 1.09601L5.28862 0.212128L10.15 5.07351L5.28862 9.93483L4.40474 9.05095L7.75724 5.69851H0.149994V4.44851H7.75724Z"
                                fill="#ED7D37" stroke="#ED7D37" stroke-width="0.3" />
                        </svg>
                    </a>
                </div>
            </div>


        <?php endif;
        return ob_get_clean();
    }
}