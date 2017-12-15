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
                $stmt = $this->conn->prepare( "SELECT * FROM Requisitante WHERE CD_Requisitante = ?" );
                $stmt->bind_param( "i", $index );
            }
            else if( $nome )
            {
                $nome = "%".$nome."%";

                $stmt = $this->conn->prepare( "SELECT * FROM Requisitante WHERE NM_Requisitante LIKE ?" );
                $stmt->bind_param( "s", $nome );
            }
            else if( $filterByInRoom )
                $stmt = $this->conn->prepare( "SELECT * FROM Requisitante WHERE CD_Requisitante NOT IN ( SELECT CD_Requisitante FROM RequisicaoSala )");
            else
                $stmt = $this->conn->prepare( "SELECT * FROM Requisitante" );
            
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
        
        public function UpdateRequisitante( $params = array() ) 
        {

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