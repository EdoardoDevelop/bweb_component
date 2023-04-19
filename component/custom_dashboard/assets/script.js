jQuery(function($){

        var cont_widget;
        var boxwidget;
        var adminmenu_a;
        var add_element_item_widget;
        var boxwidget_item_widget;
        var add_element_item_widget_select;
        var add_element_item_widget_text;
        var trash_dash;
        var item_widget_box_icons;
        var select_dashicons_dashicons;
        
        refresh_d();

        function refresh_d(){

            
            select_dashicons_dashicons = $( ".select_dashicons .dashicons" ).draggable({
                revert: true,
                revertDuration: 100,
                start: function( event, ui ) {
                    $( ".item_widget .box_icons" ).addClass('box_icons-state-accept');
                    $( "#adminmenu a.ui-draggable-handle, .form-table th, #trash_dash, #submit, .button_box_icon, #cont_n_col, #cont_bg_dash" ).addClass('d_opacity');
                },
                stop: function( event, ui ) {
                    $( ".item_widget .box_icons" ).removeClass('box_icons-state-accept');
                    $( "*" ).removeClass('d_opacity');
                }

            });
            cont_widget = $( "#cont_widget" ).sortable({
                revert: 100,
                tolerance: "pointer",
                placeholder: "ui-sortable-highlight",
                axis: "x",
                start: function(){
                    $( "#adminmenu a.ui-draggable-handle, .form-table th, #trash_dash, #submit, .button_box_icon, #cont_n_col, #select_dashicons, #cont_bg_dash" ).addClass('d_opacity');
                },
                stop: function(){
                    $( ".boxwidget:not(.ui-sortable-placeholder)" ).removeAttr('style');
                    $( "*" ).removeClass('d_opacity');
                }
            });
            boxwidget = $( ".boxwidget" ).sortable({
                revert: 100,
                tolerance: "pointer",
                placeholder: "ui-sortable-highlight",
                start: function(){
                    $( "#adminmenu a.ui-draggable-handle, .form-table th, #submit, .button_box_icon, #cont_n_col, #select_dashicons, #cont_bg_dash" ).addClass('d_opacity');
                },
                stop: function(){
                    $( ".item_widget:not(.ui-sortable-placeholder)" ).removeAttr('style');
                    $( "*" ).removeClass('d_opacity');
                }
            });
            boxwidget.disableSelection();
            adminmenu_a = $( "#adminmenu a" ).draggable({
                connectToSortable: boxwidget,
                helper: function(e) {
                    var icon = 'dashicons-open-folder';
                    //var classItem = $('.wp-menu-image',this).removeClass('wp-menu-image').removeClass('dashicons-before').attr('class');
                    var classItem = $('.wp-menu-image',this).attr('class');
                    if((classItem != undefined) && (!$('.wp-menu-image',this).hasClass('svg'))){
                        icon = classItem;
                    }
                    
                    return $('<div class="item_widget"><a href="'+$(this).attr('href')+'" ><span class="box_icons dashicons '+icon+'"></span>'+$(this).text()+'</a></div>');
                },
                revert: "invalid",
                stop: function( event, ui ) {
                    
                    $( "*" ).removeClass('d_opacity');
                    $( ".item_widget" ).draggable("instance");
                    refresh_d();
                    
                },
                start: function( event, ui ) {
                    $('.button_box_icon').focus();
                },
                drag:function( event, ui ) {
                    $( "#adminmenu a.ui-draggable-handle, .form-table th, #trash_dash, #submit, .button_box_icon, #cont_n_col, #select_dashicons, #cont_bg_dash" ).addClass('d_opacity');
                },
                
                
            });
            
            
            add_element_item_widget = $( ".add_element .item_widget" ).draggable({
                connectToSortable: boxwidget,
                revert: 'invalid',
                helper: 'clone',
                tolerance: "pointer",
                stop: function( event, ui ) {
                    $( "*" ).removeClass('d_opacity');
                    refresh_d();
                },
                start: function(){
                    $( "#adminmenu a.ui-draggable-handle, #submit, #trash_dash, .button_box_icon, #cont_n_col, #select_dashicons, #cont_bg_dash" ).addClass('d_opacity');
                }
            });
            add_element_item_widget_select = $( ".add_element .item_widget_select" ).draggable({
                connectToSortable: boxwidget,
                revert: 'invalid',
                helper: function(e) {
                    var type = $(this).attr('attr-type');
                    var id = $('#id'+type+' option:selected' ).val();
                    
                        var title = $('#id'+type+' option:selected' ).text();
                        return $('<div class="item_widget"><a href="post.php?post='+id+'&action=edit" ><span class="box_icons"></span>'+title+'</a></div></div>');
                    
                },
                stop: function( event, ui ) {
                    
                    $( "*" ).removeClass('d_opacity');
                    //$( ".item_widget:not(.ui-sortable-placeholder)" ).removeAttr('style');
                    $( ".item_widget" ).draggable("instance");
                    refresh_d();
                },
                start: function( event, ui){
                    var type = $(this).attr('attr-type');
                    var id = $('#id'+type+' option:selected' ).val();
                    if(id === undefined){
                        return false;
                    }
                    $( "#adminmenu a.ui-draggable-handle, #submit, #trash_dash, .button_box_icon, #cont_n_col, #select_dashicons, #cont_bg_dash" ).addClass('d_opacity');
                },
                tolerance: "pointer"
            });
            add_element_item_widget_text = $( ".add_element .item_widget_text" ).draggable({
                connectToSortable: boxwidget,
                revert: 'invalid',
                helper: function(e) {
                    var t = $('#input_widget_text').val();
                    
                    return $('<div class="item_widget">'+t+'</div>');
                },
                stop: function( event, ui ) {
                    $( "*" ).removeClass('d_opacity');
                    //$( ".item_widget:not(.ui-sortable-placeholder)" ).removeAttr('style');
                    $( ".item_widget" ).draggable("instance");
                    refresh_d();
                },
                start: function(){
                    $( "#adminmenu a.ui-draggable-handle, #submit, #trash_dash, .button_box_icon, #cont_n_col, #select_dashicons, #cont_bg_dash" ).addClass('d_opacity');
                },
                tolerance: "pointer"
            });
            trash_dash = $( "#trash_dash" ).droppable({
                accept: ".boxwidget .item_widget",
                classes: {
                    "ui-droppable-hover": "trash-state-active"
                },
                activeClass: "ui-state-hover",
                tolerance: "pointer",
                over: function( event, ui ) {
                    $( ui.helper ).addClass( "ui-state-highlight" )
                },
                out: function( event, ui ) {
                    $( ui.helper ).removeClass( "ui-state-highlight" )
                },
                drop: function( event, ui ) {
                    $(ui.helper).remove();
                    $( "*" ).removeClass('d_opacity');
                }
            });
            item_widget_box_icons = $( ".item_widget" ).droppable({
                accept: select_dashicons_dashicons,
                classes: {
                    "ui-droppable-hover": "box_icons-state-active"
                },
                helper: "clone",
                revert: "invalid",
                drop: function( event, ui ) {
                    //$(event.target).removeClass().addClass('box_icons').addClass('dashicons').addClass(ui.helper.attr('atr-class'));
                    if($('.box_icons',event.target).length){
                        $('.box_icons',event.target).remove();
                        $('a', event.target).prepend('<span class="box_icons dashicons '+ui.helper.attr('atr-class')+'">');
                        $( ".item_widget .dashicons" ).draggable("instance");
                    }
                    //$(ui.helper).remove();
                    
                }
            });
            var h_helper_boxwidget_item_widget = 0;
            var w_helper_boxwidget_item_widget = 0;
            boxwidget_item_widget = $( ".boxwidget .item_widget" ).draggable({
                connectToSortable: $( ".boxwidget" ),
                revert: 'invalid',
                tolerance: "pointer",
                start: function( event, ui ) {
                    
                    h_helper_boxwidget_item_widget = $(ui.helper).height();
                    w_helper_boxwidget_item_widget = $(ui.helper).width();
                    //$(ui.helper).css('position','absolute').css('height',$(ui.helper).height()).css('width',$(ui.helper).width());
                },
                drag: function( event, ui ) {
                    $(ui.helper).css('position','absolute').css('height',h_helper_boxwidget_item_widget).css('width',w_helper_boxwidget_item_widget);
                },
                stop: function( event, ui ) {
                    //$( ".item_widget:not(.ui-sortable-placeholder)" ).removeAttr('style');
                    $( ".item_widget" ).draggable("instance");
                },
            })

        }


        $('#form_dash').submit(function (e) { 

            $('#cont_widget')
                .removeClass('ui-sortable');
            $('#cont_widget *')
                .removeClass('ui-sortable')
                .removeClass('ui-sortable-handle')
                .removeClass('ui-draggable')
                .removeClass('ui-draggable-handle')
                .removeClass('ui-droppable')
                .removeClass('ui-droppable-handle')
                .removeClass('svg');

            var html = $.trim($('#cont_widget').html());
            //var obj_html = $.parseHTML($.trim($('#cont_widget').html()));
            //console.log(html);
            $('#html_dash').html(html);
            //obj_html.forEach(element => {
            //    console.log($(element).removeClass('ui-sortable').removeClass('ui-sortable-handle').removeClass('ui-draggable'));
            //});
            return true;
        });

        $(".boxwidget").delegate(".item_widget a","click", function(e){ 
            e.preventDefault(); 
        });

        $('.button_box_icon').click(function (e) { 
            e.preventDefault();
            if($('#select_dashicons').hasClass('open')){
                $('.button_box_icon').text('Apri icone');
                $('#select_dashicons').removeClass('open');
            }else{
                $('.button_box_icon').text('Chiudi icone');
                $('#select_dashicons').addClass('open');
            }
        });

        $( "#n_col" ).val($( ".boxwidget" ).length);

        $("#n_col").change(function (e) { 
            
            var v = $('#n_col').val();
            if($( ".boxwidget" ).length < v){
                $('#cont_widget').append('<div class="boxwidget"></div>');
                refresh_d();
            }else if($( ".boxwidget" ).length > v){
                if ($('#cont_widget .boxwidget:last-child').is(':empty')) {
                    $('#cont_widget .boxwidget:last-child').remove();
                }else{
                    var x = false;
                    $('#cont_widget .boxwidget').each(function (index, element) {
                        if ($(this).is(':empty')) {
                            $(this).remove();
                            x = true;
                        }
                    });
                    if(!x){
                        alert('Svuota almeno un box per rimuovere una colonna');
                        $( "#n_col" ).val($( ".boxwidget" ).length);
                    }
                }
            }
            boxwidget.sortable( "refresh" );
        });


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
              
              //console.log(attachment);

              $('#preview_dash_bg').attr('src', attachment.url);
              $('#id_dash_bg').val(attachment.id);
      
            });
          });
      
          
          file_frame.open();
    });
    $('.default_image_button').click(function(e) {
        e.preventDefault();
        $('#preview_dash_bg').attr('src', $(this).attr('attr-default'));
        $('#id_dash_bg').val('');

    });

});