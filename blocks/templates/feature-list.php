<?php
/**
 * Feature List Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'feature-list-' . uniqid());

// Get fields
$main_title = get_field('main_title') ?: '';
$main_title_badge = get_field('main_title_badge') ?: '';
$badges = get_field('badges') ?: [];
$section_title = get_field('section_title') ?: '';
$items = get_field('items') ?: [];
$cta_button = get_field('cta_button') ?: '';
$show_attribution = get_field('show_attribution') ?: true;
$attribution_prefix = get_field('attribution_prefix') ?: 'Powered by';
$attribution_logo = get_field('attribution_logo') ?: '';
$attribution_text = get_field('attribution_text') ?: '';
$layout_style = get_field('layout_style') ?: 'simple';
$use_lottie = get_field('use_lottie') ?: false;
$lottie_file = get_field('lottie_file') ?: '';
$video_url = get_field('video_url') ?: '';

// Only display if we have items or main title
if (!empty($items) || $main_title):
?>
<section id="<?php echo esc_attr($id); ?>" class="feature-list-block layout-<?php echo esc_attr($layout_style); ?>">
    <div class="container">
        <?php if ($layout_style === 'with_media' && ($lottie_file || $video_url)): ?>
        <div class="feature-list-with-media">
            <div class="feature-list-media" data-aos="fade-right" data-aos-duration="700">
                <?php if ($use_lottie && $lottie_file): ?>
                <div class="feature-list-lottie">
                    <lottie-player src="<?php echo esc_url($lottie_file['url']); ?>" background="transparent" speed="1" loop autoplay></lottie-player>
                </div>
                <?php elseif ($video_url): ?>
                <div class="feature-list-video">
                    <?php
                    // Convert YouTube/Vimeo URLs to embed format
                    $embed_url = $video_url;
                    if (strpos($video_url, 'youtube.com/watch') !== false) {
                        parse_str(parse_url($video_url, PHP_URL_QUERY), $params);
                        $embed_url = 'https://www.youtube.com/embed/' . ($params['v'] ?? '');
                    } elseif (strpos($video_url, 'youtu.be/') !== false) {
                        $video_id = substr(parse_url($video_url, PHP_URL_PATH), 1);
                        $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                    } elseif (strpos($video_url, 'vimeo.com/') !== false) {
                        $video_id = substr(parse_url($video_url, PHP_URL_PATH), 1);
                        $embed_url = 'https://player.vimeo.com/video/' . $video_id;
                    }
                    ?>
                    <iframe src="<?php echo esc_url($embed_url); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="feature-list-content-wrapper" data-aos="fade-left" data-aos-duration="700" data-aos-delay="100">
                <?php if ($main_title): ?>
                <div class="feature-list-main-header" data-aos="fade-up" data-aos-duration="700">
                    <div class="main-title-wrapper">
                        <h2 class="feature-list-main-title"><?php echo esc_html($main_title); ?></h2>
                    </div>
                    
                    <?php if (!empty($badges)): ?>
                    <div class="feature-badges" data-aos="fade-up" data-aos-delay="100">
                        <?php foreach ($badges as $badge): 
                            $badge_text = $badge['badge_text'] ?? '';
                            if (empty($badge_text)) continue;
                        ?>
                        <span class="feature-badge"><?php echo esc_html($badge_text); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <?php if ($section_title): ?>
                <div class="feature-list-header" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                    <h2 class="feature-list-title"><?php echo esc_html($section_title); ?></h2>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($items)): ?>
                <div class="feature-list-items">
                    <?php foreach ($items as $index => $item): 
                        $item_text = $item['item_text'] ?? '';
                        if (empty($item_text)) continue;
                    ?>
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 50; ?>">
                        <div class="feature-item-content">
                            <?php echo wp_kses_post(nl2br($item_text)); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
            <?php if ($main_title): ?>
            <div class="feature-list-main-header" data-aos="fade-up" data-aos-duration="700">
                <div class="main-title-wrapper">
                    <h2 class="feature-list-main-title"><?php echo esc_html($main_title); ?></h2>
                </div>
                
                <?php if (!empty($badges)): ?>
                <div class="feature-badges" data-aos="fade-up" data-aos-delay="100">
                    <?php foreach ($badges as $badge): 
                        $badge_text = $badge['badge_text'] ?? '';
                        if (empty($badge_text)) continue;
                    ?>
                    <span class="feature-badge"><?php echo esc_html($badge_text); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($section_title): ?>
            <div class="feature-list-header" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                <h2 class="feature-list-title"><?php echo esc_html($section_title); ?></h2>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($items)): ?>
            <div class="feature-list-items" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                <?php foreach ($items as $index => $item): 
                    $item_text = $item['item_text'] ?? '';
                    if (empty($item_text)) continue;
                ?>
                <div class="feature-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 50; ?>">
                    <div class="feature-item-content">
                        <?php echo wp_kses_post(nl2br($item_text)); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if ($cta_button && !empty($cta_button['url'])): 
            $cta_url = $cta_button['url'];
            $cta_title = $cta_button['title'] ?? 'Get Started';
            $cta_target = isset($cta_button['target']) ? $cta_button['target'] : '_self';
        ?>
        <div class="feature-list-cta" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
            <a href="<?php echo esc_url($cta_url); ?>" target="<?php echo esc_attr($cta_target); ?>" class="btn btn-primary feature-list-cta-button">
                <?php echo esc_html($cta_title); ?>
            </a>
        </div>
        <?php endif; ?>
        
        <?php if ($show_attribution && ($attribution_logo || $attribution_text)): ?>
        <div class="feature-list-attribution" data-aos="fade-up" data-aos-duration="700" data-aos-delay="300">
            <?php if ($attribution_prefix): ?>
            <span class="attribution-prefix"><?php echo esc_html($attribution_prefix); ?></span>
            <?php endif; ?>
            
            <?php if ($attribution_logo): ?>
            <div class="attribution-logo">
                <img src="<?php echo esc_url($attribution_logo['url']); ?>" 
                     alt="<?php echo esc_attr($attribution_logo['alt'] ?: 'Logo'); ?>" 
                     class="img-fluid">
            </div>
            <?php endif; ?>
            
            <?php if ($attribution_text): ?>
            <span class="attribution-text"><?php echo esc_html($attribution_text); ?></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
endif;
?>

