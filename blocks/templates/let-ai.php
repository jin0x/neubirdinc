<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$pretitle = get_field('pretitle') ? : '';
$title = get_field('title') ? : '';
$text = get_field('text') ? : '';
$button = get_field('button') ? : '';
$chats = get_field('chats') ? : '';
$lottie = get_field('lottie') ? : '';

if($title || $text || $button || $pretitle || $chats):
?>
<section class="let-ai-do-work">
  <div class="content-area">
    
    <?php if($chats): ?>
        <div class="chat-area">
            <?php 
                $counter = 0;
                foreach ($chats as $key => $value) {
                    $text_item = $value['text'];

                    if($text_item) {
                        ?>
                        <p <?php echo ($key + 1) % 2 == 0 ? 'class="right"' : ''  ?> data-aos="fade-in" <?php echo $key > 0 ? 'data-aos-delay="'.$counter.'"' : '' ?>><?php echo $text_item ?></p>
                        <?php
                    }

                    $counter =+ 200;
                }
            ?>
        </div>
    <?php else: ?>
        <?php if($lottie && !$chats): ?>
            <div class="chat-area">
                <lottie-player src="<?php echo $lottie['url'] ?>" background="transparent" speed="1" loop autoplay></lottie-player>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="text-area" data-aos="fade-in">
        <?php if($pretitle): ?>
            <p class="eyebrow"><?php echo $pretitle ?></p>
        <?php endif; ?>

        <?php if($title): ?>
            <h2 class="h1"><?php echo $title ?></h2>
        <?php endif; echo $text ?>

        <?php if($button):
            $button_url = $button['url'];
            $button_title = $button['title'];
            $button_target = $button['target'] ? $button['target'] : '_self';
        ?>
        <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : '' ?> target="<?php echo $button_target ?>" class="btn btn-primary"><?php echo $button_title ?></a>
        <?php endif; ?>
    </div>
  </div>
</section>
<?php
endif;