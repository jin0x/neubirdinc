<?php
$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'plan-comparison-'.uniqid());

// Get fields from ACF
$heading = get_field('heading') ? : 'Plan comparison';
$description = get_field('description') ? : '';
$plan_names = get_field('plan_names') ? : array();
$comparison_rows = get_field('comparison_rows') ? : array();

// Get plan names with defaults
$plan_1_name = isset($plan_names['plan_1']) && !empty($plan_names['plan_1']) ? $plan_names['plan_1'] : 'Free Trial';
$plan_2_name = isset($plan_names['plan_2']) && !empty($plan_names['plan_2']) ? $plan_names['plan_2'] : 'Per investigation';
$plan_3_name = isset($plan_names['plan_3']) && !empty($plan_names['plan_3']) ? $plan_names['plan_3'] : 'Enterprise';

// Helper function to format comparison value
if (!function_exists('format_comparison_value')) {
    function format_comparison_value($value) {
        if(empty($value) || $value === '-') {
            return '<span class="comparison-dash">—</span>';
        }
        $value_lower = strtolower(trim($value));
        if($value_lower === 'yes') {
            return '<span class="comparison-check">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.667 5L7.5 14.167 3.333 10" stroke="#00a651" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>';
        }
        return '<span class="comparison-text">' . esc_html($value) . '</span>';
    }
}

if($heading || ($comparison_rows && is_array($comparison_rows) && count($comparison_rows) > 0)):
?>
<section class="plan-comparison-block" id="compare" data-anchor-id="<?php echo esc_attr($id); ?>">
    <div class="container">
        <?php if($heading): ?>
            <h2 class="comparison-heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        
        <?php if($description): ?>
            <div class="comparison-description">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif; ?>

        <?php if($comparison_rows && is_array($comparison_rows) && count($comparison_rows) > 0): ?>
            <!-- Desktop/Tablet Table View -->
            <div class="comparison-table-wrapper desktop-view">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th class="capability-column">Capability</th>
                            <th><?php echo esc_html($plan_1_name); ?></th>
                            <th><?php echo esc_html($plan_2_name); ?></th>
                            <th><?php echo esc_html($plan_3_name); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($comparison_rows as $index => $row): 
                            $capability = $row['capability_name'] ?? '';
                            $plan_1_value = $row['plan_1_value'] ?? '';
                            $plan_2_value = $row['plan_2_value'] ?? '';
                            $plan_3_value = $row['plan_3_value'] ?? '';
                            
                            if(empty($capability)) continue;
                        ?>
                            <tr data-aos="fade-up" data-aos-delay="<?php echo ($index % 5) * 50; ?>">
                                <td class="capability-cell">
                                    <strong><?php echo esc_html($capability); ?></strong>
                                </td>
                                <td class="plan-value-cell" data-plan-name="<?php echo esc_attr($plan_1_name); ?>">
                                    <?php echo format_comparison_value($plan_1_value); ?>
                                </td>
                                <td class="plan-value-cell" data-plan-name="<?php echo esc_attr($plan_2_name); ?>">
                                    <?php echo format_comparison_value($plan_2_value); ?>
                                </td>
                                <td class="plan-value-cell" data-plan-name="<?php echo esc_attr($plan_3_name); ?>">
                                    <?php echo format_comparison_value($plan_3_value); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Tabbed View -->
            <div class="mobile-tab-view">
                <div class="mobile-tabs">
                    <button class="mobile-tab-btn active" onclick="switchPlan(1, this)"><?php echo esc_html($plan_1_name); ?></button>
                    <button class="mobile-tab-btn" onclick="switchPlan(2, this)"><?php echo esc_html($plan_2_name); ?></button>
                    <button class="mobile-tab-btn" onclick="switchPlan(3, this)"><?php echo esc_html($plan_3_name); ?></button>
                </div>
                
                <div class="mobile-plan-content active" id="plan-content-1">
                    <?php foreach($comparison_rows as $row): 
                        if(empty($row['capability_name'])) continue;
                    ?>
                    <div class="mobile-feature-row">
                        <div class="mobile-feature-name"><?php echo esc_html($row['capability_name']); ?></div>
                        <div class="mobile-feature-value"><?php echo format_comparison_value($row['plan_1_value']); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="mobile-plan-content" id="plan-content-2">
                    <?php foreach($comparison_rows as $row): 
                        if(empty($row['capability_name'])) continue;
                    ?>
                    <div class="mobile-feature-row">
                        <div class="mobile-feature-name"><?php echo esc_html($row['capability_name']); ?></div>
                        <div class="mobile-feature-value"><?php echo format_comparison_value($row['plan_2_value']); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="mobile-plan-content" id="plan-content-3">
                    <?php foreach($comparison_rows as $row): 
                        if(empty($row['capability_name'])) continue;
                    ?>
                    <div class="mobile-feature-row">
                        <div class="mobile-feature-name"><?php echo esc_html($row['capability_name']); ?></div>
                        <div class="mobile-feature-value"><?php echo format_comparison_value($row['plan_3_value']); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <script>
            function switchPlan(planIndex, btn) {
                // Remove active class from all buttons and content
                document.querySelectorAll('.mobile-tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.mobile-plan-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked button and target content
                btn.classList.add('active');
                document.getElementById('plan-content-' + planIndex).classList.add('active');
            }
            </script>
        <?php endif; ?>
    </div>
</section>
<?php
endif;

