<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div id="page_body" class="content-area centered">
	<div class="blog-posts hfeed container">
	<div class="centered top-bar-container" style="top: 4px">
	<div class="progress-bar-container"><div class="progress-bar" id="progress-bar-top-bar" style=""></div></div>
	</div>
	<main id="main" class="site-main centered-bottom" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) :
			the_post();

			// Include the single post content template.
			get_template_part( 'template-parts/content', 'single' );

		endwhile;
		?>
		<!-- <?php //echo get_next_post_link('<button class="pill-button ripple">%link</button>', '較新的文章');?> -->
<div class="blog-pager container" id="blog-pager">
                      <div class="post-filter-message" style="display: table; text-align: center; table-layout: fixed">
                        <div style="display: table-cell">
						<?php 
							$prev = get_permalink(get_adjacent_post(false,'',false)); 
							if ($prev != get_permalink()) { 
								echo '<a class="blog-pager-older-link  pill-button ripple" href="'.  $prev . '">＜　較新的文章</a>';
							}
						?>
                        </div>
                        <div style="display: table-cell">
						  <?php
						  		$tags = get_the_category(get_the_ID());
								// echo json_encode($tags);
								$name = '';
								$moreTag = array_filter($tags, function ($tag){
									if (!in_array( urldecode($tag->name), ['散文', '隨筆', '精選', '小說', '世界觀', '每月主題', '置頂']) ) {
										return true;
									}
								});
								// echo $moreTag;
								// echo json_encode($moreTag);
								if (empty($moreTag)) {
									$moreTag = $tags;
								}

								if (!empty($moreTag)):
									$name = urldecode(array_values($moreTag)[0]->name);
									$link = urldecode('/category/' . $slug);
									
						  ?>
                          <a class="pill-button ripple"
                            href="<?php echo $link;?>" title="更多「<?php echo $name;?>」文章">
                            <svg class="svg-icon-pagination" height="14px" version="1.1" viewBox="0 0 18 14"
                              width="18px" xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink">
                              <path
                                d="M1.027 5.332 C0.574 5.481 5.909 13.728 6.433 13.98 7.082 14.294 7.982 14.361 8.595 13.98 8.949 13.76 13.907 5.746 14 5.332 14.026 5.217 11.198 5.123 10.757 5.332 10.392 5.505 8.021 9.656 7.514 9.656 7.132 9.657 4.6 5.548 4.27 5.332 3.667 4.938 1.712 5.108 1.027 5.332 Z"
                                fill="#646464" fill-opacity="1" id="Path-copy-1" stroke="none"></path>
                              <path
                                d="M1 5 C0.581 5.137 5.515 12.766 6 13 6.6 13.29 7.434 13.352 8 13 8.328 12.796 12.914 5.383 13 5 13.024 4.894 10.408 4.807 10 5 9.663 5.159 7.469 8.999 7 9 6.647 9.001 4.305 5.2 4 5 3.442 4.635 1.633 4.792 1 5 Z"
                                fill="#ffffff" fill-opacity="1" id="Path-copy" stroke="none"></path>
                            </svg>
                            更多相似文章
                          </a>
						  <?php endif; ?>
                        </div>
                        <div style="display: table-cell">

						<?php 
							$next = get_permalink(get_adjacent_post(false,'',true)); 
							if ($next != get_permalink()) { 
								echo '<a class="blog-pager-newer-link  pill-button ripple" href="'.  $next . '">較舊的文章　＞</a>';
							}
						?>
                        </div>
                        <div style="display: none">aaa</div>
                      </div>
                    </div>
					<?php echo get_page_list(page_list());?>
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>
	</div>
</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
