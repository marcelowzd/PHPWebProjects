<?php
    class Equipamento
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }

        public function CreateEquipamento( $name )
        {
            $stmt = $this->conn->prepare( "INSERT INTO Equipamento VALUES (null, ? )" );
            $stmt->bind_param( "s", $name );
            
            $return = ( $stmt->execute() == false ? false : true );

            $stmt->close();

            return $return;
        }
        
        public function ReadEquipamento( $index = null, $nome = null )
        {
            $stmt = null;

            if( $index )
            {
                $stmt = $this->conn->prepare( "SELECT * FROM Equipamento WHERE CD_Equipamento = ?" );
                $stmt->bind_param( "i", $index );
            }
            else if( $nome )
            {
                $nome = "%".$nome."%";

                $stmt = $this->conn->prepare( "SELECT * FROM Equipamento WHERE NM_Equipamento LIKE ?" );
                $stmt->bind_param( "s", $nome );
            }
            else
                $stmt = $this->conn->prepare( "SELECT * FROM Equipamento" );
            
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
                        'CD_Equipamento' => $codigo,
                        'NM_Equipamento' => $nome,
                    );

                    $count++;
                }
            }

            $stmt->close();

            return $return;
        }
        
        public function UpdateEquipamento( $params = array() ) 
        {

        }

        public function DeleteEquipamento( $index )
        {
            $stmt = $this->conn->prepare( "DELETE FROM Equipamento WHERE CD_Equipamento = ?" );
            $stmt->bind_param( "i", $index );

            $return = ( $stmt->execute() == false ? false : true );
            
            $stmt->close();
            
            return $return;
        }
    }
?>