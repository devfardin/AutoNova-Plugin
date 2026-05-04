<?php
namespace Fardin\Autonova\Features;
if (!defined('ABSPATH')) {
    exit;
}

class FeaturesBase
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
        WhatsApp::instance();
    }
}

