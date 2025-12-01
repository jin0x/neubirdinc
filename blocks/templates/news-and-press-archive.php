<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();
$title = get_field('title') ? : '';
$type = get_field('type') ? : '';
$posts_per_page = get_field('posts_per_page') ? : 6;
$show_pagination = get_field('show_pagination') ? : true;

$blog_cat = get_terms('blog-categories');

$args = array(
    'post_type' => array('post'),
    'post_status' => 'publish',
    'posts_per_page'=> -1, // Load all for JavaScript pagination
);

if($type) {
  if($type == 'blog') {
    $args['post_type'] = array('blog');
  }
  // Keep News & Press as regular posts (post type 'post')
}


$the_query = new WP_Query( $args );
$arr_news = array();
if ( $the_query->have_posts() ):


    while ( $the_query->have_posts() ) {
        $the_query->the_post();

        $post_id = get_the_ID();
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

        if($type) {
          if($type == 'blog') {
            $args['post_type'] = array('blog');
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
          // $args['category__in'] = $type;
        }
        


        array_push($arr_news, array(
          'post_id' => $post_id, 
          'excerpt' => $excerpt, 
          'post_title' => $post_title, 
          'permalink_target' => $permalink_target, 
          'permalink' => $permalink, 
          'get_the_date' => $get_the_date, 
          'logo' => $logo, 
          'featured_image' => $featured_image, 
          'type_news_name' => $type_news_name, 
          'type_news_post_arr_slug' => $type_news_post_arr_slug, 
      ));
    }
    wp_reset_postdata();

    $js_posts = json_encode($arr_news);
endif;


if($title || $arr_news):
?>
<section class="news-press-archive">
  <div class="content-area">
    <?php if($title):
        $title = str_replace('<br />', '<br class="d-md-none">', $title);
        ?>
        <h1><?php echo $title ?></h1>
    <?php endif; ?>

    <?php if($type == 'blog'): ?>
      <div class="filter_area">
        <div class="custom-select">
            <select name="blog_cat_select" id="blog_cat_select">
                <option value="">All Categories</option>
                <?php 
                    foreach ($blog_cat as $key_tab => $value_tab) {
                        ?>
                        <option value="<?php echo $value_tab->slug ?>"><?php echo $value_tab->name ?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <div class="clear_button">
          <a href="#">Clear</a>
        </div>
      </div>
    <?php endif; ?>

    <div class="blog-posts-grid">
    </div>

    <div class="news-pagination">
      <!-- <a href="#" class="newer disable">Newer</a>
      <a href="#" class="older">Older</a> -->
    </div>
  </div>
</section>
<script>
      <?php echo "var data_news = ". $js_posts . ";\n"; ?>
      <?php echo "var themeurl = '". $themeurl . "';\n"; ?>
      <?php echo "var type_archive = '". $type . "';\n"; ?>
      <?php echo "var posts_per_page = ". $posts_per_page . ";\n"; ?>
      <?php echo "var show_pagination = ". ($show_pagination ? 'true' : 'false') . ";\n"; ?>

</script>
<?php endif;