<?php
$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'pricing-hero-'.uniqid());

// Get fields from ACF
$heading = get_field('heading') ? : '';
$subheading = get_field('subheading') ? : '';
$description = get_field('description') ? : '';
$badge_1 = get_field('badge_1') ? : '';
$badge_2 = get_field('badge_2') ? : '';
$button_1 = get_field('button_1') ? : '';
$button_2 = get_field('button_2') ? : '';
$background_image = get_field('background_image') ? : '';

if($heading || $subheading || $description || $button_1 || $button_2){
    ?>
    <section class="pricing-hero" id="<?php echo esc_attr($id); ?>" <?php if($background_image): ?> style="background-image: url('<?php echo esc_url($background_image['url']); ?>');"<?php endif; ?>>
        <?php if($background_image): ?>
            <div class="overlay"></div>
        <?php endif; ?>
        <div class="container">
            <div class="content-area">
                <div class="text-area text-center">
                    <?php if($heading): ?>
                        <h2 class="pricing-hero-heading"><?php echo esc_html($heading); ?></h2>
                    <?php endif; ?>

                    <?php if($subheading): ?>
                        <h2 class="pricing-hero-subheading"><?php echo esc_html($subheading); ?></h2>
                    <?php endif; ?>

                    <?php if($description): ?>
                        <div class="pricing-hero-description">
                            <?php echo wp_kses_post($description); ?>
                        </div>
                    <?php endif; ?>

                    <?php if($badge_1 || $badge_2): ?>
                        <div class="pricing-hero-badges">
                            <?php if($badge_1): ?>
                                <span class="pricing-hero-badge"><?php echo esc_html($badge_1); ?></span>
                            <?php endif; ?>
                            <?php if($badge_2): ?>
                                <span class="pricing-hero-badge"><?php echo esc_html($badge_2); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if($button_1 || $button_2): ?>
                        <div class="btn-area">
                            <?php if($button_1):
                                $button_1_url = isset($button_1['url']) ? $button_1['url'] : '';
                                $button_1_title = isset($button_1['title']) ? $button_1['title'] : 'Start free trial';
                                $button_1_target = isset($button_1['target']) ? $button_1['target'] : '_self';
                            ?>
                                <a <?php echo $button_1_url && $button_1_url != '#' ? 'href="'.esc_url($button_1_url).'"' : '' ?> target="<?php echo esc_attr($button_1_target); ?>" class="btn btn-orange"><?php echo esc_html($button_1_title); ?></a>
                            <?php endif; ?>
                            
                            <?php if($button_2):
                                $button_2_url = isset($button_2['url']) ? $button_2['url'] : '';
                                $button_2_title = isset($button_2['title']) ? $button_2['title'] : 'Compare Plans';
                                // If button text is "Compare Plans" and URL is empty or #, default to #compare
                                if((strtolower($button_2_title) === 'compare plans') && (empty($button_2_url) || $button_2_url === '#')) {
                                    $button_2_url = '#compare';
                                }
                                $button_2_target = isset($button_2['target']) ? $button_2['target'] : '_self';
                            ?>
                                <a <?php echo $button_2_url && $button_2_url != '#' ? 'href="'.esc_url($button_2_url).'"' : ($button_2_url === '#compare' ? 'href="#compare"' : '') ?> target="<?php echo esc_attr($button_2_target); ?>" class="btn btn-green-primary"><?php echo esc_html($button_2_title); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}

