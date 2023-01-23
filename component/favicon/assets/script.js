jQuery(function($){
    var file_frame;
    $('.upload_image_button').click(function(e) {
        e.preventDefault();
        
        if (file_frame) file_frame.close();

        file_frame = wp.media.frames.file_frame = wp.media({
            library: {
                type: [ 
                    'image',
                  ]
            }
          });

          file_frame.on('select', function() {
            var selection = file_frame.state().get('selection');
      
            selection.map(function(a, i) {
              var attachment = a.toJSON();
              
              console.log(attachment);

              $('#bc_favicon_img').attr('src', attachment.url);
              $('#bc_favicon_options').val(attachment.id);
      
            });
          });
      
          
          file_frame.open();
    });
    
  


});