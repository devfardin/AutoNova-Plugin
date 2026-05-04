<?php
namespace Fardin\Autonova\Frontend;
if (!defined('ABSPATH')) {
    exit;

}

class FrontendBase{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
       FrontendEnqueue::instance()->init();
       PageHero::instance();
    }
    
}