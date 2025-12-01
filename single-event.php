<?php
/**
 * The template for displaying single Events
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package neubird
 */

get_header();

// Get event meta
$event_image = get_field('event_image');
$event_description = get_field('event_description');
$event_location = get_field('event_location');
$event_date = get_field('event_date');
$event_url = get_field('event_url');
$button_text = get_field('button_text');

// Handle event type - use new event_type field only
$event_type = get_field('event_type');

// Determine event type based on new field
$is_on_demand = ($event_type === 'on_demand');
$is_live = ($event_type === 'live');
$is_in_person = ($event_type === 'in_person');

$event_pacific_time = get_field('event_pacific_time');
$event_eastern_time = get_field('event_eastern_time');
// New fields: all-day toggle and Calendly integration
$event_all_day = get_field('event_all_day');
$event_calendly_enable = get_field('event_calendly_enable');
$event_calendly_url = get_field('event_calendly_url');
$event_calendly_button_text = get_field('event_calendly_button_text');

// Format date with time zones
$event_end_date = get_field('event_end_date');
$full_formatted_date = '';
if ($event_date && !$is_on_demand) {
    $event_timestamp = strtotime($event_date);
    $has_event_time = (date('H:i', $event_timestamp) !== '00:00');
    
    // Format date range if end date exists
    if ($event_end_date) {
        $end_timestamp = strtotime($event_end_date);
        $start_date = date('F j', $event_timestamp);
        $end_date = date('F j, Y', $end_timestamp);
        
        // If same month, show "Dec 2 - 4, 2024"
        if (date('F Y', $event_timestamp) === date('F Y', $end_timestamp)) {
            $formatted_date = $start_date . ' - ' . date('j', $end_timestamp) . ', ' . date('Y', $end_timestamp);
        } else {
            $formatted_date = $start_date . ' - ' . $end_date;
        }
    } else {
        $formatted_date = date('F j, Y', $event_timestamp);
    }
    
    // Show time when not all-day and either explicit PT/ET provided or date includes a time
    $show_time = ($is_live || $is_in_person) && !$event_all_day && ( !empty($event_pacific_time) || !empty($event_eastern_time) || $has_event_time );

    if ($show_time) {
        if (!empty($event_pacific_time) || !empty($event_eastern_time)) {
            $pt_display = !empty($event_pacific_time) ? ($event_pacific_time . ' PDT') : '';
            $et_display = !empty($event_eastern_time) ? ($event_eastern_time . ' EDT') : '';
            // Prefer Pacific time in the main display, consistent with prior UI
            $time_suffix = !empty($pt_display) ? ', ' . $pt_display : ( !empty($et_display) ? ', ' . $et_display : '' );
            $full_formatted_date = $formatted_date . $time_suffix;
        } else {
            // Fall back to time from event_date
            $full_formatted_date = $formatted_date . ', ' . date('g:i A', $event_timestamp);
        }
    } else {
        $full_formatted_date = $formatted_date; // all-day, no time shown
    }
} elseif ($event_date && $is_on_demand) {
    // For on-demand events, show date range if exists, otherwise just date
    $event_timestamp = strtotime($event_date);
    if ($event_end_date) {
        $end_timestamp = strtotime($event_end_date);
        $start_date = date('F j', $event_timestamp);
        $end_date = date('F j, Y', $end_timestamp);
        
        if (date('F Y', $event_timestamp) === date('F Y', $end_timestamp)) {
            $full_formatted_date = $start_date . ' - ' . date('j', $end_timestamp) . ', ' . date('Y', $end_timestamp);
        } else {
            $full_formatted_date = $start_date . ' - ' . $end_date;
        }
    } else {
        $full_formatted_date = date('F j, Y', $event_timestamp);
    }
}
?>

<main id="primary" class="site-main">

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="event-single-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="event-back-navigation">
                            <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>" class="back-to-events">
                                <i class="fas fa-arrow-left"></i> Back to Events
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Event Header Above Image -->
                        <div class="event-header">
                            <h1 class="event-title"><?php the_title(); ?></h1>
                            <?php if ($event_description) : ?>
                                <div class="event-description">
                                    <?php echo wp_kses_post($event_description); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="event-featured-section">
                            <?php if ($event_image) : ?>
                                <div class="event-featured-image">
                                    <img src="<?php echo esc_url($event_image['url']); ?>" alt="<?php echo esc_attr($event_image['alt']); ?>" class="img-fluid">
                                </div>
                            <?php elseif (has_post_thumbnail()) : ?>
                                <div class="event-featured-image">
                                    <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="event-content-area">
                            <div class="event-main-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="event-sidebar">
                            <div class="event-details-card">
                                <h3>Event Details</h3>
                                
                                <?php 
                                // Show event badges
                                if ($is_on_demand || $is_live || $is_in_person) : 
                                ?>
                                    <div class="event-badges mb-3">
                                        <?php if ($is_on_demand) : ?>
                                            <span class="event-badge on-demand-badge">ON-DEMAND</span>
                                        <?php endif; ?>
                                        <?php if ($is_live) : ?>
                                            <span class="event-badge live-badge">LIVE</span>
                                        <?php endif; ?>
                                        <?php if ($is_in_person) : ?>
                                            <span class="event-badge in-person-badge">IN PERSON</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <ul class="event-details-list">
                                    <?php if ($full_formatted_date) : ?>
                                        <li>
                                            <strong>Date:</strong> <span class="event-detail-value event-date-value"><?php echo esc_html($full_formatted_date); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($event_location) : ?>
                                        <?php 
                                            // Force single-line location (replace breaks/newlines with commas)
                                            $location_single_line = preg_replace('/\s*(<br\s*\/?>|\r?\n)+\s*/i', ', ', $event_location);
                                        ?>
                                        <li>
                                            <strong>Location:</strong> <span class="event-detail-value event-location-value"><?php echo esc_html($location_single_line); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php 
                                    // Get event categories
                                    $event_categories = get_the_terms(get_the_ID(), 'event-categories');
                                    if ($event_categories && !is_wp_error($event_categories)) : 
                                    ?>
                                        <li>
                                            <strong>Categories:</strong> <span class="event-detail-value">
                                            <?php 
                                                $cat_names = array();
                                                foreach ($event_categories as $category) {
                                                    $cat_names[] = $category->name;
                                                }
                                            echo esc_html(implode(', ', $cat_names));
                                            ?>
                                            </span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                
                                <?php if ($event_url) : 
                                    // Use custom button text if provided, otherwise set defaults based on event type
                                    if (!empty($button_text)) {
                                        $display_button_text = $button_text;
                                    } elseif ($is_on_demand) {
                                        $display_button_text = 'WATCH NOW';
                                    } else {
                                        $display_button_text = 'Register Now';
                                    }
                                ?>
                                    <div class="event-cta">
                                        <a href="<?php echo esc_url($event_url); ?>" class="btn btn-primary btn-block" target="_blank" rel="noopener noreferrer"><?php echo esc_html($display_button_text); ?></a>
                                    </div>
                                <?php endif; ?>

                                <?php if ($event_calendly_enable && !empty($event_calendly_url)) : ?>
                                    <div class="event-cta">
                                        <a href="#" class="btn btn-secondary btn-block" onclick="Calendly.initPopupWidget({url: '<?php echo esc_js($event_calendly_url); ?>'}); return false;">
                                            <?php echo esc_html(!empty($event_calendly_button_text) ? $event_calendly_button_text : 'Book a meeting'); ?>
                                        </a>
                                    </div>
                                    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                                <?php endif; ?>
                            </div>
                            
                            <?php
                            // Get related events
                            $today_start = date('Y-m-d 00:00:00');
                            $related_args = array(
                                'post_type' => 'event',
                                'posts_per_page' => 3,
                                'post__not_in' => array(get_the_ID()),
                                'orderby' => 'meta_value',
                                'meta_key' => 'event_date',
                                'meta_type' => 'DATETIME',
                                'order' => 'ASC',
                                'meta_query' => array(
                                    array(
                                        'key' => 'event_date',
                                        'value' => $today_start,
                                        'compare' => '>=',
                                        'type' => 'DATETIME'
                                    )
                                )
                            );
                            
                            $related_events = new WP_Query($related_args);
                            
                            if ($related_events->have_posts()) :
                            ?>
                                <div class="related-events">
                                    <h3>Upcoming Events</h3>
                                    <ul class="related-events-list">
                                        <?php while ($related_events->have_posts()) : $related_events->the_post(); 
                                            $rel_event_date = get_field('event_date', get_the_ID());
                                            $rel_event_end_date = get_field('event_end_date', get_the_ID());
                                            
                                            if ($rel_event_date) {
                                                $rel_timestamp = strtotime($rel_event_date);
                                                if ($rel_event_end_date) {
                                                    $rel_end_timestamp = strtotime($rel_event_end_date);
                                                    $rel_start_date = date('F j', $rel_timestamp);
                                                    $rel_end_date = date('F j, Y', $rel_end_timestamp);
                                                    
                                                    if (date('F Y', $rel_timestamp) === date('F Y', $rel_end_timestamp)) {
                                                        $rel_formatted_date = $rel_start_date . ' - ' . date('j', $rel_end_timestamp) . ', ' . date('Y', $rel_end_timestamp);
                                                    } else {
                                                        $rel_formatted_date = $rel_start_date . ' - ' . $rel_end_date;
                                                    }
                                                } else {
                                                    $rel_formatted_date = date_i18n('F j, Y', $rel_timestamp);
                                                }
                                            } else {
                                                $rel_formatted_date = '';
                                            }
                                        ?>
                                            <li>
                                                <a href="<?php the_permalink(); ?>">
                                                    <span class="related-event-date"><?php echo esc_html($rel_formatted_date); ?></span>
                                                    <span class="related-event-title"><?php the_title(); ?></span>
                                                </a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                    <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>" class="view-all-events">View All Events</a>
                                </div>
                            <?php 
                            wp_reset_postdata();
                            endif; 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="event-navigation">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="post-navigation">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            
                            <?php if (!empty($prev_post)) : ?>
                                <div class="nav-previous">
                                    <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                                        <span class="nav-subtitle">&larr; Previous Event</span>
                                        <span class="nav-title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($next_post)) : ?>
                                <div class="nav-next">
                                    <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
                                        <span class="nav-subtitle">Next Event &rarr;</span>
                                        <span class="nav-title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article><!-- #post-<?php the_ID(); ?> -->

</main><!-- #main -->

<?php
// Add JSON-LD structured data for events
function event_structured_data() {
    if (is_singular('event')) {
        $event_date = get_field('event_date');
        $event_location = get_field('event_location');
        $event_description = get_field('event_description') ? get_field('event_description') : get_the_excerpt();
        
        if ($event_date) {
            $schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'Event',
                'name' => get_the_title(),
                'description' => wp_strip_all_tags($event_description),
                'startDate' => date('c', strtotime($event_date)),
                'url' => get_permalink(),
            );
            
            if ($event_location) {
                $schema['location'] = array(
                    '@type' => 'Place',
                    'name' => $event_location,
                    'address' => $event_location
                );
            }
            
            if (has_post_thumbnail()) {
                $schema['image'] = get_the_post_thumbnail_url(get_the_ID(), 'full');
            } elseif ($event_image = get_field('event_image')) {
                $schema['image'] = $event_image['url'];
            }
            
            echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
        }
    }
}
add_action('wp_head', 'event_structured_data');

get_footer();
