<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$items = get_field('items') ? : '';

if($items):
?>
<section class="integration_ready">
    <div class="content-area">
        <div class="item_wrapper">
            <?php 
                foreach ($items as $key => $value) {
                    $title = $value['title'];
                    $manual_picker = $value['manual_picker'];

                    if($title || $manual_picker) {
                        ?>
                        <div class="item_single">
                            <?php if($title): ?>
                                <h3><?php echo $title ?></h3>
                            <?php endif; ?>
                            <?php if($manual_picker): ?>
                                <div class="logo_wrapper">
                                    <?php 
                                        foreach ($manual_picker as $key_manual => $value_manual) {
                                            $logo = get_field('logo', $value_manual);
                                            $enable_post_page = get_field('enable_post_page', $value_manual);
                                            $third_party_link = get_field('3rd_party_link', $value_manual);
                                            $post_title = get_the_title($value_manual);
                                            $permalink = get_permalink($value_manual);
                                            $permalink_target = '_self';

                                            if($enable_post_page !== FALSE) {
                                                $enable_post_page = 1;
                                            }

                                            if($third_party_link) {
                                                $permalink = $third_party_link;
                                                $permalink_target = '_blank';
                                            }
                                            ?>
                                            <div class="logo_item <?php echo !$enable_post_page ? 'no_hover' : ''; ?>">
                                                <?php if($logo): ?>
                                                    <div class="logo_wrap">
                                                        <img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" class="img-fluid">
                                                    </div>
                                                <?php endif; ?>
                                                <h4><?php echo $post_title ?></h4>
                                                <a href="<?php echo $permalink ?>" target="<?php echo $permalink_target ?>">Link</a>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</section>
<?php
endif;