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
		<main id="main" class="site-main centered-bottom" role="main">
			<div class="widget Blog">

		<header class="page-header">
			<?php post_filter_message()?>
		</header><!-- .page-header -->
		<?php 
			if (is_home() && !is_paged()) :
				blog_search();
			endif;
		?>
		<div class="blog-posts hfeed container">

		<?php
		if ( have_posts() ) : ?>

			<?php
			// Start the loop.
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

		</div>
		<?php
		blog_pager();
		echo get_page_list(page_list());
		?>
		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
