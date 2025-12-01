<?php
/**
 * Hero Banner Template
 * Supports three variations:
 * 1. Lottie file rendering on the right
 * 2. Normal image rendering on the right
 * 3. Normal image rendering on the bottom
 */

// Set up variables based on context (ACF block or regular template part)
$is_block = isset($block);

if ($is_block) {
    // ACF Block context
    $id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'hero-banner-'.uniqid());
    $pretitle = get_field('bn_pretitle') ? : '';
    $title = get_field('bn_title') ? : '';
    $text = get_field('bn_text') ? : '';
    $button_1 = get_field('bn_link') ? : '';
    $button_2 = get_field('bn_button_2') ? : '';
    $banner_image = get_field('bn_image') ? : '';
    $lottie = get_field('bn_lottie') ? : '';
    $lottieimage = get_field('bn_lottieimage') ? : '';
    $layout_style = get_field('bn_layout_style') ? : 'text_over_image';
    $text_alignment = get_field('bn_text_alignment') ? : 'left';
    $show_desktop = get_field('bn_show_desktop') ? : false;
    $iframe_url = get_field('bn_iframe_url') ? : '';
    $animate_text = get_field('bn_animate_text') ? : false;
    $banner_height = get_field('bn_banner_height') ? : 'medium';
} else {
    // Regular template part context (Integrations page)
    $id = 'hero-banner-'.uniqid();
    $pretitle = isset($pretitle) ? $pretitle : '';
    $title = isset($title) ? $title : '';
    $text = isset($text) ? $text : '';
    $button_1 = isset($button_1) ? $button_1 : '';
    $button_2 = isset($button_2) ? $button_2 : '';
    $banner_image = isset($banner_image) ? $banner_image : '';
    $lottie = isset($lottie) ? $lottie : '';
    $lottieimage = isset($lottieimage) ? $lottieimage : '';
    $layout_style = isset($layout_style) ? $layout_style : 'text_with_side_image';
    $text_alignment = 'left';
    $show_desktop = false;
    $iframe_url = '';
    $animate_text = isset($animate_text) ? $animate_text : false;
}

// Set classes based on settings
$banner_classes = 'hero-banner';
$banner_classes .= ' layout-' . $layout_style;
$banner_classes .= ' height-' . $banner_height;
if($text_alignment == 'center') {
    $banner_classes .= ' text-center';
}
if($show_desktop) {
    $banner_classes .= ' desktop-only';
}
if($lottie && $lottieimage) {
    $banner_classes .= ' with_lottie';
}

// Only display if we have content
if($title || $text || $pretitle || $banner_image || ($lottie && $lottieimage)):
?>
<section id="<?php echo esc_attr($id); ?>" class="<?php echo $banner_classes; ?>">
  <div class="container">
  <?php if($layout_style == 'text_over_image'): ?>
  <div class="background-area <?php echo $lottie && $lottieimage ? 'with_lottie' : ''; ?>">
    <?php if($banner_image && !($lottie && $lottieimage)): ?>
      <div class="image-wrapper">
        <img src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>" class="img-fluid banner-image">
      </div>
    <?php endif; ?>

    <?php if($lottie && $lottieimage): ?>
      <lottie-player class="lottie-mobile-hide" src="<?php echo $lottie['url'] ?>" background="transparent" speed="1" loop autoplay data-mobile-hide="true"></lottie-player>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <?php if($layout_style == 'text_with_side_image'): ?>
  <div class="banner-image-container">
    <div class="image-wrapper">
      <?php if($banner_image && !($lottie && $lottieimage)): ?>
        <img src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>" class="banner-image">
      <?php endif; ?>
      
      <?php if($lottie && $lottieimage): ?>
        <div class="lottie-wrapper lottie-mobile-hide" data-mobile-hide="true">
          <lottie-player class="lottie-mobile-hide" src="<?php echo $lottie['url'] ?>" background="transparent" speed="1" loop autoplay data-mobile-hide="true"></lottie-player>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>
  
  <?php if($layout_style == 'text_with_bottom_image'): ?>
  <!-- For bottom image layout, content area comes first, then image below -->
  <?php endif; ?>

  <div class="content-area" data-aos="fade-in">
    <div class="content-wrapper <?php echo $layout_style == 'text_with_side_image' ? 'side-image-content' : 'full-width-content'; ?>">
      <!-- Text content -->
      <div class="banner-text-content">
        <?php if($pretitle): ?>
        <h5 class="pretitle"><?php echo $pretitle; ?></h5>
        <?php endif; ?>
        
        <?php if($title): ?>
        <h1 class="gradient-text"><?php echo $title; ?></h1>
        <?php endif; ?>
        
        <?php // Show regular text field content - this is the main text description ?>
        <?php if($text): ?>
            <p class="banner-text"><?php echo wp_kses_post(nl2br($text)); ?></p>
        <?php endif; ?>
        
        <?php // Show animated text if enabled (this is optional/additional) ?>
        <?php if($animate_text): ?>
            <?php
            // Get the base text and flip text options from ACF fields
            $base_text = '';
            $flip_words = [];
            
            // Get base text from the dedicated field if available
            if (function_exists('get_field') && $is_block) {
                $base_text = get_field('bn_base_text') ? : '';
                
                // Get flip text options from the repeater field
                if (have_rows('bn_flip_texts')) {
                    while (have_rows('bn_flip_texts')) {
                        the_row();
                        $flip_text = get_sub_field('text');
                        if ($flip_text) {
                            $flip_words[] = $flip_text;
                        }
                    }
                }
            }
            
            // Only show animated text if we have base_text or flip_words
            if (!empty($base_text) || !empty($flip_words)) {
                // Ensure we have at least one flip word
                if (empty($flip_words)) {
                    $flip_words = ['alert fatigue'];
                }
                if (empty($base_text)) {
                    $base_text = '';
                }
                ?>
                <p class="banner-text-animated"><span id="base-text"><?php echo esc_html($base_text); ?></span><span id="flip-container" class="flip-container"><span id="flip-text" class="flip-text"><?php echo esc_html($flip_words[0]); ?></span></span></p>
                <script>
                    // Store the text for JavaScript to use
                    var baseText = '<?php echo addslashes($base_text); ?>';
                    var flipWords = <?php echo json_encode($flip_words); ?>;
                </script>
            <?php } ?>
        <?php endif; ?>
        
        <div class="btn_area">
          <?php if($button_1):
          $button_1_url = isset($button_1['url']) ? $button_1['url'] : $button_1;
          $button_1_title = isset($button_1['title']) ? $button_1['title'] : 'Try Hawkeye';
          $button_1_target = isset($button_1['target']) ? $button_1['target'] : '_self';
          ?>
          <a <?php echo $button_1_url && $button_1_url != '#' ? 'href="'.$button_1_url.'"' : '' ?> target="<?php echo $button_1_target ?>" class="btn btn-primary"><?php echo $button_1_title ?></a>
          <?php endif; ?>
      
          <?php if($button_2):
          $button_2_url = isset($button_2['url']) ? $button_2['url'] : $button_2;
          $button_2_title = isset($button_2['title']) ? $button_2['title'] : 'Learn More';
          $button_2_target = isset($button_2['target']) ? $button_2['target'] : '_self';

          $show_fancy = 0;
          if(is_string($button_2_url) && strpos($button_2_url, 'youtube')) {
            $show_fancy = 1;
            $button_2_url = str_replace('#', '', $button_2_url);
          }
          ?>
          <a <?php echo $show_fancy ? 'data-fancybox' : ''; ?> <?php echo $button_2_url && $button_2_url != '#' ? 'href="'.$button_2_url.'"' : '' ?> target="<?php echo $button_2_target ?>" class="btn btn-secondary-alt <?php echo $show_fancy ? 'fancybox' : '' ?>"><?php echo $button_2_title ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div><!-- End banner-content-wrapper -->
    
    <?php if($iframe_url): ?>
    <div class="banner-iframe-wrapper">
      <iframe src="<?php echo esc_url($iframe_url); ?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <?php endif; ?>

    <?php if($lottie && $lottieimage): ?>
      <div class="background-area d-none">
        <lottie-player src="<?php echo $lottie['url'] ?>" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
    <?php endif; ?>
  </div>
  
  <?php if($layout_style == 'text_with_bottom_image'): ?>
  <div class="banner-bottom-image-container">
    <?php if($banner_image && !($lottie && $lottieimage)): ?>
      <div class="image-wrapper">
        <img src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>" class="banner-image">
      </div>
    <?php endif; ?>
    
    <?php if($lottie && $lottieimage): ?>
      <div class="lottie-wrapper">
        <lottie-player src="<?php echo $lottie['url'] ?>" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
    <?php endif; ?>
  </div>
  <?php endif; ?>
  </div>
</section>
<?php
endif;
