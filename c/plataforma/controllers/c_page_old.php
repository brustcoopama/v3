<?php

namespace controllers;

echo '<br>' . __FILE__;

/**
 * Class: Page
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar toda a aplicação.
 * Create: 12/04/2022
 * Update: 18/04/2022
 * 
 * Registros:
 * 12/04/2022 - Criação
 * 18/04/2022 - Ajustes e atualizações para v3.
 * 
 */
class Page extends \controllers\Api
{

	/**
	 * PARÂMETROS DA CLASSE
	 * **************************************************************************
	 */

	// Configurações gerais da página.
	private static $params;
	public static function getParams($param = false)
	{
		if ($param)
			return self::$params[$param];
		return self::$params;
	}



	/**
	 * FUNÇÕES DA CLASSE
	 * **************************************************************************
	 */


	/**
	 * Construtor.
	 * Controi a controller da página com valores default.
	 */
	function __construct()
	{
		
		// Trata o nome do controller.
		$this->controllerName = \v3\Core::getInfoUrl();

		// Pega os atributos (parametros passados pela url).
		$this->attr = \v3\Core::getInfoUrl('attr');

		// url da página atual.
		$this->urlAtual  = explode('.', \v3\Core::getInfoUrl('path_view'))[0] . '/';

		// Valores default de $paramsSecurity.
		$this->params['security'] = array(
			'session'    => true,          // Página guarda sessão.
			'permission' => '000000000',   // [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
			'formToken'  => false,         // Ativa necessidade de token para transações de formulários via post. usar parametro: ($this->params['page']['formToken']) input text: (<input name="f-formToken" type="text" value="{{formToken}}" hidden>').
		);

		// Valores default de $paramsTemplate a partir da pasta template.
		$this->params['template'] = array(
			'html'        => 'default',   // Template HTML
			'head'        => 'default',   // <head> da página.
			'top'         => 'default',   // Topo da página.
			'header'      => 'default',   // Menu da página.
			'corpo'       => 'default',   // Reservado para CORPO.
			'body_pre'    => 'default',   // Antes do CORPO dentro body.
			'body_pos'    => 'default',   // Depois do CORPO dentro body.
			'footer'      => 'default',   // footer da página.
			'bottom'      => 'default',   // Fim da página.
			// 'maintenance' => 'default',   // Página de manutenção (quando controller true).
		);

		// Valores que podem ser inseridos em todas página.
		// Exemplo: 'empresa' => 'COOPAMA',
		// Exemplo de uso view: <p><b>Empresa: </b> {{empresa}}</p>
		$this->params['global'] = array(
			// Config
			'DIR_RAIZ'              => DIR_RAIZ,                       // Path dir desde a raíz.
			'URL_RAIZ'              => URL_RAIZ,                       // Path URL.
			'DIR_BASE'              => DIR_BASE,                       // Path URL.
			'PATH_MODEL_ASSETS'     => URL_RAIZ . PATH_MODEL_ASSETS,   // Path m/assets/.
			'PATH_MODEL_CSS'        => URL_RAIZ . PATH_MODEL_CSS,      // Path m/assets/css/.
			'PATH_MODEL_IMG'        => URL_RAIZ . PATH_MODEL_IMG,      // Path m/assets/img.
			'PATH_MODEL_JS'         => URL_RAIZ . PATH_MODEL_JS,       // Path m/assets/js.
			'PATH_MODEL_MIDIA'      => URL_RAIZ . PATH_MODEL_MIDIA,    // Path m/midia.
			'PATH_MODEL_ADMIN'      => URL_RAIZ . PATH_MODEL_ADMIN,    // Path.
			'CONF_GERAL_SOCKET_START' => CONF_GERAL_SOCKET_START,          // Link para startar o servidor socket.

			// Informações gerais
			'empresa'          => 'COLABORADOR',                                       // Nome da empresa.
			'attr'             => $this->attr,                                         // url completo.
			'urlInfo'          => Core::getInfoDirUrl(),                               // array url info.
			'urlAtual'         => $this->urlAtual,                                     // url da página atual.
			'favicon'          => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem favicon.
			'icon'             => URL_RAIZ . PATH_MODEL_IMG . 'icon_coopama.png',      // Imagem Icon.
			'appletouchicon'   => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem aple.
			'logo'             => URL_RAIZ . PATH_MODEL_IMG . 'logo_coopama.png',      // Imagem Logo.
			'anoAtual'         => date('Y'),                                           // Ano atual.
			// 'FeedBackMessages' => FeedBackMessagens::get(),                            // Mensagens de feedback. Tem que ser feito depois do processamento.
			// Puxar informações user.
		);


		// Valores default de $paramsView. Valores vazios são ignorados.
		//https://www.infowester.com/metatags.php
		$this->params['view'] = array(
			'title'            => 'default',   // Título da página exibido na aba/janela navegador.
			'author'           => 'default',   // Autor do desenvolvimento da página ou responsável.
			'description'      => 'default',   // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
			'keywords'         => 'default',   // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
			'content-language' => 'default',   // Linguagem primária da página (pt-br).
			'content-type'     => 'default',   // Tipo de codificação da página.
			'reply-to'         => 'default',   // E-mail do responsável da página.
			'generator'        => 'default',   // Programa usado para gerar página.
			'refresh'          => 'default',   // Tempo para recarregar a página.
			'redirect'         => 'default',   // URL para redirecionar usuário após refresh.
			'obs'              => 'default',   // Outra qualquer observação sobre a página.
		);

		// Valores default para scripts. Quais scripts a página atual necessita.
		$this->params['scripts'] = array(
			// 'js/jquery.min.js',   // TESTE.
		);

		// Valores default para estilos. Quais estilos a página atual necessita.
		$this->params['styles'] = array(
			// 'css/jquery.min.css',   // TESTE.
		);

		// Valores para serem inseridos no corpo da página.
		// Exemplo: 'p_nome' => 'Mateus',
		// Exemplo uso view: <p><b>Nome: </b> {{p_nome}}</p>
		$this->params['page'] = array(
			'versao'         => 'v1.0',               // Versão da página.
			'apiContentType' => 'application/json',   // Cabeçalho retorno da API.
			'apiCharset'     => 'utf-8',              // Codificação API.
			'formToken'      => '',                   // Token para POST gerado automaticamente. Atribuir ao input (f-formToken).
			'formTokenApi'   => '',                   // Token para POST da API gerado automaticamente. Atribuir ao input (f-formToken).
		);

		// Otimização das funções de banco de dados que serão usadas na controller.
		// Pasta e controller.
		// Exemplo: 'usuarios/BdUsuarios',
		// Exemplo uso: $var = BdUsuarios::getInfo();
		$this->params['bd'] = array(
			// 'pasta/BdArquivo',   // Exemplo
		);

		// Otimização das funções que serão usadas na controller.
		// Pasta classes.
		// Exemplo: 'classes/Noticias',
		// Exemplo uso controller: $var = Noticias::getInfo();
		$this->params['classes'] = array(
			// 'classes/Noticias',   // Exemplo
		);

		// Reutilização de funções staticas em outras controllers.
		// Pasta: c/pages.
		// Exemplo: 'admin/rh/CadastroControllerPage',
		// Exemplo uso controller: $r = CadastroControllerPage::teste(2);
		$this->params['controller'] = array(
			'admin/rh/CadastroControllerPage',   // Exemplo
		);

		// Valores default para plugins. Quais plugins a página atual necessita.
		$this->params['plugins'] = array(
			// 'modelo',   // Modelo.
		);
	}

}



















// Todo: OLD - REFAZER CADA FUNÇÃO.
class Page_OLD_APAGAR
{
	// exit;



	/**
	 * Retorna os parametros de segurança.
	 *
	 * @param string $param
	 * @return array
	 */
	public function getParamsSecurity($param = false)
	{
		if ($param)
			return $this->params['security'][$param];
		return $this->params['security'];
	}


	/**
	 * Retorna os parametros do template.
	 *
	 * @param string $param
	 * @return array
	 */
	public function getParamsTemplate($param = false)
	{
		if ($param)
			return $this->params['template'][$param];
		return $this->params['template'];
	}


	/**
	 * Retorna os parametros do global.
	 *
	 * @param string $param
	 * @return array
	 */
	public function getParamsGlobal($param = false)
	{
		if ($param)
			return $this->params['global'][$param];
		return $this->params['global'];
	}


	/**
	 * Retorna os parametros do page.
	 *
	 * @param string $param
	 * @return array
	 */
	public function getParamsPage($param = false)
	{
		if ($param)
			return $this->params['page'][$param];
		return $this->params['page'];
	}


	/**
	 * Retorna os parametros do view.
	 *
	 * @param string $param
	 * @return array
	 */
	public function getParamsView($param = false)
	{
		if ($param)
			return $this->params['view'][$param];
		return $this->params['view'];
	}


	/**
	 * Retorna os parametros do bd.
	 *
	 * @param string $param
	 * @return array
	 */
	public function getParamsBd($param = false)
	{
		if ($param)
			return $this->params['bd'][$param];
		return $this->params['bd'];
	}


	/**
	 * Retorna os parametros do classes.
	 *
	 * @param string $param
	 * @return array
	 */
	public function getParamsClasses($param = false)
	{
		if ($param)
			return $this->params['classes'][$param];
		return $this->params['classes'];
	}



	/**
	 * Construtor.
	 * Controi a controller da página com valores default.
	 */
	function __construct()
	{
		// Trata o nome do controller.
		$this->controllerName = Core::getInfoDirUrl('controller_name');

		// Pega os atributos (parametros passados pela url).
		$this->attr = Core::getInfoDirUrl('attr');

		// url da página atual.
		$this->urlAtual  = explode('.', Core::getInfoDirUrl('path_view'))[0] . '/';

		// todo: Já peguei
		// Valores default de $paramsSecurity.
		$this->params['security'] = array(
			'session'    => true,          // Página guarda sessão.
			'permission' => '000000000',   // [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
			'formToken'  => false,         // Ativa necessidade de token para transações de formulários via post. usar parametro: ($this->params['page']['formToken']) input text: (<input name="f-formToken" type="text" value="{{formToken}}" hidden>').
		);

		// todo: Já peguei - estrutura
		// Valores default de $paramsTemplate a partir da pasta template.
		$this->params['template'] = array(
			'html'        => 'default',   // Template HTML
			'head'        => 'default',   // <head> da página.
			'top'         => 'default',   // Topo da página.
			'header'      => 'default',   // Menu da página.
			'corpo'       => 'default',   // Reservado para CORPO.
			'body_pre'    => 'default',   // Antes do CORPO dentro body.
			'body_pos'    => 'default',   // Depois do CORPO dentro body.
			'footer'      => 'default',   // footer da página.
			'bottom'      => 'default',   // Fim da página.
			// 'maintenance' => 'default',   // Página de manutenção (quando controller true).
		);

		// todo: Já peguei - paths e info
		// Valores que podem ser inseridos em todas página.
		// Exemplo: 'empresa' => 'COOPAMA',
		// Exemplo de uso view: <p><b>Empresa: </b> {{empresa}}</p>
		$this->params['global'] = array(
			// Config
			'DIR_RAIZ'              => DIR_RAIZ,                       // Path dir desde a raíz.
			'URL_RAIZ'              => URL_RAIZ,                       // Path URL.
			'DIR_BASE'              => DIR_BASE,                       // Path URL.
			'PATH_MODEL_ASSETS'     => URL_RAIZ . PATH_MODEL_ASSETS,   // Path m/assets/.
			'PATH_MODEL_CSS'        => URL_RAIZ . PATH_MODEL_CSS,      // Path m/assets/css/.
			'PATH_MODEL_IMG'        => URL_RAIZ . PATH_MODEL_IMG,      // Path m/assets/img.
			'PATH_MODEL_JS'         => URL_RAIZ . PATH_MODEL_JS,       // Path m/assets/js.
			'PATH_MODEL_MIDIA'      => URL_RAIZ . PATH_MODEL_MIDIA,    // Path m/midia.
			'PATH_MODEL_ADMIN'      => URL_RAIZ . PATH_MODEL_ADMIN,    // Path.
			'CONF_GERAL_SOCKET_START' => CONF_GERAL_SOCKET_START,          // Link para startar o servidor socket.

			// Informações gerais
			'empresa'          => 'COLABORADOR',                                       // Nome da empresa.
			'attr'             => $this->attr,                                         // url completo.
			'urlInfo'          => Core::getInfoDirUrl(),                               // array url info.
			'urlAtual'         => $this->urlAtual,                                     // url da página atual.
			'favicon'          => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem favicon.
			'icon'             => URL_RAIZ . PATH_MODEL_IMG . 'icon_coopama.png',      // Imagem Icon.
			'appletouchicon'   => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem aple.
			'logo'             => URL_RAIZ . PATH_MODEL_IMG . 'logo_coopama.png',      // Imagem Logo.
			'anoAtual'         => date('Y'),                                           // Ano atual.
			// 'FeedBackMessages' => FeedBackMessagens::get(),                            // Mensagens de feedback. Tem que ser feito depois do processamento.
			// Puxar informações user.
		);


		// todo: Já peguei - metas
		// Valores default de $paramsView. Valores vazios são ignorados.
		//https://www.infowester.com/metatags.php
		$this->params['view'] = array(
			'title'            => 'default',   // Título da página exibido na aba/janela navegador.
			'author'           => 'default',   // Autor do desenvolvimento da página ou responsável.
			'description'      => 'default',   // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
			'keywords'         => 'default',   // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
			'content-language' => 'default',   // Linguagem primária da página (pt-br).
			'content-type'     => 'default',   // Tipo de codificação da página.
			'reply-to'         => 'default',   // E-mail do responsável da página.
			'generator'        => 'default',   // Programa usado para gerar página.
			'refresh'          => 'default',   // Tempo para recarregar a página.
			'redirect'         => 'default',   // URL para redirecionar usuário após refresh.
			'obs'              => 'default',   // Outra qualquer observação sobre a página.
		);




		// Valores default para scripts. Quais scripts a página atual necessita.
		$this->params['scripts'] = array(
			// 'js/jquery.min.js',   // TESTE.
		);

		// Valores default para estilos. Quais estilos a página atual necessita.
		$this->params['styles'] = array(
			// 'css/jquery.min.css',   // TESTE.
		);

		// todo: já peguei.
		// Valores para serem inseridos no corpo da página.
		// Exemplo: 'p_nome' => 'Mateus',
		// Exemplo uso view: <p><b>Nome: </b> {{p_nome}}</p>
		$this->params['page'] = array(
			'versao'         => 'v1.0',               // Versão da página.
			'apiContentType' => 'application/json',   // Cabeçalho retorno da API.
			'apiCharset'     => 'utf-8',              // Codificação API.
			'formToken'      => '',                   // Token para POST gerado automaticamente. Atribuir ao input (f-formToken).
			'formTokenApi'   => '',                   // Token para POST da API gerado automaticamente. Atribuir ao input (f-formToken).
		);

		// Otimização das funções de banco de dados que serão usadas na controller.
		// Pasta e controller.
		// Exemplo: 'usuarios/BdUsuarios',
		// Exemplo uso: $var = BdUsuarios::getInfo();
		$this->params['bd'] = array(
			// 'pasta/BdArquivo',   // Exemplo
		);

		// Otimização das funções que serão usadas na controller.
		// Pasta classes.
		// Exemplo: 'classes/Noticias',
		// Exemplo uso controller: $var = Noticias::getInfo();
		$this->params['classes'] = array(
			// 'classes/Noticias',   // Exemplo
		);

		// Reutilização de funções staticas em outras controllers.
		// Pasta: c/pages.
		// Exemplo: 'admin/rh/CadastroControllerPage',
		// Exemplo uso controller: $r = CadastroControllerPage::teste(2);
		$this->params['controller'] = array(
			'admin/rh/CadastroControllerPage',   // Exemplo
		);

		// Valores default para plugins. Quais plugins a página atual necessita.
		$this->params['plugins'] = array(
			// 'modelo',   // Modelo.
		);
	}


	/**
	 * Inicia a verificação de controle e chama função correspondente.
	 *
	 * @return void
	 */
	public function start()
	{
		// Carrega os parâmetros passados pela controller da página atual.
		$this->pre();

		// Processa os parâmetros passados pela controller da página atual. (Carrega o conteúdo html)
		$this->process();

		/**
		 * CRIA UM TOKEN DE SEGURANÇA PARA TRANSIÇÃO DE DADOS VIA POST.
		 */
		// Parâmetros do token.
		$tokenDia      = date('d');                                     // Objetivo que token dure 1 dia.
		$tokenAtributo = isset($this->attr[0]) ? $this->attr[0] : '0';  // Objetivo separar token de POST, PUT, GET, GETFULL, DELETE, TESTE. API.
		$tokenSenha    = "SetorTI";                                     // Único parâmetro interno.
		//$tokenUrl      = $this->params['view'];                         // Objetivo de garantir que saiu da mesma página. Porém tem páginas que usam apis de outras páginas (Então não implementado).
		// Cria o tooken
		// Antigo
		// $tokenTmp = md5(date('d') . (isset($this->attr[0]) ? $this->attr[0] : '0'));
		// Novo
		$tokenTmp = md5($tokenDia . $tokenAtributo . $tokenSenha);

		// Cria um token para POST da API fixo para ser usado em qualquer função (POST, PUT, GET, GETFULL, DELETE, TESTE. API).
		$this->params['page']['formTokenApi'] = md5($tokenDia . 'api' . $tokenSenha);
		// Cria o token para POST de páginas.
		$this->params['page']['formToken'] = $tokenTmp;

		// Verifica se post tem o token (f-formToken).
		$tokenVerificado = true;
		// FeedBackMessagens::set('warning', 'Atenção.', 'Sem permissão para envio de dados. Ou token incorreto.');
		if ($_POST) {
			// Verifica se segurança de token está ativa
			if (isset($this->params['security']['formToken']) && $this->params['security']['formToken'] && isset($this->attr[0]) && $_POST['f-formToken'] != $tokenTmp) {
				$_POST = null;
				FeedBackMessagens::set('warning', 'Atenção.', 'Sem permissão para envio de dados. Ou token incorreto.');
				// echo 'Sem permissão para envio de dados. Ou token incorreto.';
				// echo '<hr>';
				// echo $tokenTmp;
				// echo $this->attr[0];
				$tokenVerificado = false;
				// return false;
				// exit;
			}
		}

		// Caso não seja api, renderiza a view.
		$api = false;

		//        print_r($this->attr);
		//        exit();
		// Verifica url para ver qual REST usou.
		if ($this->attr && isset($this->attr[0])) {


			// Cria o token para validar formulários.
			// $this->params['page']['formToken'] = md5(date('d') . $this->attr[0]);

			// Verifica qual o tipo de utilizaçãoo usuário quer.
			switch ($this->attr[0]) {
				case 'post':
					if (ControllerSecurity::getPermissions('post') && $tokenVerificado)
						$this->post();
					break;
				case 'put':
					if (ControllerSecurity::getPermissions('put') && $tokenVerificado)
						$this->put();
					break;
				case 'get':
					if (ControllerSecurity::getPermissions('get') && $tokenVerificado)
						$this->get();
					break;
				case 'getfull':
					if (ControllerSecurity::getPermissions('getFull') && $tokenVerificado)
						$this->getFull();
					break;
				case 'delete':
					if (ControllerSecurity::getPermissions('delete') && $tokenVerificado)
						$this->delete();
					break;
				case 'test':
					if (ControllerSecurity::getPermissions('test') && $tokenVerificado)
						$this->test();
					break;
				case 'api':
					$api = true;
					if (ControllerSecurity::getPermissions('api') && $tokenVerificado)
						$this->api();
					break;
				default:
					$this->index();
					break;
			}
		} else if ($tokenVerificado) { // Todo: Verificar se está funcionando corretamente.
			// Caso não reconheça uma função rest, chama a index.
			$this->index();
		}


		// Carrega mensagens de FeedBack geradas nas funções.
		$this->params['global']['FeedBackMessages'] = FeedBackMessagens::get();


		// Renderiza o html e imprime na tela caso não seja solicitação de API da página.
		if (!$api) {

			// Carrega página dinâmica (do banco de dados).
			$urlPage = explode('.', Core::getInfoDirUrl('path_view'))[0] . '/';
			$html = \controle\BdPagesContent::selecionaContentPorURL($urlPage);
			$html = \controllers\Render::renderHtml($html, array_merge($this->params['page'], $this->params['global'], $this->params['view']));
			$this->paramsGlobal['pageContent'] = $html;

			echo \controllers\Render::render($this->params);
			
		}
	}




	/**
	 * 
	 * Realiza o pré processamento da página atual (controllerPage).
	 * Usado para definir os parâmetros de personalização da página filha.
	 *
	 * @return void
	 */
	public function pre()
	{
		// Usado na página filha
	}


	/**
	 * Exibe a página inicial.
	 * Usado para criar os parâmetros e dados disponibilizados na view.
	 * É executado depois do preprocessamento()
	 *
	 * @return bool
	 */
	public function index()
	{
		// Informações do delete.
		$this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

		// Caso use segurança de token ativa.
		$params['formToken'] = $this->params['page']['formToken'];

		return true;
	}


	/**
	 * Cria um registro
	 * Exibe página para criação de registros.
	 * Leve pois não busca dados no banco de dados para preencher o formulário.
	 *
	 * @return bool
	 */
	public function post()
	{
		$this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

		return false;
	}


	/**
	 * Atualiza registros.
	 * Exibe uma página com formulário para atualização de registros.
	 * Caso passe parâmetros na url, já realiza essas alterações.
	 * Caso chame a página sem parâmetros é exibido formulário com os dados de referência para atualização.
	 *
	 * @return bool
	 */
	public function put()
	{
		// Informações do delete.
		$this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

		// Caso use segurança de token ativa.
		$params['formToken'] = $this->params['page']['formToken'];


		return true;
	}


	/**
	 * Exibe registros.
	 * Usado para retornar poucos registros permitidos em uma página separada.
	 * Pode ser escolhido algum template (objs) para exibir os dados.
	 *
	 * @return void
	 */
	public function get()
	{
		// Informações do delete.
		$this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

		// Caso use segurança de token ativa.
		$params['formToken'] = $this->params['page']['formToken'];

		return true;
	}


	/**
	 * Exibe os registros completos.
	 * Usado para retornar muitos registros em uma página separada.
	 * Pode ser escolhido algum template (objs) para exibir os dados.
	 *
	 * @return void
	 */
	public function getFull()
	{
		// Informações do delete.
		$this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

		// Caso use segurança de token ativa.
		$params['formToken'] = $this->params['page']['formToken'];

		return true;
	}


	/**
	 * Deleta um registro.
	 * Usado para deletar um usuário ou classificá-lo como excluido.
	 *
	 * @return bool
	 */
	public function delete()
	{
		// Informações do delete.
		$this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

		// Caso use segurança de token ativa.
		$params['formToken'] = $this->params['page']['formToken'];

		return true;
	}


	/**
	 * Inicia a página de teste. 
	 * Usada para realizar testes sem afetar a produção.
	 *
	 * @return bool
	 */
	public function test()
	{
		// Informações do delete.
		$this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

		// Caso use segurança de token ativa.
		$params['formToken'] = $this->params['page']['formToken'];

		return true;
	}


	/**
	 * Inicia a api da página. 
	 * Usada para carregar especificidades da página.
	 * Alivia o carregamento da página e ajuda no dinamismo.
	 *
	 * @return bool
	 */
	public function api()
	{
		// // Cabeçalho para visualizar em JSON no caso de acesso direto.
		// // header('Content-Type: application/json');
		// header('Content-Type: ' . $this->params['page']['apiContentType'] . '; charset=' . $this->params['page']['apiCharset']);


		// Grava a função solicitada pela url após a api. (.../api/FUNC)
		$action  = isset($this->attr[1]) ? $this->attr[1] : null;

		// Grava os parametros solicitados pela url após a função. (.../api/func/PARAM/PARAM/...)
		$params[0] = isset($this->attr[2]) ? $this->attr[2] : null;
		$params[1] = isset($this->attr[3]) ? $this->attr[3] : null;
		$params[2] = isset($this->attr[4]) ? $this->attr[4] : null;
		$params[3] = isset($this->attr[5]) ? $this->attr[5] : null;

		// Chama a função correspondente.
		switch ($action) {
			case 'post':
				$retorno = $this->apiPost($params);
				break;
			case 'put':
				$retorno = $this->apiPut($params);
				break;
			case 'get':
				$retorno = $this->apiGet($params);
				break;
			case 'getfull':
				$retorno = $this->apiGetFull($params);
				break;
			case 'delete':
				$retorno = $this->apiDelete($params);
				break;
			case 'test':
				$retorno = $this->apiTest($params);
				break;

			default:
				$retorno['msg'] = 'Implementar a api da ' . $this->controllerName . __CLASS__ . '.';
				break;
		}

		// Retorno exemplo para Json.
		$retorno['status'] = 'OK.';
		$retorno['action'] = $action;
		$retorno['params'] = $params;
		$retorno['apiCharset'] = $this->params['page']['apiContentType'];


		// Cabeçalho para visualizar em JSON no caso de acesso direto.
		// header('Content-Type: application/json');
		header('Content-Type: ' . $this->params['page']['apiContentType'] . '; charset=' . $this->params['page']['apiCharset']);


		echo json_encode($retorno);

		// Retorna true após a execução de todo o comando.
		return true;
	}


	/**
	 *  Funções da API
	 * **********************************************************************************
	 */

	/**
	 * Função API POST
	 * Função que realiza ação solicitada.
	 *
	 * @return array
	 */
	public function apiPost($params)
	{

		// Mensagens padrão de retorno.
		$ret = 'Sem registro.';
		$msg = 'Sem retorno.';


		// code..


		// Monta array de retorno.
		$retorno = [
			'ret' => $ret,
			'msg' => $msg,
		];
		return $retorno;
	}

	/**
	 * Função API PUT
	 * Função que realiza ação solicitada.
	 *
	 * @return array
	 */
	public function apiPut($params)
	{

		// Mensagens padrão de retorno.
		$ret = 'Sem registro.';
		$msg = 'Sem retorno.';


		// code..


		// Monta array de retorno.
		$retorno = [
			'ret' => $ret,
			'msg' => $msg,
		];
		return $retorno;
	}

	/**
	 * Função API Get
	 * Função que realiza ação solicitada.
	 *
	 * @return array
	 */
	public function apiGet($params)
	{

		// Mensagens padrão de retorno.
		$ret = 'Sem registro.';
		$msg = 'Sem retorno.';


		// code..


		// Monta array de retorno.
		$retorno = [
			'ret' => $ret,
			'msg' => $msg,
		];
		return $retorno;
	}

	/**
	 * Função API GETFULL
	 * Função que realiza ação solicitada.
	 *
	 * @return array
	 */
	public function apiGetFull($params)
	{

		// Mensagens padrão de retorno.
		$ret = 'Sem registro.';
		$msg = 'Sem retorno.';


		// code..


		// Monta array de retorno.
		$retorno = [
			'ret' => $ret,
			'msg' => $msg,
		];
		return $retorno;
	}

	/**
	 * Função API DELETE
	 * Função que realiza ação solicitada.
	 *
	 * @return array
	 */
	public function apiDelete($params)
	{

		// Mensagens padrão de retorno.
		$ret = 'Sem registro.';
		$msg = 'Sem retorno.';


		// code..


		// Monta array de retorno.
		$retorno = [
			'ret' => $ret,
			'msg' => $msg,
		];
		return $retorno;
	}

	/**
	 * Função API TEST
	 * Função que realiza ação solicitada.
	 *
	 * @return array
	 */
	public function apiTest($params)
	{

		// Mensagens padrão de retorno.
		$ret = 'Sem registro.';
		$msg = 'Sem retorno.';


		// code..


		// Monta array de retorno.
		$retorno = [
			'ret' => $ret,
			'msg' => $msg,
		];
		return $retorno;
	}


	/**
	 * Realiza o processamento das configurações da controller antes de criar a página e mostrar para o usuário.
	 * Usado para chamar as dependências do banco de dados.
	 * Usado para processar o nível de segurança do usuário.
	 *
	 * @return void
	 */
	private function process()
	{

		// Verifica se página exige sessão (usuário logado).
		if ($this->params['security']['session']) {

			// Controle de sessão e permissões.
			ControllerSecurity::on($this->params['security']['permission'], $this->urlAtual);
			$this->params['global']['permissions'] = ControllerSecurity::getPermissions();

			// print_r(ControllerSecurity::getPermissions());
			// exit;

			// echo '<hr>';
			// echo $_SERVER['HTTP_HOST'];

			// Caso usuário esteja acessando a API da página. permite somente API.
			if (isset(Core::getInfoDirUrl('attr')[0]) && Core::getInfoDirUrl('attr')[0] == 'api') {
				// echo 'é uma api';
			} else {

				// Guarda url atual para registros.
				$_SESSION['URL_ATUAL'] = $this->urlAtual;

				// Carrega informações de usuário.
				// Obtém os dados da tabela login na sessão [LOGIN]
				$login = ControllerSecurity::getSession();

				// print_r($login);
				// print_r($_SESSION['use']);
				// echo 'teste';
				// exit;

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

				/**
				 * HTML Foto de Perfil.
				 */
				// Foto de perfil opções
				$fotoPerfil = [
					'matricula' => $user['matricula'],
					'nome' => $user['nome'],
					'URL_RAIZ' => URL_RAIZ,
					'foto' => $user['urlFoto'],
					'width' => '36px',
				];
				$this->params['global']['fotoPerfil'] = $this->params['page']['fotoPerfil'] = \controllers\Render::renderObj('publicos/fotoPerfil', $fotoPerfil);

				// Joga para os parâmetros da página {{page.login}} informações da tabela Login e Usuário.
				$userInfo = array_merge($login, $user);
				$this->params['page']['userInfo'] = $userInfo;


				// print_r($userInfo);
				// exit;


				/**
				 * CRONSTRÓI O MENU HTML.
				 */
				$this->params['page']['itensMenu'] = $this->carregaMenusHtml();
			}
		} else {
			// Seta permissões para visualização
			ControllerSecurity::upPermissions($this->params['security']['permission'], $this->urlAtual, true);
			$this->params['global']['permissions'] = ControllerSecurity::getPermissions();
		} // Fim sessão.

		// Carrega o template html definido na controller atual.
		$this->carregaTemplate();

		// Carrega classes de acesso ao banco definido na controller atual.
		$this->carregaBd();

		// Carrega classes de funções específicas, definida na controller atual.
		$this->carregaClasses();

		// Carrega controllers de página, definida na controller atual.
		$this->carregaController();
	}


	/**
	 * Carrega conteúdo html dos arquivos de template da pasta definida PATH_VIEW_ESTRUTURA.
	 * Carrega conteúdo html da página de conteúdo que será exibida dentro do template. definida em PATH_VIEW_PAGES.
	 *
	 * @return void
	 */
	private function carregaTemplate()
	{
		// Carrega os arquivos do parâmetro page template.
		foreach ($this->params['template'] as $key => $value) {
			// Parâmetro recebe o conteúdo HTML do arquivo.
			$this->params['template'][$key] = file_get_contents(PATH_VIEW_ESTRUTURA . $key . '/' . $value . '.html');
		}

		/**
		 * VERIFICA PERMISSÕES ANTES DE CARREGAR O TEMPLATE
		 */
		// Caso seja um rest.
		$attr0 = (isset($this->attr[0])) ? $this->attr[0] : '';
		$is_rest = isset($this->params['global']['permissions'][($attr0 == '') ? 'index' : $attr0]);
		$is_permite = $this->params['global']['permissions'][($attr0 == '' || !$is_rest) ? 'index' : $attr0];

		// Monta caminho do arquivo HTML. Conteúdo da página atual. Dentro da pasta definida em PATH_VIEW_PAGES.
		$path_view = PATH_VIEW_PAGES . Core::getInfoDirUrl('path_view');
		// Caso não tenha permissão para Menu/Início, troca a view por modelo sem permissão HTML.
		if ($this->params['security']['session'] && !$is_permite)
			$path_view = PATH_VIEW_PAGES . 'modeloSemPermissao.html';
		// Parâmetro corpo recebe o conteúdo HTML. (irá ser renderizado junto com todos os parâmetros de template.)
		$this->params['template']['corpo'] = file_get_contents($path_view);
	}


	/**
	 * Carrega conteúdo html dos menus de cada grupo que usuário faz parte.
	 *
	 * @return string
	 */
	private function carregaMenusHtml()
	{
		$html = '';

		$grupos = ControllerSecurity::getSession('grupos');
		$idMenu = ControllerSecurity::getSession('idMenu');

		// Menu Personalizado.
		if ($idMenu) {
			$menus = \controle\BdMenus::selecionaPorId($idMenu); // público
			if (!empty($menus)) {
				$html .= Menu::criaHtml(unserialize($menus['menu']), URL_RAIZ);
			}
		}

		// Menus dos grupos.
		if (is_array($grupos)) {
			foreach ($grupos as $key => $value) {
				$menus = \controle\BdMenus::selecionaMenu($value['idGroup']); // público
				if (!empty($menus)) {
					$html .= Menu::criaHtml($menus, URL_RAIZ);
				}
			}
		}

		// Retorna o html do menu completo.
		return $html;
	}


	/**
	 * Carrega os arquivos de classes PHP da pasta definida PATH_MODEL_BD.
	 * POO pode ser usado na controller para executar funções específicas de banco de dados.
	 * Caso o arquivo exista, ele é carregado.
	 *
	 * @return void
	 */
	private function carregaBd()
	{
		// Carrega as controllers de BD passadas no parâmetro de BD (paramsBd). Para poder trabalhar com os dados da tabela na controller.
		foreach ($this->params['bd'] as $value) {
			$path_bd = PATH_MODEL_BD . $value . '.php';
			// Carrega arquivo.
			if (file_exists($path_bd)) {
				require_once $path_bd;
			}
		}
	}


	/**
	 * Carrega os arquivos de classes PHP da pasta definida PATH_MODEL_CLASSES.
	 * POO pode ser usado na controller para executar funções específicas.
	 * Caso o arquivo exista, ele é carregado.
	 *
	 * @return void
	 */
	private function carregaClasses()
	{
		// Carrega as classes passadas no parâmetro classes. Para poder trabalhar na controller.
		foreach ($this->params['classes'] as $value) {
			$path_class = PATH_MODEL_CLASSES . $value . '.php';
			// Carrega arquivo.
			if (file_exists($path_class)) {
				require_once $path_class;
			}
		}
	}


	/**
	 * Carrega os arquivos de controller page PHP da pasta definida EM PATH_CONTROLLER_PAGES.
	 * Pode ser usado as funções estáticas da controller, reaproveitando as funções.
	 * Caso o arquivo exista, ele é carregado.
	 *
	 * @return void
	 */
	private function carregaController()
	{
		// Carrega as classes passadas no parâmetro classes. Para poder trabalhar na controller.
		foreach ($this->params['controller'] as $value) {
			$path_class = PATH_CONTROLLER_PAGES . $value . '.php';
			// Carrega arquivo.
			if (file_exists($path_class)) {
				require_once $path_class;
			}
		}
	}
}
