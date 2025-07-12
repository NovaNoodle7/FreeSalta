jQuery( document ).ready(function($){

    var lock = false,
       block_params = {
        message: null,
        overlayCSS: {
            background: '#fff',
            opacity: 0.6
        },
        ignoreIfBlocked: true
    };
  function hide_img_container( img_container ){

      if( img_container ) {
          img_container.addClass('ywcfav_has_featured');
      }
      $(document).find( '.woocommerce-product-gallery__trigger' ).addClass('ywcfav_has_featured');
  }

  function show_img_container( img_container ){
      if( img_container ) {
          img_container.removeClass('ywcfav_has_featured');
      }
      $(document).find( '.woocommerce-product-gallery__trigger' ).removeClass('ywcfav_has_featured');
  }

  function set_video_thumbnail_in_gallery( image_url ){

        var gallery_container = $(document).find('.flex-control-nav.flex-control-thumbs li').filter(':first-child');
        
        if( gallery_container.length ){
            var height = gallery_container.innerHeight();
            gallery_container.find('img').attr( 'src', image_url ).css('height', height );
        }
    }
  function set_video_in_slider( img_container ) {
     var data = {
          'product_id' : ywcfav_frontend_param.product_id,
          'action' : ywcfav_frontend_param.actions.get_featured_content
      };

      $('.images').block(block_params);


      $.ajax({
          type: 'POST',
          url: ywcfav_frontend_param.ajax_url,
          data: data,
          dataType: 'json',
          success: function (response) {

              $('.images').unblock();

              if (response.result) {

                  img_container.before( response.template );
                  img_container.parent().find('.ywcfav_video_content').css('float','left');

                  var video_info  =  img_container.parent().find('.ywcfav_video_content').data( 'video_info' );

                  hide_img_container( img_container );
                  lock = false;

                  $('body').trigger( 'ywcfav_show_video_content_in_slider',[video_info] );
              }



          }
      });
  }
  function remove_video_in_slider( img_container ){

      var general_content = img_container.parent(),
          video_content = general_content.find('.ywcfav_video_content');

      if( video_content.length ){
          video_content.remove();
          show_img_container( img_container );
      }
  }



  $(document.body).on('ywcfav_init_featured_content', function(e){
      
      if( ywcfav_frontend_param.has_feature_content ){

          var img_container = $( document ).find( ywcfav_frontend_param.no_img_class_container );

          if( !img_container.length ){

              img_container = $(document).find( ywcfav_frontend_param.img_class_container ).filter(':first-child');
          }

          if( $( '.variations_form.cart' ).length ){

              remove_video_in_slider( img_container );
              $('.variations_form').on( 'reset_data', function(e){



                  if(  !lock ) {
                      lock = true;
                      set_video_in_slider(img_container);
                  }


              }).on( 'show_variation', function(e, variation_data ){
                  remove_video_in_slider( img_container );
              } );


          }else{

              set_video_in_slider( img_container );
          }




      }
  }).trigger( 'ywcfav_init_featured_content' ) ;
   
  $('body').on( 'ywcfav_show_video_content_in_slider', function(e,video_info ){
      
      var data = {
              'video_info': video_info,
              'action': ywcfav_frontend_param.actions.get_video_image
            };

      $.ajax({
          type: 'POST',
          url: ywcfav_frontend_param.ajax_url,
          data: data,
          dataType: 'json',
          success: function (response) {


              set_video_thumbnail_in_gallery( response.image_url );
          }
      });

  })  ;


  $(document).on('click', '.flex-control-nav.flex-control-thumbs li', function(e){

      if( $(this).is(':first-child' ) ){
          hide_img_container( false );
      }else{
          show_img_container( false );
      }
  })  ;
});