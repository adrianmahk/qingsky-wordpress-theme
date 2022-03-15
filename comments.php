<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<?php the_comments_navigation(); ?>
		<div class="comment-thread">
		<ol class="comment-list">
			<?php
				wp_list_comments2(
					array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 42,
					)
				);
			?>
		</ol><!-- .comment-list -->
			</div>
		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'twentysixteen' ); ?></p>
	<?php endif; ?>
	<div class="comments-container" onclick="">
												
											</div>
											<script>
												function hideShowComments(el) {
													// console.log(el);
													if (el.matches(":focus")) {
														console.log("focusin");
														el.parentNode.classList.add("focused");
													}
													else if (el.value == "") {
														console.log("focusout");
														el.parentNode.classList.remove("focused");
													}
												}
											</script>
	<div class="comments-reply-container" style="">
	<div class="comments-icon-container"><svg style="display: table-cell;" class="svg-icon-24 touch-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M448 0H64C28.7 0 0 28.7 0 64v288c0 35.3 28.7 64 64 64h96v84c0 9.8 11.2 15.5 19.1 9.7L304 416h144c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64z"/></svg></div>
	<?php
		comment_form2(
			array(
				'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
				'title_reply_after'  => '</h2>',
				'title_reply' => '',
				'comment_notes_before' => '',
				'comment_field'        => '<textarea id="commentBodyField" name="comment" onfocus="hideShowComments(this)" onblur="hideShowComments(this)" cols="45" rows="8" maxlength="65525" required="required" placeholder="輸入您的留言"></textarea>',
				'class_form' => 'commentBodyContainer',
				'id_form' => 'commentsHolder',
				'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="%3$s search-action flat-button" value="%4$s">'
				// sprintf(
				// 	'<p class="comment-form-comment">%s %s</p>',
				// 	sprintf(
				// 		'<label for="comment">%s</label>',
				// 		_x( 'Comment', 'noun' )
				// 	),
				// 	'<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="abcd"></textarea>'
				// ),
			)
		);
		?>
	</div>
</div><!-- .comments-area -->
