(function ($) {
    "use strict";

    $(document).ready(function() {
        thim_startertheme.ready();
    });

    $(window).load(function() {
        thim_startertheme.load();
    });

    var thim_startertheme = {

        /**
         * Call functions when document ready
         */
        ready: function() {
            this.calendar_jqueryui();
        },

        /**
         * Call functions when window load.
         */
        load: function() {

        },

        /**
         * calendar_jqueryui
         */
        calendar_jqueryui : function() {
            try {
                $( ".js-call-calendar" ).each(function(){
                    var arrayDays = [''];
                    var arrayLinks = [''];
                    var link = '';

                    if ($(this).data('days') != null) {
                        arrayDays = $(this).data('days');
                    }
                    if ($(this).data('link') != null) {
                        arrayLinks = $(this).data('link');
                    }

                    $(this).datepicker({
                        firstDay: 1,
                        dateFormat: 'yy-mm-dd',

                        onSelect: function(dateSelected, obj) {
                            for (var i=0; i<arrayDays.length; i++) {
                                if(arrayDays[i] == dateSelected) {
                                    window.open(arrayLinks[i]);
                                }
                            }
                        },

                        beforeShowDay: function(d) {
                            var date = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();

                            for (var i=0; i<arrayDays.length; i++) {
                                if(arrayDays[i] == date) {
                                    return [true, "have-event", ""];
                                }
                            }

                            return [true];
                        }

                    });
                });
            } catch(er) {console.log(er);}
        },

    };

})(jQuery);