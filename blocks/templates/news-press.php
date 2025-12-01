<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$news_press = get_field('news_&_press') ? : '';
$title = get_field('title') ? : '';
$button = get_field('button') ? : '';

$arr_news = array();

$args = array(
    'post_status' => 'publish',
    'posts_per_page'=> 4,
);

$the_query = new WP_Query($args);

if ( $the_query->have_posts() ):
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        $post_id = get_the_ID();
        array_push($arr_news, $post_id);
    }
    wp_reset_postdata();

    if($news_press) {
        $arr_news = $news_press;
    }
endif;

if($title || $button || $news_press):
?>
<section class="news-press blog-archive">
  <div class="content-area featured-posts-section">
    <?php if($title): ?>
        <div class="title-area" data-aos="fade-in">
          <h2 class="h1"><?php echo $title ?></h2>
        </div>
    <?php endif; ?>
    
    <?php if(!empty($arr_news)): ?>
    <div class="featured-posts-grid">
      <!-- Left Column - Featured post with image -->
      <div class="featured-posts-left" data-aos="fade-in">
        <?php
        // Display the featured post (first post) in the left area with image
        $featured_post = isset($arr_news[0]) ? $arr_news[0] : null;
        
        if ($featured_post) {
            $title_post = get_the_title($featured_post);
            $permalink = get_the_permalink($featured_post);
            $permalink_target = "_self";
            $excerpt = get_field('excerpt', $featured_post) ? : '';
            $featured_image = get_field('featured_image', $featured_post) ? : '';
            $logo = get_field('logo', $featured_post) ? : '';
            $third_party_link = get_field('3rd_party_link', $featured_post) ? : '';
            
            // Get post type and try different taxonomies
            $post_type = get_post_type($featured_post);
            
            // Try standard category taxonomy
            $post_categories = get_the_terms($featured_post, 'category');
            
            // If not found, try blog-categories taxonomy
            if (!$post_categories || is_wp_error($post_categories)) {
                $post_categories = get_the_terms($featured_post, 'blog-categories');
            }
            
            // If not found, try post_tag taxonomy
            if (!$post_categories || is_wp_error($post_categories)) {
                $post_categories = get_the_terms($featured_post, 'post_tag');
            }
            
            $category_names = array();
            $category_slugs = array();
            
            if($post_categories && !is_wp_error($post_categories)) {
                foreach($post_categories as $category) {
                    $category_names[] = $category->name;
                    $category_slugs[] = $category->slug;
                }
            }
            
            // If still no categories, check for a custom field
            if (empty($category_names)) {
                $manual_category = get_post_meta($featured_post, 'category', true);
                if (!empty($manual_category)) {
                    $category_names[] = $manual_category;
                    $category_slugs[] = sanitize_title($manual_category);
                }
            }
            
            $categories = !empty($category_names) ? implode(', ', $category_names) : '';
            $category_class = !empty($category_slugs) ? implode(' ', $category_slugs) : '';
            
            if($third_party_link) {
                $permalink = $third_party_link;
                $permalink_target = '_blank';
            }
            
            if(!$featured_image) {
                // Try to get the featured image from the post thumbnail
                $thumb_id = get_post_thumbnail_id($featured_post);
                if($thumb_id) {
                    $featured_image = array(
                        'url' => wp_get_attachment_image_url($thumb_id, 'large'),
                        'alt' => get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: $title_post
                    );
                } else {
                    $featured_image = $logo;
                }
            }
        ?>
        <div class="featured-post-large">
            <div class="featured-post-inner">
                <div class="featured-image">
                    <?php if($featured_image): ?>
                        <img src="<?php echo $featured_image['url'] ?>" alt="<?php echo $featured_image['alt'] ?>" class="img-fluid">
                    <?php endif; ?>
                </div>
                <div class="featured-content">
                    <?php if(!empty($categories)): ?>
                    <div class="category-tag <?php echo $category_class; ?>"><?php echo $categories; ?></div>
                    <?php endif; ?>
                    <h3 class="article-title"><?php echo $title_post ?></h3>
                    <?php if($excerpt): ?>
                        <div class="article-excerpt"><?php echo wp_trim_words($excerpt, 60, '...'); ?></div>
                    <?php endif; ?>
                    <div class="read-more">
                        <a href="<?php echo $permalink ?>" class="btn-text" target="<?php echo $permalink_target ?>">Read More</a>
                    </div>
                </div>
                <a href="<?php echo $permalink ?>" target="<?php echo $permalink_target ?>" class="stretched-link"><span class="visually-hidden">link</span></a>
            </div>
        </div>
        <?php } ?>
      </div>
      
      <!-- Right Column - 3 small posts without images -->
      <div class="featured-posts-right" data-aos="fade-in">
        <?php 
        // Show the small posts (2nd, 3rd, 4th) in the right area without images
        $count = 0;
        foreach ($arr_news as $key => $value) {
            // Skip the first post (already displayed in left area)
            if($key == 0) continue;
            
            // Only show 3 posts in the right area
            if($count >= 3) break;
            
            $title_post = get_the_title($value);
            $permalink = get_the_permalink($value);
            $permalink_target = "_self";
            $excerpt = get_field('excerpt', $value) ? : '';
            $third_party_link = get_field('3rd_party_link', $value) ? : '';
            
            // Get post type and try different taxonomies
            $post_type = get_post_type($value);
            
            // Try standard category taxonomy
            $post_categories = get_the_terms($value, 'category');
            
            // If not found, try blog-categories taxonomy
            if (!$post_categories || is_wp_error($post_categories)) {
                $post_categories = get_the_terms($value, 'blog-categories');
            }
            
            // If not found, try post_tag taxonomy
            if (!$post_categories || is_wp_error($post_categories)) {
                $post_categories = get_the_terms($value, 'post_tag');
            }
            
            $category_names = array();
            $category_slugs = array();
            
            if($post_categories && !is_wp_error($post_categories)) {
                foreach($post_categories as $category) {
                    $category_names[] = $category->name;
                    $category_slugs[] = $category->slug;
                }
            }
            
            // If still no categories, check for a custom field
            if (empty($category_names)) {
                $manual_category = get_post_meta($value, 'category', true);
                if (!empty($manual_category)) {
                    $category_names[] = $manual_category;
                    $category_slugs[] = sanitize_title($manual_category);
                }
            }
            
            $categories = !empty($category_names) ? implode(', ', $category_names) : '';
            $category_class = !empty($category_slugs) ? implode(' ', $category_slugs) : '';
            
            if($third_party_link) {
                $permalink = $third_party_link;
                $permalink_target = '_blank';
            }
            
            $count++;
        ?>
        <div class="featured-post-small featured-post <?php echo $excerpt ? 'has-excerpt' : 'no-excerpt'; ?>">
            <div class="featured-content">
                <?php if(!empty($categories)): ?>
                    <div class="category-tag <?php echo $category_class; ?>"><?php echo $categories; ?></div>
                    <?php endif; ?>
                <h3 class="article-title"><?php echo $title_post ?></h3>
                <p class="article-excerpt"><?php echo $excerpt ? wp_trim_words($excerpt, 30, '...') : ''; ?></p>
                <div class="read-more">
                    <a href="<?php echo $permalink ?>" class="btn-text" target="<?php echo $permalink_target ?>">Read More</a>
                </div>
            </div>
            <a href="<?php echo $permalink ?>" target="<?php echo $permalink_target ?>" class="stretched-link"><span class="visually-hidden">link</span></a>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php endif; ?>
    
    <?php if($button): ?>
    <div class="button-area" data-aos="fade-in">
        <a href="<?php echo $button['url'] ?>" class="btn-primary" target="<?php echo $button['target'] ?>"><?php echo $button['title'] ?></a>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
