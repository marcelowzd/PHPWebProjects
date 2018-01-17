<?php
    class Chave
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }

        public function CreateChave( $name )
        {
            $stmt = $this->conn->prepare( "INSERT INTO Chave VALUES (null, ? )" );
            $stmt->bind_param( "s", $name );
            
            $return = ( $stmt->execute() == false ? false : true );

            $stmt->close();

            return $return;
        }
        
        public function ReadChave( $index = null, $nome = null, $filterByInUse = null )
        {
            $stmt = null;

            if( $index )
            {
                $stmt = $this->conn->prepare( "SELECT * FROM Chave WHERE CD_Chave = ?" );
                $stmt->bind_param( "i", $index );
            }
            else if( $nome )
            {
                $nome = "%".$nome."%";

                $stmt = $this->conn->prepare( "SELECT * FROM Chave WHERE NM_Chave LIKE ?" );
                $stmt->bind_param( "s", $nome );
            }
            else if($filterByInUse)
                $stmt = $this->conn->prepare( "SELECT * FROM Chave WHERE CD_Chave NOT IN (SELECT CD_Chave FROM RequisicaoSala)" );
            else
                $stmt = $this->conn->prepare( "SELECT * FROM Chave" );
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($codigo, $nome);

            $return = null;

            if( $stmt->num_rows() > 0 )
            {                
                $return = array();
                $count = 0;

                while( $stmt->fetch() )
                {
                    $return[$count] = array(
                        'CD_Chave' => $codigo,
                        'NM_Chave' => $nome,
                    );

                    $count++;
                }
            }

            $stmt->close();

            return $return;
        }
        
        public function UpdateChave( $codigo, $parameters ) 
        {
            if( $this->conn )
            {
                $sql = "UPDATE Chave SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."',";

                $sql = substr( $sql, 0, strlen( $sql ) - 1 );

                $sql .= " WHERE CD_Chave = ".$codigo;

                if( mysqli_query( $this->conn, $sql ) )
                    return 1;
                else
                    echo mysqli_error( $this->conn );
            }
            else
                return 0;
        }

        public function DeleteChave( $index )
        {
            $stmt = $this->conn->prepare( "DELETE FROM Chave WHERE CD_Chave = ?" );
            $stmt->bind_param( "i", $index );

            $return = ( $stmt->execute() == false ? false : true );
            
            $stmt->close();
            
            return $return;
        }
    }
?>