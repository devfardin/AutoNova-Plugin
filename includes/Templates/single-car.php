<?php

if (!defined('ABSPATH')) {
    exit;
}

if (did_action('elementor/loaded')) {
    \Elementor\Plugin::$instance->frontend->enqueue_styles();
}


get_header();

$id = get_the_ID();
$year = get_post_meta($id, 'car_year', true);
$mileage = get_post_meta($id, 'car_mileage', true);
$price = get_post_meta($id, 'car_sale_price', true);
$price = is_numeric(str_replace(['$', ',', ' ', 'USD'], '', $price))
    ? (int) str_replace(['$', ',', ' ', 'USD'], '', $price)
    : 0;
$fuel = get_the_terms($id, 'car_fuel_type');
$brand = get_the_terms($id, 'car_brand');
$type = get_the_terms($id, 'car_type');
$status = get_the_terms($id, 'car_status');

// get all images for the car

$gallery_images = get_post_meta($id, 'car_gallery', true);
$gallery_images = is_array($gallery_images) ? $gallery_images : [];
$featured_image = get_post_thumbnail_id($id);
$all_images = array_merge([$featured_image], $gallery_images);
$all_images = array_filter($all_images);

$options = get_option('autonova_options');
$whatsapp_number = $options['whatsapp_number'] ?? '';
$whatsapp_message = urlencode(get_the_title() . ' - ' . get_permalink());

// meta info
$year = get_post_meta(get_the_ID(), 'car_year', true);
$mileage = get_post_meta(get_the_ID(), 'car_mileage', true);
$fuel = get_the_terms(get_the_ID(), 'car_fuel_type');
$car_type = get_the_terms(get_the_ID(), 'car_type');
$car_status = get_the_terms(get_the_ID(), 'car_status');
$car_color = get_the_terms(get_the_ID(), 'car_color');
$price = get_post_meta(get_the_ID(), 'car_sale_price', true);
$transmission = get_post_meta(get_the_ID(), 'car_transmission', true);
$currency = get_post_meta(get_the_ID(), 'car_currency', true);
$car_desc = get_post_meta(get_the_ID(), 'car_description', true);
$price = is_numeric(str_replace(['$', ',', ' ', $currency], '', $price))
    ? (int) str_replace(['$', ',', ' ', $currency], '', $price)
    : 0;
$mileage_unit = get_post_meta(get_the_ID(), 'car_mileage_unit', true);
$fuel_economy = get_post_meta(get_the_ID(), 'car_fuel_economy', true);


$car_mata = array(
    array(
        'title' => 'Engine',
        'des' => get_post_meta(get_the_ID(), 'car_engine', true),
    ),
    array(
        'title' => 'Horsepower',
        'des' => get_post_meta(get_the_ID(), 'car_horsepower', true),
    ),
    array(
        'title' => 'Torque',
        'des' => get_post_meta(get_the_ID(), 'car_torque', true),
    ),
    array(
        'title' => 'Drivetrain',
        'des' => get_post_meta(get_the_ID(), 'car_drivetrain', true),
    ),
    array(
        'title' => '0-60 MPH',
        'des' => get_post_meta(get_the_ID(), 'car_0_60_mph', true),
    ),
    array(
        'title' => 'Top Speed',
        'des' => get_post_meta(get_the_ID(), 'car_top_speed', true),
    ),
)
    ?>
<div class="single-car">

    <!-- Breadcrumb -->
    <div class="single-car__breadcrumb">
        <div class="autonova-container">
            <span><a href="/">Home</a></span>
            <span> / </span>
            <span><a href="/inventory">Inventory</a></span>
            <span> / </span>
            <span><?php echo esc_html(get_the_title()) ?></span>
        </div>
    </div>

    <!-- Single Hero -->
    <div class="single-car__hero autonova-container">

        <?php
        $all_images_data = array_values(array_map(fn($img_id) => [
            'full' => wp_get_attachment_image_url($img_id, 'large'),
            'thumb' => wp_get_attachment_image_url($img_id, 'medium'),
            'alt' => get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: get_the_title(),
        ], $all_images));
        $total = count($all_images_data);
        ?>

        <div class="single-car__hero_left">

            <!-- Gallery -->
            <div class="car-gallery"
                data-images="<?php echo esc_attr(json_encode(array_column($all_images_data, 'full'))); ?>">

                <!-- Main Image -->
                <div class="car-gallery__main" id="car-gallery-main">
                    <?php if ($total > 0): ?>
                        <img id="car-gallery-img" src="<?php echo esc_url($all_images_data[0]['full']); ?>"
                            alt="<?php echo esc_attr($all_images_data[0]['alt']); ?>">
                    <?php endif; ?>

                    <div class="car-gallery__counter">
                        <span id="car-gallery-current">1</span> / <span><?php echo $total; ?></span>
                    </div>

                    <div class="car-gallery__zoom">
                        <div class="car-gallery__zoom-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
                                fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                <line x1="11" y1="8" x2="11" y2="14" />
                                <line x1="8" y1="11" x2="14" y2="11" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Thumbnails -->
                <?php if ($total > 1): ?>
                    <div class="car-gallery__thumbs">
                        <?php foreach ($all_images_data as $index => $img): ?>
                            <div class="car-gallery__thumb <?php echo $index === 0 ? 'is-active' : ''; ?>"
                                data-index="<?php echo $index; ?>" data-full="<?php echo esc_url($img['full']); ?>">
                                <img src="<?php echo esc_url($img['thumb']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- /Gallery -->
        </div>

        <div class="single-car__hero_right">
            <div class="single-car__hero_info_wrap">
                <div class="single-car__title_wrap">
                    <?php if ($car_status): ?>
                        <div class="single-car__badge_wrap">
                            <h4 class="single-car__badge"><?php echo esc_html(strtoupper($car_status[0]->name)); ?></h4>
                        </div>
                    <?php endif; ?>
                    <h2 class="single-car__title">
                        <?php echo the_title(); ?>
                    </h2>

                    <div class="single-car__year_color_wrap">
                        <span class="single-car__year_color">
                            <?php echo esc_html($year . ' · ' . $car_color[0]->name . ' · ' . $transmission); ?>
                        </span>
                    </div>
                </div>
                <!-- Car Price -->
                <div class="single-car__price_wrap">
                    <span class="single-car__price">
                        <?php echo $price ? '$' . number_format($price) : __('Call for price', AUTONOVA_PLUGIN_TEXT_DOMAIN); ?>
                    </span>
                    <span class="single-car__carrency">
                        <?php echo esc_html($currency); ?>
                    </span>
                </div>
                <!-- Performance & Engine -->
                <div class="single-car__meta_grid">
                    <?php foreach ($car_mata as $meta): ?>
                        <div class="single-car__meta_card">
                            <span class="meta_title">
                                <?php echo $meta['title'] ?>
                            </span>
                            <span class="meta_des">
                                <?php echo $meta['des'] ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Card Description -->
                <div class="single-car__desc">
                    <p>
                        <?php echo esc_html($car_desc); ?>
                    </p>
                </div>
                <div class="single-car__buttons">
                    <a class="single-car__query_btn btn" href="<?php site_url('contact') ?>">
                        INQUIRE NOW
                    </a>
                    <a class="single-car__whatsapp"
                        href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp_number; ?>&text=<?php echo $whatsapp_message; ?>"
                        class="btn btn--whatsapp" target="_blank">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#25D366">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        CHAT ON WHATSAPP
                    </a>
                </div>
                <div class="single-car__meta_flex">
                    <div class="single-car__meta_flex_card">
                        <?php if ($mileage): ?>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"
                                    fill="none">
                                    <path
                                        d="M7.5 8.33337L1.73584 12.1761C1.59224 12.2719 1.39822 12.2331 1.30248 12.0895C1.26826 12.0381 1.25 11.9778 1.25 11.9161V3.08395C1.25 2.91136 1.38991 2.77145 1.5625 2.77145C1.62419 2.77145 1.68451 2.78972 1.73584 2.82394L7.5 6.66669V3.08395C7.5 2.91136 7.63994 2.77145 7.8125 2.77145C7.87419 2.77145 7.9345 2.78972 7.98588 2.82394L14.61 7.24C14.7536 7.33575 14.7924 7.52981 14.6966 7.67337C14.6738 7.70769 14.6443 7.73718 14.61 7.76006L7.98588 12.1761C7.84225 12.2719 7.64825 12.2331 7.5525 12.0895C7.51825 12.0381 7.5 11.9778 7.5 11.9161V8.33337ZM6.4965 7.50006L2.5 4.83569V10.1644L6.4965 7.50006ZM8.75 4.83569V10.1644L12.7465 7.50006L8.75 4.83569Z"
                                        fill="#ED7D37" />
                                </svg>
                                <?php echo esc_html($mileage); ?>     <?php echo $mileage_unit ?></span>
                        <?php endif; ?>
                    </div>
                    <span class="dot_divider"></span>
                    <div class="single-car__meta_flex_card">
                        <?php if ($fuel): ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path
                                    d="M8.75 11.875H9.375V13.125H1.25V11.875H1.875V2.5C1.875 2.15482 2.15482 1.875 2.5 1.875H8.125C8.47019 1.875 8.75 2.15482 8.75 2.5V7.5H10C10.6904 7.5 11.25 8.05963 11.25 8.75V11.25C11.25 11.5952 11.5298 11.875 11.875 11.875C12.2202 11.875 12.5 11.5952 12.5 11.25V6.875H11.25C10.9048 6.875 10.625 6.59519 10.625 6.25V4.00888L9.58944 2.97335L10.4734 2.08947L13.5669 5.18306C13.689 5.3051 13.75 5.46505 13.75 5.625V11.25C13.75 12.2856 12.9106 13.125 11.875 13.125C10.8394 13.125 10 12.2856 10 11.25V8.75H8.75V11.875ZM3.125 11.875H7.5V8.125H3.125V11.875ZM3.125 3.125V6.875H7.5V3.125H3.125Z"
                                    fill="#ED7D37" />
                            </svg>
                            <?php echo esc_html($fuel[0]->name); ?>
                        <?php endif; ?>
                    </div>
                    <span class="dot_divider"></span>
                    <div class="single-car__meta_flex_card">
                        <?php if ($fuel_economy): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path
                                    d="M5.66898 4.375L3.75 7.2535V12.5H11.25V4.375H5.66898ZM5 3.125H11.875C12.2202 3.125 12.5 3.40482 12.5 3.75V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V6.875L5 3.125ZM8.125 0.625H11.25C11.5952 0.625 11.875 0.904825 11.875 1.25V2.5H7.5V1.25C7.5 0.904825 7.77981 0.625 8.125 0.625ZM5 7.5H6.25V11.25H5V7.5Z"
                                    fill="#ED7D37" />
                            </svg>
                            <?php echo esc_html($fuel_economy); ?>
                        <?php endif; ?>
                    </div>
                    <span class="dot_divider"></span>
                    <div class="single-car__meta_flex_card">
                        <?php if ($car_type): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path
                                    d="M4.89331 12.5C4.63591 13.2282 3.94139 13.75 3.125 13.75C2.08947 13.75 1.25 12.9106 1.25 11.875C1.25 11.0586 1.77176 10.3641 2.5 10.1067V4.89331C1.77176 4.63591 1.25 3.94139 1.25 3.125C1.25 2.08947 2.08947 1.25 3.125 1.25C3.94139 1.25 4.63591 1.77176 4.89331 2.5H10.1067C10.3641 1.77176 11.0586 1.25 11.875 1.25C12.9106 1.25 13.75 2.08947 13.75 3.125C13.75 3.94139 13.2282 4.63591 12.5 4.89331V10.1067C13.2282 10.3641 13.75 11.0586 13.75 11.875C13.75 12.9106 12.9106 13.75 11.875 13.75C11.0586 13.75 10.3641 13.2282 10.1067 12.5H4.89331ZM4.89331 11.25H10.1067C10.295 10.7172 10.7172 10.295 11.25 10.1067V4.89331C10.7172 4.70501 10.295 4.28276 10.1067 3.75H4.89331C4.70501 4.28276 4.28276 4.70501 3.75 4.89331V10.1067C4.28276 10.295 4.70501 10.7172 4.89331 11.25ZM3.125 3.75C3.47018 3.75 3.75 3.47018 3.75 3.125C3.75 2.77982 3.47018 2.5 3.125 2.5C2.77982 2.5 2.5 2.77982 2.5 3.125C2.5 3.47018 2.77982 3.75 3.125 3.75ZM11.875 3.75C12.2202 3.75 12.5 3.47018 12.5 3.125C12.5 2.77982 12.2202 2.5 11.875 2.5C11.5298 2.5 11.25 2.77982 11.25 3.125C11.25 3.47018 11.5298 3.75 11.875 3.75ZM11.875 12.5C12.2202 12.5 12.5 12.2202 12.5 11.875C12.5 11.5298 12.2202 11.25 11.875 11.25C11.5298 11.25 11.25 11.5298 11.25 11.875C11.25 12.2202 11.5298 12.5 11.875 12.5ZM3.125 12.5C3.47018 12.5 3.75 12.2202 3.75 11.875C3.75 11.5298 3.47018 11.25 3.125 11.25C2.77982 11.25 2.5 11.5298 2.5 11.875C2.5 12.2202 2.77982 12.5 3.125 12.5Z"
                                    fill="#ED7D37" />
                            </svg>
                            <?php echo esc_html($car_type[0]->name); ?>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- Lightbox -->
    <div class="car-lightbox" id="car-lightbox" aria-hidden="true">
        <div class="car-lightbox__overlay" id="car-lightbox-overlay"></div>
        <div class="car-lightbox__wrap">
            <button class="car-lightbox__close" id="car-lightbox-close" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path
                        d="M9.99977 8.82208L14.1246 4.69727L15.3031 5.87577L11.1783 10.0006L15.3031 14.1253L14.1246 15.3038L9.99977 11.1791L5.87499 15.3038L4.69647 14.1253L8.82127 10.0006L4.69647 5.87577L5.87499 4.69727L9.99977 8.82208Z" />
                </svg>
            </button>
            <button class="car-lightbox__arrow car-lightbox__arrow--prev" id="car-lightbox-prev" aria-label="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path
                        d="M6.52367 9.16658H16.6666V10.8332H6.52367L10.9936 15.3032L9.81515 16.4817L3.33331 9.99992L9.81515 3.51807L10.9936 4.69657L6.52367 9.16658Z" />
                </svg>
            </button>
            <img id="car-lightbox-img" src="" alt="">
            <button class="car-lightbox__arrow car-lightbox__arrow--next" id="car-lightbox-next" aria-label="Next">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path
                        d="M13.4763 9.16658L9.00631 4.69657L10.1848 3.51807L16.6666 9.99992L10.1848 16.4817L9.00631 15.3032L13.4763 10.8332H3.33331V9.16658H13.4763Z" />
                </svg>
            </button>
            <div class="car-lightbox__counter">
                <span id="car-lightbox-current">1</span> / <span id="car-lightbox-total"><?php echo $total; ?></span>
            </div>
        </div>
    </div>


</div>

<?php get_footer();
