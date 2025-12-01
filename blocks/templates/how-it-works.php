<?php
/**
 * How It Works Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'how-it-works-' . uniqid());

// Get fields
$how_title = get_field('how_title') ?: '';
$how_description = get_field('how_description') ?: '';
$steps = get_field('steps') ?: [];
$button_2 = get_field('button_2') ?: '';
$metrics = get_field('metrics') ?: [];
$metrics_footnote = get_field('metrics_footnote') ?: '';
$webinars_title = get_field('webinars_title') ?: '';
$webinars_description = get_field('webinars_description') ?: '';
$webinars = get_field('webinars') ?: [];

// Only display if we have content
if ($how_title || !empty($steps) || !empty($metrics) || !empty($webinars)):
?>
<section id="<?php echo esc_attr($id); ?>" class="how-it-works">
    <?php if ($how_title || $how_description || !empty($steps)): ?>
    <div class="how-section">
        <div class="container">
            <?php if ($how_title || $how_description): ?>
            <div class="how-header" data-aos="fade-up" data-aos-duration="700">
                <?php if ($how_title): ?>
                <h2 class="how-title"><?php echo esc_html($how_title); ?></h2>
                <?php endif; ?>
                
                <?php if ($how_description): ?>
                <p class="how-description"><?php echo wp_kses_post(nl2br($how_description)); ?></p>
                <?php endif; ?>
                <?php if ($button_2 && !empty($button_2['url']) && !empty($button_2['title'])): 
                    $button_2_url = $button_2['url'];
                    $button_2_title = $button_2['title'];
                    $button_2_target = isset($button_2['target']) ? $button_2['target'] : '_self';
                ?>
                <div class="how-cta">
                    <a href="<?php echo esc_url($button_2_url); ?>" target="<?php echo esc_attr($button_2_target); ?>" class="btn btn-orange how-btn-2"><?php echo esc_html($button_2_title); ?></a>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($steps)): ?>
            <div class="steps-grid">
                <?php foreach ($steps as $index => $step): 
                    $step_number = $step['step_number'] ?? '';
                    $step_label = $step['step_label'] ?? '';
                    $step_title = $step['step_title'] ?? '';
                    $step_description = $step['step_description'] ?? '';
                    
                    if (!$step_title) continue;
                ?>
                <div class="step-card" data-step-number="<?php echo esc_attr($step_number); ?>" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="step-label"><?php echo esc_html($step_label); ?></div>
                    <h3 class="step-title"><?php echo esc_html($step_title); ?></h3>
                    <p class="step-description"><?php echo wp_kses_post(nl2br($step_description)); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($metrics)): ?>
    <div class="metrics-section">
        <div class="container">
            <div class="metrics-grid">
                <?php foreach ($metrics as $index => $metric): 
                    $metric_value = $metric['metric_value'] ?? '';
                    $metric_label = $metric['metric_label'] ?? '';
                    
                    if (!$metric_value || !$metric_label) continue;
                ?>
                <div class="metric-card" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="metric-value"><?php echo esc_html($metric_value); ?></div>
                    <div class="metric-label"><?php echo esc_html($metric_label); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ($metrics_footnote): ?>
            <p class="metrics-footnote"><?php echo esc_html($metrics_footnote); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if ($webinars_title || $webinars_description || !empty($webinars)): ?>
    <div class="webinars-section">
        <div class="container">
            <div class="webinars-icon" aria-hidden="true"></div>
            <?php if ($webinars_title || $webinars_description): ?>
            <div class="webinars-header" data-aos="fade-up" data-aos-duration="700">
                <?php if ($webinars_title): ?>
                <h2 class="webinars-title"><?php echo esc_html($webinars_title); ?></h2>
                <?php endif; ?>
                
                <?php if ($webinars_description): ?>
                <p class="webinars-description"><?php echo esc_html($webinars_description); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($webinars)): ?>
            <div class="webinars-grid">
                <?php foreach ($webinars as $index => $webinar): 
                    $webinar_type = $webinar['webinar_type'] ?? '';
                    $webinar_title = $webinar['webinar_title'] ?? '';
                    $webinar_description = $webinar['webinar_description'] ?? '';
                    $webinar_button_text = $webinar['webinar_button_text'] ?? '';
                    $webinar_button_url = $webinar['webinar_button_url'] ?? '';
                    $webinar_button_style = $webinar['webinar_button_style'] ?? 'primary';
                    
                    if (!$webinar_title) continue;
                    
                    $button_class = $webinar_button_style === 'primary' ? 'btn-primary' : 'btn-secondary';
                ?>
                <div class="webinar-card" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                        <?php if ($webinar_type): ?>
                    <div class="webinar-type"><?php echo esc_html($webinar_type); ?></div>
                    <?php endif; ?>
                    
                    <h3 class="webinar-title"><?php echo esc_html($webinar_title); ?></h3>
                    
                    <?php if ($webinar_description): ?>
                    <p class="webinar-description"><?php echo wp_kses_post(nl2br($webinar_description)); ?></p>
                    <?php endif; ?>
                    
                    <?php if ($webinar_button_text && $webinar_button_url): ?>
                    <div class="webinar-cta">
                        <a href="<?php echo esc_url($webinar_button_url); ?>" class="btn <?php echo esc_attr($button_class); ?>"><?php echo esc_html($webinar_button_text); ?></a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="webinars-grid">
                <div class="webinar-card" data-aos="fade-up">
                    <h3 class="webinar-title"><?php echo esc_html__('Coming Soon', 'neubird'); ?></h3>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</section>
<?php
endif;
?>

