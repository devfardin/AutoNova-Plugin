<?php

if (!defined('ABSPATH')) {
    exit;
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

                    <?php if ($status): ?>
                        <span class="feature-car__badge"><?php echo esc_html(strtoupper($status[0]->name)); ?></span>
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
                        d="M6.52367 9.16658H16.6666V10.8332H6.52367L10.9936 15.3032L9.81515 16.4817L3.33331 9.99992L9.81515 3.51807L10.9936 4.69657L6.52367 9.16658Z"/>
                </svg>
            </button>
            <img id="car-lightbox-img" src="" alt="">
            <button class="car-lightbox__arrow car-lightbox__arrow--next" id="car-lightbox-next" aria-label="Next">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path
                        d="M13.4763 9.16658L9.00631 4.69657L10.1848 3.51807L16.6666 9.99992L10.1848 16.4817L9.00631 15.3032L13.4763 10.8332H3.33331V9.16658H13.4763Z"/>
                </svg>
            </button>
            <div class="car-lightbox__counter">
                <span id="car-lightbox-current">1</span> / <span id="car-lightbox-total"><?php echo $total; ?></span>
            </div>
        </div>
    </div>

    <div class="single-car__body">

        <div class="single-car__main">
            <h1 class="single-car__title"><?php the_title(); ?></h1>

            <div class="feature-car__meta">
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

                <?php if ($fuel && !is_wp_error($fuel)): ?>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <path
                                d="M8.75 11.875H9.375V13.125H1.25V11.875H1.875V2.5C1.875 2.15482 2.15482 1.875 2.5 1.875H8.125C8.47019 1.875 8.75 2.15482 8.75 2.5V7.5H10C10.6904 7.5 11.25 8.05963 11.25 8.75V11.25C11.25 11.5952 11.5298 11.875 11.875 11.875C12.2202 11.875 12.5 11.5952 12.5 11.25V6.875H11.25C10.9048 6.875 10.625 6.59519 10.625 6.25V4.00888L9.58944 2.97335L10.4734 2.08947L13.5669 5.18306C13.689 5.3051 13.75 5.46505 13.75 5.625V11.25C13.75 12.2856 12.9106 13.125 11.875 13.125C10.8394 13.125 10 12.2856 10 11.25V8.75H8.75V11.875ZM3.125 11.875H7.5V8.125H3.125V11.875ZM3.125 3.125V6.875H7.5V3.125H3.125Z"
                                fill="#ED7D37" />
                        </svg>
                        <?php echo esc_html($fuel[0]->name); ?>
                    </span>
                <?php endif; ?>

                <?php if ($brand && !is_wp_error($brand)): ?>
                    <span><?php echo esc_html($brand[0]->name); ?></span>
                <?php endif; ?>

                <?php if ($type && !is_wp_error($type)): ?>
                    <span><?php echo esc_html($type[0]->name); ?></span>
                <?php endif; ?>
            </div>

            <div class="feature-car__divider"></div>

            <div class="single-car__description">
                <?php the_content(); ?>
            </div>
        </div>

        <div class="single-car__sidebar">
            <div class="single-car__price-box">
                <?php if ($price): ?>
                    <span class="feature-car__price"><?php echo '$' . number_format($price); ?></span>
                <?php endif; ?>

                <?php if ($whatsapp_number): ?>
                    <a href="<?php echo esc_url('https://wa.me/' . $whatsapp_number . '?text=' . $whatsapp_message); ?>"
                        target="_blank" class="autonova_whatsapp_button autonova_whatsapp_button--filled">
                        <span class="autonova_whatsapp_button_icon_wrapper">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="#fff">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                        </span>
                        <span><?php esc_html_e('Enquire on WhatsApp', AUTONOVA_PLUGIN_TEXT_DOMAIN); ?></span>
                    </a>
                <?php endif; ?>

                <a href="<?php echo esc_url(site_url('/inventory')); ?>" class="feature-car__btn">
                    <?php esc_html_e('Back to Inventory', AUTONOVA_PLUGIN_TEXT_DOMAIN); ?>
                </a>
            </div>
        </div>

    </div>
</div>

<?php get_footer();
