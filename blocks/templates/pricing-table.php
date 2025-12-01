<?php
$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'pricing-table-'.uniqid());

// Get fields from ACF
$heading = get_field('heading') ? : '';
$description = get_field('description') ? : '';
$plans = get_field('plans') ? : array();
$included_heading = get_field('included_heading') ? : 'Included in every plan';
$included_description = get_field('included_description') ? : '';
$included_features = get_field('included_features') ? : array();

if($heading || $plans):
?>
<section class="pricing-table-block" id="<?php echo esc_attr($id); ?>">
    <div class="container">
        <?php if($heading): ?>
            <h2 class="pricing-table-heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        
        <?php if($description): ?>
            <div class="pricing-table-description">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif; ?>

        <?php if($plans && is_array($plans) && count($plans) > 0): ?>
            <div class="pricing-plans-grid">
                <?php foreach($plans as $index => $plan): 
                    $plan_name = $plan['plan_name'] ?? '';
                    $plan_description = $plan['plan_description'] ?? '';
                    $plan_price = $plan['plan_price'] ?? '';
                    $plan_best_for = $plan['plan_best_for'] ?? '';
                    $plan_cta = $plan['plan_cta'] ?? '';
                    $plan_ideal_for = $plan['plan_ideal_for'] ?? '';
                    $plan_bottom_description = $plan['plan_bottom_description'] ?? '';
                    $plan_badge = $plan['plan_badge'] ?? '';
                    $plan_highlighted = $plan['plan_highlighted'] ?? false;
                    $plan_features = $plan['plan_features'] ?? array();
                    
                    $plan_classes = 'pricing-plan-card';
                    if($plan_highlighted) {
                        $plan_classes .= ' highlighted';
                    }
                ?>
                    <div class="<?php echo esc_attr($plan_classes); ?>" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                        <div class="pricing-plan-header">
                            <?php if($plan_badge): ?>
                                <div class="plan-badge"><?php echo esc_html($plan_badge); ?></div>
                            <?php endif; ?>
                            
                            <?php if($plan_name): ?>
                                <h3 class="plan-name"><?php echo esc_html($plan_name); ?></h3>
                            <?php endif; ?>
                            
                            <?php if($plan_description): ?>
                                <p class="plan-description"><?php echo wp_kses_post(nl2br($plan_description)); ?></p>
                            <?php endif; ?>
                            
                            <?php if($plan_price): ?>
                                <div class="plan-price"><?php echo esc_html($plan_price); ?></div>
                            <?php endif; ?>
                            
                            <?php if($plan_best_for): ?>
                                <div class="plan-best-for"><?php echo wp_kses_post(nl2br($plan_best_for)); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if($plan_cta): 
                            $cta_url = isset($plan_cta['url']) ? $plan_cta['url'] : '';
                            $cta_title = isset($plan_cta['title']) ? $plan_cta['title'] : 'Get Started';
                            $cta_target = isset($plan_cta['target']) ? $plan_cta['target'] : '_self';
                            $cta_class = $plan_highlighted ? 'btn btn-primary' : 'btn btn-secondary-alt';
                        ?>
                            <div class="plan-cta">
                                <a href="<?php echo esc_url($cta_url); ?>" target="<?php echo esc_attr($cta_target); ?>" class="<?php echo esc_attr($cta_class); ?>"><?php echo esc_html($cta_title); ?></a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="pricing-plan-footer-content">
                            <?php if($plan_ideal_for): ?>
                                <div class="plan-ideal-for"><?php echo wp_kses_post(nl2br($plan_ideal_for)); ?></div>
                            <?php endif; ?>
                            
                            <?php if($plan_bottom_description): ?>
                                <div class="plan-bottom-description"><?php echo wp_kses_post($plan_bottom_description); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if($plan_features && is_array($plan_features) && count($plan_features) > 0): ?>
                            <div class="plan-features">
                                <?php foreach($plan_features as $feature): 
                                    $feature_text = $feature['feature_text'] ?? '';
                                    if($feature_text):
                                ?>
                                    <div class="plan-feature-item">
                                        <span class="feature-check">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.667 5L7.5 14.167 3.333 10" stroke="#00a651" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <span class="feature-text"><?php echo esc_html($feature_text); ?></span>
                                    </div>
                                <?php 
                                    endif;
                                endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if($included_heading || ($included_features && is_array($included_features) && count($included_features) > 0)): ?>
            <div class="included-section">
                <?php if($included_heading): ?>
                    <h3 class="included-heading"><?php echo esc_html($included_heading); ?></h3>
                <?php endif; ?>
                
                <?php if($included_description): ?>
                    <div class="included-description">
                        <?php echo wp_kses_post($included_description); ?>
                    </div>
                <?php endif; ?>
                
                <?php if($included_features && is_array($included_features) && count($included_features) > 0): ?>
                    <div class="included-features">
                        <?php foreach($included_features as $feature): 
                            $feature_text = $feature['feature_text'] ?? '';
                            if($feature_text):
                        ?>
                            <div class="included-feature-item">
                                <span class="feature-check">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.667 5L7.5 14.167 3.333 10" stroke="#00a651" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span class="feature-text"><?php echo esc_html($feature_text); ?></span>
                            </div>
                        <?php 
                            endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
endif;

