jQuery(function($){

    $('.table_php_value :checkbox').change(function() {
        if (this.checked) {
            $('.table_php_value :text').removeAttr("disabled");
        }else{
            $('.table_php_value :text').attr("disabled","disabled");
        }
    })

    /*var tooltips = document.querySelectorAll('.c_descr');

    $('.table_module .form-table tbody tr').hover(function () {
            window.onmousemove = function (e) {
                var x = (e.clientX + 20) + 'px',
                    y = (e.clientY + 20) + 'px';
                for (var i = 0; i < tooltips.length; i++) {
                    tooltips[i].style.top = y;
                    tooltips[i].style.left = x;
                }
            };
            
        }, function () {
            window.onmousemove = function (e) { return false; }
        }
    );*/
    

});