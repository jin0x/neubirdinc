<?php
/**
 * Cloud Resources Block Template
 * Displays a compact table of collateral (typically PDFs) with name, type, and link.
 */

if (!function_exists('get_field')) {
    return;
}

$section_title = get_field('section_title') ?: '';
$description   = get_field('description') ?: '';
$resources     = get_field('resources') ?: [];

// Don't render if nothing is configured.
if (!$section_title && !$description && empty($resources)) {
    return;
}
?>

<section class="cloud-resources">
    <div class="container">
        <div class="cloud-resources-table-wrapper">
            <div class="cloud-resources-header">
                <?php if ($section_title) : ?>
                    <h2 class="cloud-resources-title"><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <p class="cloud-resources-description">
                        <?php echo wp_kses_post(nl2br($description)); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if (!empty($resources)) : ?>
                <table class="cloud-resources-table" aria-label="<?php echo esc_attr($section_title ?: 'Cloud resources'); ?>">
                    <thead>
                        <tr>
                            <th scope="col"><?php esc_html_e('Resource', 'neubird'); ?></th>
                            <th scope="col"><?php esc_html_e('Type', 'neubird'); ?></th>
                            <th scope="col" class="cloud-resources-actions"><?php esc_html_e('Link', 'neubird'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resources as $row) :
                            $name       = isset($row['name']) ? trim($row['name']) : '';
                            $type_label = isset($row['type_label']) ? trim($row['type_label']) : '';
                            $url        = isset($row['url']) ? trim($row['url']) : '';

                            if (!$name || !$url) {
                                continue;
                            }

                            $target_attr = ' target="_blank" rel="noopener"';
                        ?>
                            <tr>
                                <td class="cloud-resources-name">
                                    <span class="cloud-resources-file-icon" aria-hidden="true">
                                        <span class="cloud-resources-file-top"></span>
                                        <span class="cloud-resources-file-body"></span>
                                    </span>
                                    <span class="cloud-resources-name-text"><?php echo esc_html($name); ?></span>
                                </td>
                                <td class="cloud-resources-type">
                                    <?php if ($type_label) : ?>
                                        <span class="cloud-resources-pill"><?php echo esc_html($type_label); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="cloud-resources-actions">
                                    <a class="cloud-resources-link" href="<?php echo esc_url($url); ?>"<?php echo $target_attr; ?>>
                                        <span><?php esc_html_e('View PDF', 'neubird'); ?></span>
                                        <span class="cloud-resources-link-icon" aria-hidden="true">
                                            <!-- simple arrow icon -->
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 11L11 3M11 3H5.2M11 3V8.8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="cloud-resources-empty">
                    <p><?php esc_html_e('More resources coming soon.', 'neubird'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


