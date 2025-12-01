<?php
/**
 * Use Cases Table Block Template
 */

if (!function_exists('get_field')) {
    return;
}

$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'use-cases-table-' . uniqid());

// Get fields
$section_title = get_field('section_title') ?: '';
$section_description = get_field('section_description') ?: '';
$column_headers = get_field('column_headers') ?: [];
$table_rows = get_field('table_rows') ?: [];

// Get column headers
$col_1_header = isset($column_headers['col_1']) ? $column_headers['col_1'] : '';
$col_2_header = isset($column_headers['col_2']) ? $column_headers['col_2'] : '';
$col_3_header = isset($column_headers['col_3']) ? $column_headers['col_3'] : '';

// Only display if we have table rows
if (!empty($table_rows)):
?>
<section id="<?php echo esc_attr($id); ?>" class="use-cases-table">
    <div class="container">
        <?php if ($section_title || $section_description): ?>
        <div class="use-cases-header" data-aos="fade-up" data-aos-duration="700">
            <?php if ($section_title): ?>
            <h2 class="use-cases-title"><?php echo esc_html($section_title); ?></h2>
            <?php endif; ?>
            
            <?php if ($section_description): ?>
            <p class="use-cases-description"><?php echo wp_kses_post(nl2br($section_description)); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($table_rows)): ?>
        <div class="use-cases-table-wrapper">
            <table class="use-cases-table-grid">
                <?php if ($col_1_header || $col_2_header || $col_3_header): ?>
                <thead>
                    <tr>
                        <?php if ($col_1_header): ?>
                        <th class="use-case-col"><?php echo esc_html($col_1_header); ?></th>
                        <?php endif; ?>
                        <?php if ($col_2_header): ?>
                        <th class="use-case-col"><?php echo esc_html($col_2_header); ?></th>
                        <?php endif; ?>
                        <?php if ($col_3_header): ?>
                        <th class="use-case-col"><?php echo esc_html($col_3_header); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <?php endif; ?>
                <tbody>
                    <?php foreach ($table_rows as $index => $row): 
                        $row_title = $row['row_title'] ?? '';
                        $cell_1 = $row['cell_1_content'] ?? '';
                        $cell_2 = $row['cell_2_content'] ?? '';
                        $cell_3 = $row['cell_3_content'] ?? '';
                    ?>
                    <tr data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                        <td class="use-case-cell">
                            <?php if ($row_title): ?>
                            <div class="use-case-row-title"><?php echo esc_html($row_title); ?></div>
                            <?php endif; ?>
                            <?php if ($cell_1): ?>
                            <div class="use-case-content"><?php echo wp_kses_post($cell_1); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="use-case-cell">
                            <?php if ($cell_2): ?>
                            <div class="use-case-content"><?php echo wp_kses_post($cell_2); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="use-case-cell">
                            <?php if ($cell_3): ?>
                            <div class="use-case-content"><?php echo wp_kses_post($cell_3); ?></div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
endif;
?>

