<?php
/**
 * Features Grid Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'features-grid-' . uniqid());

// Get fields
$section_title = get_field('section_title') ?: '';
$section_description = get_field('section_description') ?: '';
$features = get_field('features') ?: [];

// Only display if we have features
$valid_features = array_filter($features, function($feature) {
    return !empty($feature['title']) && !empty($feature['description']);
});

if (!empty($valid_features)):
?>
<section id="<?php echo esc_attr($id); ?>" class="features-grid">
    <div class="container">
        <?php if ($section_title || $section_description): ?>
        <div class="features-header" data-aos="fade-up" data-aos-duration="700">
            <?php if ($section_title): ?>
            <h2 class="features-title"><?php echo esc_html($section_title); ?></h2>
            <?php endif; ?>
            
            <?php if ($section_description): ?>
            <p class="features-description"><?php echo wp_kses_post(nl2br($section_description)); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="features-grid-container">
            <?php foreach ($valid_features as $index => $feature): 
                $feature_title = $feature['title'] ?? '';
                $feature_description = $feature['description'] ?? '';
            ?>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                <div class="feature-title"><?php echo esc_html($feature_title); ?></div>
                <p class="feature-description"><?php echo wp_kses_post(nl2br($feature_description)); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
endif;
?>

