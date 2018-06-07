<?php
    class RequisicaoSala
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }

        public function CreateRequisicaoSala( $idKey, $idRequester, $dtComplete, $dtHour )
        {
            $stmt = $this->conn->prepare( "INSERT INTO RequisicaoSala VALUES (null, ?, ?, ?, ? )" );
            $stmt->bind_param( "iiss", $idKey, $idRequester, $dtComplete, $dtHour );
            
            $return = ( $stmt->execute() == false ? false : true );

            $stmt->close();

            return $return;
        }

        public function ReadRequisicaoSala( $id = null, $idRequester = null, $idKey = null, $filterToTv = null )
        {
            $sql = "SELECT RS.CD_Requisicao_Sala, C.NM_Chave, R.CD_Requisitante, 
            R.NM_Requisitante, RS.DT_Completa, RS.DT_Horario, C.CD_Chave
            FROM RequisicaoSala RS 
            JOIN Chave C ON( RS.CD_Chave = C.CD_Chave )
            JOIN Requisitante R ON( R.CD_Requisitante = RS.CD_Requisitante ) ";

            if( $id )
                $sql .= "WHERE CD_Requisicao_Sala = $id";
            else if( $idRequester )
                $sql .= "WHERE CD_Requisitante = $idRequester";
            else if( $idKey )
                $sql .= "WHERE CD_Chave = $idKey";
            else if( $filterToTv )
                $sql .= "WHERE R.DS_Requisitante LIKE '%Professor%' OR R.DS_Requisitante LIKE '%Livre%'"; // Mostra apenas professores e labs livres
            else
                $sql .= "WHERE CD_Requisicao_Sala > 0";
            
            $sql .= " ORDER BY R.NM_Requisitante";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result
                            (
                                $idRequisicaoSala, $nmchave, 
                                $idrequisitante, $nmrequisitante, 
                                $dtcompleta, $dthorario, $idchave
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
                        'CD_Requisicao_Sala' => $idRequisicaoSala,
                        'NM_Chave' => $nmchave,
                        'CD_Chave' => $idchave,
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

        public function UpdateRequisicaoSala( $codigo, $parameters )
        {
            if( $this->conn )
            {
                $sql = "UPDATE RequisicaoSala SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."',";

                $sql = substr( $sql, 0, strlen( $sql ) - 1 );

                $sql .= " WHERE CD_Requisicao_Sala = ".$codigo;

                if( mysqli_query( $this->conn, $sql ) )
                    return 1;
                else
                    echo mysqli_error( $this->conn );
            }
            else
                return 0;
        }

        public function DeleteRequisicaoSala( $index )
        {
            $historico = new HistoricoChave( );

            $values = $this->ReadRequisicaoSala( $index );

            if( is_array( $values ) )
            {
                if( $historico->CreateHistoricoChave( 
                                                        $values[0]['NM_Chave'], 
                                                        $values[0]['NM_Requisitante'],
                                                        $_SESSION['NM_Usuario'],
                                                        $values[0]['DT_Completa'],
                                                        $values[0]['DT_Horario'],
                                                        date("Y-m-d"), 
                                                        date("H:i:s") 
                                                    )
                )
                {
                    $return = null;

                    $stmt = $this->conn->prepare( "DELETE FROM RequisicaoSala WHERE CD_Requisicao_Sala = ?" );
                    $stmt->bind_param( "i", $index );

                    $return = ( $stmt->execute() == false ? false : true );
                    
                    $stmt->close();
                    
                    return $return;
                }
            }
        }
    }
?>