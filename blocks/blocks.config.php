<?php

// Featured Content Section
acf_register_block_type(
    array(
        'name' => 'featured-content-section',
        'title' => __('Featured Content Section'),
        'description' => __('A section with centered content featuring pretitle, title, text, and button.'),
        'render_template' => 'blocks/templates/featured-content-section.php',
        'enqueue_style' => get_template_directory_uri() . '/css/featured-content-section.css',
        'keywords' => array('featured-content', 'featured', 'content', 'section', 'centered'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'editor-aligncenter',
        ), 
        'mode' => 'edit'
    )
);

// Blog Archive Block
acf_register_block_type(
    array(
        'name' => 'blog-archive',
        'title' => __('Blog Page'),
        'description' => __('A stylized blog archive page with featured posts slider, category filters, and pagination'),
        'render_template' => 'blocks/templates/blog-archive.php',
        'enqueue_style' => get_template_directory_uri() . '/css/blog-archive.css',
        'keywords' => array('blog', 'archive', 'posts', 'featured', 'categories'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-posts',
        ), 
        'mode' => 'edit'
    ),
);

// Homepage iFrame 
acf_register_block_type(
    array(
        'name' => 'homepage-iframe',
        'title' => __('Homepage iFrame'),
        'description' => __(''),
        'render_template' => 'blocks/templates/homepage-iframe.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/homepage-banner/homepage-banner.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/homepage-banner/homepage-banner.js',
        'keywords' => array('homepage-iframe',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 
        'mode' => 'edit'
    ),
);

// Homepage Banner
acf_register_block_type(
    array(
        'name' => 'homepage-banner',
        'title' => __('Homepage Banner'),
        'description' => __(''),
        'render_template' => 'blocks/templates/homepage-banner.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/homepage-banner/homepage-banner.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/homepage-banner/homepage-banner.js',
        'keywords' => array('homepage-banner',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 
        'mode' => 'edit'
    )
);

// Hero Banner
acf_register_block_type(
    array(
        'name' => 'hero-banner',
        'title' => __('Hero Banner'),
        'description' => __('A hero banner with text content and an image on the right side'),
        'render_template' => 'blocks/templates/hero-banner.php',
        'enqueue_style' => get_template_directory_uri() . '/css/hero-banner.css',
        'keywords' => array('hero', 'banner', 'image', 'header'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'align-left',
        ), 
        'mode' => 'edit'
    )
);

// Hero + Lead Form
acf_register_block_type(
    array(
        'name' => 'hero-lead-form',
        'title' => __('Hero + Lead Form'),
        'description' => __('Two-column hero section with CTA and a Gravity Form.'),
        'render_template' => 'blocks/templates/hero-lead-form.php',
        'enqueue_style' => get_template_directory_uri() . '/css/hero-lead-form.css',
        'keywords' => array('hero', 'lead', 'form', 'cta', 'gravity forms'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'feedback',
        ), 
        'mode' => 'edit'
    )
);

// What We Do
acf_register_block_type(
    array(
        'name' => 'what-we-do',
        'title' => __('What We Do'),
        'description' => __(''),
        'render_template' => 'blocks/templates/what-we-do.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/what-we-do/what-we-do.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/what-we-do/what-we-do.js',
        'keywords' => array('what-we-do',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Get More
acf_register_block_type(
    array(
        'name' => 'get-more',
        'title' => __('Get More'),
        'description' => __(''),
        'render_template' => 'blocks/templates/get-more.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/get-more/get-more.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/get-more/get-more.js',
        'keywords' => array('get-more',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Get More Alternative
acf_register_block_type(
    array(
        'name' => 'get-more-alternative',
        'title' => __('Get More Alternative'),
        'description' => __(''),
        'render_template' => 'blocks/templates/get-more-alternative.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/get-more-alternative/get-more-alternative.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/get-more-alternative/get-more-alternative.js',
        'keywords' => array('get-more-alternative',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Business analytics
acf_register_block_type(
    array(
        'name' => 'business-analytics',
        'title' => __('Business Analytics'),
        'description' => __(''),
        'render_template' => 'blocks/templates/business-analytics.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/business-analytics/business-analytics.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/business-analytics/business-analytics.js',
        'keywords' => array('business-analytics',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Let AI
acf_register_block_type(
    array(
        'name' => 'let-ai',
        'title' => __('Let AI'),
        'description' => __(''),
        'render_template' => 'blocks/templates/let-ai.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/let-ai/let-ai.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/let-ai/let-ai.js',
        'keywords' => array('let-ai',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Integrates Software
acf_register_block_type(
    array(
        'name' => 'integrates-software',
        'title' => __('Integrates Software'),
        'description' => __(''),
        'render_template' => 'blocks/templates/integrates-software.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/integrates-software/integrates-software.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/integrates-software/integrates-software.js',
        'keywords' => array('integrates-software',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Image Video with Text Right
acf_register_block_type(
    array(
        'name' => 'image-video-w-text-right',
        'title' => __('Image Video with Text Right'),
        'description' => __('A section with image/video on the right and text content on the left with white background'),
        'render_template' => 'blocks/templates/image-video-w-text-right.php',
        'enqueue_style' => get_template_directory_uri() . '/css/image-video-w-text.css',
        'keywords' => array('image', 'video', 'text', 'right', 'content'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'align-right',
        ), 
        'mode' => 'edit'
    )
);

// Testimonials
acf_register_block_type(
    array(
        'name' => 'testimonials',
        'title' => __('Testimonials'),
        'description' => __(''),
        'render_template' => 'blocks/templates/testimonials.php',
        'enqueue_style' => get_template_directory_uri() . '/css/testimonial-tabbed.css',
        'enqueue_script' => get_template_directory_uri() . '/js/testimonial-tabbed.js',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/testimonial/testimonial.js',
        'keywords' => array('testimonials',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// News & Press
acf_register_block_type(
    array(
        'name' => 'news-press',
        'title' => __('News & Press'),
        'description' => __(''),
        'render_template' => 'blocks/templates/news-press.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-press/news-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-press/news-press.js',
        'keywords' => array('news-press',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Custom Code
acf_register_block_type(
    array(
        'name' => 'custom-code',
        'title' => __('Custom Code'),
        'description' => __(''),
        'render_template' => 'blocks/templates/custom-code.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/custom-code/custom-code.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/custom-code/custom-code.js',
        'keywords' => array('custom-code',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Page Banner
acf_register_block_type(
    array(
        'name' => 'page-banner',
        'title' => __('Page Banner'),
        'description' => __(''),
        'render_template' => 'blocks/templates/page-banner.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/page-banner/page-banner.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/page-banner/page-banner.js',
        'keywords' => array('page-banner',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Our Values
acf_register_block_type(
    array(
        'name' => 'our-values',
        'title' => __('Our Values'),
        'description' => __(''),
        'render_template' => 'blocks/templates/our-values.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/our-values/our-values.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/our-values/our-values.js',
        'keywords' => array('our-values',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Leadership
acf_register_block_type(
    array(
        'name' => 'leadership',
        'title' => __('Leadership'),
        'description' => __(''),
        'render_template' => 'blocks/templates/leadership.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/leadership/leadership.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/leadership/leadership.js',
        'keywords' => array('leadership',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Investors
acf_register_block_type(
    array(
        'name' => 'investors',
        'title' => __('Investors'),
        'description' => __(''),
        'render_template' => 'blocks/templates/investors.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/investors/investors.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/investors/investors.js',
        'keywords' => array('investors',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Join our Team
acf_register_block_type(
    array(
        'name' => 'join-our-team',
        'title' => __('Join Our Team'),
        'description' => __(''),
        'render_template' => 'blocks/templates/join-our-team.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/join-our-team/join-our-team.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/join-our-team/join-our-team.js',
        'keywords' => array('join-our-team',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Open Positions
acf_register_block_type(
    array(
        'name' => 'open-positions',
        'title' => __('Open Positions'),
        'description' => __(''),
        'render_template' => 'blocks/templates/open-positions.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/open-positions/open-positions.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/open-positions/open-positions.js',
        'keywords' => array('open-positions',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Contact Us
acf_register_block_type(
    array(
        'name' => 'contact-us',
        'title' => __('Contact Us'),
        'description' => __(''),
        'render_template' => 'blocks/templates/contact-us.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/contact-us/contact-us.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/contact-us/contact-us.js',
        'keywords' => array('contact-us',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Privacy Policy
acf_register_block_type(
    array(
        'name' => 'privacy-policy',
        'title' => __('Privacy Policy'),
        'description' => __(''),
        'render_template' => 'blocks/templates/privacy-policy.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/privacy-policy/privacy-policy.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/privacy-policy/privacy-policy.js',
        'keywords' => array('privacy-policy',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// News and Press
acf_register_block_type(
    array(
        'name' => 'news-and-press',
        'title' => __('News and Press Archive'),
        'description' => __(''),
        'render_template' => 'blocks/templates/news-and-press-archive.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('news-and-press-archive',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Video
acf_register_block_type(
    array(
        'name' => 'video-section',
        'title' => __('Video'),
        'description' => __(''),
        'render_template' => 'blocks/templates/video.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('video',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Work With us
acf_register_block_type(
    array(
        'name' => 'work-with-us',
        'title' => __('Work With Us'),
        'description' => __(''),
        'render_template' => 'blocks/templates/work-with-us.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('work-with-us',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Blog Content
acf_register_block_type(
    array(
        'name' => 'blog-content',
        'title' => __('Blog Content'),
        'description' => __(''),
        'render_template' => 'blocks/templates/blog-content.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('blog-content',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// More From Blog
acf_register_block_type(
    array(
        'name' => 'more-from-blog',
        'title' => __('More From Blog'),
        'description' => __(''),
        'render_template' => 'blocks/templates/more-from-blog.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('more-from-blog',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// CTA
acf_register_block_type(
    array(
        'name' => 'cta',
        'title' => __('CTA'),
        'description' => __(''),
        'render_template' => 'blocks/templates/cta.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('cta',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);


// Image Video w/ Text
acf_register_block_type(
    array(
        'name' => 'image-video-w-text',
        'title' => __('Image Video w/ Text'),
        'description' => __(''),
        'render_template' => 'blocks/templates/image-video-w-text.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('image-video-w-text',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Hero Banner
acf_register_block_type(
    array(
        'name' => 'hero-banner',
        'title' => __('Hero Banner'),
        'description' => __(''),
        'render_template' => 'blocks/templates/hero-banner.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('hero-banner',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// WYSIWIG
acf_register_block_type(
    array(
        'name' => 'events-block',
        'title' => __('Events Block'),
        'description' => __('Display a list of events in grid or list format'),
        'render_template' => 'blocks/templates/events-block.php',
        'enqueue_style' => get_template_directory_uri() . '/css/events.css',
        'keywords' => array('events', 'calendar', 'upcoming'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'calendar-alt',
        ), 
        'mode' => 'edit'
    )
);

acf_register_block_type(
    array(
        'name' => 'wysiwig',
        'title' => __('WYSIWIG'),
        'description' => __('A flexible content block with WYSIWYG editor, alignment options, background colors, and padding controls.'),
        'render_template' => 'blocks/templates/wysiwig.php',
        'enqueue_style' => get_template_directory_uri() . '/css/wysiwig.css',
        'keywords' => array('wysiwig', 'content', 'text', 'editor'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// Integration Posts
acf_register_block_type(
    array(
        'name' => 'integration-posts',
        'title' => __('Integration Posts'),
        'description' => __(''),
        'render_template' => 'blocks/templates/integration-posts.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('integration-posts',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// CTA v2
acf_register_block_type(
    array(
        'name' => 'cta-v2',
        'title' => __('CTA V2'),
        'description' => __(''),
        'render_template' => 'blocks/templates/cta-v2.php',
        // 'enqueue_style' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.css',
        // 'enqueue_script' => get_template_directory_uri() . '/blocks/templates/news-and-press/news-and-press.js',
        'keywords' => array('cta-v2',),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 'mode' => 'edit'
    ),
);

// External Link Button
acf_register_block_type(
    array(
        'name' => 'external-link-button',
        'title' => __('External Link Button'),
        'description' => __('A button that links to external URLs with customizable text and styling'),
        'render_template' => 'blocks/templates/external-link-button.php',
        'enqueue_style' => get_template_directory_uri() . '/css/external-link-button.css',
        'keywords' => array('button', 'link', 'external', 'cta', 'call-to-action'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-links',
        ), 
        'mode' => 'edit'
    )
);

// Rolling Logos
acf_register_block_type(
    array(
        'name' => 'rolling-logos',
        'title' => __('Rolling Logos'),
        'description' => __('A scrolling logos section displaying company logos with smooth horizontal animation'),
        'render_template' => 'blocks/templates/rolling-logos.php',
        'enqueue_style' => get_template_directory_uri() . '/css/rolling-logos.css',
        'keywords' => array('logos', 'companies', 'integrations', 'partners', 'scroll', 'animation'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'format-gallery',
        ), 
        'mode' => 'edit'
    )
);

// Gallery Block
acf_register_block_type(
    array(
        'name' => 'gallery-block',
        'title' => __('Gallery Block'),
        'description' => __('A gallery block displaying 5 images in a specific layout - 3 on top, 2 on bottom'),
        'render_template' => 'blocks/templates/gallery-block.php',
        'enqueue_style' => get_template_directory_uri() . '/css/gallery-block.css',
        'keywords' => array('gallery', 'images', 'photos', 'team', 'careers'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'format-gallery',
        ), 
        'mode' => 'edit'
    )
);

// Table of Contents Block
acf_register_block_type(
    array(
        'name' => 'table-of-contents',
        'title' => __('Table of Contents'),
        'description' => __('Auto-generated table of contents from page headings with configurable options'),
        'render_template' => 'blocks/templates/table-of-contents.php',
        'enqueue_style' => get_template_directory_uri() . '/css/table-of-contents.css',
        'keywords' => array('toc', 'table of contents', 'navigation', 'headings', 'outline'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'list-view',
        ), 
        'mode' => 'edit'
    )
);

// FAQ Block
acf_register_block_type(
    array(
        'name' => 'faq-block',
        'title' => __('FAQ Block'),
        'description' => __('A flexible FAQ block with accordion functionality, schema markup, and customizable display options'),
        'render_template' => 'blocks/templates/faq-block.php',
        'enqueue_style' => get_template_directory_uri() . '/css/faq-block.css',
        'keywords' => array('faq', 'questions', 'answers', 'accordion', 'schema', 'seo'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'editor-help',
        ), 
        'mode' => 'edit'
    )
);

// Pricing Hero Block
acf_register_block_type(
    array(
        'name' => 'pricing-hero',
        'title' => __('Pricing Hero'),
        'description' => __('A centered hero section for pricing pages with heading, subheading, description, and two CTA buttons'),
        'render_template' => 'blocks/templates/pricing-hero.php',
        'enqueue_style' => get_template_directory_uri() . '/css/pricing-hero.css',
        'keywords' => array('pricing', 'hero', 'pricing-hero', 'cta', 'centered'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'editor-aligncenter',
        ), 
        'mode' => 'edit'
    )
);

// Pricing Table Block
acf_register_block_type(
    array(
        'name' => 'pricing-table',
        'title' => __('Pricing Table'),
        'description' => __('A card-based pricing table displaying multiple plans with features and included features section'),
        'render_template' => 'blocks/templates/pricing-table.php',
        'enqueue_style' => get_template_directory_uri() . '/css/pricing-table.css',
        'keywords' => array('pricing', 'table', 'plans', 'pricing-table', 'features'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'grid-view',
        ), 
        'mode' => 'edit'
    )
);

// Plan Comparison Block
acf_register_block_type(
    array(
        'name' => 'plan-comparison',
        'title' => __('Plan Comparison'),
        'description' => __('A comparison table showing capabilities across different pricing plans'),
        'render_template' => 'blocks/templates/plan-comparison.php',
        'enqueue_style' => get_template_directory_uri() . '/css/plan-comparison.css',
        'keywords' => array('pricing', 'comparison', 'plan-comparison', 'table', 'features'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'editor-table',
        ), 
        'mode' => 'edit'
    )
);

// Hero with Timeline Block
acf_register_block_type(
    array(
        'name' => 'hero-timeline',
        'title' => __('Hero with Timeline'),
        'description' => __('Hero section with timeline showing incident events, trust badges, and CTAs'),
        'render_template' => 'blocks/templates/hero-timeline.php',
        'enqueue_style' => get_template_directory_uri() . '/css/hero-timeline.css',
        'keywords' => array('hero', 'timeline', 'incident', 'war-room'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'clock',
        ), 
        'mode' => 'edit'
    )
);

// Features Grid Block
acf_register_block_type(
    array(
        'name' => 'features-grid',
        'title' => __('Features Grid'),
        'description' => __('Grid layout displaying key features in a 3x2 format'),
        'render_template' => 'blocks/templates/features-grid.php',
        'enqueue_style' => get_template_directory_uri() . '/css/features-grid.css',
        'keywords' => array('features', 'grid', 'capabilities'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'grid-view',
        ), 
        'mode' => 'edit'
    )
);

// How It Works Block
acf_register_block_type(
    array(
        'name' => 'how-it-works',
        'title' => __('How It Works'),
        'description' => __('Three-step process, metrics, and webinars section'),
        'render_template' => 'blocks/templates/how-it-works.php',
        'enqueue_style' => get_template_directory_uri() . '/css/how-it-works.css',
        'keywords' => array('how-it-works', 'process', 'metrics', 'webinars'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 
        'mode' => 'edit'
    )
);

// CTA Block
acf_register_block_type(
    array(
        'name' => 'cta-retire-war-room',
        'title' => __('CTA'),
        'description' => __('CTA section with title, description, and two buttons'),
        'render_template' => 'blocks/templates/cta-retire-war-room.php',
        'enqueue_style' => get_template_directory_uri() . '/css/cta-retire-war-room.css',
        'keywords' => array('cta', 'war-room', 'call-to-action'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'megaphone',
        ), 
        'mode' => 'edit'
    )
);

// Use Cases Table Block
acf_register_block_type(
    array(
        'name' => 'use-cases-table',
        'title' => __('Use Cases Table'),
        'description' => __('A 3x3 grid table displaying use cases with complex cell content'),
        'render_template' => 'blocks/templates/use-cases-table.php',
        'enqueue_style' => get_template_directory_uri() . '/css/use-cases-table.css',
        'keywords' => array('use-cases', 'table', 'grid', 'aws'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'editor-table',
        ), 
        'mode' => 'edit'
    )
);

// Cloud Resources Block
acf_register_block_type(
    array(
        'name' => 'cloud-resources',
        'title' => __('Cloud Resources'),
        'description' => __('A compact resources table for linking to PDFs and collateral'),
        'render_template' => 'blocks/templates/cloud-resources.php',
        'enqueue_style' => get_template_directory_uri() . '/css/cloud-resources.css',
        'keywords' => array('resources', 'pdf', 'collateral', 'table'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'media-document',
        ),
        'mode' => 'edit'
    )
);

// Integration Options Block
acf_register_block_type(
    array(
        'name' => 'integration-options',
        'title' => __('Integration Options'),
        'description' => __('A 3-column comparison table showing integration/deployment options'),
        'render_template' => 'blocks/templates/integration-options.php',
        'enqueue_style' => get_template_directory_uri() . '/css/integration-options.css',
        'keywords' => array('integration', 'options', 'deployment', 'comparison', 'table'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'admin-settings',
        ), 
        'mode' => 'edit'
    )
);

// Process Steps Block
acf_register_block_type(
    array(
        'name' => 'process-steps',
        'title' => __('Process Steps'),
        'description' => __('Display process steps with images and text in an alternating layout'),
        'render_template' => 'blocks/templates/process-steps.php',
        'enqueue_style' => get_template_directory_uri() . '/css/process-steps.css',
        'keywords' => array('process', 'steps', 'workflow', 'image', 'text'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'images-alt2',
        ), 
        'mode' => 'edit'
    )
);

// Steps Grid Block
acf_register_block_type(
    array(
        'name' => 'steps-grid',
        'title' => __('Steps Grid'),
        'description' => __('Display steps in a grid layout with icons and cards'),
        'render_template' => 'blocks/templates/steps-grid.php',
        'enqueue_style' => get_template_directory_uri() . '/css/steps-grid.css',
        'keywords' => array('steps', 'grid', 'cards', 'process', 'workflow'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'grid-view',
        ), 
        'mode' => 'edit'
    )
);

// Feature List Block
acf_register_block_type(
    array(
        'name' => 'feature-list',
        'title' => __('Feature List'),
        'description' => __('A flexible block for displaying feature lists with optional attribution section'),
        'render_template' => 'blocks/templates/feature-list.php',
        'enqueue_style' => get_template_directory_uri() . '/css/feature-list.css',
        'keywords' => array('feature', 'list', 'items', 'attribution', 'content'),
        'supports' => [
            'align' => false,
        ],
        'icon' => array(
            'background' => '#2b84ef',
            'src' => 'editor-ul',
        ), 
        'mode' => 'edit'
    )
);