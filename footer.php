<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
<div class="centered">
<footer class="footer section" id="footer" name="頁尾"><div class="widget Attribution" data-version="2" id="Attribution1">
<div class="widget-content">
<div class="blogger">
<!-- <a href="https://www.blogger.com" rel="nofollow">
<svg class="svg-icon-24">
<use xlink:href="/responsive/sprite_v1_6.css.svg#ic_post_blogger_black_24dp" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
</svg>
技術提供：Blogger
</a> -->
<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentysixteen' ) ); ?>" class="imprint">
					<?php
					/* translators: %s: WordPress */
					printf( __( 'Proudly powered by %s', 'twentysixteen' ), 'WordPress' );
					?>
				</a>
</div>
<!-- <div class="copyright">青鳥（Adrian Ma）2014 ~ 2022 All rights reserved</div> -->
<?php if ( is_active_sidebar( 'footer-1' ) ):?>
	<div class="copyright">
	 <?php dynamic_sidebar( 'footer-1' ); ?>
</div>
<?php endif;?>
</div>
</div>
</footer>
</div><!-- centered in footer -->
		
<!-- </div> -->
<!-- .site-content -->

		</div><!--lowerpart-->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
