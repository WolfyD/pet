<?php
    
    namespace PET;
    
    use Exception;
    use PET\sql\SQLConnection;
    use PET\sql\SqlFunctions;
    use PET\ErrorHandler;
    
    require_once __DIR__ . '/autoload.php';
    require_once __DIR__ . '/resources/sql/connection.php';
    require_once __DIR__ . '/resources/sql/sql_functions.php';
    require_once __DIR__ . '/resources/settings/styles.php';
    require_once __DIR__ . '/resources/error.php';
    $conn = new SQLConnection();

    $pdo = null;

    try{
        $pdo = $conn->createConnection();
    }catch(Exception $ex){
        ErrorHandler::displayErrorMessage("There was an issue while connecting to the database<br />[" . $ex->getMessage() . "]", "DB Error!");
    }

    $sql = new SqlFunctions($pdo);


    $res = $sql->checkTables();

    if(!$res[0])
    {
        $error_string = "";
        foreach ($res[1] as $table) {
            $error_string .= "Missing table [$table] !<br />";
        }
        $error_string = trim($error_string);
        ErrorHandler::displayErrorMessage($error_string, "DB Error, tables not found!");
    }
    if(isset($_GET['theme'])){
        $theme = $_GET['theme'];
    }else{
        $theme = $sql->getUserTheme() ?? "beige";
    }
    