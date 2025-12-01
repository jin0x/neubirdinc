<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$items = get_field('items') ? : '';
$title = get_field('title') ? : '';
$combined_image = get_field('combined_image') ? : '';
$display_mode = get_field('display_mode') ? : 'grid';

if($title || $items):
?>
<section class="leadership <?php echo $display_mode === 'combined' ? 'leadership-combined' : ''; ?>">
  <div class="content-area">
    <?php if($title): ?>
        <div class="title-area" data-aos="fade-in">
          <h2 class="h1"><?php echo $title ?></h2>
        </div>
    <?php endif; ?>

    <?php if($items): ?>
        <?php if($display_mode === 'combined' && $combined_image): ?>
            <!-- Combined Layout -->
            <div class="leadership-layout" data-aos="fade-in">
                <div class="leadership-image">
                    <img src="<?php echo $combined_image['url'] ?>" alt="<?php echo $combined_image['alt'] ?>" class="img-fluid">
                </div>
                <div class="leadership-details">
                    <?php 
                        foreach ($items as $key => $value) {
                            $name = $value['name'];
                            $linkedin_url = $value['linkedin_url'];
                            $job_title = $value['job_title'];
                            ?>
                            <div class="founder-info">
                                <h3><?php echo $name ?></h3>
                                <p class="job-title"><?php echo $job_title ?></p>
                                <?php if($linkedin_url): ?>
                                    <a href="<?php echo $linkedin_url ?>" target="_blank" class="linkedin-link">
                                        <img src="<?php echo $themeurl ?>/images/svg/icon-linkedin.svg" alt="LinkedIn" class="linkedin-icon">
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Grid Layout -->
            <div class="leadership-boxes">
                <?php 
                    foreach ($items as $key => $value) {
                        $image = $value['image'];
                        $name = $value['name'];
                        $linkedin_url = $value['linkedin_url'];
                        $job_title = $value['job_title'];

                        if($image || $name || $linkedin_url) {
                            ?>
                            <div class="leadership-box" data-aos="fade-in">
                                <?php if($image): ?>
                                    <div class="image-area">
                                        <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
                                    </div>
                                <?php endif; ?>
                                <div class="text-area">
                                <div class="name-title">
                                    <?php if($name): ?>
                                        <h4><?php echo $name ?></h4>
                                    <?php endif; ?>

                                    <?php if($job_title): ?>
                                        <p><?php echo $job_title ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if($linkedin_url): ?>
                                    <div class="social">
                                        <a href="<?php echo $linkedin_url ?>" target="_blank"><img src="<?php echo $themeurl ?>/images/svg/icon-linkedin.svg" alt="#" class="img-fluid"></a>
                                    </div>
                                <?php endif; ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
<?php
endif;