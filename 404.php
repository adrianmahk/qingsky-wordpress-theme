<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area centered">
	<?php echo get_page_list(page_list()); ?>
		<main id="main" class="site-main centered-bottom" role="main">
		<?php 
				// global $wp_query;
				// echo json_encode($wp_query);
			post_filter_message() ?>
		<div class="blog-posts hfeed container">
			
<div class="post-outer-container">
<div class="no-posts-message">
找不到相符的結果
<?php
	if (strpos($_SERVER['REQUEST_URI'], '.html') > 0) {
		echo '<br />註：本站在 2022 年 3 月搬家，搬運仍在進行中，鏈結可能失效，這裡可能有你想找的東西：<br />';
		$url = 'https://blogger.qingsky.hk' . $_SERVER['REQUEST_URI'];
		echo '<a href="' . $url . '">' . $url . '</a><br />' ;
		echo '（此為本站的 Blogger 舊版本的鏈結）';
	}
?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- qingskys_page_body_Blog1_1x1_as -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6259217392436204"
     data-ad-slot="4167252325"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br />
<cm>輕鬆一下</cm>
</div>
</div>
</div>
<?php
 echo get_page_list(page_list());
 blog_pager();
 
?>
		</main><!-- .site-main -->

		<?php get_sidebar( 'content-bottom' ); ?>

	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
