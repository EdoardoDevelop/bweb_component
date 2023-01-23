jQuery(function($) {

    $(document).on('click', 'a.allegato-add', function(e) {
      e.preventDefault();
      var par = $(this).parent('td');
      let file_frame = null;
      var clone_htmlliimg = $('.cloneliallegato',par).html();
  
      if (file_frame) file_frame.close();
      let button = $(this);
      file_frame = wp.media({
        title: button.data('uploader-title'),
        button: {
          text: button.data('uploader-button-text')
        },
        multiple: 'add',
        library: {
            type: [ 
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/excel',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.oasis.opendocument.text',
                'application/rtf',
                'application/vnd.rar',
                'application/zip',
                'application/x-7z-compressed',
                'text/plain'
              ]
        }
      }).on('select', function() {
        var selection = file_frame.state().get('selection');
        //button.prev().val(attachment[button.data('return')]);
        //$('#omni_name_allegato').html(attachment[button.data('return')]);
        selection.map(function(a, i) {
            
          let attachment = a.toJSON();
          htmlliimg = clone_htmlliimg .replace('_name', 'name');
        htmlliimg = htmlliimg.replace('attachment.url', attachment['url']);
        htmlliimg = htmlliimg.replace('attachment.filename', attachment['filename']);
        
          $('.allegato-metabox-list',par).append(htmlliimg);
        });
        
      });
  
      makeSortable(par);
      
      file_frame.open();
  
    });
    
  
    function makeSortable(par) {
      $('.allegato-metabox-list',par).sortable({
        opacity: 0.6
      });
    }
  
    $(document).on('click', '.allegato-metabox-list a.remove-allegato', function(e) {
      e.preventDefault();
      $(this).parents('li').animate({ opacity: 0 }, 200, function() {
        $(this).remove();
      });
    });
  
    $('.allegato-metabox-list').each(function(i) {
      $('li', this).each(function(i) {
        var par = $(this).parents('td');
        makeSortable(par);
      });
    });
  
  
    
  
  });