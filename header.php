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
include ($_SERVER['DOCUMENT_ROOT']) . '/wp-content/themes/qingsky-hk/simple_html_dom.php';
update_view_count();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<!-- <title><?php //bloginfo( 'name' ); ?></title> -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta content="yes" name="apple-mobile-web-app-capable">
  	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<link href="<?php echo get_template_directory_uri() . '/assests/manifest.json' ?>" rel="manifest">
	<script src="<?php echo get_template_directory_uri() . '/js/blog-ui-ajax.js?v=1' ?>" type="text/javascript"> </script>
	<script>
		function loadIndie() {

		}
		function setupServiceWorker() {
			if (document.body.classList.contains('home-view')) {
				if ('serviceWorker' in navigator) {
					console.log('landing');
					navigator.serviceWorker.register("<?php echo  '/sw.js'?>", {scope: "<?php echo '/' ?>"}).then(function(registration) {
						console.log('Service worker registration succeeded:', registration);
					}, /*catch*/ function(error) {
						console.log('Service worker registration failed:', error);
					});
				}
				navigator.serviceWorker.addEventListener('message', event => {
					// event is a MessageEvent object
					console.log(`The service worker sent me a message: ${event.data}`);
				});
				//loadTagsList();
			}
		}
		ready(setupServiceWorker);
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
	<!-- <link href="<?php // echo get_template_directory_uri() . '/css/blog.css' ?>" rel="stylesheet">
	<link href="<?php //echo get_template_directory_uri() . '/css/styles.css' ?>" rel="stylesheet"> -->
	
	
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body
<?php body_class(); get_last_update(); ?>>
<?php
	// echo includes_url();
?>
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
                                <div class="container section" id="header" name="標頭">
                                    <div class="widget Header" data-version="2" id="Header1">
                                        <div class="header-widget">
                                            <div>
                                                <h1>
                                                    <!-- <a href="https://www.qwinna.hk/">藍色的天空</a> -->
													<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
									<?php if ( is_front_page() && is_home() && !is_paged()) :?>
										<div class="subtitle"><?php $description = get_bloginfo( 'description', 'display' ); echo $description; ?>
										<span class="subtitle_desc">（本月主題）</span>
										</div>
									<?php else:?>
										<a class="home-page-button pill-button ripple" href="<?php echo esc_url(home_url('/')) ?>">首頁</a>
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

                    <div class="clearboth section" id="top_widget" name="網頁清單 (頂端)">
                    </div>
                </div>
            </div>
			<div class="centered top-bar-container">
                <div class="centered-top-container top-bar" id="top-bar">
					<?php if (!is_front_page() || is_paged()):?>
						<a class="return_link ripple" href="/"
            onclick="removeAttribute('href');history.back();" title="上一頁">
            <img class="png_icon light"
              src="<?php echo get_template_directory_uri() . '/icons/Return.png'?>">
			  <img class="png_icon dark"
              src="<?php echo get_template_directory_uri() . '/icons/Return_dark.png'?>">
          </a>
					<?php endif?>
                    <a class="return_link to_top ripple"
                        onclick="window.scrollTo({top: 0, behavior: 'smooth'});" title="回頁首">
                        <img class="png_icon light"
                            src="<?php echo get_template_directory_uri() . '/icons/ToTop.png'?>">
                        <img class="png_icon dark"
							src="<?php echo get_template_directory_uri() . '/icons/ToTop_dark.png'?>">
                    </a>
                    <div class="right-button-container  flat-icon-button ripple">
                        <a class="return_link dark_mode_button" onclick="darkMode();" title="黑夜模式">
                            
                            <img class="png_icon light"
                                src="<?php echo get_template_directory_uri() . '/icons/moon9.png'?>">
                            <img class="png_icon dark"
							src="<?php echo get_template_directory_uri() . '/icons/moon9_dark.png'?>">
                        </a>
                    </div>
					<?php if (is_single()|| is_page()):?>
					<div class="right-button-container flat-icon-button ripple">
            <a class="return_link font_size" onclick="changeFontSize();" style="" title="字體大小">
              <img class="png_icon light"
			  src="<?php echo get_template_directory_uri() . '/icons/FontSize.png'?>">
              <img class="png_icon dark"
			  src="<?php echo get_template_directory_uri() . '/icons/FontSize_dark.png'?>">
            </a>
          </div>
		  <?php endif?>
                    <div class='subscribe-section-container'> <a title='訂閱本站' href='/about/#subscribe' target='_blank'><button class='subscribe-button pill-button'>訂閱</button></a> </div>
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
					<h3 class="post-title main">作者的話</h3>
					<div class="post-outer">
						<div class="post intro">
							<?php dynamic_sidebar( 'frontpage-2' ); ?>
							<div style="text-align: right">
								<a class="jump-link flat-button ripple" href="/greetings#more">
									繼續看 ≫
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
