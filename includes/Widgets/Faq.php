<?php
namespace Fardin\Autonova\Widgets;

if (!defined("ABSPATH")) {
    exit;
}
use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;

class Faq extends Widget_Base
{

    use \Fardin\Autonova\App\Traits\Singletion;

    public function get_name(): string
    {
        return 'autonova_faq';
    }

    public function get_title(): string
    {
        return esc_html__('FAQ', AUTONOVA_PLUGIN_TEXT_DOMAIN);
    }

    public function get_icon(): string
    {
        return 'eicon-button';
    }

    public function get_categories(): array
    {
        return ['basic'];
    }

    public function get_keywords(): array
    {
        return ['addon', 'autonova', 'faq'];
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
                'label' => esc_html__('Faq ', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->end_controls_section();

        // Content Tab End
    }
    protected function style_controls_section()
    {
        // Style Tab Start
        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__('Button Style', AUTONOVA_PLUGIN_TEXT_DOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->end_controls_section();

        // Style Tab End
    }
    public function get_style_depends(): array {
		return [ 'autonova_faq'];
	}
    protected function render(): void
    {
        wp_enqueue_style('autonova_faq');
        $faq = get_field('faq_settings', 'option');
        if (!$faq) {
            echo '<p>' . esc_html__('Please Add FAQ Fields From Theme Options Panel', 'autonova') . '</p>';
            return;
        }
        ?>
        <div class="auto-faq-wrap">
            <?php foreach ($faq as $index => $item) : ?>
            <div class="auto-faq-item">
                <div class="auto-faq-trigger" role="button" aria-expanded="false">
                    <span><?php echo esc_html($item['faq_question']); ?></span>
                    <svg class="faq-icon-plus" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--e-global-color-primary)" stroke-width="2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <svg class="faq-icon-minus" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--e-global-color-primary)" stroke-width="2" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </div>
                <div class="auto-faq-body">
                    <p><?php echo esc_html($item['faq_answear']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <script>
        (function(){
            document.querySelectorAll('.auto-faq-trigger').forEach(function(btn){
                btn.addEventListener('click', function(){
                    var item = this.closest('.auto-faq-item');
                    var body = item.querySelector('.auto-faq-body');
                    var isOpen = item.classList.contains('is-open');
                    // close all
                    item.closest('.auto-faq-wrap').querySelectorAll('.auto-faq-item.is-open').forEach(function(el){
                        el.classList.remove('is-open');
                        el.querySelector('.auto-faq-body').style.maxHeight = '0';
                        el.querySelector('.auto-faq-trigger').setAttribute('aria-expanded','false');
                    });
                    if (!isOpen) {
                        item.classList.add('is-open');
                        body.style.maxHeight = body.scrollHeight + 'px';
                        this.setAttribute('aria-expanded','true');
                    }
                });
            });
        })();
        </script>
        <?php
    }
}