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
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_menu', [$this, 'menu']);
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
            <h1 style="display:none"></h1>
            <div class="autonova-card">
                <h2>
                    <span class="wa-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </span>
                    WhatsApp Settings

                    
                </h2>
                <form method="post" action="options.php">
                    <?php settings_fields('autonova_options_group'); ?>

                    <div class="autonova-field">
                        <label>WhatsApp Number</label>
                        <input type="text" name="autonova_options[whatsapp_number]"
                            value="<?php echo esc_attr($options['whatsapp_number'] ?? ''); ?>"
                            placeholder="e.g. 8801XXXXXXXXX" />
                        <p class="hint">Include country code without + or spaces.</p>
                    </div>

                    <div class="autonova-field">
                        <label>Predefined Message</label>
                        <textarea name="autonova_options[whatsapp_predefined_message]" placeholder="Hello! I'm interested in..."><?php echo esc_textarea($options['whatsapp_predefined_message'] ?? ''); ?></textarea>
                    </div>

                    <?php submit_button('Save Settings', 'primary autonova-save-btn', 'submit', false); ?>
                </form>
            </div>
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
        $message = urlencode($options['whatsapp_predefined_message'] ?? '');
        if (!$whatsapp_number) return;
        ?>
        <style>
            @keyframes wa-ping {
                75%, 100% { transform: scale(2); opacity: 0; }
            }
            @keyframes wa-pulse-ring {
                0%, 100% { opacity: 1; }
                50%       { opacity: .5; }
            }
            .wa-float {
                position: fixed;
                bottom: 32px;
                right: 32px;
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 16px;
                cursor: pointer;
                text-decoration: none;
            }
            .wa-float__label {
                white-space: nowrap;
                background: #000000e6;
                border: 1px solid #25D366;
                color: #fff;
                font-family: "Montserrat", Sans-serif;
                font-size: 12px;
                letter-spacing: .08em;
                padding: 8px 16px;
                border: 1px solid rgba(37,211,102,.3);
                opacity: 0;
                transform: translateX(16px);
                transition: opacity .3s ease, transform .3s ease;
                pointer-events: none;
            }
            .wa-float:hover .wa-float__label {
                opacity: 1;
                transform: translateX(0);
            }
            .wa-float__icon-wrap {
                position: relative;
                flex-shrink: 0;
            }
            .wa-float__ping {
                position: absolute;
                inset: 0;
                border-radius: 50%;
                background: rgba(37,211,102,.3);
                animation: wa-ping 1.4s cubic-bezier(0,0,.2,1) infinite;
            }
            .wa-float__pulse {
                position: absolute;
                inset: 0;
                border-radius: 50%;
                background: rgba(37,211,102,.2);
                animation: wa-pulse-ring 2s ease-in-out infinite;
            }
            .wa-float__btn {
                position: relative;
                width: 64px;
                height: 64px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: #25D366;
                box-shadow: 0 8px 24px rgba(37,211,102,.35);
                transition: transform .3s ease;
            }
            .wa-float:hover .wa-float__btn {
                transform: scale(1.1);
            }
        </style>
        <a class="wa-float" href="https://wa.me/<?php echo esc_attr($whatsapp_number); ?>?text=<?php echo $message; ?>" target="_blank" rel="nofollow noreferrer" aria-label="Chat on WhatsApp">
            <div class="wa-float__label">Chat with us</div>
            <div class="wa-float__icon-wrap">
                <span class="wa-float__ping"></span>
                <span class="wa-float__pulse"></span>
                <div class="wa-float__btn">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </div>
            </div>
        </a>
        <?php
    }
}

