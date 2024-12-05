function showMessage(type, message) {
    const messageContainer = document.getElementById('registration_message');
    messageContainer.style.display = 'block'; // Make the container visible
    messageContainer.className = 'message-container ' + type; // Add the appropriate class
    messageContainer.querySelector('.message-text').innerHTML = message; // Set the message text
}

function clearMessage() {
    const messageContainer = document.getElementById('registration_message');
    messageContainer.style.display = 'none'; // Make the container visible
    messageContainer.className = 'message-container '; // Add the appropriate class
}

async function getEncodedPassword(password){
    return await generateMD5Hash(btoa(password));
}

async function generateMD5Hash(input) {
    // Use CryptoJS for SHA-512 hashing
    const hash = CryptoJS.SHA512(input); 
    return hash.toString(CryptoJS.enc.Hex); // Convert to hex
}


// async function generateMD5Hash(input) {
//     const encoder = new TextEncoder();
//     const data = encoder.encode(input);

//     const hashBuffer = await crypto.subtle.digest('SHA-512', data);

//     const hashArray = Array.from(new Uint8Array(hashBuffer));
//     const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');
    
//     return hashHex;
// }

async function checkRegister()
{
    clearMessage();
    event.preventDefault();
    var errCount = 0;

    var rx_name = RegExp("^([a-zA-Z0-9_-]+)$");
    var rx_email = RegExp("^(?:(?!.*?[.]{2})[a-zA-Z0-9](?:[a-zA-Z0-9.+!%-]{1,64}|)|\"[a-zA-Z0-9.+!% -]{1,64}\")@[a-zA-Z0-9][a-zA-Z0-9.-]+(.[a-z]{2,}|.[0-9]{1,})$");

    var name  = document.getElementById("username").value.trim();
    var email = document.getElementById("email").value.trim();
    var pass1 = document.getElementById("password1").value;
    var pass2 = document.getElementById("password2").value;

    var message = "";

    // Username
    if(name == ""){ errCount++; message += "Username can not be left empty!\r\n"; }
    else if(name.length < 4){ errCount++; message += "Username must be at least 4 characters long!\r\n"; }
    if(!rx_name.exec(name) || rx_name.exec(name).length == 0){ errCount++; message += "Username can only contains letters numbers dashes and underlines!\r\n"; }

    // Email
    if(email == ""){ errCount++; message += "Email can not be left empty!\r\n"; }
    else if(!rx_email.exec(email) || rx_email.exec(email).length == 0){ errCount++; message += "Email not valid email address!\r\n"; }

    //Pass
    if(pass1 == "" || pass2 == ""){ errCount++; message += "Password can not be left empty!\r\n"; }
    else if(pass1.length < 4){ errCount++; message += "Password has to be at least 6 characters long!\r\n"; }
    if(pass1 !== pass2){ errCount++; message += "Passwords do not match!\r\n"; }

    
    if(errCount > 0){ console.log("ERROR"); showMessage('error', message); return; }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange= function() {
        if (this.readyState == 4 && this.status == 200) {
            var resp = this.responseText;
            if(resp.indexOf("!!ERROR!!") > -1){
                resp = resp.substring(9);
                showMessage('error', resp);
            }else if(resp.indexOf("!!SUCCESS!!") > -1){
                resp = resp.substring(11);
                showMessage('success', resp);
                window.setTimeout(()=>{ window.location = "login.php"; }, 1000);
            }
        }
    };

    var password = await getEncodedPassword(pass1);

    xhttp.open("POST", "./resources/sql/formcheck.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = JSON.stringify({username:name, email:email, password: password})
    console.log(btoa(data));
    xhttp.send("register=1&form_data=" + btoa(data));
}

async function checkLogin()
{
    clearMessage();
    event.preventDefault();
    var errCount = 0;

    var name  = document.getElementById("username").value.trim();
    var pass1 = document.getElementById("password").value;

    var message = "";

    // Username
    if(name == ""){ errCount++; message += "Username is empty!\r\n"; }

    //Pass
    if(pass1 == ""){ errCount++; message += "Password is empty!\r\n"; }
    
    if(errCount > 0){ console.log("ERROR"); showMessage('error', message); return; }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange= function() {
        if (this.readyState == 4 && this.status == 200) {
            var resp = this.responseText;
            if(resp.indexOf("!!ERROR!!") > -1){
                resp = resp.substring(9);
                showMessage('error', resp);
            }else if(resp.indexOf("!!SUCCESS!!") > -1){
                console.log(resp);
                if(resp.indexOf('**') == 0){
                    var hash = resp.substring(2, resp.indexOf("!!SUCCESS!!"));
                    console.log("HASH", hash);
                    window.localStorage.setItem("PET_username", name);
                    window.localStorage.setItem("PET_session_hash", hash);
                    window.localStorage.setItem("PET_session_start", new Date().getTime());
                }
                resp = resp.substring(resp.indexOf("!!SUCCESS!!") + 11);
                showMessage('success', resp);
                window.setTimeout(()=>{ window.location = "/pet/"; }, 1000);
            }
        }
    };

    var password = await getEncodedPassword(pass1);

    xhttp.open("POST", "./resources/sql/formcheck.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = JSON.stringify({username:name, password: password})
    xhttp.send("login=1&form_data=" + btoa(data));
}


function checkLocalStorage(){
    if(window.location.pathname != "/pet/login.php"){ return; }
    
    var name = window.localStorage.getItem('PET_username');
    var session = window.localStorage.getItem('PET_session_hash');

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange= function() {
        if (this.readyState == 4 && this.status == 200) {
            var resp = this.responseText;
            
            if(resp == "SESSION OK"){ window.location = "index.php"; }
        }
    };

    xhttp.open("POST", "./resources/sql/formcheck.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = JSON.stringify({username:name, session:session})
    xhttp.send("session=1&form_data=" + btoa(data));
}

function getLocalStorage(){
    var name = window.localStorage.getItem('PET_username');
    var session = window.localStorage.getItem('PET_session_hash');

    return {username:name, session:session};
}

window.addEventListener("load", checkLocalStorage());