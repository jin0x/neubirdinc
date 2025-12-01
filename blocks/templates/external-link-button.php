<?php
/**
 * External Link Button Block Template
 */

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'external-button-'.uniqid());

// Get fields from ACF
$button_text = get_field('button_text') ?: 'Learn More';
$external_url = get_field('external_url') ?: '';
$open_new_tab = get_field('open_new_tab');
$button_style = get_field('button_style') ?: 'primary';

// Only display if we have both text and URL
if($button_text && $external_url):
    
    // Set target attribute
    $target = $open_new_tab ? '_blank' : '_self';
    $rel = $open_new_tab ? 'rel="noopener noreferrer"' : '';
    
    // Set button classes based on style
    $button_classes = 'btn';
    switch($button_style) {
        case 'secondary':
            $button_classes .= ' btn-secondary';
            break;
        case 'outline':
            $button_classes .= ' btn-outline';
            break;
        case 'primary':
        default:
            $button_classes .= ' btn-primary';
            break;
    }
?>

<section class="external-link-button-block" id="<?php echo esc_attr($id); ?>">
    <div class="content-area">
        <div class="button-wrapper text-center">
            <a href="<?php echo esc_url($external_url); ?>" 
               target="<?php echo esc_attr($target); ?>" 
               <?php echo $rel; ?>
               class="<?php echo esc_attr($button_classes); ?>"
               aria-label="<?php echo esc_attr($button_text); ?>">
                <?php echo esc_html($button_text); ?>
            </a>
        </div>
    </div>
</section>

<?php
endif;
?>
