<?php
namespace Fardin\Autonova\Widgets;

if (!defined("ABSPATH")) {
	exit;
}
use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;

class WhatsappBtn extends Widget_Base
{

	use \Fardin\Autonova\App\Traits\Singletion;

	public function get_name(): string
	{
		return 'autonova_whatsapp';
	}

	public function get_title(): string
	{
		return esc_html__('Whats Btn', AUTONOVA_PLUGIN_TEXT_DOMAIN);
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
		return ['addon', 'autonova', 'whatsapp-button', 'whatsapp'];
	}

	protected function register_controls(): void
	{
		$this->content_controls_section();
		$this->style_controls_section();
		wp_enqueue_style('autonova_whatsapp');

	}
	protected function content_controls_section()
	{
		// Content Tab Start

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__('Whatsapp Button ', AUTONOVA_PLUGIN_TEXT_DOMAIN),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__('Text', AUTONOVA_PLUGIN_TEXT_DOMAIN),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Click me', AUTONOVA_PLUGIN_TEXT_DOMAIN),
				'dynamic' => [
					'active' => true,
				],
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
		return [ 'autonova_whatsapp'];
	}
	protected function render(): void
	{
		$settings = $this->get_settings_for_display();

		if (empty($settings['button_text'])) {
			return;
		}
		$options = get_option('autonova_options');
        $whatsapp_number = $options['whatsapp_number'] ?? '';
        $message = urlencode($options['whatsapp_predefined_message'] ?? '');

		?>
		<div class="autonova_whatsapp_button_container">
			<a href="https://wa.me/<?php echo esc_attr($whatsapp_number); ?>?text=<?php echo $message; ?>" target="_blank" class="autonova_whatsapp_button">
				
					<span class="autonova_whatsapp_button_icon_wrapper">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="#fff">
							<path
								d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
						</svg>
					</span>
					<span>
						<?php echo $settings['button_text']; ?>
					</span>
			</a>
		</div>
		<?php
	}
}