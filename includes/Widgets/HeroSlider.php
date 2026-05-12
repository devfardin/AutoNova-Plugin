<?php
namespace Fardin\Autonova\Widgets;

if (!defined("ABSPATH")) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\Repeater;
use \Elementor\Icons_Manager;

class HeroSlider extends Widget_Base
{
    use \Fardin\Autonova\App\Traits\Singletion;

    public function get_name(): string
    {
        return 'hero_slider';
    }

    public function get_title(): string
    {
        return esc_html__('Hero Slider', AUTONOVA_PLUGIN_TEXT_DOMAIN);
    }

    public function get_icon(): string
    {
        return 'eicon-slider-full-screen';
    }

    public function get_categories(): array
    {
        return ['basic'];
    }

    public function get_keywords(): array
    {
        return ['hero', 'slider', 'banner', 'autonova'];
    }

    protected function register_controls(): void
    {
        // ── Slides Repeater ──────────────────────────────────────────────
        $this->start_controls_section('section_slides', [
            'label' => esc_html__('Slides', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new Repeater();

        $repeater->add_control('slide_image', [
            'label' => esc_html__('Background Image', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::MEDIA,
            'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
        ]);

        $repeater->add_control('slide_badge', [
            'label' => esc_html__('Badge Text', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Premium Automotive Solutions', AUTONOVA_PLUGIN_TEXT_DOMAIN),
        ]);

        $repeater->add_control('slide_heading', [
            'label' => esc_html__('Heading', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::TEXTAREA,
            'default' => "REDEFINE YOUR\n<span>DRIVING</span>\nEXPERIENCE",
            'rows' => 3,
        ]);

        $repeater->add_control('slide_description', [
            'label' => esc_html__('Description', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('Curated luxury vehicles and bespoke automotive services. Your journey to automotive excellence starts here.', AUTONOVA_PLUGIN_TEXT_DOMAIN),
        ]);

        $repeater->add_control('btn_primary_text', [
            'label' => esc_html__('Primary Button Text', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('EXPLORE INVENTORY', AUTONOVA_PLUGIN_TEXT_DOMAIN),
        ]);

        $repeater->add_control('btn_primary_url', [
            'label' => esc_html__('Primary Button URL', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
            'label_block' => true,
        ]);

        $repeater->add_control('btn_secondary_text', [
            'label' => esc_html__('Secondary Button Text', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('REQUEST INFORMATION', AUTONOVA_PLUGIN_TEXT_DOMAIN),
        ]);

        $repeater->add_control('btn_secondary_url', [
            'label' => esc_html__('Secondary Button URL', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
            'label_block' => true,
        ]);

        $this->add_control('slides', [
            'label' => esc_html__('Slides', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'slide_badge' => 'Premium Automotive Solutions',
                    'slide_heading' => "REDEFINE YOUR\n<span>DRIVING</span>\nEXPERIENCE",
                    'slide_description' => 'Curated luxury vehicles and bespoke automotive services.',
                    'btn_primary_text' => 'EXPLORE INVENTORY',
                    'btn_secondary_text' => 'REQUEST INFORMATION',
                ],
            ],
            'title_field' => '{{{ slide_badge }}}',
        ]);

        $this->end_controls_section();

        // ── Stats ────────────────────────────────────────────────────────
        $this->start_controls_section('section_stats', [
            'label' => esc_html__('Stats', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $stats_repeater = new Repeater();

        $stats_repeater->add_control('stat_icon', [
            'label'   => esc_html__('Icon', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type'    => Controls_Manager::ICONS,
            'default' => [
                'value'   => 'fas fa-car',
                'library' => 'fa-solid',
            ],
        ]);

        $stats_repeater->add_control('stat_number', [
            'label' => esc_html__('Number', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => '50+',
        ]);

        $stats_repeater->add_control('stat_label', [
            'label' => esc_html__('Label', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => 'VEHICLES IN STOCK',
        ]);

        $this->add_control('stats', [
            'label' => esc_html__('Stats', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::REPEATER,
            'fields' => $stats_repeater->get_controls(),
            'default' => [
                ['stat_icon' => ['value' => 'fas fa-car',       'library' => 'fa-solid'], 'stat_number' => '50+',  'stat_label' => 'VEHICLES IN STOCK'],
                ['stat_icon' => ['value' => 'fas fa-users',      'library' => 'fa-solid'], 'stat_number' => '500+', 'stat_label' => 'SATISFIED CLIENTS'],
                ['stat_icon' => ['value' => 'fas fa-award',      'library' => 'fa-solid'], 'stat_number' => '15+',  'stat_label' => 'YEARS EXPERIENCE'],
            ],
            'title_field' => '{{{ stat_label }}}',
        ]);

        $this->end_controls_section();

        // ── Slider Settings ──────────────────────────────────────────────
        $this->start_controls_section('section_settings', [
            'label' => esc_html__('Slider Settings', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('autoplay_speed', [
            'label' => esc_html__('Autoplay Speed (ms)', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            'type' => Controls_Manager::NUMBER,
            'default' => 5000,
            'min' => 2000,
            'max' => 15000,
            'step' => 500,
        ]);

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        $slides = $settings['slides'] ?? [];
        $stats = $settings['stats'] ?? [];
        $speed = (int) ($settings['autoplay_speed'] ?? 5000);

        if (empty($slides))
            return;
        ?>
        <section class="hs-hero" data-speed="<?php echo esc_attr($speed); ?>">

            <?php foreach ($slides as $index => $slide):
                $img = $slide['slide_image']['url'] ?? '';
                $active = $index === 0 ? ' hs-slide--active' : '';
                ?>
                <div class="hs-slide<?php echo $active; ?>">
                    <div class="hs-slide__bg" style="background-image:url('<?php echo esc_url($img); ?>')"></div>
                </div>
            <?php endforeach; ?>

            <!-- Overlays -->
            <div class="hs-overlay hs-overlay--lr"></div>
            <div class="hs-overlay hs-overlay--tb"></div>
            <div class="hs-overlay hs-overlay--grid"></div>

            <!-- Content + Stats inside container -->
            <div class="hs-content-wrap autonova-container">
                <div class="hs-inner">
                    <!-- Slide content -->
                    <div class="hs-content-col">
                        <?php foreach ($slides as $index => $slide):
                            $active = $index === 0 ? ' hs-content--active' : '';
                            $heading = nl2br(wp_kses($slide['slide_heading'], ['span' => [], 'br' => []]));
                            ?>
                            <div class="hs-content<?php echo $active; ?>">
                                <div class="hs-badge">
                                    <span class="hs-badge__line"></span>
                                    <span class="hs-badge__text"><?php echo esc_html($slide['slide_badge']); ?></span>
                                </div>
                                <h1 class="hs-heading"><?php echo $heading; ?></h1>
                                <p class="hs-desc"><?php echo esc_html($slide['slide_description']); ?></p>
                                <div class="hs-buttons">
                                    <?php if (!empty($slide['btn_primary_text'])): ?>
                                        <a href="<?php echo esc_url($slide['btn_primary_url']['url'] ?? '#'); ?>"
                                            class="hs-btn hs-btn--primary">
                                            <?php echo esc_html($slide['btn_primary_text']); ?>
                                            <i class="ri-arrow-right-line"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($slide['btn_secondary_text'])): ?>
                                        <a href="<?php echo esc_url($slide['btn_secondary_url']['url'] ?? '#'); ?>"
                                            class="hs-btn hs-btn--secondary">
                                            <?php echo esc_html($slide['btn_secondary_text']); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Stats -->
                    <?php if (!empty($stats)): ?>
                        <div class="hs-stats">
                            <?php foreach ($stats as $stat): ?>
                                <div class="hs-stat">
                                    <div class="hs-stat__icon">
                                        <?php \Elementor\Icons_Manager::render_icon($stat['stat_icon'], ['aria-hidden' => 'true']); ?>
                                    </div>
                                    <div>
                                        <div class="hs-stat__number"><?php echo esc_html($stat['stat_number']); ?></div>
                                        <div class="hs-stat__label"><?php echo esc_html($stat['stat_label']); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Arrows -->
            <?php if (count($slides) > 1): ?>
                <button class="hs-arrow hs-arrow--prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        class="__web-inspector-hide-shortcut__">
                        <path
                            d="M6.52367 9.16658H16.6666V10.8332H6.52367L10.9936 15.3032L9.81515 16.4817L3.33331 9.99992L9.81515 3.51807L10.9936 4.69657L6.52367 9.16658Z"
                            fill="white" />
                    </svg>
                </button>
                <button class="hs-arrow hs-arrow--next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        class="__web-inspector-hide-shortcut__">
                        <path
                            d="M13.4763 9.16658L9.00631 4.69657L10.1848 3.51807L16.6666 9.99992L10.1848 16.4817L9.00631 15.3032L13.4763 10.8332H3.33331V9.16658H13.4763Z"
                            fill="white" />
                    </svg>
                </button>
            <?php endif; ?>

            <!-- Dots -->
            <?php if (count($slides) > 1): ?>
                <div class="hs-dots">
                    <?php foreach ($slides as $index => $slide): ?>
                        <button class="hs-dot<?php echo $index === 0 ? ' hs-dot--active' : ''; ?>"
                            data-index="<?php echo $index; ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Scroll indicator -->
            <div class="hs-scroll">
                <span class="hs-scroll__label">SCROLL</span>
                <div class="hs-scroll__line"></div>
            </div>

        </section>
        <?php
    }
}
