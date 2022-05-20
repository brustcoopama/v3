<?php

/**
 * PLUGIN MODELO
 */
class Modelo
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

        // Monta um html com os dados e retorna um html em linha.
        // Minifica para poder caber no js sem atrapalhar o script. (não aceita quebra de linha)
		$dados['conteudo'] = TratamentoDados::minification(ControllerRender::renderPluginView('modelo/item', $dados));

        // Renderiza o js com os dados ou html. (O js normalmente desenhará o html e os dados na tela.)
		$plugins = ControllerRender::renderPluginJs('modelo/alert', $dados);

        // retorna os dados em forma de JS puro.
        return $plugins;
    }
}