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

        public function ReadRequisicaoSala( $id = null, $idRequester = null, $idKey = null)
        {
            $sql = "SELECT RS.CD_Requisicao_Sala, C.NM_Chave, 
            R.NM_Requisitante, RS.DT_Completa, RS.DT_Horario
            FROM RequisicaoSala RS 
            JOIN Chave C ON( RS.CD_Chave = C.CD_Chave )
            JOIN Requisitante R ON( R.CD_Requisitante = RS.CD_Requisitante ) ";

            if( $id )
                $sql .= "WHERE CD_Requisicao_Sala = $id";
            else if( $idRequester )
                $sql .= "WHERE CD_Requisitante = $idRequester";
            else if( $idKey )
                $sql .= "WHERE CD_Chave = $idKey";
            else
                $sql .= "WHERE CD_Requisicao_Sala > 0";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($idRequisicaoSala, $nmchave, $nmrequisitante, $dtcompleta, $dthorario );

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
                        'NM_Requisitante' => $nmrequisitante,
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
                $sqlc = "UPDATE RequisicaoSala SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."', ";

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
            $stmt = $this->conn->prepare( "DELETE FROM RequisicaoSala WHERE CD_Requisicao_Sala = ?" );
            $stmt->bind_param( "i", $index );

            $return = ( $stmt->execute() == false ? false : true );
            
            $stmt->close();
            
            return $return;
        }
    }
?>