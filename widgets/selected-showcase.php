<?php
namespace ElementorWidgets\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class SelectedShowcase extends Widget_Base {
 
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
    return 'selected_showcase';
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
    return __( 'Selected Showcase', 'elementor-widgets' );
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
    return 'fa fa-check';
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
 
    $this->add_control(
      'title',
      [
        'label' => __( 'Title', 'elementor-widgets' ),
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Title', 'elementor-widgets' ),
      ]
    );

    $this->add_control(
        'sub_title',
        [
            'label' => __( 'Sub Title', 'elementor-widgets' ),
            'type' => Controls_Manager::TEXT,
            'default' => __( 'Sub Title', 'elementor-widgets' ),
        ]
    );

    $this->add_control(
        'intro',
        [
            'label' => __( 'Intro', 'elementor-widgets' ),
            'type' => Controls_Manager::TEXT,
            'default' => __( 'This is the section intro', 'elementor-widgets' ),
        ]
    );

    $this->add_control(
        'select_categories',
        [
            'label' => __( 'Select Categories', 'elementor-widgets' ),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $this->hierarchical_category_tree(0, 0, array()),
            'default' => [ 'title', 'description' ],
        ]
    );

    $this->add_control(
      'select_taxonomy',
      [
          'label' => __( 'Select Taxonomy', 'elementor-widgets' ),
          'type' => Controls_Manager::SELECT2,
          'multiple' => true,
          'options' => $this->get_product_tags(),
          'default' => [ 'title', 'description' ],
      ]
    );

    $this->add_control(
      'section_url',
      [
        'label' => __( 'Section URL', 'elementor-widgets' ),
        'type' => Controls_Manager::URL,
        'placeholder' => __( 'https://your-link.com', 'elementor-widgets' ),
        'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
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
    $settings = $this->get_settings_for_display(); 
    $this->add_inline_editing_attributes( 'title', 'none' );

    $target = $settings['section_url']['is_external'] ? ' target="_blank"' : '';
    $nofollow = $settings['section_url']['nofollow'] ? ' rel="nofollow"' : '';
    $product_cat = $settings['select_categories'];
    $product_tags = $settings['select_taxonomy'];
    $section_title = $settings['title'];
    $section_sub_title = $settings['sub_title'];;
    $section_intro = $settings['intro'];
    $section_link = $settings['section_url']['url'];;
    ?>
    <div class="container">
      <!-- banner -->
      <!-- best seller -->
      <div class="section best-sellers col-lg-12 col-xs-12">
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="groupproductlist">
              <div class="row d-flex align-items-center">
                <!-- column 4 -->
                <div class="flex-4 col-lg-4 flex-4">
                  <h2 class="title-block">
                    <span class="sub-title"><?php echo $section_sub_title ?></span><?php echo $section_title ?>
                  </h2>
                  <div class="content-text">
                    <p><?php echo $section_intro ?></p>
                    <div>
                      <a href="<?php echo $section_link; ?>" <?php $target;?> <?php $nofollow;?>> View all product </a>
                    </div>
                  </div>
                </div>

                <!-- column 8 -->
                <div class="block-content col-lg-8 flex-8">
                  <div class="tab-content">
                    <div class="tab-pane fade in active show">
                      <div class="category-product-index owl-carousel owl-theme owl-loaded owl-drag">
                        <div class="item text-center">
                          <?php
                                $taxQuery = array();
                                if($product_cat) {
                                    $taxQuery = array(
                                        'taxonomy' => 'product_cat',
                                        'terms' => $product_cat
                                    );
                                }
                                if($product_tags) {
                                    $taxQuery = array(
                                        'taxonomy' => 'product_tag',
                                        'terms' => $product_tags
                                    );
                                }
                                if ($product_cat && $product_tags) {
                                    $taxQuery = array(
                                        'relation' => 'AND',
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'terms' => $product_cat,
                                        ),
                                        array(
                                            'taxonomy' => 'product_tag',
                                            'terms' => $product_tags
                                        )
                                    );
                                }
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 12,
                                    'tax_query' => array($taxQuery)
                                );
                                $post_loop = new \WP_Query($args);
                                $i = 0;
                                while ($post_loop->have_posts()) :
                                $post_loop->the_post(); ?>
                          <?php if ($i % 2 === 0 && $i > 0): ?>
                        </div>
                        <div class="item text-center">
                          <?php endif; ?>
                          <div class="product-miniature js-product-miniature item-one first-item">
                            <div class="thumbnail-container">
                              <?php woocommerce_show_product_loop_sale_flash(); ?>
                              <a
                                href="<?php the_permalink(); ?>"><?php woocommerce_template_loop_product_thumbnail(); ?></a>
                            </div>
                            <div class="product-description">
                              <div class="product-groups">
                                <div class="product-title">
                                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php $i++; ?>
                          <?php endwhile; ?>
                        </div>
                        <?php wp_reset_query(); ?>
                      </div>
                    </div>
                  </div>
                </div>
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
      <# 
      view.addInlineEditingAttributes( 'title' , 'none' ); 
      var target=settings.section_url.is_external ? ' target="_blank"': '' ; 
      var nofollow=settings.section_url.nofollow ? ' rel="nofollow"' : '' ; 
      #>
      <?php

      $product_cat = "{{{ settings.select_categories }}}";
      $product_tags = "{{{ settings.select_taxonomy }}}";
      $section_title = "{{{ settings.title }}}";
      $section_sub_title = "{{{ settings.sub_title }}}";
      $section_intro = "{{{ settings.intro }}}";
      $section_link = "{{{settings.section_url.url}}}";
      ?>
      <div class="container">
        <!-- banner -->
        <!-- best seller -->
        <div class="section best-sellers col-lg-12 col-xs-12">
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="groupproductlist">
                <div class="row d-flex align-items-center">
                  <!-- column 4 -->
                  <div class="flex-4 col-lg-4 flex-4">
                    <h2 class="title-block">
                      <span class="sub-title"><?php echo $section_sub_title ?></span><?php echo $section_title ?>
                    </h2>
                    <div class="content-text">
                      <p><?php echo $section_intro ?></p>
                      <div>
                        <a href="<?php echo $section_link; ?>" {{target}} {{nofollow}}> View all product </a>
                      </div>
                    </div>
                  </div>

                  <!-- column 8 -->
                  <div class="block-content col-lg-8 flex-8">
                    <div class="tab-content">
                      <div class="tab-pane fade in active show">
                        <div class="category-product-index owl-carousel owl-theme owl-loaded owl-drag">
                          <div class="item text-center">
                            <?php
                            $taxQuery = array();
                            if($product_cat) {
                                $taxQuery = array(
                                    'taxonomy' => 'product_cat',
                                    'terms' => $product_cat
                                );
                            }
                            if($product_tags) {
                                $taxQuery = array(
                                    'taxonomy' => 'product_tag',
                                    'terms' => $product_tags
                                );
                            }
                            if ($product_cat && $product_tags) {
                                $taxQuery = array(
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'terms' => $product_cat,
                                    ),
                                    array(
                                        'taxonomy' => 'product_tag',
                                        'terms' => $product_tags
                                    )
                                );
                            }
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => 12,
                                'tax_query' => array($taxQuery)
                            );
                            $post_loop = new \WP_Query($args);
                            $i = 0;
                            while ($post_loop->have_posts()) :
                            $post_loop->the_post(); ?>
                            <?php if ($i % 2 === 0 && $i > 0): ?>
                          </div>
                          <div class="item text-center">
                            <?php endif; ?>
                            <div class="product-miniature js-product-miniature item-one first-item">
                              <div class="thumbnail-container">
                                <?php woocommerce_show_product_loop_sale_flash(); ?>
                                <a
                                  href="<?php the_permalink(); ?>"><?php woocommerce_template_loop_product_thumbnail(); ?></a>
                              </div>
                              <div class="product-description">
                                <div class="product-groups">
                                  <div class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php $i++; ?>
                            <?php endwhile; ?>
                          </div>
                          <?php wp_reset_query(); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
    }

  protected function hierarchical_category_tree($cat, $depth, $product_category_list) {

    global $product_category_list;

    $categories = get_categories('hide_empty=0&taxonomy=product_cat&parent='. $cat);
    if( $categories ) : 
        $depth++;
        $indent = "";
        if($depth != 1){
            foreach(range(2, $depth) as $addsdf){
                $indent .= "&nbsp&nbsp ";
            }
        }
      foreach( $categories as $cate ) :
        $cate_name = $indent.$cate->name;
        $product_category_list[$cate->name] = $cate_name;
        $childerns = get_terms('hide_empty=0&taxonomy=product_cat&parent='. $cate->term_id);
        if($childerns){
            $this->hierarchical_category_tree($cate->term_id, $depth, $product_category_list);
        }
        
      endforeach; 
      $depth--;   
    endif;
    return $product_category_list;
  }

  protected function get_product_tags(){
    $terms = get_terms( 'product_tag' );
    $term_array = array();
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $term_array[$term->term_id] = $term->name;
        }
    }
    return $term_array;
  }
}