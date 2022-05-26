<?php

namespace controllers;

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
 * 25/04/2022 - Inclusão das funções.
 * 
 */
class Page extends \controllers\Api
{


	/**
	 * ********************************************************************************************
	 * PARÂMETROS DA CLASSE
	 * ********************************************************************************************
	 */



	/**
	 * ********************************************************************************************
	 * FUNÇÕES DA CLASSE
	 * ********************************************************************************************
	 */



	/**
	 * Inicia o motor da controller. Função de inicialização da controller.
	 */
	public function start()
	{
		// Salva visita no banco de dados.
		$this->gravaVisita();

		// Executa a API, caso seja API. (Controller API)
		$this->executeApi();

		// Executa página, caso seja Página.
		$this->executePage();

		// Finaliza a função.
		return true;
	}


	/**
	 * Executa a página. 
	 * Usada para carregar especificidades da página.
	 * Alivia o carregamento da página e ajuda no dinamismo.
	 *
	 * @return bool
	 */
	public function executePage()
	{
		// Se for API, cancela execução.
		if (!empty($this->params['infoUrl']['attr'][0]) && $this->params['infoUrl']['attr'][0] == 'api' || $this->params['paths']['A_ATIVO']) {
			return false;
		}

		// Verifica a segurança da página.
		$seguroPage = $this->segurancaPage();

		// Verifica menu.
		$menu = $this->checkMenu();

		// Verifica a segurança da função (menu) da página.
		$seguroFunc = $this->segurancaPageFunc($menu);

		// Verifica configurações e carrega dependências personalizadas da controller para se usar no menu. Só vai carregar se realmente tiver todo acesso a página.
		$this->carregaDependencias();

		// Se seguro.
		if ($seguroFunc) {
			// Chama a função (menu) escolhido da página.
			$this->$menu();
		}

		// Realiza o processamento das configurações.
		$this->process($seguroPage, $seguroFunc, $menu);

		// Carrega e monta toda a estrutura
		$this->carregaEstrutura($seguroPage, $seguroFunc, $menu);

		// Carrega as mensagens para dentro das informações da página.
		$this->carregaFeedBack();

		// Renderiza estrutura com os parâmetros e .
		echo \controllers\Render::renderPage($this->params);


		return true;
	}

	/**
	 * CARREGA OS PARÂMETROS DA CONFIGURAÇÃO
	 * Inicia parâmetros gerais da controller, tanto para Módulo quanto para Api.
	 *
	 * @return bool
	 */
	public function carregaDependencias()
	{
		// Carrega as classes para funções específicas.
		$this->carregaClasses();

		// Carrega as controllers para uso das funções staticas.
		$this->carregaControllers();
	}

	/**
	 * Realiza o processamento das configurações da controller.
	 *
	 * @return void
	 */
	private function process($seguroPage, $seguroFunc, $menu)
	{
		// Segurança - Permissões

		// Tem permissão para acessar a página.
		if ($seguroPage) {
			# code...
		}

		// Tem permissão para usar a função (menu).
		if ($seguroFunc) {
			# code...
		}

		// Carrega menus

		// Carrega dependências
	}


	/**
	 * Carrega conteúdo html dos arquivos de estrutura do módulo.
	 * .
	 *
	 * @return void
	 */
	private function carregaEstrutura($seguroPage, $seguroFunc, $menu)
	{

		// Caso tenha, tira o content_page. pois é escolhido apenas pela controller e não pelo usuário.
		unset($this->params['structure']['content_page']);

		// Carrega os arquivos do parâmetro page template.
		foreach ($this->params['structure'] as $key => $value) {

			// Parâmetro recebe o conteúdo HTML do arquivo na posição.
			$this->params['structure'][$key] = file_get_contents($this->params['paths']['M_PATH_ESTRUTURA'] . $key . '/' . $value . '.html');
		}

		// Se usuário tem permissão para a página e para a função.
		if ($seguroPage && $seguroFunc) {
			// Acrescenta novamente o html após as permissões.
			$this->params['structure']['html'] = str_replace("block content_page", "block " . $menu, $this->params['structure']['html']);

			// Carrega conteúdo da página.
			$this->params['structure']['content_page'] = file_get_contents($this->params['infoUrl']['view_path']);
		} else {
			// Carrega conteúdo padrão (sem permissão).
			$this->params['structure']['content_page'] = file_get_contents($this->params['paths']['M_PATH_ESTRUTURA'] . 'content_page/sem_permissao.html');
		}

		return true;
	}

	/**
	 * Função que grava a visita na página no banco de dados.
	 *
	 * @return void
	 */
	private function gravaVisita()
	{
		if ($this->params['config']['bd'] && $this->params['config']['visita']) {
			// Salva a visita na página.
			\controllers\Bd::gravaLogVisita();
		}
	}

	/**
	 * Função que manda para páginas o feed back das ações da controller.
	 *
	 * @return void
	 */
	protected function carregaFeedBack()
	{
		// Verifica se feedback está ativo.
		if ($this->params['config']['feedback'])
			// Carrega as mensagens para dentro das informações da página.
			$this->params['info']['FeedBackMessagens'] = \classes\FeedBackMessagens::get();
	}
}
