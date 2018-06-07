<?php
    class ReservaChave
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }

        public function CreateReservaChave( $idKey, $idRequester, $dtComplete, $dtHourStart, $dtHourEnd )
        {
            $stmt = $this->conn->prepare( "INSERT INTO ReservaChave VALUES (null, ?, ?, ?, ?, ? )" );
            $stmt->bind_param( "iisss", $idRequester, $idKey, $dtComplete, $dtHourStart, $dtHourEnd );
            
            $return = ( $stmt->execute() == false ? false : true );

            $stmt->close();

            return $return;
        }

        public function ReadReservaChave( $id = null, $idRequester = null, $idKey = null )
        {
            $sql = "SELECT RC.CD_Reserva_Chave, C.NM_Chave, R.CD_Requisitante, 
            R.NM_Requisitante, RC.DT_Completa, RC.DT_Horario_Comeco, RC.DT_Horario_Termino, C.CD_Chave
            FROM ReservaChave RC 
            JOIN Chave C ON( RC.CD_Chave = C.CD_Chave )
            JOIN Requisitante R ON( R.CD_Requisitante = RC.CD_Requisitante ) ";

            if( $id )
                $sql .= "WHERE CD_Reserva_Chave = $id";
            else if( $idRequester )
                $sql .= "WHERE CD_Requisitante = $idRequester";
            else if( $idKey )
                $sql .= "WHERE CD_Chave = $idKey";
            else
                $sql .= "WHERE CD_Reserva_Chave > 0";
            
            $sql .= " ORDER BY RC.DT_Completa, R.NM_Requisitante";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result
                            (
                                $idReservaChave, $nmchave, 
                                $idrequisitante, $nmrequisitante, 
                                $dtcompleta, $dthorariocomeco,
                                $dthorariotermino, $idchave
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
                        'CD_Reserva_Chave' => $idReservaChave,
                        'NM_Chave' => $nmchave,
                        'CD_Chave' => $idchave,
                        'NM_Requisitante' => $nmrequisitante,
                        'CD_Requisitante' => $idrequisitante,
                        'DT_Completa' => $dtcompleta,
                        'DT_Horario_Comeco' => $dthorariocomeco,
                        'DT_Horario_Termino' => $dthorariotermino
                    );

                    $count++;
                }
            }

            $stmt->close();

            return $return;
        }

        public function UpdateReservaChave( $codigo, $parameters )
        {
            if( $this->conn )
            {
                $sql = "UPDATE ReservaChave SET ";

                foreach( $parameters as $key => $value )
                    $sql .= $key." = '".$value."',";

                $sql = substr( $sql, 0, strlen( $sql ) - 1 );

                $sql .= " WHERE CD_Reserva_Chave = ".$codigo;

                if( mysqli_query( $this->conn, $sql ) )
                    return 1;
                else
                    echo mysqli_error( $this->conn );
            }
            else
                return 0;
        }

        public function DeleteReservaChave( $index )
        {
            $return = null;

            $stmt = $this->conn->prepare( "DELETE FROM ReservaChave WHERE CD_Reserva_Chave = ?" );
            $stmt->bind_param( "i", $index );

            $return = ( $stmt->execute() == false ? false : true );
                    
            $stmt->close();
                    
            return $return;
        }
    }
?>