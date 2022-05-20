<?php

/**
 * Class: Config
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar toda a aplicação.
 * Create: 12/04/2022
 * Update: 12/04/2022
 * 
 * Registros:
 * 12/04/2022 - Criação
 * 
 */


/**
 * Acesso Off-Line
 * Caso seja desconsiderado o uso de BD dentro da controller.
 */
define("VC_LOGIN", "admin");
define("VC_PASSWORD", "admin");


/**
 *  Define o tipo de ambiente que a plataforma irá rodar.
 */
// define("VC_AMBIENTE", "1"); // PRODUÇÃO - Execução remota com base de dados de produção.
// define("VC_AMBIENTE", "2"); // HOMOLOGAÇÃO - Execução remota com base de dados de homologação.

// Personalizado Programador 01
// define("VC_AMBIENTE", "3"); // PROGRAMADOR 01 - BD PRODUÇÃO - Execução local com a base de dados de produção.
// define("VC_AMBIENTE", "4"); // PROGRAMADOR 01 - BD HOMOLOGAÇÃO - Execução local com a base de dados de homologação.
define("VC_AMBIENTE", "5"); // PROGRAMADOR 01 - LOCAL - Execução local com a base de dados local.

// Personalizado Programador 02
// define("VC_AMBIENTE", "6"); // PROGRAMADOR 02 - BD PRODUÇÃO - Execução local com a base de dados de produção.
// define("VC_AMBIENTE", "7"); // PROGRAMADOR 02 - BD HOMOLOGAÇÃO - Execução local com a base de dados de homologação.
// define("VC_AMBIENTE", "8"); // PROGRAMADOR 02 - LOCAL - Execução local com a base de dados local.


/**
 * Chama as configurações default.
 */

// Configurações de caminhos de pastas.
require_once 'c/plataforma/configs/config_paths.php';

// Configurações de conexões.
require_once 'c/plataforma/configs/config_connections.php';

// Configurações de informações plataforma.
require_once 'c/plataforma/configs/config_infos.php';

// Configurações do PHP
require_once 'c/plataforma/configs/config_php.php';

// Configurações de Tokens
require_once 'c/plataforma/configs/config_tokens.php';
