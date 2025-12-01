<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$video = get_field('video') ? : '';

if($video){
    ?>
    <section class="video_section">
        <div class="content-area">
            <?php 
                if(strtolower(end(explode(".",$video['url']))) =="mp4")
                {
                    ?>
                    <video autoplay="autoplay" muted >
                        <source src="<?php echo $video['url'] ?>" type="video/mp4">
                        <source src="movie.ogg" type="video/ogg">
                        Your browser does not support the video tag.
                    </video>
                    <?php
                } else {
                    ?>
                    <lottie-player src="<?php echo $video['url'] ?>" background="transparent" speed="1" loop autoplay></lottie-player>
                    <?php
                }
            ?>

        </div>
    </section>
    <?php
}