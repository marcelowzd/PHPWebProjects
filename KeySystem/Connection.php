<?php
    class Connection
    {
        private static $host = "localhost";
        private static $user = "root";
        private static $pswd = "root"; // Or root
        private static $dtbs = "DtbsChave";

        public static function Connect()
        {
            $conn = mysqli_connect( self::$host, self::$user, self::$pswd, self::$dtbs );

            date_default_timezone_set("Brazil/East");
            mysqli_set_charset( $conn, 'utf8' );

            if( $conn ) return $conn;
            else return mysqli_error( $conn );
        }
    }
?>