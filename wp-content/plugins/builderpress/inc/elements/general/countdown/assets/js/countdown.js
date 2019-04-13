(function ($) {
    "use strict";

    $(document).ready(function () {
        layout_1();
        kindergarten_coundown();
    });

    var layout_1 = function() {
        let countdown = $('.bp-element-countdown .wrap-countdown');

        for (var i = 0; i < countdown.length; i++) {

            var count = $(countdown[i]).find('.countdown'),
                time = count.data('time'),
                labels = [
                    count.data('text-year') ? count.data('text-year') : 'Year(s)',
                    count.data('text-month') ? count.data('text-month') : 'Month(s)',
                    count.data('text-week') ? count.data('text-week') : 'Week(s)',
                    count.data('text-day') ? count.data('text-day') : 'Day(s)',
                    count.data('text-hour') ? count.data('text-hour') : 'Hour(s)',
                    count.data('text-minute') ? count.data('text-minute') : 'Minutes(s)',
                    count.data('text-second') ? count.data('text-second') : 'Second(s)',
                ];

            time = new Date(time);

            var current_time = new Date(time);

            $(countdown[i]).countdown({
                labels: labels,
                until: current_time
            });
        }
    };

    var kindergarten_coundown = function () {
        var counts = $('.tp_event_counter');
        for (var i = 0; i < counts.length; i++) {
            var time = $(counts[i]).attr('data-time');
            time = new Date(time);

            var current_time = new Date(time);

            $(counts[i]).countdown({
                labels    : ['Years', 'Months', 'Weeks', 'Days', 'Hours', 'Minutes', 'Seconds'],
                labels1   : ['Years', 'Months', 'Weeks', 'Days', 'Hours', 'Minutes', 'Seconds'],
                until     : current_time,
                serverSync: current_time
            });
        }
    }

})(jQuery);