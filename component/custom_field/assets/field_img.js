jQuery(function($) {

    $(document).on('click', '.single_image_add', function(e) {
        e.preventDefault();
        var file_frame;
        if (file_frame) file_frame.close();
        id = $(this).data('id');

        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Immagine',
            button: {
            text: 'seleziona',
            },
            library: {
                    type: [ 'image' ]
            }
        });

        file_frame.on('select', function() {
            var selection = file_frame.state().get('selection');

            selection.map(function(a, i) {
                attachment = a.toJSON();
                
                $( '#img-preview-'+id ).attr( 'src',attachment.sizes.thumbnail.url );
                $( '#'+id ).val(attachment.id);
                $( '.single_image_add[data-id='+id+']').hide();
                $( '.single_image_del[data-id='+id+']').show();
                

            });
        });
        
        file_frame.open();

    });

    $(document).on('click', '.single_image_del', function(e) {
        e.preventDefault();
        id = $(this).data('id');
        $( '#img-preview-'+id ).attr( 'src','' );
        $( '#'+id ).val('');
        $( '.single_image_add[data-id='+id+']').show();
        $( '.single_image_del[data-id='+id+']').hide();

    });

}); 
