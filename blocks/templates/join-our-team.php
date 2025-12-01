<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$items = get_field('items') ? : '';
$title = get_field('title') ? : '';
$subtitle = get_field('subtitle') ? : '';
$title_2 = get_field('title_2') ? : '';
$image = get_field('image') ? : '';
$image_2 = get_field('image_2') ? : '';
$image_3 = get_field('image_3') ? : '';

if($title || $items || $subtitle || $title_2 || $image):
?>
<section class="careers join_team">
  <div class="content-area">
    <?php if($title || $subtitle): ?>
        <div class="top-text">
            <?php if($title): ?>
                <h1><?php echo $title; ?></h1>
            <?php endif; ?>

            <?php if($subtitle): ?>
                <p><?php echo $subtitle ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if($items || $image || $title_2): ?>
        <div class="life-at-neubird">
          <div class="left-area">
            <?php if($title_2): ?>
                <p class="eyebrow"><?php echo $title_2 ?></p>
            <?php endif; ?>

            <?php
                if($items) {
                    foreach ($items as $key => $value) {
                        $title_item = $value['title'];
                        $text_item = $value['text'];

                        if($title_item || $text_item) {
                            ?>
                            <div class="fun-box">
                                <?php if($title_item): ?>
                                    <h2><?php echo $title_item ?></h2>
                                <?php endif; ?>

                                <?php if($text_item): ?>
                                    <p><?php echo $text_item; ?></p>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    }
                }
            ?>
          </div>
          <div class="right-area">
            <div class="img-area">
                <?php if($image): ?>
                    <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
                <?php endif; ?>
                <?php if($image_2): ?>
                    <img src="<?php echo $image_2['url'] ?>" alt="<?php echo $image_2['alt'] ?>" class="img-fluid">
                <?php endif; ?>
                <?php if($image_3): ?>
                    <img src="<?php echo $image_3['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
                <?php endif; ?>
            </div>
          </div>
        </div>
    <?php endif; ?>
  </div>
</section>
<?php
endif;