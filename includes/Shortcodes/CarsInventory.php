<?php
namespace Fardin\Autonova\Shortcodes;
if (!defined('ABSPATH')) {
    exit;
}
class CarsInventory
{
    use \Fardin\Autonova\App\Traits\Singletion;


    public function init()
    {
        add_shortcode('cars_inventory', [$this, 'rander_cars_inventory']);
        add_action('wp_ajax_cars_inventory_filter', [$this, 'ajax_filter']);
        add_action('wp_ajax_nopriv_cars_inventory_filter', [$this, 'ajax_filter']);
    }

    private function build_query_args(array $filters = []): array
    {
        $args = [
            'post_type' => 'car',
            'post_status' => 'publish',
            'posts_per_page' => 12,
        ];

        // Brand filter (taxonomy)
        if (!empty($filters['car_brand'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'car_brand',
                'field' => 'slug',
                'terms' => sanitize_text_field($filters['car_brand']),
            ];
        }

        // Type filter (taxonomy)
        if (!empty($filters['car_type'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'car_type',
                'field' => 'slug',
                'terms' => sanitize_text_field($filters['car_type']),
            ];
        }

        // Year filter (post meta)
        if (!empty($filters['car_year'])) {
            $args['meta_query'][] = [
                'key' => 'car_year',
                'value' => sanitize_text_field($filters['car_year']),
                'compare' => '=',
            ];
        }

        // Price filter (post meta range)
        if (!empty($filters['car_price'])) {
            $price_ranges = [
                'under-100k' => ['', '100000'],
                '100k-150k' => ['100000', '150000'],
                '150k-200k' => ['150000', '200000'],
                '200k-300k' => ['200000', '300000'],
                'over-300k' => ['300000', ''],
            ];
            $range = $price_ranges[$filters['car_price']] ?? null;
            if ($range) {
                if ($range[0] !== '' && $range[1] !== '') {
                    $args['meta_query'][] = [
                        'key' => 'car_sale_price',
                        'value' => [$range[0], $range[1]],
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN',
                    ];
                } elseif ($range[0] === '') {
                    $args['meta_query'][] = [
                        'key' => 'car_sale_price',
                        'value' => $range[1],
                        'type' => 'NUMERIC',
                        'compare' => '<=',
                    ];
                } else {
                    $args['meta_query'][] = [
                        'key' => 'car_sale_price',
                        'value' => $range[0],
                        'type' => 'NUMERIC',
                        'compare' => '>=',
                    ];
                }
            }
        }

        return $args;
    }

    private function render_card(): string
    {
        wp_enqueue_style('autonova-cars-inventory');
        $year = get_post_meta(get_the_ID(), 'car_year', true);
        $mileage = get_post_meta(get_the_ID(), 'car_mileage', true);
        $fuel = get_the_terms(get_the_ID(), 'car_fuel_type');
        $car_status = get_the_terms(get_the_ID(), 'car_status');
        $price = get_post_meta(get_the_ID(), 'car_sale_price', true);
        $car_color = get_the_terms(get_the_ID(), 'car_color');
        $transmission = get_post_meta(get_the_ID(), 'car_transmission', true);
        $engine = get_post_meta(get_the_ID(), 'car_engine', true);
        $ph = get_post_meta(get_the_ID(), 'car_horsepower', true);
        $car_desc = get_post_meta(get_the_ID(), 'car_description', true);
        $price = is_numeric(str_replace(['$', ',', ' ', 'USD'], '', $price))
            ? (int) str_replace(['$', ',', ' ', 'USD'], '', $price)
            : 0;
        ob_start(); ?>
        <div class="feature-car__card">
            <a class="feature-car__thumb" href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('large', ['class' => 'feature-car__img']); ?>
                <?php endif; ?>
                <div class="feature-car__thumb-overlay"></div>
                <?php if ($car_status): ?>
                    <span class="feature-car__badge"><?php echo esc_html(strtoupper($car_status[0]->name)); ?></span>
                <?php endif; ?>
                <div class="feature-car__hover-cta"><span>VIEW DETAILS</span></div>
            </a>
            <div class="feature-car__info">
                <a href="<?php the_permalink(); ?>">
                    <h3 class="feature-car__title"><?php the_title(); ?></h3>
                </a>
                <div class="feature-car__color_wrap">
                    <span class="feature-car__color">
                        <?php echo esc_html($car_color[0]->name . ' · ' . $transmission); ?>
                    </span>
                </div>
                <!-- Car info -->
                <div class="feature-car__meta_box">
                    <?php if ($year): ?>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path
                                    d="M5.625 0.625V1.875H9.375V0.625H10.625V1.875H13.125C13.4702 1.875 13.75 2.15482 13.75 2.5V12.5C13.75 12.8452 13.4702 13.125 13.125 13.125H1.875C1.52982 13.125 1.25 12.8452 1.25 12.5V2.5C1.25 2.15482 1.52982 1.875 1.875 1.875H4.375V0.625H5.625ZM12.5 6.875H2.5V11.875H12.5V6.875ZM4.375 3.125H2.5V5.625H12.5V3.125H10.625V4.375H9.375V3.125H5.625V4.375H4.375V3.125Z"
                                    fill="#ED7D37" />
                            </svg>
                            <?php echo esc_html($year); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($mileage): ?>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path
                                    d="M7.5 8.33337L1.73584 12.1761C1.59224 12.2719 1.39822 12.2331 1.30248 12.0895C1.26826 12.0381 1.25 11.9778 1.25 11.9161V3.08395C1.25 2.91136 1.38991 2.77145 1.5625 2.77145C1.62419 2.77145 1.68451 2.78972 1.73584 2.82394L7.5 6.66669V3.08395C7.5 2.91136 7.63994 2.77145 7.8125 2.77145C7.87419 2.77145 7.9345 2.78972 7.98588 2.82394L14.61 7.24C14.7536 7.33575 14.7924 7.52981 14.6966 7.67337C14.6738 7.70769 14.6443 7.73718 14.61 7.76006L7.98588 12.1761C7.84225 12.2719 7.64825 12.2331 7.5525 12.0895C7.51825 12.0381 7.5 11.9778 7.5 11.9161V8.33337ZM6.4965 7.50006L2.5 4.83569V10.1644L6.4965 7.50006ZM8.75 4.83569V10.1644L12.7465 7.50006L8.75 4.83569Z"
                                    fill="#ED7D37" />
                            </svg>
                            <?php echo esc_html($mileage); ?> km
                        </span>
                    <?php endif; ?>
                    <?php if ($fuel): ?>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path
                                    d="M8.75 11.875H9.375V13.125H1.25V11.875H1.875V2.5C1.875 2.15482 2.15482 1.875 2.5 1.875H8.125C8.47019 1.875 8.75 2.15482 8.75 2.5V7.5H10C10.6904 7.5 11.25 8.05963 11.25 8.75V11.25C11.25 11.5952 11.5298 11.875 11.875 11.875C12.2202 11.875 12.5 11.5952 12.5 11.25V6.875H11.25C10.9048 6.875 10.625 6.59519 10.625 6.25V4.00888L9.58944 2.97335L10.4734 2.08947L13.5669 5.18306C13.689 5.3051 13.75 5.46505 13.75 5.625V11.25C13.75 12.2856 12.9106 13.125 11.875 13.125C10.8394 13.125 10 12.2856 10 11.25V8.75H8.75V11.875ZM3.125 11.875H7.5V8.125H3.125V11.875ZM3.125 3.125V6.875H7.5V3.125H3.125Z"
                                    fill="#ED7D37" />
                            </svg>
                            <?php echo esc_html($fuel[0]->name); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="feature-car__meta_flex">
                    <?php if ($engine) ?>
                    <div class="feature-car__engine_meta_wrap">
                        <h6>
                            ENGINE
                        </h6>
                        <span class="feature-car__engine_meta">
                            <?php echo esc_html(substr($engine, 0, 4)); ?>
                        </span>
                    </div>
                    <div class="feature-car__engine_meta_wrap">
                        <h6>
                            HP
                        </h6>
                        <span class="feature-car__engine_meta">
                            <?php echo esc_html(strstr($ph, ' ', true)); ?>
                        </span>
                    </div>
                </div>
                <div class="feature-car__divider"></div>
                <div class="feature-car__footer">
                    <span class="feature-car__price"><?php echo $price ? '$' . number_format($price) : ''; ?></span>
                    <a class="feature-car__btn" href="<?php the_permalink(); ?>">DETAILS</a>
                </div>
            </div>
        </div>
        <?php return ob_get_clean();
    }

    private function render_grid(\WP_Query $query): string
    {
        $html = '';
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $html .= $this->render_card();
            }
            wp_reset_postdata();
        } else {
            $html = $this->render_no_cars();
        }
        return $html;
    }

    private function render_no_cars(): string
    {
        ob_start(); ?>
        <div class="feature-cars__empty">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80" fill="none">
                <path
                    d="M63.3333 66.6667H16.6667V70C16.6667 71.841 15.1743 73.3333 13.3333 73.3333H10C8.15907 73.3333 6.66667 71.841 6.66667 70V36.6667L14.935 17.3739C15.9855 14.9226 18.3958 13.3333 21.0626 13.3333H58.9373C61.6043 13.3333 64.0143 14.9226 65.065 17.3739L73.3333 36.6667V70C73.3333 71.841 71.841 73.3333 70 73.3333H66.6667C64.8257 73.3333 63.3333 71.841 63.3333 70V66.6667ZM66.6667 43.3333H13.3333V60H66.6667V43.3333ZM13.9198 36.6667H66.0803L58.9373 20H21.0626L13.9198 36.6667ZM21.6667 56.6667C18.9052 56.6667 16.6667 54.428 16.6667 51.6667C16.6667 48.9053 18.9052 46.6667 21.6667 46.6667C24.4281 46.6667 26.6667 48.9053 26.6667 51.6667C26.6667 54.428 24.4281 56.6667 21.6667 56.6667ZM58.3333 56.6667C55.572 56.6667 53.3333 54.428 53.3333 51.6667C53.3333 48.9053 55.572 46.6667 58.3333 46.6667C61.0947 46.6667 63.3333 48.9053 63.3333 51.6667C63.3333 54.428 61.0947 56.6667 58.3333 56.6667Z"
                    fill="#ED7D37" />
            </svg>
            <h3 class="feature-cars__empty-title">
                <?php esc_html_e('No vehicles found', 'autonova'); ?>
            </h3>
            <p class="feature-cars__empty-text">
                <?php esc_html_e('Try adjusting your filters to see more results.', 'autonova'); ?>
            </p>
            <div class="feature-cars__empty-reset"><?php esc_html_e('CLEAR FILTERS', 'autonova'); ?></div>
        </div>
        <?php return ob_get_clean();
    }

    public function ajax_filter()
    {
        check_ajax_referer('cars_inventory_nonce', 'nonce');

        $filters = [
            'car_brand' => $_POST['car_brand'] ?? '',
            'car_type' => $_POST['car_type'] ?? '',
            'car_year' => $_POST['car_year'] ?? '',
            'car_price' => $_POST['car_price'] ?? '',
        ];

        $query = new \WP_Query($this->build_query_args($filters));

        wp_send_json([
            'html' => $this->render_grid($query),
            'count' => $query->found_posts,
        ]);
    }

    public function rander_cars_inventory()
    {
        $query = new \WP_Query($this->build_query_args());

        wp_enqueue_style('autonova-featue-car');
        wp_enqueue_script(
            'autonova-cars-inventory',
            AUTONOVA_PLUGIN_URL . 'assets/js/cars-inventory.js',
            [],
            AUTONOVA_PLUGIN_VERSION,
            true
        );
        wp_localize_script('autonova-cars-inventory', 'carsInventory', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cars_inventory_nonce'),
        ]);

        global $wpdb;
        $years = $wpdb->get_col(
            "SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
            INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key = 'car_year' AND pm.meta_value != ''
            AND p.post_type = 'car' AND p.post_status = 'publish'
            ORDER BY pm.meta_value DESC"
        );
        $brands = get_terms(['taxonomy' => 'car_brand', 'hide_empty' => false]);
        $types = get_terms(['taxonomy' => 'car_type', 'hide_empty' => false]);
        $arrow = '<span class="feature-cars__arrow"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--e-global-color-primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></span>';

        ob_start(); ?>
        <div class="feature-cars__wrapper">
            <div class="feature-cars__filter">
                <div class="feature-cars__select-wrap">
                    <select class="feature-cars__select" name="car_brand">
                        <option value="">All Brands</option>
                        <?php if (!is_wp_error($brands))
                            foreach ($brands as $brand): ?>
                                <option value="<?php echo esc_attr($brand->slug); ?>"><?php echo esc_html($brand->name); ?></option>
                            <?php endforeach; ?>
                    </select>
                    <?php echo $arrow; ?>
                </div>
                <div class="feature-cars__select-wrap">
                    <select class="feature-cars__select" name="car_type">
                        <option value="">All Types</option>
                        <?php if (!is_wp_error($types))
                            foreach ($types as $type): ?>
                                <option value="<?php echo esc_attr($type->slug); ?>"><?php echo esc_html($type->name); ?></option>
                            <?php endforeach; ?>
                    </select>
                    <?php echo $arrow; ?>
                </div>
                <div class="feature-cars__select-wrap">
                    <select class="feature-cars__select" name="car_year">
                        <option value="">All Years</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo esc_attr($year); ?>"><?php echo esc_html($year); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo $arrow; ?>
                </div>
                <div class="feature-cars__select-wrap">
                    <select class="feature-cars__select" name="car_price">
                        <option value="">All Prices</option>
                        <option value="under-100k">Under $100K</option>
                        <option value="100k-150k">$100K - $150K</option>
                        <option value="150k-200k">$150K - $200K</option>
                        <option value="200k-300k">$200K - $300K</option>
                        <option value="over-300k">Over $300K</option>
                    </select>
                    <?php echo $arrow; ?>
                </div>
                <div class="feature-cars__reset" style="display:none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    <?php esc_html_e('Reset', 'autonova'); ?>
                </div>
                <div class="feature-cars__count">
                    <strong><?php echo $query->found_posts; ?></strong> <?php esc_html_e('vehicles found', 'autonova'); ?>
                </div>
            </div>
            <div class="feature-cars__grid">
                <?php echo $this->render_grid($query); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
