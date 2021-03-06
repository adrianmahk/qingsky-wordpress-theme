<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
$themeLocalPath =  ($_SERVER['DOCUMENT_ROOT']) . '/wp-content/themes/qingsky-hk';
// include  $themeLocalPath . '/simple_html_dom.php';
update_view_count();
if ($_GET['ajax']) {
	global $wp_query;
	if (!is_singular()) {
		foreach ($wp_query->posts as $post) {
			$post->post_excerpt = substr($post->post_content, 0, custom_excerpt_length(0));
			$post->permalink = get_permalink($post);
			unset($post->post_content);
		}
	}
	echo print_r($wp_query->posts);
	die();
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta content="yes" name="apple-mobile-web-app-capable">
  	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta content="<?php $description = get_bloginfo( 'description', 'display' ); echo $description; ?>" name="description">
	<meta content="<?php $description = get_bloginfo( 'description', 'display' ); echo $description; ?>" property="og:description">
	<link href="<?php echo get_template_directory_uri() . '/assests/manifest.json' ?>" rel="manifest">
	<script src="<?php echo get_template_directory_uri() . '/js/blog-ui-all-ajax.js?t=' . filemtime($themeLocalPath . '/js/blog-ui-all-ajax.js') ?>" type="text/javascript"> </script>
	<script src="<?php echo get_template_directory_uri() . '/js/popupmsg.js?t=' . filemtime($themeLocalPath . '/js/popupmsg.js') ?>" type="text/javascript"> </script>
	<script>
		function loadIndie() {

		}
		function setupServiceWorker() {
			if (!document.body.classList.contains('error404')) {
				// if ('serviceWorker' in navigator && navigator.serviceWorker.controller === null) {
				if ('serviceWorker' in navigator) {
					navigator.serviceWorker.register("<?php echo  '/sw.js?t=' . get_last_update();?>", {scope: "<?php echo '/' ?>"}).then(function(registration) {
						console.log('Service worker registration succeeded:', registration);
					}, /*catch*/ function(error) {
						console.log('Service worker registration failed:', error);
					});
				}
			}
		}
		window.addEventListener("load", setupServiceWorker);
		// ready(setupServiceWorker);
		// setupServiceWorker();
	</script>
	<style type="text/css">
			@font-face {
                font-family: 'Roboto';
                font-style: italic;
                font-weight: 300;
                src: url(<?php echo get_template_directory_uri().'/assests/roboto-italic.woff2'?>) format('woff2');
				/* unicode-range: U + 0000-00FF, U + 0131, U + 0152-0153, U + 02BB-02BC, U + 02C6, U + 02DA, U + 02DC, U + 2000-206F, U + 2074, U + 20AC, U + 2122, U + 2191, U + 2193, U + 2212, U + 2215, U + FEFF, U + FFFD; */
            }
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: url(<?php echo get_template_directory_uri().'/assests/roboto.woff2'?>) format('woff2');
				unicode-range: U + 0000-00FF, U + 0131, U + 0152-0153, U + 02BB-02BC, U + 02C6, U + 02DA, U + 02DC, U + 2000-206F, U + 2074, U + 20AC, U + 2122, U + 2191, U + 2193, U + 2212, U + 2215, U + FEFF, U + FFFD;
            }
	</style>
	<link href="<?php  echo get_template_directory_uri() . '/css/blog.css?t=' . filemtime($themeLocalPath . '/css/blog.css') ?>" rel="stylesheet">
	<link href="<?php  echo get_template_directory_uri() . '/css/styles.css?t=' . filemtime($themeLocalPath . '/css/styles.css') ?>" rel="stylesheet">
	<link href="<?php  echo get_template_directory_uri() . '/css/popupmsg.css?t=' . filemtime($themeLocalPath . '/css/popupmsg.css') ?>" rel="stylesheet">
	
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
	<!-- <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script> -->
	<!-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
</head>

<body
<?php body_class(); get_last_update(); ?>>
<script type="text/javascript">
	bodyInit();
</script>
<?php wp_body_open(); ?>
<div class="loading-bar" id="loading-bar"></div>
    <div class="bg-div" id="bg-div"></div>
	<div class="bg-div-cust" id="bg-div"></div>
	<div class="bg-div-mask" id="bg-div-mask"></div>
	<div class="dark_mode_overlay" id="dark_mode_overlay"></div>
    <!-- <div class="bg-div-mask" id="bg-div-mask"></div> -->
<div id="page" class="page">
<!-- <div class="page_body"> -->
	<div class="page_body">
		<!-- <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a> -->
		<div class="page-upper-part" id="page-upper-part">
                <div class="centered page-upper-part-content" id="page-upper-part-content">
                    <div class="shadow-box"></div>
                    <div class="centered-top-placeholder"></div>

                    <header class="centered-top-container" role="banner">
                        <div class="centered-top">
                            <!-- original position of top-bar-->
                            <div class="blog-top-space"></div>
                            <div class="blog-name container">
                                <div class="container section" id="header" name="??????">
                                    <div class="widget Header" data-version="2" id="Header1">
                                        <div class="header-widget">
                                            <div>
                                                <h1>
                                                    <!-- <a href="https://www.qwinna.hk/">???????????????</a> -->
													<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
									<?php if ( is_front_page() && is_home() && !is_paged()) :?>
										<!-- <div class="subtitle"><?php //$description = get_bloginfo( 'description', 'display' ); echo $description; ?>
										<span class="subtitle_desc">??????????????????</span></div> -->
										<?php if (is_home() && is_front_page() && !is_paged() && is_active_sidebar( 'subtitle-1' )) {
											dynamic_sidebar( 'subtitle-1' );
										}?>
										
									<?php else:?>
										<a class="home-page-button pill-button ripple" href="<?php echo esc_url(home_url('/')) ?>">??????</a>
									<?php endif; ?>
                                </div>
                                <nav role="navigation">
                                </nav>
                            </div>
                        </div>
                    </header>

					<!-- for PageList1 -->
					<?php if (is_single() || is_page() ){
						echo get_page_list(page_list(), 'top_widget');
					}?>

                    <div class="clearboth section" id="top_widget" name="???????????? (??????)">
                    </div>
                </div>
            </div>
			<div class="centered top-bar-container">
                <div class="centered-top-container top-bar" id="top-bar">
					<?php if (!is_front_page() || is_paged()):?>
						<a class="return_link ripple" href="/"
            onclick="removeAttribute('href');history.back();" title="?????????">
            <img class="png_icon light"
              src="<?php echo get_template_directory_uri() . '/icons/Return.png'?>">
			  <img class="png_icon dark"
              src="<?php echo get_template_directory_uri() . '/icons/Return_dark.png'?>">
          </a>
					<?php endif?>
                    <a class="return_link to_top ripple"
                        onclick="window.scrollTo({top: 0, behavior: 'smooth'});" title="?????????">
                        <img class="png_icon light"
                            src="<?php echo get_template_directory_uri() . '/icons/ToTop.png'?>">
                        <img class="png_icon dark"
							src="<?php echo get_template_directory_uri() . '/icons/ToTop_dark.png'?>">
                    </a>
                    <div class="right-button-container  flat-icon-button ripple">
                        <a class="return_link dark_mode_button" onclick="darkMode();" title="????????????">
                            
                            <img class="png_icon light"
                                src="<?php echo get_template_directory_uri() . '/icons/moon9.png'?>">
                            <img class="png_icon dark"
							src="<?php echo get_template_directory_uri() . '/icons/moon9_dark.png'?>">
                        </a>
                    </div>
					<?php if (is_single()|| is_page()):?>
					<div class="right-button-container flat-icon-button ripple">
            <a class="return_link font_size" onclick="changeFontSize();" style="" title="????????????">
              <img class="png_icon light"
			  src="<?php echo get_template_directory_uri() . '/icons/FontSize.png'?>">
              <img class="png_icon dark"
			  src="<?php echo get_template_directory_uri() . '/icons/FontSize_dark.png'?>">
            </a>
          </div>
		  <?php endif?>
                    <div class='subscribe-section-container'> <a title='????????????' href='/about/#subscribe' target='_blank'><button class='subscribe-button pill-button'>??????</button></a> </div>
                </div>
            </div>
		
            <div class="middle section centered" id="page_middle">
		<?php 
		if (is_home() && is_front_page() && !is_paged()) {
			if ( is_active_sidebar( 'frontpage-1' ) ) : ?>
				<div class="widget-area widget HTML">
					<div class="apps-icon">
						<!-- <div class="icons-container"> -->
							<?php dynamic_sidebar( 'frontpage-1' ); ?>
						<!-- </div> -->
					</div>
				</div><!-- .widget-area -->
			<?php endif;
			if ( is_active_sidebar( 'frontpage-2' ) ) : ?>
				<div class="widget-area widget HTML">
					<h3 class="post-title main">????????????</h3>
					<div class="post-outer">
						<div class="post intro">
							<?php dynamic_sidebar( 'frontpage-2' ); ?>
							<div style="text-align: right">
								<a class="jump-link flat-button ripple" href="/greetings#more">
									????????? ???
								</a>
							</div>
						</div>
					</div>
				</div><!-- .widget-area -->
				<?php endif;
		}

		if (is_archive() || is_search()){// && is_active_sidebar( 'header-1' ) ){
			// dynamic_sidebar( 'header-1' );
			echo get_page_list(page_list(), '');
		}
		// Popup Widgets
		if ( is_active_sidebar( 'popup-1' ) ) : ?>
			<div class="widget-area widget HTML">
				<?php dynamic_sidebar( 'popup-1' ); ?>
			</div><!-- .widget-area -->
		<?php endif;
		?>

		</div>
		<div id="content" class="page-lower-part">
