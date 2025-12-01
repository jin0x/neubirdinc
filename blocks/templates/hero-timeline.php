<?php
/**
 * Hero with Timeline Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'hero-timeline-' . uniqid());

// Get fields
$pretitle = get_field('pretitle') ?: '';
$title = get_field('title') ?: '';
$description = get_field('description') ?: '';
$button_1 = get_field('button_1') ?: '';
$button_2 = get_field('button_2') ?: '';
$stat_1_value = get_field('stat_1_value') ?: '';
$stat_1_label = get_field('stat_1_label') ?: '';
$stat_2_text = get_field('stat_2_text') ?: '';
$stat_3_text = get_field('stat_3_text') ?: '';
$timeline_title = get_field('timeline_title') ?: 'Incident Timeline';
$timeline_items = get_field('timeline_items') ?: [];
$noise_filter_label = get_field('noise_filter_label') ?: 'Noise filter';
$noise_filter_text = get_field('noise_filter_text') ?: '';
$trust_badges_text_raw = get_field('trust_badges_text');
$trust_badges_text = (isset($trust_badges_text_raw) && trim($trust_badges_text_raw) !== '') ? $trust_badges_text_raw : '';
$trust_badges_logo = get_field('trust_badges_logo') ?: '';
$trust_badges_description = get_field('trust_badges_description') ?: '';

// Color mapping for timeline items
$color_classes = [
    'cyan' => 'timeline-cyan',
    'emerald' => 'timeline-emerald',
    'fuchsia' => 'timeline-fuchsia',
    'amber' => 'timeline-amber'
];

// Only display if we have content
if ($title || $description || $pretitle):
?>
<section id="<?php echo esc_attr($id); ?>" class="hero-timeline">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-left">
                <?php if ($pretitle): ?>
                <div class="hero-pretitle" data-aos="fade-down" data-aos-duration="600">
                    <span class="hero-pretitle-dot"></span>
                    <?php echo esc_html($pretitle); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($title): ?>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100" data-aos-duration="700"><?php echo wp_kses_post($title); ?></h1>
                <?php endif; ?>
                
                <?php if ($description): ?>
                <p class="hero-description" data-aos="fade-up" data-aos-delay="200" data-aos-duration="700"><?php echo wp_kses_post(nl2br($description)); ?></p>
                <?php endif; ?>

                <?php if (($stat_1_value || $stat_1_label) || $stat_2_text || $stat_3_text): ?>
                <div class="hero-stats" data-aos="fade-up" data-aos-delay="300" data-aos-duration="700">
                    <?php if ($stat_1_value || $stat_1_label): ?>
                    <div class="hero-stat">
                        <?php if ($stat_1_value): ?>
                        <span class="hero-stat-value"><?php echo esc_html($stat_1_value); ?></span>
                        <?php endif; ?>
                        <?php if ($stat_1_label): ?>
                        <span class="hero-stat-label"><?php echo esc_html($stat_1_label); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($stat_2_text): ?>
                    <div class="hero-stat">
                        <?php echo esc_html($stat_2_text); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($stat_3_text): ?>
                    <div class="hero-stat">
                        <?php echo esc_html($stat_3_text); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ($button_1 || $button_2): ?>
                <div class="hero-buttons">
                    <?php if ($button_1 && !empty($button_1['url']) && !empty($button_1['title'])): 
                        $button_1_url = $button_1['url'];
                        $button_1_title = $button_1['title'];
                        $button_1_target = isset($button_1['target']) ? $button_1['target'] : '_self';
                    ?>
                    <a href="<?php echo esc_url($button_1_url); ?>" target="<?php echo esc_attr($button_1_target); ?>" class="btn btn-primary hero-btn-1"><?php echo esc_html($button_1_title); ?></a>
                    <?php endif; ?>
                    
                    <?php if ($button_2 && !empty($button_2['url']) && !empty($button_2['title'])): 
                        $button_2_url = $button_2['url'];
                        $button_2_title = $button_2['title'];
                        $button_2_target = isset($button_2['target']) ? $button_2['target'] : '_self';
                    ?>
                    <a href="<?php echo esc_url($button_2_url); ?>" target="<?php echo esc_attr($button_2_target); ?>" class="btn btn-secondary hero-btn-2"><?php echo esc_html($button_2_title); ?></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="hero-right">
                <div class="timeline-wrapper" data-aos="fade-left" data-aos-delay="300" data-aos-duration="800">
                    <?php if ($timeline_title && !empty($timeline_items)): ?>
                    <div class="timeline-card">
                        <div class="timeline-header">
                            <span><?php echo esc_html($timeline_title); ?></span>
                            <span>Hawkeye</span>
                        </div>
                        <ul class="timeline-list" data-timeline-items="<?php echo count($timeline_items); ?>">
                            <?php foreach ($timeline_items as $index => $item): 
                                $time = $item['time'] ?? '';
                                $event = $item['event'] ?? '';
                                $color = $item['color'] ?? 'cyan';
                                $color_class = $color_classes[$color] ?? $color_classes['cyan'];
                                
                                if (!$time || !$event) continue;
                            ?>
                            <li class="timeline-item" data-index="<?php echo $index; ?>" style="opacity: 0; transform: translateY(10px);">
                                <span class="timeline-dot <?php echo esc_attr($color_class); ?>"></span>
                                <span class="timeline-content">
                                    <strong><?php echo esc_html($time); ?></strong> — <?php echo wp_kses_post(nl2br($event)); ?>
                                </span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($noise_filter_text): ?>
                    <div class="noise-filter-card">
                        <?php if ($noise_filter_label): ?>
                        <div class="noise-filter-label"><?php echo esc_html($noise_filter_label); ?></div>
                        <?php endif; ?>
                        <p class="noise-filter-text"><?php echo wp_kses_post(nl2br($noise_filter_text)); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php 
    // Only show trust badges section if at least one field has content
    $has_trust_content = false;
    if ($trust_badges_text && trim($trust_badges_text) !== '') $has_trust_content = true;
    if ($trust_badges_logo && !empty($trust_badges_logo['url'])) $has_trust_content = true;
    if ($trust_badges_description && trim($trust_badges_description) !== '') $has_trust_content = true;
    
    if ($has_trust_content): 
    ?>
    <div class="trust-badges">
        <div class="container">
            <div class="trust-badges-content">
                <?php if ($trust_badges_text && trim($trust_badges_text) !== ''): ?>
                <div class="trust-badges-text"><?php echo esc_html($trust_badges_text); ?></div>
                <?php endif; ?>
                
                <?php if ($trust_badges_logo && !empty($trust_badges_logo['url'])): ?>
                <img src="<?php echo esc_url($trust_badges_logo['url']); ?>" alt="<?php echo esc_attr($trust_badges_logo['alt'] ?? ''); ?>" class="trust-badges-logo" />
                <?php endif; ?>
                
                <?php if ($trust_badges_description && trim($trust_badges_description) !== ''): ?>
                <div class="trust-badges-description"><?php echo esc_html($trust_badges_description); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>
<?php if (!empty($timeline_items)): ?>
<script>
(function() {
    const timelineList = document.querySelector('#<?php echo esc_js($id); ?> .timeline-list');
    if (!timelineList) return;
    
    const items = timelineList.querySelectorAll('.timeline-item');
    if (items.length === 0) return;
    
    const totalItems = items.length;
    let currentIndex = 0;
    const showDuration = 2000; // 2 seconds per item
    const loopPauseDuration = 10000; // keep full timeline visible for at least 10 seconds before restarting
    let isAnimating = false;
    
    function showNextItem() {
        if (isAnimating) return;
        
        // If we've shown all items, pause with everything visible, then reset and start over
        if (currentIndex >= totalItems) {
            setTimeout(() => {
                // Hide all items
                items.forEach((item) => {
                    item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(10px)';
                });

                // Reset and show first item
                currentIndex = 0;
                showNextItem();
            }, loopPauseDuration);
            return;
        }
        
        isAnimating = true;
        
        // Show current item (cumulative - keep previous items visible)
        const currentItem = items[currentIndex];
        if (currentItem) {
            currentItem.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            currentItem.style.opacity = '1';
            currentItem.style.transform = 'translateY(0)';
        }
        
        currentIndex++;
        isAnimating = false;
        
        // Move to next item
        setTimeout(() => showNextItem(), showDuration);
    }
    
    // Start animation after page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => showNextItem(), 800);
        });
    } else {
        setTimeout(() => showNextItem(), 800);
    }
})();
</script>
<?php endif; ?>
<script>
(function() {
  const hero = document.querySelector('#<?php echo esc_js($id); ?>');
  if (!hero) return;
  const stats = hero.querySelector('.hero-stats');
  if (!stats) return;
  const allItems = Array.from(stats.querySelectorAll('.hero-stat'));
  const rotating = allItems; // rotate all stats as plain text
  if (rotating.length <= 1) return;

  stats.style.position = 'relative';
  const initialHeight = Math.max(...allItems.map(el => el.offsetHeight));
  if (initialHeight > 0) stats.style.minHeight = initialHeight + 'px';

  let current = 0;
  rotating.forEach((el, i) => {
    el.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
    el.style.opacity = (i === 0) ? '1' : '0';
    el.style.transform = (i === 0) ? 'translateY(0)' : 'translateY(6px)';
    el.style.position = (i === 0) ? 'relative' : 'absolute';
    el.style.left = '0';
    el.style.top = '0';
  });

  function next() {
    const nxt = (current + 1) % rotating.length;
    const curEl = rotating[current];
    const nxtEl = rotating[nxt];
    if (!curEl || !nxtEl) return;
    curEl.style.opacity = '0';
    curEl.style.transform = 'translateY(6px)';
    nxtEl.style.opacity = '1';
    nxtEl.style.transform = 'translateY(0)';
    current = nxt;
  }

  setInterval(next, 2500);
})();
</script>
<?php
endif;
?>

