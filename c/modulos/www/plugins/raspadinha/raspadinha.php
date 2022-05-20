<?php

/**
 * PLUGIN MODELO
 */
class Raspadinha
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

		// Prepara os dados. (pode ser de algum banco de dados)
		$dados['conteudo'] = 'plugin';
        $dados['URL_RAIZ'] = URL_RAIZ;
        $dados['PATH_MODEL_PLUGINS'] = PATH_MODEL_PLUGINS;
        $dados['PATH_PLUGIN'] = URL_RAIZ . PATH_MODEL_PLUGINS;

        // Monta um html com os dados e retorna um html em linha.
		$dados['raspadinhatool'] = TratamentoDados::minification(ControllerRender::renderPluginView('raspadinha/raspadinhatool', $dados));

        // Renderiza o js com os dados ou html. (O js normalmente desenhará o html e os dados na tela.)
		$plugins = ControllerRender::renderPluginJs('raspadinha/raspadinha', $dados);

        // retorna os dados em forma de JS puro.
        return $plugins;
    }
}