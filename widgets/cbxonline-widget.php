<?php

 
 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}


class CBXOnlineWidget extends WP_Widget {

    /**
     *
     * Unique identifier for your widget.
     *
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * widget file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'cbxuseronline'; //main parent plugin's language file

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			$this->get_widget_slug(),
			__( 'CBX Useronline', $this->get_widget_slug() ),
			array(
				'classname'  => $this->get_widget_slug().'-class',
				'description' => __( 'This widget shows online user stat based on the option', $this->get_widget_slug() )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

		// Refreshing the widget's cached output with each new post
		add_action( 'cbxuseronline_record',    array( $this, 'flush_widget_cache' ) );
		//add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

	} // end constructor


    /**
     * Return the widget slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		
		// Check if there is a cached output
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset ( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset ( $cache[ $args['widget_id'] ] ) )
			return print $cache[ $args['widget_id'] ];
		
		// go on with your widget logic, put everything into a string and …


		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;

		$title         = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'CBX Useronline', $this->get_widget_slug() ) : $instance['title'], $instance, $this->id_base );
		// Defining the Widget Title
		if ( $title ) {
			$widget_string .= $args['before_title'] . $title . $args['after_title'];
		}
		else{
			$widget_string .= $args['before_title'] .  $args['after_title'];
		}
		/*
		$count               = !empty($instance['count']) ? intval( $instance['count'] )  : 1;
		$count_individual    = isset($instance['count_individual'])     ? intval( $instance['count_individual'] )  : 1;
		$member_count        = isset($instance['member_count'])         ? esc_attr( $instance['member_count'] ): 1;
		$guest_count         = isset($instance['guest_count'])        ? esc_attr( $instance['guest_count'] ) : 1;
		$bot_count           = isset($instance['bot_count'])     ? esc_attr( $instance['bot_count'] ): 1;
		$page                = isset($instance['page'])        ? intval( $instance['page'] ): 1;
		$mobile              = isset($instance['mobile'])        ? intval( $instance['mobile'] ): 1;
		*/
		$fields = array(
			'count'             => 1,
			'count_individual'  => 1,
			'member_count'      => 1,
			'guest_count'       => 1,
			'bot_count'         => 1,
			'page'              => 0,
			'mobile'            => 1
		);

		foreach($fields as $field => $val){

			if ( isset($instance[$field]) )
			{
				$instance[$field] = intval( $instance[$field] );
			}
			else{
				$instance[$field] = $val;
			}

		}

/*
		echo '<pre>';
		print_r($instance);
		echo '</pre>';*/

		ob_start();



		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;

		$instance['page'] = ($instance['page'])? $_SERVER['REQUEST_URI']: '';

		echo CBXUseronlineHelper::cbxuseronline_display($instance);

		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;

	} // end widget
	
	
	public function flush_widget_cache() 
	{
    	wp_cache_delete( $this->get_widget_slug(), 'widget' );
	}
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$fields = array(
			'count'             => 1,
			'count_individual'  => 1,
			'member_count'      => 1,
			'guest_count'       => 1,
			'bot_count'         => 1,
			'page'              => 0,
			'mobile'            => 1
		);

		$instance['title']              = esc_attr( $new_instance['title'] );
		foreach($fields as $field => $val){

			if ( isset($new_instance[$field]) )
			{
				$instance[$field] = 1;
			}
			else{
				$instance[$field] = 0;
			}

		}
		/*
		$instance['count']              = intval( $new_instance['count'] );
		$instance['count_individual']   = intval( $new_instance['count_individual'] );
		$instance['member_count']       = intval( $new_instance['member_count'] );
		$instance['guest_count']        = intval( $new_instance['guest_count'] );
		$instance['bot_count']          = intval( $new_instance['bot_count'] );
		$instance['page']               = intval( $new_instance['page'] );
		$instance['mobile']             = intval( $new_instance['mobile'] );
		*/


		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {


		$instance = wp_parse_args(
			(array) $instance,
			array(
				'count'             => 1,
				'count_individual'  => 1,
				'member_count'      => 1,
				'guest_count'       => 1,
				'bot_count'         => 1,
				'page'              => 0,
				'mobile'            => 1
			)
		);

		extract( $instance, EXTR_SKIP );


		/*
		$title               = esc_attr( $instance['title'] );
		$count               = !empty($instance['count']) ? intval( $instance['count'] )  : 1;
		$count_individual    = isset($instance['count_individual'])     ? intval( $instance['count_individual'] )  : 1;
		$member_count        = isset($instance['member_count'])         ? esc_attr( $instance['member_count'] ): 1;
		$guest_count         = isset($instance['guest_count'])        ? esc_attr( $instance['guest_count'] ) : 1;
		$bot_count           = isset($instance['bot_count'])     ? esc_attr( $instance['bot_count'] ): 1;
		$page                = isset($instance['page'])        ? intval( $instance['page'] ): 1;
		$mobile              = isset($instance['mobile'])        ? intval( $instance['mobile'] ): 1;
		*/

		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/




	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array('jquery') );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-widget-styles', plugins_url( 'css/widget.css', __FILE__ ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'js/widget.js', __FILE__ ), array('jquery') );

	} // end register_widget_scripts

} // end class



