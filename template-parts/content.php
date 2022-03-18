<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" class="post-outer-container">
                                            <a class="snippet-a" href="<?php echo get_permalink();?>">
                                                <div class="progress-bar-container">
                                                    <div class="progress-bar" style=""></div>
                                                </div>
                                            </a>
                                            <div class="post-outer">
                                                <div class="post">
                                                    <a name="2928964363418182385"></a>
													<header class="entry-header">
		<?php the_title( sprintf( '<h3 class="post-title entry-title"><a class="post-title-a" href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
	</header>
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
															<!-- <br />
                                                            <span class="byline post-author vcard">
                                                                <span class="post-author-label">
                                                                    作者：
                                                                </span>
                                                                <span class="fn">
                                                                    <span>Unknown</span>
                                                                </span>
                                                            </span> -->
                                                            <!-- <span class="byline post-timestamp">
                                                                -
                                                                <meta
                                                                    content="https://www.qwinna.hk/2022/02/blog-post.html">
                                                                <a class="timestamp-link"
                                                                    href="https://www.qwinna.hk/2022/02/blog-post.html"
                                                                    rel="bookmark">
                                                                    <time class="published"
                                                                        datetime="2022-02-25T17:41:00+08:00"
                                                                        title="2月 25, 2022">
                                                                        2月 25, 2022
                                                                    </time>
                                                                    <span class="byline post-timestamp last-updated"
                                                                        datetime="2022-02-25T17:41:00+08:00"
                                                                        title="3月 01, 2022"> (已更新)</span>
                                                                </a>
                                                            </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="container post-body entry-content"
                                                        id="post-snippet-2928964363418182385"
                                                        style="display:table; position:relative">
                                                        <?php twentysixteen_post_thumbnail(); ?>
                                                        <div class="snippet-text<?php echo has_post_thumbnail() ? ' has-featured-image' : '';?>">
														<div class="post-body entry-content float-container entry-content">
		
            <?php //twentysixteen_excerpt(); ?>
        <?php
			the_content(
				sprintf(
					/* translators: %s: Post title. */
					__( '', 'twentysixteen' ),
					get_the_title()
				)
			);
            

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
			?>
	</div><!-- .entry-content -->
                                                        </div>
                                                        <div class="post-snippet">
                                                            <div class="snippet-fade"></div>
                                                        </div>
                                                    </div>
                                                    <div class="post-bottom">
                                                        <div class="post-footer float-container"
                                                            style="-webkit-order : -1; order : -1;">
                                                            <div class="label-cust-container">
															<?php
															if ( 'post' === get_post_type() ) {
																// twentysixteen_entry_taxonomies();
                                                                postTags();
															}
															?>	
                                                            </div>
                                                            <div title=""></div>
                                                            <div class="post-footer-line post-footer-line-1">
                                                                <span class="byline post-comment-link container">
                                                                    <a class="comment-link"
                                                                        href='<?php echo get_permalink() . '#respond';?>'
                                                                        onclick="">
                                                                        <!-- <svg class="svg-icon-24 touch-icon"> -->
                                                                            <!-- <use xlink:href="/responsive/sprite_v1_6.css.svg#ic_mode_comment_black_24dp"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                            </use> -->
                                                                        <!-- </svg> -->
                                                                        <svg class="svg-icon-24 touch-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M448 0H64C28.7 0 0 28.7 0 64v288c0 35.3 28.7 64 64 64h96v84c0 9.8 11.2 15.5 19.1 9.7L304 416h144c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64z"/></svg>
                                                                        <!-- <i class="fas fa-comment-alt"></i> -->
                                                                        <!-- <span class="num_comments">
                                                                            張貼留言
                                                                        </span> -->
																		<?php
																		if (get_comments_number() >  0) {
																			echo get_comments_number() . " 則留言";
																		}
																		else {
																			echo "張貼留言";
																		}
                                                                        ?>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="post-footer-line post-footer-line-2">
                                                            </div>
                                                        </div>
                                                        <div class="jump-link flat-button ripple">
                                                            <a href="<?php echo get_permalink()."#more"?>">
                                                                繼續看 ≫
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>