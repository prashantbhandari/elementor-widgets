<?php
namespace ElementorWidgets\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class RecentPosts extends Widget_Base {
 
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
    return 'recent_posts';
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
    return __( 'Recent Posts', 'elementor-widgets' );
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
    return 'fa fa-newspaper';
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
    $settings = $this->get_settings_for_display();
    ?>
    <!-- recent posts -->
    <div class="container">
        <div class="section recent-post">
            <div class="title-block">RECENT POST</div>
            <div class="row">
                <?php
                $args = array( 'numberposts' => '3' );
                $recent_posts = wp_get_recent_posts($args);
                foreach( $recent_posts as $recent ):
                setup_postdata($recent);
                ?>
                <div class="col-md-4">
                    <div class="item-post">
                        <div class="thumbnail-img border">
                            <a href="<?php echo get_permalink($recent["ID"]);?>"><?php
                            if ( has_post_thumbnail( $recent["ID"]) ) {
                                echo  get_the_post_thumbnail($recent["ID"], 'homepage_recent_post_thumbnail',array('class' => 'img-fluid w-100'));
                            }else {
                                echo '<img src="http://halesi.local/wp-content/uploads/2019/08/default-image-370x208.png" />';
                            }
                            ?>
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-info">
                                <span class="comment">
                                    <i class="fa fa-comments-o" aria-hidden="true"></i>
                                    <span><?php echo get_comments_number($recent['ID']);?>
                                        Comments</span>
                                </span>
                                <span class="datetime">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <span><?php echo get_the_date($recent['ID']);?></span>
                                </span>
                            </div>
                            <div class="post-title">
                                <?php echo '<a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a>'; ?>
                            </div>
                            <div class="post-desc">
                                <?php echo $recent['post_excerpt']; ?>
                            </div>
                        </div>
                    </div>
                </div><?php
                endforeach;
                wp_reset_query();
                ?>
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
    <!-- recent posts -->
    <div class="container">
        <div class="section recent-post">
            <div class="title-block">RECENT POST</div>
            <div class="row">
                <?php
                $args = array( 'numberposts' => '3' );
                $recent_posts = wp_get_recent_posts($args);
                foreach( $recent_posts as $recent ):
                setup_postdata($recent);
                ?>
                <div class="col-md-4">
                    <div class="item-post">
                        <div class="thumbnail-img border">
                            <a href="<?php echo get_permalink($recent["ID"]);?>"><?php
                            if ( has_post_thumbnail( $recent["ID"]) ) {
                                echo  get_the_post_thumbnail($recent["ID"], 'homepage_recent_post_thumbnail',array('class' => 'img-fluid w-100'));
                            }else {
                                echo '<img src="http://halesi.local/wp-content/uploads/2019/08/default-image-370x208.png" />';
                            }
                            ?>
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-info">
                                <span class="comment">
                                    <i class="fa fa-comments-o" aria-hidden="true"></i>
                                    <span><?php echo get_comments_number($recent['ID']);?>
                                        Comments</span>
                                </span>
                                <span class="datetime">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <span><?php echo get_the_date($recent['ID']);?></span>
                                </span>
                            </div>
                            <div class="post-title">
                                <?php echo '<a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a>'; ?>
                            </div>
                            <div class="post-desc">
                                <?php echo $recent['post_excerpt']; ?>
                            </div>
                        </div>
                    </div>
                </div><?php
                endforeach;
                wp_reset_query();
                ?>
            </div>
        </div>
    </div>

    <?php
  }
}