$(function () {
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

    $.fn.persianDatepickerTrigger = function () {
        var persianDatepicker = [];

        this.each(function (index) {
            var val = $(this).data("value"),
                config = $(this).data("config");
            config['onShow'] = function () {
                for (var i = 0; i < persianDatepicker.length; i++)
                    if (i !== index)
                        persianDatepicker[i].hide();
            };

            if ($(this).hasClass('date-time-picker')) {
                config['onSelect'] = function (date) {
                    $(this).parent().find('.hour').val((new Date()).getHours());
                    $(this).parent().find('.minute').val((new Date()).getMinutes());
                };
            }

            //persianDatepicker[index] = $(this).persianDatepicker(config);

            persianDatepicker[index] = $(this).datepicker(config);

            if (typeof val !== "undefined" && val)
                $(this).datepicker('setDate', new Date(val * 1000));
        });
    };

    $(".datepicker").persianDatepickerTrigger();
});

$.fn.digitFormat = function () {
    return this.each(function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            if (parseInt(value) === 0)
                return value;
            else if (value.indexOf(".") >=0) {
                return value;
                var arr = value.split('.');
                console.log(arr);
                value = arr[0]
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+arr[1];
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