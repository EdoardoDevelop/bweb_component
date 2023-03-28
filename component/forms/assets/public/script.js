function processContactSubmit(idform, nonce) {
    document.getElementById("bc_contactForm"+idform).classList.add("loading");
    var request = new XMLHttpRequest();
    request.open("POST", "<?php echo admin_url( 'admin-ajax.php?action=process_contact_form' )?>");
    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            document.getElementById("bc_contactForm_status"+idform).innerHTML = this.responseText;
            document.getElementById("bc_contactForm"+idform).classList.remove("loading");
        }
    };
    var contactForm = document.getElementById("bc_contactForm"+idform);
    var formData = new FormData(contactForm);
    formData.append( "security", nonce );
    formData.append( "idf", idform );
    request.send(formData);
    return false;
}

function refresh_captcha(idform){
    var refreshButton = document.getElementById("captcha_"+idform);
    
    refreshButton.src = 'captcha.php?' + Date.now();
    return false;
}

