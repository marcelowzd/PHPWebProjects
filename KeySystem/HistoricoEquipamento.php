<?php
    class HistoricoEquipamento
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }

        public function CreateHistoricoEquipamento( 
                                                $equipamento, $requisitante, $usuario, 
                                                $dtRecebida, $dtHorarioRecebido,
                                                $dtEntregue, $dtHorarioEntregue 
                                            )
        {
            $stmt = $this->conn->prepare( "INSERT INTO HistoricoEquipamento VALUES (null, ?, ?, ?, ?, ?, ?, ? )" );
            $stmt->bind_param( "sssssss", $equipamento, $requisitante, $usuario, $dtRecebida, $dtHorarioRecebido,
            $dtEntregue, $dtHorarioEntregue );
            
            $return = ( $stmt->execute() == false ? false : true );

            $stmt->close();

            return $return;
        }

        public function ReadHistoricoEquipamento( $id = null, $equipamento = null, $requisitante = null, $usuario = null, $dtRecebida = null, $dtHorarioRecebido = null, $dtEntregue = null, $dtHorarioEntregue = null )
        {
            $sql = "SELECT * FROM HistoricoEquipamento ";

            if( $id )
                $sql .= "WHERE CD_Historico_Equipamento = $id";
            else if( $equipamento )
                $sql .= "WHERE NM_Equipamento LIKE $equipamento";
            else if( $requisitante )
                $sql .= "WHERE NM_Requisitante LIKE $requisitante";
            else if( $usuario )
                $sql .= "WHERE NM_Usuario LIKE $usuario";
            else if( $dtRecebida )
                $sql .= "WHERE DT_Completa_Recebida = $dtRecebida";
            else if( $dtHorarioRecebido )
                $sql .= "WHERE DT_Horario_Recebido = $dtHorarioRecebido";
            else if( $dtEntregue )
                $sql .= "WHERE DT_Completa_Entrega = $dtEntregue";
            else if( $dtHorarioEntregue )
                $sql .= "WHERE DT_Entrega = $dtHorarioEntregue";
            else
                $sql .= "WHERE CD_Historico_Equipamento > 0";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result
                            (
                                $idHistoricoEquipamento, $nmequipamento, $nmrequisitante, 
                                $nmusuario, $dtcompletarecebidaANS, 
                                $dthorariorecebidoANS, $dtcompletaentregueANS, $dthorarioentregueANS 
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
                        'CD_Historico_Equipamento' => $idHistoricoEquipamento,
                        'NM_Equipamento' => $nmequipamento,
                        'NM_Requisitante' => $nmrequisitante,
                        'NM_Usuario' => $nmusuario,
                        'DT_Completa_Recebida' => $dtcompletarecebidaANS,
                        'DT_Horario_Recebido' => $dthorariorecebidoANS,
                        'DT_Completa_Entrega' => $dtcompletaentregueANS,
                        'DT_Horario_Entrega' => $dthorarioentregueANS
                    );

                    $count++;
                }
            }

            $stmt->close();

            return $return;
        }

        /*public function UpdateHistoricoEquipamento( $codigo, $parameters )
        {
            if( $this->conn )
            {
                $sql = "UPDATE HistoricoEquipamento SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."',";

                $sql = substr( $sql, 0, strlen( $sql ) - 1 );

                $sql .= " WHERE CD_Historico_Equipamento = ".$codigo;

                if( mysqli_query( $this->conn, $sql ) )
                    return 1;
                else
                    echo mysqli_error( $this->conn );
            }
            else
                return 0;
        }*/

        public function DeleteHistoricoEquipamento( $index )
        {
            $stmt = $this->conn->prepare( "DELETE FROM HistoricoEquipamento WHERE CD_Historico_Equipamento = ?" );
            $stmt->bind_param( "i", $index );

            $return = ( $stmt->execute() == false ? false : true );
            
            $stmt->close();
            
            return $return;
        }
    }
?>