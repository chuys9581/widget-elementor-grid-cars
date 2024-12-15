<?php
/**
 * Plugin Name: Car Showcase Widget for Elementor
 * Description: A custom Elementor widget to showcase cars with images, prices and buttons
 * Version: 1.0.0
 * Author: Jesus Jimenez
 */

if (!defined('ABSPATH')) exit;

final class Car_Showcase_Widget_Elementor {
    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init() {
        // Check for required Elementor version
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Add Plugin actions
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);
    }

    public function init_widgets() {
        require_once(__DIR__ . '/widgets/car-showcase.php');
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Car_Showcase_Widget());
    }

    public function widget_styles() {
        wp_register_style('car-showcase-style', plugins_url('assets/css/car-showcase.css', __FILE__));
        wp_enqueue_style('car-showcase-style');
    }

    public function admin_notice_missing_elementor() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'car-showcase-elementor'),
            '<strong>' . esc_html__('Car Showcase Widget', 'car-showcase-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'car-showcase-elementor') . '</strong>'
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'car-showcase-elementor'),
            '<strong>' . esc_html__('Car Showcase Widget', 'car-showcase-elementor') . '</strong>',
            '<strong>' . esc_html__('PHP', 'car-showcase-elementor') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
}

Car_Showcase_Widget_Elementor::instance();