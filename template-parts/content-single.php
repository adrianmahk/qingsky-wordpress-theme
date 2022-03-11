<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" class="post-outer-container">
											<div class="post-outer">
												<div class="post">
													<a name="9110926056781354028"></a>
													<?php the_title( '<h3 class="post-title entry-title">', '</h2>' ); ?>
													<!-- <h3 class="post-title entry-title">
														作者的話
														<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
													</h3> -->
													
													<?php 
                                                        share_button();
                                                    ?>
													<?php 
                                                        if (is_sticky()) {
                                                            echo '<img class="post-title-pin-icon" src="' . get_template_directory_uri() . '/icons/pinned4.png" title="置頂文章">';
                                                        }
                                                    ?>
													<div class="post-header">
														<div class="post-header-line-1">
														<?php twentysixteen_entry_meta(); ?>
															<!-- <span class="byline post-author vcard">
																<span class="post-author-label">
																	作者：
																</span>
																<span class="fn">
																	<span>Unknown</span>
																</span>
															</span> -->
														</div>
													</div>
													<!-- <span class="byline post-timestamp last-updated">
														於 <time class="published" datetime="2022-03-03T02:00:03+08:00"
															title="">3月 03, 2022</time> 更新
													</span> -->
													<div class="entry-content post-body entry-content float-container">
		<?php
			the_content();

			wp_link_pages(
				array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				)
			);

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}
			// echo wp_make_link_relative(get_permalink()); exit;
			if (wp_make_link_relative(get_permalink()) == '/allposts/'){
				echo '<h2>按月份瀏覽</h2><a name="archive"/>';
				echo blogArchive();
			}
					
			?>
	</div><!-- .entry-content -->
	<div class="post-bottom">
	<footer class="post-footer float-containe entry-footer">
		<div class="label-cust-container"><?php
															if ( 'post' === get_post_type() ) {
																// twentysixteen_entry_taxonomies();
																postTags();
															}
															?>
															</div>
															<div class="subscribe-message">
																	<hr>
																	<em>請支持自由創作者，如果喜歡可以分享給好友及留言，也可以<a
																			href="/about/#subscribe"
																			target="_blank">按這裡支持作者</a>，你的支持將會給我很大的鼓勵，謝謝～</em>
																</div>
		<?php //twentysixteen_entry_meta(); ?>
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Post title. */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
	</footer>
		</div>
													
												
												</div>
											</div>
											<script type="text/javascript">
												function popupComment() {
													var iframe = document.getElementById("comment-editor");
													var url = iframe.src;
													var win = window.open(url, "_blank");
												}
											</script>
											<?php 
											if ( comments_open() || get_comments_number() ) {
												comments_template();
											}
											?>
											
										</article>