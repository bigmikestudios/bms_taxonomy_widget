<?php
/**
 * @author Mike Lathrop
 * @version 0.0.1
 */
/*
Plugin Name: BMS Taxonomy Widget
Plugin URI: http://bigmikestudios.com
Depends: 
Description: Adds a simple widget for displaying custom taxonomies
Version: 0.0.1
Author URI: http://bigmikestudios.com
*/

// =============================================================================

//////////////////////////
//
// WIDGETS
//
//////////////////////////

class Bms_Taxonomy_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'bms_taxonomy_widget', // Base ID
			'BMS Taxonomy Widget', // Name
			array( 'description' => __( 'Creates a simple widget to display custom taxonomies.', 'text_domain' ), ) // Args 
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$taxonomy = $instance['taxonomy'];

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		$args = array(
		  'title_li' => false,
		  'taxonomy' => $taxonomy
		);
		?>
		<ul>
        	<?php wp_list_categories($args); ?>
        </ul>
        <?php
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['taxonomy'] = strip_tags( $new_instance['taxonomy'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		if ( isset( $instance[ 'taxonomy' ] ) ) {
			$taxonomy = $instance[ 'taxonomy' ];
		}
		else {
			$taxonomy = __( 'Enter taxonomy slug here', 'text_domain' );
		}
		
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        <label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Taxonomy:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" type="text" value="<?php echo esc_attr( $taxonomy ); ?>" />
		</p>
		<?php 
	}

} // class Foo_Widget

// register Foo_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "bms_taxonomy_widget" );' ) );

?>