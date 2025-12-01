<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();
$iframe_content = get_field('iframe_url') ? : '';
$show_desktop_only = get_field('show_desktop_only') ? : '';
?>
<section class="home-iframe <?php echo $show_desktop_only ? 'd-none d-md-block' : '' ?>">
    <div class="iframe-container">
        <iframe src="<?php echo esc_url($iframe_content); ?>" width="100%" height="100%" frameborder="0" class="neubird-hero-iframe" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <a href="#get-more" class="scroll-down-arrow smoothscroll">
        <div class="arrow"></div>
    </a>
</section>