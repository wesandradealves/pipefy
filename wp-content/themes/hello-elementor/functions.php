<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '2.4.1' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_load_textdomain', [ true ], '2.0', 'hello_elementor_load_textdomain' );
		if ( apply_filters( 'hello_elementor_load_textdomain', $hook_result ) ) {
			load_theme_textdomain( 'hello-elementor', get_template_directory() . '/languages' );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_menus', [ true ], '2.0', 'hello_elementor_register_menus' );
		if ( apply_filters( 'hello_elementor_register_menus', $hook_result ) ) {
			register_nav_menus( [ 'menu-1' => __( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => __( 'Footer', 'hello-elementor' ) ] );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_theme_support', [ true ], '2.0', 'hello_elementor_add_theme_support' );
		if ( apply_filters( 'hello_elementor_add_theme_support', $hook_result ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_woocommerce_support', [ true ], '2.0', 'hello_elementor_add_woocommerce_support' );
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', $hook_result ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	$hello_theme_db_version = get_option( $theme_version_option_name );

	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	function hello_elementor_scripts_styles() {
		$enqueue_basic_style = apply_filters_deprecated( 'elementor_hello_theme_enqueue_style', [ true ], '2.0', 'hello_elementor_enqueue_style' );
		$min_suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', $enqueue_basic_style ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_elementor_locations', [ true ], '2.0', 'hello_elementor_register_elementor_locations' );
		if ( apply_filters( 'hello_elementor_register_elementor_locations', $hook_result ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

require get_template_directory() . '/includes/elementor-functions.php';

function hello_register_customizer_functions() {
	if ( hello_header_footer_experiment_active() && is_customize_preview() ) {
		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_register_customizer_functions' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );


if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	}
}

function widgets_init() {
    register_sidebar( array(
        'name' => 'Sidebar',
        'id' => 'sidebar',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ) );
}
add_action( 'widgets_init', 'widgets_init' );	

function field_shortcode( $atts, $content = null ) {
    $field = shortcode_atts( array(
		'button' => 'Button label',
		'title' => 'Title goes here',
        'type' => 'text',
        'name'  => 'input_field',
        'iid' => 'input_field',
		'fid' => '',
		'text_contrast' => 'white',
		'text' => 'gray',
		'primary_color' => '#48b55a',
		'ibgcolor' => 'whitesmoke',
		'ico' => 'fa-ellipsis-h'
    ), $atts );

    return '
		<form onsubmit="return event.preventDefault()" id="'.esc_attr($field['fid']).'" name="'.esc_attr($field['fid']).'">
			<div id="spinner">
				<div class="sk-chase">
					<div class="sk-chase-dot"></div>
					<div class="sk-chase-dot"></div>
					<div class="sk-chase-dot"></div>
					<div class="sk-chase-dot"></div>
					<div class="sk-chase-dot"></div>
					<div class="sk-chase-dot"></div>
				</div>	
			</div>
			<div class="form-inner">
				<div class="form-fields">
					<h2>'.esc_attr($field['title']).'</h2>
					<span class="input_wrapper">
						<input type="' . esc_attr($field['type']) . '" name="' . esc_attr($field['iid']) . '" id="' . esc_attr($field['iid']) . '"/>
						<i class="fa '.esc_attr($field['ico']).'"></i>
					</span>
					<button onclick="PING(`' . esc_attr($field['iid']) . '`)">'.esc_attr($field['button']).'</button>
				</div>
				<p id="msg-wrapper"></p>
				<p class="result"></p>
			</div>			
		</form>
		<style>
			#spinner {
				display: none;
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: rgba(0,0,0,.3);
				justify-content: center;
				align-items: center;
			}

			.sk-chase {
				display: block;
				width: 40px;
				height: 40px;
				position: relative;
				animation: sk-chase 2.5s infinite linear both;
			}
			
			.sk-chase-dot {
				width: 100%;
				height: 100%;
				position: absolute;
				left: 0;
				top: 0; 
				animation: sk-chase-dot 2.0s infinite ease-in-out both; 
			}
			
			.sk-chase-dot:before {
				content: "";
				display: block;
				width: 25%;
				height: 25%;
				background-color: #fff;
				border-radius: 100%;
				animation: sk-chase-dot-before 2.0s infinite ease-in-out both; 
			}
			
			.sk-chase-dot:nth-child(1) { animation-delay: -1.1s; }
			.sk-chase-dot:nth-child(2) { animation-delay: -1.0s; }
			.sk-chase-dot:nth-child(3) { animation-delay: -0.9s; }
			.sk-chase-dot:nth-child(4) { animation-delay: -0.8s; }
			.sk-chase-dot:nth-child(5) { animation-delay: -0.7s; }
			.sk-chase-dot:nth-child(6) { animation-delay: -0.6s; }
			.sk-chase-dot:nth-child(1):before { animation-delay: -1.1s; }
			.sk-chase-dot:nth-child(2):before { animation-delay: -1.0s; }
			.sk-chase-dot:nth-child(3):before { animation-delay: -0.9s; }
			.sk-chase-dot:nth-child(4):before { animation-delay: -0.8s; }
			.sk-chase-dot:nth-child(5):before { animation-delay: -0.7s; }
			.sk-chase-dot:nth-child(6):before { animation-delay: -0.6s; }
			
			@keyframes sk-chase {
				100% { transform: rotate(360deg); } 
			}
			
			@keyframes sk-chase-dot {
				80%, 100% { transform: rotate(360deg); } 
			}
			
			@keyframes sk-chase-dot-before {
				50% {
				transform: scale(0.4); 
				} 100%, 0% {
				transform: scale(1.0); 
				} 
			}		

			#'.esc_attr($field['fid']).' p {
				margin: 0;	
			}
			#msg-wrapper:not(:empty) {
				font-size: .9rem;
				display: block;
				padding-top: 15px;
				text-align: center;
				font-style: italic;
			}
			.result:not(:empty) {
				font-size: 1.6rem;
				text-align: center;
			}
			#'.esc_attr($field['fid']).' h2 {
				font-weight: normal;
				font-size: 1.3rem;
			}
			#'.esc_attr($field['fid']).' {
				display: flex;
				justify-content: center;
				align-items: center;
				position: absolute;
				width: 100%;
				height: 100vh;
				top: 0;
				left: 0;
				background-color: '.esc_attr($field['primary_color']).';
				color: '.esc_attr($field['text']).';
			}
			#'.esc_attr($field['fid']).' .form-inner {
				background-color: white;
				display: block; 
				padding: 50px;
				width: 100%;
				max-width: 346px;
			}
			#'.esc_attr($field['fid']).' button {
				background-color: '.esc_attr($field['primary_color']).';
				color: '.esc_attr($field['text_contrast']).';
				display: block;
				width: 100%;		
				border: 0;
				border-radius: 0;		
			}
			#'.esc_attr($field['fid']).' .input_wrapper {
				background-color: '.esc_attr($field['ibgcolor']).';
				display: flex;
				flex-flow: row wrap;
				align-items: center;
				padding: 15px;
				justify-content: space-between;
				margin: 20px 0 10px;
			}
			#'.esc_attr($field['fid']).' input {
				background-color: transparent;
				color: inherit;
				display: block;
				width: 100%;
				margin: 0;
				padding: 0;
				border: 0;
				flex: 1;
				margin-right: 5px;
			}
			#'.esc_attr($field['fid']).' input + i {
				flex: 0 0 auto;
			}
		</style>
	';
}
add_shortcode( 'shortpress', 'field_shortcode' );

function fontawesome() {
    wp_enqueue_script( 'fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'fontawesome' );

add_action( 'wp_enqueue_scripts', 'secure_enqueue_script' );
function secure_enqueue_script() {
  wp_register_script( 'secure-ajax-access', esc_url( add_query_arg( array( 'js_global' => 1 ), site_url() ) ) );
  wp_enqueue_script( 'secure-ajax-access' );
}

add_action( 'template_redirect', 'javascript_variaveis' );

function javascript_variaveis() {
  if ( !isset( $_GET[ 'js_global' ] ) ) return;

  $nonce = wp_create_nonce('posts');

  $variaveis_javascript = array(
    'posts' => $nonce, 
    'xhr_url' => admin_url('admin-ajax.php') 
  );

  $new_array = array();
  foreach( $variaveis_javascript as $var => $value ) $new_array[] = esc_js( $var ) . " : '" . esc_js( $value ) . "'";

  header("Content-type: application/x-javascript");
  printf('var %s = {%s};', 'js_global', implode( ',', $new_array ) );
  exit;
}

function ping_php()
{
   print_r(json_encode(get_post($_POST['id'])));
   die();
}
add_action( 'wp_ajax_ping_php', 'ping_php' );
add_action( 'wp_ajax_nopriv_ping_php', 'ping_php' );
function enqueue_scripts() {
	wp_register_script('ajax-script',  get_template_directory_uri() .'/assets/js/functions.js', array('jquery'), 1.0 ); 
	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
    wp_enqueue_script( 'ajax-script'); 
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');