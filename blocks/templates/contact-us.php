<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$tabs = get_field('tabs') ? : '';
$title = get_field('title') ? : '';
$title_2 = get_field('title_2') ? : '';
$items = get_field('items') ? : '';

if($tabs || $title || $title_2 || $image || $title_3 || $address):
?>
<section class="contact-us">
  <div class="content-area">
    <?php if($title): ?>
        <h1><?php echo $title ?></h1>
    <?php endif; ?>

    <?php if($tabs): ?>
    <div class="form-area">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php 
            foreach ($tabs as $key => $value) {
                $tab_title = $value['title'];

                if($tab_title) {
                    ?>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $key == 0 ? 'active' : '' ?>" id="option<?php echo $key; ?>-tab" data-bs-toggle="tab" data-bs-target="#option<?php echo $key; ?>-tab-pane" type="button" role="tab" aria-controls="option<?php echo $key; ?>-tab-pane" aria-selected="true"><?php echo $tab_title ?></button>
                    </li>
                    <?php
                }
            }
        ?>
      </ul>
      <div class="tab-content" id="myTabContent">
      <?php 
            foreach ($tabs as $key => $value) {
                    $form = $value['form'];

                    if($form) {
                        ?>
                        <div class="tab-pane fade <?php echo $key == 0 ? 'show active' : '' ?>" id="option<?php echo $key; ?>-tab-pane" role="tabpanel" aria-labelledby="option<?php echo $key; ?>-tab" tabindex="0">
                            <div class="form-container">
                                <?php if (function_exists('gravity_form')) : ?>
                                    <?php gravity_form($form, false, false, true, null, true); ?>
                                <?php else : ?>
                                    <p class="gf-missing">Gravity Forms is not available.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                }
            ?>
      </div>
    </div>
    <?php endif; ?>
    <div class="our-office">
        <?php if($title_2): ?>
            <p class="eyebrow"><?php echo $title_2 ?></p>
        <?php endif; ?>
        <?php  
            if($items) {
                foreach ($items as $key => $value) {
                    $image = $value['image'];
                    $title_3 = $value['title_3'];
                    $address = $value['address'];

                    if($image || $title_3 || $address) {
                        ?>
                        <div class="column-boxes <?php echo $key > 0 ? 'mt-5' : '' ?>">
                            <?php if($image): ?>
                            <div class="column-box">
                                <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid w-100">
                            </div>
                            <?php endif; ?>
                            <div class="column-box">
                                <?php if($title_3): ?>
                                    <h3><?php echo $title_3 ?></h3>
                                <?php endif; ?>

                                <?php if($address): ?>
                                    <p><?php echo $address; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        ?>

    </div>
  </div>
</section>
<?php
endif;