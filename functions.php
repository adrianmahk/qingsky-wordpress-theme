<?php
/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://developer.wordpress.org/plugins/}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentysixteen_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * Create your own twentysixteen_setup() function to override in a child theme.
	 *
	 * @since Twenty Sixteen 1.0
	 */
	function twentysixteen_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentysixteen
		 * If you're building a theme based on Twenty Sixteen, use a find and replace
		 * to change 'twentysixteen' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'twentysixteen' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for custom logo.
		 *
		 *  @since Twenty Sixteen 1.2
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 240,
				'width'       => 240,
				'flex-height' => true,
			)
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#post-thumbnails
		 */
		// add_theme_support( 'post-thumbnails' );
		// set_post_thumbnail_size( 1200, 9999 );
		// set_post_thumbnail_size( 0, 0 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'twentysixteen' ),
				'social'  => __( 'Social Links Menu', 'twentysixteen' ),
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
				'script',
				'style',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://wordpress.org/support/article/post-formats/
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'status',
				'audio',
				'chat',
			)
		);

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/editor-style.css', twentysixteen_fonts_url() ) );

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom color scheme.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Dark Gray', 'twentysixteen' ),
					'slug'  => 'dark-gray',
					'color' => '#1a1a1a',
				),
				array(
					'name'  => __( 'Medium Gray', 'twentysixteen' ),
					'slug'  => 'medium-gray',
					'color' => '#686868',
				),
				array(
					'name'  => __( 'Light Gray', 'twentysixteen' ),
					'slug'  => 'light-gray',
					'color' => '#e5e5e5',
				),
				array(
					'name'  => __( 'White', 'twentysixteen' ),
					'slug'  => 'white',
					'color' => '#fff',
				),
				array(
					'name'  => __( 'Blue Gray', 'twentysixteen' ),
					'slug'  => 'blue-gray',
					'color' => '#4d545c',
				),
				array(
					'name'  => __( 'Bright Blue', 'twentysixteen' ),
					'slug'  => 'bright-blue',
					'color' => '#007acc',
				),
				array(
					'name'  => __( 'Light Blue', 'twentysixteen' ),
					'slug'  => 'light-blue',
					'color' => '#9adffd',
				),
				array(
					'name'  => __( 'Dark Brown', 'twentysixteen' ),
					'slug'  => 'dark-brown',
					'color' => '#402b30',
				),
				array(
					'name'  => __( 'Medium Brown', 'twentysixteen' ),
					'slug'  => 'medium-brown',
					'color' => '#774e24',
				),
				array(
					'name'  => __( 'Dark Red', 'twentysixteen' ),
					'slug'  => 'dark-red',
					'color' => '#640c1f',
				),
				array(
					'name'  => __( 'Bright Red', 'twentysixteen' ),
					'slug'  => 'bright-red',
					'color' => '#ff675f',
				),
				array(
					'name'  => __( 'Yellow', 'twentysixteen' ),
					'slug'  => 'yellow',
					'color' => '#ffef8e',
				),
			)
		);

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif; // twentysixteen_setup()
add_action( 'after_setup_theme', 'twentysixteen_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'twentysixteen_content_width', 840 );
}
add_action( 'after_setup_theme', 'twentysixteen_content_width', 0 );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Sixteen 1.6
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
// function twentysixteen_resource_hints( $urls, $relation_type ) {
// 	if ( wp_style_is( 'twentysixteen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
// 		$urls[] = array(
// 			'href' => 'https://fonts.gstatic.com',
// 			'crossorigin',
// 		);
// 	}

// 	return $urls;
// }
// add_filter( 'wp_resource_hints', 'twentysixteen_resource_hints', 10, 2 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'twentysixteen' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Content Bottom 1', 'twentysixteen' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Content Bottom 2', 'twentysixteen' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Content Header 1', 'twentysixteen' ),
			'id'            => 'header-1',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Subtitle 1', 'twentysixteen' ),
			'id'            => 'subtitle-1',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title post-title main">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Icons', 'twentysixteen' ),
			'id'            => 'frontpage-1',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title post-title main">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Greetings', 'twentysixteen' ),
			'id'            => 'frontpage-2',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title post-title main">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Popup 1', 'twentysixteen' ),
			'id'            => 'popup-1',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title post-title main">',
			'after_title'   => '</h3>',
		)
	);

	// register_sidebar(
	// 	array(
	// 		'name'          => __( 'Popup 2', 'twentysixteen' ),
	// 		'id'            => 'popup-2',
	// 		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
	// 		'before_widget' => '<section id="%1$s" class="widget %2$s">',
	// 		'after_widget'  => '</section>',
	// 		'before_title'  => '<h3 class="widget-title post-title main">',
	// 		'after_title'   => '</h3>',
	// 	)
	// );

	register_sidebar(
		array(
			'name'          => __( 'Footer 1 (copyright)', 'twentysixteen' ),
			'id'            => 'footer-1',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title post-title main">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'twentysixteen_widgets_init' );

if ( ! function_exists( 'twentysixteen_fonts_url' ) ) :
	/**
	 * Register Google fonts for Twenty Sixteen.
	 *
	 * Create your own twentysixteen_fonts_url() function to override in a child theme.
	 *
	 * @since Twenty Sixteen 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function twentysixteen_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/*
		 * translators: If there are characters in your language that are not supported
		 * by Merriweather, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'twentysixteen' ) ) {
			$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
		}

		/*
		 * translators: If there are characters in your language that are not supported
		 * by Montserrat, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'twentysixteen' ) ) {
			$fonts[] = 'Montserrat:400,700';
		}

		/*
		 * translators: If there are characters in your language that are not supported
		 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentysixteen' ) ) {
			$fonts[] = 'Inconsolata:400';
		}

		// if ( $fonts ) {
		// 	$fonts_url = add_query_arg(
		// 		array(
		// 			'family'  => urlencode( implode( '|', $fonts ) ),
		// 			'subset'  => urlencode( $subsets ),
		// 			'display' => urlencode( 'fallback' ),
		// 		),
		// 		'https://fonts.googleapis.com/css'
		// 	);
		// }

		return $fonts_url;
	}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentysixteen_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	// wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	// wp_enqueue_style( 'twentysixteen-style', get_stylesheet_uri(), array(), '20190507' );
	
	// wp_enqueue_style( 'blog', get_template_directory_uri() . '/css/blog.css', array(), '20190310');
	// wp_enqueue_style( 'styles', get_template_directory_uri() . '/css/styles.css', array( 'blog'));

	// Theme block stylesheet.
	wp_enqueue_style( 'twentysixteen-block-style', get_template_directory_uri() . '/css/blocks.css', array( 'twentysixteen-style' ), '20190102' );
	
	// wp_enqueue_style( 'styles', get_template_directory_uri() . '/css/styles.css', array( 'twentysixteen-style' ), '20190103' );

	// Load the Internet Explorer specific stylesheet.
	// wp_enqueue_style( 'twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentysixteen-style' ), '20170530' );
	// wp_style_add_data( 'twentysixteen-ie', 'conditional', 'lt IE 10' );

	// // Load the Internet Explorer 8 specific stylesheet.
	// wp_enqueue_style( 'twentysixteen-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'twentysixteen-style' ), '20170530' );
	// wp_style_add_data( 'twentysixteen-ie8', 'conditional', 'lt IE 9' );

	// // Load the Internet Explorer 7 specific stylesheet.
	// wp_enqueue_style( 'twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentysixteen-style' ), '20170530' );
	// wp_style_add_data( 'twentysixteen-ie7', 'conditional', 'lt IE 8' );

	// // Load the html5 shiv.
	// wp_enqueue_script( 'twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	// wp_script_add_data( 'twentysixteen-html5', 'conditional', 'lt IE 9' );

	// wp_enqueue_script( 'twentysixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20170530', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		// wp_enqueue_script( 'twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20170530' );
	}

	// wp_enqueue_script( 'twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20181217', true );

	wp_localize_script(
		'twentysixteen-script',
		'screenReaderText',
		array(
			'expand'   => __( 'expand child menu', 'twentysixteen' ),
			'collapse' => __( 'collapse child menu', 'twentysixteen' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'twentysixteen_scripts' );

/**
 * Enqueue styles for the block-based editor.
 *
 * @since Twenty Sixteen 1.6
 */
function twentysixteen_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'twentysixteen-block-editor-style', get_template_directory_uri() . '/css/editor-blocks.css', array(), '20190102' );
	// Add custom fonts.
	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'twentysixteen_block_editor_styles' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function twentysixteen_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	// if ( is_multi_author() ) {
	// 	$classes[] = 'group-blog';
	// }

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_front_page() && !is_paged()) {
		$classes[] = 'home-view';
		// $classes[] = 'home';
	}
	if ( is_home() || is_archive() ) {
		$classes[] = 'blog';
	}
	if ( is_privacy_policy() ) {
		$classes[] = 'privacy-policy';
	}
	if ( is_archive() ) {
		// $classes[] = 'archive';
		// $classes[] = 'archive-view';
	}
	if ( is_date() ) {
		$classes[] = 'archive-view';
	}
	if ( is_search() ) {
		$classes = array_diff($classes, array('search'));
		// $classes[] = 'search';
		// $classes[] = $wp_query->posts ? 'search-results' : 'search-no-results';
	}
	if ( is_singular() ) {
		$classes[] = 'item-view';
	}
	if ( is_single()) {
		$classes[] = 'is-post';
	}

	return $classes;
}
add_filter( 'body_class', 'twentysixteen_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 840 <= $width ) {
		$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
	}

	if ( 'page' === get_post_type() ) {
		if ( 840 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	} else {
		if ( 840 > $width && 600 <= $width ) {
			$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		} elseif ( 600 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	}

	return $sizes;
}
// add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10, 2 );
remove_image_size('1536x1536');
remove_image_size('2048x2048');
remove_image_size('medium_large');
remove_image_size('post-thumbnail');
remove_image_size('scaled');

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function twentysixteen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		} else {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
		}
	}
	return $attr;
}
// add_filter( 'wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentysixteen_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args' );

function update_view_count() {	
	// if (is_home() || is_archive() || is_singular() || is_search() || is_404()) {
	if (is_home() || is_archive() || is_singular()) {
		if (is_user_logged_in()) {
			if (current_user_can( 'edit_post', get_the_ID() )) {
				return;
			}
		}
		if (strpos($_SERVER['HTTP_REFERER'], 'sw.js') > 0) {
			return;
		}

		global $wp;
		global $wpdb;
		
		// Split table
		$view_count_date_table_sql = "CREATE TABLE IF NOT EXISTS `wordpress`.`wp_viewcounts_date` ( `view_count` INT(11) NOT NULL DEFAULT '0', `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , `update_time` TIME NOT NULL DEFAULT CURRENT_TIMESTAMP  , PRIMARY KEY (`date`)) ENGINE = InnoDB";
		$view_count_date_sql = "INSERT INTO `wp_viewcounts_date` (`date`, `update_time`, `view_count`) VALUES(CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1) ON DUPLICATE KEY UPDATE `view_count` = `view_count` + 1, `update_time` = CURRENT_TIMESTAMP";
		
		$view_count_post_table_sql = "CREATE TABLE IF NOT EXISTS `wordpress`.`wp_viewcounts_post` ( `title` TEXT NULL, `post_id` BIGINT(20) NULL, `view_count` INT(11) NOT NULL DEFAULT '0', `is_valid` BOOLEAN NOT NULL DEFAULT TRUE, `url` VARCHAR(255) NOT NULL , `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , `update_time` TIME NOT NULL DEFAULT CURRENT_TIMESTAMP  , PRIMARY KEY (`url`)) ENGINE = InnoDB";
		$view_count_post_sql = "INSERT INTO `wp_viewcounts_post` (`url`, `date`, `update_time`, `view_count`, `is_valid`, `post_id`, `title`) VALUES('". urldecode(home_url($wp->request))."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1, " . (is_404() ? 0 : 1)  . ", " . (is_singular() ?  get_the_ID() : 0) . ", '" . html_entity_decode(wp_get_document_title()) . "') ON DUPLICATE KEY UPDATE `view_count` = `view_count` + 1, `update_time` = CURRENT_TIMESTAMP";
		
		
		// Detailed version (will be purged by cron)
		$view_count_table_sql = "CREATE TABLE IF NOT EXISTS `wordpress`.`wp_viewcounts` ( `title` TEXT NULL, `post_id` BIGINT(20) NULL, `view_count` INT(11) NOT NULL DEFAULT '0', `is_valid` BOOLEAN NOT NULL DEFAULT TRUE, `url` VARCHAR(255) NOT NULL , `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , `update_time` TIME NOT NULL DEFAULT CURRENT_TIMESTAMP  , PRIMARY KEY (`url`, `date`)) ENGINE = InnoDB";
		$view_count_sql = "INSERT INTO `wp_viewcounts` (`post_id`, `post_title`, `post_url`, `view_count`) VALUES(" . get_the_ID() . ", '" . get_the_title() . "', '" . get_permalink() . "', 1) ON DUPLICATE KEY UPDATE `view_count` = `view_count` + 1";

		// User region (not working for now)
		// $user_region = getIpData($_SERVER['REMOTE_ADDR']);
		// $user_region_table_sql = "CREATE TABLE IF NOT EXISTS `wordpress`.`wp_viewcounts_region` ( `region` VARCHAR(255) NOT NULL , `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , `update_time` TIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `view_count` INT(11) NOT NULL , PRIMARY KEY (`region`, `date`)) ENGINE = InnoDB;";
		// $user_region_sql = "INSERT INTO `wp_viewcounts_region` (`region`, `date`, `update_time`, `view_count`) VALUES('". $user_region . "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1) ON DUPLICATE KEY UPDATE `view_count` = `view_count` + 1, `update_time` = CURRENT_TIMESTAMP";

		$wpdb->query( "START TRANSACTION" );
		$wpdb->query($view_count_date_table_sql);
		$wpdb->query($view_count_date_sql);
		$wpdb->query($view_count_post_table_sql);
		$wpdb->query($view_count_post_sql);
		
		$wpdb->query($view_count_table_sql);
		$wpdb->query($view_count_sql);

		// $wpdb->query($user_region_table_sql);
		// $wpdb->query($user_region_sql);
		
		$wpdb->query( "COMMIT" );
	}
}

function getIpData($userIP) {
	// API end URL 
	$apiURL = 'https://freegeoip.app/json/'.$userIP; 
	
	// Create a new cURL resource with URL 
	$ch = curl_init($apiURL); 
	
	// Return response instead of outputting 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	
	// Execute API request 
	$apiResponse = curl_exec($ch); 
	// echo $apiResponse; exit;
	
	// Close cURL resource 
	curl_close($ch); 
	
	// Retrieve IP data from API response 
	$ipData = json_decode($apiResponse, true); 
	
	if(!empty($ipData)){ 
		return $ipData['country_name'];
	}else{ 
	} 
}

function purgeViewCountData() {
	global $wpdb;
	$truncate_sql = "TRUNCATE `wp_viewcounts`";
	$wpdb->query('START TRANSACTION');
	$result = $wpdb->get_results('SELECT * FROM `wp_viewcounts`');
	$wpdb->query($truncate_sql);
	$wpdb->query('COMMIT');
	error_log('Purged '. sizeof($result). ' lines of data from `wp_viewcounts`.');
}

add_shortcode('get_stats', 'get_stats');
function get_stats($atts, $content = null) {
	if (!current_user_can( 'edit_post', get_the_ID() ) || wp_make_link_relative(get_permalink()) != '/stat/') {
	// if (!current_user_can( 'edit_post', get_the_ID() ) ) {
		return;
	}
    extract(shortcode_atts(array(
	'sql' => '',
	'dev' => '',
), $atts)); 
	$servername = "localhost";
	$username = "readonly";
	$password = "123456";
	$dbname = ($dev == '') ?  "wordpress" : "wordpress-dev";
	// die($dbname);
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$sql = html_entity_decode($sql);
	$output = $conn->query($sql);
	$conn->close();
	if ($output->num_rows > 0) {
		// output data of each row
		$keys = null;
		$string = '<style>
		table.stats {

		}
		table.stats td, table.stats th {
			box-shadow: 1px 1px 0px #888;
		}
		td.numbers {
			text-align: right;
		}
		</style><table class="stats" style="white-space: nowrap;">';
		
		
		while($row = $output->fetch_assoc()) {
		
			if (!$keys) {
				$keys = array_keys($row);
				$string .= '<tr>';
				foreach ($keys as $key) {
					$string .= '<th>' . $key. '</th>';
				}
				$string .= '</tr>';
				
			}
			$string .= '<tr>';
			$values = array_values($row);
			foreach ($values as $value) {
				$string .= '<td class="'. (is_numeric($value) ? 'numbers' : '') .  '">' . $value. '</td>';
			}
			$string .= '</tr>';
		}
		$string .= '</table>';
		return $string;
	  }
	  else {
		// echo "0 results";
	  }
}

add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_year' );
function keep_me_logged_in_for_1_year( $expirein ) {
    return YEAR_IN_SECONDS; // 1 year in seconds
}


add_shortcode('user_activation_key', 'user_activation_key2');
function user_activation_key2($atts, $content = null) {
    extract(shortcode_atts(array(
	'id' => '',
	// 'dev' => '',
), $atts)); 
	if ($id) {
		global $wpdb;
		$result = $wpdb->get_results( "SELECT `user_activation_key` FROM `wp_users` WHERE `id` = ". $id );
		if ($result) {
			return $result[0]->user_activation_key;
		}
	}
	return '';
}

function get_last_update($return = false) {
	if (!is_singular()) {
		global $wpdb;
		$sql = "SELECT MAX(GREATEST(`post_date`,`post_modified`)) as `last_update` FROM `wp_posts`";
		$result = $wpdb->get_results($sql);
		if (!empty($result)) {
			if ($return) {
				echo 'last-update="' . $result[0]->last_update .'"';
			}
			else {
				return strtotime($result[0]->last_update);
			}
		}
	}
}


function home_archive_category(&$query) {

	if (is_home() && !is_paged()) {
		$date = strtotime(get_lastpostdate());
		$query->set('monthnum', date('m', $date));
		$query->set('year', date('Y', $date));
	}
	// if ($query->is_home() && !is_paged()) {
	// 	$query->set( 'posts_per_page', 1 );
	// 	return;
	// }
	// define the offset here

	if (!is_single()) {
		$sticky = get_option( 'sticky_posts' );
		$query->set('ignore_sticky_posts', true);
		$query->set('post__not_in', $sticky);
	}

	if ($query->is_category) {

		// echo json_encode($sticky);exit;
		$query->set('ignore_sticky_posts', false);
		$query->set('post__not_in', '');
		$posts = get_posts( array(
			'posts_per_page' => -1,
			'category_name'  => $query->query_vars['category'],
			'fields'         => 'ids'
		) );
		$array =  array_diff(array_merge($sticky,$posts),array_intersect($sticky,$posts));
		$query->set('post__in', $array);
		$query->set('orderby', 'post__in');
		$query->set('order', 'DESC');
	}
	else if ($query->is_date){
		$query->set('posts_per_page', -1);
	// 	echo json_encode($query);
	// exit;
	}
	else if ($query->is_home()) {
		$date = strtotime(get_lastpostdate());
		$posts_last_month = get_posts( array(
			'posts_per_page' => -1,
			'monthnum' => date('m', $date),
			'year' => date('Y', $date),
			'fields' => 'ids'
		) );
		$offset = sizeof($posts_last_month);
		$ppp = get_option('posts_per_page');
		if ( $query->is_paged && !$query->is_tag && !$query->is_category && !$query->is_date && !$query->is_search) {
			$page_offset = $offset + ( ($query->query_vars['paged'] - 2) * $ppp );
			$query->set('offset', $page_offset );
		}
	}
	
}
add_action('pre_get_posts', 'home_archive_category', 1 );

function home_offset($found_posts, $query) {
	// define the offset here
    $offset = 1;
	if ( $query->is_home() ) {
		return $found_posts - $offset;
	}
	return $found_posts;
}
add_filter('found_posts', 'home_offset', 1, 2 );

add_filter( 'posts_search_orderby', function( $search_orderby ) {
	global $wp_query;
	// echo html_entity_decode(json_encode($wp_query));exit;
	// echo $wp_query->query_vars['s'];exit;
	// echo $search_orderby;exit;
	// $search_orderby = " REGEXP_COUNT(`post_content`, ". $wp_query->query_vars['s'] .")";
	$search_orderby = "length(post_content)- length(REPLACE(post_content, '" . $wp_query->query_vars['s'] . "', '')) desc";
	return $search_orderby;
	// echo $search_orderby; exit;
	// return 'relavance';
    // global $wpdb;
    // return "{$wpdb->posts}.post_type LIKE 'profiles' DESC, {$search_orderby}";
    // return "COUNT () {$wpdb->posts}.post_type LIKE 'profiles' DESC, {$search_orderby}";
});

function custom_theme_support() {
	add_theme_support('custom-background', array(
			'default-color'    => '333333',
			'wp-head-callback' => 'custom_background_cb'
	));
}
add_action('after_setup_theme', 'custom_theme_support');
function custom_background_cb() {
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if ( get_theme_support( 'custom-background', 'default-color' ) === $color ) {
		$color = false;
	}

	$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';

	if ( ! $background && ! $color ) {
		if ( is_customize_preview() ) {
			printf( '<style%s id="custom-background-css"></style>', $type_attr );
		}
		return;
	}

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = ' background-image: url("' . esc_url_raw( $background ) . '");';

		// Background Position.
		$position_x = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		$position_y = get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) );

		if ( ! in_array( $position_x, array( 'left', 'center', 'right' ), true ) ) {
			$position_x = 'left';
		}

		if ( ! in_array( $position_y, array( 'top', 'center', 'bottom' ), true ) ) {
			$position_y = 'top';
		}

		$position = " background-position: $position_x $position_y;";

		// Background Size.
		$size = get_theme_mod( 'background_size', get_theme_support( 'custom-background', 'default-size' ) );

		if ( ! in_array( $size, array( 'auto', 'contain', 'cover' ), true ) ) {
			$size = 'auto';
		}

		$size = " background-size: $size;";

		// Background Repeat.
		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

		if ( ! in_array( $repeat, array( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ), true ) ) {
			$repeat = 'repeat';
		}

		$repeat = " background-repeat: $repeat;";

		// Background Scroll.
		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );

		if ( 'fixed' !== $attachment ) {
			$attachment = 'scroll';
		}

		$attachment = " background-attachment: $attachment;";

		$style .= $image . $position . $size . $repeat . $attachment;
	}
	?>
<style<?php echo $type_attr; ?> id="custom-background-css">
.bg-div { <?php echo trim( $style ); ?> }
</style>
	<?php
}

$uploadFolder = null;
function generateThumbnail($src, $thumbWidth = 0) {
	$relativeSrc = preg_replace('/https?:\/\/(www.qingsky.hk|dev.qingsky.hk|localhost:81)/', '', $src);
	$relativeSrc = preg_replace('/\/wp-content\/uploads\/(s\/)?/', '', $relativeSrc);

	global $uploadFolder;
	if (!$uploadFolder) {
		$uploadFolder = (is_link(wp_upload_dir()['basedir'])) ? readlink(wp_upload_dir()['basedir']) : wp_upload_dir()['basedir'];
	}

	if (filter_var($relativeSrc, FILTER_VALIDATE_URL) && $relativeSrc == $src) {
		// is external image, do nothing
		return $src;
	}
	$relativeSrc = preg_replace('/-[0-9]{1,}x[0-9]{1,}(?=\.(gif|jpg|jpeg|png)$)/', '', $relativeSrc);
	// if (preg_match('/(?:\/s)?\/([^\/]*)(?:-[0-9]{1,}x[0-9]{1,})(?:~s([0-9]{1,}))?(\.jpg|\.jpeg|\.png|\.gif)$/', $relativeSrc, $matches)) {
	if (preg_match('/(?:\/s)?\/?([^\/]*(?=~s)|[^\/]*)(?:~s([0-9]{1,}))?(\.jpg|\.jpeg|\.png|\.gif)$/', $relativeSrc, $matches)) {
		// echo $relativeSrc;
		$name = $matches[1];
		$thumbWidth = ($thumbWidth > 0) ? $thumbWidth : $matches[2];
		$type = $matches[3];
		// echo json_encode($matches);
	}
	else {
		// no width variable found in path & not override mode
		return $src;
	}

	if (!isset($name) || !isset($type) || $thumbWidth == 0) {
		//error
		return $src;
	}
	
	$destName = $name . '~s' . $thumbWidth . $type;
	$destPath = $uploadFolder . '/s/'  . $destName;
	$sourcePath = $uploadFolder . '/' .  $name . $type;

	if (file_exists($destPath)) {
		return wp_upload_dir()['baseurl'] . '/s/' . $destName;
	}
	if (!file_exists($sourcePath)) {
		// no file
		return $src;
	}
	else {
		switch (strtolower($type)) {
			case '.jpg':
			case '.jpeg':
				$sourceImage = @imagecreatefromjpeg($sourcePath);
				break;
			case '.gif':
				$sourceImage = @imagecreatefromgif($sourcePath);
				break;
			case '.png':
				$sourceImage = @imagecreatefrompng($sourcePath);
				break;
			case '.bmp':
				$sourceImage = @imagecreatefrombmp($sourcePath);
				break;
		}
		
		if (!$sourceImage) {
			return $src;
		}
		$orgWidth = imagesx($sourceImage);
		$orgHeight = imagesy($sourceImage);
		if ($thumbWidth >= $orgWidth) {
			//nth to do
			return $src;
		}
		$thumbHeight = floor($orgHeight * ($thumbWidth / $orgWidth));
		$destImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
		imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $orgWidth, $orgHeight);
		if (!file_exists( $uploadFolder. '/s')) {
			mkdir( $uploadFolder . '/s');
		}
		imagejpeg($destImage, $destPath);
		imagedestroy($sourceImage);
		imagedestroy($destImage);
		return wp_upload_dir()['baseurl'] . '/s/' . $destName;
	}

}

function clear_br($content) { 
	require_once ($_SERVER['DOCUMENT_ROOT']) . '/wp-content/themes/qingsky-hk' . '/simple_html_dom.php';
	//this requires simplehtmldom
	if (!is_singular()) {
		return $content;
	}

	$html = str_get_html($content, true, true, DEFAULT_TARGET_CHARSET, false);
	if (!$html) {
		return str_replace("<br/>","<br clear='none'/>", $content);
	}

	// for links to work the same on localhost, dev and prod
	// foreach($html->find('a') as $element) {
	// 	// $element->href = str_replace('http://' . $domain, '', str_replace('https://' . $domain, '', $element->href));
	// 	$element->href = preg_replace('/https?:\/\/(www.qingsky.hk|dev.qingsky.hk|localhost:81)/', '', $element->href);
	//  }

	// generate small size imgs and 2x srcset if not exist
	foreach($html->find('a > img') as $element) {
		// echo ($element->parent->tag == 'a' && is_array($element->parent->children) && sizeof($element->parent->children) == 1);
		if ($element->parent->tag == 'a' && is_array($element->parent->children) && sizeof($element->parent->children) == 1) {
			$width = $element->width;
			$src = $element->src;
			$src = generateThumbnail($element->src, ($width > 0) ? $width : 0);
			if ($src != $element->src) {
				$element->src = $src;
				$element->srcset = generateThumbnail($src, ($width > 0) ? $width * 2 : 0) . ' 2x';
			}
		}
	}
	return str_replace("<br/>","<br clear='none'/>", $html);
} 
add_filter('the_content','clear_br');
add_filter('post_thumbnail_html','clear_br');
remove_filter ('the_content', 'wpautop');
// add_shortcode('post_excerpt_custom', 'trim_content_to_excerpts');
function trim_content_to_excerpts($text) {
	$post = get_post();
	$content = $post->post_content;
	return substr($content, 0, custom_excerpt_length(0));
	// return '';
	// return str_replace(' ', '<br />', $text);
}

function custom_excerpt_length( $length ) {
	$post = get_post();
	$limit = strpos($post->post_content, '<!--more-->');
	if ($limit > 0) {
		return $limit;
	}
	$len = strlen(utf8_decode($post->post_content));
	if ($len < 500) {
		return $len - 1;
	}
    return 500;
}
remove_filter( 'the_excerpt', 'wpautop' );
remove_filter( 'the_excerpt', 'wp_trim_excerpt' );
add_filter( 'the_excerpt', 'trim_content_to_excerpts' );
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


function search_distinct() {
	return "DISTINCT";
}
add_filter('posts_distinct', 'search_distinct');



add_filter( 'manage_post_posts_columns', 'set_custom_edit_mycpt_columns', 10 );
function set_custom_edit_mycpt_columns( $columns = null ) {
  $columns['view_count'] = __( 'Views', '' );
  return $columns;
}

add_action( 'manage_post_posts_custom_column' , 'custom_mycpt_column', 9, 2 );
function custom_mycpt_column( $column, $post_id ) {
  global $wpdb;
  $result = $wpdb->get_col("SELECT `view_count` FROM `wp_stats_bypost` WHERE `post_id` = ". $post_id. "");
//   echo json_encode($result);
  switch ( $column ) {
    // display a thumbnail photo
    case 'view_count' :
      echo empty($result) ? 0 : $result[0];
      break;

  }
}
add_filter( 'manage_edit-post_sortable_columns', 'set_custom_mycpt_sortable_columns' );
function set_custom_mycpt_sortable_columns( $columns ) {
  $columns['view_count'] = 'view_count';

  return $columns;
}
add_filter( 'request', 'city_column_orderby');
function city_column_orderby( $vars ) {
	// die(json_encode($vars));
	// global $wpdb;
  	// $result = $wpdb->get_col("SELECT `view_count` FROM `wp_stats_bypost` WHERE `post_id` = ". $post_id. "");
	if ( isset( $vars['orderby'] ) && $vars['orderby'] == 'view_count' ) {
		$vars = array_merge( $vars, array(
			
			'meta_key' => 'view_count',
			// 'meta_value' => "",
			// 'meta_compare' => 'exists',
			// 'orderby' => 'view_count', // does not work
			'orderby' => 'meta_key', // does not work
			// 'orderby' => 'post_mime_type',
			// 'orderby' => 'relavance',
			// 'meta_type' => 'NUMERIC',
			
			//'order' => 'asc' // don't use this; blocks toggle UI
		) );
	}
	return $vars;
}

add_action( 'post_updated', 'aaaaa', 10, 3 );
function aaaaa ($new_status, $old_status, $post ) {
	// die($post);
}

// Page Elements


function page_list(){
	return [
		[
			'name' => '網誌', 'href' => '/'
		],
		[
			'name' => '散文', 'href' => '/category/散文'
		],
		[
			'name' => '隨筆', 'href' => '/category/隨筆'
		],
		[
			'name' => '小說', 'href' => '/category/小說'
		],
		[
			'name' => '精選', 'href' => '/category/精選'
		],
		[
			'name' => '世界觀', 'href' => '/category/世界觀'
		],
		[
			'name' => '每月主題', 'href' => '/category/每月主題'
		],
		[
			'name' => '所有文章', 'href' => '/allposts'
		],
		[
			'name' => '關於本站', 'href' => '/about'
		],
	];
}

function get_page_list($array = [], $id = '') {
	$tabs =
		'<div class="widget PageList" data-version="2" id="'. $id . '">' . 
		'<div class="widget-content">' . 
		'<div class="label-all-container">' .
		'<div class="label-container-shadow" id="label-container-shadow"></div>' .
		'<div class="label-container" id="label-container" onscroll="drawButtonsShadow()">' .
		'<ul class="tabs">'
	;
	foreach ($array as $item) {
		
		// echo $_SERVER['REQUEST_URI'];
		$selected = false;
		if (($item['href'] == '/') && ((is_home() && !is_paged()) || (!is_single() && get_query_var('year'))) ) {
			$selected = true;
		}
		else if (get_query_var('category_name')) {
			$tag = get_query_var('category_name');
			if (urldecode($tag) == $item['name']) {
				$selected = true;
			}
		}
		else if ($item['href'] == wp_make_link_relative(get_permalink()) || $item['href'] . '/' == wp_make_link_relative(get_permalink()) || $item['href']  == wp_make_link_relative(get_permalink()). '/') {
			$selected = true;
		}
		$tabs .= '<a href='. $item['href'] . '>';
		$tabs .= '<li class="pill-button ripple label-item' . ($selected ? ' selected' : '') . '">' . $item['name'] .'</li>';
		// else if () {

		// }
		$tabs .= '</a> ';

		// $tabs .= '<li class="pill-button ripple label-item' . ($selected ? ' selected' : '') . '">';
		// // else if () {

		// // }
		// $tabs .= '<a href='. $item['href'] . '>' . $item['name'] .' </a>';
		// $tabs .= '</li>';
	}

	$tabs .=
		'</ul>' .
		'</div>' . 
		'</div>' . 
		'</div>' . 
		'</div>';

	$tabs .=
	'<script type="text/javascript">scrollToSelected();</script>';

	return $tabs;
}

function post_filter_message() {
	$h3 = '<h3 class="page-title post-title main">';
	// $div = '<div class="post-filter-message"><div>';
	
	$tag_msg = '<div class="post-filter-message"><div>目前顯示的是有「<span class="search-label">%1$s</span>」標籤的文章</div><div><a class="flat-button ripple" href="%2$s" target="_blank" title="查找所有文章">%3$s</a></div></div>';
	$archive_msg = '<div class="post-filter-message"><div>目前顯示的是 %1$s 的文章</div><div><a class="flat-button ripple" href="%2$s" target="_blank" title="查找所有文章">%3$s</a></div></div>';
	if (is_front_page() && !is_paged()) {
		echo $h3;
		echo '最新文章';
		echo '</h3>';
	}
	// else if (is_tag() || is_category()) {
	// 	echo $h3;
	// 	$name = is_tag() ? single_tag_title() : single_cat_title();
	// 	echo $name;
	// 	echo '</h3>';
	// 	// echo '<div class="post-filter-message"><div>目前顯示的是有「<span class="search-label">散文</span>」標籤的文章</div><div><a class="flat-button ripple" href="/p/allposts.html#tags" target="_blank" title="查找所有文章">標籤列表</a></div></div>';
	// 	printf($tag_msg, $name, '/allposts#tags', '標籤列表');
	// }
	else if (get_query_var('tag') || get_query_var('category_name')) {
		echo $h3;
		$name = get_query_var('tag') ? get_query_var('tag') : get_query_var('category_name');
		$tag = get_term_by('slug', $name, get_query_var('tag') ? 'tag' : 'category');
		if ($tag) {
			$name = $tag->name;
		}
		// echo $name;
		echo urldecode($name);
		echo '</h3>';
		// echo '<div class="post-filter-message"><div>目前顯示的是有「<span class="search-label">散文</span>」標籤的文章</div><div><a class="flat-button ripple" href="/p/allposts.html#tags" target="_blank" title="查找所有文章">標籤列表</a></div></div>';
		printf($tag_msg, urldecode($name), '/allposts/#tags', '標籤列表');
	}
	else if (get_query_var('year')) {
		$year = get_query_var('year');
		$month = get_query_var('monthnum');
		if ($month) {
			$month_name = array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '十一', '十二');
			$month_str = $month_name[$month - 1] . '月, ';
		}

		echo $h3;
		echo ($year ? ($year . ' 年 ') : '') . ($month ? ($month . ' 月 '): '') . (get_query_var('date') ? get_query_var('date') : '');
		echo '<a class="pill-button ripple" href="/allposts/#archive" onclick="togglePopupArchive(' . $year  . ' ,' . $month . '); return false;" style="font-size: 12px; margin: -1px" title="選擇其他月份">選擇</a>';
		echo '</h3>';
	
		echo '<div class="post-filter-message"><div>目前顯示的是 '. $month_str . $year.' 的文章</div><div><a class="flat-button ripple" href="/allposts/#archive" target="_blank" title="查找所有文章">文章列表</a></div></div>';
	}
}

function subscribe_msg($in_post = false) {
	if (!$in_post) {
		echo '<div class="subscribe-message-container blog-pager">';
	}
	echo '<div class="subscribe-message">';
	if ($in_post) {
		echo '<hr />';
	}
	echo '<em>請支持自由創作者，如果喜歡可以<a href="/about/#subscribe" target="_blank">訂閱本站</a>、分享給好友及留言，也可以<a href="/about/#subscribe" target="_blank">按這裡支持作者</a>，你的支持將會給我很大的鼓勵，謝謝～</em>
		</div>';
	if (!$in_post) {
		echo '</div>';
	}
}

function blog_pager($show_subscribe_msg = true) {
	// echo '' . (get_query_var( 'paged' ) * get_query_var('posts_per_page') + 1);
	echo '<div class="blog-pager container widget" id="blog-pager">';
	if ($show_subscribe_msg) {
		subscribe_msg();
	}
	// echo '<div class="blog-pager">';
	$button = '<a class="pill-button ripple %1$s" href="%2$s" id="blog-pager-older-link" title="較舊的文章">%3$s</a>';
	$svg = '<svg class="svg-icon-pagination" height="14px" version="1.1" viewBox="0 0 18 14" width="18px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
		<path d="M1.027 5.332 C0.574 5.481 5.909 13.728 6.433 13.98 7.082 14.294 7.982 14.361 8.595 13.98 8.949 13.76 13.907 5.746 14 5.332 14.026 5.217 11.198 5.123 10.757 5.332 10.392 5.505 8.021 9.656 7.514 9.656 7.132 9.657 4.6 5.548 4.27 5.332 3.667 4.938 1.712 5.108 1.027 5.332 Z" fill="#646464" fill-opacity="1" id="Path-copy-1" stroke="none"></path>
		<path d="M1 5 C0.581 5.137 5.515 12.766 6 13 6.6 13.29 7.434 13.352 8 13 8.328 12.796 12.914 5.383 13 5 13.024 4.894 10.408 4.807 10 5 9.663 5.159 7.469 8.999 7 9 6.647 9.001 4.305 5.2 4 5 3.442 4.635 1.633 4.792 1 5 Z" fill="#ffffff" fill-opacity="1" id="Path-copy" stroke="none"></path>
		</svg>';
	// printf("%1d, %2d, %3d, %4d", is_home(), is_front_page(), is_paged(), is_date()); 
	if (is_home() && !is_paged() && !is_date()) {
		$date = strtotime(get_lastpostdate());
		$month = date('m', $date);
		$year = date('Y', $date);
		if (!$month) {
			$year = $year - 1;
			// printf($button, 'ajax-load', '/' . $year , $svg . ' 更多文章');
		}
		else {
			switch ($month) {
				case 1:
					$month = '12';
					$year = $year - 1;
					break;
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
				case 8: 
				case 9:
				case 10:
					$month = strval(('0' . $month - 1));
					break;
				break;
				case 11:
				case 12:
					$month = '' . $month - 1;
					break;
			}
			// printf($button, 'ajax-load', '/' . $year . '/' . (string) $month, $svg . ' 更多文章');
		}
		$path =  '/' . $year . '/' . $month . '/';

		printf($button, 'ajax-load', $path, $svg . ' 更多文章');
	}
	else if (get_query_var('year')) {
		// $path = paginate_links(['type' => 'array']);
		$year = get_query_var("year");
		$month = get_query_var("monthnum");
		if (!$month) {
			$year = $year - 1;
			printf($button, 'ajax-load', '/' . $year . '/' , $svg . ' 更多文章');
		}
		else {
			switch ($month) {
				case 1:
					$month = '12';
					$year = $year - 1;
					break;
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
				case 8: 
				case 9:
				case 10:
					$month = strval(('0' . $month - 1));
					break;
				break;
				case 11:
				case 12:
					$month = '' . $month - 1;
					break;
			}
			printf($button, 'ajax-load', '/' . $year . '/' . (string) $month . '/', $svg . ' 更多文章');
		}
	}
	else {
		printf($button, 'ajax-load', get_next_posts_page_link(), $svg . ' 更多文章');
	}
	// echo '</div>';
	echo '</div>';
}

function postTags() {
	// $tags = wp_get_post_categories(get_the_ID());
	$tags = get_the_category(get_the_ID());
	// echo json_encode($tags); exit;
	if (!empty($tags)) {
		echo '<ul class="tabs inpost">';
		foreach ($tags as $tag) {
			// echo $tag->slug;
			printf('<a href="%1$s" title="更多「%2$s」的文章"><li class="pill-button ripple">%2$s</li></a>', '/category/' . $tag->slug, $tag->name);
		}
		echo '</ul>';
	}

	
}

function blog_search() {
	echo '<div class="widget BlogSearch" data-version="2" id="BlogSearch1">
	<div class="widget-content" role="search">
			<form role="search" method="get" id="searchform" class="searchform" action="'. esc_url(home_url( '/' ) ) .'">
					<div class="search-input">
						<input class="seach-input" type="text" placeholder="搜尋此網誌" value="'. get_search_query() . '" name="s" id="s" />
					</div>
					<input class="search-action flat-button" type="submit" id="searchsubmit" value="' . esc_attr_x( 'Search', 'submit button' ) . '" />
				</form>
				</div>
				</div>';
}

function share_button() {
	echo '<script>
	function copyLink(link) {
	var dummy = document.createElement("input"), text = link;
		document.body.appendChild(dummy);
		dummy.value = text;
		dummy.select();
		document.execCommand("copy");
		document.body.removeChild(dummy);
	}</script>
	<div style="display:block;" title="分享">
			<div class="post-share-buttons post-share-buttons-top">
				<button
					aria-controls="sharing-popup-Blog1-byline-2928964363418182385"
					aria-label="分享"
					class="sharing-button touch-icon-button"
					id="sharing-button"
					role="button" aria-expanded="false"
					aria-haspopup="true"
					onclick="copyLink(\''. urldecode(get_permalink()) .'\');showPopupMessage(\'已複製鏈結至剪貼簿\')">
					<div class="flat-icon-button ripple">
					<svg class="svg-icon-24 touch-icon sharing-link" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M172.5 131.1C228.1 75.51 320.5 75.51 376.1 131.1C426.1 181.1 433.5 260.8 392.4 318.3L391.3 319.9C381 334.2 361 337.6 346.7 327.3C332.3 317 328.9 297 339.2 282.7L340.3 281.1C363.2 249 359.6 205.1 331.7 177.2C300.3 145.8 249.2 145.8 217.7 177.2L105.5 289.5C73.99 320.1 73.99 372 105.5 403.5C133.3 431.4 177.3 435 209.3 412.1L210.9 410.1C225.3 400.7 245.3 404 255.5 418.4C265.8 432.8 262.5 452.8 248.1 463.1L246.5 464.2C188.1 505.3 110.2 498.7 60.21 448.8C3.741 392.3 3.741 300.7 60.21 244.3L172.5 131.1zM467.5 380C411 436.5 319.5 436.5 263 380C213 330 206.5 251.2 247.6 193.7L248.7 192.1C258.1 177.8 278.1 174.4 293.3 184.7C307.7 194.1 311.1 214.1 300.8 229.3L299.7 230.9C276.8 262.1 280.4 306.9 308.3 334.8C339.7 366.2 390.8 366.2 422.3 334.8L534.5 222.5C566 191 566 139.1 534.5 108.5C506.7 80.63 462.7 76.99 430.7 99.9L429.1 101C414.7 111.3 394.7 107.1 384.5 93.58C374.2 79.2 377.5 59.21 391.9 48.94L393.5 47.82C451 6.731 529.8 13.25 579.8 63.24C636.3 119.7 636.3 211.3 579.8 267.7L467.5 380z"/></svg>
					</div>
				</button>
			</div>
		</div>';
}

add_shortcode('blog_archive', 'blog_archive');
function blog_archive() {
	global $wpdb;
	// $echo = '<blockquote>';
	$echo = '';
	$echo .= '<div id="ArchiveList">';
	$echo .= '<div id="BlogArchive2_ArchiveList">';
	// $echo .= '<ul class="nzcaNewsList">';
    
    
    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date)
                            FROM $wpdb->posts
                            WHERE post_status = 'publish'
                            AND post_type = 'post'
                            ORDER BY post_date DESC");
	foreach($years as $year) {
		$echo .= '<ul>';//<span class="postArrowUp"></span><a class="postYear" href="#">' . $year . '</a>
		$months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date)
								FROM $wpdb->posts
								WHERE post_status = 'publish'
								AND post_type = 'post'
								AND YEAR(post_date) = '".$year."'
								ORDER BY post_date DESC");
		foreach($months as $month) {
			$echo .= '<li><a href="'. get_month_link($year , $month) .'">' .$year . ' 年 ' . $month . ' 月</a>
				<ul>';
				$days = $wpdb->get_col("SELECT ID
								FROM $wpdb->posts
								WHERE post_status = 'publish'
								AND post_type = 'post'
								AND MONTH(post_date) = '".$month."'                                             
								AND YEAR(post_date) = '".$year."'
								ORDER BY post_date DESC");
				foreach($days as $day) {
					$echo .= '<li><a href="'. get_permalink( $day ) . '">' . get_the_title( $day ) . '</a></li>';
				}
			$echo .= '</ul>';
			// $echo .= '</ul></li>';
		}
    	$echo .= '</ul>';
	}
	// $echo .= '</ul>';
	$echo .= '</div>';
	$echo .= '</div>';
	// $echo .= '</blockquote>';
	return $echo;
}




function a() {
	return 'a';
}
// remove_all_filters('wp_get_document_title');

function comment_form2( $args = array(), $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	// Exit the function when comments for the post are closed.
	if ( ! comments_open( $post_id ) ) {
		/**
		 * Fires after the comment form if comments are closed.
		 *
		 * @since 3.0.0
		 */
		do_action( 'comment_form_comments_closed' );

		return;
	}

	$commenter     = wp_get_current_commenter();
	$user          = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$args = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	}

	$req      = get_option( 'require_name_email' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = 'html5' === $args['format'];

	$fields = array(
		'author' => sprintf(
			'<p class="comment-form-author">%s %s</p>',
			sprintf(
				'<label for="author">%s%s</label>',
				__( 'Name' ),
				( $req ? ' <span class="required">*</span>' : '' )
			),
			sprintf(
				'<input id="author" name="author" type="text" value="%s" size="30" maxlength="245"%s />',
				esc_attr( $commenter['comment_author'] ),
				$html_req
			)
		),
		'email'  => sprintf(
			'<p class="comment-form-email">%s %s</p>',
			sprintf(
				'<label for="email">%s%s</label>',
				__( 'Email' ),
				( $req ? ' <span class="required">*</span>' : '' )
			),
			sprintf(
				'<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
				( $html5 ? 'type="email"' : 'type="text"' ),
				esc_attr( $commenter['comment_author_email'] ),
				$html_req
			)
		),
		'url'    => sprintf(
			'<p class="comment-form-url">%s %s</p>',
			sprintf(
				'<label for="url">%s</label>',
				__( 'Website' )
			),
			sprintf(
				'<input id="url" name="url" %s value="%s" size="30" maxlength="200" />',
				( $html5 ? 'type="url"' : 'type="text"' ),
				esc_attr( $commenter['comment_author_url'] )
			)
		),
	);

	if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
		$consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

		$fields['cookies'] = sprintf(
			'<p class="comment-form-cookies-consent">%s %s</p>',
			sprintf(
				'<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />',
				$consent
			),
			sprintf(
				'<label for="wp-comment-cookies-consent">%s</label>',
				__( 'Save my name, email, and website in this browser for the next time I comment.' )
			)
		);

		// Ensure that the passed fields include cookies consent.
		if ( isset( $args['fields'] ) && ! isset( $args['fields']['cookies'] ) ) {
			$args['fields']['cookies'] = $fields['cookies'];
		}
	}

	$required_text = sprintf(
		/* translators: %s: Asterisk symbol (*). */
		' ' . __( 'Required fields are marked %s' ),
		'<span class="required">*</span>'
	);

	/**
	 * Filters the default comment form fields.
	 *
	 * @since 3.0.0
	 *
	 * @param string[] $fields Array of the default comment fields.
	 */
	$fields = apply_filters( 'comment_form_default_fields', $fields );

	$defaults = array(
		'fields'               => $fields,
		'comment_field'        => sprintf(
			'<p class="comment-form-comment">%s %s</p>',
			sprintf(
				'<label for="comment">%s</label>',
				_x( 'Comment', 'noun' )
			),
			'<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>'
		),
		'must_log_in'          => sprintf(
			'<p class="must-log-in">%s</p>',
			sprintf(
				/* translators: %s: Login URL. */
				__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
				/** This filter is documented in wp-includes/link-template.php */
				wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
			)
		),
		'logged_in_as'         => sprintf(
			'<p class="logged-in-as">%s</p>',
			sprintf(
				/* translators: 1: Edit user link, 2: Accessibility text, 3: User name, 4: Logout URL. */
				__( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>' ),
				get_edit_user_link(),
				/* translators: %s: User name. */
				esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.' ), $user_identity ) ),
				$user_identity,
				/** This filter is documented in wp-includes/link-template.php */
				wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
			)
		),
		'comment_notes_before' => sprintf(
			'<p class="comment-notes">%s%s</p>',
			sprintf(
				'<span id="email-notes">%s</span>',
				__( 'Your email address will not be published.' )
			),
			( $req ? $required_text : '' )
		),
		'comment_notes_after'  => '',
		'action'               => site_url( '/wp-comments-post.php' ),
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'class_form'           => 'comment-form',
		'class_submit'         => 'submit',
		'name_submit'          => 'submit',
		'title_reply'          => __( 'Leave a Reply' ),
		/* translators: %s: Author of the comment being replied to. */
		'title_reply_to'       => __( 'Leave a Reply to %s' ),
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h3>',
		'cancel_reply_before'  => ' <small>',
		'cancel_reply_after'   => '</small>',
		'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => __( 'Post Comment' ),
		'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
		'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
		'format'               => 'xhtml',
	);

	/**
	 * Filters the comment form default arguments.
	 *
	 * Use {@see 'comment_form_default_fields'} to filter the comment fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $defaults The default comment form arguments.
	 */
	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	// Ensure that the filtered args contain all required default values.
	$args = array_merge( $defaults, $args );

	// Remove `aria-describedby` from the email field if there's no associated description.
	if ( isset( $args['fields']['email'] ) && false === strpos( $args['comment_notes_before'], 'id="email-notes"' ) ) {
		$args['fields']['email'] = str_replace(
			' aria-describedby="email-notes"',
			'',
			$args['fields']['email']
		);
	}

	/**
	 * Fires before the comment form.
	 *
	 * @since 3.0.0
	 */
	do_action( 'comment_form_before' );
	?>
	<div id="respond" class="comment-respond">
		<?php
		echo $args['title_reply_before'];

		comment_form_title( $args['title_reply'], $args['title_reply_to'] );

		echo $args['cancel_reply_before'];

		cancel_comment_reply_link( $args['cancel_reply_link'] );

		echo $args['cancel_reply_after'];

		echo $args['title_reply_after'];

		if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) :

			echo $args['must_log_in'];
			/**
			 * Fires after the HTML-formatted 'must log in after' message in the comment form.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_must_log_in_after' );

		else :

			printf(
				'<form action="%s" method="post" id="%s" class="%s"%s>',
				esc_url( $args['action'] ),
				esc_attr( $args['id_form'] ),
				esc_attr( $args['class_form'] ),
				( $html5 ? ' novalidate' : '' )
			);

			/**
			 * Fires at the top of the comment form, inside the form tag.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_top' );

			
			
			$submit_button = sprintf(
				$args['submit_button'],
				esc_attr( $args['name_submit'] ),
				esc_attr( $args['id_submit'] ),
				esc_attr( $args['class_submit'] ),
				esc_attr( $args['label_submit'] )
			);

			/**
			 * Filters the submit button for the comment form to display.
			 *
			 * @since 4.2.0
			 *
			 * @param string $submit_button HTML markup for the submit button.
			 * @param array  $args          Arguments passed to comment_form().
			 */
			$submit_button = apply_filters( 'comment_form_submit_button', $submit_button, $args );

			$submit_field = sprintf(
				$args['submit_field'],
				$submit_button,
				get_comment_id_fields( $post_id )
			);

			/**
			 * Filters the submit field for the comment form to display.
			 *
			 * The submit field includes the submit button, hidden fields for the
			 * comment form, and any wrapper markup.
			 *
			 * @since 4.2.0
			 *
			 * @param string $submit_field HTML markup for the submit field.
			 * @param array  $args         Arguments passed to comment_form().
			 */
			// echo apply_filters( 'comment_form_submit_field', $submit_field, $args );

			// Prepare an array of all fields, including the textarea.
			$comment_fields = array( 'comment' => $args['comment_field'] ) + (array) $args['fields'];

			/**
			 * Filters the comment form fields, including the textarea.
			 *
			 * @since 4.4.0
			 *
			 * @param array $comment_fields The comment fields.
			 */
			$comment_fields = apply_filters( 'comment_form_fields', $comment_fields );

			// Get an array of field names, excluding the textarea.
			$comment_field_keys = array_diff( array_keys( $comment_fields ), array( 'comment' ) );

			// Get the first and the last field name, excluding the textarea.
			$first_field = reset( $comment_field_keys );
			$last_field  = end( $comment_field_keys );

			foreach ( $comment_fields as $name => $field ) {

				if ( 'comment' === $name ) {

					/**
					 * Filters the content of the comment textarea field for display.
					 *
					 * @since 3.0.0
					 *
					 * @param string $args_comment_field The content of the comment textarea field.
					 */
					// echo '<div id="commentBodyField-container">';
					echo apply_filters( 'comment_form_field_comment', $field );

					echo $args['comment_notes_after'];
					
					// echo apply_filters( 'comment_form_submit_field', $submit_field, $args );
					// echo '</div>';
				} elseif ( ! is_user_logged_in() ) {

					if ( $first_field === $name ) {
						/**
						 * Fires before the comment fields in the comment form, excluding the textarea.
						 *
						 * @since 3.0.0
						 */
						do_action( 'comment_form_before_fields' );
					}

					/**
					 * Filters a comment form field for display.
					 *
					 * The dynamic portion of the filter hook, `$name`, refers to the name
					 * of the comment form field. Such as 'author', 'email', or 'url'.
					 *
					 * @since 3.0.0
					 *
					 * @param string $field The HTML-formatted output of the comment form field.
					 */
					echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";

					if ( $last_field === $name ) {
						/**
						 * Fires after the comment fields in the comment form, excluding the textarea.
						 *
						 * @since 3.0.0
						 */
						do_action( 'comment_form_after_fields' );
					}
				}
			}
			if ( is_user_logged_in() ) :

				/**
				 * Filters the 'logged in' message for the comment form for display.
				 *
				 * @since 3.0.0
				 *
				 * @param string $args_logged_in The logged-in-as HTML-formatted message.
				 * @param array  $commenter      An array containing the comment author's
				 *                               username, email, and URL.
				 * @param string $user_identity  If the commenter is a registered user,
				 *                               the display name, blank otherwise.
				 */
				echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );

				/**
				 * Fires after the is_user_logged_in() check in the comment form.
				 *
				 * @since 3.0.0
				 *
				 * @param array  $commenter     An array containing the comment author's
				 *                              username, email, and URL.
				 * @param string $user_identity If the commenter is a registered user,
				 *                              the display name, blank otherwise.
				 */
				do_action( 'comment_form_logged_in_after', $commenter, $user_identity );

			else :

				echo $args['comment_notes_before'];

			endif;
			echo apply_filters( 'comment_form_submit_field', $submit_field, $args );

			

			/**
			 * Fires at the bottom of the comment form, inside the closing form tag.
			 *
			 * @since 1.5.0
			 *
			 * @param int $post_id The post ID.
			 */
			do_action( 'comment_form', $post_id );

			echo '</form>';

		endif;
		?>
	</div><!-- #respond -->
	<?php

	/**
	 * Fires after the comment form.
	 *
	 * @since 3.0.0
	 */
	do_action( 'comment_form_after' );
}


?>


