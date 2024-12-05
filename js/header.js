function buttonPressed(button){
    switch(button){
        case 'logout': Logout();
            break;
        case 'list': jumpToPage('list');
            break;
        case '':
            break;
        case '':
            break;
        case '':
            break;
        case '':
            break;
        case '':
            break;
        
        default:
            break;
    }
}

async function Logout() {
    if (confirm("Are you sure you want to log out?")) {
        try {
            const data = getLocalStorage();
            const response = await sendRequestToBackend(
                "logout",
                "./resources/sql/formcheck.php",
                "POST",
                "application/x-www-form-urlencoded",
                data
            );

            console.log("Logout response:", response); // Log the response for debugging
            jumpToPage("login"); // Ensure this is called
            window.location.reload(); // Reload after the request completes
        } catch (error) {
            console.error("Logout failed:", error); // Handle errors
        }
    }
}



function getLocalStorage(){
    var name = window.localStorage.getItem('PET_username');
    var session = window.localStorage.getItem('PET_session_hash');

    return {username:name, session:session};
}

function jumpToPage(page) {
    window.location = `/pet/${page}.php`;
}

function fillUserName(){
    var ls = getLocalStorage();
    var un = document.getElementById("userName");
    if(un){
        un.innerText = ls.username;
    }
}