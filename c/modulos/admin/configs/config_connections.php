<?php

/**
 * Class: config_connections
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Guarda as configurações de conexão personalizadas.
 * Create: 18/04/2022
 * Update: 18/04/2022
 * 
 * Registros:
 * 18/04/2022 - Criação
 * 
 */

/**
 * [1] CONEXÃO COM BASE PERSONALIZADA.
 */
// Acesso ao banco de dados PDO Personalizado 01.
define("VC_P_C_DB1", false);                  		// Conexão será usada?
define("VC_P_C_DB1_API", false);             		// Conexão será via API?
define("VC_P_C_DB1_DBMANAGER", "mysql");			// Linguagem do Gerenciador de banco de dados (GBD).
define("VC_P_C_DB1_HOST", "localhost");				// HOST do servidor de banco de dados. IP ou DNS.
define("VC_P_C_DB1_PORT", "3306");					// Porta do serviço de BD.
define("VC_P_C_DB1_USER", "root");					// Usuário do GBD.
define("VC_P_C_DB1_PASSWORD", "");					// Senha do usuário do GBD.
define("VC_P_C_DB1_DBNAME", "v3_personalizado_01");	// Nome da base de dados no GBD.
define("VC_P_C_DB1_CHARSET", "utf8");				// Charset usado na base de Dados.
define("VC_P_C_DB1_PREFIX_TABLE", "v3_");			// Prefixo das tabelas.


/**
 * [2] CONEXÃO COM BASE PERSONALIZADA.
 */
// Acesso ao banco de dados PDO Personalizado 02.
define("VC_P_C_DB2", false);                  		// Conexão será usada?
define("VC_P_C_DB2_API", false);             		// Conexão será via API?
define("VC_P_C_DB2_DBMANAGER", "mysql");			// Linguagem do Gerenciador de banco de dados (GBD).
define("VC_P_C_DB2_HOST", "localhost");				// HOST do servidor de banco de dados. IP ou DNS.
define("VC_P_C_DB2_PORT", "3306");					// Porta do serviço de BD.
define("VC_P_C_DB2_USER", "root");					// Usuário do GBD.
define("VC_P_C_DB2_PASSWORD", "");					// Senha do usuário do GBD.
define("VC_P_C_DB2_DBNAME", "v3_personalizado_02");	// Nome da base de dados no GBD.
define("VC_P_C_DB2_CHARSET", "utf8");				// Charset usado na base de Dados.
define("VC_P_C_DB2_PREFIX_TABLE", "v3_");			// Prefixo das tabelas.