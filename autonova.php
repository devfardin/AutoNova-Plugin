<?php
/**
 * Plugin Name: Autonova
 * Description: AutoNova Core is a lightweight companion plugin that adds essential features like car inventory management, custom fields, and dynamic content—making it easy to manage and update your automotive website. 
 * Plugin URI: https://github.com/devfardin
 * Version: 1.0.0
 * Author: Fardin Ahmed
 * Author URI: https://github.com/devfardin
 * Text Domain: autonova
 * Requires Plugins: autonova
 */

namespace Fardin\Autonova;

if (!defined("ABSPATH")) {
    exit;
}

if (! class_exists(Autonova::class) && is_readable(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
class_exists(Autonova::class) && Autonova::instance()->init();