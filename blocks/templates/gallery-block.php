<?php
$id = 'gallery-block-' . get_row_index();
$title = get_field('title') ?: '';
$images = get_field('images') ?: array();

if ($title || !empty($images)):
?>
<section class="gallery-block" id="<?php echo $id; ?>">
    <div class="content-area">
        <?php if ($title): ?>
            <h2 class="gallery-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <?php if (!empty($images)): ?>
            <div class="gallery-container">
                <div class="gallery-grid">
                    <?php foreach (array_slice($images, 0, 5) as $index => $image): ?>
                        <?php if ($image): ?>
                            <div class="gallery-item gallery-item-<?php echo $index + 1; ?>">
                                <img 
                                    src="<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>" 
                                    alt="<?php echo esc_attr($image['alt'] ?: $image['title'] ?: 'Gallery image'); ?>"
                                    loading="lazy"
                                />
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
endif;
?>
