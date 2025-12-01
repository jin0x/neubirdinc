<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$images = get_field('images')?:'';
$text = get_field('text')?:'';
// $themeurl/images/svg/quote_icon.svg
?>
<section class="right_content">
    <div class="wrapper_blog">
        <?php 
            if($images) {
                ?>
                <div class="img_area <?php echo count($images) > 1 ? 'gallery_img' : ''; ?>">
                    <?php 
                        foreach ($images as $key => $value) {
                            $image = $value['image'];
                            $caption = $value['caption'];
                            $full_width = $value['full_width'];

                            if($image) {
                                ?>
                                <div class="img_wrap <?php echo !$full_width ? 'half_width' : ''; ?>">
                                    <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
                                    <?php if($caption): ?>
                                        <span><?php echo $caption; ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
                <?php
            }

            echo $text;
        ?>
    </div>
</section>
