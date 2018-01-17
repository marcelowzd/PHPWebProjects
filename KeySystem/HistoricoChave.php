<?php
    class HistoricoChave
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }

        public function CreateHistoricoChave( 
                                                $chave, $requisitante, $usuario, 
                                                $dtRecebida, $dtHorarioRecebido,
                                                $dtEntregue, $dtHorarioEntregue 
                                            )
        {
            $stmt = $this->conn->prepare( "INSERT INTO HistoricoChave VALUES (null, ?, ?, ?, ?, ?, ?, ? )" );
            $stmt->bind_param( "sssssss", $chave, $requisitante, $usuario, $dtRecebida, $dtHorarioRecebido,
            $dtEntregue, $dtHorarioEntregue );
            
            $return = ( $stmt->execute() == false ? false : true );

            $stmt->close();

            return $return;
        }

        public function ReadHistoricoChave( $id = null, $chave = null, $requisitante = null, $usuario = null, $dtRecebida = null, $dtHorarioRecebido = null, $dtEntregue = null, $dtHorarioEntregue = null )
        {
            $sql = "SELECT * FROM HistoricoChave ";

            if( $id )
                $sql .= "WHERE CD_Historico_Chave = $id";
            else if( $chave )
                $sql .= "WHERE NM_Chave LIKE $chave";
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
                $sql .= "WHERE CD_Historico_Chave > 0";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result
                            (
                                $idHistoricoChave, $nmchave, $nmrequisitante, 
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
                        'CD_Historico_Chave' => $idHistoricoChave,
                        'NM_Chave' => $nmchave,
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

        /*public function UpdateHistoricoChave( $codigo, $parameters )
        {
            if( $this->conn )
            {
                $sql = "UPDATE HistoricoChave SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."',";

                $sql = substr( $sql, 0, strlen( $sql ) - 1 );

                $sql .= " WHERE CD_Historico_Chave = ".$codigo;

                if( mysqli_query( $this->conn, $sql ) )
                    return 1;
                else
                    echo mysqli_error( $this->conn );
            }
            else
                return 0;
        }*/

        public function DeleteHistoricoChave( $index )
        {
            $stmt = $this->conn->prepare( "DELETE FROM HistoricoChave WHERE CD_Historico_Chave = ?" );
            $stmt->bind_param( "i", $index );

            $return = ( $stmt->execute() == false ? false : true );
            
            $stmt->close();
            
            return $return;
        }
    }
?>