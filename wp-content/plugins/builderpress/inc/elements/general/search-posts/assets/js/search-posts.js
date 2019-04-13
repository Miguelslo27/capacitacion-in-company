(function ($) {
    "use strict";

    $(document).ready(function () {
        bp_element_search.search_layout_2();
        bp_element_search.search_ajax();
        bp_element_search.search_popup();
    });

    var bp_element_search = {

        search_layout_2: function () {
            $('.thim-search-box').on('click', '.toggle-form', function (e) {
                e.preventDefault();
                $('body').toggleClass('thim-active-search');
                var $search = $(this).parent();
                $search.find('.search-default').slideDown();
                $search.find('.search-found').slideUp();
                setTimeout(function () {
                    $search.find('.search-field').focus().val('');
                }, 400);
            });

            $(".thim-search-box form").submit(function () {
                var input_search = $(this).find("input.search-field");
                if ($.trim(input_search.val()) === "") {
                    input_search.focus();
                    return false;
                }
            });

            $('#main-content').on('click', function () {
                if ($('body').hasClass('thim-active-search')) {
                    $('body').removeClass('thim-active-search');
                    var $search = $('#masthead .thim-search-box');
                    $search.each(function (index, form) {
                        $(form).find('.search-default').slideDown();
                        $(form).find('.search-found').slideUp();
                    });
                }
            });

            // $(window).scroll(function () {
            //     if ($(window).width() > 768) {
            //         if ($('body').hasClass('thim-active-search')) {
            //             $('body').removeClass('thim-active-search');
            //             var $search = $('#masthead .thim-search-box');
            //             $search.each(function (index, form) {
            //                 $(form).find('.search-default').slideDown();
            //                 $(form).find('.search-found').slideUp();
            //             });
            //         }
            //     }
            // });

            $('.icon-close').on('click', function () {
                if ($('body').hasClass('thim-active-search')) {
                    $('body').removeClass('thim-active-search');
                }
            });

            $(window).scroll(function() {
                $('body').removeClass('thim-active-search');
            });
        },


        search_ajax: function () {
            var $sc_wrapper = $('.bp-element-search .search-form');

            $sc_wrapper.live('keyup', '.search-field', function (event) {

                var selected = $(".ob-selected");

                clearTimeout($.data(this, 'timer'));
                if (event.which === 13) {
                    event.preventDefault();
                    $(this).stop();
                } else if (event.which === 38) {
                    if (navigator.userAgent.indexOf('Chrome') !== -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15) {
                        if ($sc_wrapper.find(".list-search li").length > 1) {
                            $sc_wrapper.find(".list-search li").removeClass("ob-selected");
                            // if there is no element before the selected one, we select the last one
                            if (selected.prev().length === 0) {
                                selected.siblings().last().addClass("ob-selected");
                            } else { // otherwise we just select the next one
                                selected.prev().addClass("ob-selected");
                            }
                        }
                    }
                } else if (event.which === 40) {
                    if (navigator.userAgent.indexOf('Chrome') !== -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15) {
                        if ($sc_wrapper.find(".list-search li").length > 1) {
                            $sc_wrapper.find(".list-search li").removeClass("ob-selected");

                            // if there is no element before the selected one, we select the last one
                            if (selected.next().length === 0) {
                                selected.siblings().first().addClass("ob-selected");
                            } else { // otherwise we just select the next one
                                selected.next().addClass("ob-selected");
                            }
                        }
                    }
                } else if (event.which === 27) {
                    $sc_wrapper.find('.list-search').html('');
                    $(this).val('');
                    $(this).stop();
                } else if (event.which === 8) {
                    $sc_wrapper.find('.list-search').html('');
                } else {
                    $(this).data('timer', setTimeout(bp_element_search.livesearch(this), 700));
                }
            });

            $sc_wrapper.live('keypress', '.search-field', function (event) {

                var selected = $(".ob-selected");

                if (event.keyCode === 13) {
                    if (selected.length > 0) {
                        var ob_href = selected.find('a').first().attr('href');
                        window.location.href = ob_href;
                    }
                    event.preventDefault();
                }
                if (event.keyCode === 38) {
                    // if there is no element before the selected one, we select the last one
                    if ($sc_wrapper.find(".list-search li").length > 1) {
                        $sc_wrapper.find(".list-search li").removeClass("ob-selected");
                        if (selected.prev().length === 0) {
                            selected.siblings().last().addClass("ob-selected");
                        } else { // otherwise we just select the next one
                            selected.prev().addClass("ob-selected");
                        }
                    }
                }
                if (event.keyCode === 40) {
                    if ($sc_wrapper.find(".list-search li").length > 1) {
                        $sc_wrapper.find(".list-search li").removeClass("ob-selected");
                        // if there is no element before the selected one, we select the last one
                        if (selected.next().length === 0) {
                            selected.siblings().first().addClass("ob-selected");
                        } else { // otherwise we just select the next one
                            selected.next().addClass("ob-selected");
                        }
                    }
                }
            });

            $sc_wrapper.find('.list-search,.search-field').live('click', function (event) {
                event.stopPropagation();
            });

            $(document).on('click', function () {
                $sc_wrapper.find(".list-search li").remove();
            });

            this.searchFocus();
        },

        livesearch: function (element, waitKey) {
            var keyword = $(element).find('.search-field').val();
            var $sc_wrapper = $(element);
            if (keyword) {
                if (!waitKey && keyword.length < 3) {
                    return;
                }
                $sc_wrapper.addClass('loading');
                $.ajax({
                    type: 'POST',
                    data: 'action=builderpress_search_ajax&keyword=' + keyword + '&from=search',
                    url: ajaxurl,
                    success: function (res) {
                        var data_li = '';
                        var items = res.data;
                        if (res.success) {
                            $.each(items, function (index) {
                                if (index === 0) {
                                    data_li += '<li class="ui-menu-item' + this.id + ' ob-selected"><a class="ui-corner-all" href="' + this.guid + '">' + this.title + '</a></li>';
                                } else {
                                    data_li += '<li class="ui-menu-item' + this.id + '"><a class="ui-corner-all" href="' + this.guid + '">' + this.title + '</a></li>';
                                }
                            });
                            $sc_wrapper.find('.list-search').html('').append(data_li);
                        }
                        bp_element_search.searchHover();
                        $sc_wrapper.removeClass('loading');
                    },
                });
            }
        },

        searchHover: function () {
            var $sc_wrapper = $('.bp-element-search .search-form');
            $sc_wrapper.on('hover', '.list-search li', function () {
                $sc_wrapper.find('.list-search li').removeClass('ob-selected');
                $(this).addClass('ob-selected');
            });
        },

        searchFocus: function () {
            var $sc_wrapper = $('.bp-element-search .search-form');
            $sc_wrapper.each(function (index, form) {
                $(form).on('hover', 'form', function () {
                    $(form).find('.search-field').focus();
                });
            });
        },

        search_popup: function () {
            var $search_button = $('.search-button'),
                $header = $('#masthead.sticky-header'),
                windoH = $(window).height();
            $('.bp-element-search').find('.search-form').css('height', windoH);
            $search_button.live('click', function (event) {
                $(this).parents('.bp-element-search').find('.search-form').addClass('open');
                $(document).on('keydown', function (e) {
                    // ESCAPE key pressed
                    if (e.keyCode === 27) {
                        $(this).find('.search-form').removeClass('open');
                    }
                });
            });
            $(document).on('click', '.close-form', function (e) {
                e.stopPropagation();
                $(this).parents('.search-form').removeClass('open');
            });

            $(window).scroll(function () {
                var window2 = windoH;

                if ($header.hasClass('menu-hidden')) {
                    window2 = windoH + $header.height() + 40;
                    $('.bp-element-search.layout-1').find('.search-form').css('height', window2);
                }

            });
        }
    }

})(jQuery);