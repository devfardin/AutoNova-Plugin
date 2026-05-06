<?php
namespace Fardin\Autonova\Shortcodes;


if (!defined('ABSPATH')) {
    exit;
}

class ShortcodesBase
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init(){
        $this->load_dep();

    }
    public function load_dep(){
       TeamMember::instance()->init();
    }
}