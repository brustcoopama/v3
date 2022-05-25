<?php

/**
 * Class: Config Personalizada do Módulo
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar toda a aplicação.
 * Create: 18/04/2022
 * Update: 18/04/2022
 * 
 * Registros:
 * 18/04/2022 - Criação
 * 
 */


/**
 * Chama as configurações personalizadas.
 */






/**
 * ********************************************************************************************
 * CONNECTIONS
 * ********************************************************************************************
 */

$conexao[1] = [
	'ATIVO'        => true,                     // Conexão será usada?
	'API'          => false,                    // Conexão será via API?
	'DBMANAGER'    => "mysql",                  // Linguagem do Gerenciador de banco de dados (GBD).
	'HOST'         => "localhost",              // HOST do servidor de banco de dados. IP ou DNS.
	'PORT'         => "3306",                   // Porta do serviço de BD.
	'USER'         => "root",                   // Usuário do GBD.
	'PASSWORD'     => "",                       // Senha do usuário do GBD.
	'DBNAME'       => "v3_personalizado_01",    // Nome da base de dados no GBD.
	'CHARSET'      => "utf8",                   // Charset usado na base de Dados.
	'PREFIX_TABLE' => "v3_",                    // Prefixo das tabelas.
];

// GUARDA AS CONEXÕES NA CONSTANTE
define("VC_P_DB", $conexao);
// Libera memória.
unset($conexao);








/**
 * ********************************************************************************************
 * PATHS
 * ********************************************************************************************
 */
// Define os paths personalizados.
define("VC_P_PATH", [
    '' => '',
]);







/**
 * ********************************************************************************************
 * INFORMAÇÕES
 * ********************************************************************************************
 */

// Define as informações personalizadas.
define("VC_P_INFO", [
    '' => '',
]);







/**
 * ********************************************************************************************
 * PHP
 * ********************************************************************************************
 */










/**
 * ********************************************************************************************
 * TOKENS
 * ********************************************************************************************
 */
