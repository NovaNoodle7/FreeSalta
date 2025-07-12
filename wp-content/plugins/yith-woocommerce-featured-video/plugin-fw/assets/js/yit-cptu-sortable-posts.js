/**
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

(function($) {
    "use strict";
    // Author code here

    $("#the-list").sortable({
        items  : 'tr',
        axis   : 'y',
        helper : function(e, ui) {
            ui.children().children().each(function() {
                $(this).width( $(this).width() );
            });
            return ui;
        },
        update : function(e, ui) {
            $.post( ajaxurl, {
                action: 'cpt_sort_posts',
                order: $("#the-list").sortable("serialize"),
                post_type: typenow
            });
        }
    });

})(jQuery);