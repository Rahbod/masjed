$(document).scroll(function () {
    var y = $(this).scrollTop();
    if (y > 800) {
        $('.fade').fadeIn();
    } else {
        $('.fade').fadeOut();
    }
});

$(document).scroll(function () {
    var y = $(this).scrollTop();
    if (y > 100) {
        $('.site-header').addClass('fixed-menu');
    } else {
        $('.site-header').removeClass('fixed-menu');
    }
});

$(function () {
    $("body").on('click', 'a.lazy-scroll', function (e) {
        e.preventDefault();
        $("html, body").animate({
          scrollTop: $($(this).attr("href")).offset().top
        }, 2000);
    });
});