<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="page_body" class="content-area centered">
		<main id="main" class="site-main centered-bottom widget Blog" role="main">
		<h3 class="page-title post-title main">搜尋文章</h3>
		<div class="blog-posts hfeed container">
		<?php 
			if (is_search()) :
				blog_search();
		endif;?>
		<?php if ( have_posts() ) : ?>
			<?php
			// Start the loop.
			while ( have_posts() ) :
				
				the_post();
				if (is_search() && $post->post_type =='page') {
					continue;
				}
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

				// End the loop.
			endwhile;

			// Previous/next page navigation.
			// the_posts_pagination(
			// 	array(
			// 		'prev_text'          => __( 'Previous page', 'twentysixteen' ),
			// 		'next_text'          => __( 'Next page', 'twentysixteen' ),
			// 		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
			// 	)
			// );

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		</div>
		<?php
		blog_pager();
		echo get_page_list(page_list());
		?>
		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
