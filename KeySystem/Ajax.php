<?php

    require 'Connection.php';
    require 'Requisitante.php';
    require 'RequisicaoSala.php';

    if( array_key_exists( 'RequisicaoSalaEdit', $_GET ) )
    {
        $idRequisicaoSala = $_GET['CD_Requisicao_Sala'];

        if( is_numeric( $idRequisicaoSala ) && intval( $idRequisicaoSala ) > 0 )
        {
            $requisicaoSala = new RequisicaoSala();
            
            $requisicao = $requisicaoSala->ReadRequisicaoSala( $_GET['CD_Requisicao_Sala'] );
            
            $return;
            
            if( is_array( $requisicao ) )
            {
            
            }
        }
    }
?>