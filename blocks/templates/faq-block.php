<?php
$id = 'faq-block-' . get_row_index();
$themeurl = get_stylesheet_directory_uri();

// Get field values
$faq_header = get_field('faq_header') ?: 'Frequently Asked Questions';
$faq_subheading = get_field('faq_subheading');
$faq_display_style = get_field('faq_display_style') ?: 'accordion_closed';
$faq_layout = get_field('faq_layout') ?: 'single_column';
$faq_items = get_field('faq_items');
$faq_enable_schema = get_field('faq_enable_schema');

// Only display if we have FAQ items
if ($faq_items && is_array($faq_items) && count($faq_items) > 0):
?>

<section class="faq-block" id="<?php echo $id; ?>">
    <div class="container">
        <?php if ($faq_header): ?>
            <h3 class="faq-header"><?php echo esc_html($faq_header); ?></h3>
        <?php endif; ?>
        
        <?php if ($faq_subheading): ?>
            <div class="faq-subheading"><?php echo wp_kses_post(nl2br($faq_subheading)); ?></div>
        <?php endif; ?>
        
        <div class="faq-container <?php echo esc_attr($faq_layout); ?> <?php echo esc_attr($faq_display_style); ?>">
            <?php foreach ($faq_items as $index => $item): 
                $question = $item['question'] ?? '';
                $answer = $item['answer'] ?? '';
                
                if (!$question || !$answer) continue;
                
                $item_id = $id . '-item-' . $index;
                $is_first = $index === 0;
                $is_open = ($faq_display_style === 'accordion_open' || 
                           $faq_display_style === 'always_open' ||
                           ($faq_display_style === 'first_expanded' && $is_first));
                $has_toggle = ($faq_display_style !== 'always_open');
            ?>
                <div class="faq-item <?php echo $is_open ? 'active' : ''; ?>" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <?php if ($has_toggle): ?>
                        <button class="faq-question" 
                                aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>" 
                                aria-controls="<?php echo $item_id; ?>"
                                data-toggle="faq">
                            <h4><?php echo esc_html($question); ?></h4>
                            <span class="faq-toggle-icon" aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="horizontal-line" d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path class="vertical-line" d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                        </button>
                        <div class="faq-answer" 
                             id="<?php echo $item_id; ?>" 
                             <?php echo $is_open ? '' : 'style="display: none;"'; ?>>
                            <div class="faq-answer-content">
                                <?php echo wp_kses_post($answer); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="faq-question-static">
                            <h4><?php echo esc_html($question); ?></h4>
                        </div>
                        <div class="faq-answer-static">
                            <div class="faq-answer-content">
                                <?php echo wp_kses_post($answer); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($faq_enable_schema): ?>
<?php
    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'FAQPage',
        'mainEntity' => []
    ];

    foreach ($faq_items as $item) {
        $question = $item['question'] ?? '';
        $answer   = $item['answer'] ?? '';
        if (!$question || !$answer) { continue; }

        $clean_answer = wp_strip_all_tags($answer);
        $clean_answer = preg_replace('/\s+/', ' ', $clean_answer);
        $clean_answer = trim($clean_answer);

        $schema['mainEntity'][] = [
            '@type' => 'Question',
            'name'  => $question,
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $clean_answer,
            ],
        ];
    }
?>
<script type="application/ld+json">
<?php echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
</script>
<?php endif; ?>

<script>
(function() {
    function initFAQ() {
        const faqBlock = document.getElementById('<?php echo $id; ?>');
        if (!faqBlock) {
            // If FAQ block not found, try again after a short delay
            setTimeout(initFAQ, 100);
            return;
        }
        
        const faqToggles = faqBlock.querySelectorAll('[data-toggle="faq"]');
        
        faqToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const answer = this.nextElementSibling;
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                // Toggle the answer visibility
                if (isExpanded) {
                    answer.style.display = 'none';
                    this.setAttribute('aria-expanded', 'false');
                    this.classList.remove('active');
                } else {
                    answer.style.display = 'block';
                    this.setAttribute('aria-expanded', 'true');
                    this.classList.add('active');
                }
                
                // Update Lenis scroll height immediately and after animation
                if (window.lenis) {
                    // Immediate resize
                    window.lenis.resize();
                    // Resize again after a short delay to account for transitions
                    setTimeout(function() {
                        window.lenis.resize();
                    }, 50);
                    setTimeout(function() {
                        window.lenis.resize();
                    }, 300);
                }
            });
            
            // Set initial state
            if (toggle.getAttribute('aria-expanded') === 'true') {
                toggle.classList.add('active');
            }
        });
        
        // Ensure FAQ block is visible
        faqBlock.style.visibility = 'visible';
        faqBlock.style.opacity = '1';
        
        // Update Lenis scroll height after FAQ is initialized
        if (window.lenis) {
            // Multiple resize calls to ensure proper calculation
            setTimeout(function() {
                window.lenis.resize();
            }, 100);
            setTimeout(function() {
                window.lenis.resize();
            }, 300);
            setTimeout(function() {
                window.lenis.resize();
            }, 600);
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            // Wait a bit for Lenis to initialize first
            setTimeout(initFAQ, 150);
        });
    } else {
        // DOM already ready
        setTimeout(initFAQ, 150);
    }
})();
</script>

<?php endif; ?>
