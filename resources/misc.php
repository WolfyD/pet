<?php
    namespace PET;

    class Misc
    {
        public static function GenerateSessionHash($user_id, $date) : string {
            $hashBase = json_encode(['name'=>'PETSession', 'user'=>$user_id, 'timestamp'=>$date, 'length'=>'2 days']);
            $padding = Misc::GenerateRandomPadding();
            $hashBase = str_replace("|", $hashBase, $padding);
            $tmp = trim(base64_encode($hashBase), "=");
            $tmp1 = substr($tmp, 0, 1);
            $tmp2 = substr($tmp, 1);
            $fixed = $tmp2 . $tmp1;
            return $fixed;
        }

        private static function GenerateRandomPadding()
        {
            $paddingChars = ['_', '-', '*', '~', '=', '^', '°', '+'];
            $len = rand(3, 7);
            $starting = "";
            $trailing = "";
            $charLen = count($paddingChars);
            for($i = 0; $i < $len; $i++){
                $c = $paddingChars[rand(0, $charLen - 1)];
                $starting .= $c;
                $trailing = $c . $trailing;
            }

            return $starting."•|•".$trailing;
        }
    }