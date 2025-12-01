<?php
$id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : (isset($block['id']) ? $block['id'] : 'image-video-right-'.uniqid());
$themeurl = get_stylesheet_directory_uri();

$image = get_field('image') ? : '';
$video_urlupload = get_field('video_urlupload') ? : '';
$video_url = get_field('video_url') ? : '';
$upload_video = get_field('upload_video') ? : '';
$pretitle = get_field('pretitle') ? : '';
$title = get_field('title') ? : '';
$text = get_field('text') ? : '';
$button = get_field('button') ? : '';

if($image || $pretitle || $title || $text || $button){
    $video_string = '';
    if($video_urlupload) {
        if($upload_video) {
            $video_string = $upload_video['url'];
        }
    } else {
        $video_string = $video_url;
    }
    ?>
    <section class="image_video_w_text_right bg-white" id="<?php echo $id ?>">
        <div class="container-fluid px-0">
            <!-- Adding mobile-only text version at the top for better visibility on mobile -->
            <div class="d-md-none mobile-text-area">
                <?php if($pretitle): ?>
                    <p class="pretitle"><?php echo $pretitle ?></p>
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
                <div class="btn_area mobile-btn-area">
                    <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : '' ?> target="<?php echo $button_target ?>" class="btn btn-primary"><?php echo $button_title ?></a>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="content-area">
                <div class="text_area d-none d-md-block">
                    <?php if($pretitle): ?>
                        <p class="pretitle"><?php echo $pretitle ?></p>
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
                    <div class="btn_area d-md-block">
                        <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : '' ?> target="<?php echo $button_target ?>" class="btn btn-primary"><?php echo $button_title ?></a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if($image): ?>
                    <div class="media_area">
                        <!-- Using actual img tag instead of background-image for better visibility -->
                        <div class="img_wrap">
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo isset($image['alt']) ? $image['alt'] : 'Feature image'; ?>" class="main-image" />
                            <div class="overlay"></div>
                            <?php if($video_string): ?>
                                <img src="<?php echo $themeurl ?>/images/neubird-play.png" alt="play icon" class="img-fluid play-icon">
                                <a href="<?php echo $video_string ?>" class="strecth_link open_fancybox" >Link</a>
                            <?php endif; ?>
                        </div>

                                <!-- Mobile button removed to prevent duplication -->
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}
