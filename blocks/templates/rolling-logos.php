<?php
/**
 * Rolling Logos Block Template
 */

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'rolling-logos-'.uniqid());

// Get fields from ACF
$section_title = get_field('section_title') ?: '';
$section_subtitle = get_field('section_subtitle') ?: '';
$display_mode = get_field('display_mode') ?: 'all';
$manual_picker = get_field('manual_picker') ?: array();
$logos_limit = get_field('logos_limit') ?: 12;
$client_logos = get_field('client_logos') ?: array();
$animation_speed = get_field('animation_speed') ?: 'medium';
$background_style = get_field('background_style') ?: 'light';

// Get logos based on display mode
$integration_posts = array();
$display_client_logos = array();

if($display_mode === 'integrations_manual' && !empty($manual_picker)) {
    // Use manually selected integrations
    $integration_posts = $manual_picker;
} elseif($display_mode === 'integrations_all') {
    // Query all published integrations
    $query_args = array(
        'post_type' => 'integrations',
        'post_status' => 'publish',
        'posts_per_page' => $logos_limit,
        'orderby' => 'title',
        'order' => 'ASC',
        'fields' => 'ids'
    );
    
    $integration_query = new WP_Query($query_args);
    if($integration_query->have_posts()) {
        $integration_posts = $integration_query->posts;
    }
    wp_reset_postdata();
} elseif($display_mode === 'client_logos') {
    // Use manual client logos
    $display_client_logos = $client_logos;
}

// Only display if we have logos to show
if(!empty($integration_posts) || !empty($display_client_logos)):
    
    // Set speed class based on selection
    $speed_class = '';
    switch($animation_speed) {
        case 'ultra-slow':
            $speed_class = 'speed-ultra-slow';
            break;
        case 'glacial':
            $speed_class = 'speed-glacial';
            break;
        case 'very-slow':
            $speed_class = 'speed-very-slow';
            break;
        case 'slow':
            $speed_class = 'speed-slow';
            break;
        case 'fast':
            $speed_class = 'speed-fast';
            break;
        case 'very-fast':
            $speed_class = 'speed-very-fast';
            break;
        case 'medium':
        default:
            $speed_class = 'speed-medium';
            break;
    }
    
    // Set background class
    $bg_class = '';
    switch($background_style) {
        case 'white':
            $bg_class = 'bg-white';
            break;
        case 'transparent':
            $bg_class = 'bg-transparent';
            break;
        case 'light':
        default:
            $bg_class = 'bg-light';
            break;
    }
?>

<section class="rolling-logos-block <?php echo esc_attr($bg_class); ?>" id="<?php echo esc_attr($id); ?>">
    <div class="container">
        <?php if($section_title || $section_subtitle): ?>
        <div class="logos-header text-center" data-aos="fade-up">
            <?php if($section_title): ?>
                <h3 class="logos-title"><?php echo esc_html($section_title); ?></h3>
            <?php endif; ?>
            
            <?php if($section_subtitle): ?>
                <p class="logos-subtitle"><?php echo esc_html($section_subtitle); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="logos-container" data-aos="fade-in" id="logos-container-<?php echo esc_attr($id); ?>">
            <div class="logo-track <?php echo esc_attr($speed_class); ?>" id="logo-track-<?php echo esc_attr($id); ?>">
                    <?php if(!empty($integration_posts)): ?>
                        <?php foreach($integration_posts as $post_id): 
                            $logo = get_field('logo', $post_id);
                            $post_title = get_the_title($post_id);
                            $enable_post_page = get_field('enable_post_page', $post_id);
                            $third_party_link = get_field('3rd_party_link', $post_id);
                            $permalink = get_permalink($post_id);
                            
                            // Set up link target
                            $link_url = $permalink;
                            $link_target = '_self';
                            
                            if($third_party_link) {
                                $link_url = $third_party_link;
                                $link_target = '_blank';
                            }
                            
                            if($logo):
                        ?>
                        <div class="logo-item">
                            <?php if($enable_post_page !== false && ($permalink || $third_party_link)): ?>
                                <a href="<?php echo esc_url($link_url); ?>" 
                                   target="<?php echo esc_attr($link_target); ?>"
                                   <?php echo $link_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                                   aria-label="Learn more about <?php echo esc_attr($post_title); ?>">
                                    <img src="<?php echo esc_url($logo['url']); ?>" 
                                         alt="<?php echo esc_attr($logo['alt'] ?: $post_title . ' Logo'); ?>"
                                         loading="eager"
                                         decoding="async"
                                         style="width: auto; height: 60px; max-width: 150px; object-fit: contain;"
                                         class="logo-image" />
                                </a>
                            <?php else: ?>
                                <img src="<?php echo esc_url($logo['url']); ?>" 
                                     alt="<?php echo esc_attr($logo['alt'] ?: $post_title . ' Logo'); ?>"
                                     loading="eager"
                                     decoding="async"
                                     style="width: auto; height: 60px; max-width: 150px; object-fit: contain;"
                                     class="logo-image" />
                            <?php endif; ?>
                        </div>
                        <?php 
                            endif;
                        endforeach; ?>
                    <?php elseif(!empty($display_client_logos)): ?>
                        <?php foreach($display_client_logos as $client_logo): 
                            $client_name = $client_logo['client_name'] ?: '';
                            $client_logo_image = $client_logo['client_logo_image'] ?: '';
                            $client_url = $client_logo['client_url'] ?: '';
                            
                            if($client_logo_image && $client_name):
                        ?>
                        <div class="logo-item">
                            <?php if($client_url): ?>
                                <a href="<?php echo esc_url($client_url); ?>" 
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   aria-label="Learn more about <?php echo esc_attr($client_name); ?>">
                                    <img src="<?php echo esc_url($client_logo_image['url']); ?>" 
                                         alt="<?php echo esc_attr($client_logo_image['alt'] ?: $client_name . ' Logo'); ?>"
                                         loading="eager"
                                         decoding="async"
                                         style="width: auto; height: 60px; max-width: 150px; object-fit: contain;"
                                         class="logo-image" />
                                </a>
                            <?php else: ?>
                                <img src="<?php echo esc_url($client_logo_image['url']); ?>" 
                                     alt="<?php echo esc_attr($client_logo_image['alt'] ?: $client_name . ' Logo'); ?>"
                                     loading="eager"
                                     decoding="async"
                                     style="width: auto; height: 60px; max-width: 150px; object-fit: contain;"
                                     class="logo-image" />
                            <?php endif; ?>
                        </div>
                        <?php 
                            endif;
                        endforeach; ?>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
endif;
?>

<style>
.rolling-logos-block {
    overflow: hidden;
    padding: 40px 0;
    position: relative;
}

.logos-container {
    width: 100%;
    height: 80px;
    position: relative;
    overflow: hidden;
    mask: linear-gradient(90deg, transparent, black 2%, black 98%, transparent);
    -webkit-mask: linear-gradient(90deg, transparent, black 2%, black 98%, transparent);
}

.logo-track {
    display: flex;
    align-items: center;
    height: 100%;
    width: max-content;
    animation-duration: 30s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-name: scrollLeft;
    will-change: transform;
    backface-visibility: hidden;
}

/* Speed variations */
.logo-track.speed-glacial {
    animation-duration: 120s;
}

.logo-track.speed-ultra-slow {
    animation-duration: 100s;
}

.logo-track.speed-very-slow {
    animation-duration: 60s;
}

.logo-track.speed-slow {
    animation-duration: 45s;
}

.logo-track.speed-medium {
    animation-duration: 30s;
}

.logo-track.speed-fast {
    animation-duration: 15s;
}

.logo-track.speed-very-fast {
    animation-duration: 10s;
}

.logo-item {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 60px;
    min-width: 120px;
    margin: 0 25px;
    flex-shrink: 0;
}

.logo-item a,
.logo-item img {
    display: block;
    max-height: 100%;
    width: auto;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.logo-item:hover img {
    transform: scale(1.1);
}

.logo-track:hover {
    animation-play-state: paused;
}

/* Keyframe animation for right-to-left scrolling */
@keyframes scrollLeft {
    0% {
        transform: translate3d(-50%, 0, 0);
    }
    100% {
        transform: translate3d(0, 0, 0);
    }
}

@media (prefers-reduced-motion: reduce) {
    .logo-track {
        animation: none !important;
        transform: none !important;
    }
}
</style>

<script>
// Duplicate logos for seamless infinite scroll
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('logo-track-<?php echo esc_attr($id); ?>');
    if (!track) return;
    
    const logoItems = Array.from(track.children);
    logoItems.forEach(item => {
        const clone = item.cloneNode(true);
        track.appendChild(clone);
    });
});
</script>
