<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$title = get_field('title')?:'';
$related_blogs = get_field('related_blogs')?:array();
// $themeurl/images/svg/quote_icon.svg

$arr_news = array();

$args = array(
    'post_type' => array('blog'),
    'post_status' => 'publish',
    'posts_per_page'=> 3,
    'order' => 'DESC',
);

if($related_blogs) {
    $args['post__in'] = $related_blogs;
    $args['orderby'] = 'post__in';
    $args['order'] = 'ASC';
    $args['posts_per_page'] = 3;
} else {
    $post_id = get_the_ID();
    $blog_cat = get_the_terms($post_id, 'blog-categories');
    $blog_cat_arr_slug = wp_list_pluck($blog_cat, 'slug');
    $args['post__not_in'] = array(get_the_ID());
    $args['tax_query'] = array(
        array (
            'taxonomy' => 'blog-categories',
            'field' => 'slug',
            'terms' => $blog_cat_arr_slug,
        )
    );
}

$the_query = new WP_Query( $args );


while ( $the_query->have_posts() ) {
    $the_query->the_post();

    $post_id = get_the_ID();
    
    array_push($arr_news, $post_id);
}
wp_reset_postdata();
?>
<section class="more_from_blog">
    <div class="content-area">
        <?php if($title): ?>
            <div class="title_area">
                <h2><?php echo $title ?></h2>
            </div>
        <?php endif; ?>
        <?php if($arr_news): ?>
            <div class="news-boxes">
                <?php 
                    foreach ($arr_news as $key => $value) {
                        $post_id = $value;

                        $post_title = get_the_title($post_id);
                        $permalink_target = '_self';
                        $permalink = get_permalink($post_id);
                        $featured_image = get_field('featured_image', $post_id);
                        $logo = '';
                        $excerpt = get_field('excerpt', $post_id);
                        $get_the_date = get_the_date('F j, Y', $post_id);

                        $third_party_link = get_field('3rd_party_link', $post_id);
                
                        if($third_party_link) {
                          $permalink = $third_party_link;
                          $permalink_target = '_blank';
                        }
                
                        $type_news_post = get_the_category($post_id);
                        $type_news_post_arr_slug = wp_list_pluck($type_news_post, 'slug');
                        $type_news_post_arr = wp_list_pluck($type_news_post, 'name');
                        $type_news_name = '';
                        if($type_news_post_arr) {
                            foreach ($type_news_post_arr as $key => $value) {
                                if($key + 1 == count($type_news_post_arr)){
                                    $type_news_name .= $value;
                                } else {
                                    $type_news_name .= $value.', ';
                                }
                            }
                        }

                        $type_news_post = get_the_terms($post_id, 'blog-categories');
                        $type_news_post_arr_slug = wp_list_pluck($type_news_post, 'slug');
                        $type_news_post_arr = wp_list_pluck($type_news_post, 'name');
                        $type_news_name = '';
                        if($type_news_post) {
                            foreach ($type_news_post as $key => $value) {
                
                                if($key + 1 == count($type_news_post)){
                                    $type_news_name .= $value->name;
                                } else {
                                    $type_news_name .= $value->name . ', ';
                                }
                            }
                        }

                        // $type_news_name = 'Blog';
                
                        ?>
                        <div class="news-box">
                            <div class="meta">
                                <p><?php echo $get_the_date ?></p>
                                <?php if($type_news_name): ?>
                                    <h6><?php echo $type_news_name ?></h6>
                                <?php endif; ?> 
                            </div>
                            <?php if($featured_image): ?>
                                <div class="image-box">
                                    <img src="<?php echo $featured_image['url'] ?>" alt="<?php echo $featured_image['alt'] ?>" class="img-fluid" width="282px">
                                </div>
                            <?php endif; ?>
                            <div class="text-area">
                                <h3><?php echo $post_title ?></h3>
                                <?php if($excerpt): ?>
                                    <p><?php echo $excerpt ?></p>
                                <?php endif; ?>
                            </div>
                                <a href="<?php echo $permalink ?>" target="<?php echo $permalink_target ?>" class="stretched-link">
                                <span class="visually-hidden">link</span>
                            </a>
                        </div>
                        <?php
                    }
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>
