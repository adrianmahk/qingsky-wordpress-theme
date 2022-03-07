<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
get_header(); ?>

	<div id="page_body" class="content-area centered">
		<main id="main" class="site-main centered-bottom widget Blog" role="main">
		<header class="page-header">
			<?php post_filter_message()?>
		</header><!-- .page-header -->
		<div class="blog-posts hfeed container">
		<?php 
		if (is_home() && is_front_page() && !is_paged()) {
		// if (false()) {
			// query_posts(array( 'posts_per_page' => 1 ));
			// add_query_arg(array('posts_per_page' => 1));
			// add_action( 'pre_get_posts', 'wpshout_pages_blogindex');

			// $wp_query->set('posts_per_page', 1);
			// $wp_query->query($wp_query->query_vars);
		}
		else {
			// query_posts(array( 'offset' => (get_query_var( 'paged' ) - 2) * get_query_var('posts_per_page') + 1));
		}
		if ( have_posts() ) : ?>

			<?php
			// Start the loop.
			// if (is_home() && is_front_page() && !is_paged()) {
			// // if (false()) {
			// 	// The Query
			// 	// $the_query = new WP_Query( array( 'posts_per_page' => 1 ) );
			// 	query_posts(array( 'posts_per_page' => 1 ));
				
			// 	// The Loop
			// 	if ( have_posts() ) {
			// 		// echo '<ul>';
			// 		while ( have_posts() ) {
			// 			the_post();
			// 			// echo '<li>' . get_the_title() . '</li>';
			// 			get_template_part( 'template-parts/content', get_post_format() );
			// 		}
			// 		// echo '</ul>';
			// 		// the_post();
			// 	} else {
			// 		// no posts found
			// 	}
			// 	/* Restore original Post Data */
			// 	wp_reset_query();
			// }
			// else {
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Format-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Format name) and that
					* will be used instead.
					*/
					get_template_part( 'template-parts/content', get_post_format() );

					// End the loop.
				endwhile;
				// if (is_home() && is_front_page() && !is_paged()) {
				// 	wp_reset_query();
				// 	// query_posts(array( 'offset' => 1));
				// }
			
			// }
			// Previous/next page navigation.
			// the_posts_pagination(
			// 	array(
			// 		'prev_text'          => __( 'Previous page', 'twentysixteen' ),
			// 		'next_text'          => __( 'Next page', 'twentysixteen' ),
			// 		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
			// 	)
			// );
			// echo end(paginate_links(['type' => 'array']));
			blog_pager();
			echo get_page_list(page_list());
			
			// echo $wp_query->paged;
			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		<?php
			// echo get_page_list(page_list());
		?>
		</div>
		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
