<?php

/**
 * PLUGIN MODELO
 */
class Chat
{
    
    /**
     * Banco de dados utilizados no plugin.
     */
    public static $bds = [
        // 'controle/contacts/BdContacts',   // Contatos.
    ];


    /**
     * Classes Utilizadas no plugin.
     */
    public static $classes = [
        'JWT',   // Minificação.
        'TratamentoDados',   // Minificação.
    ];


    /**
     * Função que executa as ações do plugin e retorna um JS.
     *
     * @return void
     */
    static function start($params)
    {
		// * JWT
		$payload = [
			'id' => ControllerSecurity::getSession('id'),
			'matricula' => ControllerSecurity::getSession('matricula'),
			'nome' => ControllerSecurity::getSession('firstName'),
		];
		$dados['jwt'] = JWT::createToken($payload);

		// * Dados usuário
		$login = ControllerSecurity::getSession();
		// Carrega dados tabela users.
		$user = \controle\BdUsers::selecionaPorId($login['idUser']);
		// Carrega foto default.
		$user['urlFoto'] = URL_RAIZ . PATH_MODEL_IMG . 'default_perfil.png';
		// Verifica se usuário tem foto.
		if (isset($user['idFoto'])) {
			$midia = \controle\BdMidias::selecionaPorId($user['idFoto']);
			if (isset($midia['urlMidia']))
				$user['urlFoto'] = $midia['urlMidia'];
		}
		// Joga para os parâmetros da página {{page.login}} informações da tabela Login e Usuário.
		$userInfo = array_merge($login, $user);
		$dados['firstName'] = ControllerSecurity::getSession('firstName');
		$dados['userInfo'] = $userInfo;

		// * Configuração
		// $dados['server_url'] = str_replace('/:', ':', str_replace(array('http:','https:'), array('ws:','wss:'), URL_RAIZ) . ':8081/') . '';
		// $dados['CONF_GERAL_SOCKET'] = str_replace('/:', ':', str_replace(array('http:','https:'), 'ws:', URL_RAIZ) . ':8081/') . '';
		$dados['CONF_GERAL_SOCKET'] = CONF_GERAL_SOCKET;
		$dados['icon'] = URL_RAIZ . PATH_MODEL_IMG . 'icon_coopama.png';
		$dados['URL_RAIZ'] = URL_RAIZ;

		// * Desenho
		$dados['conteudo'] = str_replace(array("\r", "\n", "\t", "  "), '', ControllerRender::renderPluginView('chat/chat'));
		$dados['chattools'] = TratamentoDados::minification(ControllerRender::renderPluginView('chat/chattools'));
		$plugins = ControllerRender::renderPluginJs('chat/chat', $dados);

        // retorna os dados em forma de JS puro.
        return $plugins;
    }
}