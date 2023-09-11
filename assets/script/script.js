jQuery(function($){

    $('.table_php_value :checkbox').change(function() {
        if (this.checked) {
            $('.table_php_value :text').removeAttr("disabled");
        }else{
            $('.table_php_value :text').attr("disabled","disabled");
        }
    })
    $('#filtermodule a').click(function (e) { 
        e.preventDefault();
        $filter = $(this).attr('href').replace(/#/g, "");
        $('.table_module .form-table tbody tr').each(function (index, element) {
            // element == this
            //console.log($('.data-tags',element).data('tags'));
            if(!$('.data-tags',this).data('tags').includes($filter) ){
                $(this).hide();
            }else{
                $(this).show();
            }
        });
        $('#filtermodule a').hide();
        $('.remove_filter').show();
        $(this).show();
    });
    $('.remove_filter').click(function (e) { 
        e.preventDefault();
        $('#filtermodule a').show();
        $('.table_module .form-table tbody tr').show();
        $(this).hide();
    });
 
});