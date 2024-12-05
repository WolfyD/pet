<?php
    namespace PET\sql;

    use PET\Misc;
    use DateTime;
    
    class SqlFunctions
    {
        public \PDO $pdo;

        function __construct(\PDO $pdo)
        {
            $this->pdo = $pdo;
            return $this;
        }

        /** Function that checks if all the necessary tables are available */
        function checkTables()
        {
            $tableCount = 8;
            $errors = [];
            $tableNames = ["pet_errors", "pet_error_relevance", "pet_error_types", "pet_notes", "pet_screenshots", "pet_users", "pet_user_sessions", "pet_user_settings"];

            $q = "SELECT table_name as name FROM `information_schema`.`tables` where table_name like '%pet_%';";

            $r = $this->pdo->query($q);

            foreach ($r as $result) {
                if(in_array($result['name'], $tableNames))
                {
                    $tableCount--;
                }else{
                    $errors[] = $result['name'];
                }
            }

            if($tableCount > 0){
                return [false, $errors];
            }else{
                return [true, []];
            }
        }

        /** Gets the users preferred theme from local storage. 
         * If that isn't available, it checks the DB. 
         * If user isn't logged in yet, it returns the default.  */
        function getUserTheme($user_id=0)
        {
            $id = 4;

            switch ($id) {
                case  1: return 'beige';
                case  2: return 'dracula';
                case  3: return 'solarized';
                case  4: return 'solarized_dark';
                case  5: return 'monokai';
                case  6: return 'gray';
                case  7: return 'red';
                case  8: return 'green';
                case  9: return 'brown';
                case 10: return 'blue';
                case 11: return 'dark';
                case 12: return 'christmas';
                case 13: return 'halloween';
                case 14: return 'pastel_orange';
                case 15: return 'warm_red';
                case 16: return 'dragon';
                
                default: return 'beige';
            }
            return "solarized_dark";
        }

        /** Log user in */
        function login($username, $pass)
        {
            $response = [];
            $p = $pass;

            $q = "SELECT 1 as user FROM pet_users WHERE username='$username' AND password='$p' AND deleted IS NULL;";
            $res = $this->pdo->query($q);

            if($a = $res->fetch()){
                $q_user_id = "SELECT id FROM pet_users WHERE username='$username' AND deleted IS NULL;";
                $uid_res = $this->pdo->query($q_user_id);
                $id = $uid_res->fetch(\PDO::FETCH_ASSOC)['id'];
                $dt = new DateTime();
                $hash = Misc::GenerateSessionHash($id, $dt->getTimestamp());
                $q_session = "INSERT INTO pet_user_sessions (`user_id`, `session`) values ($id, '$hash');";
                $this->pdo->query($q_session);
                $response['status'] = 'SUCCESS';
                $response['session'] = $hash;
            }else{
                $response['status'] = 'ERROR';
            }

            return $response;
        }

        /** Create new user */
        function register($un, $em, $pass)
        {
            $username = ($un);
            $email = ($em);

            $response = [];

            $p = $pass;
            // Check if username or password exists already
            $q0 = "SELECT count(id) FROM pet_users WHERE username='$username' OR email='$email';";
            $res = $this->pdo->query($q0);
            // If yes, display data
            if($res->fetchColumn() > 0)
            {
                $q1 = "SELECT username as name, email as email FROM pet_users WHERE username='$username' OR email='$email';";
                $res = $this->pdo->query($q1);
                foreach ($res as $row) {
                    $n = $row['name'];
                    $e = $row['email'];
                    $response['status'] = "ERROR";
                    if($username == $n){ $response[] = "A user with the name $n already exists!"; }
                    if($email == $e){ $response[] = "A user with the email address $e already exists!"; }
                }
            }
            // If no, add new user
            else
            {
                $q2 = "INSERT INTO pet_users (username, email, password) values ('$username', '$email', '$p');";
                $res = $this->pdo->query($q2);

                $this->createDefaultUserSetting($this->pdo->lastInsertId());
                
                $response['status'] = "SUCCESS";
                $response[] = "User $username created successfully!";
            }

            return $response;
        }

        function createDefaultUserSetting($user_id)
        {
            $q = "INSERT INTO pet_user_settings (`user_id`, `setting`, `value`) VALUES ";
            $q .= "($user_id, 'theme', 'beige'),";
            $q .= "($user_id, 'font_family', 'Arial, sans-serif'),";
            $q .= "($user_id, 'list_lines', '11'),";
            $q .= "($user_id, 'list_view', 'comfortable'),";
            $q .= "($user_id, 'font_scaling', 1);";

            $this->pdo->query($q);
        }

        function getRunningSession($username, $session)
        {
            $response = [];
            $q = "SELECT * FROM pet_user_sessions WHERE `session`='$session' AND user_id=(SELECT id FROM pet_users WHERE username='$username' LIMIT 1) AND closed IS NULL;";
            $res = $this->pdo->query($q);

            $res = $res->fetch(\PDO::FETCH_ASSOC);
            if(!$res){ return ['status'=>'ERROR', 'session'=>null]; }
            $ends = $res['ends'];
            $session_id = $res['id'];
            $dt = new DateTime();
            $endStamp = strtotime($ends);
            $nowStamp = $dt->getTimestamp();
            $isOver = $endStamp < $nowStamp;
            if(!$isOver)
            {
                $q1 = "UPDATE pet_user_sessions SET `last_updated`=NOW(), `ends`=(NOW() + INTERVAL 48 HOUR) WHERE `id`=$session_id;";
                $this->pdo->query($q1);
                $response = [
                    'status' => 'SUCCESS',
                    'session' => "$res[session]"
                ];
            }
            else
            {
                $q2 = "UPDATE pet_user_sessions SET `last_updated`=NOW(), `closed`=NOW() WHERE `id`=$session_id;";
                $this->pdo->query($q2);
                $response = [
                    'status' => 'ERROR',
                    'session' => null
                ];
            }

            $this->sessionCleanup();

            return $response;
        }

        function closeRunningSession($username, $session)
        {
            $response = ['status' => 'ERROR'];
            $q = "SELECT * FROM pet_user_sessions WHERE `session`='$session' AND user_id=(SELECT id FROM pet_users WHERE username='$username' LIMIT 1) AND closed IS NULL;";
            $res = $this->pdo->query($q);

            $res = $res->fetch(\PDO::FETCH_ASSOC);
            if(!$res){ return ['status'=>'ERROR', 'session'=>null]; }
            $session_id = $res['id'];
            
            $q_close = "UPDATE pet_user_sessions SET `last_updated`=NOW(), `closed`=NOW() WHERE `id`=$session_id;";
            $this->pdo->query($q_close);
            $response = [
                'status' => 'SUCCESS',
                'session' => null
            ];

            $this->sessionCleanup();

            return $response;
        }

        function sessionCleanup()
        {
            $dt = new DateTime();
            $nowStamp = $dt->getTimestamp();
            $q = "UPDATE pet_user_sessions SET closed=NOW()  WHERE UNIX_TIMESTAMP(`ends`) < '$nowStamp';";
            $this->pdo->query($q);
        }

        function getUserList(){
            $q = "SELECT id, username as name, email FROM pet_users";
            $res = $this->pdo->query($q);
            return $res->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        function getErrorTypes(){
            $q = "SELECT id, error_type, breaking FROM pet_error_types WHERE deleted IS NULL";
            $res = $this->pdo->query($q);
            return $res->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        function getErrorRelevance(){
            $q = "SELECT id, relevance FROM pet_error_relevance";
            $res = $this->pdo->query($q);
            return $res->fetchAll(\PDO::FETCH_ASSOC);
        }




    }