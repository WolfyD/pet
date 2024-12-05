async function getErrorPage(page){
    var filter = getFilter();
    var data = { 'page': page };
    if(filter){
        data.filter = filter;
    }
    const response = await sendRequestToBackend("errorPage",
                "./resources/sql/query_runner.php",
                "POST",
                "application/x-www-form-urlencoded",
                data);
    var errorCollection = [];
    var errorCollectionForTable = [];
    JSON.parse(response).forEach(item => {
        errorCollection.push(new petError(JSON.stringify(item)));
        errorCollectionForTable.push(new petErrorTableObject(JSON.stringify(item)));
    });

    return { ec: errorCollection, table_ec: errorCollectionForTable };
}

async function createTableFromErrorCollection(ecoll){

    var tables = await getAllIndexedTables();
    indexedUserList = tables.indexed.users;
    indexedErrorTypeList = tables.indexed.types;
    indexedErrorRelevanceList = tables.indexed.relevances;


    let etabm = document.getElementById("error_table_main");
    if(!etabm){ return ""; }

    var rows = [];
    Array.from(etabm.getElementsByTagName("tr")).forEach(row => {
        rows.push(row);
    });

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        row.parentNode.removeChild(row);
    }

    console.log("rows", rows);


    ecoll.forEach(element => {
        var row = document.createElement("tr");
        var td01 = document.createElement("td");
        var td02 = document.createElement("td");
        var td03 = document.createElement("td");
        var td04 = document.createElement("td");
        var td05 = document.createElement("td");
        var td06 = document.createElement("td");
        var td07 = document.createElement("td");
        var td08 = document.createElement("td");
        var td09 = document.createElement("td");
        var td10 = document.createElement("td");

        td04.style.paddingRight = "30px";
        td02.classList.add("filter_td");
        td03.classList.add("filter_td");
        td04.classList.add("filter_td");
        td06.classList.add("filter_td");
        td07.classList.add("filter_td");
        td08.classList.add("filter_td");

        var w = "";
        if(isThemeDark(theme)){
            w = "w_";
        }

        var diff = `<span style='cursor:pointer;' title='Difficulty: ${element.difficulty}/5'>`;
        for (let i = 0; i < 5; i++) {
            if(i < element.difficulty){
                diff += "★";
            }else{
                diff += "☆";
            }
        }
        diff += "</span>";

        var misc = `
            <img id=${generateButtonId(element.id, 'message')}" title="Read error message" class="list_img list_action_img" src="./resources/images/${w}message.png" alt="message" onclick="showSimplePopup('Message','${escape(element.message)}')" />
            <img id="${generateButtonId(element.id, 'notes')}" title="Read error notes" class="list_img list_action_img" src="./resources/images/${w}notes.png" alt="notes" onclick="showSimplePopup('Notes','${escape(element.notes)}')" />
            <img id="${generateButtonId(element.id, 'quickView')}" title="Quick view full error data" class="list_img list_action_img" src="./resources/images/${w}quick_view.png" alt="quick_view" />
            <img id="${generateButtonId(element.id, 'open')}" title="Open error on main viewer" class="list_img list_action_img" src="./resources/images/${w}open.png" alt="view" onclick="window.location = '/pet/index.php?id=' + ${element.id}" />
        `;

        var tags = "";
        if(element.fixed != 0){
            tags += "<span class='list_row_tag fixed'>fixed</span>";
        }

        if(element.confirmed_not_important != 0){
            tags += "<span class='list_row_tag unimportant'>not important</span>";
        }

        var relevance = indexedErrorRelevanceList.get(element.relevance_id).relevance;
        tags += `<span class='list_row_tag relevance rel_${relevance.toLowerCase()}'>${relevance}</span>`;
        
        /*ID*/          td01.innerHTML = element.id;
        /*Severity*/    td02.innerHTML = `<span class='filter_link'                                                     onclick='setSingleFilter("severity", this.innerText.toLowerCase())'>${element.severity.toProperCase()}</span>`;
        /*Type*/        td03.innerHTML = `<span class='filter_link'                                                     onclick='setSingleFilter("type", ${element.type_id})'>${indexedErrorTypeList.get(element.type_id).error_type}</span>`
        /*File*/        td04.innerHTML = `<span class='filter_link'                                                     onclick='setSingleFilter("file", this.innerText)'>${element.file_name + `<img title="Open ${element.file_name} at line #${element.line_from}" class="list_img list_action_img list_code_img" onclick="" src="./resources/images/${w}file.png" alt="file" />`}</span>`;
        /*Error*/       td05.innerHTML = `<a href="${element.link}" target="_blank" title="Open error page for error ${element.shortcode}" ><img class="list_img" src="./resources/images/${w}link.png" alt="link" />${element.shortcode}</a>`;
        /*Difficulty*/  td06.innerHTML = `<span class='filter_link'                                                     onclick='setSingleFilter("difficulty", ${element.difficulty})'>${diff}</span>`;
        /*Time*/        td07.innerHTML = `<img class="list_img" src="./resources/images/${w}clock.png" alt="clock" /><span  onclick="setSingleFilter('time', this.innerText)" class='filter_link'>${(element.estimated_duration ? (element.estimated_duration +'h') : ' - ')}</span>`;
        /*Assigned to*/ td08.innerHTML = `<span class='filter_link'                                                     onclick='setSingleFilter("user", ${element.user_id || null})'>${element.user_id ? indexedUserList.get(element.user_id).name : "Not assigned"}</span>`;
        /*Actions*/     td09.innerHTML = misc;
        /*Tags*/        td10.innerHTML = tags;
        

        td01.style.cursor = "pointer";
        td01.onclick = () => {
            window.location = "/pet/index.php?id=" + element.id;
        }

        row.appendChild(td01);
        row.appendChild(td02);
        row.appendChild(td03);
        row.appendChild(td04);
        row.appendChild(td05);
        row.appendChild(td06);
        row.appendChild(td07);
        row.appendChild(td08);
        row.appendChild(td09);
        row.appendChild(td10);

        etabm.appendChild(row);
    });
    return 1;
}

function generateButtonId(rowId, action){
    return `action_button_${rowId}__${action}`;
}

function setSingleFilter(name, value){
    var filter = [{ name: name, value: value}];
    setCookie('listFilter', `${JSON.stringify(filter)}`);
    getPage(window.listPage);
}

function getFilter(){
    var filterstr = getCookie("listFilter");
    var ret = null;
    if(filterstr){
        var fso = JSON.parse(filterstr);
        var O = { filter: fso };
        var s = JSON.stringify(O);
        ret = s;
    }
    return ret;
}

function getTextColor(backgroundColor) {
    var bgc = backgroundColor.replace("rgb(", "").replace(")", "");
    let [r,g,b] = bgc.split(',')

    // Calculate brightness
    let brightness = 0.2126 * r + 0.7152 * g + 0.0722 * b;

    // Return either black or white based on the brightness
    return brightness > 128 ? '#000000' : '#ffffff';
}

function handleTagTextColor(){
    document.querySelectorAll('.list_row_tag').forEach(cell => {
        const bgColor = window.getComputedStyle(cell).backgroundColor;
        cell.style.color = getTextColor(bgColor);
    });
}

async function getPage(page){
    var errors = await getErrorPage(page);
    createTableFromErrorCollection(errors.table_ec);
    setTimeout(()=>{
        handleTagTextColor();
    }, 1000);
}




// * Classes * ==========================================================================

/** Full error object containing all data */
class petError{
    constructor(json){
        var error                       = JSON.parse(json);
        this.id                         = error.id;
        this.severity                   = error.severity;
        this.line_from                  = error.line_from;
        this.line_to                    = error.line_to;
        this.type_id                    = error.type_id;
        this.message                    = error.message;
        this.file_name                  = error.file_name;
        this.file_path                  = error.file_path;
        this.snippet                    = error.snippet;
        this.selected_text              = error.selected_text;
        this.from_i                     = error.from_i;
        this.to_i                       = error.to_i;
        this.snippet_from               = error.snippet_from;
        this.snippet_to                 = error.snippet_to;
        this.column_from                = error.column_from;
        this.column_to                  = error.column_to;
        this.error_level                = error.error_level;
        this.shortcode                  = error.shortcode;
        this.link                       = error.link;
        this.taint_trace                = error.taint_trace;
        this.other_references           = error.other_references;
        this.relevance_id               = error.relevance_id;
        this.request_not_important      = error.request_not_important;
        this.confirmed_not_important    = error.confirmed_not_important;
        this.notes                      = error.notes;
        this.difficulty                 = error.difficulty;
        this.estimated_duration         = error.estimated_duration;
        this.fixed                      = error.fixed;
        this.user_id                    = error.user_id;
        this.deleted                    = error.deleted ;
    }
}

/** Smaller error object for table creation */
class petErrorTableObject{
    constructor(json){
        var error                       = JSON.parse(json);
        this.id                         = error.id;
        this.severity                   = error.severity;
        this.type_id                    = error.type_id;
        this.line_from                  = error.line_from;
        this.message                    = error.message;
        this.file_name                  = error.file_name;
        this.error_level                = error.error_level;
        this.shortcode                  = error.shortcode;
        this.link                       = error.link;
        this.relevance_id               = error.relevance_id;
        this.confirmed_not_important    = error.confirmed_not_important;
        this.notes                      = error.notes;
        this.difficulty                 = error.difficulty;
        this.estimated_duration         = error.estimated_duration;
        this.fixed                      = error.fixed;
        this.user_id                    = error.user_id;

        // -- Including the full error for reference
        this.petError                   = new petError(json);
    }
}