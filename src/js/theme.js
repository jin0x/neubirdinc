jQuery(document).ready(function () {
  var OSName = "unknown";
  if (navigator.appVersion.indexOf("Win") != -1) OSName = "windows";
  if (navigator.appVersion.indexOf("Mac") != -1) OSName = "mac";
  if (navigator.appVersion.indexOf("X11") != -1) OSName = "unix";
  if (navigator.appVersion.indexOf("Linux") != -1) OSName = "Linux";
  jQuery("body").addClass(OSName);

  jQuery("header .navbar-toggler").click(function () {
    if (jQuery(this).is(".collapsed")) {
      const scrollY = document.body.style.top;
      document.body.style.position = "";
      document.body.style.top = "";
      window.scrollTo(0, parseInt(scrollY || "0") * -1);
      jQuery("header").toggleClass("active");
      jQuery(".megamenu").removeClass("active");
    } else {
      var scroll = jQuery(window).scrollTop();
      document.body.style.position = "fixed";
      document.body.style.top = "-" + scroll + "px";
      jQuery("header").toggleClass("active");
      jQuery(".megamenu").removeClass("active");
    }
  });
});

function smoothscroll() {
  jQuery(".smoothscroll").on("click", function (e) {
    e.preventDefault();
    jQuerytarget = jQuery(this.hash);
    jQueryspace = 0;
    jQuery("html, body")
      .stop()
      .animate(
        {
          scrollTop: jQuerytarget.offset().top - jQueryspace,
        },
        500
      );
  });
}

var lastScrollTop = 0;
jQuery(window).scroll(function () {
  var scroll = jQuery(window).scrollTop();

  if (scroll > lastScrollTop) {
    if (scroll <= 113) {
      jQuery("header").removeClass("scrolled");
    }
    if (scroll >= 114) {
      jQuery("header").addClass("scrolled");
      jQuery("header").removeClass("start");
      jQuery(".megamenu").addClass("inactive");
    }
  } else {
    jQuery("header").removeClass("scrolled");
    jQuery(".megamenu").removeClass("inactive");
    if (scroll <= 276) {
      jQuery("header").addClass("start");
    }
  }
  lastScrollTop = scroll;
});

jQuery(window).on("load", function () {
  AOS.init({
    duration: 1400,
    once: true,
    anchorPlacement: "top-bottom",
  });

  smoothscroll();

  var scroll = jQuery(window).scrollTop();

  if (scroll <= 1) {
    jQuery("header").removeClass("scrolled");
  }

  if (scroll >= 10) {
    jQuery("header").addClass("scrolled");
  }

  jQuery(".testimonials .content-area .testimonial-toggle a").click(
    function () {
      var order = jQuery(this).index();

      jQuery(".testimonials .content-area .testimonial-toggle a").removeClass(
        "active"
      );
      jQuery(this).addClass("active");
      jQuery(
        ".testimonials .content-area .testimonial-container .testimonial-box"
      ).removeClass("active");
      jQuery(
        ".testimonials .content-area .testimonial-container .testimonial-box:eq(" +
          order +
          ")"
      ).addClass("active");
    }
  );

  jQuery(
    ".contact-us .content-area .form-area .tab-content .tab-pane .form-container form .input-box .required"
  ).on("keydown", function () {
    var required = jQuery(this)
      .parent()
      .siblings(".input-box")
      .children("input,textarea")
      .filter("[required]:visible");
    var allRequired = true;
    required.each(function () {
      if (jQuery(this).val() == "") {
        allRequired = false;
      }
    });

    if (!allRequired) {
      jQuery(this)
        .parent()
        .siblings(".form-submit")
        .children(".btn")
        .addClass("inactive");
    } else {
      jQuery(this)
        .parent()
        .siblings(".form-submit")
        .children(".btn")
        .removeClass("inactive");
    }
  });

  if (document.querySelector(".home-slider")) {
    jQuery(".home-slider").slick({
      infinite: true,
      dots: false,
      nav: false,
      arrows: true,
      speed: 300,
      slidesToShow: 1,
      autoplay: true,
      pauseOnHover: false,
      autoplaySpeed: 5000,
      useTransform: false,
    });
    function triggerScroll(targetObj) {
      let targetName = targetObj.attr("class"); //for console.log
      let targetFlag = false;
      let scrollTop = jQuery(window).scrollTop();
      let scrollBottom = scrollTop + jQuery(window).height();
      let targetTop = targetObj.offset().top;
      let targetBottom = targetTop + targetObj.height(); // while loading
      if (scrollBottom > targetTop && scrollTop < targetBottom) {
        if (!targetFlag) {
          console.log(targetName + " is in sight"); //for console.log
          targetObj.slick("slickPlay");
          targetFlag = true;
        }
      } else {
        console.log(targetName + " is not in sight"); //for console.log
        targetObj.slick("slickPause");
        targetFlag = false;
      }

      jQuery(window).on("scroll", function () {
        scrollTop = jQuery(window).scrollTop();
        scrollBottom = scrollTop + jQuery(window).height();
        targetTop = targetObj.offset().top + 200;
        targetBottom = targetTop + targetObj.height();
        if (scrollBottom > targetTop && scrollTop < targetBottom) {
          // Start autoplay when entering the viewport
          if (!targetFlag) {
            console.log(targetName + " is in sight"); //確認用
            targetObj.slick("slickPlay");
            targetFlag = true;
          }
        } else {
          // Stop autoplay when you get out of the viewport
          if (targetFlag) {
            console.log(targetName + " is not in sight"); //for console.log
            targetObj.slick("slickPause");
            targetFlag = false;
          }
        }
      });
    }
    // Execute function
    triggerScroll(jQuery(".home-slider"));
  }

  function adjustImageWidth(image) {
    var widthBase = 130;
    var scaleFactor = 0.525;
    var imageRatio = image.naturalWidth / image.naturalHeight;
    image.width = Math.pow(imageRatio, scaleFactor) * widthBase;
  }

  var images = document.querySelectorAll(
    ".companies .content-area .companies-boxes .companies-box .logo-area img"
  );

  images.forEach(adjustImageWidth);

  jQuery(
    "header .content-area .navbar .container-fluid .navbar-collapse .navbar-nav .nav-item.has-megamenu .nav-link"
  ).on("click", function (e) {
    e.preventDefault();
    jQuery(this).toggleClass("active");
    jQuery(this).siblings(".megamenu").toggleClass("active");
  });

  // ===========================
  // ===========================
  // ===========================
  // ===========================
  // ===========================
  // ===========================
  // ===========================
  // ===========================
  // ===========================
  // ===========================
  // ===========================
  // ===========================

  if (document.querySelector(".news-insights .news-slider")) {
    jQuery(".news-insights .news-slider").slick({
      infinite: true,
      dots: false,
      nav: false,
      arrows: true,
      speed: 300,
      slidesToShow: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      useTransform: false,
    });
    function triggerScroll(targetObj) {
      let targetName = targetObj.attr("class"); //for console.log
      let targetFlag = false;
      let scrollTop = jQuery(window).scrollTop();
      let scrollBottom = scrollTop + jQuery(window).height();
      let targetTop = targetObj.offset().top;
      let targetBottom = targetTop + targetObj.height(); // while loading
      if (scrollBottom > targetTop && scrollTop < targetBottom) {
        if (!targetFlag) {
          console.log(targetName + " is in sight"); //for console.log
          targetObj.slick("slickPlay");
          targetFlag = true;
        }
      } else {
        console.log(targetName + " is not in sight"); //for console.log
        targetObj.slick("slickPause");
        targetFlag = false;
      }

      jQuery(window).on("scroll", function () {
        scrollTop = jQuery(window).scrollTop();
        scrollBottom = scrollTop + jQuery(window).height();
        targetTop = targetObj.offset().top;
        targetBottom = targetTop + targetObj.height();
        if (scrollBottom > targetTop && scrollTop < targetBottom) {
          // Start autoplay when entering the viewport
          if (!targetFlag) {
            console.log(targetName + " is in sight"); //確認用
            targetObj.slick("slickPlay");
            targetFlag = true;
          }
        } else {
          // Stop autoplay when you get out of the viewport
          if (targetFlag) {
            console.log(targetName + " is not in sight"); //for console.log
            targetObj.slick("slickPause");
            targetFlag = false;
          }
        }
      });
    }
    // Execute function
    triggerScroll(jQuery(".news-insights .news-slider"));
  }

  jQuery(".firm-history-slider").slick({
    infinite: false,
    dots: false,
    nav: false,
    arrows: true,
    speed: 300,
    slidesToShow: 4,
    autoplay: false,
    // autoplaySpeed: 5000,
    useTransform: false,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 1300,
        settings: {
          slidesToShow: 3,
          variableWidth: false,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          variableWidth: false,
        },
      },
    ],
  });

  const modals = document.querySelectorAll(".modal");
  modals.forEach((modal) => {
    let currentModal = bootstrap.Modal.getInstance(modal);
    if (currentModal) currentModal.hide();
  });

  // jQuery(
  //   ".contact-us-form-section .content-area .contact-us-container .contact-select .filter-box .select-items div"
  // ).on("click", function () {
  //   var order = jQuery(this).index();
  //   console.log("asdf");
  //   jQuery(
  //     ".contact-us-form-section .content-area .contact-us-container .tab-content .tab-pane"
  //   ).removeClass("show active");

  //   jQuery(
  //     ".contact-us-form-section .content-area .contact-us-container .tab-content .tab-pane:eq(" +
  //       order +
  //       ")"
  //   ).addClass("show active");
  // });

  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================
  // ===============================================

  if (document.querySelector(".testimonial-slider-area")) {
    jQuery(".testimonial-slider-area").slick({
      infinite: true,
      dots: false,
      nav: false,
      arrows: true,
      speed: 300,
      slidesToShow: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      useTransform: false,
    });
    function triggerScroll(targetObj) {
      let targetName = targetObj.attr("class"); //for console.log
      let targetFlag = false;
      let scrollTop = jQuery(window).scrollTop();
      let scrollBottom = scrollTop + jQuery(window).height();
      let targetTop = targetObj.offset().top;
      let targetBottom = targetTop + targetObj.height(); // while loading
      if (scrollBottom > targetTop && scrollTop < targetBottom) {
        if (!targetFlag) {
          console.log(targetName + " is in sight"); //for console.log
          targetObj.slick("slickPlay");
          targetFlag = true;
        }
      } else {
        console.log(targetName + " is not in sight"); //for console.log
        targetObj.slick("slickPause");
        targetFlag = false;
      }

      jQuery(window).on("scroll", function () {
        scrollTop = jQuery(window).scrollTop();
        scrollBottom = scrollTop + jQuery(window).height();
        targetTop = targetObj.offset().top;
        targetBottom = targetTop + targetObj.height();
        if (scrollBottom > targetTop && scrollTop < targetBottom) {
          // Start autoplay when entering the viewport
          if (!targetFlag) {
            console.log(targetName + " is in sight"); //確認用
            targetObj.slick("slickPlay");
            targetFlag = true;
          }
        } else {
          // Stop autoplay when you get out of the viewport
          if (targetFlag) {
            console.log(targetName + " is not in sight"); //for console.log
            targetObj.slick("slickPause");
            targetFlag = false;
          }
        }
      });
    }
    // Execute function
    triggerScroll(jQuery(".testimonial-slider-area"));
  }

  // if (document.querySelector(".video_bg_sliders")) {
  //   jQuery(".video_bg_sliders").slick({
  //     infinite: true,
  //     dots: true,
  //     nav: false,
  //     arrows: false,
  //     slidesToShow: 1,
  //     autoplay: false,
  //   });

  //   jQuery(".video_bg_sliders").on(
  //     "afterChange",
  //     function (event, slick, currentSlide, nextSlide) {
  //       jQuery(
  //         `.home_banner .content_area .text_area .slider_tab .tab_title[data-index=${currentSlide}]`
  //       ).trigger("click");
  //       console.log(currentSlide);
  //     }
  //   );
  //   function triggerScroll(targetObj) {
  //     let targetName = targetObj.attr("class"); //for console.log
  //     let targetFlag = false;
  //     let scrollTop = jQuery(window).scrollTop();
  //     let scrollBottom = scrollTop + jQuery(window).height();
  //     let targetTop = targetObj.offset().top;
  //     let targetBottom = targetTop + targetObj.height(); // while loading
  //     if (scrollBottom > targetTop && scrollTop < targetBottom) {
  //       if (!targetFlag) {
  //         console.log(targetName + " is in sight"); //for console.log
  //         targetObj.slick("slickPlay");
  //         targetFlag = true;
  //       }
  //     } else {
  //       console.log(targetName + " is not in sight"); //for console.log
  //       targetObj.slick("slickPause");
  //       targetFlag = false;
  //     }

  //     jQuery(window).on("scroll", function () {
  //       scrollTop = jQuery(window).scrollTop();
  //       scrollBottom = scrollTop + jQuery(window).height();
  //       targetTop = targetObj.offset().top;
  //       targetBottom = targetTop + targetObj.height();
  //       if (scrollBottom > targetTop && scrollTop < targetBottom) {
  //         // Start autoplay when entering the viewport
  //         if (!targetFlag) {
  //           console.log(targetName + " is in sight"); //確認用
  //           targetObj.slick("slickPlay");
  //           targetFlag = true;
  //         }
  //       } else {
  //         // Stop autoplay when you get out of the viewport
  //         if (targetFlag) {
  //           console.log(targetName + " is not in sight"); //for console.log
  //           targetObj.slick("slickPause");
  //           targetFlag = false;
  //         }
  //       }
  //     });
  //   }
  //   // Execute function
  //   // triggerScroll(jQuery(".video_bg_sliders"));
  // }

  jQuery(function () {
    let url = window.location.pathname.split("/").pop();

    // Add active nav class based on url
    jQuery(
      "header .content-area .navbar .navbar-collapse .navbar-nav .nav-item .nav-link"
    ).each(function () {
      if (
        jQuery(this).attr("href") == url ||
        jQuery(this).attr("href") == "" ||
        jQuery(this)
          .siblings(".dropdown-menu")
          .children("li")
          .children(".dropdown-item")
          .attr("href") == url
      ) {
        jQuery(this)
          .closest(".content-area .navbar-nav .nav-item .nav-link")
          .addClass("active");
      }
    });

    jQuery("footer .footer-box .footer-column ul li a").each(function () {
      if (
        jQuery(this).attr("href") == url ||
        jQuery(this).attr("href") == "  "
      ) {
        jQuery(this).addClass("active");
      }
    });
  });

  jQuery("#numberOnly").on("input blur paste", function () {
    jQuery(this).val(jQuery(this).val().replace(/\D/g, ""));
  });

  // if (window.outerWidth < 1200) {
  //   jQuery("header .navbar-toggler").click(function () {
  //     if (jQuery("body").hasClass("scroll-lock")) {
  //       jQuery("body").removeClass("scroll-lock");
  //     } else {
  //       jQuery("body").addClass("scroll-lock");
  //     }
  //   });
  // }

  jQuery(".side-navbar .navbar-toggle").click(function () {
    // jQuery("body").addClass("scroll-lock");
    jQuery(".mega-menu").addClass("active");
  });
  jQuery(".mobile-navbar .mobile-navbar-toggle").click(function () {
    // jQuery("body").addClass("scroll-lock");
    jQuery(".mega-menu").addClass("active");
  });
  jQuery(".close-megamenu").click(function () {
    // jQuery("body").removeClass("scroll-lock");
    jQuery(".mega-menu").removeClass("active");
  });

  var x, i, j, l, ll, selElmnt, a, b, c;
  /* Look for any elements with the class "custom-select": */
  x = document.getElementsByClassName("custom-select");
  l = x.length;
  for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    ll = selElmnt.length;
    /* For each element, create a new DIV that will act as the selected item: */
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /* For each element, create a new DIV that will contain the option list: */
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < ll; j++) {
      /* For each option in the original select element,
      create a new DIV that will act as an option item: */
      c = document.createElement("DIV");
      c.innerHTML = selElmnt.options[j].innerHTML;
      c.addEventListener("click", function (e) {
        /* When an item is clicked, update the original select box,
        and the selected item: */
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
        jQuery(".filter-reset-button").removeClass("invisible");
        jQuery(".reset-filter-box").removeClass("invisible");
      });
      b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function (e) {
      /* When the select box is clicked, close any other select boxes,
      and open/close the current select box: */
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
  }

  function closeAllSelect(elmnt) {
    /* A function that will close all select boxes in the document,
    except the current select box: */
    var x,
      y,
      i,
      xl,
      yl,
      arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
      if (elmnt == y[i]) {
        arrNo.push(i);
      } else {
        y[i].classList.remove("select-arrow-active");
      }
    }
    for (i = 0; i < xl; i++) {
      if (arrNo.indexOf(i)) {
        x[i].classList.add("select-hide");
      }
    }
  }

  /* If the user clicks anywhere outside the select box,
  then close all select boxes: */
  document.addEventListener("click", closeAllSelect);

  jQuery(".filter-reset-button").click(function () {
    jQuery(this).addClass("invisible");
    jQuery(".select-selected").each(function () {
      var text = jQuery(this)
        .siblings(".form-select")
        .children("option:first-child()")
        .text();
      console.log(text);
      jQuery(this).text(text);
    });
    jQuery(".select-items div").removeClass();
  });

  jQuery(".mobile-filter .filter-toggle").click(function () {
    // if (jQuery("body").hasClass("scroll-lock")) {
    //   jQuery("body").removeClass("scroll-lock");
    //   jQuery("header").removeClass("invisible");
    // } else {
    //   setTimeout(() => {
    //     jQuery("body").addClass("scroll-lock");
    //   }, "400");
    //   jQuery("header").addClass("invisible");
    // }
    if (jQuery("header").hasClass("invisible")) {
      jQuery("header").removeClass("invisible");
    } else {
      jQuery("header").addClass("invisible");
    }
    jQuery(this).parent().siblings(".filter-box-container").addClass("active");
  });
  jQuery(".filter-box-apply").click(function () {
    jQuery(this).parent().removeClass("active");
    jQuery("body").removeClass("scroll-lock");
    jQuery("header").removeClass("invisible");
    // jQuery("html, body").animate(
    //   {
    //     scrollTop: jQuery(".mobile-filter").offset().top - 0,
    //   },
    //   50
    // );
  });
  jQuery(".close-filter-box").click(function () {
    jQuery(this).parent().removeClass("active");
    jQuery("body").removeClass("scroll-lock");
    jQuery("header").removeClass("invisible");
    // jQuery("html, body").animate(
    //   {
    //     scrollTop: jQuery(".mobile-filter").offset().top - 0,
    //   },
    //   50
    // );
  });

  // jQuery(".how-we-help-box").click(function () {
  //   jQuery(this).toggleClass("active");
  // });

  jQuery(function () {
    jQuery(
      ".perspectives-insights-archive .content-area .archives-boxes .archive-box"
    )
      .slice(0, 12)
      .show();
    jQuery(
      ".perspectives-insights-archive .content-area .archive-load-more .btn"
    ).on("click", function (e) {
      e.preventDefault();
      jQuery(
        ".perspectives-insights-archive .content-area .archives-boxes .archive-box:hidden"
      )
        .slice(0, 12)
        .slideDown();
      if (
        jQuery(
          ".perspectives-insights-archive .content-area .archives-boxes .archive-box:hidden"
        ).length == 0
      ) {
        jQuery(
          ".perspectives-insights-archive .content-area .archive-load-more .btn"
        ).fadeOut("slow");
      }
    });
  });

  jQuery(".filter-box .filter-selector").on("click", function (e) {
    jQuery(this)
      .parent()
      .siblings()
      .children(".filter-selector")
      .addClass("collapsed");
    jQuery(this)
      .parent()
      .siblings()
      .children(".filter-check")
      .addClass("collapsed");
    jQuery(this)
      .parent()
      .siblings()
      .children(".filter-check")
      .removeClass("show");
  });

  var rellax = new Rellax(".rellax", {
    horizontal: true,
  });

  jQuery("#comp-upload-pitch").on("change", function () {
    jQuery(this).addClass("uploaded");
  });

  (function () {
    "use strict";

    var section = document.querySelectorAll(".fullwidth-section");
    var sections = {};
    var i = 0;
    var sectionHeight = jQuery(section).height() + 118 - 118;

    Array.prototype.forEach.call(section, function (e) {
      sections[e.id] = e.offsetTop + sectionHeight;
    });

    window.onscroll = function () {
      var scrollPosition =
        document.documentElement.scrollTop || document.body.scrollTop;
      for (i in sections) {
        if (sections[i] <= scrollPosition) {
          jQuery("header").addClass("white-border");
        } else {
          jQuery("header").removeClass("white-border");
        }
      }
    };
  })();

  var html_height = jQuery(document).height();
  var mb_scaled = -0.2 * html_height;
  jQuery("body").css("margin-bottom", mb_scaled);

  jQuery(
    ".contact-us-form-section .content-area .contact-us-container .contact-select .filter-box .select-items div"
  ).on("click", function () {
    var order = jQuery(this).index();
    jQuery(
      ".contact-us-form-section .content-area .contact-us-container .tab-content .tab-pane"
    ).removeClass("show active");
    jQuery(
      ".contact-us-form-section .content-area .contact-us-container .tab-content .tab-pane:eq(" +
        order +
        ")"
    ).addClass("show active");
  });

  AOS.refresh();
});

// jQuery(window).on("resize", function () {
//   var html_height = jQuery(document).height();
//   var mb_scaled = -0.2 * html_height;
//   jQuery("body").css("margin-bottom", mb_scaled);
// });

jQueryslickPhoto = false;
function photoSlider() {
  if (jQuery(window).width() < 767) {
    if (!jQueryslickPhoto) {
      jQuery(".photos .photo-boxes").slick({
        infinite: true,
        dots: false,
        nav: false,
        arrows: true,
        speed: 300,
        slidesToShow: 1,
        autoplay: true,
        pauseOnHover: false,
        autoplaySpeed: 5000,
        useTransform: false,
      });
      jQueryslickPhoto = true;
    }
  } else if (jQuery(window).width() > 768) {
    if (jQueryslickPhoto) {
      jQuery(".photos .photo-boxes").slick("unslick");
      jQueryslickPhoto = false;
    }
  }
}

jQuery(document).ready(function () {
  photoSlider();
});
jQuery(window).on("resize", function () {
  photoSlider();
});
