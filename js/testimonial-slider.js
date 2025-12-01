jQuery(document).ready(function($) {
    // Simple testimonial slider initialization
    function initTestimonialSlider() {
        // Check if slider exists
        if (!$('.testimonial-slider').length) {
            return;
        }
        
        // Destroy existing slider if initialized
        if ($('.testimonial-slider').hasClass('slick-initialized')) {
            $('.testimonial-slider').slick('unslick');
        }
        
        // Clear all inline styles
        $('.testimonial-slider, .testimonial-slider *').removeAttr('style');
        
        // Basic slider configuration
        var config = {
            dots: false,
            arrows: false,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            adaptiveHeight: true,
            fade: false,
            swipe: true,
            touchMove: true,
            draggable: true,
            mobileFirst: true,
            variableWidth: false,
            centerMode: false
        };
        
        // Initialize slider
        $('.testimonial-slider').slick(config);
        
        // Create pagination dots
        createPagination();
        
        // Add slide change event handler
        $('.testimonial-slider').on('afterChange', function(event, slick, currentSlide) {
            updateActiveDot(currentSlide);
        });
    }
    
    // Create pagination dots
    function createPagination() {
        // Get total slides
        var totalSlides = $('.testimonial-slider').slick('getSlick').slideCount;
        
        // Clear existing pagination
        $('.testimonial-pagination').empty();
        
        // Create pagination dots
        for (var i = 0; i < totalSlides; i++) {
            $('.testimonial-pagination').append(
                '<button class="custom-dot' + (i === 0 ? ' active' : '') + '" data-slide="' + i + '"></button>'
            );
        }
        
        // Make pagination visible
        $('.testimonial-pagination').css({
            'display': 'flex',
            'opacity': '1',
            'visibility': 'visible'
        });
        
        // Handle dot clicks
        $('.testimonial-pagination').off('click', '.custom-dot').on('click', '.custom-dot', function() {
            var slideIndex = $(this).data('slide');
            $('.testimonial-slider').slick('slickGoTo', slideIndex);
        });
    }
    
    // Update active pagination dot
    function updateActiveDot(currentSlide) {
        $('.testimonial-pagination .custom-dot').removeClass('active');
        $('.testimonial-pagination .custom-dot[data-slide="' + currentSlide + '"]').addClass('active');
    }
    
    // Initialize slider with a slight delay
    setTimeout(function() {
        initTestimonialSlider();
    }, 100);
    
    // Handle window resize with debounce
    var resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            initTestimonialSlider();
        }, 250);
    });
});
