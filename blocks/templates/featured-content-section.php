<?php
$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'featured-content-'.uniqid());

// Get fields from ACF
$pretitle = get_field('ft_pretitle') ? : '';
$title = get_field('ft_title') ? : '';
$text = get_field('ft_text') ? : '';
$button = get_field('ft_link') ? : '';
$background_image = get_field('ft_background_image') ? : '';

if($pretitle || $title || $text || $button){
    ?>
    <section class="featured_content_section" id="<?php echo $id ?>" <?php if($background_image): ?> style="background-image: url('<?php echo $background_image['url']; ?>');"<?php endif; ?>>
        <div class="overlay"></div>
        <div class="content-area">
            <div class="text_area text-center">
                <?php if($pretitle): ?>
                    <p><?php echo $pretitle ?></p>
                <?php endif; ?>

                <?php if($title): ?>
                    <h2><?php echo $title ?></h2>
                <?php endif; ?>

                <?php if($text): ?>
                    <div class="text_par">
                        <?php echo $text; ?>
                    </div>
                <?php endif; ?>

                <?php if($button):
                    $button_url = $button['url'];
                    $button_title = $button['title'];
                    $button_target = $button['target'] ? $button['target'] : '_self';
                ?>
                <div class="btn_area">
                    <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : '' ?> target="<?php echo $button_target ?>" class="btn btn-primary"><?php echo $button_title ?></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}
