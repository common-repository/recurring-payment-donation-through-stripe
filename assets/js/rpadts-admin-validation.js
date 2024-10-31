
function rpadts_showKeyField()
{
jQuery('.liveKeys').show();
jQuery('.testKeys').hide();
}

function rpadts_hiddenKeyField()
{
jQuery('.testKeys').show();
jQuery('.liveKeys').hide();
}

function rpadts_validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
 } 


 function rpadts_continueOrNot() {
    if(rpadts_validateEmail(document.getElementById('rpadts_email_receipt_sender_address').value)){
    return true;
    }else{ alert("email not valid"); return false;}
 }