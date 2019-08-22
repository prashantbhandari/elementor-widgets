<?php
namespace ElementorWidgets\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class TestimonialWidget extends Widget_Base {
 
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
    return 'testimonial_widget';
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
    return __( 'Testimonial', 'elementor-widgets' );
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
    return 'fa fa-quote-left';
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
    <div class="container">
        <div class="section testimonial-block col-lg-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 ">
                    <div class="block">
                        <div class="owl-carousel owl-theme testimonial-type-one">

                            <?php
                                    $args = array(
                                        'post_type' => 'testimonial',
                                    );
                                    // the query
                                    $the_query = new \WP_Query($args); ?>
                            <?php if ($the_query->have_posts()) : ?>

                            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

                            <!-- start testimonial single item -->
                            <div class="item type-one d-flex align-items-center flex-column">
                                <div class="textimonial-image">
                                    <i class="icon-testimonial"></i>
                                </div>
                                <div class="desc-testimonial">
                                    <div class="testimonial-content">
                                        <div class="text">
                                            <p><?php the_excerpt(); ?></p>
                                        </div>
                                    </div>
                                    <div class="testimonial-info">
                                        <h5 class="mt-0 box-info"><?php the_title() ?></h5>
                                        <p class="box-dress"><?php the_field('sub_title') ?></p>
                                    </div>
                                </div>
                            </div>

                            <?php endwhile; ?>

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
    <div class="container">
        <div class="section testimonial-block col-lg-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 ">
                    <div class="block">
                        <div class="owl-carousel owl-theme testimonial-type-one">

                            <?php
                                    $args = array(
                                        'post_type' => 'testimonial',
                                    );
                                    // the query
                                    $the_query = new \WP_Query($args); ?>
                            <?php if ($the_query->have_posts()) : ?>

                            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

                            <!-- start testimonial single item -->
                            <div class="item type-one d-flex align-items-center flex-column">
                                <div class="textimonial-image">
                                    <i class="icon-testimonial"></i>
                                </div>
                                <div class="desc-testimonial">
                                    <div class="testimonial-content">
                                        <div class="text">
                                            <p><?php the_excerpt(); ?></p>
                                        </div>
                                    </div>
                                    <div class="testimonial-info">
                                        <h5 class="mt-0 box-info"><?php the_title() ?></h5>
                                        <p class="box-dress"><?php the_field('sub_title') ?></p>
                                    </div>
                                </div>
                            </div>

                            <?php endwhile; ?>

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