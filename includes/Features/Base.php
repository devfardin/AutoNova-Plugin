<?php
namespace Fardin\Autonova\Features;



if (!defined('ABSPATH')) {
    exit;
}

class Base
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
        WhatsApp::instance();
    }
}

