jQuery(document).ready(function(e){

    var screenTop = false;
    jQuery('#gform_submit_button_1, #gform_submit_button_2, #gform_submit_button_3, #gform_submit_button_4').on('click', function(e){
        screenTop = jQuery(document).scrollTop();
    })
    
    // Fallback: Force show contact-us forms on page load (in case Gravity Forms JS hasn't run yet)
    function showContactUsForms() {
        jQuery('.contact-us .gform_wrapper').each(function(){
            var $wrapper = jQuery(this);
            if ($wrapper.attr('style') && $wrapper.attr('style').indexOf('display:none') !== -1) {
                $wrapper.css('display', 'block');
            }
        });
    }
    
    // Run immediately and also after a short delay to catch late-loading forms
    showContactUsForms();
    setTimeout(showContactUsForms, 500);
    setTimeout(showContactUsForms, 1500);

jQuery(document).on("gform_post_render", function (e, form_id) {
    // Generic structuring: make any Gravity Form look like Contact Us styles
    function structureContactStyle(fid) {
        var $fields = jQuery('#gform_fields_' + fid);
        if (!$fields.length) return;

        // Normalize required indicators
        $fields.find('label .gfield_required').each(function(){ jQuery(this).text('*'); });
        $fields.find('.gfield_label').each(function(){
            var txt = jQuery(this).text();
            jQuery(this).html(txt.replace(/\s*\(\s*Required\s*\)\s*$/i, '').replace(/\s*Required\s*$/i, ''));
        });

        // Wrap HTML text blocks
        $fields.find('.gfield--type-html').each(function(){
            var $el = jQuery(this);
            if (!$el.parent().hasClass('form-text')) {
                $el.wrap('<div class="form-text" />');
            }
        });

        // Wrap half-width fields
        $fields.find('.gfield--width-half').each(function(){
            var $el = jQuery(this);
            if (!$el.parent().hasClass('input-box')) {
                $el.wrap('<div class="input-box half" />');
            }
        });

        // Wrap full-width fields (excluding HTML)
        $fields.find('.gfield--width-full').not('.gfield--type-html').each(function(){
            var $el = jQuery(this);
            if (!$el.parent().hasClass('input-box')) {
                $el.wrap('<div class="input-box" />');
            }
        });

        // Submit button styling
        var $submit = jQuery('#gform_submit_button_' + fid);
        if ($submit.length) {
            $submit.addClass('btn btn-primary inactive').parent().addClass('form-submit');
        }

        // Toggle submit active state based on required inputs
        var $form = jQuery('#gform_' + fid);
        function refreshSubmitState() {
            var allFilled = true;
            $form.find('[aria-required="true"]').each(function(){
                var $input = jQuery(this);
                var isGroup = $input.is(':checkbox') || $input.is(':radio');
                var val = '';
                if (isGroup) {
                    val = $form.find('input[name="' + $input.attr('name') + '"]:checked').length;
                } else {
                    val = jQuery.trim($input.val());
                }
                if (!val) { allFilled = false; }
            });
            if ($submit.length) {
                if (allFilled) { $submit.removeClass('inactive'); } else { $submit.addClass('inactive'); }
            }
        }
        // Initial state and bindings
        refreshSubmitState();
        $form.on('keyup change', '[aria-required="true"]', refreshSubmitState);
    }
    // Scope modifications to the hero block form (if present)
    var $heroForm = jQuery('.hero-lead-form .gform_wrapper.gravity-theme');
    if ($heroForm.length) {
        // Replace explicit "Required" text with asterisks
        $heroForm.find('.gfield_label .gfield_required').each(function(){
            jQuery(this).text('*');
        });
        // Remove trailing "Required" from labels
        $heroForm.find('.gfield_label').each(function(){
            var label = jQuery(this).text();
            jQuery(this).html(label.replace(/\s*Required$/, ''));
        });
    }

    // Normalize required indicators for any Contact Us block Gravity Forms
    var $contactForms = jQuery('.contact-us .gform_wrapper.gravity-theme');
    if ($contactForms.length) {
        $contactForms.find('.gfield_label .gfield_required').each(function(){
            // Force single asterisk
            jQuery(this).text('*');
        });
        $contactForms.find('.gfield_label').each(function(){
            // Strip any literal "Required" text appended by plugins/themes
            var txt = jQuery(this).text();
            jQuery(this).html(txt.replace(/\s*\(\s*Required\s*\)\s*$/i, '').replace(/\s*Required\s*$/i, ''));
        });
    }

    // Ensure any contact-us forms are visible after render on any page/form id
    jQuery('.contact-us form').addClass('active');
    
    // Force remove inline display:none from Gravity Forms wrapper (fixes live site issue)
    jQuery('.contact-us .gform_wrapper').each(function(){
        var $wrapper = jQuery(this);
        if ($wrapper.attr('style') && $wrapper.attr('style').indexOf('display:none') !== -1) {
            $wrapper.css('display', 'block');
        }

        // Apply generic structuring only for non-legacy IDs to avoid double-wrapping
        if (form_id !== 1 && form_id !== 2 && form_id !== 3 && form_id !== 4) {
            structureContactStyle(form_id);
        }
    });

    // Preserve Contact Us page form behaviors
    if(form_id == 1) {
            jQuery('.contact-us #gform_fields_1 label .gfield_required').each(function(e){
                jQuery(this).html('*')
            });
    
            jQuery('.contact-us #gform_fields_1 .gfield--type-html').each(function(e){
                jQuery(this).wrap('<div class="form-text" />');
            });
    
            jQuery('.contact-us #gform_fields_1 .gfield--width-half').each(function(e){
                jQuery(this).wrap('<div class="input-box half" />');
            });
    
            jQuery('.contact-us #gform_fields_1 .gfield--width-full').not('.gfield--type-html').each(function(e){
                jQuery(this).wrap('<div class="input-box" />');
            });
    
    
            jQuery('#gform_submit_button_1').addClass('btn btn-primary inactive').parent().addClass('form-submit');
    
            jQuery('.contact-us form').addClass('active');
    
            jQuery('.contact-us #gform_1 .gform_footer.before').append(`
            <div class="form-info">
                    <p>* Required</p>
                  </div>
            `);


            jQuery('.contact-us #gform_fields_1 input, .contact-us #gform_fields_1 textarea').on('keyup', function(e){
                
                let active_submit = true;
//                 jQuery('.contact-us #gform_fields_1 input, .contact-us #gform_fields_1 textarea').each(function(e){
//                     let curr_val = jQuery(this).val();
//                     if(curr_val == '') {
//                         active_submit = false
//                     }
//                 })

//                 console.log(active_submit);
                if(active_submit) {
                    jQuery('#gform_submit_button_1').removeClass('inactive');
                } else {
                    jQuery('#gform_submit_button_1').addClass('inactive');
                }
            })
        }
        
        if(form_id == 2) {
            jQuery('.contact-us #gform_fields_2 label .gfield_required').each(function(e){
                jQuery(this).html('*')
            });
    
            jQuery('.contact-us #gform_fields_2 .gfield--type-html').each(function(e){
                jQuery(this).wrap('<div class="form-text" />');
            });
    
            jQuery('.contact-us #gform_fields_2 .gfield--width-half').each(function(e){
                jQuery(this).wrap('<div class="input-box half" />');
            });
    
            jQuery('.contact-us #gform_fields_2 .gfield--width-full').not('.gfield--type-html').each(function(e){
                jQuery(this).wrap('<div class="input-box" />');
            });
    
    
            jQuery('#gform_submit_button_2').addClass('btn btn-primary inactive').parent().addClass('form-submit');
    
            jQuery('.contact-us form').addClass('active');
    
            jQuery('.contact-us #gform_2 .gform_footer.before').append(`
            <div class="form-info">
                    <p>* Required</p>
                  </div>
            `);

            jQuery('.contact-us #gform_fields_2 input, .contact-us #gform_fields_2 textarea').on('keyup', function(e){
                let val = jQuery(this).val();
                
                let active_submit = true;



//                 jQuery('.contact-us #gform_fields_2 input, .contact-us #gform_fields_2 textarea').each(function(e){
//                     let curr_val = jQuery(this).val();
//                     if(curr_val == '') {
//                         active_submit = false
//                     }
//                 })


                if(active_submit) {
                    jQuery('#gform_submit_button_2').removeClass('inactive');
                } else {
                    jQuery('#gform_submit_button_2').addClass('inactive');
                }
            })
        }

        if(form_id == 3) {
            jQuery('.contact-us #gform_fields_3 label .gfield_required').each(function(e){
                jQuery(this).html('*')
            });
    
            jQuery('.contact-us #gform_fields_3 .gfield--type-html').each(function(e){
                jQuery(this).wrap('<div class="form-text" />');
            });
    
            jQuery('.contact-us #gform_fields_3 .gfield--width-half').each(function(e){
                jQuery(this).wrap('<div class="input-box half" />');
            });
    
            jQuery('.contact-us #gform_fields_3 .gfield--width-full').not('.gfield--type-html').each(function(e){
                jQuery(this).wrap('<div class="input-box" />');
            });
    
    
            jQuery('#gform_submit_button_3').addClass('btn btn-primary inactive').parent().addClass('form-submit');
    
            jQuery('.contact-us form').addClass('active');
    
            jQuery('.contact-us #gform_3 .gform_footer.before').append(`
            <div class="form-info">
                    <p>* Required</p>
                  </div>
            `);

            jQuery('.contact-us #gform_fields_3 input, .contact-us #gform_fields_3 textarea').on('keyup', function(e){
                let val = jQuery(this).val();
                
                let active_submit = true;



//                 jQuery('.contact-us #gform_fields_3 input, .contact-us #gform_fields_3 textarea').each(function(e){
//                     let curr_val = jQuery(this).val();
//                     if(curr_val == '') {
//                         active_submit = false
//                     }
//                 })


                if(active_submit) {
                    jQuery('#gform_submit_button_3').removeClass('inactive');
                } else {
                    jQuery('#gform_submit_button_3').addClass('inactive');
                }
            })
        }

        if(form_id == 4) {
            jQuery('.contact-us #gform_fields_4 label .gfield_required').each(function(e){
                jQuery(this).html('*')
            });
    
            jQuery('.contact-us #gform_fields_4 .gfield--type-html').each(function(e){
                jQuery(this).wrap('<div class="form-text" />');
            });
    
            jQuery('.contact-us #gform_fields_4 .gfield--width-half').each(function(e){
                jQuery(this).wrap('<div class="input-box half" />');
            });
    
            jQuery('.contact-us #gform_fields_4 .gfield--width-full').not('.gfield--type-html').each(function(e){
                jQuery(this).wrap('<div class="input-box" />');
            });
    
    
            jQuery('#gform_submit_button_4').addClass('btn btn-primary inactive').parent().addClass('form-submit');
    
            jQuery('.contact-us form').addClass('active');
    
                jQuery('.contact-us #gform_4 .gform_footer.before').append(`
            <div class="form-info">
                    <p>* Required</p>
                  </div>
            `);


            jQuery('.contact-us #gform_fields_4 input, .contact-us #gform_fields_4 textarea').on('keyup', function(e){
                
                let active_submit = true;
//                 jQuery('.contact-us #gform_fields_4 input, .contact-us #gform_fields_4 textarea').each(function(e){
//                     let curr_val = jQuery(this).val();
//                     if(curr_val == '') {
//                         active_submit = false
//                     }
//                 })

                console.log(active_submit);
                if(active_submit) {
                    jQuery('#gform_submit_button_4').removeClass('inactive');
                } else {
                    jQuery('#gform_submit_button_4').addClass('inactive');
                }
            })
        }

        // Private Preview (Form ID 7) – apply Contact Us block wrappers and styling
        if(form_id == 7) {
            jQuery('.contact-us #gform_fields_7 label .gfield_required').each(function(){
                jQuery(this).text('*');
            });

            jQuery('.contact-us #gform_fields_7 .gfield--type-html').each(function(){
                jQuery(this).wrap('<div class="form-text" />');
            });

            jQuery('.contact-us #gform_fields_7 .gfield--width-half').each(function(){
                jQuery(this).wrap('<div class="input-box half" />');
            });

            jQuery('.contact-us #gform_fields_7 .gfield--width-full').not('.gfield--type-html').each(function(){
                jQuery(this).wrap('<div class="input-box" />');
            });

            jQuery('#gform_submit_button_7').addClass('btn btn-primary').parent().addClass('form-submit');
            jQuery('.contact-us form').addClass('active');

            // Add the required note if not present
            if (!jQuery('.contact-us #gform_7 .gform_footer.before .form-info').length) {
                jQuery('.contact-us #gform_7 .gform_footer.before').append(
                    '<div class="form-info"><p>* Required</p></div>'
                );
            }
        }
});

// Client-side guard: prevent empty form submission if GF validation fails to load
jQuery(document).on('submit', '.contact-us .gform_wrapper form', function(e){
    var $form = jQuery(this);
    var invalid = false;

    // Reset previous error states
    $form.find('.gfield_error .validation_message').remove();
    $form.find('.gfield_error').removeClass('gfield_error');

    $form.find('[aria-required="true"]').each(function(){
        var $input = jQuery(this);
        var isGroup = $input.is(':checkbox') || $input.is(':radio');
        var value = '';
        if (isGroup) {
            value = $form.find('input[name="' + $input.attr('name') + '"]:checked').length;
        } else {
            value = jQuery.trim($input.val());
        }
        if (!value) {
            invalid = true;
            var $gfield = $input.closest('.gfield');
            $gfield.addClass('gfield_error');
            if (!$gfield.find('.validation_message').length) {
                jQuery('<div class="validation_message">This field is required.</div>').appendTo($gfield);
            }
        }
    });

    if (invalid) {
        e.preventDefault();
        e.stopImmediatePropagation();
    }
});

    jQuery(document).on("gform_confirmation_loaded", function (e, form_id) {
        if(form_id == 1 || form_id == 2 || form_id == 3 || form_id == 4) {
            if(screenTop !== false) {
                jQuery(document).scrollTop(screenTop);
            }
        }
    });

    if (typeof data_news !== 'undefined') {
        let pageNumber = 1;
        let pagination = [];
        let activeCat = '';
        let postsPerPage = (typeof posts_per_page !== 'undefined') ? posts_per_page : 6;
        let showPagination = (typeof show_pagination !== 'undefined') ? show_pagination : true;

    
        function load_data_posts(scroll = false, animation = true) {
            filtered = [];
            data_news.reduce((result, resource) => {
                if(type_archive == 'blog') {
                    const cat = resource.type_news_post_arr_slug.map(stat => stat);
                    if(hasCat(cat)) {
                        filtered.push(resource);
                    }
                } else {
                    filtered.push(resource);
                }
            }, 0)
            pagination = paginator(filtered, pageNumber, postsPerPage);
    
            let post_item = '';
        
            pagination.data.map((post, index) => {
              let excerpt = post.excerpt;
              let post_title = post.post_title;
              let get_the_date = post.get_the_date;
              let type_news_post = post.type_news_name;
              let small_archive_text = post.small_archive_text;
              let permalink = post.permalink;
              let permalink_target = post.permalink_target;
              let featured_image = post.featured_image;
              let logo = post.logo;
              let type_news_name = post.type_news_name;

              if(!featured_image) {
                featured_image = logo;
              }

              console.log(featured_image)

              post_item += `
                <div class="blog-post">
                    <div class="blog-post-inner">
                        ${
                            featured_image ? `
                            <div class="post-image">
                                <a href="${permalink}" target="${permalink_target}">
                                    <img src="${featured_image.url}" alt="${featured_image.alt || post_title}" class="img-fluid">
                                </a>
                            </div>
                            ` : ''
                        }
                        <div class="post-content">
                            ${
                                type_news_post ? `
                                <div class="category-tag">${type_news_post}</div>
                                ` : ''
                            }
                            <div class="post-date">${get_the_date}</div>
                            <h3 class="post-title">
                                <a href="${permalink}" target="${permalink_target}">${post_title}</a>
                            </h3>
                            ${
                                excerpt ? `
                                <div class="post-excerpt">${excerpt}</div>
                                ` : ''
                            }
                            <div class="read-more">
                                <a href="${permalink}" target="${permalink_target}" class="btn-read-more">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
              `;

            })

            if(filtered.length < 1) {
                post_item = '<p class="no_match">No posts match the filter selection(s) you have chosen.</p>';
            }         
            jQuery('.news-press-archive .content-area .blog-posts-grid').html(post_item);
            if(activeCat) {
                jQuery('body .news-press-archive .filter_area .clear_button').addClass('active');
            } else {
                jQuery('body .news-press-archive .filter_area .clear_button').removeClass('active');
            }

        }

        function paginator(items, current_page, per_page_items) {
            let page = current_page || 1,
            per_page = per_page_items || 10,
            offset = (page - 1) * per_page,
            paginatedItems = items.slice(offset).slice(0, per_page_items),
            total_pages = Math.ceil(items.length / per_page);
    
    
            return {
                page: page,
                per_page: per_page,
                pre_page: page - 1 ? page - 1 : null,
                next_page: (total_pages > page) ? page + 1 : null,
                total: items.length,
                total_pages: total_pages,
                data: paginatedItems
            };
        }

        let pageCount = [];
        function paginationNav() {
            let html = '';
            if(showPagination && pagination.total_pages > 1) {
                html += '<div class="pagination-numbers">';
                
                // Previous button
                if(pageNumber > 1) {
                    html += `<a href="#" class="page-number prev" data-page_number="${pageNumber - 1}">«</a>`;
                } else {
                    html += `<span class="page-number prev disabled">«</span>`;
                }
                
                // Numbered pagination with ellipsis
                const maxPages = 5;
                const halfMaxPages = Math.floor(maxPages / 2);
                
                let startPage = Math.max(1, pageNumber - halfMaxPages);
                let endPage = Math.min(pagination.total_pages, startPage + maxPages - 1);
                
                // Adjust if we're near the end
                if (endPage - startPage + 1 < maxPages) {
                    startPage = Math.max(1, endPage - maxPages + 1);
                }
                
                // Page numbers
                for (let i = startPage; i <= endPage; i++) {
                    if (i === pageNumber) {
                        html += `<span class="page-number current">${i}</span>`;
                    } else {
                        html += `<a href="#" class="page-number" data-page_number="${i}">${i}</a>`;
                    }
                }
                
                // Next button
                if(pageNumber < pagination.total_pages) {
                    html += `<a href="#" class="page-number next" data-page_number="${pageNumber + 1}">»</a>`;
                } else {
                    html += `<span class="page-number next disabled">»</span>`;
                }
                
                html += '</div>';
            }
            jQuery('.news-press-archive .content-area .news-pagination').html(html);
        }

        jQuery(document).on('click', '.news-press-archive .content-area .news-pagination a', function(e){
            e.preventDefault();
            let curr_num = jQuery(this).data('page_number');
            pageNumber = curr_num;
            load_data_posts(true, false);
            paginationNav();
        })

        function hasCat(values) {
            let hasCat = false;
  
            if(activeCat.length === 0) {
              return true;
            }
  
            values.forEach(function(item) {
              if(item.toLowerCase() == activeCat.toLowerCase()) {
                  hasCat = true;
              }
            })
      
            return hasCat;
        }

        function handleCat(newValue) {
            if(newValue == 'all') {
                activeCat = '';
            } else {
                activeCat = newValue;
            }
            pageNumber = 1;
            load_data_posts();

            paginationNav();
        }

        jQuery(document).on('click', '.category-pill', function(e){
            e.preventDefault();
            let val = jQuery(this).data('category');
            jQuery('.category-pill').removeClass('active');
            jQuery(this).addClass('active');
            handleCat(val);
        })

        jQuery('body .news-press-archive .filter_area .clear_button a').on('click', function(e){
            e.preventDefault();
            activeCat = '';
            jQuery('.category-pill').removeClass('active');
            jQuery('.category-pill[data-category=""]').addClass('active');
            load_data_posts();
            paginationNav();
        })    

        load_data_posts();

        paginationNav();
    }

    if (typeof reduce_padding_homebanner !== 'undefined') {
        jQuery('.home-banner').addClass('reduce_padding');
    }

    jQuery(".home-banner .content-area h4 span").Morphext({
        // The [in] animation type. Refer to Animate.css for a list of available animations.
        animation: "fadeInUp",
        // An array of phrases to rotate are created based on this separator. Change it if you wish to separate the phrases differently (e.g. So Simple | Very Doge | Much Wow | Such Cool).
        separator: ",",
        // The delay between the changing of each phrase in milliseconds.
        speed: 5000,
        complete: function () {
            // Called after the entrance animation is executed.
        }
    });

    jQuery(".open_fancybox").fancybox({
        // afterShow: function() {
        //     var obj=this.$content.find('video');
        //         if (mp4Video) setTimeout(function() { obj.trigger('pause'); }, 100);
        //     if (slideType === 'video') {  // see also #1983
        //         obj.on('ended', function() {
        //             if (slideshowWasOn) FancyBoxInstance.SlideShow.toggle();
        //             FancyBoxInstance.next(100);
        //         });
        //     }
        // }
    });

});
