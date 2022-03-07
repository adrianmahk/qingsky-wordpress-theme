<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
function body_class2( $class = '' ) {
	// Separates class names with a single space, collates class names for body element.
	echo 'class="' . join( ' ', get_body_class2( $class ) ) . '"';
}

function get_body_class2( $class = '' ) {
	global $wp_query;

	$classes = array();

	if ( is_rtl() ) {
		$classes[] = 'rtl';
	}

	if ( is_front_page() && !is_paged()) {
		$classes[] = 'home-view';
		// $classes[] = 'home';
	}
	if ( is_home() ) {
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
		$classes[] = 'search';
		$classes[] = $wp_query->posts ? 'search-results' : 'search-no-results';
	}
	if ( is_paged() ) {
		$classes[] = 'paged';
	}
	if ( is_attachment() ) {
		$classes[] = 'attachment';
	}
	if ( is_404() ) {
		$classes[] = 'error404';
	}

	if ( is_singular() ) {
		$post_id   = $wp_query->get_queried_object_id();
		$post      = $wp_query->get_queried_object();
		$post_type = $post->post_type;

		if ( is_page_template() ) {
			$classes[] = "{$post_type}-template";

			$template_slug  = get_page_template_slug( $post_id );
			$template_parts = explode( '/', $template_slug );

			foreach ( $template_parts as $part ) {
				$classes[] = "{$post_type}-template-" . sanitize_html_class( str_replace( array( '.', '/' ), '-', basename( $part, '.php' ) ) );
			}
			$classes[] = "{$post_type}-template-" . sanitize_html_class( str_replace( '.', '-', $template_slug ) );
		} else {
			$classes[] = "{$post_type}-template-default";
		}

		if ( is_single() ) {
			$classes[] = 'item-view';
			if ( isset( $post->post_type ) ) {
				$classes[] = 'single-' . sanitize_html_class( $post->post_type, $post_id );
				$classes[] = 'postid-' . $post_id;

				// Post Format.
				if ( post_type_supports( $post->post_type, 'post-formats' ) ) {
					$post_format = get_post_format( $post->ID );

					if ( $post_format && ! is_wp_error( $post_format ) ) {
						$classes[] = 'single-format-' . sanitize_html_class( $post_format );
					} else {
						$classes[] = 'single-format-standard';
					}
				}
			}
		}

		if ( is_attachment() ) {
			$mime_type   = get_post_mime_type( $post_id );
			$mime_prefix = array( 'application/', 'image/', 'text/', 'audio/', 'video/', 'music/' );
			$classes[]   = 'attachmentid-' . $post_id;
			$classes[]   = 'attachment-' . str_replace( $mime_prefix, '', $mime_type );
		} elseif ( is_page() ) {
			$classes[] = 'page';

			$page_id = $wp_query->get_queried_object_id();

			$post = get_post( $page_id );

			$classes[] = 'page-id-' . $page_id;

			if ( get_pages(
				array(
					'parent' => $page_id,
					'number' => 1,
				)
			) ) {
				$classes[] = 'page-parent';
			}

			if ( $post->post_parent ) {
				$classes[] = 'page-child';
				$classes[] = 'parent-pageid-' . $post->post_parent;
			}
		}
	} elseif ( is_archive() ) {
		if ( is_post_type_archive() ) {
			$classes[] = 'post-type-archive';
			$post_type = get_query_var( 'post_type' );
			if ( is_array( $post_type ) ) {
				$post_type = reset( $post_type );
			}
			$classes[] = 'post-type-archive-' . sanitize_html_class( $post_type );
		} elseif ( is_author() ) {
			$author    = $wp_query->get_queried_object();
			$classes[] = 'author';
			if ( isset( $author->user_nicename ) ) {
				$classes[] = 'author-' . sanitize_html_class( $author->user_nicename, $author->ID );
				$classes[] = 'author-' . $author->ID;
			}
		} elseif ( is_category() ) {
			$cat       = $wp_query->get_queried_object();
			$classes[] = 'category';
			if ( isset( $cat->term_id ) ) {
				$cat_class = sanitize_html_class( $cat->slug, $cat->term_id );
				if ( is_numeric( $cat_class ) || ! trim( $cat_class, '-' ) ) {
					$cat_class = $cat->term_id;
				}

				$classes[] = 'category-' . $cat_class;
				$classes[] = 'category-' . $cat->term_id;
			}
		} elseif ( is_tag() ) {
			$tag       = $wp_query->get_queried_object();
			$classes[] = 'tag';
			if ( isset( $tag->term_id ) ) {
				$tag_class = sanitize_html_class( $tag->slug, $tag->term_id );
				if ( is_numeric( $tag_class ) || ! trim( $tag_class, '-' ) ) {
					$tag_class = $tag->term_id;
				}

				$classes[] = 'tag-' . $tag_class;
				$classes[] = 'tag-' . $tag->term_id;
			}
		} elseif ( is_tax() ) {
			$term = $wp_query->get_queried_object();
			if ( isset( $term->term_id ) ) {
				$term_class = sanitize_html_class( $term->slug, $term->term_id );
				if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
					$term_class = $term->term_id;
				}

				$classes[] = 'tax-' . sanitize_html_class( $term->taxonomy );
				$classes[] = 'term-' . $term_class;
				$classes[] = 'term-' . $term->term_id;
			}
		}
	}

	if ( is_user_logged_in() ) {
		$classes[] = 'logged-in';
	}

	if ( is_admin_bar_showing() ) {
		$classes[] = 'admin-bar';
		$classes[] = 'no-customize-support';
	}

	if ( current_theme_supports( 'custom-background' )
		&& ( get_background_color() !== get_theme_support( 'custom-background', 'default-color' ) || get_background_image() ) ) {
		$classes[] = 'custom-background';
	}

	if ( has_custom_logo() ) {
		$classes[] = 'wp-custom-logo';
	}

	if ( current_theme_supports( 'responsive-embeds' ) ) {
		$classes[] = 'wp-embed-responsive';
	}

	$page = $wp_query->get( 'page' );

	if ( ! $page || $page < 2 ) {
		$page = $wp_query->get( 'paged' );
	}

	if ( $page && $page > 1 && ! is_404() ) {
		$classes[] = 'paged-' . $page;

		if ( is_single() ) {
			$classes[] = 'single-paged-' . $page;
		} elseif ( is_page() ) {
			$classes[] = 'page-paged-' . $page;
		} elseif ( is_category() ) {
			$classes[] = 'category-paged-' . $page;
		} elseif ( is_tag() ) {
			$classes[] = 'tag-paged-' . $page;
		} elseif ( is_date() ) {
			$classes[] = 'date-paged-' . $page;
		} elseif ( is_author() ) {
			$classes[] = 'author-paged-' . $page;
		} elseif ( is_search() ) {
			$classes[] = 'search-paged-' . $page;
		} elseif ( is_post_type_archive() ) {
			$classes[] = 'post-type-paged-' . $page;
		}
	}

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );

	/**
	 * Filters the list of CSS body class names for the current post or page.
	 *
	 * @since 2.8.0
	 *
	 * @param string[] $classes An array of body class names.
	 * @param string[] $class   An array of additional class names added to the body.
	 */
	$classes = apply_filters( 'body_class', $classes, $class );

	return array_unique( $classes );
}

function page_list(){
	return [
		[
			'name' => '網誌', 'href' => '/'
		],
		[
			'name' => '散文', 'href' => '/tag/散文'
		],
		[
			'name' => '隨筆', 'href' => '/tag/隨筆'
		],
		[
			'name' => '小說', 'href' => '/tag/小說'
		],
		[
			'name' => '精選', 'href' => '/tag/精選'
		],
		[
			'name' => '世界觀', 'href' => '/tag/世界觀'
		],
		[
			'name' => '每月主題', 'href' => '/tag/每月主題'
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
		if ($item['href'] == '/' && is_home() && !is_paged()) {
			$selected = true;
		}
		else if (is_tag()) {
			$tag = get_query_var('tag');
			if (urldecode($tag) == $item['name']) {
				$selected = true;
			}
		}

		$tabs .= '<li class="pill-button ripple label-item' . ($selected ? ' selected' : '') . '">';
		// else if () {

		// }
		$tabs .= '<a href='. $item['href'] . '>' . $item['name'] .' </a>';
		$tabs .= '</li>';
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
		echo urldecode($name);
		echo '</h3>';
		// echo '<div class="post-filter-message"><div>目前顯示的是有「<span class="search-label">散文</span>」標籤的文章</div><div><a class="flat-button ripple" href="/p/allposts.html#tags" target="_blank" title="查找所有文章">標籤列表</a></div></div>';
		printf($tag_msg, urldecode($name), '/allposts#tags', '標籤列表');
	}
	else if (get_query_var('year')) {
		echo $h3;
		echo (get_query_var('year') ? (get_query_var('year') . ' 年 ') : '') . (get_query_var('monthnum') ? (get_query_var('monthnum') . ' 月 '): '') . (get_query_var('date') ? get_query_var('date') : '');
		echo '</h3>';
		echo '<div class="post-filter-message"><div>目前顯示的是 二月, 2022的文章</div><div><a class="flat-button ripple" href="/allposts#archive" target="_blank" title="查找所有文章">文章列表</a></div></div>';
	}
}

function blog_pager() {
	// echo '' . (get_query_var( 'paged' ) * get_query_var('posts_per_page') + 1);
	echo '<div class="blog-pager-container widget">';
	echo '<div class="blog-pager">';
	$button = '<a class="pill-button ripple %1$s" href="%2$s" id="blog-pager-older-link" title="較舊的文章">%3$s</a>';
	$svg = '<svg class="svg-icon-pagination" height="14px" version="1.1" viewBox="0 0 18 14" width="18px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
		<path d="M1.027 5.332 C0.574 5.481 5.909 13.728 6.433 13.98 7.082 14.294 7.982 14.361 8.595 13.98 8.949 13.76 13.907 5.746 14 5.332 14.026 5.217 11.198 5.123 10.757 5.332 10.392 5.505 8.021 9.656 7.514 9.656 7.132 9.657 4.6 5.548 4.27 5.332 3.667 4.938 1.712 5.108 1.027 5.332 Z" fill="#646464" fill-opacity="1" id="Path-copy-1" stroke="none"></path>
		<path d="M1 5 C0.581 5.137 5.515 12.766 6 13 6.6 13.29 7.434 13.352 8 13 8.328 12.796 12.914 5.383 13 5 13.024 4.894 10.408 4.807 10 5 9.663 5.159 7.469 8.999 7 9 6.647 9.001 4.305 5.2 4 5 3.442 4.635 1.633 4.792 1 5 Z" fill="#ffffff" fill-opacity="1" id="Path-copy" stroke="none"></path>
		</svg>';
	// printf("%1d, %2d, %3d, %4d", is_home(), is_front_page(), is_paged(), is_date()); 
	if (is_home() && !is_paged() && !is_date()) {
		$date = strtotime(get_lastpostdate());
		$path =  '/' . date('Y', $date) . '/' . date('m', $date) . '/';
		printf($button, 'ajax-load-home', $path, $svg . '更多文章');
	}
	else if (get_query_var('year')) {
		// $path = paginate_links(['type' => 'array']);
		$year = get_query_var("year");
		$month = get_query_var("monthnum");
		if (!$month) {
			$year = $year - 1;
			printf($button, 'ajax-load', '/' . $year , $svg . '更多文章');
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
			printf($button, 'ajax-load', '/' . $year . '/' . (string) $month, $svg . '更多文章');
		}

		
		// echo $year;
		// echo $month;

		// exit;
		
		
	}
	else {
		printf($button, 'ajax-load', get_next_posts_page_link(), $svg . '更多文章');
	}
	echo '</div>';
	echo '</div>';
}