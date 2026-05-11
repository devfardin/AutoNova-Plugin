<?php 
namespace Fardin\Autonova\Templates;
if(!defined('ABSPATH')){
    exit;
}

class Footer{
     use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
        // add_action('wp_footer', 'my_start_footer_ob', 1);
        // add_action('wp_footer', 'my_end_footer_ob', 1000);
    }

    function my_start_footer_ob() {
    ob_start("my_end_footer_ob_callback");
}

// add_action('wp_footer', 'my_end_footer_ob', 1000);
function my_end_footer_ob() {
    ob_end_flush();
}

function my_end_footer_ob_callback($buffer) {
    // remove what you need from he buffer

    return $buffer;
}
    
}