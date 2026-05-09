<?php 
namespace Fardin\Autonova\Admin;
if(!defined('ABSPATH')){
    exit;
}
class Customize{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init(){
         add_filter('enter_title_here', [$this, 'customize_title_placeholder_masseuses'], 10, 2);
    }
     public function customize_title_placeholder_masseuses($title, $post)
    {
        if ($post->post_type == 'car') {
            $my_title = "Car Title";
            return $my_title;
        }
        return $title;
    }
}
