<?php
namespace ElementorWidgets\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class categoryShowcase extends Widget_Base {
 
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
    return 'category_showcase';
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
    return __( 'Category Showcase', 'elementor-widgets' );
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
    return 'fa fa-list';
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
			'product_categories',
			[
				'label' => __( 'Categories', 'elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->hierarchical_category_tree(0, 0, array()),
				'default' => 'Not Selected',
			]
    );
    
    $this->add_control(
			'background_image',
			[
				'label' => __( 'Background Image', 'elementor-widgets' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
    );
    
    $this->add_control(
			'banner_left',
			[
				'label' => __( 'Banner Left', 'elementor-widgets' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
    );

    $this->add_control(
      'banner_left_url',
      [
        'label' => __( 'Banner Left URL', 'elementor-widgets' ),
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
    
    $this->add_control(
			'banner_right',
			[
				'label' => __( 'Banner Right', 'elementor-widgets' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
    );
    
    $this->add_control(
      'banner_right_url',
      [
        'label' => __( 'Banner Right URL', 'elementor-widgets' ),
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
    ?>

    <?php
    $target = $settings['banner_left_url']['is_external'] ? ' target="_blank"' : '';
    $nofollow = $settings['banner_left_url']['nofollow'] ? ' rel="nofollow"' : '';
    $target = $settings['banner_right_url']['is_external'] ? ' target="_blank"' : '';
	$nofollow = $settings['banner_right_url']['nofollow'] ? ' rel="nofollow"' : '';
    $background_url = $settings['background_image']['url'];
    $banner_left = $settings['banner_left']['url'];
    $banner_left_link = $settings['banner_left_url']['url'];
    $banner_right = $settings['banner_right']['url'];
    $banner_right_link = $settings['banner_right_url']['url'];
    $term_name = $settings['product_categories'];
    $term = get_term_by('name', $term_name, 'product_cat');
    $term_id = $term->term_id;
    ?>
    <div class="section living-room"
    style="background: url(<?php echo $background_url ?>) no-repeat;">
   <div class="container">
       <div class="tiva-row-wrap row">
           <div class="groupcategoriestab-vertical col-md-12 col-xs-12">
               <div class="grouptab row">
                   <div class="categoriestab-right col-lg-3 align-items-start d-flex flex-column col-md-3 flex-3">
                       <div class="block-title-content">
                           <h2 class="title-block">
                               <?php echo $term->name; ?>
                           </h2>
                       </div>
                       <div class="cate-child-vertical">
                           <?php
                           $orderby = 'name';
                           $order = 'asc';
                           $hide_empty = false;
                           $cat_args = array(
                               'orderby' => $orderby,
                               'order' => $order,
                               'hide_empty' => $hide_empty,
                               'child_of' => $term_id,
                               'number' => 12
                           );

                           $product_categories = get_terms('product_cat', $cat_args);

                           if (!empty($product_categories)) {
                               echo '<ul>';
                               foreach ($product_categories as $key => $category) {
                                   echo '<li>';
                                   echo '<a href="' . get_term_link($category) . '" >';
                                   echo $category->name;
                                   echo '</a>';
                                   echo '</li>';
                               }
                               echo '<li><a href="' . get_term_link($term) . '">View All</a></li>';
                               echo '</ul>';
                           }
                           ?>
                       </div>
                   </div>
                   <div class="categoriestab-left product-tab col-md-9 flex-9">
                       <div class="title-tab-content d-flex justify-content-start">
                           <ul class="nav nav-tabs">
                               <li>
                                   <a href="#new" data-toggle="tab" class="active">New Arrivals</a>
                               </li>
                               <li>
                                   <a href="#best" data-toggle="tab">Best Sellers</a>
                               </li>
                               <li>
                                   <a href="#sale" data-toggle="tab">Special Products</a>
                               </li>
                           </ul>
                       </div>
                       <div class="tab-content">
                           <div id="new" class="tab-pane fade in active show">
                               <div class="category-product-index owl-carousel owl-theme owl-loaded owl-drag">

                                   <?php

                                   $args = array(
                                       'post_type' => 'product',
                                       'stock' => 1,
                                       'posts_per_page' => 6,
                                       'product_cat' => $term->slug,
                                       'orderby' => 'date',
                                       'order' => 'DESC');
                                   $loop = new \WP_Query($args);
                                   while ($loop->have_posts()) : $loop->the_post();

                                       wc_get_template_part('content', 'product_grid');

                                   endwhile;
                                   wp_reset_query();
                                   ?>
                               </div>
                           </div>

                           <div class="tab-pane fade" id="best">
                               <div class="category-product-index owl-carousel owl-theme">
                                   <?php
                                   $args = array(
                                       'post_type' => 'product',
                                       'orderby' => 'meta_value_num',
                                       'posts_per_page' => 6,
                                       'product_cat' => $term->slug,
                                       'product_tag' => 'best seller'
                                   );
                                   $loop = new \WP_Query($args);
                                   while ($loop->have_posts()) : $loop->the_post();
                                       wc_get_template_part('content', 'product_grid');
                                   endwhile; ?>
                                   <?php wp_reset_query(); ?>

                               </div>
                           </div>

                           <div class="tab-pane fade" id="sale">
                               <div class="category-product-index owl-carousel owl-theme">
                                   <?php
                                   $args = array(
                                       'post_type' => 'product',
                                       'orderby' => 'meta_value_num',
                                       'posts_per_page' => 6,
                                       'product_cat' => $term->slug,
                                       'post__in' => wc_get_featured_product_ids(),
                                   );
                                   $loop = new \WP_Query($args);
                                   while ($loop->have_posts()) : $loop->the_post();

                                       wc_get_template_part('content', 'product_grid');

                                   endwhile; ?>
                                   <?php wp_reset_query(); ?>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="section spacing-10 group-image-special col-lg-12 col-xs-12">
           <div class="row">
               <div class="col-lg-6 col-md-6">
                   <div class="effect">
                       <a href="<?php echo $banner_left_link ?>" <?php echo $target; ?> <?php echo $nofollow; ?>>
                           <img class="img-fluid"
                                src="<?php echo $banner_left ?>"
                                alt="banner-1" title="banner-1">
                       </a>
                   </div>
               </div>
               <div class="col-lg-6 col-md-6">
                   <div class="effect">
                       <a href="<?php echo $banner_right_link ?>" <?php echo $target; ?> <?php echo $nofollow; ?>>
                           <img class="img-fluid"
                                src="<?php echo $banner_right ?>"
                                alt="banner-2" title="banner-2">
                       </a>
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
    view.addInlineEditingAttributes( 'title', 'none' );
    var target = settings.banner_left_url.is_external ? ' target="_blank"' : '';
		var nofollow = settings.banner_left_url.nofollow ? ' rel="nofollow"' : '';
    var target = settings.banner_right_url.is_external ? ' target="_blank"' : '';
		var nofollow = settings.banner_right_url.nofollow ? ' rel="nofollow"' : '';
    #>
<?php
    $background_url = "{{{ settings.background_image.url }}}";
    $banner_left = "{{{ settings.banner_left.url }}}";
    $banner_left_link = "{{{settings.banner_left_url.url}}}";
    $banner_right = "{{{ settings.banner_right.url }}}";
    $banner_right_link = "{{{settings.banner_right_url.url}}}";
    $term_id = "{{{ settings.product_categories }}}";
    $term = get_term($term_id);
    ?>
    <div class="section living-room"
    style="background: url(<?php echo $background_url ?>) no-repeat;">
    <div class="container">
        <div class="tiva-row-wrap row">
            <div class="groupcategoriestab-vertical col-md-12 col-xs-12">
                <div class="grouptab row">
                    <div class="categoriestab-right col-lg-3 align-items-start d-flex flex-column col-md-3 flex-3">
                        <div class="block-title-content">
                            <h2 class="title-block">
                                <?php echo $term->name; ?>
                            </h2>
                        </div>
                        <div class="cate-child-vertical">
                            <?php
                            $orderby = 'name';
                            $order = 'asc';
                            $hide_empty = false;
                            $cat_args = array(
                                'orderby' => $orderby,
                                'order' => $order,
                                'hide_empty' => $hide_empty,
                                'child_of' => $term_id,
                                'number' => 12
                            );

                            $product_categories = get_terms('product_cat', $cat_args);

                            if (!empty($product_categories)) {
                                echo '<ul>';
                                foreach ($product_categories as $key => $category) {
                                    echo '<li>';
                                    echo '<a href="' . get_term_link($category) . '" >';
                                    echo $category->name;
                                    echo '</a>';
                                    echo '</li>';
                                }
                                echo '<li><a href="' . get_term_link($term) . '">View All</a></li>';
                                echo '</ul>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="categoriestab-left product-tab col-md-9 flex-9">
                        <div class="title-tab-content d-flex justify-content-start">
                            <ul class="nav nav-tabs">
                                <li>
                                    <a href="#new" data-toggle="tab" class="active">New Arrivals</a>
                                </li>
                                <li>
                                    <a href="#best" data-toggle="tab">Best Sellers</a>
                                </li>
                                <li>
                                    <a href="#sale" data-toggle="tab">Special Products</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div id="new" class="tab-pane fade in active show">
                                <div class="category-product-index owl-carousel owl-theme owl-loaded owl-drag">

                                    <?php

                                    $args = array(
                                        'post_type' => 'product',
                                        'stock' => 1,
                                        'posts_per_page' => 6,
                                        'product_cat' => $term->slug,
                                        'orderby' => 'date',
                                        'order' => 'DESC');
                                    $loop = new \WP_Query($args);
                                    while ($loop->have_posts()) : $loop->the_post();

                                        wc_get_template_part('content', 'product_grid');

                                    endwhile;
                                    wp_reset_query();
                                    ?>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="best">
                                <div class="category-product-index owl-carousel owl-theme">
                                    <?php
                                    $args = array(
                                        'post_type' => 'product',
                                        'orderby' => 'meta_value_num',
                                        'posts_per_page' => 6,
                                        'product_cat' => $term->slug,
                                        'product_tag' => 'best seller'
                                    );
                                    $loop = new \WP_Query($args);
                                    while ($loop->have_posts()) : $loop->the_post();
                                        wc_get_template_part('content', 'product_grid');
                                    endwhile; ?>
                                    <?php wp_reset_query(); ?>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="sale">
                                <div class="category-product-index owl-carousel owl-theme">
                                    <?php
                                    $args = array(
                                        'post_type' => 'product',
                                        'orderby' => 'meta_value_num',
                                        'posts_per_page' => 6,
                                        'product_cat' => $term->slug,
                                        'post__in' => wc_get_featured_product_ids(),
                                    );
                                    $loop = new \WP_Query($args);
                                    while ($loop->have_posts()) : $loop->the_post();

                                        wc_get_template_part('content', 'product_grid');

                                    endwhile; ?>
                                    <?php wp_reset_query(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section spacing-10 group-image-special col-lg-12 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="effect">
                        <a href="<?php echo $banner_left_link ?>" {{target}} {{nofollow}}>
                            <img class="img-fluid"
                                  src="<?php echo $banner_left ?>"
                                  alt="banner-1" title="banner-1">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="effect">
                        <a href="<?php echo $banner_right_link ?>" {{target}} {{nofollow}}>
                            <img class="img-fluid"
                                  src="<?php echo $banner_right ?>"
                                  alt="banner-2" title="banner-2">
                        </a>
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

    $categories = get_categories('hide_empty=0&taxonomy=product_cat&order=ASC&parent='. $cat);
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
        $childerns = get_categories('hide_empty=0&taxonomy=product_cat&order=ASC&parent='. $cate->term_id);
        if($childerns){
            $this->hierarchical_category_tree($cate->term_id, $depth, $product_category_list);
        }
        
      endforeach; 
      $depth--;   
    endif;
    return $product_category_list;
  }
}