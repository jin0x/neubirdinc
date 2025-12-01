<?php
/**
 * Process Steps Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'process-steps-' . uniqid());

// Get fields
$section_title = get_field('section_title') ?: '';
$section_description = get_field('section_description') ?: '';
$layout_direction = get_field('layout_direction') ?: 'right';
$steps = get_field('steps') ?: [];
$cta_button = get_field('cta_button') ?: '';

// Only display if we have steps
if (!empty($steps)):
?>
<section id="<?php echo esc_attr($id); ?>" class="process-steps">
    <div class="container">
        <?php if ($section_title || $section_description): ?>
        <div class="process-steps-header" data-aos="fade-up" data-aos-duration="700">
            <?php if ($section_title): ?>
            <h2 class="process-steps-title"><?php echo esc_html($section_title); ?></h2>
            <?php endif; ?>
            
            <?php if ($section_description): ?>
            <p class="process-steps-description"><?php echo wp_kses_post(nl2br($section_description)); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($steps)): ?>
        <div class="process-steps-list">
            <?php foreach ($steps as $index => $step): 
                $step_title = $step['step_title'] ?? '';
                $step_description = $step['step_description'] ?? '';
                
                if (!$step_title) continue;
            ?>
            <div class="process-step-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 50; ?>">
                <div class="process-step-content">
                    <div class="process-step-number">
                        <span class="step-number-badge"><?php echo $index + 1; ?></span>
                    </div>
                    <div class="process-step-text">
                        <?php if ($step_title): ?>
                        <h3 class="process-step-title"><?php echo esc_html($step_title); ?></h3>
                        <?php endif; ?>
                        
                        <?php if ($step_description): ?>
                        <div class="process-step-description"><?php echo wp_kses_post(nl2br($step_description)); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($cta_button && !empty($cta_button['url'])): 
            $cta_url = $cta_button['url'];
            $cta_title = $cta_button['title'] ?? 'Learn More';
            $cta_target = isset($cta_button['target']) ? $cta_button['target'] : '_self';
        ?>
        <div class="process-steps-cta" data-aos="fade-up" data-aos-delay="300">
            <a href="<?php echo esc_url($cta_url); ?>" target="<?php echo esc_attr($cta_target); ?>" class="btn btn-primary"><?php echo esc_html($cta_title); ?></a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
endif;
?>

