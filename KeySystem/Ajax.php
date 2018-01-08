<?php
    require 'Connection.php';
    require 'Requisitante.php';
    require 'RequisicaoSala.php';

    if( array_key_exists( 'CD_Requisicao_Sala_Edit', $_GET ) )
    {
        $idRequisicaoSala = $_GET['CD_Requisicao_Sala_Edit'];

        if( is_numeric( $idRequisicaoSala ) && intval( $idRequisicaoSala ) > 0 )
        {
            $requisicaoSala = new RequisicaoSala();
            
            $requisicao = $requisicaoSala->ReadRequisicaoSala( $idRequisicaoSala, null, null );
            
            if( is_array( $requisicao ) )
            { echo json_encode($requisicao); }
        }
    }

    if( array_key_exists( 'CD_Requisicao_Sala_Del', $_GET ) )
    {
        $idRequisicaoSala = $_GET['CD_Requisicao_Sala_Del'];

        if( is_numeric( $idRequisicaoSala ) && intval( $idRequisicaoSala ) > 0 )
        {
            $requisicaoSala = new RequisicaoSala();

            if( $requisicaoSala->DeleteRequisicaoSala( $idRequisicaoSala ) )
                echo "Deletado";
        }
    }
?>