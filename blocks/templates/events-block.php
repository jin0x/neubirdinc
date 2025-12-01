<?php
/**
 * Events Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *
 * @package neubird
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'events-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'events-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

// Block attributes
$number_of_events = get_field('number_of_events') ?: 3;
$layout_type = get_field('layout_type') ?: 'grid';
$show_date = get_field('show_date') !== false;
$show_location = get_field('show_location') !== false;
$show_excerpt = get_field('show_excerpt') !== false;
$show_featured_image = get_field('show_featured_image') !== false;
$title = get_field('title') ?: 'Upcoming Events';
$show_only_future_events = get_field('show_only_future_events');

// Query events
$args = array(
    'post_type' => 'event',
    'posts_per_page' => $number_of_events,
    'orderby' => 'meta_value',
    'meta_key' => 'event_date',
    'meta_type' => 'DATETIME',
    'order' => 'ASC',
);

// If show only future events is enabled
if ($show_only_future_events) {
    // Use start of today - events today are still upcoming
    $today_start = date('Y-m-d 00:00:00');
    $args['meta_query'] = array(
        array(
            'key' => 'event_date',
            'value' => $today_start,
            'compare' => '>=',
            'type' => 'DATETIME'
        )
    );
}

$events_query = new WP_Query($args);
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> layout-<?php echo esc_attr($layout_type); ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="title-area text-center">
                    <h2><?php echo esc_html($title); ?></h2>
                </div>
            </div>
        </div>
        
        <?php if ($events_query->have_posts()) : ?>
            <div class="row events-<?php echo esc_attr($layout_type); ?>">
                <?php while ($events_query->have_posts()) : $events_query->the_post(); 
                    // Get event meta
                    $event_date = get_field('event_date');
                    $event_end_date = get_field('event_end_date');
                    $event_location = get_field('event_location');
                    $event_url = get_field('event_url');
                    
                    // Format date range if end date exists
                    if ($event_date) {
                        $event_timestamp = strtotime($event_date);
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
                            $formatted_date = date_i18n('F j, Y', $event_timestamp);
                        }
                    } else {
                        $formatted_date = '';
                    }
                    
                    // Determine column classes based on layout
                    $column_class = $layout_type === 'grid' ? 'col-md-6 col-lg-4 mb-4' : 'col-12 mb-4';
                ?>
                    <div class="<?php echo esc_attr($column_class); ?>">
                        <div class="event-card <?php echo $layout_type === 'list' ? 'event-card-horizontal' : ''; ?>">
                            <?php if ($show_featured_image && has_post_thumbnail()) : ?>
                                <div class="event-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large', array('class' => 'img-fluid')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="event-content">
                                <div class="event-meta">
                                    <?php if ($show_date && $formatted_date) : ?>
                                        <span class="event-date"><?php echo esc_html($formatted_date); ?></span>
                                    <?php endif; ?>
                                    <?php if ($show_location && $event_location) : ?>
                                        <span class="event-location"><?php echo wp_kses_post(nl2br($event_location)); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="event-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                
                                <?php 
                                // Check for On-demand badge
                                $is_on_demand = get_field('is_on_demand');
                                if ($is_on_demand) : 
                                ?>
                                    <div class="event-badges">
                                        <span class="event-badge on-demand-badge">On-demand</span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($show_excerpt) : ?>
                                    <div class="event-excerpt">
                                        <?php 
                                        $excerpt = get_field('event_description') ? wp_strip_all_tags(get_field('event_description')) : get_the_excerpt();
                                        echo wp_trim_words($excerpt, 20, '...');
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            
            <?php if (get_field('show_view_all_button')) : ?>
                <div class="row">
                    <div class="col-12 text-center mt-4">
                        <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>" class="btn btn-secondary">View All Events</a>
                    </div>
                </div>
            <?php endif; ?>
            
        <?php else : ?>
            <div class="row">
                <div class="col-12">
                    <p class="no-events-message">No events found. Check back soon for upcoming events.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
