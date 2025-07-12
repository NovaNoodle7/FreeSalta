/*
 Spinner for jQuery (version 0.1)
 Copyright (c) 2012 Simone D'Amico
 http://simonedamico.com/

 Licensed under the MIT license:
 http://www.opensource.org/licenses/mit-license.php

 Any and all use of this script must be accompanied by this copyright/license notice in its present form.

 */
(function($){
    $.fn.spinner = function(params) {

        //private methods
        var _createButton = function( buttonClass, buttonLabel ) {
            return $('<button/>', {
                'class' : buttonClass + ' spinner-button',
                text    : buttonLabel
            });
        };

        var _createBody = function(input) {
            //create wrapper
            var wrapper = input.wrap('<div class="spinner-wrapper"></div>').parent();

            //create spinner buttons
            var plus = _createButton('button-plus', '+').appendTo(wrapper).show(),
                minus = _createButton('button-minus', '-').appendTo(wrapper).show();

            return wrapper;
        };

        var _buttonClick = function( e ) {
            var input  = e.data.input,
                params = e.data.params,
                button = $(this),
                value  = parseFloat(input.val());

            if( button.hasClass('button-plus') ) {
                if( params.max != null ) {
                    if( ( value + params.interval ) <= params.max  ) {
                        input.val( value + params.interval );
                    } else {
                        input.val( params.max );
                    }
                } else {
                    input.val( value + params.interval );
                }
            } else if( button.hasClass('button-minus') ) {
                if( params.min != null ) {
                    if( ( value - params.interval ) >= params.min ) {
                        input.val( value - params.interval );
                    } else {
                        input.val( params.min );
                    }
                } else {
                    input.val( value - params.interval );
                }
            }

            input.change(); e.preventDefault();
        };

        var _validateContent = function( e ) {
            var value = parseFloat( $(this).val() );

            if( params.max != null && value >= params.max ) {
                $(this).val(params.max);
            } else if( value <= params.min || isNaN( value ) ) {
                $(this).val(params.min ? params.min : 0);
            } else {
                $(this).val(value);
            }
        };


        //public methods
        var methods = {
            init : function( params ) {

                var params = $.extend({
                    min: null,
                    max: null,
                    interval: 1,
                    defaultValue: 0,
                    mouseWheel: true,
                    largeInterval: 10
                }, params);

                var self = this,
                    t = $(this),
                    data = t.data('spinner');

                return this.each(function(){
                    //check if the plugin hasn't already been initialized
                    //and it's an input[type=text] element
                    if( !data && t.is(':text') ) {
                        //initialize the value
                        if( params.defaultValue ) {
                            t.val( params.defaultValue );
                        }

                        //create the spinner body
                        var wrapper = _createBody(t);

                        //event handlers
                        //var mouseWheelEventName = $.browser.mozilla ? 'DOMMouseScroll' : 'mousewheel';

                        wrapper.find('.spinner-button')
                            .bind('click.spinner', { params: params, input: t }, _buttonClick);

                        t.bind('blur.spinner', _validateContent)
                        //.bind('keyup.spinner', _validateKey)
                        //.bind(mouseWheelEventName, _inputMousewheel);

                        //register field data
                        t.data('spinner', {
                            target: self
                        });
                    }
                });
            },

            destroy : function( params) {
                console.log('destroy', params);
            }
        };

        //execute the plugin
        if ( methods[params] ) {
            return methods[params].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof params === 'object' || ! params ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  params + ' does not exist' );
        }
    };
})(jQuery);
