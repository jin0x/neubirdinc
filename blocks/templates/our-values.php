<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$items = get_field('items') ? : '';
$title = get_field('title') ? : '';
$pretitle = get_field('pretitle') ? : '';

if($title || $pretitle || $items):
?>
<section class="values">
  <div class="content-area">
    <div class="top-title">
      <div class="text-box" data-aos="fade-in">
        <?php if($pretitle): ?>
            <p class="eyebrow"><?php echo $pretitle; ?></p>
        <?php endif; ?>

        <?php if($title): ?>
            <h2><?php echo $title ?></h2>
        <?php endif; ?>
      </div>
    </div>

    <?php if($items): ?>
        <div class="accordion accordion-values" id="accordionValues" data-aos="fade-in">
            <?php 
                foreach ($items as $key => $value) {
                    $title_item = $value['title'];
                    $text_item = $value['text'];
                    $image = $value['image'];

                    if($title_item) {
                        ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="values-heading<?php echo $key ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#values-collapse<?php echo $key ?>" aria-expanded="false" aria-controls="values-collapse<?php echo $key ?>">
                                <span><?php echo $title_item ?></span>
                            </button>
                            </h2>
                            <div id="values-collapse<?php echo $key ?>" class="accordion-collapse collapse" aria-labelledby="values-heading<?php echo $key ?>" data-bs-parent="#accordionValues">
                            <div class="accordion-body">
                                <div class="content-text">
                                    <?php echo $text_item ?>
                                </div>

                                <?php if($image): ?>
                                    <div class="image-box">
                                        <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
                                    </div>
                                <?php endif; ?>
                            </div>
                            </div>
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