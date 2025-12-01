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
$post_id = get_the_ID();

$third_party_link = get_field('3rd_party_link', $post_id);
$enable_post_page = get_field('enable_post_page', $post_id);

$post_title = get_the_title($post_id);

if ($third_party_link) {
	wp_redirect($third_party_link, 301);
	exit();
}

if($enable_post_page !== FALSE) {
    $enable_post_page = 1;
}

if(!$enable_post_page) {
    wp_redirect(get_site_url(), 301);
	exit();
}

// Enqueue FAQ block styles for integration posts
wp_enqueue_style('faq-block-style', get_template_directory_uri() . '/css/faq-block.css', array(), '1.0.0');

$logo = get_field('logo', $post_id);
$custom_logo_width_integrations_post_page = get_field('custom_logo_width_-_integrations_post_page', $post_id);
$text = get_field('text', $post_id);
$sidebar_text = get_field('sidebar_text', $post_id);
$tags = get_field('tags', $post_id);

$button_get_started = get_field('button_get_started', $post_id);
$title_related_articles = get_field('title_related_articles', $post_id);
$related_articles = get_field('related_articles', $post_id);
$hero_headline = get_field('hero_headline', $post_id);

$back_link_integrations = get_field('back_link_integrations', 'option');

?>

<main id="primary" class="site-main">
    <section class="top_banner_integration">
        <div class="content-area">
            <?php if($back_link_integrations):
                $back_link_integrations_url = $back_link_integrations['url'];
                $back_link_integrations_title = $back_link_integrations['title'];
                $back_link_integrations_target = $back_link_integrations['target'] ? $back_link_integrations['target'] : '_self';
            ?>
            <div class="back_link_area">
                <a <?php echo $back_link_integrations_url && $back_link_integrations_url != '#' ? 'href="'.$back_link_integrations_url.'"' : '' ?> target="<?php echo $back_link_integrations_target ?>">
                <img src="<?php echo $themeurl ?>/images/svg/left_arrow.svg" alt="arrow left" class="img-fluid"><span><?php echo $back_link_integrations_title ?></span></a>
            </div>
        <?php endif; ?>

        <?php if($logo): ?>
            <div class="logo_area">
                <img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" class="img-fluid" <?php echo $custom_logo_width_integrations_post_page ? 'style="width:'.$custom_logo_width_integrations_post_page.'px;"' : '' ?>>
            </div>
        <?php endif; ?>
            <?php if($hero_headline): ?>
                <h1><?php echo $hero_headline ?></h1>
            <?php endif; ?>
        </div>
    </section>

    <?php if($text || $sidebar_text || $tags): ?>
        <section class="integration_content">
            <div class="content-area">
                <div class="main_content">
                    <?php 
                    // Check if content contains FAQ blocks to avoid duplicates
                    $content_has_faq = strpos($text, 'faq-block') !== false || strpos($text, 'wp:acf/faq-block') !== false;
                    echo $text;
                    ?>

                    <?php if($tags): ?>
                        <div class="tag_wrap d-none d-md-flex">
                            <?php 
                                foreach ($tags as $key => $value) {
                                    $title_tag = $value['title'];
                                    $url_tag = $value['url'];

                                    if($title_tag) {
                                        if($url_tag) {
                                            ?>
                                            <a href="<?php echo $url_tag ?>"><?php echo $title_tag ?></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="#" style="pointer-events: none;"><?php echo $title_tag ?></a>
                                            <?php
                                        }
                                    }
                                }
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php 
                    // FAQ Section - Only render if content doesn't already have FAQ blocks
                    if (!$content_has_faq):
                        $integration_faq_header = get_field('integration_faq_header', $post_id);
                        $integration_faq_subheading = get_field('integration_faq_subheading', $post_id);
                        $integration_faq_display_style = get_field('integration_faq_display_style', $post_id);
                        $integration_faq_layout = get_field('integration_faq_layout', $post_id);
                        $integration_faq_enable_schema = get_field('integration_faq_enable_schema', $post_id);
                        $integration_faq_items = get_field('integration_faq_items', $post_id);

                        if ($integration_faq_items && count($integration_faq_items) > 0): 
                            $faq_block_id = 'faq-block-integration-' . $post_id;
                            $display_style = $integration_faq_display_style ?: 'static';
                            $layout = $integration_faq_layout ?: 'single';
                            $enable_schema = $integration_faq_enable_schema !== false ? true : false;
                        ?>
                        <div class="integration-faq-inline">
                            <?php if ($integration_faq_subheading): ?>
                                <div class="faq-subheading integration-help"><?php echo wp_kses_post($integration_faq_subheading); ?></div>
                            <?php endif; ?>
                            
                            <?php if ($integration_faq_header): ?>
                                <h2 class="faq-header"><?php echo esc_html($integration_faq_header); ?></h2>
                            <?php endif; ?>
                            
                            <div class="faq-container <?php echo esc_attr($layout ?: 'single_column'); ?>" id="<?php echo $faq_block_id; ?>">
                                <?php foreach ($integration_faq_items as $index => $faq_item): 
                                    $question = $faq_item['question'];
                                    $answer = $faq_item['answer'];
                                    $is_first = $index === 0;
                                    
                                    // Determine if this FAQ should be expanded based on display style
                                    $is_expanded = false;
                                    switch ($display_style) {
                                        case 'accordion_open':
                                            $is_expanded = true;
                                            break;
                                        case 'first_open':
                                            $is_expanded = $is_first;
                                            break;
                                        case 'accordion_closed':
                                            $is_expanded = false;
                                            break;
                                        case 'static':
                                        case 'always_open':
                                            $is_expanded = true;
                                            break;
                                        case 'accordion':
                                        default:
                                            $is_expanded = $is_first; // Default behavior - first expanded
                                            break;
                                    }
                                    
                                    $item_id = $faq_block_id . '-item-' . $index;
                                    $has_toggle = ($display_style !== 'static' && $display_style !== 'always_open');
                                ?>
                                    <div class="faq-item <?php echo $is_expanded ? 'active' : ''; ?>">
                                        <?php if ($has_toggle): ?>
                                            <button class="faq-question" 
                                                    aria-expanded="<?php echo $is_expanded ? 'true' : 'false'; ?>"
                                                    aria-controls="<?php echo $item_id; ?>"
                                                    data-toggle="faq">
                                                <h4><?php echo esc_html($question); ?></h4>
                                                <span class="faq-toggle-icon" aria-hidden="true">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path class="horizontal-line" d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                        <path class="vertical-line" d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                    </svg>
                                                </span>
                                            </button>
                                            <div class="faq-answer" 
                                                 id="<?php echo $item_id; ?>" 
                                                 <?php echo $is_expanded ? '' : 'style="display: none;"'; ?>>
                                                <div class="faq-answer-content">
                                                    <?php echo wp_kses_post($answer); ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="faq-question-static">
                                                <h4><?php echo esc_html($question); ?></h4>
                                            </div>
                                            <div class="faq-answer-static">
                                                <div class="faq-answer-content">
                                                    <?php echo wp_kses_post($answer); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <?php if ($enable_schema): ?>
                            <?php
                                $schema = [
                                    '@context' => 'https://schema.org',
                                    '@type' => 'FAQPage',
                                    'mainEntity' => []
                                ];
                                foreach ($integration_faq_items as $faq_item) {
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
                <?php endif; ?>
                </div>
                <?php if($sidebar_text): ?>
                    <div class="sidebar_content">
                        <div class="box">
                            <?php echo $sidebar_text ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="main_content d-md-none">
                    <?php if($tags): ?>
                        <div class="tag_wrap">
                            <?php 
                                foreach ($tags as $key => $value) {
                                    $title_tag = $value['title'];
                                    $url_tag = $value['url'];

                                    if($title_tag) {
                                        if($url_tag) {
                                            ?>
                                            <a href="<?php echo $url_tag ?>"><?php echo $title_tag ?></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="#" style="pointer-events: none;"><?php echo $title_tag ?></a>
                                            <?php
                                        }
                                    }
                                }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const faqToggles = document.querySelectorAll('#<?php echo $faq_block_id; ?> [data-toggle="faq"]');
                    
                    faqToggles.forEach(function(toggle) {
                        toggle.addEventListener('click', function() {
                            const answer = this.nextElementSibling;
                            const isExpanded = this.getAttribute('aria-expanded') === 'true';
                            
                            // Toggle the answer visibility
                            if (isExpanded) {
                                answer.style.display = 'none';
                                this.setAttribute('aria-expanded', 'false');
                                this.classList.remove('active');
                                this.parentElement.classList.remove('active');
                            } else {
                                answer.style.display = 'block';
                                this.setAttribute('aria-expanded', 'true');
                                this.classList.add('active');
                                this.parentElement.classList.add('active');
                            }
                        });
                        
                        // Set initial state
                        if (toggle.getAttribute('aria-expanded') === 'true') {
                            toggle.classList.add('active');
                            toggle.parentElement.classList.add('active');
                        }
                    });
                });
                </script>
            </div>
        </section>
    <?php endif; ?>

    <?php if($button_get_started):
        $button_get_started_url = $button_get_started['url'];
        $button_get_started_title = $button_get_started['title'];
        $button_get_started_target = $button_get_started['target'] ? $button_get_started['target'] : '_self';
        ?>
        <section class="let-ai-do-work cta_version cta_integrations">
            <div class="content-area">
                <div class="text-area aos-init aos-animate" data-aos="fade-in">
                    <a <?php echo $button_get_started_url && $button_get_started_url != '#' ? 'href="'.$button_get_started_url.'"' : '' ?> target="<?php echo $button_get_started_target ?>" class="btn btn-primary"><?php echo $button_get_started_title ?></a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if($title_related_articles || $related_articles): ?>
        <section class="more_from_blog">
            <div class="content-area">
                <?php if($title_related_articles): ?>
                    <div class="title_area">
                        <h2><?php echo $title_related_articles ?></h2>
                    </div>
                <?php endif; ?>
                <?php if($related_articles): ?>
                    <div class="news-boxes">
                        <?php 
                            foreach ($related_articles as $key => $value) {
                                $post_id_related = $value;
    
                                $post_title = get_the_title($post_id_related);
                                $permalink_target = '_self';
                                $permalink = get_permalink($post_id_related);
                                $featured_image = get_field('featured_image', $post_id_related);
                                $logo = '';
                                $excerpt = get_field('excerpt', $post_id_related);
                                $get_the_date = get_the_date('F j, Y', $post_id_related);
    
                                $third_party_link = get_field('3rd_party_link', $post_id_related);
                        
                                if($third_party_link) {
                                $permalink = $third_party_link;
                                $permalink_target = '_blank';
                                }
                        
                                $type_news_post = get_the_category($post_id_related);
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
    
                                // $type_news_post = get_the_terms($post_id_related, 'blog-categories');
                                // $type_news_post_arr_slug = wp_list_pluck($type_news_post, 'slug');
                                // $type_news_post_arr = wp_list_pluck($type_news_post, 'name');
                                // $type_news_name = '';
                                // if($type_news_post) {
                                //     foreach ($type_news_post as $key => $value) {
                        
                                //         if($key + 1 == count($type_news_post)){
                                //             $type_news_name .= $value->name;
                                //         } else {
                                //             $type_news_name .= $value->name . ', ';
                                //         }
                                //     }
                                // }
    
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
    <?php endif; ?>


</main><!-- #main -->

<?php
get_footer();
