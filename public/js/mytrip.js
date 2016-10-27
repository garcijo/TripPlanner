function newItem() {
    $('.itemform').animate({opacity: "toggle"}, 500);
    $('.item-form').animate({height: "toggle", opacity: "toggle"}, 100);
}

$(document).ready(function(){
    document.getElementById('check').onchange = function() {
        if(this.checked==true){
            document.getElementById("price").disabled=false;
            document.getElementById("price").focus();
        }
        else{
            document.getElementById("price").disabled=true;
        }
    };

});
