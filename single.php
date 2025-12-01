<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package neubird
 */

get_header();
$themeurl = get_stylesheet_directory_uri();
$third_party_link = get_field('3rd_party_link', $post_id);

if ($third_party_link) {
	wp_redirect($third_party_link, 301);
	exit();
}
$post_id = get_the_ID();

$written_by = get_field('written_by')?:'';
$permalink = get_permalink();
$post_title = get_the_title();
$date = get_the_date();
$blog_cat = get_the_terms($post_id, 'blog-categories');

$back_button_link_blog = get_field('back_button_link_blog', 'option')?:'';

// Enqueue FAQ block styles for blog posts
wp_enqueue_style('faq-block-style', get_template_directory_uri() . '/css/faq-block.css', array(), '1.0.0');
?>

<main id="primary" class="site-main">
	<section class="blog_content">
		<div class="content-area">
			<?php if($back_button_link_blog):
				$back_button_link_blog_url = $back_button_link_blog['url'];
				$back_button_link_blog_title = $back_button_link_blog['title'];
				$back_button_link_blog_target = $back_button_link_blog['target'] ? $back_button_link_blog['target'] : '_self';
				?>
				<div class="last_updated">
					<a <?php echo $back_button_link_blog_url && $back_button_link_blog_url != '#' ? 'href="'.$back_button_link_blog_url.'"' : '' ?> target="<?php echo $back_button_link_blog_target ?>">
						<img src="<?php echo $themeurl ?>/images/svg/left_arrow.svg" alt="arrow left" class="img-fluid">
						<span><?php echo $back_button_link_blog_title; ?></span>
					</a>
				</div>
			<?php endif; ?>
			<div class="top_area">
				<div class="meta_area">
					<p>
						<span><?php echo $date; ?></span>
						<span class="divider"></span>
						<span>
            <?php 
            if ($blog_cat && !is_wp_error($blog_cat)) {
                $category_name = $blog_cat[0]->name;
                echo $category_name;
            } 
            ?> 
        </span>
					</p>
				</div>
				<div class="title_area">
					<h1><?php echo $post_title; ?></h1>
				</div>
			</div>
			<div class="bottom_area">
				<div class="left_area">
				<?php

					$blocks = parse_blocks( get_the_content() );
					foreach ( $blocks as $block ) {
						if($block['blockName'] == 'acf/blog-content') {
							echo render_block( $block );
						}
					}

				?>
				</div>
				<div class="right_area">
					<?php if($written_by): ?>
						<h4>Written by</h4>
						<?php 
						 	echo '<div class="written-area">';
							foreach ($written_by as $key => $value) {
								$image = $value['image'];
								$position = $value['position'];
								$name = $value['name'];

								if($image || $position || $name) {
									?>
									<div class="single_written">
										<?php if($image): ?>
											<div class="img_area">
												<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
											</div>
										<?php endif; ?>

										<div class="text_area">
											<?php if($position): ?>
												<span><?php echo $position ?></span>
											<?php endif; ?>

											<?php if($name): ?>
												<p><?php echo $name; ?></p>
											<?php endif; ?>
										</div>
									</div>
									<?php
								}
							}
							echo '</div>';
						?>
					<?php endif; ?>

					<div class="share_box">
						<p>Share VIA</p>
						<div class="flex_area">
							<a href="http://twitter.com/share?url=<?php echo $permalink; ?>" target="_blank">
								<img src="<?php echo $themeurl ?>/images/svg/icon-twitter-white.svg" alt="twitter">
							</a>
							<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>" target="_blank">
								<img src="<?php echo $themeurl ?>/images/svg/icon-linked-new.svg" alt="linked">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php 
		foreach ( $blocks as $block ) {
			if($block['blockName'] !== 'acf/blog-content') {
				echo render_block( $block );
			}
		}
	?>

	<?php 
	// FAQ Section for Blog Posts
	$blog_faq_header = get_field('blog_faq_header');
	$blog_faq_subheading = get_field('blog_faq_subheading');
	$blog_faq_display_style = get_field('blog_faq_display_style');
	$blog_faq_layout = get_field('blog_faq_layout');
	$blog_faq_enable_schema = get_field('blog_faq_enable_schema');
	$blog_faq_items = get_field('blog_faq_items');

	if ($blog_faq_items && !empty($blog_faq_items)) :
	?>
	<section class="blog-faq-section">
		<div class="content-area">
			<div class="blog-faq-inline">
				<?php if ($blog_faq_header) : ?>
					<h2 class="faq-header"><?php echo esc_html($blog_faq_header); ?></h2>
				<?php endif; ?>
				
				<?php if ($blog_faq_subheading) : ?>
					<p class="faq-subheading blog-help"><?php echo esc_html($blog_faq_subheading); ?></p>
				<?php endif; ?>
				
				<div class="faq-container <?php echo esc_attr($blog_faq_layout ?: 'single_column'); ?>">
					<?php foreach ($blog_faq_items as $index => $faq_item) : 
						$question = $faq_item['question'];
						$answer = $faq_item['answer'];
						$is_first = $index === 0;
						$is_expanded = ($blog_faq_display_style === 'accordion_open' || 
									  ($blog_faq_display_style === 'first_expanded' && $is_first) ||
									  $blog_faq_display_style === 'always_open');
					?>
						<div class="faq-item <?php echo $is_expanded ? 'active' : ''; ?>">
							<?php if ($blog_faq_display_style === 'always_open') : ?>
								<div class="faq-question" style="cursor: default;">
									<?php echo esc_html($question); ?>
								</div>
							<?php else : ?>
								<button class="faq-question" 
										aria-expanded="<?php echo $is_expanded ? 'true' : 'false'; ?>"
										data-toggle="faq-answer-<?php echo $index; ?>">
									<?php echo esc_html($question); ?>
								</button>
							<?php endif; ?>
							<div class="faq-answer" id="faq-answer-<?php echo $index; ?>" <?php echo !$is_expanded ? 'style="display: none;"' : ''; ?>>
								<?php echo wp_kses_post($answer); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

    <?php if ($blog_faq_enable_schema && $blog_faq_items) : ?>
    <?php
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];
        foreach ($blog_faq_items as $faq_item) {
            $q = wp_strip_all_tags($faq_item['question']);
            $a = wp_strip_all_tags($faq_item['answer']);
            $a = preg_replace('/\s+/', ' ', $a);
            $a = trim($a);
            if (!$q || !$a) { continue; }
            $schema['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $q,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $a,
                ],
            ];
        }
    ?>
    <script type="application/ld+json">
    <?php echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
    </script>
    <?php endif; ?>
	<?php endif; ?>

	<!-- Related Posts Section -->
	<?php
	// Only show related posts for blog post type
	if (get_post_type() === 'blog' && !empty($blog_cat)) {
		// Get the first category
		$current_category = $blog_cat[0];
		$current_post_id = get_the_ID();
		
		// Query related posts from the same category
		$related_args = array(
			'post_type' => 'blog',
			'posts_per_page' => 3,
			'post__not_in' => array($current_post_id), // Exclude current post
			'tax_query' => array(
				array(
					'taxonomy' => 'blog-categories',
					'field' => 'term_id',
					'terms' => $current_category->term_id,
				),
			),
		);
		
		$related_query = new WP_Query($related_args);
		
		if ($related_query->have_posts()) :
	?>
	<section class="related-posts-section">
		<div class="content-area">
			<h2 class="related-posts-title">Related Articles</h2>
			<div class="related-posts-grid">
				<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
					<div class="blog-post">
						<div class="blog-post-inner">
							<?php if (has_post_thumbnail()) : ?>
							<div class="post-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('medium'); ?>
								</a>
							</div>
							<?php endif; ?>
							<div class="post-content">
								<?php
								$post_categories = get_the_terms(get_the_ID(), 'blog-categories');
								if ($post_categories && !is_wp_error($post_categories)) : ?>
									<div class="category-tag"><?php echo $post_categories[0]->name; ?></div>
								<?php endif; ?>
								<div class="post-date"><?php echo get_the_date('F j, Y'); ?></div>
								<h3 class="post-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<div class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></div>
								<div class="read-more">
									<a href="<?php the_permalink(); ?>" class="btn-read-more">Read More</a>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>
	<?php
		endif;
		wp_reset_postdata();
	}
	?>
</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Blog FAQ Toggle Functionality
    const blogFaqToggles = document.querySelectorAll('.blog-faq-inline .faq-question[data-toggle]');
    
    blogFaqToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-toggle');
            const answer = document.getElementById(targetId);
            const faqItem = this.closest('.faq-item');
            
            if (answer) {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                if (isExpanded) {
                    // Collapse
                    answer.style.display = 'none';
                    this.setAttribute('aria-expanded', 'false');
                    faqItem.classList.remove('active');
                } else {
                    // Expand
                    answer.style.display = 'block';
                    this.setAttribute('aria-expanded', 'true');
                    faqItem.classList.add('active');
                }
            }
        });
    });
});
</script>

<?php
get_footer();
