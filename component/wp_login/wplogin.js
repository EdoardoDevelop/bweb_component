jQuery(function($){

    $('#loginform').submit(function(e) {
        e.preventDefault();
        $('#loginform').addClass('loading_op');
        $('body').addClass('initloading');
        
        var form = this;
        setTimeout(function(){
            form.submit();
        },1000)
    })


});
