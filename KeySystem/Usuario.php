<?php

    class Usuario
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }

        public function CreateUsuario( $nome, $login, $senha, $email, $acesso )
        {
            $stmt = $this->conn->prepare( "INSERT INTO Usuario VALUES (null, ?, ?, ?, ?, ?)" );
            $stmt->bind_param( "sssss", $nome, $login, $senha, $email, $acesso );
            
            $return = ( $stmt->execute() == false ? false : true );

            $stmt->close();

            return $return;
        }

        public function ReadUsuario( $index = null, $nome = null, $email = null )
        {
            $stmt = null;

            if( $index )
            {
                $stmt = $this->conn->prepare( "SELECT * FROM Usuario WHERE CD_Usuario = ?" );
                $stmt->bind_param( "i", $index );
            }
            else if( $nome )
            {
                $nome = "%".$nome."%";

                $stmt = $this->conn->prepare( "SELECT * FROM Usuario WHERE NM_Usuario LIKE ?" );
                $stmt->bind_param( "s", $nome );
            }
            else if( $email )
            {
                $nome = "%".$nome."%";

                $stmt = $this->conn->prepare( "SELECT * FROM Usuario WHERE DS_Email_Usuario LIKE ?" );
                $stmt->bind_param( "s", $email );
            }
            else
                $stmt = $this->conn->prepare( "SELECT * FROM Usuario" );
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($codigo, $nome, $email, $login, $senha, $acesso);

            $return = null;

            if( $stmt->num_rows() > 0 )
            {                
                $return = array();
                $count = 0;

                while( $stmt->fetch() )
                {
                    $return[$count] = array(
                        'CD_Usuario' => $codigo,
                        'NM_Usuario' => $nome,
                        'DS_Email_Usuario' => $email,
                        'DS_Login_Usuario' => $login,
                        'DS_Senha_Usuario' => $senha,
                        'DS_Acesso_Usuario' => $acesso
                    );

                    $count++;
                }
            }

            $stmt->close();

            return $return;
        }
        
        public function UpdateUsuario( $codigo, $parameters ) 
        {
            if( $this->conn )
            {
                $sql = "UPDATE Usuario SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."',";

                $sql = substr( $sql, 0, strlen( $sql ) - 1 );

                $sql .= " WHERE CD_Usuario = ".$codigo;

                if( mysqli_query( $this->conn, $sql ) )
                    return 1;
                else
                    echo mysqli_error( $this->conn );
            }
            else
                return 0;
        }

        public function DeleteEquipamento( $index )
        {
            $stmt = $this->conn->prepare( "DELETE FROM Usuario WHERE CD_Usuario = ?" );
            $stmt->bind_param( "i", $index );

            $return = ( $stmt->execute() == false ? false : true );
            
            $stmt->close();
            
            return $return;
        }

        public function Login( $login, $senha )
        {
            $stmt = $this->conn->prepare( "SELECT NM_Usuario, DS_Acesso_Usuario FROM Usuario WHERE DS_Login_Usuario = ? AND DS_Senha_Usuario = ?" );
            $stmt->bind_param( "ss", $login, $senha );

            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($nome, $acesso);

            $return = 0;

            if( $stmt->num_rows() > 0 )
            {
                while( $stmt->fetch() )
                {
                    $_SESSION['NM_Usuario'] = $nome;
                    $_SESSION['DS_Acesso_Usuario'] = $acesso;
                }

                $return = 1;
            }

            return $return;
        }

        public function Logout( )
        {
            if( $this->conn )
            {
                $_SESSION['NM_Usuario'] = null;
                $_SESSION['DS_Acesso_Usuario'] = null;

                return 1;
            }
        }

        public function getUserAccess()
        {
            return ( isset( $_SESSION['DS_Acesso_Usuario'] ) ? $_SESSION['DS_Acesso_Usuario'] : "Offline" );
        }
    }

?>