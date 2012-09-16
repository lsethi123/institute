function CheckLogin1(){
    var msg = "";
    
    if ($("#txtUser1").val().replace(/ /g, "") == "") {
        msg += "Please Enter Username<br />";
    }

    if ($("#txtPass1").val().replace(/ /g, "") == "") {
        msg += "Please Enter Password<br />";
    }

    if (msg == "") {
        return true;
    }
    else {
        showError(msg);
        //TO CLEAR ALL MESSAGES
        //showError(msg,true);
        return false;
    }
}