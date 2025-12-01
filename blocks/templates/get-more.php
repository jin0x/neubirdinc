<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$items = get_field('items') ? : '';
$title = get_field('title') ? : '';
$button = get_field('button') ? : '';
$text_new = get_field('text') ? : '';

if($title || $button || $items):
?>
<section class="get-more-from-business">
  <div class="content-area">
    <?php if($title): ?>
        <div class="title-area" data-aos="fade-in">
          <h3><?php echo $title ?></h3>
        </div>
    <?php endif; ?>

    <?php if($items): ?>
        <div class="column-boxes" data-aos="fade-in">
            <?php 
                foreach ($items as $key => $value) {
                    $icon = $value['icon'];
                    $title_item = $value['title'];
                    $text = $value['text'];

                    if($icon || $title_item || $text) {
                        ?>
                        <div class="column-box">
                            <?php if($icon): ?>
                                <div class="icon-area">
                                    <img src="<?php echo $icon['url'] ?>" alt="<?php echo $icon['alt'] ?>" class="img-fluid">
                                </div>
                            <?php endif; ?>

                            <?php if($title_item): 
                                $title_item = str_replace('<br />', '<br class="d-none d-md-block">', $title_item);
                                ?>
                                <h4><?php echo $title_item ?></h4>
                            <?php endif; ?>

                            <?php if($text): ?>
                                <p><?php echo $text; ?></p>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
    <?php endif; ?>

    <?php if($button):
        $button_url = $button['url'];
        $button_title = $button['title'];
        $button_target = $button['target'] ? $button['target'] : '_self';
    ?>
    <div class="button-area" data-aos="fade-in">
        <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : '' ?> target="<?php echo $button_target ?>" class="btn-linked"><span><?php echo $button_title ?></span><img src="/wp-content/themes/neubird/images/svg/neubird_linked.svg" alt="neubird linked" class="img-fluid"></a>
    </div>
    <?php endif; ?>

    <?php if($text_new): ?>
        <div class="text_area">
            <?php echo $text_new; ?>
        </div>
    <?php endif; ?>
  </div>
</section>
<?php
endif;