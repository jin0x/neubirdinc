<?php
$id = 'row' . get_row_index();
$themeurl = get_stylesheet_directory_uri();

$items = get_field('items') ?: '';
$title = get_field('title') ?: '';
$text = get_field('text') ?: '';
$image = get_field('image') ?: '';

if ($items):
?>
<section class="testimonials">
  <div class="content-area" data-aos="fade-in">
    <div class="testimonial-slider">
      <?php 
        foreach ($items as $key => $value) {
          $image = $value['image'] ?? '';
          $logo = $value['logo'] ?? '';
          $quote = $value['quote'] ?? '';
          $author = $value['author'] ?? '';
          $job_title = $value['job_title'] ?? '';

          if ($image || $logo || $quote || $author || $job_title) {
            ?>
            <div class="testimonial-slide">
              <div class="testimonial-box">
                <?php if ($image): ?>
                  <div class="image-area">
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="img-fluid">
                  </div>
                <?php endif; ?>
                <div class="text-area">
                  <?php if ($logo): ?>
                    <div class="logo-area">
                      <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" class="img-fluid">
                    </div>
                  <?php endif; ?>
                  <?php if ($quote): ?>
                    <p class="testimonial"><?php echo $quote; ?></p>
                  <?php endif; ?>
                  <div class="testi-meta">
                    <p><strong><?php echo $author; ?></strong><br>
                      <?php echo $job_title; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <?php
          }
        }
      ?>
    </div>
    <div class="testimonial-pagination"></div>
  </div>
</section>
<?php
endif;
