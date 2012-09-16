$(document).ready(function(){
    
})

function showError(err,clear_all) {
    if(clear_all != null){
        if(clear_all){
            clearMessage();
        }
        else{
            clearMessage("#errorDiv");
        }
    }
    else{
        clearMessage("#errorDiv");
    }
    
    $("#errorDiv").html(closeBtn() + unescape(err)).fadeIn("normal", function () {
        scrollTo(0, 0);
    });
}

function showInfo(inf,clear_all) {
    if(clear_all != null){
        if(clear_all){
            clearMessage();
        }
        else{
            clearMessage("#infoDiv");
        }
    }
    else{
        clearMessage("#infoDiv");
    }
    
    $("#infoDiv").html(closeBtn() + unescape(inf)).fadeIn("normal", function () {
        scrollTo(0, 0);
    });
}

function showWarn(warn,clear_all) {
    if(clear_all != null){
        if(clear_all){
            clearMessage();
        }
        else{
            clearMessage("#warnDiv");
        }
    }
    else{
        clearMessage("#warnDiv");
    }
    
    $("#warnDiv").html(closeBtn() + unescape(warn)).fadeIn("normal", function () {
        scrollTo(0, 0);
    });
}

function showSucc(succ,clear_all) {
    if(clear_all != null){
        if(clear_all){
            clearMessage();
        }
        else{
            clearMessage("#succDiv");
        }
    }
    else{
        clearMessage("#succDiv");
    }
    
    $("#succDiv").html(closeBtn() + unescape(succ)).fadeIn("normal", function () {
        scrollTo(0, 0);
    });
}

function showControlError(object,message) {
    $(object).parent().append("<span class=\"error\">" + message + "</span>");
}

function closeMe(object) {
    $(object).parent().fadeOut("normal");
}

function closeBtn() {
    return "<a href=\"javascript:void(0)\" onclick=\"javascript:closeMe(this);\"></a>";
}

function clearMessage(messagediv){
    if(messagediv != null){
        $(messagediv).hide();
    }
    else{
        $(".showInfo").hide();
    }
}

function clearFormErrors(formObj){
    if(formObj != null){
        $(".error",formObj).remove();
    }
    else{
        $(".error",document).remove();
    }    
}