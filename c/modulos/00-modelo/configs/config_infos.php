<?php

/**
 * Class: config_infos
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Guarda todas as configurações de conexão. Conexões ativas e bloqueadas.
 * Create: 18/04/2022
 * Update: 18/04/2022
 * 
 * Registros:
 * 18/04/2022 - Criação
 * 
 */

define("VC_P_I_NAME", TRUE);		// Prefixo das tabelas.

// Define as informações do projeto.
define("VC_P_I_EMPRESA", [
	// Nome da empresa.
	'prefixo'       => '',
	'empresa'      => 'COOPAMA',
	'sufixo'        => '',
	'sigla'        => 'COOP',
	'slogan'       => 'Soluções no Agronegócio',
	'nomeFantasia' => 'Coopama Soluções no Agronegócio',
	'razaoSocial'  => 'Coopama Soluções no Agronegócio',
	'cnpj'         => '123456789',
	'ie'           => '123456789',
	'endereco'     => 'Rua tal, número 12. Brasil - Machado/MG.',
	'email'        => 'mateus.brust@coopama.com.br',
	'telefone'     => '35 9 1234-1234',
	'whatsapp'     => '35 9 1234-1234',
	'since'        => '1900',
	'dataAtual'    => date('d/m/Y H:i:s'),
	'anoAtual'     => date('Y'),
	'logo'         => VC_PATH_MODULO_MIDIAS . 'logo.png',

	// Exemplo que pode acrescentar.
	// 'logoNegativa' => VC_PATH_MODULO_MIDIAS . 'logoNegativa.png',
	// 'logoPositiva' => VC_PATH_MODULO_MIDIAS . 'logoPositiva.png',
]);

// Define informações de SEO geral.
define("VC_P_I_METAS", [
	'title'            => 'Coopama',                                        // Título da página exibido na aba/janela navegador.
	'author'           => 'Coopama',                                        // Autor do desenvolvimento da página ou responsável.
	'description'      => 'Coopama - Soluções no Agronegócio.',             // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
	'keywords'         => 'coopama, solução, agro, agronegócio, negócio',   // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
	'content-language' => 'pt-BR',                                          // Linguagem primária da página (pt-br).
	'content-type'     => 'text/html',                                      // Tipo de codificação da página.
	'reply-to'         => 'mateus.brust@coopama.com.br',                    // E-mail do responsável da página.
	'generator'        => 'vscode',                                         // Programa usado para gerar página.
	'refresh'          => false,                                            // Tempo para recarregar a página.
	'redirect'         => false,                                            // URL para redirecionar usuário após refresh.
	'favicon'          => VC_PATH_MODULO_MIDIAS . 'favicon.ico',            // Imagem do favicon na página.
	'icon'             => VC_PATH_MODULO_MIDIAS . 'logo.png',               // Imagem ícone da empresa na página.
	'appletouchicon'   => VC_PATH_MODULO_MIDIAS . 'logo.png',               // Imagem da logo na página.

	// Outras informações para head.
	'obs'              => false,                                        	// Outra qualquer observação sobre a página.
]);