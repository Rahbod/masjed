var nicescrolls = [];

$(function () {
    if ($.fn.onepage_scroll !== undefined && $(window).width() > 1024) {
        $(".content").onepage_scroll({
            sectionContainer: "section",
            easing: "ease",
            animationTime: 1000,
            pagination: true,
            updateURL: false,
            loop: false,
            keyboard: true,
            responsiveFallback: false,
            direction: "vertical"
        });
    }

    $('.digitFormat').digitFormat();
    $('.numberFormat').numericFormat();
    $('.dateFormat').dateFormat();

    $("body").on("keyup", '.digitFormat', function () {
        $(this).digitFormat();
    }).on("change", '.digitFormat', function () {
        $(this).digitFormat();
    }).on("keyup", '.numberFormat', function () {
        $(this).numericFormat();
    }).on("change", '.numberFormat', function () {
        $(this).numericFormat();
    }).on("keyup", '.dateFormat', function () {
        $(this).dateFormat();
    }).on("change", '.dateFormat', function () {
        $(this).dateFormat();
    });

    if ($.fn.datepicker) {
        $(".datepicker").each(function () {
            var options = $(this).data('datepicker');
            $(this).datepicker(options);
        });
    }

    // $(window).on("load resize scroll", function () {
    $(".owl-carousel").each(function () {
        if ($(window).width() > 768) {
            if ($(this).hasClass('mobile-carousel')) {
                $(this).removeClass('owl-carousel').removeClass('owl-theme');
                return;
            }
        }

        var options = $(this).data(),
            allOptions = $(this).data('owlcarousel');
        delete options.owlcarousel;

        if (typeof allOptions === "string" && allOptions.indexOf("js:") !== -1)
            allOptions = JSON.parse(allOptions.substr(3));

        if (typeof options.autoheight !== undefined) {
            options.autoHeight = true;
            delete options.autoheight;
        }

        // if (typeof options.autoplayspeed !== undefined) {
        //     options.autoPlaySpeed = options.autoplayspeed;
        //     options.autoplay = true;
        //     delete options.autoplayspeed;
        // }

        if ($(this).hasClass('news-carousel') || $(this).hasClass('header-slider'))
            options['navText'] = ["<i class='icon icon-chevron-right'></i>", "<i class='icon icon-chevron-left'></i>"];
        else {
            if (typeof options.rtl !== undefined && options.rtl === true)
                options['navText'] = ["<i class='svg-arrow-left'></i>", "<i class='svg-arrow-right'></i>"];
            else
                options['navText'] = ["<i class='svg-arrow-right'></i>", "<i class='svg-arrow-left'></i>"];
        }

        options['lazyLoad'] = false;

        if (typeof allOptions !== undefined)
            options = $.extend(options, allOptions);

        $(this).owlCarousel(options);
    });
    // });

    var contentBodyH;
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 10)
            $('header').addClass('shadow');
        else
            $('header').removeClass('shadow');

        if ($(window).width() < 768) {
            if ($(".content-body, #news-list").length) {
                contentBodyH = $(".content-body, #news-list").offset().top + $(".content-body, #news-list").height();
                if ($(this).scrollTop() > $(".content-header").height())
                    $('body').addClass('scroll');
                else
                    $('body').removeClass('scroll');

                if ($(this).scrollTop() > (contentBodyH - 300))
                    $('body').addClass('stop');
                else
                    $('body').removeClass('stop');
            }
        }

    });

    $("body").on("mouseover", "li.dropdown", function () {
        $(this).addClass("open");
    }).on("mouseleave", "li.dropdown", function () {
        $(this).removeClass("open");
    }).on('click', '.panel-title', function (event) {
        $('.overlay').toggle();
        var This = $(event.target);
        var panel_parent = This.parents('.panel');
        var el_id = This.parents('.panel').find('div.collapse').attr('id');
        $('#' + el_id).collapse();
        if (panel_parent.hasClass('-z-index')) {
            panel_parent.removeClass('-z-index')
        } else {
            panel_parent.addClass('-z-index')
        }
    }).on('click', '#sidebarCollapse', function () {
        // open sidebar
        $('#sidebar').addClass('active');
        // fade in the overlay
        $('.sidebar--overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    }).on('click', '#dismiss, .sidebar--overlay', function () {
        // hide sidebar
        $('#sidebar').removeClass('active');
        // hide overlay
        $('.sidebar--overlay').removeClass('active');
    }).on('click', '.desktop-menu .close', function () {
        $('.desktop-menu').removeClass('open').fadeOut();
    }).on('click', '.navbar-toggler', function () {
        $('.desktop-menu').fadeIn(function () {
            $(this).addClass('open')
        });
        return false;
    }).on('click', '.mobile-index-menu ul li a', function (e) {
        var position = $($(this).attr('href')).offset();
        $('.mobile-index-menu').removeClass('open').fadeOut(function () {
            $("html, body").animate({scrollTop: position.top}, 'slow');
        });
        e.preventDefault();
    }).on('click', '.desktop-menu .anchor-link', function (e) {
        e.preventDefault();

        var href = $(this).attr('href'),
            secNum = 0;
        if (href.indexOf('#') != -1)
            secNum = href.substr(href.indexOf('#') + 1);

        $('.desktop-menu').removeClass('open').fadeOut(function () {
            if (!$('body').hasClass('inner-page')) {
                if ($(window).width() > 768)
                    $(".content").moveTo(secNum);
                else {
                    var position = $('#section-' + secNum).offset();
                    $("html, body").animate({scrollTop: position.top}, 'slow');
                }
            } else {
                if (href.indexOf('#') != -1)
                    window.location = '/site/index?sec=' + secNum;
                else
                    window.location = href;
            }
        });
    }).on('click', '.mobile-index-menu .close', function () {
        $('.mobile-index-menu').removeClass('open').fadeOut();
    }).on('click', '.mobile-menu-trigger', function () {
        $('.mobile-index-menu').fadeIn(function () {
            $(this).addClass('open')
        });
        return false;
    }).on('click', '.bank-accounts li:not(.tel-link)', function () {
        copyToClipboard($(this).find('.account-number input').attr('id'));
    }).on('click', '.video-overlay', function () {
        $(this).parent().find('video')[0].play();
        $(this).remove();
    }).on('click', 'header .navbar-nav > li > a', function (e) {
        e.preventDefault();
        var href = $(this).attr('href'),
            secNum = 0;
        if (href.indexOf('#') != -1)
            secNum = href.substr(href.indexOf('#') + 1);
        if (!$('body').hasClass('inner-page'))
            $(".content").moveTo(secNum);
        else {
            if (href.indexOf('#') != -1)
                window.location = '/site/index?sec=' + secNum;
            else
                window.location = href;
        }
    });

    $(window).on("load resize", function () {
        // news carousel initialize
        if ($(".news-carousel").length) {
            $(".news-carousel .owl-next").css({left: $(".news-carousel .owl-dot:last-of-type").offset().left - 45 - (($(window).width() - $(".container").width() - 30) / 2)});
            $(".news-carousel .owl-prev").css({left: $(".news-carousel .owl-dot:first-of-type").offset().left + 10 - (($(window).width() - $(".container").width() - 30) / 2)});
        }
        // if($(window).width()>768)
        // $(".nicescroll").each(function () {
        //     var options = $(this).data();
        //     $.each(options, function (key, value) {
        //         if (typeof value === "string" && value.indexOf("js:") !== -1)
        //             options[key] = JSON.parse(value.substr(3));
        //     });
        //     // if (refresh === true)
        //     //     $(this).getNiceScroll().remove();
        //
        //     var instance = $(this).niceScroll(options);
        //     // if($(this).attr('id')=='scroll-box')
        //     //     console.log(instance);
        //     nicescrolls.push({id: $(this).attr('id'), instance: instance});
        // });
    });

    makeHelpBox();

    var index = $('.time-line .owl-item').index($('.time-line-item.doing').parent('.owl-item'));
    $('.time-line.owl-carousel').trigger('to.owl.carousel', [index - 1, 500, true]);

    var url = window.location.href;
    if (url.indexOf('?sec=') != -1) {
        var section = url.substr(url.indexOf('?sec=') + 5);
        if ($(window).width() > 768)
            $(".content").moveTo(section);
        else {
            var position = $('#section-' + section).offset();
            $("html, body").animate({scrollTop: position.top}, 'slow');
        }
    }
});
// hide or show the main navbar base on page scroll : start
// var header_height = $('header').height();
var header_height = 160;
var headerTag = $('header');

$(window).on("load resize scroll", function () {
    var width = $(this).width();
    if (width > 992) {
        var scroll = $(window).scrollTop();
        if (scroll > header_height) {
            $('header > .container').hide();
            $('header .navbar > li > a').addClass('text-white');
            headerTag.addClass('smallHeader');
            // $('li.dropdown').removeClass("open");
        } else {

            $('header > .container').show();
            headerTag.removeClass('smallHeader');
            $('header .navbar > li > a').removeClass('text-white');

        }
    }
    // header_height = scroll;
});
// hide or show the main navbar base on page scroll : end

$(window).on("scroll", function () {
    var width = $(this).width();
    if (width < 768) {
        var scroll = $(window).scrollTop();
        if (scroll > 200)
            $('body').addClass('mobile-scrolled');
        else
            $('body').removeClass('mobile-scrolled');
    }
});

$('#dismiss, .screen-overlay').on('click', function () {
    $('nav#sidebar').removeClass('active');
    $('.screen-overlay').removeClass('active');
    $('body').removeClass('overflow-fix');
});

$('#sidebarCollapse').on('click', function () {
    $('#sidebar').addClass('active');
    $('.screen-overlay').addClass('active');
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    $('body').addClass('overflow-fix');
});


$.fn.digitFormat = function () {
    return this.each(function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            if (parseInt(value) === 0)
                return value;
            else if (value.indexOf(".") >= 0) {
                return value;
                var arr = value.split('.');
                console.log(arr);
                value = arr[0]
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + arr[1];
                return value;
            }
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
};

$.fn.numericFormat = function () {
    return this.each(function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            return value
                .replace(/\D/g, "");
        });
    });
};

$.fn.dateFormat = function () {
    return this.each(function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            return value
                .replace(/[0-9\/]*/g, "");
        });
    });
};

function makeHelpBox() {
    if ($(window).width() > 768) {
        var helpBoxColumns = {first: [], second: [], third: []},
            i = 0,
            helpContainer = $('.help-container');
        helpContainer.find('.help-content .help-item').each(function (index) {
            if (i == 0)
                helpBoxColumns.first.push($(this).html());
            else if (i == 1)
                helpBoxColumns.second.push($(this).html());
            else if (i == 2)
                helpBoxColumns.third.push($(this).html());

            if (i < 2)
                i++;
            else
                i = 0;
        });

        helpContainer.find('.help-content').html('');
        helpContainer.find('.help-content').append('<div class="col-lg-4 col-md-4 col-sm-4 help-column first"><div class="help-item">' + helpBoxColumns.first.join('</div><div class="help-item">') + '</div></div>');
        helpContainer.find('.help-content').append('<div class="col-lg-4 col-md-4 col-sm-4 help-column second"><div class="help-item">' + helpBoxColumns.second.join('</div><div class="help-item">') + '</div></div>');
        helpContainer.find('.help-content').append('<div class="col-lg-4 col-md-4 col-sm-4 help-column third"><div class="help-item">' + helpBoxColumns.third.join('</div><div class="help-item">') + '</div></div>');
    }
}

function copyToClipboard(id) {
    /* Get the text field */
    var copyText = document.getElementById(id);

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    alert("The account number was copied.");
}