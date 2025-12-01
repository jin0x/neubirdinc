<?php
/**
 * Steps Grid Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'steps-grid-' . uniqid());

// Get fields
$section_title = get_field('section_title') ?: '';
$section_description = get_field('section_description') ?: '';
$columns = get_field('columns') ?: '3';
$steps = get_field('steps') ?: [];
$cta_button = get_field('cta_button') ?: '';

// Only display if we have steps
if (!empty($steps)):
?>
<section id="<?php echo esc_attr($id); ?>" class="steps-grid-block columns-<?php echo esc_attr($columns); ?>">
    <div class="container">
        <?php if ($section_title || $section_description): ?>
        <div class="steps-grid-header" data-aos="fade-up" data-aos-duration="700">
            <?php if ($section_title): ?>
            <h2 class="steps-grid-title"><?php echo esc_html($section_title); ?></h2>
            <?php endif; ?>
            
            <?php if ($section_description): ?>
            <p class="steps-grid-description"><?php echo wp_kses_post(nl2br($section_description)); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($steps)): ?>
        <div class="steps-grid-container">
            <?php foreach ($steps as $index => $step): 
                $step_icon = $step['step_icon'] ?? '';
                $step_icon_color = $step['step_icon_color'] ?? 'green';
                $step_title = $step['step_title'] ?? '';
                $step_description = $step['step_description'] ?? '';
                $step_link = $step['step_link'] ?? '';
                
                if (!$step_title) continue;
                
                $has_icon = !empty($step_icon);
                $icon_color_class = ($has_icon && $step_icon_color !== 'none') ? 'icon-color-' . esc_attr($step_icon_color) : '';
                $preserve_original_colors = ($step_icon_color === 'none');
                $has_link = !empty($step_link) && !empty($step_link['url']);
                $link_url = $has_link ? $step_link['url'] : '';
                $link_target = $has_link ? ($step_link['target'] ?? '_self') : '_self';
            ?>
            <div class="step-card <?php echo $has_icon ? 'has-icon' : ''; ?> <?php echo $has_link ? 'has-link' : ''; ?>" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                <?php if ($has_link): ?>
                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="step-card-link" aria-label="<?php echo esc_attr($step_title); ?>"></a>
                <?php endif; ?>
                
                <?php if (!$has_icon): ?>
                <div class="step-number-indicator">
                    <span class="step-number"><?php echo $index + 1; ?></span>
                </div>
                <?php endif; ?>
                
                <div class="step-content">
                    <?php if ($step_title): ?>
                    <h3 class="step-title"><?php echo esc_html($step_title); ?></h3>
                    <?php endif; ?>
                    
                    <?php if ($step_description): ?>
                    <div class="step-description"><?php echo wp_kses_post(nl2br($step_description)); ?></div>
                    <?php endif; ?>
                </div>
                
                <?php if ($has_icon): ?>
                <div class="step-icon-wrapper <?php echo esc_attr($icon_color_class); ?>">
                    <?php 
                    $icon_url = $step_icon['url'] ?? '';
                    $icon_mime = $step_icon['mime_type'] ?? '';
                    $icon_path = $step_icon['path'] ?? '';
                    
                    // Check if it's an SVG
                    if (strpos($icon_mime, 'svg') !== false || strpos($icon_url, '.svg') !== false) {
                        // Try to get SVG content
                        $svg_content = '';
                        if ($icon_path && file_exists($icon_path)) {
                            $svg_content = file_get_contents($icon_path);
                        } elseif ($icon_url) {
                            // Try to get from URL if path not available
                            $upload_dir = wp_upload_dir();
                            $relative_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $icon_url);
                            if (file_exists($relative_path)) {
                                $svg_content = file_get_contents($relative_path);
                            }
                        }
                        
                        if ($svg_content) {
                            // Only remove fill/stroke if we're applying a color override
                            if (!$preserve_original_colors) {
                                // Remove existing fill and stroke attributes from SVG
                                $svg_content = preg_replace('/fill=["\'][^"\']*["\']/i', '', $svg_content);
                                $svg_content = preg_replace('/stroke=["\'][^"\']*["\']/i', '', $svg_content);
                                $svg_content = preg_replace('/style=["\'][^"\']*fill[^"\']*["\']/i', '', $svg_content);
                            }
                            
                            // Add width and height attributes if missing for better rendering
                            if (strpos($svg_content, 'width=') === false) {
                                $svg_content = preg_replace('/<svg/i', '<svg width="72" height="72"', $svg_content);
                            }
                            if (strpos($svg_content, 'viewBox=') === false && strpos($svg_content, 'width=') !== false) {
                                // Try to extract width/height and create viewBox
                                preg_match('/width=["\'](\d+)["\']/', $svg_content, $width_match);
                                preg_match('/height=["\'](\d+)["\']/', $svg_content, $height_match);
                                if (!empty($width_match[1]) && !empty($height_match[1])) {
                                    $svg_content = preg_replace('/<svg/i', '<svg viewBox="0 0 ' . $width_match[1] . ' ' . $height_match[1] . '"', $svg_content);
                                }
                            }
                            
                            echo '<div class="step-icon-svg">';
                            echo $svg_content;
                            echo '</div>';
                        } else {
                            // Fallback to img tag if can't read SVG
                            echo '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($step_icon['alt'] ?: $step_title) . '" class="step-icon-img">';
                        }
                    } else {
                        // For other image types, use img tag
                        echo '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($step_icon['alt'] ?: $step_title) . '" class="step-icon-img">';
                    }
                    ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($cta_button && !empty($cta_button['url'])): 
            $cta_url = $cta_button['url'];
            $cta_title = $cta_button['title'] ?? 'Learn More';
            $cta_target = isset($cta_button['target']) ? $cta_button['target'] : '_self';
        ?>
        <div class="steps-grid-cta" data-aos="fade-up" data-aos-delay="300">
            <a href="<?php echo esc_url($cta_url); ?>" target="<?php echo esc_attr($cta_target); ?>" class="btn btn-primary"><?php echo esc_html($cta_title); ?></a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
endif;
?>

