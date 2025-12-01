<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();
$title = get_field('title') ? : 'Blog';
$featured_posts_count = get_field('featured_posts_count') ? : 5;
$regular_posts_count = get_field('regular_posts_count') ? : 9;

// Get manually selected featured posts if available
$manual_featured_posts = get_field('manual_featured_posts');
$featured_post_ids = array();
$main_featured_post_id = get_field('main_featured_post'); // Get the main featured post ID

if (!empty($manual_featured_posts)) {
    // If we have a main featured post, make sure it's first in the array
    if ($main_featured_post_id) {
        $featured_post_ids[] = $main_featured_post_id;
    }
    
    // Add the rest of the manually selected posts
    foreach ($manual_featured_posts as $post_id) {
        // Skip if it's the main featured post (already added)
        if ($main_featured_post_id && $post_id == $main_featured_post_id) {
            continue;
        }
        $featured_post_ids[] = $post_id;
    }
}

// Get blog categories
$blog_categories = get_terms([
    'taxonomy' => 'blog-categories',
    'hide_empty' => true,
]);

// Query for all blog posts
$args = array(
    'post_type' => 'blog',
    'post_status' => 'publish',
    'posts_per_page' => -1,
);

$blog_query = new WP_Query($args);
$all_posts = array();
$featured_posts = array();
$featured_post_ids_for_display = array(); // Only for featured section display, not filtering

if ($blog_query->have_posts()):
    while ($blog_query->have_posts()) {
        $blog_query->the_post();

        $post_id = get_the_ID();
        $post_title = get_the_title($post_id);
        $permalink_target = '_self';
        $permalink = get_permalink($post_id);
        $featured_image = get_field('featured_image', $post_id);
        $excerpt = get_field('excerpt', $post_id) ? : wp_trim_words(get_the_content(), 20, '...');
        $is_featured = get_field('featured_post', $post_id);
        $post_date = get_the_date('F j, Y', $post_id);

        // Get third party link if exists
        $third_party_link = get_field('3rd_party_link', $post_id);
        if($third_party_link) {
            $permalink = $third_party_link;
            $permalink_target = '_blank';
        }

        // Get post categories
        $post_categories = get_the_terms($post_id, 'blog-categories');
        $category_names = array();
        $category_slugs = array();
        
        if($post_categories && !is_wp_error($post_categories)) {
            foreach($post_categories as $category) {
                $category_names[] = $category->name;
                $category_slugs[] = $category->slug;
            }
        }
        
        $post_data = array(
            'post_id' => $post_id,
            'post_title' => $post_title,
            'permalink' => $permalink,
            'permalink_target' => $permalink_target,
            'featured_image' => $featured_image,
            'excerpt' => $excerpt,
            'post_date' => $post_date,
            'is_featured' => $is_featured,
            'categories' => $category_names,
            'category_slugs' => $category_slugs
        );
        
        // Add to featured posts array if manually selected or marked as featured
        if (!empty($manual_featured_posts) && in_array($post_id, $featured_post_ids)) {
            array_push($featured_posts, $post_data);
            $featured_post_ids_for_display[] = $post_id;
        } elseif (empty($manual_featured_posts) && $is_featured) {
            array_push($featured_posts, $post_data);
            $featured_post_ids_for_display[] = $post_id;
        }
        
        array_push($all_posts, $post_data);
    }
    wp_reset_postdata();
    
    // If no featured posts are found, use the latest posts as fallback
    if (empty($featured_posts)) {
        $featured_posts = array_slice($all_posts, 0, $featured_posts_count);
        foreach ($featured_posts as $post) {
            $featured_post_ids_for_display[] = $post['post_id'];
        }
    } elseif (count($featured_posts) > $featured_posts_count) {
        // Limit to specified number of featured posts if more are selected
        $featured_posts = array_slice($featured_posts, 0, $featured_posts_count);
        // Update the featured_post_ids_for_display to only include the limited featured posts
        $featured_post_ids_for_display = array();
        foreach ($featured_posts as $post) {
            $featured_post_ids_for_display[] = $post['post_id'];
        }
    }

    // Convert posts to JSON for JavaScript
    $js_posts = json_encode($all_posts);
    $js_featured_post_ids = json_encode($featured_post_ids_for_display);
endif;
?>

<section class="blog-archive" id="blog-archive">
    <div class="content-area">
        <?php if($title): ?>
            <h1 class="page-title"><?php echo $title; ?></h1>
        <?php endif; ?>

        <!-- Featured Articles Grid -->
        <?php if(!empty($featured_posts)): ?>
        <div class="featured-posts-section">
            <div class="featured-posts-grid">
                <!-- Left Column - 3 smaller articles -->
                <div class="featured-posts-left">
                    <?php 
                    // Get smaller featured posts for left column (skip the main featured post)
                    $left_posts = array_slice($featured_posts, 1, 3); // Skip the first one (main featured post)
                    foreach($left_posts as $post): 
                        $categories = !empty($post['categories']) ? implode(', ', $post['categories']) : '';
                        $category_class = !empty($post['category_slugs']) ? implode(' ', $post['category_slugs']) : '';
                    ?>
                    <div class="featured-post featured-post-small">
                        <div class="featured-post-inner">
                            <div class="featured-content">
                                <?php if($categories): ?>
                                <div class="category-tag <?php echo $category_class; ?>"><?php echo $categories; ?></div>
                                <?php endif; ?>
                                <h3 class="article-title">
                                    <a href="<?php echo $post['permalink']; ?>" target="<?php echo $post['permalink_target']; ?>"><?php echo $post['post_title']; ?></a>
                                </h3>
                                <div class="article-meta">
                                    <div class="meta-date"><?php echo $post['post_date']; ?></div>
                                </div>
                                <div class="read-more">
                                    <a href="<?php echo $post['permalink']; ?>" target="<?php echo $post['permalink_target']; ?>" class="btn-read-more">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Right Column - 1 big featured article -->
                <div class="featured-posts-right">
                    <?php 
                    // Get the main featured post for right column (always the first one)
                    if(count($featured_posts) >= 1) {
                        $right_post = $featured_posts[0]; // Main featured post is always first
                        $categories = !empty($right_post['categories']) ? implode(', ', $right_post['categories']) : '';
                        $category_class = !empty($right_post['category_slugs']) ? implode(' ', $right_post['category_slugs']) : '';
                    ?>
                    <div class="featured-post featured-post-large">
                        <div class="featured-post-inner">
                            <?php if($right_post['featured_image']): ?>
                            <div class="featured-image">
                                <img src="<?php echo $right_post['featured_image']['url']; ?>" alt="<?php echo $right_post['featured_image']['alt']; ?>" class="img-fluid">
                            </div>
                            <?php endif; ?>
                            <div class="featured-content">
                                <?php if($categories): ?>
                                <div class="category-tag <?php echo $category_class; ?>"><?php echo $categories; ?></div>
                                <?php endif; ?>
                                <h3 class="article-title">
                                    <a href="<?php echo $right_post['permalink']; ?>" target="<?php echo $right_post['permalink_target']; ?>"><?php echo $right_post['post_title']; ?></a>
                                </h3>
                                <div class="article-meta">
                                    <div class="meta-date"><?php echo $right_post['post_date']; ?></div>
                                </div>
                                <?php if(!empty($right_post['excerpt'])): ?>
                                <div class="article-excerpt">
                                    <?php echo wp_trim_words($right_post['excerpt'], 25); ?>
                                </div>
                                <?php endif; ?>
                                <div class="read-more">
                                    <a href="<?php echo $right_post['permalink']; ?>" target="<?php echo $right_post['permalink_target']; ?>" class="btn-read-more">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Search and Filter Section -->
        <div class="filter-header">
            <h2>Search Posts</h2>
            <!-- Search Box -->
            <div class="search-box">
                <div class="search-input-container">
                    <input type="text" id="blog-search" placeholder="Search blog posts...">
                    <button id="search-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section" id="blog-filter-section">
            <!-- Category Filter Pills -->
            <div class="filter-by-category">
                <span class="filter-label">Filter by Category</span>
                <div class="category-pills-container">
                    <div class="category-pills">
                        <button class="category-pill active" data-category="">All Categories</button>
                        <?php 
                        if(!empty($blog_categories)):
                            foreach($blog_categories as $category): 
                        ?>
                            <button class="category-pill" data-category="<?php echo $category->slug; ?>"><?php echo $category->name; ?></button>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </div>
                </div>
            </div>
            <div class="filter-reset">
                <button class="reset-button">Reset Filters</button>
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <div class="blog-posts-grid" id="blog-posts-container">
            <!-- Posts will be loaded here via JavaScript -->
        </div>

        <!-- Pagination -->
        <div class="blog-pagination">
            <div class="pagination-numbers">
                <!-- Pagination numbers will be generated via JavaScript -->
            </div>
        </div>
    </div>
</section>

<script>
// Store posts data in JavaScript variable
var blogPosts = <?php echo $js_posts; ?>;
var featuredPostIds = <?php echo $js_featured_post_ids; ?>;
var postsPerPage = <?php echo $regular_posts_count; ?>;
var currentPage = 1;
var filteredPosts = [];

jQuery(document).ready(function($) {
    // Initialize category pills slider for mobile
    function initCategoryPillsSlider() {
        if ($(window).width() < 768 && !$('.category-pills').hasClass('slick-initialized')) {
            $('.category-pills').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: true,
                dots: false,
                infinite: false,
                variableWidth: true,
                prevArrow: '<button type="button" class="slick-prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></button>',
                nextArrow: '<button type="button" class="slick-next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></button>'
            });
        } else if ($(window).width() >= 768 && $('.category-pills').hasClass('slick-initialized')) {
            $('.category-pills').slick('unslick');
        }
    }

    // Call on page load and resize
    initCategoryPillsSlider();
    $(window).resize(function() {
        initCategoryPillsSlider();
    });

    // Filter out featured posts from regular posts display (only for default view)
    function filterOutFeaturedPosts(posts) {
        return posts.filter(function(post) {
            return !featuredPostIds.includes(post.post_id);
        });
    }

    // Initial load of posts (exclude featured posts to avoid duplication)
    filteredPosts = filterOutFeaturedPosts(blogPosts);
    displayPosts(filteredPosts, currentPage);
    setupPagination(filteredPosts.length, postsPerPage, currentPage);

    // Search functionality
    $('#search-button').on('click', function() {
        performSearch();
    });

    $('#blog-search').on('keyup', function(e) {
        if (e.keyCode === 13) {
            performSearch();
        }
    });

    function performSearch() {
        var searchTerm = $('#blog-search').val().toLowerCase().trim();
        
        // Reset category filter
        $('.category-pill').removeClass('active');
        $('.category-pill[data-category=""]').addClass('active');
        
        if (searchTerm === '') {
            // If search is empty, show all posts except featured ones to avoid duplication
            filteredPosts = filterOutFeaturedPosts(blogPosts);
        } else {
            // Filter posts by search term - include ALL posts (including featured) when searching
            filteredPosts = blogPosts.filter(function(post) {
                return (post.post_title.toLowerCase().includes(searchTerm) || 
                       post.excerpt.toLowerCase().includes(searchTerm));
            });
        }
        
        // Reset to first page and update display
        currentPage = 1;
        displayPosts(filteredPosts, currentPage);
        setupPagination(filteredPosts.length, postsPerPage, currentPage);
    }

    // Category filter functionality
    $('.category-pill').on('click', function() {
        $('.category-pill').removeClass('active');
        $(this).addClass('active');
        
        var selectedCategory = $(this).data('category');
        
        if (selectedCategory === '') {
            // Show all posts except featured ones to avoid duplication with featured section
            filteredPosts = filterOutFeaturedPosts(blogPosts);
        } else {
            // Filter posts by selected category - include ALL posts (including featured) when filtering by category
            filteredPosts = blogPosts.filter(function(post) {
                return post.category_slugs.includes(selectedCategory);
            });
        }
        
        // Reset to first page and update display
        currentPage = 1;
        displayPosts(filteredPosts, currentPage);
        setupPagination(filteredPosts.length, postsPerPage, currentPage);
    });

    // Reset filters
    $('.reset-button').on('click', function() {
        $('.category-pill').removeClass('active');
        $('.category-pill[data-category=""]').addClass('active');
        
        // Reset to default view (exclude featured posts to avoid duplication)
        filteredPosts = filterOutFeaturedPosts(blogPosts);
        currentPage = 1;
        displayPosts(filteredPosts, currentPage);
        setupPagination(filteredPosts.length, postsPerPage, currentPage);
    });

    // Function to display posts for current page
    function displayPosts(posts, page) {
        var container = $('#blog-posts-container');
        container.empty();
        
        // Calculate start and end index for current page
        var startIndex = (page - 1) * postsPerPage;
        var endIndex = Math.min(startIndex + postsPerPage, posts.length);
        
        // If no posts match the filter
        if (posts.length === 0) {
            container.html('<div class="no-posts-found">No posts found matching your criteria.</div>');
            return;
        }
        
        // Display posts for current page
        for (var i = startIndex; i < endIndex; i++) {
            var post = posts[i];
            var categories = post.categories.join(', ');
            var categoryClasses = post.category_slugs.join(' ');
            
            var postHTML = `
                <div class="blog-post">
                    <div class="blog-post-inner">
                        ${post.featured_image ? 
                            `<div class="post-image">
                                <a href="${post.permalink}" target="${post.permalink_target}">
                                    <img src="${post.featured_image.url}" alt="${post.featured_image.alt || post.post_title}" class="img-fluid">
                                </a>
                            </div>` : ''}
                        <div class="post-content">
                            ${categories ? 
                                `<div class="category-tag ${categoryClasses}">${categories}</div>` : ''}
                            <div class="post-date">${post.post_date}</div>
                            <h3 class="post-title">
                                <a href="${post.permalink}" target="${post.permalink_target}">${post.post_title}</a>
                            </h3>
                            ${post.excerpt ? 
                                `<div class="post-excerpt">${post.excerpt}</div>` : ''}
                            <div class="read-more">
                                <a href="${post.permalink}" target="${post.permalink_target}" class="btn-read-more">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.append(postHTML);
        }
    }

    // Function to setup pagination
    function setupPagination(totalPosts, postsPerPage, currentPage) {
        var paginationContainer = $('.pagination-numbers');
        paginationContainer.empty();
        
        // Calculate total pages
        var totalPages = Math.ceil(totalPosts / postsPerPage);
        
        if (totalPages <= 1) {
            return; // No pagination needed
        }
        
        // Previous button
        if (currentPage > 1) {
            paginationContainer.append(`<a href="#" class="page-number prev" data-page="${currentPage - 1}">«</a>`);
        } else {
            paginationContainer.append(`<span class="page-number prev disabled">«</span>`);
        }
        
        // Page numbers
        var startPage = Math.max(1, currentPage - 2);
        var endPage = Math.min(totalPages, startPage + 4);
        
        if (endPage - startPage < 4 && startPage > 1) {
            startPage = Math.max(1, endPage - 4);
        }
        
        for (var i = startPage; i <= endPage; i++) {
            if (i === currentPage) {
                paginationContainer.append(`<span class="page-number current">${i}</span>`);
            } else {
                paginationContainer.append(`<a href="#" class="page-number" data-page="${i}">${i}</a>`);
            }
        }
        
        // Next button
        if (currentPage < totalPages) {
            paginationContainer.append(`<a href="#" class="page-number next" data-page="${currentPage + 1}">»</a>`);
        } else {
            paginationContainer.append(`<span class="page-number next disabled">»</span>`);
        }
        
        // Add click event for pagination
        $('.page-number:not(.disabled)').on('click', function(e) {
            e.preventDefault();
            currentPage = parseInt($(this).data('page'));
            displayPosts(filteredPosts, currentPage);
            setupPagination(filteredPosts.length, postsPerPage, currentPage);
            
            // Scroll to filter section instead of top of blog section
            $('html, body').animate({
                scrollTop: $('#blog-filter-section').offset().top - 80
            }, 500);
        });
    }
});
</script>
