/*jslint browser: true, white: true */
/*global console,jQuery,megamenu,window,navigator*/

/**
 * Max Mega Menu jQuery Plugin
 */
jQuery(function($) {

    // Make block areas sortable
    $( ".mega-blocks .mega-left" ).sortable({
        forcePlaceholderSize: false,
        items : '.block',
        stop: function() {
            reindex_blocks();
        },
        connectWith: ".mega-blocks .mega-right, .mega-blocks .mega-center"
    });

    $( ".mega-blocks .mega-right" ).sortable({
        forcePlaceholderSize: false,
        items : '.block',
        stop: function() {
            reindex_blocks();
        },
        connectWith: ".mega-blocks .mega-left, .mega-blocks .mega-center"
    });

    $( ".mega-blocks .mega-center" ).sortable({
        forcePlaceholderSize: false,
        items : '.block',
        stop: function() {
            reindex_blocks();
        },
        connectWith: ".mega-blocks .mega-left, .mega-blocks .mega-right"
    });


    // Reindex blocks based on position
    var reindex_blocks = function() {
        var i = 0;

        $(".mega-blocks .block").each(function() {
            i++;

            var block = $(this);

            block.find('input, select, textarea').each(function() {
                // account for inputs created by select2
                if (typeof $(this).attr('name') !== 'undefined') {
                    $(this).attr('name', $(this).attr('name').replace(/\[\d+\]/g, "[" + i + "]"));
                }
            });

            // update the align value based on block position
            block.find('input.align').each(function() {
                if (block.parent().hasClass('mega-right')) {
                    $(this).attr('value', 'right');
                } else if (block.parent().hasClass('mega-center')) {
                    $(this).attr('value', 'center');
                } else {
                    $(this).attr('value', 'left');
                }
            });
        });
    };


    // Delete block
    $( ".mega-toggle_blocks").on('click', 'a.mega-delete', function(e) {
        e.preventDefault();
        $(this).parent(".block-settings").parent(".block").remove();
        reindex_blocks();
    });


    // Show/hide block settings
    $( '.mega-toggle_blocks').on('click', '.block-title', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var settings = $(this).parent().find(".block-settings");
        $(".block").removeClass('mega-open');

        if ( settings.is(":visible") ) {
            settings.parent().removeClass('mega-open');
            settings.hide();
        } else {
            settings.parent().addClass('mega-open');
            $(".block-settings").hide();
            settings.show();
        }

    });


    // Add block to designer
    $( "#toggle-block-selector").on('change', function() {
        var selected_option = $("#toggle-block-selector").find(":selected");
        var val = selected_option.attr('value');

        if (val == 'title') {
            return;
        }

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: "mm_get_toggle_block_" + val,
                _wpnonce: megamenu.nonce
            },
            cache: false,
            success: function(response) {

                var $response = $(response);

                // initiate color picker fields
                $(".mm_colorpicker", $response).spectrum({
                    preferredFormat: "rgb",
                    showInput: true,
                    showAlpha: true,
                    clickoutFiresChange: true,
                    change: function(color) {
                        if (color.getAlpha() === 0) {
                            $(this).siblings('div.chosen-color').html('transparent');
                        } else {
                            $(this).siblings('div.chosen-color').html(color.toRgbString());
                        }
                    }
                });

                // initiate icon selector dropdowns
                $('.icon_dropdown', $response).select2({
                  containerCssClass: 'tpx-select2-container select2-container-sm',
                  dropdownCssClass: 'tpx-select2-drop',
                  minimumResultsForSearch: -1,
                  formatResult: function(icon) {
                    return '<i class="dashicons ' + $(icon.element).attr('data-class') + '"></i>';
                  },
                  formatSelection: function (icon) {
                    return '<i class="dashicons ' + $(icon.element).attr('data-class') + '"></i>';
                    }
                });

                // add the block
                $(".mega-blocks .mega-left").append($response);

                // reinded blocks
                reindex_blocks();

                // reset the select dropdown
                $("#toggle-block-selector").val("title");

                $('body').trigger('toggle_block_content_loaded');

            }
        });
    });
});