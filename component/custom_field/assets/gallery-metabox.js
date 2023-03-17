jQuery(function($) {

  var file_frame;

  $(document).on('click', 'a.gallery-add', function(e) {
    e.preventDefault();
    var par = $(this).parent('td');
    var clone_htmlliimg = $('.cloneligallery',par).html();

    if (file_frame) file_frame.close();

    file_frame = wp.media.frames.file_frame = wp.media({
      title: $(this).data('uploader-title'),
      button: {
        text: $(this).data('uploader-button-text'),
      },
      multiple: 'add',
      library: {
              type: [ 'image' ]
      }
    });

    file_frame.on('select', function() {
      var selection = file_frame.state().get('selection');

      selection.map(function(a, i) {
        attachment = a.toJSON();
        
        htmlliimg = clone_htmlliimg .replace('_name', 'name');
        htmlliimg = htmlliimg.replace('_src', 'src');
        htmlliimg = htmlliimg.replace('attachment.id', attachment.id);
        if(attachment.sizes.thumbnail && attachment.sizes.thumbnail.url){
            htmlliimg = htmlliimg.replace('attachment.sizes.thumbnail.url', attachment.sizes.thumbnail.url);
        //console.log(htmlliimg);
            $('.gallery-metabox-list',par).append(htmlliimg);
        }else{
          alert('L\'immagine selezionata non è possibile ridimensionarla. Si prega di ricaricarla in questa pagina.');
        }


      });
    });

    makeSortable(par);
    
    file_frame.open();

  });

  $(document).on('click', 'a.change-image', function(e) {

    e.preventDefault();

    var that = $(this);

    if (file_frame) file_frame.close();

    file_frame = wp.media.frames.file_frame = wp.media({
      title: $(this).data('uploader-title'),
      button: {
        text: $(this).data('uploader-button-text'),
      },
      multiple: 'add'
    });

    file_frame.on( 'select', function() {
      attachment = file_frame.state().get('selection').first().toJSON();
        
      that.parent().find('input:hidden').attr('value', attachment.id);
        if(attachment.sizes.thumbnail && attachment.sizes.thumbnail.url){
            that.parent().find('img.image-preview').attr('src', attachment.sizes.thumbnail.url);
        }else{
            alert('L\'immagine selezionata non è possibile ridimensionarla. Si prega di ricaricarla in questa pagina.');
        }
    });

    file_frame.on('open',function(){
        var selection = file_frame.state().get('selection');
        var selected = that.parent().find('input:hidden').attr('value'); // the id of the image
        if (selected) {
            selection.add(wp.media.attachment(selected));
        }
    });
    file_frame.open();
  });

  

  function makeSortable(par) {
    $('.gallery-metabox-list',par).sortable({
      opacity: 0.6
    });
  }

  $(document).on('click', '.gallery-metabox-list a.remove-image', function(e) {
    e.preventDefault();
    $(this).parents('li').animate({ opacity: 0 }, 200, function() {
      $(this).remove();
    });
  });

  $('.gallery-metabox-list').each(function(i) {
    $('li', this).each(function(i) {
      var par = $(this).parents('td');
      makeSortable(par);
    });
  });


  

});