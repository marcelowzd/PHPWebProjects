<?php
    class Crypt
    {
        /*public static function Encrypt( $password )
        {
            $mcrypt = mcrypt_module_open( 'rijndael-256', '', 'cbc', '' );

            $iv = mcrypt_create_iv( mcrypt_enc_get_iv_size( $mcrypt ), MCRYPT_DEV_RANDOM );
    
            $key = md5("cipsdf@t3c972");

            mcrypt_generic_init( $mcrypt, $key, $iv );

            $encrypted = mcrypt_generic( $mcrypt, $password );

            mcrypt_generic_deinit( $mcrypt );

            mcrypt_module_close( $mcrypt );

            return base64_encode( $encrypted );
        }*/

        /*public static function Encrypt( $password )
        {
            $key = 'cipsdf@t3c972';

            $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $password, MCRYPT_MODE_CBC, md5(md5($key)));
            //$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

            return base64_encode( $encrypted );
        }*/

        public static function Encrypt( $password )
        {
            $output = false;

            $encrypt_method = "AES-256-CBC";
            $secret_key = 'cipsdf@t3c972';
            $secret_iv = 'f@t3civcipsd';
            
            $key = hash('sha256', $secret_key);
            
            $iv = substr( hash( 'sha256', $secret_iv), 0, 16 );
            
            $output = openssl_encrypt($password, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);

            return $output;
        }
    }
?>