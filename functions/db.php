<?php
	class Db {
		public static function open() {
            $liveUrls = array('pwgen.rmtweb.co.uk');

            if(!in_array(strtolower($_SERVER['HTTP_HOST']), $liveUrls)) {
				//development server connection
				$server = 'localhost';
                //$server = 'mysql.isarc.co.uk';
				$username = 'root';
				$password = 'root';
				$defaultSchema = 'pwGen';
			} else {
				//live server connection
				$server = 'localhost';
				$username = 'pwgen';
				$password = 'pwgen';
				$defaultSchema = 'pwGen';
			}

			$link = new mysqli($server, $username, $password, $defaultSchema);

			if(mysqli_connect_errno()) {
				die('Connection to database failed - ' . mysqli_connect_errno());
			}

			return $link;
		}

		public static function close($link) {
			$link -> close();
		}

        public static function logError($error, $link) {
            $stmt = $link -> prepare("INSERT INTO ErrorLog (DateOfError, ErrorMessage) VALUE (?, ?)");
            $stmt -> bind_param('ss', date('Y-m-d'), $error);
            $stmt -> execute();
        }

        /***** Data Preparation Helpers *****/
		public static function prepareDate($date, $link) {
			$preparedDate = DateTime::createFromFormat('d/m/Y', $date);
      		return '\'' . $link -> real_escape_string($preparedDate -> format('Y-m-d')) . '\'';
		}

        public static function prepareTime($time, $link) {
            $preparedTime = date ('H:i',strtotime($time));
            return '\'' . $link -> real_escape_string($preparedTime) . '\'';
        }

        public static function prepareString($value, $link)
        {
            if (strlen($value) > 0) {
                $value = '\'' . $link -> real_escape_string($value) . '\'';
            } else {
                $value = 'NULL';
            }

            return $value;
        }

        public static function prepareInt($value)
        {
            if($value == "")
            {
                $value = 'NULL';
            }

            return $value;
        }
        /***** Data Preparation Helpers *****/


        /***** Data Preparation Helpers for Prepared Statements *****/
        public static function prepareDateForStmt($date) {

            if($date == "")
            {
                return null;
            }

                $preparedDate = DateTime::createFromFormat('d/m/Y', $date);
                return $preparedDate -> format('Y-m-d');



        }

        public static function prepareStringForStmt($string) {
            //Remove all html tags from the value.
            $string = strip_tags($string);

            //remove extra slashes characters
            $string = stripslashes($string);

            //Trim all leading and trailing whitespace.
            $string = trim($string);

            return (strlen($string) > 0 ? $string : null);
        }
        /***** Data Preparation Helpers for Prepared Statements *****/
	}
?>