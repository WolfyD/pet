if(!cookieExists("listFilter")){
    setCookie("listFilter", "[]");
}

function sendRequestToBackend(title = '', path = '.', method = "POST", contentType = "application/x-www-form-urlencoded", data={}) {
    return new Promise((resolve, reject) => {
        const xhttp = new XMLHttpRequest();

        console.log("DATA:", btoa(JSON.stringify(data)));

        xhttp.open(method, path, true);
        xhttp.setRequestHeader("Content-type", contentType);

        xhttp.timeout = 1000; // Set timeout
        xhttp.ontimeout = () => reject(new Error("Request timed out"));

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    resolve(this.responseText); // Return HTML content
                } else {
                    reject(new Error(`Request failed with status: ${this.status}`));
                }
            }
        };

        xhttp.send(title + "=1&form_data=" + btoa(JSON.stringify(data))); // Send the correctly formatted POST data
    });
}

function getCookie(name){
    var cookies = document.cookie.split(';');
    var ret = null;
    cookies.forEach(cookie => {
        if(cookie.split('=')[0].trim() == name){
            ret = cookie.split('=')[1];
        }
    });
    return ret;
}

function cookieExists(name){
    var cookies = document.cookie.split(';');
    var ret = false;
    cookies.forEach(cookie => {
        if(cookie.split('=')[0].trim() == name){
            ret = true;
        }
    });
    return ret;
}

function setCookie(name, value="", ttl=1, path='/'){
    var today = new Date();
    var tomorrow = new Date();
    tomorrow.setDate(today.getDate()+ttl);
    document.cookie = `${name}=${value}; expires=${tomorrow}; path=${path}`;
}

function isThemeDark(theme){
    switch (theme) {
        case "dracula":
        case "solarized_dark":
        case "solarized_dark":
        case "monokai":
        case "dark":
        case "dragon":
        case "halloween": return true;    
        default:return false;
    }
}

String.prototype.toProperCase = function () {
    return this.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
};

// ----------------------------------------------------------------

// -- Making sure dataInitialized is set once a day, 
// -- not pulling tables any more frequently than that
var di = localStorage.getItem("dataInitialized");
var da = null;
var d = Date.now();
if(di){ da = new Date(di * 1000).valueOf() / 1000; }

if (!da || (da + 86400000) < d) {
    // Function to initialize IndexedDB
    function initIDB() {
        return new Promise((resolve, reject) => {
            const request = window.indexedDB.open("pet_localStorage", 2); // Ensure correct version
            let iDB = null;

            // Handle errors
            request.onerror = (event) => {
                console.error("Couldn't initiate IndexedDB:", event.target.error?.message);
                reject(event.target.error);
            };

            // Handle upgrade logic
            request.onupgradeneeded = (event) => {
                const db = event.target.result;

                if (!db.objectStoreNames.contains("users")) {
                    // User table
                    const os_users = db.createObjectStore("users", { keyPath: "id" });
                    os_users.createIndex("name", "name", { unique: false });
                    os_users.createIndex("email", "email", { unique: true });

                    // Error types table
                    const os_etype = db.createObjectStore("error_types", { keyPath: "id" });
                    os_etype.createIndex("error_type", "error_type", { unique: true });
                    os_etype.createIndex("breaking", "breaking", { unique: false });

                    // Error relevance table
                    const os_erel = db.createObjectStore("error_relevance", { keyPath: "id" });
                    os_erel.createIndex("relevance", "relevance", { unique: true });
                }
                console.log("Database structure initialized.");
            };

            // Handle success
            request.onsuccess = (event) => {
                localStorage.setItem("dataInitialized", Date.now());
                iDB = event.target.result;
                console.log("IndexedDB initialized.");
                resolve(iDB); // Resolve the promise with the database instance
            };
        });
    }

    // Function to initialize data
    async function init() {
        try {
            // Ensure the database is ready before proceeding
            const iDB = await initIDB();

            // ---- USER TABLE
            const users = await sendRequestToBackend(
                "users",
                "./resources/sql/query_runner.php",
                "POST",
                "application/x-www-form-urlencoded",
                {}
            ).then(res => res);

            JSON.parse(users).forEach(user => {
                const dbTransaction = iDB.transaction("users", "readwrite");
                const store = dbTransaction.objectStore("users");
                store.put(user);
            });
            console.log("User data successfully stored in IndexedDB.");

            
            // ---- ERROR TYPE TABLE
            const etypes = await sendRequestToBackend(
                "error_types",
                "./resources/sql/query_runner.php",
                "POST",
                "application/x-www-form-urlencoded",
                {}
            ).then(res => res);
            
            JSON.parse(etypes).forEach(etype => {
                const dbTransaction = iDB.transaction("error_types", "readwrite");
                const store = dbTransaction.objectStore("error_types");
                store.put(etype);
            });
            console.log("Error type data successfully stored in IndexedDB.");
            
            
            // ---- ERROR TYPE TABLE
            const erels = await sendRequestToBackend(
                "error_relevance",
                "./resources/sql/query_runner.php",
                "POST",
                "application/x-www-form-urlencoded",
                {}
            ).then(res => res);
            
            JSON.parse(erels).forEach(erel => {
                const dbTransaction = iDB.transaction("error_relevance", "readwrite");
                const store = dbTransaction.objectStore("error_relevance");
                store.put(erel);
            });
            console.log("Error relevance data successfully stored in IndexedDB.");

        } catch (error) {
            console.error("Initialization error:", error);
        }
    }

    // Run initialization
    init();
}

function fetchAllUsers() {
    return new Promise((resolve, reject) => {
        const request = window.indexedDB.open("pet_localStorage");

        request.onerror = (event) => {
            console.error("Error opening IndexedDB:", event.target.error?.message);
            reject(event.target.error);
        };

        request.onsuccess = (event) => {
            const db = event.target.result;

            // Open a transaction on the 'users' object store
            const transaction = db.transaction("users", "readonly");
            const store = transaction.objectStore("users");

            // Use getAll() to fetch all records
            const getAllRequest = store.getAll();

            getAllRequest.onsuccess = () => {
                console.log("Fetched data from IndexedDB:", getAllRequest.result);
                resolve(getAllRequest.result); // Resolve with the fetched data
            };

            getAllRequest.onerror = (event) => {
                console.error("Error fetching data from IndexedDB:", event.target.error?.message);
                reject(event.target.error);
            };
        };
    });
}

function fetchAllErrorTypes() {
    return new Promise((resolve, reject) => {
        const request = window.indexedDB.open("pet_localStorage");

        request.onerror = (event) => {
            console.error("Error opening IndexedDB:", event.target.error?.message);
            reject(event.target.error);
        };

        request.onsuccess = (event) => {
            const db = event.target.result;

            // Open a transaction on the 'users' object store
            const transaction = db.transaction("error_types", "readonly");
            const store = transaction.objectStore("error_types");

            // Use getAll() to fetch all records
            const getAllRequest = store.getAll();

            getAllRequest.onsuccess = () => {
                console.log("Fetched data from IndexedDB:", getAllRequest.result);
                resolve(getAllRequest.result); // Resolve with the fetched data
            };

            getAllRequest.onerror = (event) => {
                console.error("Error fetching data from IndexedDB:", event.target.error?.message);
                reject(event.target.error);
            };
        };
    });
}

function fetchAllErrorRelevance() {
    return new Promise((resolve, reject) => {
        const request = window.indexedDB.open("pet_localStorage");

        request.onerror = (event) => {
            console.error("Error opening IndexedDB:", event.target.error?.message);
            reject(event.target.error);
        };

        request.onsuccess = (event) => {
            const db = event.target.result;

            // Open a transaction on the 'users' object store
            const transaction = db.transaction("error_relevance", "readonly");
            const store = transaction.objectStore("error_relevance");

            // Use getAll() to fetch all records
            const getAllRequest = store.getAll();

            getAllRequest.onsuccess = () => {
                console.log("Fetched data from IndexedDB:", getAllRequest.result);
                resolve(getAllRequest.result); // Resolve with the fetched data
            };

            getAllRequest.onerror = (event) => {
                console.error("Error fetching data from IndexedDB:", event.target.error?.message);
                reject(event.target.error);
            };
        };
    });
}


async function getAllIndexedTables(){
    var userList = await fetchAllUsers();
    var errorTypeList = await fetchAllErrorTypes();
    var errorRelevanceList = await fetchAllErrorRelevance();

    var indexedUserList = new Map();
    userList.forEach(user => {
        indexedUserList.set(user.id, user);
    });

    var indexedErrorTypeList = new Map();
    errorTypeList.forEach(error_type => {
        indexedErrorTypeList.set(error_type.id, error_type);
    });

    var indexedErrorRelevanceList = new Map();
    errorRelevanceList.forEach(error_relevance => {
        indexedErrorRelevanceList.set(error_relevance.id, error_relevance);
    });

    return {unindexed:  {users: userList, types: errorTypeList, relevances: errorRelevanceList},
            indexed:    {users: indexedUserList, types: indexedErrorTypeList, relevances: indexedErrorRelevanceList}};
}