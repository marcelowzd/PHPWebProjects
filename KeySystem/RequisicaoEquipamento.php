<?php
    class RequisicaoEquipamento
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }

        public function CreateRequisicaoEquipamento( $idEquipment, $idRequester, $dtComplete, $dtHour )
        {
            $stmt = $this->conn->prepare( "INSERT INTO RequisicaoEquipamento VALUES (null, ?, ?, ?, ? )" );
            $stmt->bind_param( "iiss", $idEquipment, $idRequester, $dtComplete, $dtHour );
            
            $return = ( $stmt->execute() == false ? false : true );

            $stmt->close();

            return $return;
        }

        public function ReadRequisicaoEquipamento( $id = null, $idRequester = null, $idEquipment = null)
        {
            $sql = "SELECT RE.CD_Requisicao_Equipamento, E.NM_Equipamento, R.CD_Requisitante, 
            R.NM_Requisitante, RE.DT_Completa, RE.DT_Horario, E.CD_Equipamento
            FROM RequisicaoEquipamento RE
            JOIN Equipamento E ON( RE.CD_Equipamento = E.CD_Equipamento )
            JOIN Requisitante R ON( R.CD_Requisitante = RE.CD_Requisitante ) ";

            if( $id )
                $sql .= "WHERE CD_Requisicao_Equipamento = $id";
            else if( $idRequester )
                $sql .= "WHERE CD_Requisitante = $idRequester";
            else if( $idEquipment )
                $sql .= "WHERE CD_Equipamento = $idEquipment";
            else
                $sql .= "WHERE CD_Requisicao_Equipamento > 0";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result
                            (
                                $idRequisicaoEquipamento, $nmequipamento, 
                                $idrequisitante, $nmrequisitante, 
                                $dtcompleta, $dthorario, $idequipamento 
                            );
            
            $return = null;

            if($stmt->num_rows() > 0)
            {
                $return = array();
                $count = 0;

                while( $stmt->fetch() )
                {
                    $return[$count] = array
                    (
                        'CD_Requisicao_Equipamento' => $idRequisicaoEquipamento,
                        'NM_Equipamento' => $nmequipamento,
                        'CD_Equipamento' => $idequipamento,
                        'NM_Requisitante' => $nmrequisitante,
                        'CD_Requisitante' => $idrequisitante,
                        'DT_Completa' => $dtcompleta,
                        'DT_Horario' => $dthorario
                    );

                    $count++;
                }
            }

            $stmt->close();

            return $return;
        }

        public function UpdateRequisicaoEquipamento( $codigo, $parameters )
        {
            if( $this->conn )
            {
                $sql = "UPDATE RequisicaoEquipamento SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."',";

                $sql = substr( $sql, 0, strlen( $sql ) - 1 );

                $sql .= " WHERE CD_Requisicao_Equipamento = ".$codigo;

                if( mysqli_query( $this->conn, $sql ) )
                    return 1;
                else
                    echo mysqli_error( $this->conn );
            }
            else
                return 0;
        }

        public function DeleteRequisicaoEquipamento( $index )
        {
            $historico = new HistoricoEquipamento( );
            
            $values = $this->ReadRequisicaoEquipamento( $index );

            if( is_array( $values ) )
            {
                if( $historico->CreateHistoricoEquipamento( 
                                                        $values[0]['NM_Equipamento'], 
                                                        $values[0]['NM_Requisitante'],
                                                        $_SESSION['NM_Usuario'],
                                                        $values[0]['DT_Completa'],
                                                        $values[0]['DT_Horario'],
                                                        date("Y-m-d"), 
                                                        date("H:i:s") 
                                                    )
                )
                {
                    $stmt = $this->conn->prepare( "DELETE FROM RequisicaoEquipamento WHERE CD_Requisicao_Equipamento = ?" );
                    $stmt->bind_param( "i", $index );

                    $return = ( $stmt->execute() == false ? false : true );
                    
                    $stmt->close();
                    
                    return $return;
                }
            }
        }
    }
?>