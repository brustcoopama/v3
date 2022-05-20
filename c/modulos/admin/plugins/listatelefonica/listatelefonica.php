<?php

/**
 * PLUGIN LISTA TELEFÔNICA
 */
class ListaTelefonica
{
    
    /**
     * Banco de dados utilizados no plugin.
     */
    public static $bds = [
        'controle/users/BdUsers',   // Usuários.
        'controle/contacts/BdContacts',   // Contatos.
    ];


    /**
     * Classes Utilizadas no plugin.
     */
    public static $classes = [
        'JWT',   // Token
        'TratamentoDados',   // Minificação.
    ];


    /**
     * Função que executa as ações do plugin e retorna um JS.
     *
     * @return void
     */
    static function start($params)
    {

        // Carrega os contatos.
		// $dados['usuarios'] = \controle\BdUsers::selecionaTudoCompleto();
		$dados['usuarios'] = \controle\BdUsers::selecionaCompleto(null, null);
        
        // Percorre cada usuário e acrescenta os contatos e endereços.
		foreach ($dados['usuarios'] as $key => $value) {

            // Acrescenta os contatos.
			// $dados['usuarios'][$key]['contacts'] = \controle\BdContacts::selecionaCompletoPorUser($value['id']);
			$dados['usuarios'][$key]['contacts'] = \controle\BdContacts::selecionaTelefonesProfissional($value['id']);

            if ($dados['usuarios'][$key]['contacts']) {
                foreach ($dados['usuarios'][$key]['contacts'] as $keyC => $r) {
                    $dados['usuarios'][$key]['contacts'][$keyC]['valorBr'] = TratamentoDados::telefoneBr($r['valor']);
                }
            }

            // Acrescenta os endereços.
			// $dados['usuarios'][$key]['contacts'] = \controle\BdContacts::selecionaCompletoPorUser($value['idUser']);

            // Monta a foto de perfil padrão HMTL.
            $fotoPerfil = [
                'matricula' => $dados['usuarios'][$key]['matricula'],
                'nome' => $dados['usuarios'][$key]['nome'],
                'URL_RAIZ' => URL_RAIZ,
                'foto' => $dados['usuarios'][$key]['urlMidia'],
                'width' => '36px',
            ];
			$dados['usuarios'][$key]['fotoPerfil'] = ControllerRender::renderObj('publicos/fotoPerfil', $fotoPerfil);
		}
        
        // Monta a lista inteira HTML
		$lista['lista'] = TratamentoDados::minification(ControllerRender::renderPluginView('listatelefonica/item_lista_telefonica', $dados));

        // Manda a lista para dentro da tool.
		$dados = null;
		$dados['conteudo'] = TratamentoDados::minification(ControllerRender::renderPluginView('listatelefonica/tool_lista_telefonica', $lista));

        $dados['URL_RAIZ'] = URL_RAIZ;
        // Guarda o Token api para usar ajax.
        $dados['formTokenApi'] = JWT::formTokenApi();

        // Monta o plugin e manda pro site.
		$plugins = ControllerRender::renderPluginJs('listatelefonica/listatelefonica', $dados);

        return $plugins;
    }
}