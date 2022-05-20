<?php

/**
 * PLUGIN MODELO
 */
class Agra
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
        // * Dados de configuração
        // Prepara os dados. (pode ser de algum banco de dados)
		$dados['conteudo'] = 'plugin';
        $dados['URL_RAIZ'] = URL_RAIZ;
        $dados['PATH_MODEL_PLUGINS'] = PATH_MODEL_PLUGINS;
        $dados['PATH_PLUGIN'] = URL_RAIZ . PATH_MODEL_PLUGINS;


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


        // Monta um html com os dados e retorna um html em linha.
		$dados['agratool'] = TratamentoDados::minification(ControllerRender::renderPluginView('agra/agratool', $dados));
        // Monta um html com os dados e retorna um html em linha.
		$dados['janelaAgra'] = TratamentoDados::minification(ControllerRender::renderPluginView('agra/janela', $dados));

        // Renderiza o js com os dados ou html. (O js normalmente desenhará o html e os dados na tela.)
		$plugins = ControllerRender::renderPluginJs('agra/load', $dados);

		// $plugins = ControllerRender::renderPluginJs('agra/shared-worker', $dados);

        // retorna os dados em forma de JS puro.
        return $plugins;
    }
}