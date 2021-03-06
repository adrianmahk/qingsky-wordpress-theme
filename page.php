<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); 
?>

<div id="page_body" class="content-area centered">
	<?php 
		if (wp_make_link_relative(get_permalink()) == '/allposts/'){
			blog_search();
		}
	?>
<div class="blog-posts hfeed container">
	<main id="main" class="site-main centered-bottom" role="main">
		<?php
		
		// Start the loop.
		while ( have_posts() ) :
			the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'single' );

			// If comments are open or we have at least one comment, load up the comment template.
			// if ( comments_open() || get_comments_number() ) {
			// 	comments_template();
			// }

			// End the loop.
		endwhile;
		// blog_pager();
		echo get_page_list(page_list());
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>
	</div>
</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
