<?php
/**
 * Integration Options Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'integration-options-' . uniqid());

// Get fields
$section_title = get_field('section_title') ?: '';
$section_subtitle = get_field('section_subtitle') ?: '';
$column_headers = get_field('column_headers') ?: [];
$options = get_field('options') ?: [];
$global_cta = get_field('global_cta') ?: '';

// Get column headers
$col_option = isset($column_headers['col_option']) ? $column_headers['col_option'] : 'Option';
$col_what = isset($column_headers['col_what']) ? $column_headers['col_what'] : 'What it does';
$col_when = isset($column_headers['col_when']) ? $column_headers['col_when'] : 'When to use';

// Only display if we have options
if (!empty($options)):
?>
<section id="<?php echo esc_attr($id); ?>" class="integration-options">
    <div class="container">
        <?php if ($section_title || $section_subtitle): ?>
        <div class="integration-options-header" data-aos="fade-up" data-aos-duration="700">
            <?php if ($section_title): ?>
            <h2 class="integration-options-title"><?php echo esc_html($section_title); ?></h2>
            <?php endif; ?>
            
            <?php if ($section_subtitle): ?>
            <p class="integration-options-subtitle"><?php echo esc_html($section_subtitle); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($options)): ?>
        <div class="integration-options-table-wrapper">
            <table class="integration-options-table">
                <thead>
                    <tr>
                        <th class="option-col"><?php echo esc_html($col_option); ?></th>
                        <th class="what-col"><?php echo esc_html($col_what); ?></th>
                        <th class="when-col"><?php echo esc_html($col_when); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($options as $index => $option): 
                        $option_name = $option['option_name'] ?? '';
                        $what_it_does = $option['what_it_does'] ?? '';
                        $when_to_use = $option['when_to_use'] ?? '';
                        $cta_button = $option['cta_button'] ?? '';
                    ?>
                    <tr data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                        <td class="option-cell">
                            <div class="option-name"><?php echo esc_html($option_name); ?></div>
                            <?php if ($cta_button && !empty($cta_button['url'])): 
                                $cta_url = $cta_button['url'];
                                $cta_title = $cta_button['title'] ?? 'Learn More';
                                $cta_target = isset($cta_button['target']) ? $cta_button['target'] : '_self';
                            ?>
                            <div class="option-cta">
                                <a href="<?php echo esc_url($cta_url); ?>" target="<?php echo esc_attr($cta_target); ?>" class="btn btn-secondary"><?php echo esc_html($cta_title); ?></a>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="what-cell">
                            <?php if ($what_it_does): ?>
                            <div class="option-description"><?php echo wp_kses_post(nl2br($what_it_does)); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="when-cell">
                            <?php if ($when_to_use): ?>
                            <div class="option-description"><?php echo wp_kses_post(nl2br($when_to_use)); ?></div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <?php if ($global_cta && !empty($global_cta['url'])): 
            $global_cta_url = $global_cta['url'];
            $global_cta_title = $global_cta['title'] ?? 'FREE TRIAL';
            $global_cta_target = isset($global_cta['target']) ? $global_cta['target'] : '_self';
        ?>
        <div class="integration-options-global-cta" data-aos="fade-up" data-aos-delay="300">
            <a href="<?php echo esc_url($global_cta_url); ?>" target="<?php echo esc_attr($global_cta_target); ?>" class="btn btn-primary"><?php echo esc_html($global_cta_title); ?></a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
endif;
?>

