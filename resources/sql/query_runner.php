<?php
    namespace PET\sql;

    header('Content-Type: application/json');

    use PET;
    use Exception;
    use PET\Misc;
    use PET\ErrorHandler;
    use PET\sql\ErrorList;
    use PET\sql\SqlFunctions;
    use PET\sql\SQLConnection;
    require_once(__DIR__ . "/sql_functions.php");
    require_once(__DIR__ . "/error_list.php");
    require_once(__DIR__ . "/sql_functions.php");
    require_once(__DIR__ . "/connection.php");
    require_once(__DIR__ . "/../misc.php");
    //require_once(__DIR__ . "/../../init.php");

    $conn = new SQLConnection();

    $pdo = null;

    try{
        $pdo = $conn->createConnection();
    }catch(Exception $ex){
        ErrorHandler::displayErrorMessage("There was an issue while connecting to the database", "DB Error!");
    }
    
    if(!$pdo){ return [false, "Database error"]; }
    $sql = new ErrorList($pdo);
    $sql_f = new SqlFunctions($pdo);
    if(!isset($_POST['form_data']))
    {
        return [false, "No form data present"];
    }

    $formData = json_decode(base64_decode($_POST['form_data']));



    if(isset($_POST['errorPage']))
    {
        GetErrorPage($formData, $sql);
    }
    else if(isset($_POST['users']))
    {
        GetUserList($sql_f);
    }
    else if(isset($_POST['error_types']))
    {
        GetErrorTypeList($sql_f);
    }
    else if(isset($_POST['error_relevance']))
    {
        GetErrorRelevanceList($sql_f);
    }
    else
    {
        return [false, ""];
    }


    function GetErrorPage($formData, $sql)
    {
        $page = $formData->page;
        $q_res = null;
        if(isset($formData->filter))
        {
            $q_res = $sql->getFilteredErrorPage($page, $formData->filter);
        }
        else
        {
            $q_res = $sql->getErrorPage($page);
        }
        
        echo json_encode($q_res);
    }

    function GetUserList($sql)
    {
        $q_res = $sql->getUserList();

        echo json_encode($q_res);
    }

    function GetErrorTypeList($sql)
    {
        $q_res = $sql->getErrorTypes();

        echo json_encode($q_res);
    }

    function GetErrorRelevanceList($sql)
    {
        $q_res = $sql->getErrorRelevance();

        echo json_encode($q_res);
    }