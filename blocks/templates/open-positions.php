<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$items = get_field('items') ? : '';
$title = get_field('title') ? : '';

if($title || $items):
?>
<section class="careers open_postion">
  <div class="content-area">
    <div class="open-positions">
        <?php if($title): ?>
            <p class="eyebrow"><?php echo $title ?></p>
        <?php endif; ?>

        <?php if($items): ?>
            <div class="accordion accordion-careers" id="accordioncareers">
                <?php 
                    foreach ($items as $key => $value) {
                        $job_title = $value['job_title'];
                        $location = $value['location'];
                        $city = $value['city'];
                        $text = $value['text'];
                        $button = $value['button'];

                        if($job_title) {
                            ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="careers-heading<?php echo $key ?>">
                                <button class="accordion-button red-gradient collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#careers-collapse<?php echo $key ?>" aria-expanded="false" aria-controls="careers-collapse<?php echo $key ?>">
                                    <?php echo $job_title ?> <span class="address"><?php echo $location ?> <?php echo $city ? '<span class="separator">|</span> '.$city.'</span>' : '' ?>
                                </button>
                                </h2>

                                <?php if($text || $button): ?>
                                    <div id="careers-collapse<?php echo $key ?>" class="accordion-collapse collapse" aria-labelledby="careers-heading<?php echo $key ?>" data-bs-parent="#accordioncareers">
                                        <div class="accordion-body">
                                            <div class="text-box">
                                                <?php if($text): ?>
                                                    <?php echo $text; ?>
                                                <?php endif; ?>

                                                <?php if($button):
                                                    $button_url = $button['url'];
                                                    $button_title = $button['title'];
                                                    $button_target = $button['target'] ? $button['target'] : '_self';
                                                    
                                                    // Handle mailto links to prevent external app opening
                                                    $additional_attrs = '';
                                                    if ($button_url && strpos($button_url, 'mailto:') === 0) {
                                                        // Add class and data attribute for JavaScript handling
                                                        $additional_attrs = 'class="btn btn-primary mailto-button" data-email="' . esc_attr(str_replace('mailto:', '', $button_url)) . '"';
                                                        $button_url = '#'; // Prevent default mailto behavior
                                                        $button_target = '_self';
                                                    } else {
                                                        $additional_attrs = 'class="btn btn-primary"';
                                                    }
                                                ?>
                                                    <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : 'href="#"' ?> target="<?php echo $button_target ?>" <?php echo $additional_attrs; ?>><?php echo $button_title ?></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
        <?php endif; ?>
    </div>
  </div>
</section>
<?php
endif;