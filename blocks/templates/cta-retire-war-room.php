<?php
/**
 * CTA - Ready to Retire the 3 AM War Room Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'cta-retire-war-room-' . uniqid());

// Get fields
$title = get_field('title') ?: '';
$description = get_field('description') ?: '';
$button_1 = get_field('button_1') ?: '';
$button_2 = get_field('button_2') ?: '';

// Only display if we have content
if ($title || $description || $button_1 || $button_2):
?>
<section id="<?php echo esc_attr($id); ?>" class="cta-retire-war-room">
    <div class="container">
        <div class="cta-content">
            <?php if ($title): ?>
            <h2 class="cta-title" data-aos="fade-up" data-aos-duration="700"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            
            <?php if ($description): ?>
            <p class="cta-description" data-aos="fade-up" data-aos-delay="100" data-aos-duration="700"><?php echo wp_kses_post(nl2br($description)); ?></p>
            <?php endif; ?>
            
            <?php if ($button_1 || $button_2): ?>
            <div class="cta-buttons" data-aos="fade-up" data-aos-delay="200" data-aos-duration="700">
                <?php if ($button_1 && !empty($button_1['url']) && !empty($button_1['title'])): 
                    $button_1_url = $button_1['url'];
                    $button_1_title = $button_1['title'];
                    $button_1_target = isset($button_1['target']) ? $button_1['target'] : '_self';
                ?>
                <a href="<?php echo esc_url($button_1_url); ?>" target="<?php echo esc_attr($button_1_target); ?>" class="btn btn-primary"><?php echo esc_html($button_1_title); ?></a>
                <?php endif; ?>
                
                <?php if ($button_2 && !empty($button_2['url']) && !empty($button_2['title'])): 
                    $button_2_url = $button_2['url'];
                    $button_2_title = $button_2['title'];
                    $button_2_target = isset($button_2['target']) ? $button_2['target'] : '_self';
                ?>
                <a href="<?php echo esc_url($button_2_url); ?>" target="<?php echo esc_attr($button_2_target); ?>" class="btn btn-secondary"><?php echo esc_html($button_2_title); ?></a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
endif;
?>

