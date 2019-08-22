<?php
namespace ElementorWidgets\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class ImageSlider extends Widget_Base {
 
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
    return 'image_slider';
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
    return __( 'Image Slider Menu', 'elementor-widgets' );
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
    return 'fa fa-picture-o';
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
        'label' => __( 'Content', 'elementor-awesomesauce' ),
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
    <div class="wrap-banner">
            <!-- menu category -->
            <div class="container position">
                <div class="section menu-banner d-xs-none">
                    <div class="tiva-verticalmenu block">
                        <div class="box-content">
                            <div class="verticalmenu" role="navigation">
                                <ul class="menu level1">
                                    <?php
                                    $locations = get_nav_menu_locations();
                                    $menu = get_term($locations['slider'], 'nav_menu');
                                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                                    $menus = array();
                                    $menu = "";
                                    foreach ($menu_items as $menu_item) {
                                        if ($menu_item->menu_item_parent == 0) {
                                            $level_0_ID = $menu_item->ID;
                                            $menu_type = get_field('menu_style', $menu_item->ID);
                                            $menu_image = get_field('featured_image', $menu_item->ID);
                                            $menu_class = $menu_type == 'row' ? 'group' : '';
                                            $menu_class = $menu_type == 'image' ? 'group group-category-img' : '';
                                            $menu .= '<li class="item parent ' . $menu_class . '">';
                                            $menu .= '<a class="hasicon" href="' . $menu_item->url . '">';
                                            $menu .= '<img src="' . get_field('menu_icon', $menu_item->ID) . '" alt="img">';
                                            $menu .= $menu_item->title . '</a>';
                                            if ($menu_type === 'default') {
                                                $menu .= '<div class="dropdown-menu">';
                                                $menu .= '<div class="menu-items">';
                                                $menu .= '<ul>';
                                                foreach ($menu_items as $level_1_item) {
                                                    if ($level_1_item->menu_item_parent == $level_0_ID) {
                                                        $level_1_ID = $level_1_item->ID;
                                                        $menu .= '<li class="item parent-submenu parent" ><a href="' . $level_1_item->url . '">' . $level_1_item->title . '</a>';
                                                        $menu .= '<span class="show-sub fa-active-sub"></span>';
                                                        $menu .= '<div class="dropdown-submenu">';
                                                        $menu .= '<div class="menu-items">';
                                                        $menu .= '<ul>';
                                                        foreach ($menu_items as $level_2_item) {
                                                            if ($level_2_item->menu_item_parent == $level_1_ID) {

                                                                $menu .= '<li class="item"><a href="' . $level_2_item->url . '">' . $level_2_item->title . '</a></li>';
                                                            }
                                                        }
                                                        $menu .= '</ul>';
                                                        $menu .= '</div>';
                                                        $menu .= '</div>';
                                                        $menu .= '</li>';
                                                    }
                                                }
                                                $menu .= '</ul>';
                                                $menu .= '</div>';
                                                $menu .= '</div>';
                                            } elseif ($menu_type === 'row') {
                                                $menu .= '<div class="dropdown-menu menu-2">';
                                                $menu .= '<div class="menu-items">';
                                                $menu .= '<div class="item">';
                                                $menu .= '<div class="menu-content">';
                                                foreach ($menu_items as $level_1_item) {
                                                    if ($level_1_item->menu_item_parent == $level_0_ID) {
                                                        $level_1_ID = $level_1_item->ID;
                                                        $menu .= '<div class="tags">';
                                                        $menu .= '<div class="title float-left"><a href="' . $level_1_item->url . '"><b>' . $level_1_item->title . '</b></a>';
                                                        $menu .= '</div><!--title-->';
                                                        $menu .= '<ul class="list-inline">';
                                                        foreach ($menu_items as $level_2_item) {
                                                            if ($level_2_item->menu_item_parent == $level_1_ID) {
                                                                $menu .= '<li class="list-inline-item"><a href="' . $level_2_item->url . '">' . $level_2_item->title . '</a></li>';
                                                            }
                                                        }
                                                        $menu .= '</ul>';
                                                        $menu .= '</div><!--tags-->';
                                                    }
                                                }
                                                $menu .= '</div>';
                                                $menu .= '</div>';
                                                $menu .= '</div>';
                                                $menu .= '</div>';
                                            } elseif ($menu_type === 'image') {
                                                $menu .= '<div class="dropdown-menu menu-3">';
                                                $menu .= '<div class="menu-items">';
                                                $menu .= '<div class="item">';
                                                $menu .= '<div class="menu-content">';
                                                $menu .= '<div class="group-category row">';
                                                $menu .= '<div class="mt-20">';
                                                $subMenuCount = 0;
                                                $menu .= '<div class="d-flex">';
                                                foreach ($menu_items as $level_1_item) {
                                                    if ($level_1_item->menu_item_parent == $level_0_ID) {
                                                        $level_1_ID = $level_1_item->ID;

                                                        if ($subMenuCount % 2 == 0 && $subMenuCount > 0) {
                                                            $menu .= '</div><div class="d-flex">';
                                                        }
                                                        $menu .= '<div class="col">';

                                                        $menu .= '<span class="menu-title">';
                                                        $menu .= '<a href="' . $level_1_item->url . '">' . $level_1_item->title . '</a>';
                                                        $menu .= '</span><!--title-->';
                                                        $menu .= '<ul>';
                                                        foreach ($menu_items as $level_2_item) {
                                                            if ($level_2_item->menu_item_parent == $level_1_ID) {
                                                                $menu .= '<li><a href="' . $level_2_item->url . '">' . $level_2_item->title . '</a></li>';
                                                            }
                                                        }
                                                        $menu .= '</ul>';
                                                        $menu .= '</div><!--.col-->';

                                                        $subMenuCount++;
                                                    }
                                                }
                                                $menu .= '</div><!--.d-flex-->';
                                                $menu .= '</div><!--.mt-20-->';
                                                $menu .= '<div class="ml-15">';
                                                $menu .= '<span><img src="' . $menu_image . '" alt="Featured Image"></span>';
                                                $menu .= '</div><!--.ml-15-->';
                                                $menu .= '</div><!--.group-category.row-->';
                                                $menu .= '</div><!--.menu-content-->';
                                                $menu .= '</div><!--.item-->';
                                                $menu .= '</div><!--.menu-items-->';
                                                $menu .= '</div><!--.dropdown-menu-->';
                                            }
                                            $menu .= '</li>';
                                        }
                                    }
                                    echo $menu;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- slide show -->
            <div class="section banner">
                <div class="tiva-slideshow-wrapper">
                    <div id="tiva-slideshow" class="nivoSlider">
                        <?php
                        $args = array(
                            'post_type' => 'home-slider',
                        );
                        // the query
                        $the_query = new \WP_Query($args); ?>
                        <?php if ($the_query->have_posts()) : ?>

                            <?php
                            while ($the_query->have_posts()) : $the_query->the_post();
                                $image = get_field('slider');
                                $slider_link = get_field('slider_link');
                                $size = 'full'; // (thumbnail, medium, large, full or custom size)
                                if ($image) {
                                    ?>
                                    <a href="<?php echo $slider_link ? $slider_link : wp_get_attachment_image_url($image,'full')?>" target="_blank">
                                        <?php echo wp_get_attachment_image($image,'full', false, array('class'=>'img-responsive')); ?>
                                    </a>
                                    <?php
                                }
                            endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
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
        <div class="wrap-banner">
            <!-- menu category -->
            <div class="container position">
                <div class="section menu-banner d-xs-none">
                    <div class="tiva-verticalmenu block">
                        <div class="box-content">
                            <div class="verticalmenu" role="navigation">
                                <ul class="menu level1">
                                    <?php
                                    $locations = get_nav_menu_locations();
                                    $menu = get_term($locations['slider'], 'nav_menu');
                                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                                    $menus = array();
                                    $menu = "";
                                    foreach ($menu_items as $menu_item) {
                                        if ($menu_item->menu_item_parent == 0) {
                                            $level_0_ID = $menu_item->ID;
                                            $menu_type = get_field('menu_style', $menu_item->ID);
                                            $menu_image = get_field('featured_image', $menu_item->ID);
                                            $menu_class = $menu_type == 'row' ? 'group' : '';
                                            $menu_class = $menu_type == 'image' ? 'group group-category-img' : '';
                                            $menu .= '<li class="item parent ' . $menu_class . '">';
                                            $menu .= '<a class="hasicon" href="' . $menu_item->url . '">';
                                            $menu .= '<img src="' . get_field('menu_icon', $menu_item->ID) . '" alt="img">';
                                            $menu .= $menu_item->title . '</a>';
                                            if ($menu_type === 'default') {
                                                $menu .= '<div class="dropdown-menu">';
                                                $menu .= '<div class="menu-items">';
                                                $menu .= '<ul>';
                                                foreach ($menu_items as $level_1_item) {
                                                    if ($level_1_item->menu_item_parent == $level_0_ID) {
                                                        $level_1_ID = $level_1_item->ID;
                                                        $menu .= '<li class="item parent-submenu parent" ><a href="' . $level_1_item->url . '">' . $level_1_item->title . '</a>';
                                                        $menu .= '<span class="show-sub fa-active-sub"></span>';
                                                        $menu .= '<div class="dropdown-submenu">';
                                                        $menu .= '<div class="menu-items">';
                                                        $menu .= '<ul>';
                                                        foreach ($menu_items as $level_2_item) {
                                                            if ($level_2_item->menu_item_parent == $level_1_ID) {

                                                                $menu .= '<li class="item"><a href="' . $level_2_item->url . '">' . $level_2_item->title . '</a></li>';
                                                            }
                                                        }
                                                        $menu .= '</ul>';
                                                        $menu .= '</div>';
                                                        $menu .= '</div>';
                                                        $menu .= '</li>';
                                                    }
                                                }
                                                $menu .= '</ul>';
                                                $menu .= '</div>';
                                                $menu .= '</div>';
                                            } elseif ($menu_type === 'row') {
                                                $menu .= '<div class="dropdown-menu menu-2">';
                                                $menu .= '<div class="menu-items">';
                                                $menu .= '<div class="item">';
                                                $menu .= '<div class="menu-content">';
                                                foreach ($menu_items as $level_1_item) {
                                                    if ($level_1_item->menu_item_parent == $level_0_ID) {
                                                        $level_1_ID = $level_1_item->ID;
                                                        $menu .= '<div class="tags">';
                                                        $menu .= '<div class="title float-left"><a href="' . $level_1_item->url . '"><b>' . $level_1_item->title . '</b></a>';
                                                        $menu .= '</div><!--title-->';
                                                        $menu .= '<ul class="list-inline">';
                                                        foreach ($menu_items as $level_2_item) {
                                                            if ($level_2_item->menu_item_parent == $level_1_ID) {
                                                                $menu .= '<li class="list-inline-item"><a href="' . $level_2_item->url . '">' . $level_2_item->title . '</a></li>';
                                                            }
                                                        }
                                                        $menu .= '</ul>';
                                                        $menu .= '</div><!--tags-->';
                                                    }
                                                }
                                                $menu .= '</div>';
                                                $menu .= '</div>';
                                                $menu .= '</div>';
                                                $menu .= '</div>';
                                            } elseif ($menu_type === 'image') {
                                                $menu .= '<div class="dropdown-menu menu-3">';
                                                $menu .= '<div class="menu-items">';
                                                $menu .= '<div class="item">';
                                                $menu .= '<div class="menu-content">';
                                                $menu .= '<div class="group-category row">';
                                                $menu .= '<div class="mt-20">';
                                                $subMenuCount = 0;
                                                $menu .= '<div class="d-flex">';
                                                foreach ($menu_items as $level_1_item) {
                                                    if ($level_1_item->menu_item_parent == $level_0_ID) {
                                                        $level_1_ID = $level_1_item->ID;

                                                        if ($subMenuCount % 2 == 0 && $subMenuCount > 0) {
                                                            $menu .= '</div><div class="d-flex">';
                                                        }
                                                        $menu .= '<div class="col">';

                                                        $menu .= '<span class="menu-title">';
                                                        $menu .= '<a href="' . $level_1_item->url . '">' . $level_1_item->title . '</a>';
                                                        $menu .= '</span><!--title-->';
                                                        $menu .= '<ul>';
                                                        foreach ($menu_items as $level_2_item) {
                                                            if ($level_2_item->menu_item_parent == $level_1_ID) {
                                                                $menu .= '<li><a href="' . $level_2_item->url . '">' . $level_2_item->title . '</a></li>';
                                                            }
                                                        }
                                                        $menu .= '</ul>';
                                                        $menu .= '</div><!--.col-->';

                                                        $subMenuCount++;
                                                    }
                                                }
                                                $menu .= '</div><!--.d-flex-->';
                                                $menu .= '</div><!--.mt-20-->';
                                                $menu .= '<div class="ml-15">';
                                                $menu .= '<span><img src="' . $menu_image . '" alt="Featured Image"></span>';
                                                $menu .= '</div><!--.ml-15-->';
                                                $menu .= '</div><!--.group-category.row-->';
                                                $menu .= '</div><!--.menu-content-->';
                                                $menu .= '</div><!--.item-->';
                                                $menu .= '</div><!--.menu-items-->';
                                                $menu .= '</div><!--.dropdown-menu-->';
                                            }
                                            $menu .= '</li>';
                                        }
                                    }
                                    echo $menu;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- slide show -->
            <div class="section banner">
                <div class="tiva-slideshow-wrapper">
                    <div id="tiva-slideshow" class="nivoSlider">
                        <?php
                        $args = array(
                            'post_type' => 'home-slider',
                        );
                        // the query
                        $the_query = new \WP_Query($args); ?>
                        <?php if ($the_query->have_posts()) : ?>

                            <?php
                            while ($the_query->have_posts()) : $the_query->the_post();
                                $image = get_field('slider');
                                $slider_link = get_field('slider_link');
                                $size = 'full'; // (thumbnail, medium, large, full or custom size)
                                if ($image) {
                                    ?>
                                    <a href="<?php echo $slider_link ? $slider_link : wp_get_attachment_image_url($image,'full')?>" target="_blank">
                                        <?php echo wp_get_attachment_image($image,'full', false, array('class'=>'img-responsive')); ?>
                                    </a>
                                    <?php
                                }
                            endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
  }
}