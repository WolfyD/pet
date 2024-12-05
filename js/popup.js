//TODO: do popup stuff

function showSimplePopup(title, message, button_text = 'close'){
    var sp = document.getElementById("simple_popup_container");
    sp.children[0].querySelector(".simple_popup_header").innerText = unescape(title);
    sp.children[0].querySelector(".simple_popup_body").innerText = unescape(message);
    sp.classList.add("visible_simple_popup_container");
}

function hideSimplePopup(){
    var sp = document.getElementById("simple_popup_container");
    if(sp.classList.contains("visible_simple_popup_container")){
        sp.classList.remove("visible_simple_popup_container");
    }
}