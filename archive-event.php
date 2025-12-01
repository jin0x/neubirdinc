<?php
/**
 * The template for displaying Events archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package neubird
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="events-archive">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-area text-center">
                        <h1><?php post_type_archive_title(); ?></h1>
                        <p class="subtitle">Watch and learn, live and on demand</p>
                    </div>
                </div>
            </div>
            
            <?php
            // Current filters
            $current_timing = isset($_GET['timing']) ? sanitize_text_field($_GET['timing']) : 'combined';
            $search_query = isset($_GET['event_search']) ? sanitize_text_field($_GET['event_search']) : '';
            
            // Current view
            $current_view = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : 'grid';
            ?>
            
            <div class="row mb-4">
                <div class="col-12">
                    <div class="events-filter-bar">
                        <form action="<?php echo esc_url(get_post_type_archive_link('event')); ?>" method="get" class="event-filters-form">
                            <div class="filters-row">
                                <div class="search-box">
                                    <input type="text" name="event_search" placeholder="Search events..." value="<?php echo esc_attr($search_query); ?>" class="search-input">
                                    <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                                </div>
                                
                                <div class="filters-group">
                                    <div class="timing-filter-buttons">
                                        <button type="button" class="timing-btn <?php echo ($current_timing === 'upcoming' || $current_timing === '') ? 'active' : ''; ?>" onclick="setTimingFilter('upcoming')">
                                            Upcoming
                                        </button>
                                        <button type="button" class="timing-btn <?php echo $current_timing === 'past' ? 'active' : ''; ?>" onclick="setTimingFilter('past')">
                                            Past Events
                                        </button>
                                    </div>
                                    
                                    <div class="view-toggle">
                                        <?php
                                        $grid_url = add_query_arg('view', 'grid', remove_query_arg('paged', get_pagenum_link()));
                                        $list_url = add_query_arg('view', 'list', remove_query_arg('paged', get_pagenum_link()));
                                        
                                        // Preserve filters if set
                                        if (!empty($current_timing)) {
                                            $grid_url = add_query_arg('timing', $current_timing, $grid_url);
                                            $list_url = add_query_arg('timing', $current_timing, $list_url);
                                        }
                                        if (!empty($search_query)) {
                                            $grid_url = add_query_arg('event_search', $search_query, $grid_url);
                                            $list_url = add_query_arg('event_search', $search_query, $list_url);
                                        }
                                        
                                        $grid_active = ($current_view === 'grid' || $current_view === '') ? 'active' : '';
                                        $list_active = ($current_view === 'list') ? 'active' : '';
                                        ?>
                                        <a href="<?php echo esc_url($grid_url); ?>" class="view-button <?php echo esc_attr($grid_active); ?>" title="Grid View"><i class="fas fa-th-large"></i></a>
                                        <a href="<?php echo esc_url($list_url); ?>" class="view-button <?php echo esc_attr($list_active); ?>" title="List View"><i class="fas fa-list"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="timing" id="timing-filter" value="<?php echo esc_attr($current_timing); ?>">
                            <?php if (!empty($current_view)) : ?>
                                <input type="hidden" name="view" value="<?php echo esc_attr($current_view); ?>">
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            // Set up the query arguments
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'event',
                'posts_per_page' => 12,
                'paged' => $paged,
                'meta_key' => 'event_date',
                'orderby' => 'meta_value',
                'meta_type' => 'DATETIME',
                'order' => 'DESC'
            );
            
            // Initialize meta_query array
            $meta_query = array();
            
            // Add timing filter (upcoming/past/categories)
            if (!empty($current_timing) && $current_timing !== 'combined') {
                // Use start of today to compare - events today are still upcoming
                $today_start = date('Y-m-d 00:00:00');
                
                if ($current_timing === 'upcoming') {
                    // Show events that start today or in the future
                    $meta_query[] = array(
                        'key' => 'event_date',
                        'value' => $today_start,
                        'compare' => '>=',
                        'type' => 'DATETIME'
                    );
                    $args['order'] = 'ASC'; // Show upcoming events in chronological order
                } elseif ($current_timing === 'past') {
                    // Show events that ended before today (check end date if exists, otherwise start date)
                    // For events without end date, check if start date is before today
                    $meta_query[] = array(
                        'relation' => 'OR',
                        array(
                            'key' => 'event_end_date',
                            'value' => $today_start,
                            'compare' => '<',
                            'type' => 'DATETIME'
                        ),
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => 'event_end_date',
                                'compare' => 'NOT EXISTS'
                            ),
                            array(
                                'key' => 'event_date',
                                'value' => $today_start,
                                'compare' => '<',
                                'type' => 'DATETIME'
                            )
                        )
                    );
                    $args['order'] = 'DESC'; // Show past events with most recent first
                } else {
                    // For category-based filters (featured, intro, ai), show all events but can be filtered by taxonomy if needed
                    // This is a placeholder - you might want to implement taxonomy-based filtering here
                }
            }
            
            // Apply meta query if we have conditions
            if (!empty($meta_query)) {
                $args['meta_query'] = $meta_query;
            }
            
            // Add search query if set
            if (!empty($search_query)) {
                $args['s'] = $search_query;
            }
            
            // Combined mode: Build two queries, upcoming then past
            $events_query = null;
            $past_query = null;
            $total_events = 0;
            if ($current_timing === 'combined') {
                $today_start = date('Y-m-d 00:00:00');
                $upcoming_args = $args;
                $upcoming_args['order'] = 'ASC';
                $upcoming_args['meta_query'] = array(
                    array(
                        'key' => 'event_date',
                        'value' => $today_start,
                        'compare' => '>=',
                        'type' => 'DATETIME'
                    )
                );
                $events_query = new WP_Query($upcoming_args);

                $past_args = $args;
                $past_args['order'] = 'DESC';
                $past_args['meta_query'] = array(
                    'relation' => 'OR',
                    array(
                        'key' => 'event_end_date',
                        'value' => $today_start,
                        'compare' => '<',
                        'type' => 'DATETIME'
                    ),
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'event_end_date',
                            'compare' => 'NOT EXISTS'
                        ),
                        array(
                            'key' => 'event_date',
                            'value' => $today_start,
                            'compare' => '<',
                                'type' => 'DATETIME'
                        )
                    )
                );
                $past_query = new WP_Query($past_args);
                $total_events = $events_query->found_posts + $past_query->found_posts;
            } else {
                $events_query = new WP_Query($args);
                $total_events = $events_query->found_posts;
            }
            ?>
            
            <div class="event-count">
                <p>
                    <strong><?php echo $total_events; ?></strong> 
                    <?php echo $total_events === 1 ? 'Event' : 'Events'; ?> 
                    <?php if ($current_timing === 'upcoming') echo 'Upcoming'; ?>
                    <?php if ($current_timing === 'past') echo 'from the Past'; ?>
                    <?php if ($current_timing === 'combined') echo 'listed'; ?>
                    <?php if (!empty($search_query)) echo 'matching "' . esc_html($search_query) . '"'; ?>
                </p>
            </div>

            <?php
            // Determine view type
            $view_class = ($current_view === 'list') ? 'events-list' : 'events-grid';
            $column_class = ($current_view === 'list') ? 'col-12 mb-4' : 'col-md-6 col-xl-4 mb-4';
            ?>
            
            <div class="row <?php echo esc_attr($view_class); ?>">
                <?php if ($current_timing === 'combined') : ?>
                    <?php if ($events_query->have_posts()) : ?>
                        <div class="col-12"><h2 class="mb-3">Upcoming Events</h2></div>
                        <?php while ($events_query->have_posts()) : $events_query->the_post(); ?>
                            <div class="<?php echo esc_attr($column_class); ?>">
                                <div class="event-card <?php echo $current_view === 'list' ? 'event-card-horizontal' : ''; ?>">
                                    <?php 
                                    $event_image = get_field('event_image');
                                    if ($event_image || has_post_thumbnail()) : 
                                    ?>
                                        <div class="event-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if ($event_image) : ?>
                                                    <img src="<?php echo esc_url($event_image['url']); ?>" alt="<?php echo esc_attr($event_image['alt']); ?>" class="img-fluid">
                                                <?php else : ?>
                                                    <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="event-content">
                                        <h3 class="event-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <?php 
                                        $event_type = get_field('event_type');
                                        $is_on_demand = ($event_type === 'on_demand');
                                        $is_live = ($event_type === 'live');
                                        $is_in_person = ($event_type === 'in_person');
                                        ?>
                                        <div class="event-meta-row">
                                            <?php if ($is_live || $is_on_demand || $is_in_person) : ?>
                                                <?php if ($is_live) : ?>
                                                    <span class="event-badge live-badge"><span class="live-dot"></span>LIVE</span>
                                                <?php endif; ?>
                                                <?php if ($is_on_demand) : ?>
                                                    <span class="event-badge on-demand-badge">ON-DEMAND</span>
                                                <?php endif; ?>
                                                <?php if ($is_in_person) : ?>
                                                    <span class="event-badge in-person-badge">IN PERSON</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if (get_field('event_date')) : ?>
                                                <?php
                                                $event_date = get_field('event_date');
                                                $event_end_date = get_field('event_end_date');
                                                $event_timestamp = strtotime($event_date);
                                                
                                                // Format date range if end date exists
                                                if ($event_end_date) {
                                                    $end_timestamp = strtotime($event_end_date);
                                                    $start_date = date('F j', $event_timestamp);
                                                    $end_date = date('F j Y', $end_timestamp);
                                                    
                                                    // If same month, show "Dec 2 - 4, 2024"
                                                    if (date('F Y', $event_timestamp) === date('F Y', $end_timestamp)) {
                                                        $formatted_date = $start_date . ' - ' . date('j', $end_timestamp) . ', ' . date('Y', $end_timestamp);
                                                    } else {
                                                        $formatted_date = $start_date . ' - ' . $end_date;
                                                    }
                                                } else {
                                                    $formatted_date = date('F j Y', $event_timestamp);
                                                }
                                                
                                                // Show time only if explicitly set in ACF; otherwise treat as all-day
                                                $pacific_time = get_field('event_pacific_time');
                                                $eastern_time = get_field('event_eastern_time');
                                                $all_day = get_field('event_all_day');
                                                $has_event_time = (date('H:i', $event_timestamp) !== '00:00');
                                                $show_time = ($is_live || $is_in_person) && !$is_on_demand && !$all_day && ( !empty($pacific_time) || !empty($eastern_time) || $has_event_time );
                                                if ($show_time && (!empty($pacific_time) || !empty($eastern_time))) {
                                                    $pacific_time = !empty($pacific_time) ? ($pacific_time . ' PDT') : '';
                                                    $eastern_time = !empty($eastern_time) ? ($eastern_time . ' EDT') : '';
                                                }
                                                ?>
                                                <?php if ($show_time) : ?>
                                                    <?php if (!empty($pacific_time) || !empty($eastern_time)) : ?>
                                                        <span class="event-date"><i class="fas fa-calendar-alt"></i> <?php echo $formatted_date; ?>, <?php echo esc_html($pacific_time); ?></span>
                                                    <?php else : ?>
                                                        <span class="event-date"><i class="fas fa-calendar-alt"></i> <?php echo $formatted_date; ?>, <?php echo esc_html(date('g:i A', $event_timestamp)); ?></span>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <span class="event-date"><i class="fas fa-calendar-alt"></i> <?php echo $formatted_date; ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if (get_field('event_location')) : ?>
                                                <?php $loc_text = preg_replace('/\s*(<br\s*\/?>|\r?\n)+\s*/i', ', ', get_field('event_location')); ?>
                                                <span class="event-location"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($loc_text); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($current_view !== 'list') : ?>
                                            <div class="event-excerpt">
                                                <?php 
                                                $excerpt = get_field('event_description') ? wp_strip_all_tags(get_field('event_description')) : get_the_excerpt();
                                                echo wp_trim_words($excerpt, 20, '...');
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="event-actions">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>

                    <?php if ($past_query && $past_query->have_posts()) : ?>
                        <div class="col-12"><h2 class="mt-4 mb-3">Past Events</h2></div>
                        <?php while ($past_query->have_posts()) : $past_query->the_post(); ?>
                            <div class="<?php echo esc_attr($column_class); ?>">
                                <div class="event-card <?php echo $current_view === 'list' ? 'event-card-horizontal' : ''; ?>">
                                    <?php 
                                    $event_image = get_field('event_image');
                                    if ($event_image || has_post_thumbnail()) : 
                                    ?>
                                        <div class="event-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if ($event_image) : ?>
                                                    <img src="<?php echo esc_url($event_image['url']); ?>" alt="<?php echo esc_attr($event_image['alt']); ?>" class="img-fluid">
                                                <?php else : ?>
                                                    <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="event-content">
                                        <h3 class="event-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <?php 
                                        $event_type = get_field('event_type');
                                        $is_on_demand = ($event_type === 'on_demand');
                                        $is_live = ($event_type === 'live');
                                        $is_in_person = ($event_type === 'in_person');
                                        ?>
                                        <div class="event-meta-row">
                                            <?php if ($is_live || $is_on_demand || $is_in_person) : ?>
                                                <?php if ($is_live) : ?>
                                                    <span class="event-badge live-badge"><span class="live-dot"></span>LIVE</span>
                                                <?php endif; ?>
                                                <?php if ($is_on_demand) : ?>
                                                    <span class="event-badge on-demand-badge">ON-DEMAND</span>
                                                <?php endif; ?>
                                                <?php if ($is_in_person) : ?>
                                                    <span class="event-badge in-person-badge">IN PERSON</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if (get_field('event_date')) : ?>
                                                <?php
                                                $event_date = get_field('event_date');
                                                $event_end_date = get_field('event_end_date');
                                                $event_timestamp = strtotime($event_date);
                                                
                                                // Format date range if end date exists
                                                if ($event_end_date) {
                                                    $end_timestamp = strtotime($event_end_date);
                                                    $start_date = date('F j', $event_timestamp);
                                                    $end_date = date('F j Y', $end_timestamp);
                                                    
                                                    // If same month, show "Dec 2 - 4, 2024"
                                                    if (date('F Y', $event_timestamp) === date('F Y', $end_timestamp)) {
                                                        $formatted_date = $start_date . ' - ' . date('j', $end_timestamp) . ', ' . date('Y', $end_timestamp);
                                                    } else {
                                                        $formatted_date = $start_date . ' - ' . $end_date;
                                                    }
                                                } else {
                                                    $formatted_date = date('F j Y', $event_timestamp);
                                                }
                                                
                                                // Show time only if explicitly set in ACF; otherwise treat as all-day
                                                $pacific_time = get_field('event_pacific_time');
                                                $eastern_time = get_field('event_eastern_time');
                                                $all_day = get_field('event_all_day');
                                                $has_event_time = (date('H:i', $event_timestamp) !== '00:00');
                                                $show_time = ($is_live || $is_in_person) && !$is_on_demand && !$all_day && ( !empty($pacific_time) || !empty($eastern_time) || $has_event_time );
                                                if ($show_time && (!empty($pacific_time) || !empty($eastern_time))) {
                                                    $pacific_time = !empty($pacific_time) ? ($pacific_time . ' PDT') : '';
                                                    $eastern_time = !empty($eastern_time) ? ($eastern_time . ' EDT') : '';
                                                }
                                                ?>
                                                <?php if ($show_time) : ?>
                                                    <?php if (!empty($pacific_time) || !empty($eastern_time)) : ?>
                                                        <span class="event-date"><i class="fas fa-calendar-alt"></i> <?php echo $formatted_date; ?>, <?php echo esc_html($pacific_time); ?></span>
                                                    <?php else : ?>
                                                        <span class="event-date"><i class="fas fa-calendar-alt"></i> <?php echo $formatted_date; ?>, <?php echo esc_html(date('g:i A', $event_timestamp)); ?></span>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <span class="event-date"><i class="fas fa-calendar-alt"></i> <?php echo $formatted_date; ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if (get_field('event_location')) : ?>
                                                <?php $loc_text = preg_replace('/\s*(<br\s*\/?>|\r?\n)+\s*/i', ', ', get_field('event_location')); ?>
                                                <span class="event-location"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($loc_text); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($current_view !== 'list') : ?>
                                            <div class="event-excerpt">
                                                <?php 
                                                $excerpt = get_field('event_description') ? wp_strip_all_tags(get_field('event_description')) : get_the_excerpt();
                                                echo wp_trim_words($excerpt, 20, '...');
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="event-actions">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php elseif ($events_query->have_posts()) : ?>
                    <?php while ($events_query->have_posts()) : $events_query->the_post(); ?>
                        <div class="<?php echo esc_attr($column_class); ?>">
                            <div class="event-card <?php echo $current_view === 'list' ? 'event-card-horizontal' : ''; ?>">
                                <?php 
                                $event_image = get_field('event_image');
                                if ($event_image || has_post_thumbnail()) : 
                                ?>
                                    <div class="event-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if ($event_image) : ?>
                                                <img src="<?php echo esc_url($event_image['url']); ?>" alt="<?php echo esc_attr($event_image['alt']); ?>" class="img-fluid">
                                            <?php else : ?>
                                                <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="event-content">
                                    <h3 class="event-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    
                                    <?php 
                                    // Handle event type - use new event_type field only (same as single-event.php)
                                    $event_type = get_field('event_type');
                                    
                                    // Determine event type based on new field
                                    $is_on_demand = ($event_type === 'on_demand');
                                    $is_live = ($event_type === 'live');
                                    $is_in_person = ($event_type === 'in_person');
                                    ?>
                                    <div class="event-meta-row">
                                        <?php if ($is_live || $is_on_demand || $is_in_person) : ?>
                                            <?php if ($is_live) : ?>
                                                <span class="event-badge live-badge"><span class="live-dot"></span>LIVE</span>
                                            <?php elseif ($is_on_demand) : ?>
                                                <span class="event-badge on-demand-badge">ON-DEMAND</span>
                                            <?php elseif ($is_in_person) : ?>
                                                <span class="event-badge in-person-badge">IN PERSON</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <?php if (get_field('event_date')) : ?>
                                            <?php
                                            $event_date = get_field('event_date');
                                            $event_end_date = get_field('event_end_date');
                                            $event_timestamp = strtotime($event_date);
                                            
                                            // Format date range if end date exists
                                            if ($event_end_date) {
                                                $end_timestamp = strtotime($event_end_date);
                                                $start_date = date('F j', $event_timestamp);
                                                $end_date = date('F j Y', $end_timestamp);
                                                
                                                // If same month, show "Dec 2 - 4, 2024"
                                                if (date('F Y', $event_timestamp) === date('F Y', $end_timestamp)) {
                                                    $formatted_date = $start_date . ' - ' . date('j', $end_timestamp) . ', ' . date('Y', $end_timestamp);
                                                } else {
                                                    $formatted_date = $start_date . ' - ' . $end_date;
                                                }
                                            } else {
                                                $formatted_date = date('F j Y', $event_timestamp);
                                            }
                                            
                                            // Show time only if explicitly set in ACF; otherwise treat as all-day
                                            $pacific_time = get_field('event_pacific_time');
                                            $eastern_time = get_field('event_eastern_time');
                                            $all_day = get_field('event_all_day');
                                            $has_event_time = (date('H:i', $event_timestamp) !== '00:00');
                                            $show_time = ($is_live || $is_in_person) && !$is_on_demand && !$all_day && ( !empty($pacific_time) || !empty($eastern_time) || $has_event_time );
                                            if ($show_time && (!empty($pacific_time) || !empty($eastern_time))) {
                                                $pacific_time = !empty($pacific_time) ? ($pacific_time . ' PDT') : '';
                                                $eastern_time = !empty($eastern_time) ? ($eastern_time . ' EDT') : '';
                                            }
                                            ?>
                                            <?php if ($show_time) : ?>
                                                <?php if (!empty($pacific_time) || !empty($eastern_time)) : ?>
                                                    <span class="event-date"><i class="fas fa-calendar-alt"></i> <?php echo $formatted_date; ?>, <?php echo esc_html($pacific_time); ?></span>
                                                <?php else : ?>
                                                    <span class="event-date"><i class="fas fa-calendar-alt"></i> <?php echo $formatted_date; ?>, <?php echo esc_html(date('g:i A', $event_timestamp)); ?></span>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <span class="event-date"><i class="fas fa-calendar-alt"></i> <?php echo $formatted_date; ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <?php if (get_field('event_location')) : ?>
                                            <?php $loc_text = preg_replace('/\s*(<br\s*\/?>|\r?\n)+\s*/i', ', ', get_field('event_location')); ?>
                                            <span class="event-location"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($loc_text); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($current_view !== 'list') : ?>
                                        <div class="event-excerpt">
                                            <?php 
                                            $excerpt = get_field('event_description') ? wp_strip_all_tags(get_field('event_description')) : get_the_excerpt();
                                            echo wp_trim_words($excerpt, 20, '...');
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="event-actions">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="col-12">
                        <div class="no-events-message">
                            <p>No events found. Try adjusting your search or filters.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ($events_query->max_num_pages > 1) : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="pagination-container">
                            <?php
                            $big = 999999999; // need an unlikely integer
                            echo paginate_links(array(
                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format' => '?paged=%#%',
                                'current' => max(1, $paged),
                                'total' => $events_query->max_num_pages,
                                'prev_text' => '<i class="fas fa-chevron-left"></i> Previous',
                                'next_text' => 'Next <i class="fas fa-chevron-right"></i>',
                                'type' => 'list',
                                'end_size' => 1,
                                'mid_size' => 2
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>
        </div>
    </section>

</main><!-- #main -->

<script>
function setTimingFilter(timing) {
    document.getElementById('timing-filter').value = timing;
    document.querySelector('.event-filters-form').submit();
}
</script>

<?php
get_footer();
