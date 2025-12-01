<?php
/**
 * WYSIWIG Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'wysiwig-' . uniqid());

$text = get_field('text') ?: '';
$content_alignment = get_field('content_alignment') ?: 'left';
$max_width = get_field('max_width') ?: '1200px';
$background_color = get_field('background_color') ?: 'transparent';
$vertical_padding = get_field('vertical_padding') ?: 'medium';
$image = get_field('image') ?: '';
$image_position = get_field('image_position') ?: 'right';

if ($text):
    // Map background color values to CSS classes
    $bg_class = '';
    switch ($background_color) {
        case 'white':
            $bg_class = 'bg-white';
            break;
        case 'light-gray':
            $bg_class = 'bg-light-gray';
            break;
        case 'dark':
            $bg_class = 'bg-dark';
            break;
        default:
            $bg_class = 'bg-transparent';
    }
    
    // Map padding values to CSS classes
    $padding_class = '';
    switch ($vertical_padding) {
        case 'none':
            $padding_class = 'padding-none';
            break;
        case 'small':
            $padding_class = 'padding-small';
            break;
        case 'medium':
            $padding_class = 'padding-medium';
            break;
        case 'large':
            $padding_class = 'padding-large';
            break;
        case 'xlarge':
            $padding_class = 'padding-xlarge';
            break;
        default:
            $padding_class = 'padding-medium';
    }
    
    // Map max width values
    $max_width_value = $max_width === 'full' ? '100%' : $max_width;
    
    // Add image class if image exists
    $has_image_class = $image ? 'has-image image-' . $image_position : '';
?>
<section id="<?php echo esc_attr($id); ?>" class="wysiwig-block <?php echo esc_attr($bg_class); ?> <?php echo esc_attr($padding_class); ?> <?php echo esc_attr($has_image_class); ?>">
    <div class="wysiwig-container" style="max-width: <?php echo esc_attr($max_width_value); ?>;">
        <div class="wysiwig-inner-wrapper">
            <div class="wysiwig-content wysiwig-align-<?php echo esc_attr($content_alignment); ?>">
                <?php echo wp_kses_post($text); ?>
            </div>
            
            <?php if($image): ?>
            <div class="wysiwig-image">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="img-fluid">
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
endif;