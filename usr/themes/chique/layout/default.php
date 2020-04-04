<!DOCTYPE html>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $site->name; ?></title>


	</script>

	<link rel='stylesheet' id='font-awesome-css' href='<?= $v->import("css/font-awesome/css/font-awesome.css") ?>' type='text/css' media='all' />
	<link rel='stylesheet' id='chique-style-css' href='<?= $v->import("css/style.css") ?>' type='text/css' media='all' />
	<style id='chique-style-inline-css' type='text/css'>
		.home .custom-header:after {
			background-color: rgba(0, 0, 0, 0);
		}

		body:not(.home) .custom-header:after {
			background-color: rgba(0, 0, 0, 0.5);
		}
	</style>
	<link rel='stylesheet' id='chique-block-style-css' href='<?= $v->import("css/blocks.css?ver=1.0' type='text/css' media='all") ?>' />
	<script type='text/javascript' src='https://cdn.bootcss.com/jquery/1.12.2/jquery.slim.min.js'></script>
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://wp-themes.com/wp/xmlrpc.php?rsd" />
	<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://wp-themes.com/wp/wp-includes/wlwmanifest.xml" />
	<meta name="generator" content="WordPress 5.5-alpha-47534" />
	<style type="text/css" rel="header-image">
		.custom-header {
			background-image: url(https://pluvet-1251765364.cos.ap-chengdu.myqcloud.com/typora/20200331160009.jpg);
			background-position: center top;
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>
	<style type="text/css">
		.site-title a,
		.site-description {
			color: #000000;
		}
	</style>
</head>

<body class="home blog wp-embed-responsive hfeed navigation-classic no-sidebar content-width-layout no-featured-slider color-scheme-default">


	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content">Skip to content</a>

		<header id="masthead" class="site-header">
			<div class="wrapper">
				<div class="site-header-main">
					<div class="site-branding">

						<div class="site-identity">
							<h1 class="site-title"><a href="<?= $site->url; ?>" rel="home"> <?= $site->name; ?></a></h1>

							<p class="site-description"> <?= $site->description; ?></p>
						</div>
					</div><!-- .site-branding -->

					<div id="site-header-menu" class="site-header-menu">
						<div id="primary-menu-wrapper" class="menu-wrapper">

							<div class="header-overlay"></div>

							<div class="menu-toggle-wrapper">
								<button id="menu-toggle" class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
									<div class="menu-bars">
										<div class="bars bar1"></div>
										<div class="bars bar2"></div>
										<div class="bars bar3"></div>
									</div>
									<span class="menu-label">Menu</span>
								</button>
							</div><!-- .menu-toggle-wrapper -->

							<div class="menu-inside-wrapper">


								<nav id="site-navigation" class="main-navigation default-page-menu" role="navigation" aria-label="Primary Menu">
									<div class="primary-menu-container">
										<ul id="menu-primary-items" class="menu nav-menu">
											<li class="page_item page-item-2"><a href="https://wp-themes.com/chique/?page_id=2">About</a></li>
											<li class="page_item page-item-46 page_item_has_children"><a href="https://wp-themes.com/chique/?page_id=46">Parent Page</a>
												<ul class='children'>
													<li class="page_item page-item-49"><a href="https://wp-themes.com/chique/?page_id=49">Sub-page</a></li>
												</ul>
											</li>
										</ul>
									</div>

								</nav><!-- .main-navigation -->

								<div class="mobile-social-search">
									<div class="search-container">


										<form role="search" method="get" class="search-form" action="<?= $util->url::search(); ?>">
											<label for="search-form-5e82d51812baa">
												<span class="screen-reader-text">Search for:</span>
												<input type="search" id="search-form-5e82d51812baa" class="search-field" placeholder="Search ..." value="" name="s" title="Search for:">
											</label>

											<button type="submit" class="search-submit fa fa-search"></button>
										</form>
									</div>

									<nav class="social-navigation" role="navigation" aria-label="Social Links Menu">
										<div class="menu">
											<ul>
												<li class="page_item page-item-2"><a href="https://wp-themes.com/chique/?page_id=2"><span class="screen-reader-text">About</span></a></li>
												<li class="page_item page-item-46 page_item_has_children"><a href="https://wp-themes.com/chique/?page_id=46"><span class="screen-reader-text">Parent Page</span></a></li>
											</ul>
										</div>
									</nav><!-- .social-navigation -->


								</div><!-- .mobile-social-search -->
							</div><!-- .menu-inside-wrapper -->
						</div><!-- #primary-menu-wrapper.menu-wrapper -->

					</div><!-- .site-header-menu -->

					<div class="search-social-container">
						<div id="primary-search-wrapper">
							<div class="search-container">


								<form role="search" method="get" class="search-form" action="<?= $util->url::search(); ?>">
									<label for="search-form-5e82d5181374b">
										<span class="screen-reader-text">Search for:</span>
										<input type="search" id="search-form-5e82d5181374b" class="search-field" placeholder="Search ..." value="" name="s" title="Search for:">
									</label>

									<button type="submit" class="search-submit fa fa-search"></button>
								</form>
							</div>
						</div><!-- #primary-search-wrapper -->

					</div> <!-- .search-social-container -->



				</div> <!-- .site-header-main -->

			</div> <!-- .wrapper -->
		</header><!-- #masthead -->

		<div class="below-site-header">

			<div class="site-overlay"><span class="screen-reader-text">Site Overlay</span></div>


			<div class="custom-header">
				<div class="custom-header-media">
					<img src="https://pluvet-1251765364.cos.ap-chengdu.myqcloud.com/typora/20200331160009.jpg"> </div>

				<div class="custom-header-content content-aligned-center text-aligned-center">
					<div class="entry-container">
						<div class="entry-container-wrap">
							<header class="entry-header">
								<h2 class="entry-title"><span></span></h2>
							</header>

						</div> <!-- .entry-container-wrap -->
					</div>
				</div> <!-- entry-container -->

				<div class="scroll-down">
					<span>Scroll</span>
					<span class="fa fa-angle-down" aria-hidden="true"></span>
				</div><!-- .scroll-down -->
			</div>







			<div id="content" class="site-content">
				<div class="wrapper">

					<div id="primary" class="content-area">
						<main id="main" class="site-main">
							<div class="archive-content-wrap">
								<?= $v->section('content'); ?>

							</div> <!-- .archive-content-wrap -->
						</main><!-- #main -->
					</div><!-- #primary -->

				</div><!-- .wrapper -->
			</div><!-- #content -->


			<footer id="colophon" class="site-footer">


				<div id="site-generator">
					<div class="wrapper">


						<div class="site-info">
							Copyright &copy; 2020 <a href="<?= $site->url; ?>"><?= $site->name; ?></a>. All Rights Reserved. &#124; Chique&nbsp;by&nbsp;<a target="_blank" href="https://catchthemes.com/">Catch Themes</a> </div> <!-- .site-info -->
					</div> <!-- .wrapper -->
				</div><!-- .site-info -->
			</footer><!-- #colophon -->
		</div> <!-- below-site-header -->
	</div><!-- #page -->

	<script type='text/javascript' src='<?= $v->import("js/navigation.min.js?") ?>'></script>
	<script type='text/javascript' src='<?= $v->import("js/skip-link-focus-fix.min.js?") ?>'></script>
	<script type='text/javascript' src='<?= $v->import("js/jquery.matchHeight.min.js?") ?>'></script>
	<script type='text/javascript'>
		/* <![CDATA[ */
		var chiqueOptions = {
			"screenReaderText": {
				"expand": "expand child menu",
				"collapse": "collapse child menu"
			},
			"iconNavPrev": "<i class=\"fa fa-chevron-left\"><\/i>",
			"iconNavNext": "<i class=\"fa fa-chevron-right\"><\/i>"
		};
		/* ]]> */
	</script>
	<script type='text/javascript' src='<?= $v->import("js/custom-scripts.min.js?ver=201800703") ?>'></script>
</body>

</html>