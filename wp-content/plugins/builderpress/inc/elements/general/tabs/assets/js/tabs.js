(function($) {
    'use strict';

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
            this.thim_tabs();
        },

        /**
         * Call functions when window load.
         */
        load: function() {

        },

        /**
         * thim-tabs
         */
        thim_tabs: function() {
            try {
                $('.js-call-tabs').each(function(){
                    var navTabs = $(this).find('.thim-nav-tabs');
                    var contentTabs = $(this).find('.thim-content-tabs');

                    $(contentTabs).find('.tab-panel').hide();

                    var getPanelActive = $(navTabs).find('.item-nav.active').data('panel');

                    $(contentTabs).find(".tab-panel[data-nav='" + getPanelActive + "']").show();
                    $(contentTabs).find(".tab-panel[data-nav='" + getPanelActive + "']").addClass('active');


                    $(navTabs).find('.item-nav').each(function(){
                        $(this).on('click', function(){
                            var getPanel = $(this).data('panel');

                            $(contentTabs).find('.tab-panel').hide();
                            $(contentTabs).find('.tab-panel').removeClass('active');
                            $(navTabs).find('.item-nav').removeClass('active');

                            $(contentTabs).find(".tab-panel[data-nav='" + getPanel + "']").show();
                            $(contentTabs).find(".tab-panel[data-nav='" + getPanel + "']").addClass('active');
                            $(this).addClass('active');
                        });
                    });

                });
            } catch(er) {console.log(er);}
        },

    };

})(jQuery);