<?php
namespace Fardin\Autonova\Templates;
if (!defined('ABSPATH')) {
    exit;
}

class LightBox
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function lightbox($total)
    {
        ?>
        <div class="car-lightbox" id="car-lightbox" aria-hidden="true">
            <div class="car-lightbox__overlay" id="car-lightbox-overlay"></div>
            <div class="car-lightbox__wrap">
                <button class="car-lightbox__close" id="car-lightbox-close" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M9.99977 8.82208L14.1246 4.69727L15.3031 5.87577L11.1783 10.0006L15.3031 14.1253L14.1246 15.3038L9.99977 11.1791L5.87499 15.3038L4.69647 14.1253L8.82127 10.0006L4.69647 5.87577L5.87499 4.69727L9.99977 8.82208Z" />
                    </svg>
                </button>
                <button class="car-lightbox__arrow car-lightbox__arrow--prev" id="car-lightbox-prev" aria-label="Previous">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M6.52367 9.16658H16.6666V10.8332H6.52367L10.9936 15.3032L9.81515 16.4817L3.33331 9.99992L9.81515 3.51807L10.9936 4.69657L6.52367 9.16658Z" />
                    </svg>
                </button>
                <img id="car-lightbox-img" src="" alt="">
                <button class="car-lightbox__arrow car-lightbox__arrow--next" id="car-lightbox-next" aria-label="Next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M13.4763 9.16658L9.00631 4.69657L10.1848 3.51807L16.6666 9.99992L10.1848 16.4817L9.00631 15.3032L13.4763 10.8332H3.33331V9.16658H13.4763Z" />
                    </svg>
                </button>
                <div class="car-lightbox__counter">
                    <span id="car-lightbox-current">1</span> / <span id="car-lightbox-total"><?php echo $total; ?></span>
                </div>
            </div>
        </div>
        <?php
    }



}
