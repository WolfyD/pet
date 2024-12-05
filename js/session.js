function checkLocalStorage(){
    var name = window.localStorage.getItem('PET_username');
    var session = window.localStorage.getItem('PET_session_hash');

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange= function() {
        if (this.readyState == 4 && this.status == 200) {
            var resp = this.responseText;
            
            if(resp == "SESSION ENDED"){ window.location = "login.php"; }
        }
    };

    xhttp.open("POST", "./resources/sql/formcheck.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = JSON.stringify({username:name, session:session})
    xhttp.send("session=1&form_data=" + btoa(data));
}

window.addEventListener("load", checkLocalStorage());