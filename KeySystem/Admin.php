<?php
    require 'Connection.php';

    $conn = Connection::Connect();

    if( $conn )
    {
        $sql = "CREATE DATABASE IF NOT EXISTS DtbsChave";

        if( mysqli_query( $conn, $sql ) ) echo "<p> Database DtbsChave criado com sucesso </p>";
        else echo "<p>".mysqli_error( $conn )."</p>";

        $sql = "CREATE TABLE IF NOT EXISTS Requisitante
                (
                    CD_Requisitante INTEGER PRIMARY KEY AUTO_INCREMENT,
                    NM_Requisitante VARCHAR(50) NOT NULL,
                    DS_Requisitante VARCHAR(50) NOT NULL
                )";

        if( mysqli_query( $conn, $sql ) ) echo "<p> Tabela requisitante criada com sucesso </p>";
        else echo "<p>".mysqli_error( $conn )."</p>";

        $sql = "CREATE TABLE IF NOT EXISTS Chave
                (
                    CD_Chave INTEGER PRIMARY KEY AUTO_INCREMENT,
                    NM_Chave VARCHAR(50) NOT NULL
                )";

        if( mysqli_query( $conn, $sql ) ) echo "<p> Tabela chave criada com sucesso </p>";
        else echo "<p>".mysqli_error( $conn )."</p>";

        $sql = "CREATE TABLE IF NOT EXISTS Equipamento
                (
                    CD_Equipamento INTEGER PRIMARY KEY AUTO_INCREMENT,
                    NM_Equipamento VARCHAR(50) NOT NULL
                )";

        if( mysqli_query( $conn, $sql ) ) echo "<p> Tabela equipamento criada com sucesso </p>";
        else echo "<p>".mysqli_error( $conn )."</p>";

        $sql = "CREATE TABLE IF NOT EXISTS HistoricoChave
                (
                    CD_Historico_Chave INTEGER PRIMARY KEY AUTO_INCREMENT,
                    NM_Chave VARCHAR(50) NOT NULL,
                    NM_Requisitante VARCHAR(50) NOT NULL,
                    DT_Completa DATE NOT NULL,
                    DT_Horario DATETIME NOT NULL
                )";

        if( mysqli_query( $conn, $sql ) ) echo "<p> Tabela HistoricoChave criada com sucesso </p>";
        else echo "<p>".mysqli_error( $conn )."</p>";

        $sql = "CREATE TABLE IF NOT EXISTS HistoricoEquipamento
                (
                    CD_Historico_Equipamento INTEGER PRIMARY KEY AUTO_INCREMENT,
                    NM_Equipamento VARCHAR(50) NOT NULL,
                    NM_Requisitante VARCHAR(50) NOT NULL,
                    DT_Completa DATE NOT NULL,
                    DT_Horario DATETIME NOT NULL
                )";

        if( mysqli_query( $conn, $sql ) ) echo "<p> Tabela HistoricoEquipamento criada com sucesso </p>";
        else echo "<p>".mysqli_error( $conn )."</p>";

        $sql = "CREATE TABLE IF NOT EXISTS RequisicaoSala
                (
                    CD_Requisicao_Sala INTEGER PRIMARY KEY AUTO_INCREMENT,
                    CD_Chave INTEGER NOT NULL UNIQUE,
                    CD_Requisitante INTEGER NOT NULL UNIQUE,
                    DT_Completa DATE NOT NULL,
                    DT_Horario TIME NOT NULL,
                    FOREIGN KEY (CD_Chave) REFERENCES Chave(CD_Chave),
                    FOREIGN KEY (CD_Requisitante) REFERENCES Requisitante(CD_Requisitante)
                )";

        if( mysqli_query( $conn, $sql ) ) echo "<p> Tabela RequisicaoSala criada com sucesso </p>";
        else echo "<p>".mysqli_error( $conn )."</p>";

        $sql = "CREATE TABLE IF NOT EXISTS RequisicaoEquipamento
                (
                    CD_Requisicao_Equipamento INTEGER PRIMARY KEY AUTO_INCREMENT,
                    CD_Equipamento INTEGER NOT NULL UNIQUE,
                    CD_Requisitante INTEGER NOT NULL,
                    DT_Completa DATE NOT NULL,
                    DT_Horario TIME NOT NULL,
                    FOREIGN KEY (CD_Equipamento) REFERENCES Equipamento(CD_Equipamento),
                    FOREIGN KEY (CD_Requisitante) REFERENCES Requisitante(CD_Requisitante)
                )";
        
        if( mysqli_query( $conn, $sql ) ) echo "<p> Tabela RequisicaoEquipamento criada com sucesso </p>";
        else echo "<p>".mysqli_error( $conn )."</p>";

    }
    else echo mysqli_error( $conn );
?>