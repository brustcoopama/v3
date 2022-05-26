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
 * ********************************************************************************************
 * AMBIENTE
 * ********************************************************************************************
 * Define o tipo de ambiente que a plataforma irá rodar.
 */
// define("VC_AMBIENTE", "0"); // LOCALHOST - Execução local sem banco de dados.
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
 * ********************************************************************************************
 * CONFIGURAÇÕES PRINCIPAIS POR AMBIENTE
 * ********************************************************************************************
 */

// Connections
// *********************
// Conexão principal
$conexao_00 = array();

// Paths
// *********************
// Caminho da URL raiz.
$path_raiz_url = '';
// Caminho relativo.
$path_dir_base = '';


// Escolha do ambiente de execução.
switch (VC_AMBIENTE) {

		/**
	 * SERVIDOR OFF BD
	 * ******************************************************************
	 */
	case '0':
		// LOCALHOST - Execução local sem banco de dados.

		// Paths
		// *********************
		$path_raiz_url = 'https://v3.coopama.com.br/';
		$path_dir_base = '';

		// PHP
		// *********************
		// Exibe erros para usuários.
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);

		break;




		/**
		 * SERVIDOR
		 * ******************************************************************
		 */
	case '1':
		// PRODUÇÃO - Execução remota com base de dados de produção.

		// Connections
		// *********************
		$conexao[1] = [
			'ATIVO'        => true,               // Conexão será usada?
			'API'          => false,              // Conexão será via API?
			'DBMANAGER'    => "mysql",            // Linguagem do Gerenciador de banco de dados (GBD).
			'HOST'         => "coopama.com.br",   // HOST do servidor de banco de dados. IP ou DNS.
			'PORT'         => "3306",             // Porta do serviço de BD.
			'USER'         => "v3_user",          // Usuário do GBD.
			'PASSWORD'     => "",                 // Senha do usuário do GBD.
			'DBNAME'       => "v3_prod",          // Nome da base de dados no GBD.
			'CHARSET'      => "utf8",             // Charset usado na base de Dados.
			'PREFIX_TABLE' => "v3_",              // Prefixo das tabelas.
		];


		// Paths
		// *********************
		$path_raiz_url = 'https://v3.coopama.com.br/';
		$path_dir_base = '';


		// PHP
		// *********************
		// Não exibe erros para usuários.
		ini_set('display_errors', 0);
		ini_set('display_startup_erros', 0);
		// error_reporting(E_ALL);


		break;

	case '2':
		// HOMOLOGAÇÃO - Execução remota com base de dados de homologação.

		// Connections
		// *********************
		$conexao[1] = [
			'ATIVO'        => true,               // Conexão será usada?
			'API'          => false,              // Conexão será via API?
			'DBMANAGER'    => "mysql",            // Linguagem do Gerenciador de banco de dados (GBD).
			'HOST'         => "coopama.com.br",   // HOST do servidor de banco de dados. IP ou DNS.
			'PORT'         => "3306",             // Porta do serviço de BD.
			'USER'         => "v3_user",          // Usuário do GBD.
			'PASSWORD'     => "",                 // Senha do usuário do GBD.
			'DBNAME'       => "v3_homo",          // Nome da base de dados no GBD.
			'CHARSET'      => "utf8",             // Charset usado na base de Dados.
			'PREFIX_TABLE' => "v3_",              // Prefixo das tabelas.
		];


		// Paths
		// *********************
		$path_raiz_url = 'https://v3.coopama.com.br/';
		$path_dir_base = '';


		// PHP
		// *********************
		// Exibe errors.
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);



		break;




		/**
		 * PROGRAMADOR 01
		 * ******************************************************************
		 */
	case '3':
		// PROGRAMADOR 01 - BD PRODUÇÃO - Execução local com a base de dados de produção.

		// Connections
		// *********************
		$conexao[1] = [
			'ATIVO'        => true,               // Conexão será usada?
			'API'          => false,              // Conexão será via API?
			'DBMANAGER'    => "mysql",            // Linguagem do Gerenciador de banco de dados (GBD).
			'HOST'         => "coopama.com.br",   // HOST do servidor de banco de dados. IP ou DNS.
			'PORT'         => "3306",             // Porta do serviço de BD.
			'USER'         => "v3_user",          // Usuário do GBD.
			'PASSWORD'     => "",                 // Senha do usuário do GBD.
			'DBNAME'       => "v3_prod",          // Nome da base de dados no GBD.
			'CHARSET'      => "utf8",             // Charset usado na base de Dados.
			'PREFIX_TABLE' => "v3_",              // Prefixo das tabelas.
		];


		// Paths
		// *********************
		$path_raiz_url = 'https://v3.local/';
		$path_dir_base = '';


		// PHP
		// *********************
		// Exibe errors.
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);


		break;

	case '4':
		// PROGRAMADOR 01 - BD HOMOLOGAÇÃO - Execução local com a base de dados de homologação.

		// Connections
		// *********************
		$conexao[1] = [
			'ATIVO'        => true,               // Conexão será usada?
			'API'          => false,              // Conexão será via API?
			'DBMANAGER'    => "mysql",            // Linguagem do Gerenciador de banco de dados (GBD).
			'HOST'         => "coopama.com.br",   // HOST do servidor de banco de dados. IP ou DNS.
			'PORT'         => "3306",             // Porta do serviço de BD.
			'USER'         => "v3_user",          // Usuário do GBD.
			'PASSWORD'     => "",                 // Senha do usuário do GBD.
			'DBNAME'       => "v3_homologacao",   // Nome da base de dados no GBD.
			'CHARSET'      => "utf8",             // Charset usado na base de Dados.
			'PREFIX_TABLE' => "v3_",              // Prefixo das tabelas.
		];


		// Paths
		// *********************
		$path_raiz_url = 'https://v3.local/';
		$path_dir_base = '';


		// PHP
		// *********************
		// Exibe errors.
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);


		break;

	case '5':
		// PROGRAMADOR 01 - LOCAL - Execução local com a base de dados local.

		// Connections
		// *********************
		$conexao[1] = [
			'ATIVO'        => true,          // Conexão será usada?
			'API'          => false,         // Conexão será via API?
			'DBMANAGER'    => "mysql",       // Linguagem do Gerenciador de banco de dados (GBD).
			'HOST'         => "localhost",   // HOST do servidor de banco de dados. IP ou DNS.
			'PORT'         => "3306",        // Porta do serviço de BD.
			'USER'         => "root",        // Usuário do GBD.
			'PASSWORD'     => "",            // Senha do usuário do GBD.
			'DBNAME'       => "v3_local",    // Nome da base de dados no GBD.
			'CHARSET'      => "utf8",        // Charset usado na base de Dados.
			'PREFIX_TABLE' => "v3_",         // Prefixo das tabelas.
		];


		// Paths
		// *********************
		$path_raiz_url = 'http://v3.local/';
		$path_dir_base = '';


		// PHP
		// *********************
		// Exibe errors.
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);



		break;




		/**
		 * PROGRAMADOR 02
		 * ******************************************************************
		 */
	case '6':
		// PROGRAMADOR 02 - BD PRODUÇÃO - Execução local com a base de dados de produção.

		// Connections
		// *********************


		// Paths
		// *********************
		$path_raiz_url = 'http://testes.local/V3/';
		$path_dir_base = 'V3/';


		// PHP
		// *********************
		// Exibe errors.
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);


		break;

	case '7':
		// PROGRAMADOR 02 - BD HOMOLOGAÇÃO - Execução local com a base de dados de homologação.

		// Connections
		// *********************


		// Paths
		// *********************
		$path_raiz_url = 'http://testes.local/V3/';
		$path_dir_base = 'V3/';


		// PHP
		// *********************
		// Exibe errors.
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);


		break;

	case '8':
		// PROGRAMADOR 02 - LOCAL - Execução local com a base de dados local.

		// Connections
		// *********************


		// Paths
		// *********************
		$path_raiz_url = 'http://testes.local/V3/';
		$path_dir_base = 'V3/';


		// PHP
		// *********************
		// Exibe errors.
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);


		break;

	default:
		# code...
		break;
}



/**
 * [01] CONEXÃO COM BASE SECUNDARIA.
 */
$conexao[2] = [
	'ATIVO'        => true,              // Conexão será usada?
	'API'          => false,             // Conexão será via API?
	'DBMANAGER'    => "mysql",           // Linguagem do Gerenciador de banco de dados (GBD).
	'HOST'         => "localhost",       // HOST do servidor de banco de dados. IP ou DNS.
	'PORT'         => "3306",            // Porta do serviço de BD.
	'USER'         => "root",            // Usuário do GBD.
	'PASSWORD'     => "",                // Senha do usuário do GBD.
	'DBNAME'       => "v3_secundario",   // Nome da base de dados no GBD.
	'CHARSET'      => "utf8",            // Charset usado na base de Dados.
	'PREFIX_TABLE' => "v3_",             // Prefixo das tabelas.
];

/**
 * [02] CONEXÃO COM BASE SECUNDARIA.
 */
$conexao[3] = [
	'ATIVO'        => true,              // Conexão será usada?
	'API'          => false,             // Conexão será via API?
	'DBMANAGER'    => "mysql",           // Linguagem do Gerenciador de banco de dados (GBD).
	'HOST'         => "localhost",       // HOST do servidor de banco de dados. IP ou DNS.
	'PORT'         => "3306",            // Porta do serviço de BD.
	'USER'         => "root",            // Usuário do GBD.
	'PASSWORD'     => "",                // Senha do usuário do GBD.
	'DBNAME'       => "v3_secundario",   // Nome da base de dados no GBD.
	'CHARSET'      => "utf8",            // Charset usado na base de Dados.
	'PREFIX_TABLE' => "v3_",             // Prefixo das tabelas.
];

// GUARDA AS CONEXÕES NA CONSTANTE
define("VC_DB", $conexao);
// Libera memória.
unset($conexao);








/**
 * ********************************************************************************************
 * CONFIGURAÇÕES
 * ********************************************************************************************
 */

/**
 * CONFIGURAÇÕES
 * * *******************
 * Liga e desliga funções e recursos a serem utilizados na controller.
 */
define("VC_CONFIG", [

	// Controller usará conexão com banco de dados.
	'bd'                => true,

	// Gravar registro de acesso.
	'visita'            => true,

	// Parâmetros da controller vem do BD.
	'virtualPage'       => false,
	
	// Conteúdo da página vem do BD.
	'viewBD'            => false,

	// Ativa uso de cache para resultado.
	'cache'             => false,
	
	// Tempo para renovar cache em segundos.
	'cacheTime'         => 300,

	// Versão da controller atual.
	'versao'            => 'v1.0',

	// FeedBack padrão de transações.
	'feedback'          => true,

	// VALORES PADRÃO
	'statusDeletado'	=> 2,

	// Teste
	'class'             => __CLASS__,
]);








/**
 * ********************************************************************************************
 * PATHS
 * ********************************************************************************************
 */

/**
 * PATH RAIZ
 * * *******************
 */

// Paths iniciais
$vc_paths['RAIZ_DIR']     	= str_replace('\\', '/', getcwd()) . '/';        	// Caminho completo do sistema .
$vc_paths['RAIZ_URL']     	= $path_raiz_url;                                	// Caminho completo da URL.
$vc_paths['DIR_BASE']     	= $path_dir_base;                                	// Pasta entre domínio e pasta da plataforma.
$vc_paths['DIR_CONTROL']  	= "c/";                                          	// Pasta onde guarda todos os arquivos da plataforma (controle).
$vc_paths['PATH_CONTROL'] 	= $vc_paths['DIR_BASE'] . $vc_paths['DIR_CONTROL'];	// Caminho para a pasta de controle

// Paths iniciais
$vc_paths['PATH_RAIZ'] 		= str_replace('\\', '/', getcwd()) . '/';   		// Caminho completo do HD até o index.
$vc_paths['PATH_URL']  		= $path_raiz_url;                           		// Caminho completo da URL.
$vc_paths['BASE']      		= $path_dir_base;                           		// Pasta entre domínio e pasta da plataforma.
$vc_paths['DIR']       		= "c/";                                     		// Pasta onde guarda todos os arquivos da plataforma (controle).
$vc_paths['PATH']      		= $vc_paths['BASE'] . $vc_paths['DIR'];  			// Caminho para a pasta de controle.

// Paths da Plataforma.
$vc_paths['P_RAIZ']        	= $vc_paths['PATH'] . "plataforma/";    				// Caminho para pasta dos arquivos da plataforma.
$vc_paths['P_PATH_BD']          	= $vc_paths['P_RAIZ'] . 'bd/';                  		// Caminho da pasta bd.
$vc_paths['P_PATH_CLASSES']     	= $vc_paths['P_RAIZ'] . 'classes/';             		// Caminho da pasta classes.
$vc_paths['P_PATH_CONTROLLERS'] 	= $vc_paths['P_RAIZ'] . 'controllers/';         		// Caminho da pasta controllers.
$vc_paths['P_PATH_OBJS']        	= $vc_paths['P_RAIZ'] . 'objs/';                		// Objetos HTML personalizados para uso da plataforma.
$vc_paths['P_PATH_SRC']         	= $vc_paths['P_RAIZ'] . 'src/';                 		// Complementos da página.
$vc_paths['P_PATH_CSS']         	= $vc_paths['P_RAIZ'] . 'src/css/';             		// Arquivos css.
$vc_paths['P_PATH_FONTS']       	= $vc_paths['P_RAIZ'] . 'src/fonts/';           		// Fontes.
$vc_paths['P_PATH_JS']          	= $vc_paths['P_RAIZ'] . 'src/js/';              		// Arquivos js.
$vc_paths['P_PATH_LIBS']        	= $vc_paths['P_RAIZ'] . 'src/libs/';            		// Bibliotecas e funções já consolidadas e disponibilizadas.
$vc_paths['P_PATH_MIDIAS']      	= $vc_paths['P_RAIZ'] . 'src/midias/';          		// Todas as mídias (fotos, imagens, vídeos, documentos, planilhas, arquivos, programas, etc.) do módulo.
$vc_paths['P_PATH_UPLOADS']     	= $vc_paths['P_RAIZ'] . 'src/midias/uploads/';  		// Mídias específicas de upload.

$vc_paths['P_BD']          	= 'bd/';                  		// Caminho da pasta bd.
$vc_paths['P_CLASSES']     	= 'classes/';             		// Caminho da pasta classes.
$vc_paths['P_CONTROLLERS'] 	= 'controllers/';         		// Caminho da pasta controllers.
$vc_paths['P_OBJS']        	= 'objs/';                		// Objetos HTML personalizados para uso da plataforma.
$vc_paths['P_SRC']         	= 'src/';                 		// Complementos da página.
$vc_paths['P_CSS']         	= 'src/css/';             		// Arquivos css.
$vc_paths['P_FONTS']       	= 'src/fonts/';           		// Fontes.
$vc_paths['P_JS']          	= 'src/js/';              		// Arquivos js.
$vc_paths['P_LIBS']        	= 'src/libs/';            		// Bibliotecas e funções já consolidadas e disponibilizadas.
$vc_paths['P_MIDIAS']      	= 'src/midias/';          		// Todas as mídias (fotos, imagens, vídeos, documentos, planilhas, arquivos, programas, etc.) do módulo.
$vc_paths['P_UPLOADS']     	= 'src/midias/uploads/';  		// Mídias específicas de upload.


// API
$vc_paths['A_RAIZ']  		= $vc_paths['PATH'] . 'api/';              			// Pasta onde guarda todas as APIs.
$vc_paths['A_NAME']  		= v3\Core::getApi($vc_paths['A_RAIZ']);              // Nome da API atual.
$vc_paths['A_ATIVO'] 		= ($vc_paths['A_NAME']) ? 1 : 0;                       	// É uma API.
$vc_paths['A_PATH']  		= $vc_paths['A_RAIZ'] . $vc_paths['A_NAME'] . '/';  	// Caminho completo da API atual.

$vc_paths['A_PATH_BD']          	= $vc_paths['A_PATH'] . "bd/";                  	// Consultas ao BD por assunto.
$vc_paths['A_PATH_CLASSES']     	= $vc_paths['A_PATH'] . "classes/";             	// Classes para funções personalizadas da API.
$vc_paths['A_PATH_CONTROLLERS'] 	= $vc_paths['A_PATH'] . "controllers/";         	// Configurações personalizadas da API.
$vc_paths['A_PATH_ESTRUTURA']   	= $vc_paths['A_PATH'] . "estrutura/";           	// Estrutura HTML personalizada da API.
$vc_paths['A_PATH_OBJS']        	= $vc_paths['A_PATH'] . "objs/";                	// Objetos HTML personalizados da API.
$vc_paths['A_PATH_FUNCTIONS']   	= $vc_paths['A_PATH'] . "functions/";           	// Controle das funções de api.
$vc_paths['A_PATH_SRC']         	= $vc_paths['A_PATH'] . "src/";                 	// Pasta para guardar complementos da página.
$vc_paths['A_PATH_CSS']         	= $vc_paths['A_PATH'] . "src/css/";             	// Pasta que guarda arquivos css.
$vc_paths['A_PATH_FONTS']       	= $vc_paths['A_PATH'] . "src/fonts/";           	// Pasta que guarda fontes.
$vc_paths['A_PATH_JS']          	= $vc_paths['A_PATH'] . "src/js/";              	// Pasta que guarda arquivos js.
$vc_paths['A_PATH_LIBS']        	= $vc_paths['A_PATH'] . "src/libs/";            	// Pasta que guarda bibliotecas e funções já cons
$vc_paths['A_PATH_MIDIAS']      	= $vc_paths['A_PATH'] . "src/midias/";          	// Pasta que guarda todas as mídias (fotos, image
$vc_paths['A_PATH_UPLOADS']     	= $vc_paths['A_PATH'] . "src/midias/uploads/";  	// Pasta que guarda mídias específicas de upload.

$vc_paths['A_BD']          		= "bd/";                  						// Consultas ao BD por assunto.
$vc_paths['A_CLASSES']     		= "classes/";             						// Classes para funções personalizadas da API.
$vc_paths['A_CONTROLLERS'] 		= "controllers/";         						// Configurações personalizadas da API.
$vc_paths['A_ESTRUTURA']   		= "estrutura/";           						// Estrutura HTML personalizada da API.
$vc_paths['A_OBJS']        		= "objs/";                						// Objetos HTML personalizados da API.
$vc_paths['A_FUNCTIONS']   		= "functions/";           						// Controle das funções de api.
$vc_paths['A_SRC']         		= "src/";                 						// Pasta para guardar complementos da página.
$vc_paths['A_CSS']         		= "src/css/";             						// Pasta que guarda arquivos css.
$vc_paths['A_FONTS']       		= "src/fonts/";           						// Pasta que guarda fontes.
$vc_paths['A_JS']          		= "src/js/";              						// Pasta que guarda arquivos js.
$vc_paths['A_LIBS']        		= "src/libs/";            						// Pasta que guarda bibliotecas e funções já cons
$vc_paths['A_MIDIAS']      		= "src/midias/";          						// Pasta que guarda todas as mídias (fotos, image
$vc_paths['A_UPLOADS']     		= "src/midias/uploads/";  						// Pasta que guarda mídias específicas de upload.

// Módulo
$vc_paths['M_RAIZ']    		= $vc_paths['PATH'] . 'modulos/';          			// Pasta onde guarda todas as APIs.
$vc_paths['M_DEFAULT'] 		= 'www';                                         	// Pasta onde guarda todas as APIs.
$vc_paths['M_NAME']    		= v3\Core::getModulo($vc_paths['M_RAIZ'], $vc_paths['M_DEFAULT']);           // Nome da API atual.
$vc_paths['M_ATIVO']   		= ($vc_paths['M_NAME']) ? 1 : 0;                       	// É uma API.
$vc_paths['M_PATH']    		= $vc_paths['M_RAIZ'] . $vc_paths['M_NAME'] . '/';  	// Caminho completo da API atual.

$vc_paths['M_PATH_BD']          = $vc_paths['M_PATH'] . "bd/";					// Consultas ao BD por assunto.
$vc_paths['M_PATH_CLASSES']     = $vc_paths['M_PATH'] . "classes/";				// Classes para funções personalizadas do módulo.
$vc_paths['M_PATH_CONTROLLERS'] = $vc_paths['M_PATH'] . "controllers/";			// Caminho da pasta controllers.
$vc_paths['M_PATH_ESTRUTURA']   = $vc_paths['M_PATH'] . "estrutura/";				// Estrutura HTML personalizada do módulo.
$vc_paths['M_PATH_OBJS']        = $vc_paths['M_PATH'] . "objs/";					// Objetos HTML personalizados do módulo.
$vc_paths['M_PATH_VIEW']        = $vc_paths['M_PATH'] . "pages/v/";				// Conteúdo HTML das páginas.
$vc_paths['M_PATH_CONTROLLER']  = $vc_paths['M_PATH'] . "pages/c/";				// Controle e configuração da construção da página.
$vc_paths['M_PATH_SRC']         = $vc_paths['M_PATH'] . "src/";					// Complementos da página.
$vc_paths['M_PATH_CSS']         = $vc_paths['M_PATH'] . "src/css/";				// Arquivos css.
$vc_paths['M_PATH_FONTS']       = $vc_paths['M_PATH'] . "src/fonts/";				// Fontes.
$vc_paths['M_PATH_JS']          = $vc_paths['M_PATH'] . "src/js/";				// Arquivos js.
$vc_paths['M_PATH_LIBS']        = $vc_paths['M_PATH'] . "src/libs/";				// Bibliotecas e funções já consolidadas e disponibilizadas.
$vc_paths['M_PATH_MIDIAS']      = $vc_paths['M_PATH'] . "src/midias/";			// Todas as mídias (fotos, imagens, vídeos, documentos, planilhas, arquivos, programas, etc.) do módulo.
$vc_paths['M_PATH_UPLOADS']     = $vc_paths['M_PATH'] . "src/midias/uploads/";	// Mídias específicas de upload.

$vc_paths['M_BD']          		= "bd/";                  						// Consultas ao BD por assunto.
$vc_paths['M_CLASSES']     		= "classes/";             						// Classes para funções personali
$vc_paths['M_CONTROLLERS'] 		= "controllers/";         						// Caminho da pasta controllers.
$vc_paths['M_ESTRUTURA']   		= "estrutura/";           						// Estrutura HTML personalizada d
$vc_paths['M_OBJS']        		= "objs/";                						// Objetos HTML personalizados do
$vc_paths['M_VIEW']        		= "pages/v/";             						// Conteúdo HTML das páginas.
$vc_paths['M_CONTROLLER']  		= "pages/c/";             						// Controle e configuração da con
$vc_paths['M_SRC']         		= "src/";                 						// Complementos da página.
$vc_paths['M_CSS']         		= "src/css/";             						// Arquivos css.
$vc_paths['M_FONTS']       		= "src/fonts/";           						// Fontes.
$vc_paths['M_JS']          		= "src/js/";              						// Arquivos js.
$vc_paths['M_LIBS']        		= "src/libs/";            						// Bibliotecas e funções já conso
$vc_paths['M_MIDIAS']      		= "src/midias/";          						// Todas as mídias (fotos, imagen
$vc_paths['M_UPLOADS']     		= "src/midias/uploads/";  						// Mídias específicas de upload.

// GUARDA OS PATHS NA CONSTANTE
define("VC_PATHS", $vc_paths);
// Libera memória.
unset($vc_paths);








/**
 * ********************************************************************************************
 * INFORMAÇÕES GERAIS
 * ********************************************************************************************
 */

/**
 * INFORMAÇÕES GERAIS
 * * *******************
 * Informações gerais para toda plataforma.
 */
define("VC_INFO", [

	// INFORMAÇÕES GERAIS
	// *********************
	// Nome da empresa.
	'empresa'         => 'COOPAMA',
	'slogan'          => 'Soluções no Agronegócio',
	'nomeFantasia'    => 'Coopama Soluções no Agronegócio',
	'razaoSocial'     => 'Coopama Soluções no Agronegócio',
	'cnpj'            => '123456789',
	'ie'              => '123456789',
	'endereco'        => 'Rua tal, número 12. Brasil - Machado/MG.',
	'email'           => 'mateus.brust@coopama.com.br',
	'emailSuporte'    => 'mateus.brust@coopama.com.br',
	'telefoneSuporte' => '35 3295-0171',
	'telefone'        => '35 9 1234-1234',
	'whatsapp'        => '35 9 1234-1234',
	'since'           => '1917',
	'dataAtual'       => date('d/m/Y H:i:s'),
	'anoAtual'        => date('Y'),
	'logo'            => 'logo.png',
	'logo'            => 'logo.png',


	// MENSAGENS PARA USUÁRIO
	// *********************
	// Página não encontrada.
	'404'             => 'Página não encontrada, removida ou em desenvolvimento. Acesse o menu.',
	// Usuário não tem permissões para a página ou funções da página.
	'permissaoNegada' => 'Usuário não tem acesso ao conteúdo ou funções dessa página.',


	// INFORMAÇÕES ADICIONAIS PARA HEAD
	// *********************
	// Arquivo js ou css, o próprio código ou livre para acrescentar conteúdo na head.
	'headGeral'       	=> '',   // Inclui antes de fechar a tag </head>
	'scriptHeadGeral' 	=> '',   // Escreve dentro de uma tag <script></script> antes da </head>.
	'scriptBodyGeral' 	=> '',   // Escreve dentro de uma tag <script></script> antes da </body>.
	'styleHeadGeral'  	=> '',   // Escreve dentro de uma tag <script></script> antes da </head>.
	'styleBodyGeral'  	=> '',   // Escreve dentro de uma tag <script></script> antes da </body>.


	// INFORMAÇÕES DE SEO
	// *********************
	// Informações que vão ser usadas para SEO na página.
	'title'            => 'ND',                         // Título da página exibido na aba/janela navegador.
	'author'           => 'Mateus Brust',             // Autor do desenvolvimento da página ou responsável.
	'description'      => '',                         // Resumo do conteúdo do site em até 90 carecteres.
	'keywords'         => '',                         // palavras minúsculas separadas por "," em até 150 caracteres.
	'content_language' => 'pt-BR',                    // Linguagem primária da página (pt-br).
	'content_type'     => 'text/html',                // Tipo de codificação da página.
	'reply_to'         => 'contato@coopama.com.br',   // E-mail do responsável da página.
	'charset'          => 'utf-8',                    // Charset da página.
	'image'            => 'logo.png',				  // Imagem redes sociais.
	'url'              => 'coopama',				  // Url para instagram.
	'site'             => 'coopama',				  // Site para twitter.
	'creator'          => 'coopama',				  // Perfil criador twitter.
	'author_article'   => 'coopama',				  // Autor do artigo da página atual.
	'generator'        => 'vscode',                   // Programa usado para gerar página.
	'refresh'          => false,                      // Tempo para recarregar a página.
	'redirect'         => false,                      // URL para redirecionar usuário após refresh.
	'favicon'          => 'favicon.ico',              // Imagem do favicon na página.
	'icon'             => 'favicon.ico',              // Imagem ícone da empresa na página.
	'appletouchicon'   => 'favicon.ico',              // Imagem da logo na página.
]);









/**
 * ********************************************************************************************
 * INFORMAÇÕES DE USUÁRIO GERAL
 * ********************************************************************************************
 */

/**
 * INFORMAÇÕES USUÁRIO OFFLINE
 * * *******************
 * Usuário sem banco de dados.
 * A segurança segue esse padrão.
 */
$userinfo[0] = [
	'id'         => '1',           // Identificador único.
	'off'		 => true,		   // Identifica se é um login offline.
	'nome'       => 'Admin',       // Nome para ser exibido.
	'login'      => 'admin',       // Identificação de usuário (user, matricula, email, id).
	'senha'      => 'admin',       // Senha usada para logar. Depois é retirada da sessão.
	'permission' => '111111111',   // Permissões personalizadas do usuário logado. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
	'groups'     => [1,2,3],           // Grupos que usuário pertence.
];

$userinfo[1] = [
	'id'         => '2',           // Identificador único.
	'off'		 => true,		   // Identifica se é um login offline.
	'nome'       => 'Grupo',       // Nome para ser exibido.
	'login'      => 'grupo',       // Identificação de usuário (user, matricula, email, id).
	'senha'      => 'grupo',       // Senha usada para logar. Depois é retirada da sessão.
	'permission' => '111110000',   // Permissões personalizadas do usuário logado. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
	'groups'     => [2],           // Grupos que usuário pertence.
];

$userinfo[2] = [
	'id'         => '3',           // Identificador único.
	'off'		 => true,		   // Identifica se é um login offline.
	'nome'       => 'Publico',     // Nome para ser exibido.
	'login'      => 'publico',     // Identificação de usuário (user, matricula, email, id)
	'senha'      => 'publico',     // Senha usada para logar. Depois é retirada da sessão.
	'permission' => '110000000',   // Permissões personalizadas do usuário logado. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
	'groups'     => [3],           // Grupos que usuário pertence.
];

/**
 * GUARDA AS INFORMAÇÕES NA CONSTANTE
 */
define("VC_INFOUSER", $userinfo);
// Libera memória.
unset($userinfo);








/**
 * ********************************************************************************************
 * SEGURANÇA
 * ********************************************************************************************
 */

/**
 * SEGURANÇA
 * * *******************
 * Define níveis de permissões e fatores extras de segurança.
 */
define("VC_SECURITY", [

	// Controller usará controller de segurança.
	'ativo'             => true,

	// Usuário só acessa a controller logado.
	'session'           => true,

	// Nome da sessão deste projeto.
	'sessionName'       => 'v3',

	// Tempo para sessão acabar.
	'sessionTimeOut'    => (60 * 30),

	// Caminho para página de login.
	'loginPage'         => 'www/login/',

	// Caminho para página restrita.
	'restrictPage'      => 'www/admin/',

	// Permissões personalizadas da página atual. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
	'permission'        => '111111111',

	// Transações de dados (GET - POST) apenas com token. Usar classe Tokens. Exemplo: (<input name="token" type="text" value="{{token}}" hidden>').
	'token'             => true, // Só aceitar com token.

	// FeedBack padrão de nível de acesso.
	'feedback'          => true,

	// Receber transações externas. Acesso direto de outras origens.
	'origin'            => [
		// 'v3.local',  // URL teste.
	],

	// Grupos que tem permissão TOTAL a esta controller. Usar apenas para teste.
	'groups'            => [
		// 1, // Grupo ID: 1.
	],

	// IDs que tem permissão TOTAL a esta controller. Usar apenas para teste.
	'ids'            => [
		// 1, // Login ID: 1.
	],
]);








/**
 * ********************************************************************************************
 * API
 * ********************************************************************************************
 */

/**
 * API
 * * *******************
 * Configurações da API.
 */
define("VC_API", [

	// Tipo do retorno do cabeçalho http.
	'contentType'    => 'application/json',

	// Tipo de codificação do cabeçalho http.
	'charset'        => 'utf-8',
]);








/**
 * ********************************************************************************************
 * MODULO MENUS
 * ********************************************************************************************
 */

/**
 * MENUS
 * * *******************
 * Menus padrão para páginas.
 */
define("VC_MENUS", [

	// Função:
	'index' => [
		'title'    => 'Início',      // Nome exibido no menu.
		'permission' => '110000000',   // Permissões necessárias para acesso.
		'groups'   => [],            // Quais grupos tem acesso a esse menu.
		'ids'      => [],            // Quais ids tem acesso a esse menu.
	],

]);










/**
 * ********************************************************************************************
 * PHP
 * ********************************************************************************************
 */
// Algumas configurações PHP estão divididas dentro dos ambientes no início do arquivo. 
// Como por exemplo exibição de erros.

// Horário de brasília
date_default_timezone_set('America/Sao_Paulo');

// ini_set('post_max_size', '256M');
// ini_set('upload_max_filesize', '256M');









/**
 * ********************************************************************************************
 * TOKENS
 * ********************************************************************************************
 */
/**
 * ESTRUTURA HTML
 * * *******************
 * Personalização da estrutura da página HTML.
 */
define("VC_TOKENS", [

	// Token geral de alteração diária.
	'geralDiario' => hash("sha256", 'vctoken' . date('dmy') . '@2019'),

	// Token geral fixo.
	'geralFixo' => hash("sha256", 'vctoken@2019'),
	
	// API Token registro de ações.
	'apiRegistro' => hash("sha256", 'vcregistro' . date('dmy') . '@2019'),

]);
