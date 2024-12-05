<?php
    namespace PET\sql;

    use PET;
    use Exception;
    use PET\Misc;
    use PET\ErrorHandler;
    use PET\sql\SqlFunctions;
    use PET\sql\SQLConnection;
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
    $sql = new SqlFunctions($pdo);
    if(!isset($_POST['form_data']))
    {
        return [false, "No form data present"];
    }

    $formData = json_decode(base64_decode($_POST['form_data']));



    if(isset($_POST['register']))
    {
        Register($formData, $sql);
    }
    else if(isset($_POST['login']))
    {
        Login($formData, $sql);
    }
    else if(isset($_POST['session']))
    {
        HandleSession($formData, $sql);
    }
    else if(isset($_POST['logout']))
    {
        Logout($formData, $sql);
    }
    else
    {
        return [false, ""];
    }


    function Register($formData, $sql)
    {
        $name = $formData->username;
        $pass = $formData->password;
        $mail = $formData->email;
        
        $reg_res = $sql->register($name, $mail, $pass);
        if($reg_res['status'] == "ERROR"){
            array_shift($reg_res);
            print("!!ERROR!!");
            foreach ($reg_res as $row) {
                print($row . "\r\n");
            }
            return [false, "User already exists!"];
        } else if($reg_res['status'] == "SUCCESS"){
            array_shift($reg_res);
            print("!!SUCCESS!!");
            foreach ($reg_res as $row) {
                print($row . " - Redirecting...");
            }
            return [true, "User created successfully!"];
        }
    }

    function Login($formData, $sql)
    {
        $name = $formData->username;
        $pass = $formData->password;

        $log_res = $sql->login($name, $pass);

        if($log_res['status'] == "ERROR"){
            print("!!ERROR!!Username or Password incorrect!");
            return [false, "User already exists!"];
        } else if($log_res['status'] == "SUCCESS"){
            array_shift($log_res);
            print("**$log_res[session]!!SUCCESS!!Logged in as $name");
            return [true, "User created successfully!"];
        }
    }

    function Logout($formData, $sql)
    {
        $name = $formData->username;
        $session = $formData->session;

        $log_res = $sql->closeRunningSession($name, $session);

        if($log_res['status'] == "ERROR"){
            print("ERROR");
            return [false, "Error while closing session!"];
        } else if($log_res['status'] == "SUCCESS"){
            array_shift($log_res);
            print("SUCCESS");
            return [true, "Session closed!"];
        }
    }

    function HandleSession($formData, $sql)
    {
        $name = $formData->username;
        $session = $formData->session;

        $log_res = $sql->getRunningSession($name, $session);
        if($log_res['status'] == 'SUCCESS')
        {
            print("SESSION OK");
        }
        else
        {
            print("SESSION ENDED");
        }
    }