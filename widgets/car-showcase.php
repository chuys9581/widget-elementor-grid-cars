<?php
class Car_Showcase_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'car_showcase';
    }

    public function get_title() {
        return __('Car Showcase', 'car-showcase-elementor');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Cars', 'car-showcase-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'car_image',
            [
                'label' => __('Car Image', 'car-showcase-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'car_name',
            [
                'label' => __('Car Name', 'car-showcase-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Car Name', 'car-showcase-elementor'),
                'placeholder' => __('Enter car name', 'car-showcase-elementor'),
            ]
        );

        $repeater->add_control(
            'car_price',
            [
                'label' => __('Car Price', 'car-showcase-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('$0', 'car-showcase-elementor'),
                'placeholder' => __('Enter car price', 'car-showcase-elementor'),
            ]
        );

        $repeater->add_control(
            'button_1_text',
            [
                'label' => __('First Button Text', 'car-showcase-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Conócelo', 'car-showcase-elementor'),
                'placeholder' => __('Enter button text', 'car-showcase-elementor'),
            ]
        );

        $repeater->add_control(
            'button_2_text',
            [
                'label' => __('Second Button Text', 'car-showcase-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Cotízalo', 'car-showcase-elementor'),
                'placeholder' => __('Enter button text', 'car-showcase-elementor'),
            ]
        );

        $repeater->add_control(
            'button_1_url',
            [
                'label' => __('First Button URL', 'car-showcase-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'car-showcase-elementor'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $repeater->add_control(
            'button_2_url',
            [
                'label' => __('Second Button URL', 'car-showcase-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'car-showcase-elementor'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'car_list',
            [
                'label' => __('Cars', 'car-showcase-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ car_name }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="car-showcase-container">
            <div class="car-showcase-grid">
                <?php foreach ($settings['car_list'] as $index => $item) : ?>
                    <div class="car-item">
                        <img src="<?php echo esc_url($item['car_image']['url']); ?>" alt="<?php echo esc_attr($item['car_name']); ?>" class="car-image">
                        <h3 class="car-name"><?php echo esc_html($item['car_name']); ?></h3>
                        <p class="car-price">Desde <?php echo esc_html($item['car_price']); ?></p>
                        <div class="car-buttons">
                            <a href="<?php echo esc_url($item['button_1_url']['url']); ?>" class="car-button" <?php echo $item['button_1_url']['is_external'] ? 'target="_blank"' : ''; ?> <?php echo $item['button_1_url']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                <?php echo esc_html($item['button_1_text']); ?>
                            </a>
                            <a href="<?php echo esc_url($item['button_2_url']['url']); ?>" class="car-button" <?php echo $item['button_2_url']['is_external'] ? 'target="_blank"' : ''; ?> <?php echo $item['button_2_url']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                <?php echo esc_html($item['button_2_text']); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}