<?php

namespace controllers;

/**
 * Class: plataforma
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar informações gerais de acesso via url.
 * Create: 22/04/2022
 * Update: 22/04/2022
 * 
 * Registros:
 * 22/04/2022 - Criação
 * 
 */
class Plataforma
{


    /**
     * ********************************************************************************************
     * PARÂMETROS DA CLASSE
     * ********************************************************************************************
     */

    /**
     * Parâmetros gerais da controller.
     * config       - Configurações
     * security     - Segurança
     * infoUser     - Informações do usuário logado
     * infoUrl      - Informações da URL
     * info         - Informações da plataforma, módulo ou api.
     * menu         - Menus (abas) personalizados da controller.   
     * Page
     * View
     * Bd
     * Classes
     *
     * @var array
     */
    protected $params;



    /**
     * ********************************************************************************************
     * FUNÇÕES DE HERANÇA
     * ********************************************************************************************
     */

    /**
     * Construtor da classe.
     * Inicializa a controller com valores default ou personalizados.
     * 
     */
    function __construct()
    {

        // Carrega os parâmetros default de toda a aplicação.
        $this->carregaParamsDefault();

        // Faz a combinação com os parâmetros atuais e personalizados da controller.
        $this->mergeParams($this->loadParams());
        
        // Carrega as dependências das configurações personalizadas.
        $this->carregaConfigs();

        // Carrega as dependências de segurança personalizadas.
        $this->carregaSecurity();

        // Carrega as classes de Banco de Dados.
        $this->carregaBDs();
        
		// Inicia segurança. Carrega todas as informações necessárias.
		$this->startSecurity();

    }

    /**
     * CARREGA OS PARÂMETROS DA CONTROLLER
     * Inicia parâmetros gerais da controller, tanto para Módulo quanto para Api.
     *
     * @return bool
     */
    protected function carregaParamsDefault()
    {
        /**
         * CONFIGURAÇÕES
         * * *******************
         * Liga e desliga funções e recursos a serem utilizados na controller.
         * Substitui os parâmetros default ou acrescenta.
         */
        $this->params['config'] = VC_CONFIG;

        /**
         * PATHS
         * * *******************
         * Nomes, caminhos completos ou relativos de diretórios da plataforma.
         */
        $this->params['paths'] = VC_PATHS;
        
        /**
         * SEGURANÇA
         * * *******************
         * Define níveis de permissões e fatores extras de segurança.
         */
        $this->params['security'] = VC_SECURITY;
        
        /**
         * INFORMAÇÕES
         * * *******************
         * Informações gerais para serem reutilizadas nas controllers.
         */
        $this->params['info'] = VC_INFO;
        
        /**
         * INFORMAÇÕES DA URL
         * * *******************
         * Informações da URL gerais para serem reutilizadas nas controllers.
         */
        $this->params['infoUrl'] = \v3\Core::getInfoUrl();
        
        /**
         * API
         * * *******************
         * Configurações da API.
         */
        $this->params['api'] = VC_API;
        
        /**
         * MENUS
         * * *******************
         * Menus da página.
         */
        $this->params['menus'] = VC_MENUS;
        
        /**
         * TOKENS
         * * *******************
         * Tokens para acesso a APIS e outros.
         */
        $this->params['tokens'] = VC_TOKENS;
        
        /**
         * SEO
         * * *******************
         * SEO da página.
         */
        $this->params['info'] = VC_INFO;
        

        // DEFINIDOS PELA CONTROLLER FINAL.
        // * *********************************************************

        /**
         * ESTRUTURA HTML
         * * *******************
         * Escolha da estrutura da página HTML.
         */
        $this->params['structure'] = array();
        
        /**
         * SCRIPT
         * * *******************
         * Caminho dos arquivos js da página.
         */
        $this->params['scripts'] = array();
        
        /**
         * STYLES
         * * *******************
         * Caminho dos arquivos css da página.
         */
        $this->params['styles'] = array();
        
        /**
         * BANCO DE DADOS
         * * *******************
         * Otimização das funções de banco de dados que serão usadas na controller.
         */
        $this->params['bd'] = array();
        
        /**
         * CLASSES
         * * *******************
         * Otimização das funções que serão usadas na controller.
         * Necessário chamar todas as dependências que classes usa.
         */
        $this->params['classes'] = array();
        
        /**
         * CONTROLLER
         * * *******************
         * Reutilização de funções staticas em outras controllers do mesmo módulo.
         * Necessário chamar todas as dependências que controller usa na função.
         */
        $this->params['controllers'] = array();
        
        /**
         * PLUGINS
         * * *******************
         * Quais plugins a página atual necessita. (minusculo)
         */
        $this->params['plugins'] = array();

        return true;
    }

    



    /**
     * ********************************************************************************************
     * FUNÇÕES PARA CONTROLLERS HERDADAS
     * ********************************************************************************************
     */

    /**
     * Inicia o motor da controller. Função de inicialização da controller.
     */
    public function start(){echo 'API ou Módulo sem função START().';}

    /**
     * Realiza o carregamento dos parâmetros personalizados da controller acessada.
     */
    public function loadParams(){return array();}

    /**
     * CARREGA OS PARÂMETROS DA CONFIGURAÇÃO
     * Inicia parâmetros gerais da controller, tanto para Módulo quanto para Api.
     *
     * @return bool
     */
    public function carregaDependencias(){}

    /**
     * Inicia pré execução da segurança.
     *
     * @return bool
     */
    public function startSecurity(){}

    

    



    /**
     * ********************************************************************************************
     * FUNÇÕES CONTROLLER FILHO
     * ********************************************************************************************
     */


    /**
	 * Função padrão de execução.
	 * Usado para criar os parâmetros e dados disponibilizados na view.
	 * É executado depois do preprocessamento()
	 *
	 * @return bool
	 */
	public function index(){return true;}

    /**
	 * Função de execução de API.
	 * Usado para criar os parâmetros e dados disponibilizados na api.
	 * É executado depois do preprocessamento()
	 *
	 * @return bool
	 */
	public function api($params){return true;}

    


    

    



    /**
     * ********************************************************************************************
     * FUNÇÕES DE APOIO
     * ********************************************************************************************
     * Funções protegidas para serem usadas somente nesta controller.
     */


    /**
     * Junta parâmetros default com os personalizados.
     *
     * @return bool
     */
    protected function mergeParams($params_personalizados)
    {        
        // CONFIG
        if (!empty($params_personalizados['config']))
        $this->params['config'] = array_merge($this->params['config'], $params_personalizados['config']);
        
        // SEGURANÇA
        if (!empty($params_personalizados['security']))
        $this->params['security'] = array_merge($this->params['security'], $params_personalizados['security']);
        
        // INFORMAÇÕES GERAIS
        if (!empty($params_personalizados['info']))
        $this->params['info'] = array_merge($this->params['info'], $params_personalizados['info']);
        
        // API
        if (!empty($params_personalizados['api']))
        $this->params['api'] = array_merge($this->params['api'], $params_personalizados['api']);
        
        // MENUS
        if (!empty($params_personalizados['menus']))
        $this->params['menus'] = array_merge($this->params['menus'], $params_personalizados['menus']);
        
        // ESTRUTURA
        if (!empty($params_personalizados['structure']))
        $this->params['structure'] = array_merge($this->params['structure'], $params_personalizados['structure']);
        
        // SCRIPTS
        if (!empty($params_personalizados['scripts']))
        $this->params['scripts'] = array_merge($this->params['scripts'], $params_personalizados['scripts']);
        
        // STYLES
        if (!empty($params_personalizados['styles']))
        $this->params['styles'] = array_merge($this->params['styles'], $params_personalizados['styles']);
        
        // BANCO DE DADOS
        if (!empty($params_personalizados['bd']))
        $this->params['bd'] = array_merge($this->params['bd'], $params_personalizados['bd']);
        
        // CLASSES
        if (!empty($params_personalizados['classes']))
        $this->params['classes'] = array_merge($this->params['classes'], $params_personalizados['classes']);
        
        // CONTROLLER
        if (!empty($params_personalizados['controllers']))
        $this->params['controllers'] = array_merge($this->params['controllers'], $params_personalizados['controllers']);
        
        // PLUGINS
        if (!empty($params_personalizados['plugins']))
        $this->params['plugins'] = array_merge($this->params['plugins'], $params_personalizados['plugins']);

        // Finaliza a função.
        return true;
    }


    /**
	 * Carrega dependências de configurações.
     * As classes após carregadas ficam disponíveis na controller para uso.
	 * Caso o arquivo exista, ele é carregado.
	 *
	 * @return void
	 */
    protected function carregaConfigs()
    {

        // Carrega classe de feedback.
        if ($this->params['config']['bd'] && $this->params['config']['feedback']) {
            require_once VC_PATHS['P_PATH_CLASSES'] . 'FeedBackMessagens.php';
        }

    }

    /**
     * Carrega dependências de segurança.
     * Inicia parâmetros gerais da controller, tanto para Módulo quanto para Api.
     *
     * @return bool
     */
    protected function carregaSecurity()
    {
        // Carrega classe.
        require_once VC_PATHS['P_PATH_CLASSES'] . 'Session.php';
        require_once VC_PATHS['P_PATH_CLASSES'] . 'TokenPlataforma.php';

    }


    /**
	 * Carrega os arquivos de banco de dados.
     * As classes de BDs após carregadas ficam disponíveis na controller para uso.
	 * Caso o arquivo exista, ele é carregado.
	 *
	 * @return void
	 */
    protected function carregaBDs()
    {
        // Verifica se usa BD e carrega as dependências de BD.
        if ($this->params['config']['bd']) {

            // Carrega primeiramente a controller de Banco de Dados.
            require_once $this->params['paths']['P_PATH_CONTROLLERS'] . 'c_bd.php';
            require_once $this->params['paths']['P_PATH_BD'] . 'BdLogs.php';
            require_once $this->params['paths']['P_PATH_BD'] . 'BdStatus.php';
            require_once $this->params['paths']['P_PATH_BD'] . 'BdLogins.php';
            require_once $this->params['paths']['P_PATH_BD'] . 'BdLoginsGroups.php';
            require_once $this->params['paths']['P_PATH_BD'] . 'BdPermissions.php';

            // Carrega os BDs passados nos parâmetros da controler. 
            foreach ($this->params['bd'] as $key => $value) {

                // Verifica qual módulo acessará e monta a pasta.
                $modulo = explode('/', $key);
                $pasta = '';
                switch ($modulo[0]) {
                    case 'modulos':
                        $pasta = $this->params['paths']['M_BD'];
                        break;
                    case 'api':
                        # code...
                        $pasta = $this->params['paths']['A_BD'];
                        break;
                    case 'plataforma':
                        # code...
                        $pasta = $this->params['paths']['P_BD'];
                        break;
                }

                // Monta caminho do arquivo.
                $path_arquivo = $this->params['paths']['PATH_CONTROL'] . $key . '/' . $this->params['paths']['M_BD'] . $value . '.php';

                // Carrega arquivo.
                if (file_exists($path_arquivo)) {
                    require_once $path_arquivo;
                }
            }
        }
    }


    /**
	 * Carrega as classes para funções específicas.
     * As classes após carregadas ficam disponíveis na controller para uso.
	 * Caso o arquivo exista, ele é carregado.
	 *
	 * @return void
	 */
    protected function carregaClasses()
    {

        // Carrega os BDs passados nos parâmetros da controler. 
        foreach ($this->params['classes'] as $key => $value) {

            // Verifica qual módulo acessará e monta a pasta.
            $modulo = explode('/', $key);
            $pasta = '';
            switch ($modulo[0]) {
                case 'modulos':
                    $pasta = $this->params['paths']['M_CLASSES'];
                    break;
                case 'api':
                    # code...
                    $pasta = $this->params['paths']['A_CLASSES'];
                    break;
                case 'plataforma':
                    # code...
                    $pasta = $this->params['paths']['P_CLASSES'];
                    break;
            }

            // Monta caminho do arquivo.
            $path_arquivo = $this->params['paths']['PATH_CONTROL'] . $key . '/' . $pasta . $value . '.php';

            // Carrega arquivo.
            if (file_exists($path_arquivo)) {
                require_once $path_arquivo;
            }
        }
    }


    /**
	 * Carrega as controllers para uso das funções staticas.
     * As classes após carregadas ficam disponíveis na controller para uso.
	 * Caso o arquivo exista, ele é carregado.
	 *
	 * @return void
	 */
    protected function carregaControllers()
    {

        // Carrega os BDs passados nos parâmetros da controler. 
        foreach ($this->params['controllers'] as $key => $value) {

            // Verifica qual módulo acessará e monta a pasta.
            $modulo = explode('/', $key);
            $pasta = '';
            switch ($modulo[0]) {
                case 'modulos':
                    $pasta = $this->params['paths']['M_CONTROLLER'];
                    break;
                case 'api':
                    # code...
                    $pasta = $this->params['paths']['A_FUNCTIONS'];
                    break;
            }

            // Monta caminho do arquivo.
            $path_arquivo = $this->params['paths']['PATH_CONTROL'] . $key . '/' . $pasta . $value . '.php';

            // Carrega arquivo.
            if (file_exists($path_arquivo)) {
                require_once $path_arquivo;
            }
        }
    }


    /**
     * Teste de controller.
     *
     * @return bool
     */
    public static function teste()
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
