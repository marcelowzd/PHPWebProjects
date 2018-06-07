<?php
    require 'Connection.php';
    require 'Requisitante.php';
    require 'RequisicaoSala.php';
    require 'RequisicaoEquipamento.php';
    require 'Equipamento.php';
    require 'Usuario.php';
    require 'Chave.php';
    require 'HistoricoChave.php';
    require 'HistoricoEquipamento.php';
    require 'ReservaChave.php';

    session_start();

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
            $usuario = new Usuario( );

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

    if( array_key_exists( 'CD_Requisicao_Equipamento_Edit', $_GET ) )
    {
        $idRequisicaoEquipamento = $_GET['CD_Requisicao_Equipamento_Edit'];

        if( is_numeric( $idRequisicaoEquipamento ) && intval( $idRequisicaoEquipamento ) > 0 )
        {
            $requisicaoEquipamento = new RequisicaoEquipamento( );

            $requisicoesEquipamento = $requisicaoEquipamento->ReadRequisicaoEquipamento( $idRequisicaoEquipamento, null, null );

            if( is_array( $requisicoesEquipamento ) )
            { echo json_encode( $requisicoesEquipamento ); }
        }
    }

    if( array_key_exists( 'CD_Requisicao_Equipamento_Del', $_GET ) )
    {
        $idRequisicaoEquipamento = $_GET['CD_Requisicao_Equipamento_Del'];

        if( is_numeric( $idRequisicaoEquipamento ) && intval( $idRequisicaoEquipamento ) > 0 )
        {
            $requisicaoEquipamento = new RequisicaoEquipamento( );

            if( $requisicaoEquipamento->DeleteRequisicaoEquipamento( $idRequisicaoEquipamento ) )
                echo "Deletado";
        }
    }

    if( array_key_exists( 'CD_Chave_Edit', $_GET ) )
    {
        $idChave = $_GET['CD_Chave_Edit'];

        if( is_numeric( $idChave ) && intval( $idChave ) > 0 )
        {
            $chave = new Chave( );

            $chaves = $chave->ReadChave( $idChave, null, null );

            if( is_array( $chaves ) )
            { echo json_encode( $chaves ); }
        }
    }

    if( array_key_exists( 'CD_Chave_Del', $_GET ) )
    {
        $idChave = $_GET['CD_Chave_Del'];

        if( is_numeric( $idChave ) && intval( $idChave ) > 0 )
        {
            $chave = new Chave( );

            if( $chave->DeleteChave( $idChave ) )
                echo "Deletado";
        }
    }

    if( array_key_exists( 'CD_Usuario_Edit', $_GET ) )
    {
        $idUsuario = $_GET['CD_Usuario_Edit'];

        if( is_numeric( $idUsuario ) && intval( $idUsuario ) > 0 )
        {
            $usuario = new Usuario( );

            $usuarios = $usuario->ReadUsuario( $idUsuario, null, null );

            if( is_array( $usuarios ) )
            { echo json_encode( $usuarios ); }
        }
    }

    if( array_key_exists( 'CD_Usuario_Del', $_GET ) )
    {
        $idUsuario = $_GET['CD_Usuario_Del'];

        if( is_numeric( $idUsuario ) && intval( $idUsuario ) > 0 )
        {
            $usuario = new Usuario( );

            if( $usuario->DeleteUsuario( $idUsuario ) )
                echo "<script> alert('Usuario deletado'); </script>";
        }
    }

    if( array_key_exists( 'CD_Reserva_Chave_Con', $_GET ) )
    {
        $idReservaChave = $_GET['CD_Reserva_Chave_Con'];

        if( is_numeric( $idReservaChave ) && intval( $idReservaChave ) )
        {
            $reservaChave = new ReservaChave( );
            $requisicaoSala = new RequisicaoSala( );

            $result = $reservaChave->ReadReservaChave( $idReservaChave );

            if( $requisicaoSala->CreateRequisicaoSala( $result[ 0 ][ 'CD_Chave' ], $result[ 0 ][ 'CD_Requisitante' ],
                $result[ 0 ][ 'DT_Completa' ], $result[ 0 ][ 'DT_Horario_Comeco' ]
            ) )
            {
                $reservaChave->DeleteReservaChave( $idReservaChave );
            }
        }
    }

    if( array_key_exists( 'CD_Reserva_Chave_Edit', $_GET ) )
    {
        $idReservaChave = $_GET['CD_Reserva_Chave_Edit'];

        if( is_numeric( $idReservaChave ) && intval( $idReservaChave ) > 0 )
        {
            $reservaChave = new ReservaChave( );

            $reservasChave = $reservaChave->ReadReservaChave( $idReservaChave, null, null );

            if( is_array( $reservasChave ) )
            { echo json_encode( $reservasChave ); }
        }
    }

    if( array_key_exists( 'CD_Reserva_Chave_Del', $_GET ) )
    {
        $idReservaChave = $_GET['CD_Reserva_Chave_Del'];

        if( is_numeric( $idReservaChave ) && intval( $idReservaChave ) > 0 )
        {
            $reservaChave = new ReservaChave( );

            if( $reservaChave->DeleteReservaChave( $idReservaChave ) )
                echo "<script> alert('Reserva de chave deletada'); </script>";
        }
    }
?>