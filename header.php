<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package neubird
 */
$themeurl = get_stylesheet_directory_uri();
$favicon = get_field('favicon', 'option') ? : '';

$logo = get_field('logo', 'option') ? : '';
$menu_header = get_field('menu_header', 'option') ? : '';
$button_header = get_field('button_header', 'option') ? : '';

$x_url = get_field('x_url', 'option') ? : '';
$linkedin_url = get_field('linkedin_url', 'option') ? : '';
$copyright = get_field('copyright', 'option') ? : '';
$privacy_policy_link = get_field('privacy_policy_link', 'option') ? : '';

$header_code = get_field('header_code', 'option') ? : '';

$version = 2024112103;
$version = time();
global $wp;
$current_url =  home_url( $wp->request ) . '/';

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if($favicon): ?>
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo $favicon['url'] ?>" type="image/x-icon">
	<?php endif; ?>

	<?php wp_head(); ?>

	<!-- Style -->
	<link rel="stylesheet" href="<?php echo $themeurl ?>/assets/modules.css?time=<?php echo $version; ?>">
	<link rel="stylesheet" href="<?php echo $themeurl ?>/assets/css/theme.min.css?time=<?php echo $version; ?>">
	<link rel="stylesheet" href="<?php echo $themeurl ?>/custom.css?time=<?php echo $version; ?>">

	<?php echo $header_code; ?>

	<script>
		window.markerConfig = {
		project: '65ef5c8ab6142b63fc5e7872',
		source: 'snippet'
		};

		! function(e, r, a) {
		if (!e.__Marker) {
			e.__Marker = {};
			var t = [],
			n = {
				__cs: t
			};
			["show", "hide", "isVisible", "capture", "cancelCapture", "unload", "reload", "isExtensionInstalled", "setReporter", "setCustomData", "on", "off"].forEach(function(e) {
			n[e] = function() {
				var r = Array.prototype.slice.call(arguments);
				r.unshift(e), t.push(r)
			}
			}), e.Marker = n;
			var s = r.createElement("script");
			s.async = 1, s.src = "https://edge.marker.io/latest/shim.js";
			var i = r.getElementsByTagName("script")[0];
			i.parentNode.insertBefore(s, i)
		}
		}(window, document);
	</script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
  <header class="<?php echo $header_class; ?> start">
    <div class="content-area">
      <nav class="navbar navbar-expand-md">
        <div class="container-fluid px-0">
          <?php if($logo): ?>
            <a class="navbar-brand" href="<?php echo get_site_url(); ?>"><img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" class="img-fluid"></a>
          <?php endif; ?>

          <?php if($button_header):
            $button_header_url = $button_header['url'];
            $button_header_title = $button_header['title'];
            $button_header_target = $button_header['target'] ? $button_header['target'] : '_self';
            ?>
            <div class="mobile-menu-button d-md-none">
              <a <?php echo $button_header_url && $button_header_url != '#' ? 'href="'.$button_header_url.'"' : '' ?> target="<?php echo $button_header_target ?>" class="btn btn-primary"><?php echo $button_header_title ?></a>
            </div>
          <?php endif; ?>
          <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav">
              <?php 
                if($menu_header) {
                  foreach ($menu_header as $key => $value) {
                    $link = $value['link'];

                    if($link) {
                      $link_url = $link['url'];
                      $link_title = $link['title'];
                      $link_target = $link['target'] ? $link['target'] : '_self';
                      ?>
                      <li class="nav-item ">
                        <a class="nav-link <?php echo $link_url == $current_url ? 'active' : '' ?>" <?php echo $link_url && $link_url != '#' ? 'href="'.$link_url.'"' : '' ?> target="<?php echo $link_target ?>"><span><?php echo $link_title ?></span></a>
                      </li>
                      <?php
                    }
                  }
                }
              ?>

          <?php if($button_header):
            $button_header_url = $button_header['url'];
            $button_header_title = $button_header['title'];
            $button_header_target = $button_header['target'] ? $button_header['target'] : '_self';
            ?>
            <li class="nav-item no-line-hover">
              <a <?php echo $button_header_url && $button_header_url != '#' ? 'href="'.$button_header_url.'"' : '' ?> target="<?php echo $button_header_target ?>" class="nav-link menu-button"><span><?php echo $button_header_title ?></span></a>
            </li>
          <?php endif; ?>

            </ul>
            <div class="mobile-menu-footer d-md-none">
              <?php if($x_url || $linkedin_url): ?>
                <div class="social-menu">
                  <?php if($x_url): ?>
                    <a href="<?php echo $x_url ?>" target="_blank"><img src="<?php echo $themeurl ?>/images/svg/icon-twitter-white.svg" alt="#"></a>
                  <?php endif; ?>

                  <?php if($linkedin_url): ?>
                    <a href="<?php echo $linkedin_url ?>" target="_blank"><img src="<?php echo $themeurl ?>/images/svg/icon-linkedin-white.svg" alt="#"></a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

              <?php if($copyright || $privacy_policy_link): ?>
                <div class="menu-copyright">
                  <p><?php echo $copyright ?> <span class="separator">|</span> 
                    <?php 
                      if($privacy_policy_link) {
                        $privacy_policy_link_url = $privacy_policy_link['url'];
                        $privacy_policy_link_title = $privacy_policy_link['title'];
                        $privacy_policy_link_target = $privacy_policy_link['target'] ? $privacy_policy_link['target'] : '_self';
                        ?>
                        <a <?php echo $privacy_policy_link_url && $privacy_policy_link_url != '#' ? 'href="'.$privacy_policy_link_url.'"' : '' ?> target="<?php echo $privacy_policy_link_target ?>"><?php echo $privacy_policy_link_title ?></a>
                        <?php
                      }
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
