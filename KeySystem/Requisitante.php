<?php
    class Requisitante
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }

        public function CreateRequisitante( $name, $desc )
        {
            $stmt = $this->conn->prepare( "INSERT INTO Requisitante VALUES (null, ?, ? )" );
            $stmt->bind_param( "ss", $name, $desc );
            
            $return = ( $stmt->execute() == false ? false : true );

            $stmt->close();

            return $return;
        }
        
        public function ReadRequisitante( $index = null, $nome = null, $filterByInRoom = null )
        {
            $stmt = null;

            if( $index )
            {
                $stmt = $this->conn->prepare( "SELECT * FROM Requisitante WHERE CD_Requisitante = ? ORDER BY NM_Requisitante" );
                $stmt->bind_param( "i", $index );
            }
            else if( $nome )
            {
                $nome = "%".$nome."%";

                $stmt = $this->conn->prepare( "SELECT * FROM Requisitante WHERE NM_Requisitante LIKE ? ORDER BY NM_Requisitante" );
                $stmt->bind_param( "s", $nome );
            }
            else if( $filterByInRoom )
                $stmt = $this->conn->prepare( "SELECT * FROM Requisitante WHERE CD_Requisitante NOT IN ( SELECT CD_Requisitante FROM RequisicaoSala ) ORDER BY NM_Requisitante");
            else
                $stmt = $this->conn->prepare( "SELECT * FROM Requisitante ORDER BY NM_Requisitante" );
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($codigo, $nome, $descricao);

            $return = null;

            if( $stmt->num_rows() > 0 )
            {                
                $return = array();
                $count = 0;

                while( $stmt->fetch() )
                {
                    $return[$count] = array(
                        'CD_Requisitante' => $codigo,
                        'NM_Requisitante' => $nome,
                        'DS_Requisitante' => $descricao
                    );

                    $count++;
                }
            }

            $stmt->close();

            return $return;
        }
        
        public function UpdateRequisitante( $codigo, $parameters )
        {
            if( $this->conn )
            {
                $sql = "UPDATE Requisitante SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."',";

                $sql = substr( $sql, 0, strlen( $sql ) - 1 );

                $sql .= " WHERE CD_Requisitante = ".$codigo;

                if( mysqli_query( $this->conn, $sql ) )
                    return 1;
                else
                    echo mysqli_error( $this->conn );
            }
            else
                return 0;
        }

        public function DeleteRequisitante( $index )
        {
            $stmt = $this->conn->prepare( "DELETE FROM Requisitante WHERE CD_Requisitante = ?" );
            $stmt->bind_param( "i", $index );

            $return = ( $stmt->execute() == false ? false : true );
            
            $stmt->close();
            
            return $return;
        }
    }
?>