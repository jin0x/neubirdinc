<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package neubird
 */
$themeurl = get_stylesheet_directory_uri();

$logo_footer = get_field('logo_footer', 'option') ? : '';
$menu_footer = get_field('menu_footer', 'option') ? : '';
$x_url = get_field('x_url', 'option') ? : '';
$linkedin_url = get_field('linkedin_url', 'option') ? : '';
$copyright = get_field('copyright', 'option') ? : '';
$privacy_policy_link = get_field('privacy_policy_link', 'option') ? : '';
$footer_link = get_field('footer_link', 'option') ? : '';

$footer_code = get_field('footer_code', 'option') ? : '';

// $version = 28022022;
$version = time();

global $post;
$page_slug = isset($post) && $post ? $post->post_name : '';
$blocks = isset($post) && $post ? parse_blocks($post->post_content) : array();

global $wp;
$current_url =  home_url( $wp->request ) . '/';

?>

<footer>
  <div class="content-area">
    <div class="footer-logo-area">
      <?php if($logo_footer): ?>
        <a href="<?php echo get_site_url(); ?>"><img src="<?php echo $logo_footer['url'] ?>" alt="<?php echo $logo_footer['alt'] ?>" class="img-fluid"></a>
      <?php endif; ?>
    </div>
    <div class="footer-menu-social">

      <?php if($menu_footer): ?>
        <div class="footer-menu-area">
          <?php 
            foreach ($menu_footer as $key => $value) {
              $link = $value['link'];

              if($link) {
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a <?php echo $link_url && $link_url != '#' ? 'href="'.$link_url.'"' : '' ?> target="<?php echo $link_target ?>"><?php echo $link_title ?></a>
                <?php
              }
            }
          ?>
        </div>
      <?php endif; ?>

      <?php if($x_url || $linkedin_url): ?>
        <div class="footer-social-area">
          <?php if($x_url): ?>
            <a href="<?php echo $x_url ?>" target="_blank"><img src="<?php echo $themeurl ?>/images/svg/icon-twitter-white.svg" alt="#"></a>
          <?php endif; ?>

          <?php if($linkedin_url): ?>
            <a href="<?php echo $linkedin_url ?>" target="_blank"><img src="<?php echo $themeurl ?>/images/svg/icon-linkedin-white.svg" alt="#"></a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
    <?php if($copyright || $footer_link): ?>
      <div class="footer-copyright">
        <p><?php echo $copyright ?> <span class="separator">|</span> 
          <?php 
            if($footer_link) {
              foreach ($footer_link as $key => $value) {
                $link = $value['link'];
                if($link) {
                  $link_url = $link['url'];
                  $link_title = $link['title'];
                  $link_target = $link['target'] ? $link['target'] : '_self';
                  ?>
                  <a <?php echo $link_url && $link_url != '#' ? 'href="'.$link_url.'"' : '' ?> target="<?php echo $link_target ?>"><?php echo $link_title ?></a>
                  <?php
                  if(($key + 1) !== count($footer_link) ) {
                    echo '<span class="separator">|</span> ';
                  }
                }
              }
            }
          ?>
        </p>
      </div>
    <?php endif; ?>
  </div>
</footer>
</div><!-- #page -->

<div class="visually-hidden">
  <img src="<?php echo $themeurl ?>/images/menu-hamburger.png" alt="#">
  <img src="<?php echo $themeurl ?>/images/menu-close.png" alt="#">
  <img src="<?php echo $themeurl ?>/images/svg/icon-minus.svg" alt="#">
  <img src="<?php echo $themeurl ?>/images/svg/icon-plus.svg" alt="#">
  <img src="<?php echo $themeurl ?>/images/pagination-arrow-left.png" alt="#">
  <img src="<?php echo $themeurl ?>/images/pagination-arrow-right.png" alt="#">
</div>

<?php wp_footer(); ?>


<!-- Optional JavaScript -->
<script src="https://unpkg.com/@lottiefiles/lottie-player@0.4.0/dist/lottie-player.js"></script>
<script src="<?php echo $themeurl ?>/assets/modules.js?time=<?php echo $version; ?>"></script>
<script src="<?php echo $themeurl ?>/assets/js/theme.js?time=<?php echo $version; ?>"></script>
<script src="<?php echo $themeurl ?>/js/gravity-form-handler.js?time=<?php echo $version; ?>"></script>

<?php echo $footer_code; ?>

</body>
</html>
