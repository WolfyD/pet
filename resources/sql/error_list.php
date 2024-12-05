<?php
    namespace PET\sql;

    use PET\Misc;
    use DateTime;
    use PET\ErrorHandler;

    require_once(__DIR__ . "/../misc.php");
    require_once(__DIR__ . "/../error.php");
    
    class ErrorList
    {
        public \PDO $pdo;

        function __construct(\PDO $pdo)
        {
            $this->pdo = $pdo;
            return $this;
        }


        /** Gets a single error from the DB */
        function getErrorById($id)
        {
            $q = "SELECT * FROM pet_errors WHERE id=$id AND deleted IS NULL;";

            $r = $this->pdo->query($q);

            $res = $r->fetchAll(\PDO::FETCH_ASSOC);

            if(count($res) == 0){
                $q = "SELECT max(id) as max FROM pet_errors WHERE deleted IS NULL;";

                $r = $this->pdo->query($q);

                $maxId = $r->fetchColumn(0);

                if($id > $maxId){
                    $q = "SELECT * FROM pet_errors WHERE id=$maxId AND deleted IS NULL;";

                    $r = $this->pdo->query($q);

                    $res = $r->fetchAll(\PDO::FETCH_ASSOC);
                }
            }

            if($this->pdo->errorCode() && $this->pdo->errorCode() > 0)
            {
                ErrorHandler::displayErrorMessage("Database error!", "Error while running query. Error code: " . $this->pdo->errorCode() . " Error message: " . $this->pdo->errorInfo() . " QueryString: $q");
                return;
            }

            return json_encode($res);
        }

        /** Gets a page of error data from the DB */
        function getErrorPage($page)
        {
            $count = LIST_ROW_COUNT;
            $offset = ($page - 1) * $count;
            $q = "SELECT * FROM pet_errors LIMIT $count OFFSET $offset;";

            $r = $this->pdo->query($q);

            if($this->pdo->errorCode() && $this->pdo->errorCode() > 0)
            {
                ErrorHandler::displayErrorMessage("Database error!", "Error while running query. Error code: " . $this->pdo->errorCode() . " Error message: " . $this->pdo->errorInfo() . " QueryString: $q");
                return;
            }

            return $r->fetchAll(\PDO::FETCH_ASSOC);
        }

        private function getFilterString($filter_json){
            $filter_string = " WHERE ";
            $filter_array = json_decode($filter_json);
            $l = count($filter_array->filter);
            $i = 0;
            foreach ($filter_array->filter as $key=>$filter) {
                $vis = false;
                $n = $filter->name;
                $v = $filter->value;
                $tmp = "";

                switch($n){
                    case "severity":    $tmp = "severity";              $vis = true;    break;
                    case "type":        $tmp = "type_id";               $vis = false;   break;
                    case "file":        $tmp = "file_name";             $vis = true;    break;
                    case "difficulty":  $tmp = "difficulty";            $vis = false;   break;
                    case "time":        $tmp = "estimated_duration";    $vis = true;    break;
                    case "user":        $tmp = "user_id";               $vis = false; $v = ($v == "" ? "NULL" : $v);  break;
                    //case "": $tmp = ""; $vis = true; break;
                }

                if($v == "NULL"){
                    $tmp .= " IS NULL";
                }else{
                    $tmp .= "=" . ($vis ? "'$v'" : $v);
                }

                $filter_string .= " $tmp ";

                if($l < $i){
                    $filter_string .= " AND ";
                }

                $i++;
            }

            if($filter_string == " WHERE "){ $filter_string = ""; }

            return $filter_string;
        }

        function getFilteredErrorPage($page, $filter_json)
        {
            $filter_string = $this->getFilterString($filter_json);

            //var_dump($filter_string); die();

            $count = LIST_ROW_COUNT;
            $offset = ($page - 1) * $count;
            $q = "SELECT * FROM pet_errors $filter_string LIMIT $count OFFSET $offset;";

            $r = $this->pdo->query($q);

            if($this->pdo->errorCode() && $this->pdo->errorCode() > 0)
            {
                ErrorHandler::displayErrorMessage("Database error!", "Error while running query. Error code: " . $this->pdo->errorCode() . " Error message: " . $this->pdo->errorInfo() . " QueryString: $q");
                return;
            }

            return $r->fetchAll(\PDO::FETCH_ASSOC);
        }




    }