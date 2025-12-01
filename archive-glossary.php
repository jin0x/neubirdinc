<?php
/**
 * The template for displaying Glossary archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package neubird
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="glossary-archive">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="glossary-header">
                        <h1 class="page-title">Glossary</h1>
                        <p class="glossary-description">Find definitions and explanations of key terms and concepts.</p>
                    </div>

                    <!-- Minimal Filter Section -->
                    <div class="glossary-filter-container">
                        <div class="filter-row">
                            <!-- Alphabet Groups (Left) -->
                            <div class="alphabet-section">
                                <div class="alphabet-filters">
                                    <button class="alphabet-filter active" data-letter="">All</button>
                                    <?php 
                                    // Get all first letters from existing glossary posts
                                    $existing_letters = array();
                                    $all_terms = get_posts(array(
                                        'post_type' => 'glossary',
                                        'posts_per_page' => -1,
                                        'orderby' => 'title',
                                        'order' => 'ASC',
                                        'post_status' => 'publish'
                                    ));
                                    
                                    foreach ($all_terms as $term) {
                                        $first_letter = strtoupper(substr($term->post_title, 0, 1));
                                        if (preg_match('/[A-Z]/', $first_letter)) {
                                            $existing_letters[] = $first_letter;
                                        }
                                    }
                                    $existing_letters = array_unique($existing_letters);
                                    sort($existing_letters);
                                    
                                    // Define alphabet ranges
                                    $alphabet_ranges = array(
                                        'A-G' => array('A', 'B', 'C', 'D', 'E', 'F', 'G'),
                                        'H-N' => array('H', 'I', 'J', 'K', 'L', 'M', 'N'),
                                        'O-U' => array('O', 'P', 'Q', 'R', 'S', 'T', 'U'),
                                        'V-Z' => array('V', 'W', 'X', 'Y', 'Z')
                                    );
                                    
                                    // Show all ranges by default, but mark which ones have posts
                                    foreach ($alphabet_ranges as $range_label => $letters) {
                                        $has_posts = false;
                                        $range_letters = array();
                                        
                                        foreach ($letters as $letter) {
                                            if (in_array($letter, $existing_letters)) {
                                                $has_posts = true;
                                                $range_letters[] = $letter;
                                            }
                                        }
                                        
                                        $range_class = $has_posts ? 'has-posts' : 'no-posts';
                                        $range_data = implode(',', $letters);
                                        
                                        echo '<button class="alphabet-filter range-filter ' . $range_class . '" ' .
                                             'data-range="' . esc_attr($range_data) . '" ' .
                                             'data-range-label="' . esc_attr($range_label) . '" ' .
                                             'data-has-posts="' . ($has_posts ? 'true' : 'false') . '">' .
                                             esc_html($range_label) . 
                                             '<svg class="letter-group-expand-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></button>';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <!-- Search & Reset (Right) -->
                            <div class="search-reset-section">
                                <div class="search-input-container">
                                    <input type="text" id="glossary-search" placeholder="Search terms...">
                                    <button id="glossary-search-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                    </button>
                                </div>
                                <button class="reset-icon" title="Reset Filters">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Individual Letters Section (Hidden by default) -->
                        <div class="individual-letters-section" style="display:none;"></div>
                    </div>

                    <!-- Glossary Terms Section -->
                    <div class="results-info">
                        <div class="results-count"></div>
                    </div>
                    
                    <!-- Loading State -->
                    <div id="glossary-loading" class="glossary-loading" style="text-align: center; padding: 40px;">
                        <div style="color: #666; font-size: 16px;">
                            <svg style="animation: spin 1s linear infinite; margin-right: 8px;" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2v4m0 12v4M2 12h4m12 0h4"></path>
                            </svg>
                            Loading glossary terms...
                        </div>
                    </div>
                    
                    <div id="glossary-terms-container" class="glossary-terms-container" style="display: none;"></div>

                    <!-- Pagination -->
                    <div class="glossary-pagination">
                        <div class="pagination-container" id="glossary-pagination">
                            <!-- Pagination will be loaded here via JavaScript -->
                        </div>
                    </div>

                    <!-- No Results Message -->
                    <div class="no-results-message" id="no-results" style="display: none;">
                        <div class="no-results-content">
                            <h3>No terms found</h3>
                            <p>Try adjusting your search or browse by a different letter.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<script type="text/javascript">
jQuery(document).ready(function($) {
    // Get all glossary terms via AJAX or generate them here
    var glossaryTerms = [];
    var filteredTerms = [];
    var currentPage = 1;
    var termsPerPage = 12;
    var currentLetter = '';
    var currentLetterType = 'single';
    var currentSearch = '';

    // Load all glossary terms
    loadGlossaryTerms();

    // Debug: Log when page loads
    console.log('Glossary page loaded. Total alphabet filters:', $('.alphabet-filter').length);
    console.log('Range filters:', $('.range-filter').length);
    console.log('Letter groups:', $('.letter-group').length);

    function loadGlossaryTerms() {
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'load_glossary_terms'
            },
            success: function(response) {
                if (response.success) {
                    glossaryTerms = response.data;
                    filteredTerms = glossaryTerms;
                    updateDisplay();
                } else {
                    // Fallback: load terms from current page
                    loadTermsFromPage();
                }
            },
            error: function() {
                loadTermsFromPage();
            }
        });
    }

    function loadTermsFromPage() {
        // Hide loading state
        $('#glossary-loading').hide();
        
        // Fallback method using PHP data
        <?php
        $all_terms = get_posts(array(
            'post_type' => 'glossary',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ));

        $terms_data = array();
        foreach ($all_terms as $term) {
            $short_desc = get_field('short_description', $term->ID);
            $terms_data[] = array(
                'id' => $term->ID,
                'title' => $term->post_title,
                'permalink' => get_permalink($term->ID),
                'short_description' => $short_desc ? $short_desc : wp_trim_words($term->post_excerpt, 20),
                'letter' => strtoupper(substr($term->post_title, 0, 1))
            );
        }
        echo 'glossaryTerms = ' . json_encode($terms_data) . ';';
        ?>
        filteredTerms = glossaryTerms;
        updateDisplay();
    }

    // Search functionality
    $('#glossary-search').on('input', function() {
        currentSearch = $(this).val().toLowerCase();
        currentPage = 1;
        filterTerms();
    });

    $('#glossary-search-button').on('click', function() {
        currentSearch = $('#glossary-search').val().toLowerCase();
        currentPage = 1;
        filterTerms();
    });

    // Alphabet filter functionality
    $(document).on('click', '.alphabet-filter', function() {
        console.log('Filter clicked:', $(this).text(), 'Has posts:', $(this).data('has-posts'));
        
        if ($(this).hasClass('range-filter')) {
            // Handle range filter - toggle expansion
            var rangeLabel = $(this).data('range-label');
            var $individualSection = $('.individual-letters-section');
            var isCurrentlyExpanded = $(this).hasClass('expanded');
            
            console.log('Range label:', rangeLabel, 'Currently expanded:', isCurrentlyExpanded);
            
            if (isCurrentlyExpanded) {
                // Collapse
                $(this).removeClass('expanded');
                $individualSection.hide();
            } else {
                // Collapse all other range filters first
                $('.range-filter').removeClass('expanded');
                
                // Show individual letters section
                $individualSection.show();
                
                // Create letter group structure for this range
                var rangeLetters = $(this).data('range').split(',');
                var hasPostsLetters = [];
                
                // Find which letters in this range have posts
                rangeLetters.forEach(function(letter) {
                    var hasPostsForLetter = false;
                    glossaryTerms.forEach(function(term) {
                        if (term.letter === letter) {
                            hasPostsForLetter = true;
                        }
                    });
                    if (hasPostsForLetter) {
                        hasPostsLetters.push(letter);
                    }
                });
                
                // Build the letter group HTML
                var letterGroupHTML = '<div class="letter-group" data-range="' + rangeLabel + '">';
                letterGroupHTML += '<div class="letter-group-header expanded" data-range="' + rangeLabel + '">';
                letterGroupHTML += '<span>' + rangeLabel + '</span>';
                letterGroupHTML += '<svg class="letter-group-expand-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';
                letterGroupHTML += '</div>';
                letterGroupHTML += '<div class="letter-group-content expanded">';
                
                hasPostsLetters.forEach(function(letter) {
                    letterGroupHTML += '<button class="alphabet-filter individual-letter" data-letter="' + letter + '">' + letter + '</button>';
                });
                
                letterGroupHTML += '</div>';
                letterGroupHTML += '</div>';
                
                // Update the individual letters section
                $individualSection.html(letterGroupHTML);
                
                // Mark this range as expanded
                $(this).addClass('expanded');
            }
            
            // Only apply filter if range has posts
            var hasPosts = $(this).data('has-posts') === 'true';
            if (hasPosts) {
                // Apply range filter
                $('.alphabet-filter').removeClass('active');
                $(this).addClass('active');
                var rangeLetters = $(this).data('range');
                currentLetter = rangeLetters;
                currentLetterType = 'range';
                currentPage = 1;
                filterTerms();
            }
        } else {
            // Handle individual letter filter
            $('.alphabet-filter').removeClass('active');
            $(this).addClass('active');
            currentLetter = $(this).data('letter');
            currentLetterType = 'single';
            currentPage = 1;
            filterTerms();
        }
    });

    // Handle letter group header clicks (for expanding individual letters)
    $(document).on('click', '.letter-group-header', function() {
        var $header = $(this);
        var $content = $header.next('.letter-group-content');
        var isExpanded = $header.hasClass('expanded');
        
        if (isExpanded) {
            // Collapse
            $header.removeClass('expanded');
            $content.removeClass('expanded');
        } else {
            // Expand
            $header.addClass('expanded');
            $content.addClass('expanded');
        }
    });

    // Reset filters
    $('.reset-icon').on('click', function() {
        currentSearch = '';
        currentLetter = '';
        currentLetterType = 'single';
        currentPage = 1;
        $('#glossary-search').val('');
        $('.alphabet-filter').removeClass('active');
        $('.alphabet-filter[data-letter=""]').addClass('active');
        $('.range-filter').removeClass('expanded');
        $('.individual-letters-section').hide();
        filterTerms();
    });

    function filterTerms() {
        filteredTerms = glossaryTerms.filter(function(term) {
            var matchesSearch = true;
            var matchesLetter = true;

            if (currentSearch) {
                matchesSearch = term.title.toLowerCase().includes(currentSearch) || 
                               (term.short_description && term.short_description.toLowerCase().includes(currentSearch));
            }

            if (currentLetter) {
                if (currentLetterType === 'range') {
                    // Handle range filtering
                    var rangeLetters = currentLetter.split(',');
                    matchesLetter = rangeLetters.includes(term.letter);
                } else {
                    // Handle single letter filtering
                    matchesLetter = term.letter === currentLetter;
                }
            }

            return matchesSearch && matchesLetter;
        });

        updateDisplay();
    }

    function updateDisplay() {
        displayTerms();
        updatePagination();
        updateResultsCount();
    }

    function displayTerms() {
        var container = $('#glossary-terms-container');
        var noResults = $('#no-results');
        var loading = $('#glossary-loading');
        
        // Hide loading
        loading.hide();
        
        container.empty();

        if (filteredTerms.length === 0) {
            container.hide();
            noResults.show();
            return;
        }

        noResults.hide();
        container.show();

        var startIndex = (currentPage - 1) * termsPerPage;
        var endIndex = Math.min(startIndex + termsPerPage, filteredTerms.length);

        for (var i = startIndex; i < endIndex; i++) {
            var term = filteredTerms[i];
            var termHTML = `
                <div class="glossary-term-item">
                    <h3 class="term-title">
                        <a href="${term.permalink}">${term.title}</a>
                    </h3>
                    <div class="term-letter">${term.letter}</div>
                    ${term.short_description ? 
                        `<p class="term-description">${term.short_description}</p>` : ''}
                    <a href="${term.permalink}" class="read-more-link">Read</a>
                </div>
            `;
            container.append(termHTML);
        }
    }

    function updatePagination() {
        var totalPages = Math.ceil(filteredTerms.length / termsPerPage);
        var pagination = $('#glossary-pagination');
        
        pagination.empty();

        if (totalPages <= 1) return;

        var paginationHTML = '<div class="page-numbers">';
        
        // Previous button
        if (currentPage > 1) {
            paginationHTML += `<button class="page-btn prev-page" data-page="${currentPage - 1}">← Previous</button>`;
        }

        // Page numbers
        for (var i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                paginationHTML += `<span class="current-page">${i}</span>`;
            } else {
                paginationHTML += `<button class="page-btn" data-page="${i}">${i}</button>`;
            }
        }

        // Next button
        if (currentPage < totalPages) {
            paginationHTML += `<button class="page-btn next-page" data-page="${currentPage + 1}">Next →</button>`;
        }

        paginationHTML += '</div>';
        pagination.html(paginationHTML);

        // Bind pagination events
        $('.page-btn').on('click', function() {
            currentPage = parseInt($(this).data('page'));
            updateDisplay();
            $('html, body').animate({
                scrollTop: $('.glossary-terms-container').offset().top - 100
            }, 300);
        });
    }

    function updateResultsCount() {
        var count = filteredTerms.length;
        var resultsText = count === 1 ? '1 term found' : count + ' terms found';
        
        if (currentSearch || currentLetter) {
            $('.results-count').text(resultsText).show();
        } else {
            $('.results-count').text('').hide();
        }
    }
});
</script>

<?php
get_footer();
?> 