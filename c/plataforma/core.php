<?php

namespace v3;

// todo Retirar???
// use Respect\Validation\Rules\BoolVal;

/**
 * Class: Core
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar toda a aplicação.
 * Create: 11/04/2022
 * Update: 11/04/2022
 * 
 * Registros:
 * 11/04/2022 - Criação
 * 
 */
class Core
{

	/**
	 * ********************************************************************************************
	 * PARÂMETROS DA CLASSE
	 * ********************************************************************************************
	 */

	// Parâmetros da URL.
	// Guarda todas as informações obtidas pela url acessada.
	protected static $infoUrl;
	public static function getInfoUrl($key = null)
	{
		if ($key)
			return Self::$infoUrl[$key];
		return Self::$infoUrl;
	}



	/**
	 * ********************************************************************************************
	 * FUNÇÕES DA CLASSE
	 * ********************************************************************************************
	 */

	/**
	 * Função que inicia o motor de toda a aplicação.
	 *
	 * @return void
	 */
	public function start()
	{

		/**
		 * Carrega as dependências iniciais do aplicativo (COMPOSER).
		 */
		$this->carregaComposer();

		/**
		 * Carrega as configurações (constantes) iniciais do aplicativo.
		 */
		$this->carregaConfiguracoes();

		/**
		 * Carrega as configurações (constantes) personalizadas do módulo ou api.
		 */
		$this->carregaConfiguracoesPersonalizadas();

		/**
		 * Obtém todos os dados extraidos da URL.
		 */
		$this->carregaInfoUrl();

		/**
		 * Carrega dependências de classes essenciais do módulo ou api.
		 */
		$this->carregaDependencias();

		// Inicia sessão.
		\classes\Session::start();

		/**
		 * Carrega a controller usada na URL atual.
		 */
		$this->carregaController();

		return true;
	}


	/**
	 * Carrega as dependências iniciais do aplicativo.
	 *
	 * @return bool
	 */
	protected function carregaComposer()
	{
		// Carrega o arquivo autoload do composer.
		require_once 'vendor/autoload.php';  // Carrega todas as dependências do composer.
		return true;
	}


	/**
	 * Carrega as dependências iniciais do aplicativo.
	 *
	 * @return bool
	 */
	protected function carregaConfiguracoes()
	{
		// Carrega arquivo de configurações.
		require_once 'config.php';
		
		return true;
	}


	/**
	 * Carrega as dependências iniciais do aplicativo.
	 *
	 * @return bool
	 */
	protected function carregaConfiguracoesPersonalizadas()
	{
		// Verifica se é API, se não é Módulo.
		if (VC_PATHS['A_ATIVO']) {
			// Configurações personalizadas
			require_once VC_PATHS['A_PATH'] . 'config.php';
		} else {
			// Configurações personalizadas
			require_once VC_PATHS['M_PATH'] . 'config.php';
		}
		return true;
	}


	/**
	 * Carrega todas as informações retiradas da URL.
	 * Obtém 
	 *
	 * @return bool
	 */
	protected function carregaInfoUrl()
	{

		// Verifica se é API, se não é Módulo.
		if (VC_PATHS['A_ATIVO']) {
			// Carrega informações da API.
			$infoUrl = $this->carregaInfoUrlApi();
		} else {
			// Carrega informações do Módulo.
			$infoUrl = $this->carregaInfoUrlModelo();
		}

		// GUARDA INFORMAÇÕES DA URL NA CONSTANTE
		define("VC_INFOURL", $infoUrl);

		// Guarda as informações.
		self::$infoUrl = $infoUrl;


		// Finaliza função.
		return true;
	}


	/**
	 * Carrega as dependências iniciais de acordo com as informações de URL ($infoUrl).
	 *
	 * @return bool
	 */
	protected function carregaDependencias()
	{
		// Verifica se é API, se não é Módulo.
		if (VC_PATHS['A_ATIVO']) {
			$this->carregaDependenciasApi();
		} else {
			$this->carregaDependenciasPage();
		}

		// Carrega dependências gerais
		$this->carregaDependenciasGeral();

		// Finaliza função.
		return true;
	}


	/**
	 * Carrega as dependências iniciais gerais da plataforma.
	 *
	 * @return bool
	 */
	protected function carregaDependenciasGeral()
	{
		// Manipula sessão.
		require_once VC_PATHS['P_PATH_CLASSES'] . 'Session.php';
		require_once VC_PATHS['P_PATH_CLASSES'] . 'FeedBackMessagens.php';
		require_once VC_PATHS['P_PATH_CLASSES'] . 'TratamentoDados.php';

		// Finaliza função.
		return true;
	}


	/**
	 * Carrega as dependências iniciais da API de acordo com as informações de URL ($infoUrl).
	 *
	 * @return bool
	 */
	protected function carregaDependenciasApi()
	{

		// Carrega controllers de Api da plataforma.
		require_once VC_PATHS['P_CONTROLLERS'] . 'c_p.php';
		require_once VC_PATHS['P_CONTROLLERS'] . 'c_security.php';
		require_once VC_PATHS['P_CONTROLLERS'] . 'c_api.php';
		require_once VC_PATHS['P_CONTROLLERS'] . 'c_render.php';

		// Carrega controllers personalizados da api.
		require_once VC_PATHS['A_PATH_CONTROLLERS'] . 'c_security.php';
		require_once VC_PATHS['A_PATH_CONTROLLERS'] . 'c_api.php';

		// Finaliza função.
		return true;
	}


	/**
	 * Carrega as dependências iniciais do Módulo de acordo com as informações de URL ($infoUrl).
	 *
	 * @return bool
	 */
	protected function carregaDependenciasPage()
	{

		// Carrega controllers da plataforma.
		require_once VC_PATHS['P_CONTROLLERS'] . 'c_p.php';
		require_once VC_PATHS['P_CONTROLLERS'] . 'c_security.php';
		require_once VC_PATHS['P_CONTROLLERS'] . 'c_api.php';
		require_once VC_PATHS['P_CONTROLLERS'] . 'c_page.php';
		require_once VC_PATHS['P_CONTROLLERS'] . 'c_render.php';

		// Carrega controllers personalizados.
		require_once VC_PATHS['M_PATH_CONTROLLERS'] . 'c_security.php';
		require_once VC_PATHS['M_PATH_CONTROLLERS'] . 'c_api.php';
		require_once VC_PATHS['M_PATH_CONTROLLERS'] . 'c_page.php';

		// Finaliza função.
		return true;
	}

	/**
	 * Carrega a controller usada na url atual.
	 *
	 * @return bool
	 */
	protected function carregaController()
	{

		// Tenta instânciar a classe da função api ou módulo acessado.
		try {

			// Carrega arquivo da controller.
			require_once(self::$infoUrl['controller_path']);

			// Carrega a classe dinamicamente.
			$class = new \ReflectionClass(self::$infoUrl['controller_class_name']);

			// Instancia a classe.
			$instance_class = $class->newInstanceArgs();

			// Inicia o motor da controler.
			$instance_class->start();
		} catch (\Throwable $th) {
			// Caso ocorra algum erro, escreve as informações na tela.
			echo '<hr>' . 'Inconsistência encontrada, contate o administrador do sistema e envie as informações abaixo.<br>';
			echo 'Contato: ' . VC_INFO['emailSuporte'] . ' - ' . VC_INFO['telefoneSuporte'] . '.<br><br><b>Arquivo</b>: ' . $th->getFile() . '.<br><b>Linha</b>: ' . $th->getLine() . '.<br><b>Função</b>: ' . $th->getTrace()[0]['function'] . '.<br><b>Erro</b>: ' . $th->getMessage() . '.';
		}

		// Finaliza.
		return true;
	}

	/**
	 * Função que carrega as informações de API solicitadas pela URL.
	 *
	 * @return array
	 */
	protected function carregaInfoUrlApi()
	{

		// Monta o array padrão de informações de API.
		$infoUrl = [
			// Informações gerais da API
			'api'        			=> VC_PATHS['A_NAME'], 	// Api da própria página.
			'file'      			=> 'index',   			// Nome do arquivo.

			// Informações controller
			'controller_path'       => VC_PATHS['A_PATH_FUNCTIONS'] . 'index.php',   	// Caminho e nome completo da controller.
			'controller_file'       => 'index.php',   							// Path completo da controller.
			'controller_class_name' => Core::nomeControllerApi('index'),   		// Nome da controller completo.

			// Informações da URL.
			'url'             		=> '',				// String da url.
			'url_array'       		=> array(),			// Array da url pela "/".
			'attr'            		=> array(),			// Atributos/Parâmetros REST passados após a página.	
		];

		// Caso tenha endereço na URL.
		if (!empty($_GET) && !empty($_GET['url'])) {

			// Guarda URL
			$infoUrl['url'] = $_GET['url'];
			// Transforma URL em array.
			$infoUrl['url_array'] = explode('/', $_GET['url']);

			// Guarda array da URL para verificar informações da plataforma.
			$url_array = $infoUrl['url_array'];

			// Limpa array
			unset($url_array[0]); // API
			unset($url_array[1]); // Módulo API

			// Inicializa
			$path_tmp = '';

			// Monta o array com as informações da url.
			// Percorre cada posição da url em busca de uma página.
			foreach ($url_array as $key => $value) {

				// Verifica final da url / e finaliza (site.com/url/). É o ponto de parada.
				if (!empty($value)) {

					// Guarda o caminho relativo da posição atual da URL.
					$path_tmp = $path_tmp . $value;

					// Monta caminho de pasta com a posição atual.
					$path_atual = $path_tmp . '/';

					// Monta caminho de arquivo view com a posição atual.
					$controller_path_atual = $path_tmp . '.php';

					// Verifica se é um diretório.
					$is_dir = file_exists(VC_PATHS['A_PATH_FUNCTIONS'] . $path_atual);

					// Verifica se pasta tem index.
					$is_dir_index = file_exists(VC_PATHS['A_PATH_FUNCTIONS'] . $path_atual . 'index.php');

					// Verifica se é um arquivo de função.
					$is_file = file_exists(VC_PATHS['A_PATH_FUNCTIONS'] . $controller_path_atual);

					// Gera nome padrão da classe controller
					$controller_class_name = Core::nomeControllerApi($value);

					// É um diretório e tem index.
					if ($is_dir && $is_dir_index) {
						$infoUrl['file']                  = 'index';
						$infoUrl['controller_class_name'] = Core::nomeControllerApi('index');;
						$infoUrl['controller_path']       = VC_PATHS['A_PATH_FUNCTIONS'] . $path_atual . 'index.php';
						$infoUrl['url_friendly'] = VC_PATHS['M_NAME'] . '/' . $path_atual;
						$infoUrl['controller_file']       = 'index.php';
					}

					// Se tem arquivo de página.
					if ($is_file) {
						// Monta info controller.
						$infoUrl['file']                  = $value;
						$infoUrl['controller_class_name'] = $controller_class_name;
						$infoUrl['controller_path']       = VC_PATHS['A_PATH_FUNCTIONS'] . $path_tmp . '.php';
						$infoUrl['url_friendly'] = VC_PATHS['M_NAME'] . '/' . $path_atual;
						$infoUrl['controller_file']       = $value . '.php';
					}

					// Ajusta o path com '/' para próxia interação
					$path_tmp = $path_atual;

					// Se não é um diretório e não é um arquivo, então é um parâmetro.
					if (!($is_dir && $is_dir_index) && !$is_file) {
						array_push($infoUrl['attr'], $value);
					}
				}
			}
		}

		// Retorna as informações da url API.
		return $infoUrl;
	}

	/**
	 * Função que carrega as informações de Módulo solicitadas pela URL.
	 *
	 * @return array
	 */
	protected function carregaInfoUrlModelo()
	{

		// Monta o array padrão.
		$infoUrl = [
			// Informações gerais da API
			'modulo'				=> 'www',									// Módulo de execução
			'file'      			=> 'index',   								// Nome do arquivo.

			// Informações view
			'view_path' 			=> VC_PATHS['M_PATH_VIEW'] . 'index.html',  // Path completo da view.
			'url_friendly' 			=> '/',   									// Url amigável da view.
			'view_file' 			=> 'index.html',                         	// Nome do arquivo da view completa incluindo extensão.

			// Informações controller
			'controller_path'       => null,   									// Caminho e nome completo da controller.
			'controller_file'       => null,   									// Path completo da controller.
			'controller_class_name' => null,   									// Nome da controller completo.

			// Informações da URL.
			'url'             		=> '',										// String da url.
			'url_array'       		=> array(),									// Array da url pela "/".
			'attr'            		=> array(),									// Atributos/Parâmetros REST passados após a página.	
		];

		// Informações da controller
		// Verifica se tem um arquivo controller.
		$is_file_controller = file_exists(VC_PATHS['M_PATH_CONTROLLER'] . 'index.php');

		// Página tem controller
		if ($is_file_controller) {
			// Monta info controller.
			$infoUrl['controller_class_name'] = 'IndexControllerPage';                    	// Caminho e nome completo da controller._name;
			$infoUrl['controller_path']       = VC_PATHS['M_PATH_CONTROLLER'] . 'index.php';	// Path completo da controller.NTROLLER . $path_tmp . '.php';
			$infoUrl['controller_file']       = 'index.php';  								// Nome da controller completo.
		} else {
			// Monta info controller default.
			$infoUrl['controller_class_name'] = 'DefaultControllerPage';
			$infoUrl['controller_path']       = VC_PATHS['M_PATH_CONTROLLER'] . 'default.php';
			$infoUrl['controller_file']       = 'default.php';
		}

		// Caso tenha endereço na URL.
		if (!empty($_GET) && !empty($_GET['url'])) {

			// Guarda URL
			$infoUrl['url'] = $_GET['url'];
			// Transforma URL em array.
			$infoUrl['url_array'] = explode('/', $_GET['url']);

			// Guarda array da URL para verificar informações da plataforma.
			$url_array = $infoUrl['url_array'];

			// Limpa array
			if (VC_PATHS['M_NAME'] != VC_PATHS['M_DEFAULT']) {
				unset($url_array[0]); // MÓDULO
			}

			// Inicializa
			$path_ant = '';
			$path_tmp = '';

			// Monta o array com as informações da url.
			// Percorre cada posição da url em busca de uma página.
			foreach ($url_array as $key => $value) {

				// Verifica final da url / e finaliza (site.com/url/). É o ponto de parada.
				if (!empty($value)) {

					// Guarda o caminho relativo da posição atual da URL.
					$path_ant = $path_tmp;

					// Guarda o caminho relativo da posição atual da URL.
					$path_tmp = $path_tmp . $value;

					// Monta caminho de pasta com a posição atual.
					$path_atual = $path_tmp . '/';

					// Monta caminho de arquivo view com a posição atual.
					$view_path_atual = $path_tmp . '.html';

					// Verifica se é um diretório.
					$is_dir = file_exists(VC_PATHS['M_PATH_VIEW'] . $path_atual);

					// Verifica se pasta tem index.
					$is_dir_index = file_exists(VC_PATHS['M_PATH_VIEW'] . $path_atual . 'index.html');

					// Verifica se é um arquivo view.
					$is_file = file_exists(VC_PATHS['M_PATH_VIEW'] . $view_path_atual);

					// Verifica se tem um arquivo controller.
					$is_file_controller = file_exists(VC_PATHS['M_PATH_CONTROLLER'] . $path_tmp . '.php');

					// Gera nome padrão da classe controller
					$controller_class_name = Core::nomeControllerPage($value);

					// Se tem index ou arquivo de página.
					if ($is_dir_index || $is_file) {

						// Verifica se pasta tem index.
						$is_dir_controller_index = file_exists(VC_PATHS['M_PATH_CONTROLLER'] . $path_atual . 'index.php');

						// Página tem controller
						if ($is_file_controller) {
							// Monta info controller.
							$infoUrl['controller_class_name'] = $controller_class_name;
							$infoUrl['controller_path']       = VC_PATHS['M_PATH_CONTROLLER'] . $path_tmp . '.php';
							$infoUrl['controller_file']       = $value . '.php';
						} elseif ($is_dir_controller_index) {
							// Monta info controller default.
							$infoUrl['controller_class_name'] = 'IndexControllerPage';
							$infoUrl['controller_path']       = VC_PATHS['M_PATH_CONTROLLER'] . $path_atual . 'index.php';
							$infoUrl['controller_file']       = 'index.php';
						} else {
							// Monta info controller default.
							$infoUrl['controller_class_name'] = 'DefaultControllerPage';
							$infoUrl['controller_path']       = VC_PATHS['M_PATH_CONTROLLER'] . 'default.php';
							$infoUrl['controller_file']       = 'default.php';
						}
					}

					// É um diretório e tem index.
					if ($is_dir && $is_dir_index) {
						// Monta info
						$infoUrl['file']      = 'index';
						// Monta info view.
						$infoUrl['view_path'] = VC_PATHS['M_PATH_VIEW'] . $path_atual . 'index.html';
						$infoUrl['url_friendly'] = VC_PATHS['M_NAME'] . '/' . $path_atual;
						$infoUrl['view_file'] = 'index.html';
						// Monta info controller.
					}

					// É um arquivo.
					if ($is_file) {
						// Monta info
						$infoUrl['file']      = $value;
						// Monta info view.
						$infoUrl['view_path'] = VC_PATHS['M_PATH_VIEW'] . $view_path_atual;
						$infoUrl['url_friendly'] = VC_PATHS['M_NAME'] . '/' . $path_atual;
						$infoUrl['view_file'] = $value . '.html';
					}

					// Ajusta o path com '/' para próxia interação
					$path_tmp = $path_atual;

					// Se não tem view (index.html ou ****.html), então é um parâmetro.
					if (!($is_dir_index || $is_file)) {
						array_push($infoUrl['attr'], $value);
					}
				}
			}
		}

		// Retorna as informações da url Módulo.
		return $infoUrl;
	}

	/**
	 * Função que retorna o nome da api ou false.
	 * Caso acesso seja feito na "api", sistema retorna módulo da API solicitado ou api default na constante VC_API_NAME.
	 * Caso não seja "api" sistema retorna "false" na constante VC_API_NAME.
	 * Veja mais em "plataforma/configs/config_paths.php"
	 *
	 * @return bool
	 */
	public static function getApi($apis)
	{
		// Variável temporária para guardar api default
		$tmp_api = false;

		// Verifica se existe valor na url.
		if (!empty($_GET) && !empty($_GET['url'])) {

			// Obtém url em array.
			$tmp = explode('/', $_GET['url']);

			// Verifica se primeira posição é API.
			if ($tmp[0] == "api") {

				// Verifica se existe segunda opção.
				if (isset($tmp[1]) && !empty($tmp[1])) {

					// Obtém lista de módulos.
					$lista_apis = array_diff(
						scandir($apis),
						['.', '..']
					);

					// Verifica se chamou api específica.
					foreach ($lista_apis as $key => $value) {
						// Caso tenha um módulo para a api específica, guarda o módulo da API.
						if ($value == $tmp[1]) {
							$tmp_api = $tmp[1];
							break;
						}
					}

					// Caso não tenha nenhuma API com esse nome.
					if (!$tmp_api) {
						header("Content-type: application/json; charset=utf-8");
						echo '{"msg":"Api não encontrada."}';
						exit;
					}
				}
			}
		}

		// Retorna nome da pasta do módulo atual da API.
		return $tmp_api;
	}

	/**
	 * Função que retorna o nome do módulo.
	 * Caso acesso seja feito no módulo "n", sistema retorna módulo "n" solicitado ou módulo default na constante VC_MODULO_NAME.
	 * Caso não tenha o módulo no sistema, retorna módulo default (VC_MODULO_DEFAULT) na constante VC_MODULO_NAME.
	 * Veja mais em "plataforma/configs/config_paths.php"
	 *
	 * @return bool
	 */
	public static function getModulo($modulos, $default)
	{
		// Variável temporária para guardar modulo default
		$tmp_modulo = $default;

		// Verifica se existe valor na url.
		if (!empty($_GET) && !empty($_GET['url'])) {

			// Obtém url em array.
			$tmp = explode('/', $_GET['url']);

			// Se for API não gera nome do módulo. M_ATIVO = 0.
			if ($tmp[0] == "api") {
				return false;
			}

			// Obtém lista de módulos.
			$lista_modulos = array_diff(
				scandir($modulos),
				['.', '..']
			);

			// Verifica se chamou módulo específico.
			foreach ($lista_modulos as $key => $value) {
				if ($value == $tmp[0]) {
					$tmp_modulo = $tmp[0];
					break;
				}
			}
		}
		// Retorna nome da pasta do módulo atual.
		return $tmp_modulo;
	}

	/**
	 * Trata o nome passado por url e devolve o nome real do arquivo ou registro.
	 *
	 * @return bool
	 */
	public static function nomeControllerPage($value)
	{
		$value = trim($value);
		$r = '';
		$words = explode('-', $value);
		foreach ($words as $key => $value) {
			$r .= ucfirst($value);
		}

		// Retorna nome da classe completo.
		return $r . 'ControllerPage';
	}

	/**
	 * Trata o nome passado por url e devolve o nome real do arquivo ou registro.
	 *
	 * @return bool
	 */
	public static function nomeControllerApi($value)
	{
		$value = trim($value);
		$r = '';
		$words = explode('-', $value);
		foreach ($words as $key => $value) {
			$r .= ucfirst($value);
		}

		// Retorna nome da classe completo.
		return $r . 'ControllerApi';
	}

	/**
	 * Função para teste.
	 *
	 * @return bool
	 */
	protected static function teste()
	{
		// Teste.
		echo '<hr>';
		echo '<b>Arquivo</b>: ' . __FILE__ . '.<br><b>função</b>: ' . __FUNCTION__;
		echo '<br><br>';
		echo 'Controller da Plataforma.';
		echo '<hr>';

		// Finaliza a função.
		return true;
	}
}
