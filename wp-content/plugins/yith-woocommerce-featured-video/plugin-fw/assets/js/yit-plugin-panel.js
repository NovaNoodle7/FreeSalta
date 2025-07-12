/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */


(function ($) {

    // select
    var select_value = function () {

        var value = '';

        if ($(this).attr('multiple')) {
            $(this).children("option:selected").each(function (i, v) {
                if (i != 0)
                    value += ', ';

                value += $(v).text();
            });

            if (value == '') {
                $(this).children().children("option:selected").each(function (i, v) {
                    if (i != 0)
                        value += ', ';

                    value += $(v).text();
                });
            }
        }
        else {
            value = $(this).children("option:selected").text();

            if (value == '')
                value = $(this).children().children("option:selected").text();
        }


        if ($(this).parent().find('span').length <= 0) {
            $(this).before('<span></span>');
        }

        $(this).parent().children('span').replaceWith('<span>' + value + '</span>');
    };
    $('.plugin-option .select_wrapper select').not('.chosen').each(select_value).change(select_value);

    //Open select multiple
    $('.plugin-option .select_wrapper').click(function (e) {
        e.stopPropagation();
        $(this).find('select[multiple]').not('.chosen').toggle();
    });
    //Stops click propagation on select, to prevent select hide
    $('.plugin-option .select_wrapper select[multiple]').not('.chosen').click(function (e) {
        e.stopPropagation();
    });
    //Hides select on window click
    $(window).click(function () {
        $('.plugin-option .select_wrapper select[multiple]').not('.chosen').hide();
    })
    //chosen
    $('.plugin-option .chosen .select_wrapper select').chosen();

    // on-off
    $('.plugin-option .onoff_container span').on('click', function () {
        var input   = $(this).prev('input');
        var checked = input.prop('checked');

        if (checked) {
            input.prop('checked', false).attr('value', 'no').removeClass('onoffchecked');
        } else {
            input.prop('checked', true).attr('value', 'yes').addClass('onoffchecked');
        }

        input.change();
    });

    //colorpicker
    $('.plugin-option .panel-colorpicker').wpColorPicker({
        onInit: function(){ },
        change: function(event, ui){
        },
        clear: function(){
            var input = $(this);
            input.val(input.data('default-color'));
            input.change();
        }
    });

    //slider
    $('.plugin-option .slider_container .ui-slider-horizontal').each(function () {
        var val = $(this).data('val');
        var minValue = $(this).data('min');
        var maxValue = $(this).data('max');
        var step = $(this).data('step');
        var labels = $(this).data('labels');

        $(this).slider({
            value: val,
            min  : minValue,
            max  : maxValue,
            range: 'min',
            step : step,

            slide: function (event, ui) {
                $(this).find('input').val(ui.value);
                $(this).siblings('.feedback').find('strong').text(ui.value + labels);
            }
        });
    });


    if (typeof wp !== 'undefined' && typeof wp.media !== 'undefined') {

        //upload
        var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;

        // preview
        $('.plugin-option .upload_img_url').change(function () {
            var url = $(this).val();
            var re = new RegExp("(http|ftp|https)://[a-zA-Z0-9@?^=%&amp;:/~+#-_.]*.(gif|jpg|jpeg|png|ico)");

            var preview = $(this).parents().siblings('.upload_img_preview');
            if (re.test(url)) {
                preview.html('<img src="' + url + '" style="max-width:600px; max-height:300px;" />');
            } else {
                preview.html('');
            }
        }).trigger( 'change' );

        $( document ).on( 'click', '.plugin-option .upload_button', function(e) {
            e.preventDefault();

            var t = $(this),
                custom_uploader,
                id = t.attr('id').replace(/-button$/, '');

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            var custom_uploader_states = [
                // Main states.
                new wp.media.controller.Library({
                    library:   wp.media.query(),
                    multiple:  false,
                    title:     'Choose Image',
                    priority:  20,
                    filterable: 'uploaded'
                })
            ];

            // Create the media frame.
            custom_uploader = wp.media.frames.downloadable_file = wp.media({
                // Set the title of the modal.
                title: 'Choose Image',
                library: {
                    type: ''
                },
                button: {
                    text: 'Choose Image'
                },
                multiple: false,
                states: custom_uploader_states
            });


            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on( 'select' , function() {
                var attachment = custom_uploader.state().get( 'selection' ).first().toJSON();

                $("#" + id).val( attachment.url );
                //  Save the id of the selected element to an element which name is the same with
                // a suffix "-yith-attachment-id"
                if ($("#" + id + "-yith-attachment-id")) {
                    $("#" + id + "-yith-attachment-id").val(attachment.id);
                }

                $('.plugin-option .upload_img_url').trigger('change');
            });

            //Open the uploader dialog
            custom_uploader.open();
        });

        $( document).on( 'click', '.plugin-option .upload_button_reset', function(e){
            var t   = $(this),
                id = t.attr('id'),
                input_id = t.attr('id').replace(/-button_reset$/, ''),
                default_value = $('#' + id).data('default');

            $("#" + input_id).val( default_value );
            $('.plugin-option .upload_img_url').trigger('change');
        } );
    }

    $('.plugin-option .add_media').on('click', function () {
        _custom_media = false;
    });

    //dependencies handler
    $('[data-field]').each(function () {
        var t = $(this);

        var field = '#' + t.data('field'),
            dep = '#' + t.data('dep'),
            value = t.data('value');

        $(dep).on('change',function () {
            dependencies_handler(field, dep, value.toString());
        }).change();
    });

    //Handle dependencies.
    function dependencies_handler(id, deps, values) {
        var result = true;

        //Single dependency
        if (typeof( deps ) == 'string') {
            if (deps.substr(0, 6) == ':radio') {
                deps = deps + ':checked';
            }

            var values = values.split(',');

            for (var i = 0; i < values.length; i++) {

                if ($(deps).val() != values[i]) {
                    result = false;
                }
                else {
                    result = true;
                    break;
                }
            }
        }

        if (!result) {
            $(id + '-container').closest('tr').hide();
        } else {
            $(id + '-container').closest('tr').show();
        }
    };

    //connected list
    $('.rm_connectedlist').each(function () {
        var ul = $(this).find('ul');
        var input = $(this).find(':hidden');
        var sortable = ul.sortable({
            connectWith: ul,
            update     : function (event, ui) {
                var value = {};

                ul.each(function () {
                    var options = {};

                    $(this).children().each(function () {
                        options[ $(this).data('option') ] = $(this).text();
                    });

                    value[ $(this).data('list') ] = options;
                });

                input.val((JSON.stringify(value)).replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0'));
            }
        }).disableSelection();
    });

    $(document).ready(function () {

        $('.yith-video-link').click(function (event) {
            event.preventDefault();
            var target = $(this).data('video-id');

            $('.' + target).dialog({
                dialogClass  : 'wp-dialog yit-dialog yit-video-dialog',
                modal        : true,
                closeOnEscape: true,
                width        : 'auto',
                resizable    : false,
                draggable    : false,
                create       : function (event, ui) {
                    $(this).css("maxWidth", "853px");
                },
                open         : function (event, ui) {

                    $('.ui-widget-overlay').bind('click', function () {
                        $(this).siblings('.ui-dialog').find('.ui-dialog-content').dialog('close');
                    });

                }

            });

            $('.ui-dialog :button').blur();

        });
    });

    //codemirror
    $(document).ready(function () {
        $('.codemirror').each(function (i, v) {
            var editor = CodeMirror.fromTextArea(v, {
                lineNumbers            : 1,
                mode                   : 'javascript',
                showCursorWhenSelecting: true
            })

            $(v).data('codemirrorInstance', editor);
        })
    })

    //google analytics generation
    $(document).ready(function () {
        $('.google-analytic-generate').click(function () {
            var editor = $('#' + $(this).data('textarea')).data('codemirrorInstance');
            var gatc = $('#' + $(this).data('input')).val();
            var basename = $(this).data('basename');

            var text = "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n";
            text += "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement( o ),\n";
            text += "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n";
            text += "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');\n\n";
            text += "ga('create', '" + gatc + "', '" + basename + "');\n";
            text += "ga('send', 'pageview');\n";
            editor.replaceRange(
                text,
                editor.getCursor('start'),
                editor.getCursor('end')
            )
        })
    })
    
})(jQuery);