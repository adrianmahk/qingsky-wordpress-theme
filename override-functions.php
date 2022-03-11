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
				$classes[] = 'is-post';
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
			$classes[] = 'item-view';

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
		$year = get_query_var('year');
		$month = get_query_var('monthnum');
		echo $h3;
		echo ($year ? ($year . ' 年 ') : '') . ($month ? ($month . ' 月 '): '') . (get_query_var('date') ? get_query_var('date') : '');
		echo '<a class="pill-button ripple" href="/allposts" onclick="togglePopupArchive(' . $year  . ' ,' . $month . '); return false;" style="font-size: 12px; margin: -1px" title="選擇其他月份">選擇</a>';
		echo '</h3>';
	
		echo '<div class="post-filter-message"><div>目前顯示的是 二月, 2022的文章</div><div><a class="flat-button ripple" href="/allposts#archive" target="_blank" title="查找所有文章">文章列表</a></div></div>';
	}
}

function blog_pager($show_subscribe_msg = true) {
	// echo '' . (get_query_var( 'paged' ) * get_query_var('posts_per_page') + 1);
	echo '<div class="blog-pager-container widget">';
	if ($show_subscribe_msg) {
		echo '<div class="subscribe-message-container">
		<div class="subscribe-message">
		<em>請支持自由創作者，如果喜歡可以分享給好友及留言，也可以<a href="/p/about.html#subscribe" target="_blank">按這裡支持作者</a>，你的支持將會給我很大的鼓勵，謝謝～</em>
		</div>
		</div>';
	}
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

function postTags() {
	// $tags = wp_get_post_categories(get_the_ID());
	$tags = get_the_category(get_the_ID());
	// echo json_encode($tags); exit;
	if (!empty($tags)) {
		echo '<ul class="tabs inpost">';
		foreach ($tags as $tag) {
			printf('<li class="pill-button ripple"><a href="%1$s" title="更多「%2$s」的文章">%2$s</a></li>', '/tag/' . $tag->name, $tag->name);
		}
		echo '</ul>';
	}

	
}

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
					echo '<div style="display: table-row; width: 100%">';
					echo apply_filters( 'comment_form_field_comment', $field );

					echo $args['comment_notes_after'];
					
					echo apply_filters( 'comment_form_submit_field', $submit_field, $args );
					echo '</div>';
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
