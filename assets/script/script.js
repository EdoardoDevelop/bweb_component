jQuery(function($){

    $('.table_php_value :checkbox').change(function() {
        if (this.checked) {
            $('.table_php_value :text').removeAttr("disabled");
        }else{
            $('.table_php_value :text').attr("disabled","disabled");
        }
    })
});