(function ($) {
  "use strict";

  // data-background
  $(document).on("ready", function () {
    $("[data-background]").each(function () {
      $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
    });
  });

  // sidebar popup
  $(".sidebar-btn").on("click", function () {
    $(".sidebar-popup").addClass("open");
    $(".sidebar-wrapper").addClass("open");
  });
  $(".close-sidebar-popup, .sidebar-popup").on("click", function () {
    $(".sidebar-popup").removeClass("open");
    $(".sidebar-wrapper").removeClass("open");
  });

  // wow init
  new WOW().init();

  // preloader
  $(window).on("load", function () {
    $(".preloader").fadeOut("slow");
  });

  // scroll to top
  $(window).on("scroll", function () {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
      $("#scroll-top").addClass("active");
    } else {
      $("#scroll-top").removeClass("active");
    }
  });

  $("#scroll-top").on("click", function () {
    $("html, body").animate({ scrollTop: 0 }, 1500);
    return false;
  });

  // navbar fixed top
  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 50) {
      $(".navbar").addClass("fixed-top");
    } else {
      $(".navbar").removeClass("fixed-top");
    }
  });

  // copywrite date
  let date = new Date().getFullYear();
  $("#date").html(date);

  // auth password view
  $(".password-view").on("click", function () {
    var input = $(this).closest(".form-icon").find(".show-pass");
    var icon  = $(this).find("i");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
      icon.removeClass("fa-eye-slash").addClass("fa-eye");
    } else {
      input.attr("type", "password");
      icon.removeClass("fa-eye").addClass("fa-eye-slash");
      }
  });

  // counting
  $(document).ready(function () {
    let counted = false;
    function startCounter() {
      let $counter = $("#counter");
      let target = parseFloat($counter.text().replace(/[$,]/g, ""));
      let duration = 3000;
      $({ count: 0 }).animate(
        { count: target },
        {
          duration: duration,
          easing: "swing",
          step: function () {
            $counter.text(
              "$" +
                this.count.toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
            );
          },
          complete: function () {
            $counter.text(
              "$" +
                target.toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
            );
          },
        }
      );
    }
    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach((entry) => {
          if (entry.isIntersecting && !counted) {
            counted = true;
            startCounter();
          }
        });
      },
      {
        threshold: 0.5,
      }
    );
    observer.observe(document.querySelector(".recover"));
  });

  // scroll
  $(document).ready(function () {
    $('.nav-link[href^="#"], .footer-list a').on('click', function (e) {
      e.preventDefault();

      const target = $(this.getAttribute('href'));

      if (!target.length) return;

      $('html, body').animate(
        {
          scrollTop: target.offset().top - 70
        },
        600
      );
    });
  });

  // bootstrap tooltip enable
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
})(jQuery);
