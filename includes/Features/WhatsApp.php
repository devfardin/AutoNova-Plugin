<?php
namespace Fardin\Autonova\Features;

if (!defined('ABSPATH')) {
    exit;
}

class WhatsApp
{
    use \Fardin\Autonova\App\Traits\Singletion;

    function __construct()
    {
        add_action('wp_footer', [$this, 'sticky_whatsapp_button']);
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    function menu()
    {
        add_menu_page(
            __('Theme Options', AUTONOVA_PLUGIN_TEXT_DOMAIN),
            __('Theme Options', 'autonova'),
            'manage_options',
            'theme-options',
            [$this, 'render_admin_page'],
            'dashicons-car',
            60
        );
    }

    function render_admin_page()
    {
        $options = get_option('autonova_options', []);
        ?>
        <div class="wrap">
            <h1>WhatsApp Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('autonova_options_group'); ?>
                <table class="form-table">
                    <tr>
                        <th>WhatsApp Number</th>
                        <td><input type="text" name="autonova_options[whatsapp_number]"
                                value="<?php echo esc_attr($options['whatsapp_number'] ?? ''); ?>"
                                placeholder="e.g. 8801XXXXXXXXX" /></td>
                    </tr>
                    <tr>
                        <th>Predefined Message</th>
                        <td><input type="text" name="autonova_options[whatsapp_predefined_message]"
                                value="<?php echo esc_attr($options['whatsapp_predefined_message'] ?? ''); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    function register_settings()
    {
        register_setting('autonova_options_group', 'autonova_options');
    }

    function sticky_whatsapp_button()
    {
        $options = get_option('autonova_options');
        $whatsapp_number = $options['whatsapp_number'] ?? '';
        $message = $options['whatsapp_predefined_message'] ?? '';
        if (!$whatsapp_number)
            return;
        ?>
        <div class="whatsapp-float">
            <a href="https://wa.me/<?php echo $whatsapp_number . '?text=' . $message; ?>" target="_blank">
                WhatsApp
            </a>
        </div>
        <?php
    }
}

