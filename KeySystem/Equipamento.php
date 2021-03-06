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
        
        public function ReadEquipamento( $index = null, $nome = null, $filterByInUse = null )
        {
            $stmt = null;

            if( $index )
            {
                $stmt = $this->conn->prepare( "SELECT * FROM Equipamento WHERE CD_Equipamento = ? ORDER BY NM_Equipamento" );
                $stmt->bind_param( "i", $index );
            }
            else if( $nome )
            {
                $nome = "%".$nome."%";

                $stmt = $this->conn->prepare( "SELECT * FROM Equipamento WHERE NM_Equipamento LIKE ? ORDER BY NM_Equipamento" );
                $stmt->bind_param( "s", $nome );
            }
            else if( $filterByInUse )
                $stmt = $this->conn->prepare( "SELECT * FROM Equipamento WHERE CD_Equipamento NOT IN ( SELECT CD_Equipamento FROM RequisicaoEquipamento ) ORDER BY NM_Equipamento");
            else
                $stmt = $this->conn->prepare( "SELECT * FROM Equipamento ORDER BY NM_Equipamento" );
            
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
        
        public function UpdateEquipamento( $codigo, $parameters ) 
        {
            if( $this->conn )
            {
                $sql = "UPDATE Equipamento SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."',";

                $sql = substr( $sql, 0, strlen( $sql ) - 1 );

                $sql .= " WHERE CD_Equipamento = ".$codigo;

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
            $stmt = $this->conn->prepare( "DELETE FROM Equipamento WHERE CD_Equipamento = ?" );
            $stmt->bind_param( "i", $index );

            $return = ( $stmt->execute() == false ? false : true );
            
            $stmt->close();
            
            return $return;
        }
    }
?>