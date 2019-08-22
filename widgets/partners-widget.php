<?php
namespace ElementorWidgets\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PartnersWidget extends Widget_Base {
 
  /**
   * Retrieve the widget name.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'partners_widget';
  }
 
  /**
   * Retrieve the widget title.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __( 'Partners Widget', 'elementor-widgets' );
  }
 
  /**
   * Retrieve the widget icon.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'fa fa-handshake';
  }
 
  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * Used to determine where to display the widget in the editor.
   *
   * Note that currently Elementor supports only one category.
   * When multiple categories passed, Elementor uses the first one.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return array Widget categories.
   */
  public function get_categories() {
    return [ 'basic' ];
  }
 
  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function _register_controls() {
    $this->start_controls_section(
      'section_content',
      [
        'label' => __( 'Content', 'elementor-widgets' ),
      ]
    );
 
    $this->end_controls_section();
  }
 
  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function render() {
    ?>
    <!-- partner -->
    <div class="container">
        <div class="section introduct-logo">
            <div class="row">
                <div class="tiva-manufacture  col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <div class="block">
                        <div id="manufacture" class="owl-carousel owl-theme owl-loaded owl-drag">

                            <?php
                        $args = array(
                            'post_type' => 'brand',
                        );
                        // the query
                        $the_query = new \WP_Query($args); ?>
                            <?php if ($the_query->have_posts()) : ?>

                            <?php
                            while ($the_query->have_posts()) : $the_query->the_post();
                                if(has_post_thumbnail()){
                                ?>
                            <div class="item">
                                <div class="logo-manu">
                                    <?php the_post_thumbnail('full', array('class' => 'img-fluid')) ?>
                                </div>
                            </div>
                            <?php } endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
  }
 
  /**
   * Render the widget output in the editor.
   *
   * Written as a Backbone JavaScript template and used to generate the live preview.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function _content_template() {
    ?>
    <!-- partner -->
    <div class="container">
        <div class="section introduct-logo">
            <div class="row">
                <div class="tiva-manufacture  col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <div class="block">
                        <div id="manufacture" class="owl-carousel owl-theme owl-loaded owl-drag">

                            <?php
                        $args = array(
                            'post_type' => 'brand',
                        );
                        // the query
                        $the_query = new \WP_Query($args); ?>
                            <?php if ($the_query->have_posts()) : ?>

                            <?php
                            while ($the_query->have_posts()) : $the_query->the_post();
                                if(has_post_thumbnail()){
                                ?>
                            <div class="item">
                                <div class="logo-manu">
                                    <?php the_post_thumbnail('full', array('class' => 'img-fluid')) ?>
                                </div>
                            </div>
                            <?php } endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
  }
}