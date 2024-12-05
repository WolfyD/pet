this.currentData = {};
this.errorData = {};

function setErrorData(json){
    //console.log(json);
    errorData = JSON.parse(json)[0];
    currentData = JSON.parse(JSON.stringify(errorData));

    var state = "";
    if(currentData.fixed != 0){ state = "done"; }
    else if(currentData.relevance_id < 3){ state = "urgent"; }
    else if(currentData.relevance_id > 4){ state = "trivial"; }

    setId("ID: " + currentData.id);

    // * Set main form values

    if(state != ""){
        setStateValue(state);
    }
    setValue("field_severity", currentData.severity.toProperCase())
    if(currentData.line_from == currentData.line_to){
        setValue("field_line_from_to", currentData.line_from);
    }else{
        setValue("field_line_from_to", currentData.line_from + " - " + currentData.line_to);
    }
    setValue("field_type", currentData.type_id);
    setValue("field_message", currentData.message);
    setValue("field_file_name", currentData.file_name);
    setValue("field_snippet", currentData.snippet);
    setValue("field_error_level", currentData.error_level);
    setValue("field_taint_trace", currentData.taint_trace);
    setValue("field_other_references", currentData.other_references);
    setValue("field_relevance", currentData.relevance_id);

    // * Set sidebar values
    
    setValue("field_user", currentData.user_id || 0);
    setValue("notes", currentData.notes || "");
    setValue("estimate", currentData.estimated_duration || "");

    showDiff(currentData.difficulty);
}

function setValue(id, value){
    var element = document.getElementById(id);
    if(element){
        element.value = value;
    }
}
function setId(value){
    var id_span = document.getElementById("id_span");
    if(id_span){
        id_span.innerText = value;
    }
}
function setStateValue(value){
    var stateSpan = document.getElementById('state_marker');
    if(stateSpan){
        stateSpan.classList.add("state_wrapper_" + value);
        stateSpan.children[0].innerText = value.toProperCase();
    }
}

async function setDefaultLists(){
    var tables = await getAllIndexedTables();
    indexedUserList             = tables.unindexed.users;
    indexedErrorTypeList        = tables.unindexed.types;
    indexedErrorRelevanceList   = tables.unindexed.relevances;

    console.log(indexedErrorTypeList);

    indexedErrorTypeList.sort((a, b)=>{
        return a.error_type > b.error_type;
    })

    var types = document.getElementById("field_type");
    var users = document.getElementById("field_user");
    var rels = document.getElementById("field_relevance");

    indexedErrorTypeList.forEach(type => {
        var opt = document.createElement("option");
        opt.value = type.id;
        opt.innerText = type.error_type;
        types.appendChild(opt);
    });

    indexedUserList.forEach(user => {
        var opt = document.createElement("option");
        opt.value = user.id;
        opt.innerText = user.name;
        users.appendChild(opt);
    });

    indexedErrorRelevanceList.forEach(rel => {
        var opt = document.createElement("option");
        opt.value = rel.id;
        opt.innerText = rel.relevance;
        rels.appendChild(opt);
    });

    return tables;
}

function setDiff(diff){
    this.currentData.difficulty = parseInt(diff);
}

function showDiff(diff){
    this.currentDiff = parseInt(this.currentData.difficulty);
    var st1 = document.getElementById("difficulty_star_1");
    var st2 = document.getElementById("difficulty_star_2");
    var st3 = document.getElementById("difficulty_star_3");
    var st4 = document.getElementById("difficulty_star_4");
    var st5 = document.getElementById("difficulty_star_5");

    st2.innerHTML = 
    st3.innerHTML =
    st4.innerHTML =
    st5.innerHTML = "&#9734;";
    
    switch(parseInt(diff)){
        case 5: st5.innerHTML = "&#9733;"; 
        case 4: st4.innerHTML = "&#9733;"; 
        case 3: st3.innerHTML = "&#9733;"; 
        case 2: st2.innerHTML = "&#9733;"; 
        case 1: st1.innerHTML = "&#9733;"; break;
    }
}

function resetDiff(){
    showDiff(this.currentData.difficulty);
}