<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$title = get_field('title') ? : '';
$text = get_field('text') ? : '';
$items = get_field('items') ? : '';

if($title || $text || $items):
?>
<section class="business-analytics">
  <div class="content-area">
    <div class="top-title-text" data-aos="fade-in">
        <?php if($title): ?>
            <h2><?php echo $title ?></h2>
        <?php endif; ?>

        <?php if($text): ?>
            <p><?php echo $text; ?></p>
        <?php endif; ?>
    </div>

    <?php if($items): ?>
        <div class="four-column-highlight">
            <?php 
                foreach ($items as $key => $value) {
                    $title_item = $value['title'];

                    if($title_item) {
                        ?>
                        <div class="column-box" data-aos="fade-in">
                            <h3><?php echo $title_item; ?></h3>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
        <div class="four-column-timeline" data-aos="fade-in">
            <?php 
                foreach ($items as $key => $value) {
                    $title_item = $value['title'];
                    $subtitle = $value['subtitle'];
                    $text_item = $value['text'];

                    if($subtitle || $text_item) {
                        ?>
                        <div class="column-box">
                            <?php if($title_item): ?>
                                <div class="d-md-none title-area">
                                    <span><?php echo $title_item; ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($subtitle): ?>
                                <h3><?php echo $subtitle ?></h3>
                            <?php endif; ?>

                            <?php if($text_item): ?>
                                <p><?php echo $text_item; ?></p>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
    <?php endif; ?>
  </div>
</section>
<?php
endif;