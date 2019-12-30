$(function () {
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