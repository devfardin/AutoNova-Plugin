<?php
namespace Fardin\Autonova\Widgets;

if (!defined("ABSPATH")) {
    exit;
}
use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;

class TextDivider extends Widget_Base
{

    use \Fardin\Autonova\App\Traits\Singletion;

    public function get_name(): string
    {
        return 'text_divider';
    }

    public function get_title(): string
    {
        return esc_html__('Text Divider', AUTONOVA_PLUGIN_TEXT_DOMAIN);
    }

    public function get_icon(): string
    {
        return 'eicon-e-divider';
    }

    public function get_categories(): array
    {
        return ['basic'];
    }

    public function get_keywords(): array
    {
        return ['divider', 'text-divider'];
    }

    protected function register_controls(): void
    {
        $this->content_controls_section();
        $this->style_controls_section();

    }
    protected function content_controls_section()
    {
        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__('Text Divider', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'divider_text',
            [
                'label' => esc_html__('Divider Text', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Divider Text', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'divider_layout',
            [
                'label' => esc_html__('Divider Side', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'both' => [
                        'title' => esc_html__('Both', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'both',
                'toggle' => false,
            ]
        );

        $this->add_control(
            'text_tag',
            [
                'label' => esc_html__('HTML Tag', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'span',
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'p'    => 'P',
                    'span' => 'Span',
                ],
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label' => esc_html__('Alignment', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .autonova_divider_container' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content Tab End
    }
    protected function style_controls_section()
    {
        // Text Style Tab Start
        $this->start_controls_section(
            'text_section_style',
            [
                'label' => esc_html__('Text Style', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .autonova_divider_text',
            ]
        );


        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .autonova_divider_text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // Text Style Tab End
        // Divider Style Tab Start
        $this->start_controls_section(
            'divider_section_style',
            [
                'label' => esc_html__('Divider Style', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'divider_style',
            [
                'label' => esc_html__('Style', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid'  => esc_html__('Solid', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                    'dashed' => esc_html__('Dashed', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                    'dotted' => esc_html__('Dotted', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                    'double' => esc_html__('Double', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                ],
                'selectors' => [
                    '{{WRAPPER}} .autonova_divider_line' => 'border-top-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label' => esc_html__('Divider Color', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .autonova_divider_line' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'divider_height',
            [
                'label' => esc_html__('Divider Weight', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .autonova_divider_line' => 'border-top-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'divider_width',
            [
                'label' => esc_html__('Divider Width', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '50',
                ],
                'selectors' => [
                    '{{WRAPPER}} .autonova_divider_line' => 'flex: 0 0 {{SIZE}}{{UNIT}};',
                ],
                'description' => esc_html__('Leave empty to auto-fill available space.', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            ]
        );

        $this->add_control(
            'divider_space',
            [
                'label' => esc_html__('Text Spacing', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .autonova_divider_container' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // Style Tab End
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['divider_text'])) {
            return;
        }

        ?>

        <div class="autonova_divider_container">
            <?php if ( in_array( $settings['divider_layout'], ['both', 'left'] ) ) : ?>
                <span class="autonova_divider_line"></span>
            <?php endif; ?>
            <<?php echo esc_attr($settings['text_tag']); ?> class="autonova_divider_text"><?php echo wp_kses_post($settings['divider_text']); ?></<?php echo esc_attr($settings['text_tag']); ?>>
            <?php if ( in_array( $settings['divider_layout'], ['both', 'right'] ) ) : ?>
                <span class="autonova_divider_line"></span>
            <?php endif; ?>
        </div>
        <?php
    }
}