<?php
    require 'Connection.php';
    require 'Requisitante.php';
    require 'RequisicaoSala.php';
    require 'Equipamento.php';

    if( array_key_exists( 'CD_Requisicao_Sala_Edit', $_GET ) )
    {
        $idRequisicaoSala = $_GET['CD_Requisicao_Sala_Edit'];

        if( is_numeric( $idRequisicaoSala ) && intval( $idRequisicaoSala ) > 0 )
        {
            $requisicaoSala = new RequisicaoSala( );
            
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
            $requisicaoSala = new RequisicaoSala( );

            if( $requisicaoSala->DeleteRequisicaoSala( $idRequisicaoSala ) )
                echo "Deletado";
        }
    }

    if( array_key_exists( 'CD_Requisitante_Edit', $_GET ) )
    {
        $idRequisitante = $_GET['CD_Requisitante_Edit'];

        if( is_numeric( $idRequisitante ) && intval( $idRequisitante ) > 0 )
        {
            $requisitante = new Requisitante( );

            $requisitanteResponse = $requisitante->ReadRequisitante( $idRequisitante, null, null );

            if( is_array( $requisitanteResponse ) )
            { echo json_encode( $requisitanteResponse ); }
        }
    }

    if( array_key_exists( 'CD_Requisitante_Del', $_GET ) )
    {
        $idRequisitante = $_GET['CD_Requisitante_Del'];

        if( is_numeric( $idRequisitante ) && intval( $idRequisitante ) > 0 )
        {
            $requisitante = new Requisitante( );

            if( $requisitante->DeleteRequisitante( $idRequisitante ) )
                echo "Deletado";
        }
    }

    if( array_key_exists( 'CD_Equipamento_Edit', $_GET ) )
    {
        $idEquipamento = $_GET['CD_Equipamento_Edit'];

        if( is_numeric( $idEquipamento ) && intval( $idEquipamento ) > 0 )
        {
            $equipamento = new Equipamento( );

            $equipamentos = $equipamento->ReadEquipamento( $idEquipamento, null );

            if( is_array( $equipamentos ) )
            { echo json_encode( $equipamentos ); }
        }
    }

    if( array_key_exists( 'CD_Equipamento_Del', $_GET ) )
    {
        $idEquipamento = $_GET['CD_Equipamento_Del'];

        if( is_numeric( $idEquipamento ) && intval( $idEquipamento ) > 0 )
        {
            $equipamento = new Equipamento( );

            if( $equipamento->DeleteEquipamento( $idEquipamento ) )
                echo "Deletado";
        }
    }
?>