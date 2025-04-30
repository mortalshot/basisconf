<?php

/**
 * basis functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package basis
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('bas_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bas_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on basis, use a find and replace
		 * to change 'bas' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('bas', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'header' => esc_html__('Header menu', 'bas'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');
	}
endif;
add_action('after_setup_theme', 'bas_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bas_content_width()
{
	$GLOBALS['content_width'] = apply_filters('bas_content_width', 640);
}
add_action('after_setup_theme', 'bas_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function bas_scripts()
{
	wp_enqueue_style('bas-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('bas-stylesheet', get_template_directory_uri() . '/dist/css/style.min.css', array(), _S_VERSION);

	wp_enqueue_script('bas-custom-js', get_template_directory_uri() . '/dist/js/app.min.js', '', _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'bas_scripts');

// Выводим настройки в меню админки
if (function_exists('acf_add_options_page')) {
	// Main Theme Settings Page
	$parent = acf_add_options_page(array(
		'page_title' => 'Theme settings',
		'menu_title' => 'Theme settings',
		'redirect'   => 'Theme Settings',
	));
	acf_add_options_sub_page(array(
		'page_title' => 'Theme settings',
		'menu_title' => 'Theme settings',
		'menu_slug'  => "acf-options",
		'parent'     => $parent['menu_slug']
	));
	acf_add_options_sub_page(array(
		'page_title' => 'Repeating blocks',
		'menu_title' => 'Repeating blocks',
		'parent'     => $parent['menu_slug']
	));
}

// Изменяем стартовую высоту textarea в advanced custom field
function PREFIX_apply_acf_modifications()
{
?>
	<style>
		.acf-editor-wrap iframe {
			min-height: 0;
		}
	</style>
	<script>
		(function($) {
			// (filter called before the tinyMCE instance is created)
			acf.add_filter('wysiwyg_tinymce_settings', function(mceInit, id, $field) {
				// enable autoresizing of the WYSIWYG editor
				mceInit.wp_autoresize_on = true;
				return mceInit;
			});
			// (action called when a WYSIWYG tinymce element has been initialized)
			acf.add_action('wysiwyg_tinymce_init', function(ed, id, mceInit, $field) {
				// reduce tinymce's min-height settings
				ed.settings.autoresize_min_height = 130;
				// reduce iframe's 'height' style to match tinymce settings
				$('.acf-editor-wrap iframe').css('height', '130px');
			});
		})(jQuery)
	</script>
<?php
}
add_action('acf/input/admin_footer', 'PREFIX_apply_acf_modifications');

// Отключение Emoji в WordPress
function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');
function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

// Удаление стилей и скриптов wordpress по умолчанию
function wpassist_remove_block_library_css()
{
	wp_dequeue_style('global-styles');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-blocks-style');
	wp_dequeue_style('woocommerce-general');
	wp_dequeue_style('woocommerce-layout');
	wp_dequeue_style('woocommerce-smallscreen');
	wp_dequeue_style('font-awesome');
	wp_dequeue_style('yith-wcwl-main');

	wp_dequeue_script('prettyPhoto');
	wp_dequeue_script('prettyPhoto-init');
}
add_action('wp_enqueue_scripts', 'wpassist_remove_block_library_css');

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

function agentwp_dequeue_stylesandscripts()
{
	if (class_exists('woocommerce')) {
		wp_dequeue_style('selectWoo');
		wp_deregister_style('selectWoo');

		wp_dequeue_script('selectWoo');
		wp_deregister_script('selectWoo');

		wp_dequeue_script('wc-country-select');
	}
}

// Удаляем <p> и <br/> из Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');

/* Меняем у excerpt '[...]' на '...' */
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more)
{
	global $post;
	return '...';
}

// Удаляем аттрибут role и тэг h2 
function sanitize_pagination($content)
{
	$content = str_replace('navigation', '', $content);
	$content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);

	return $content;
}

add_action('navigation_markup_template', 'sanitize_pagination');

add_action('current_screen', 'disable_editor_for_homepage');
function disable_editor_for_homepage()
{
	// Получаем ID главной страницы
	$homepage_id = get_option('page_on_front');

	// Проверяем, что это главная страница
	if (isset($_GET['post'])) {
		$post_id = $_GET['post'];
	} elseif (isset($_POST['post_ID'])) {
		$post_id = $_POST['post_ID'];
	} else {
		return;
	}

	// Если это главная страница — отключаем редактор
	if ($post_id == $homepage_id) {
		remove_post_type_support('page', 'editor');
	}
}

add_action('admin_init', 'export_flamingo_emails');
function export_flamingo_emails()
{
	if (isset($_GET['export_flamingo'])) {
		$args = array(
			'post_type' => 'flamingo_inbound',
			'posts_per_page' => -1,
		);
		$posts = get_posts($args);
		$emails = array();

		foreach ($posts as $post) {
			$email = get_post_meta($post->ID, '_from_email', true);
			if ($email) $emails[] = $email;
		}

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="flamingo-emails.csv"');
		$output = fopen('php://output', 'w');
		fputcsv($output, array('Email'));
		foreach ($emails as $email) {
			fputcsv($output, array($email));
		}
		fclose($output);
		exit;
	}
}
