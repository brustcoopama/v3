<?php

/**
 * Modelo default de controller para páginas e APIs.
 * Modelo contém todas as informações que são possíveis usar dentro de uma controller.
 * É possível acrescentar ou mudar parâmetros para obter resultados mais eficientes e personalizados.
 * Os arquivos e classes são carregados após a função loadParams().
 * O método padrão para que a controller seja utilizada é a index.
 * Na função index, é realizada toda a programação da página.
 * As outras funções (menus) são chamados conforme REST utilizando a própria URL.
 */
class IndexControllerPage extends \moduloControllers\Page
{


    /**
     * ********************************************************************************************
     * PARÂMETROS DA CLASSE
     * ********************************************************************************************
     */

    // Sem parâmetros.













    /**
     * * *******************************************************************************************
     * FUNÇÕES DE HERANÇA
     * * *******************************************************************************************
     */

    /**
     * CARREGA OS PARÂMETROS PERSONALIZADOS DA CONTROLLER
     * Substitui parâmetros gerais da controller, tanto para Módulo quanto para Api.
     *
     * @return bool
     */
    public function loadParams()
    {

        /**
         * * *******************************************************************************************
         * PARÂMETROS GERAIS
         * * *******************************************************************************************
         */

        /**
         * CONFIGURAÇÕES
         * * *******************
         * Liga e desliga funções e recursos a serem utilizados na controller.
         * Substitui os parâmetros default ou acrescenta.
         */
        $params['config'] = [

            // Controller usará conexão com banco de dados.
            'bd'                => true,

            // Gravar registro de acesso.
            'visita'            => true,

            // Parâmetros da controller vem do BD.
            'virtualPage'       => false,
            
            // Conteúdo da página vem do BD.
            'viewBD'            => false,

            // Ativa uso de cache para resultado.
            'cache'             => false,
            
            // Tempo para renovar cache em segundos.
            'cacheTime'         => 300,

            // Versão da controller atual.
            'versao'            => 'v1.0',

            // FeedBack padrão de transações.
            'feedback'          => true,

            // Teste
            'class'             => __CLASS__,
        ];

        /**
         * SEGURANÇA
         * * *******************
         * Define níveis de permissões e fatores extras de segurança.
         */
        $params['security'] = [

            // Controller usará controller de segurança.
            'ativo'             => true,

            // Usuário só acessa a controller logado.
            'session'           => true,

            // Nome da sessão deste projeto.
            'sessionName'       => $this->params['paths']['M_NAME'],

            // Tempo para sessão acabar.
            'sessionTimeOut'    => (60 * 30),

            // Caminho para página de login.
            'loginPage'         => $this->params['paths']['M_NAME'] . '/login/',

            // Caminho para página restrita.
            'restrictPage'      => '/' . $this->params['paths']['M_NAME'] . '/admin/',

            // Permissões personalizadas da página atual. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
            'permission'        => '111111111',

            // Transações de dados (GET - POST) apenas com token. Usar classe Tokens. Exemplo: (<input name="token" type="text" value="{{token}}" hidden>').
            'token'             => true, // Só aceitar com token.

            // FeedBack padrão de nível de acesso.
            'feedback'          => true,

            // Receber transações externas. Acesso direto de outras origens.
            'origin'            => [
                // 'v3.local',  // URL teste.
            ],

            // Grupos que tem permissão TOTAL a esta controller. Usar apenas para teste.
            'groups'            => [
                // 1, // Grupo ID: 1.
            ],

            // IDs que tem permissão TOTAL a esta controller. Usar apenas para teste.
            'ids'            => [
                // 1, // Login ID: 1.
            ],
        ];

        /**
         * INFORMAÇÕES
         * * *******************
         * Substitui os parâmetros default ou acrescenta.
         * Informações são passadas para a view via Twig.
         */
        $params['info'] = [

            // INFORMAÇÕES GERAIS
            // *********************
            // Nome da empresa.
            'empresa'      => 'COOPAMA',
            'slogan'       => 'Soluções no Agronegócio',
            'nomeFantasia' => 'Coopama Soluções no Agronegócio',
            'razaoSocial'  => 'Coopama Soluções no Agronegócio',
            'cnpj'         => '123456789',
            'ie'           => '123456789',
            'endereco'     => 'Rua tal, número 12. Brasil - Machado/MG.',
            'email'        => 'mateus.brust@coopama.com.br',
            'telefone'     => '35 9 1234-1234',
            'whatsapp'     => '35 9 1234-1234',
            'since'        => '1917',
            'dataAtual'    => date('d/m/Y H:i:s'),
            'anoAtual'     => date('Y'),
            'logo'         => 'logo.png',


            // INFORMAÇÕES ADICIONAIS PARA HEAD
            // *********************
            // Arquivo js ou css, o próprio código ou livre para acrescentar conteúdo na head.
            'head'           => '',   // Inclui antes de fechar a tag </head>
            'scriptHead'     => '',   // Escreve dentro de uma tag <script></script> antes da </head>.
            'scriptBody'     => '',   // Escreve dentro de uma tag <script></script> antes da </body>.
            'styleHead'      => '',   // Escreve dentro de uma tag <script></script> antes da </head>.
            'styleBody'      => '',   // Escreve dentro de uma tag <script></script> antes da </body>.


            // INFORMAÇÕES DE SEO
            // *********************
            // Informações que vão ser usadas para SEO na página.
            'title'            => 'Página Padrão',              // Título da página exibido na aba/janela navegador.
            'author'           => '',              // Autor do desenvolvimento da página ou responsável.
            'description'      => '',              // Resumo do conteúdo do site em até 90 carecteres.
            'keywords'         => '',              // palavras minúsculas separadas por "," em até 150 caracteres.
            'content-language' => 'pt-BR',         // Linguagem primária da página (pt-br).
            'content-type'     => 'text/html',     // Tipo de codificação da página.
            'reply-to'         => '',              // E-mail do responsável da página.
            'generator'        => 'vscode',        // Programa usado para gerar página.
            'refresh'          => false,           // Tempo para recarregar a página.
            'redirect'         => false,           // URL para redirecionar usuário após refresh.
            'favicon'          => 'favicon.ico',   // Imagem do favicon na página.
            'icon'             => 'favicon.ico',   // Imagem ícone da empresa na página.
            'appletouchicon'   => 'favicon.ico',   // Imagem da logo na página.
        ];

        /**
         * API
         * * *******************
         * Configurações da API.
         */
        $params['api'] = [

            // Tipo do retorno do cabeçalho http.
            'contentType'    => 'application/json',

            // Tipo de codificação do cabeçalho http.
            'charset'        => 'utf-8',

            // Transações de dados (GET - POST) apenas com token. Usar classe Tokens. Exemplo: (<input name="token" type="text" value="{{token}}" hidden>').
            'token'             => false,
        ];

        /**
         * BANCO DE DADOS
         * * *******************
         * Otimização das funções de banco de dados que serão usadas na controller.
         * Procura dentro da pasta BD.
         */
        $params['bd'] = [
            // Módulo atual
            'modulos/' . $this->params['paths']['M_NAME'] => 'BdTeste',

            // Outro módulo
            // 'modulos/www' => 'BdTeste',

            // API módulo
            // 'api/00-modelo' => 'BdTeste',

            // Plataforma
            // 'plataforma' => 'BdTeste',
        ];

        /**
         * CLASSES
         * * *******************
         * Otimização das funções que serão usadas na controller.
         * Necessário chamar todas as dependências que classes usa.
         */
        $params['classes'] = [
            // Módulo atual
            'modulos/' . $this->params['paths']['M_NAME'] => 'Teste',

            // Outro módulo
            // 'modulos/www' => 'Teste',

            // API módulo
            // 'api/00-modelo' => 'Teste',

            // Plataforma
            // 'plataforma' => 'Teste',
        ];

        /**
         * CONTROLLER
         * * *******************
         * Reutilização de funções staticas em outras controllers do mesmo módulo.
         * Necessário chamar todas as dependências que controller usa na função.
         */
        $params['controllers'] = [
            // Módulo atual
            'modulos/' . $this->params['paths']['M_NAME'] => 'teste',

            // Outro módulo
            // 'modulos/www' => 'teste',

            // API módulo
            // 'api/00-modelo' => 'teste',
        ];



        /**
         * * *******************************************************************************************
         * PARÂMETROS DE VIEWS (PÁGINAS)
         * * *******************************************************************************************
         */

        /**
         * MENUS
         * * *******************
         * Menus da página chamada via REST. 
         * Ex.: "www.site.com.br/default/post/", chama a função post da página.
         * Apaga parâmetros default e acrescenta esse.
         */
        $params['menus'] = [

            // Função:
            'index' => [
                'title'    => 'Início',      // Nome exibido no menu.
                'security' => '110000000',   // Permissões necessárias para acesso.
                'groups'   => [],            // Quais grupos tem acesso a esse menu.
                'ids'      => [],            // Quais ids tem acesso a esse menu.
            ],

            // Função:
            'post' => [
                'title'    => 'Adicionar',   // Nome exibido no menu.
                'security' => '101000000',   // Permissões necessárias para acesso.
                'groups'   => [],            // Quais grupos tem acesso a esse menu.
                'ids'      => [],            // Quais ids tem acesso a esse menu.
            ],

            // Função:
            'put' => [
                'title'    => 'Atualizar',   // Nome exibido no menu.
                'security' => '100100000',   // Permissões necessárias para acesso.
                'groups'   => [],            // Quais grupos tem acesso a esse menu.
                'ids'      => [],            // Quais ids tem acesso a esse menu.
            ],

            // Função:
            'get' => [
                'title'    => 'Listar',      // Nome exibido no menu.
                'security' => '100010000',   // Permissões necessárias para acesso.
                'groups'   => [],            // Quais grupos tem acesso a esse menu.
                'ids'      => [],            // Quais ids tem acesso a esse menu.
            ],

            // Função:
            'getfull' => [
                'title'    => 'Listar Completo',   // Nome exibido no menu.
                'security' => '100001000',         // Permissões necessárias para acesso.
                'groups'   => [],                  // Quais grupos tem acesso a esse menu.
                'ids'      => [],                  // Quais ids tem acesso a esse menu.
            ],

            // Função:
            'delete' => [
                'title'    => 'Deletar',     // Nome exibido no menu.
                'security' => '100000100',   // Permissões necessárias para acesso.
                'groups'   => [],            // Quais grupos tem acesso a esse menu.
                'ids'      => [],            // Quais ids tem acesso a esse menu.
            ],

            // Função:
            'test' => [
                'title'    => 'Teste',       // Nome exibido no menu.
                'security' => '100000010',   // Permissões necessárias para acesso.
                'groups'   => [],            // Quais grupos tem acesso a esse menu.
                'ids'      => [],            // Quais ids tem acesso a esse menu.
            ],

            // Função:
            'dashboard' => [
                'title'    => 'Dash Board',   // Nome exibido no menu.
                'security' => '110100010',    // Permissões necessárias para acesso.
                'groups'   => [3],            // Quais grupos tem acesso a esse menu.
                'ids'      => [],             // Quais ids tem acesso a esse menu.
            ],
        ];

        /**
         * ESTRUTURA HTML
         * * *******************
         * Personalização da estrutura da página HTML.
         * html é o bloco origianl, dele vem todos os outros.
         * É possível criar mais blocos (pastas). Os blocos podem ser chamados dentro de outros blocos.
         */
        $params['structure'] = [
            // Origem
            'html'        => 'default',   // Estrutura HTML geral.

            // Complementos
            'head'         => 'default',   // <head> da página.
            'top'          => 'default',   // Logo após a tag <body>.
            'header'       => 'default',   // Após a estrutura "top".
            'nav'          => 'default',   // Dentro do header ou personalizado.
            'content_top'  => 'default',   // Antes do conteúdo da página.
            'content_page' => 'default',   // Reservado para conteúdo da página. Sobrescrito depois.
            'content_end'  => 'default',   // Depois do conteúdo da página.
            'footer'       => 'default',   // footer da página.
            'end'          => 'default',   // Fim da página.
        ];

        /**
         * SCRIPTS
         * * *******************
         * Quais arquivos de scripts a página atual necessita (assets/).
         */
        $params['scripts'] = [
            // 'public/js/jquery.min.js',   		// TESTE.
        ];

        /**
         * STYLES
         * * *******************
         * Quais estilos a página atual necessita (assets/).
         */
        $params['styles'] = [
            // 'public/css/coopamaAdmin-min.css',   // TESTE.
        ];

        /**
         * PLUGINS
         * * *******************
         * Quais plugins a página atual necessita. (minusculo)
         */
        $params['plugins'] = [
            // 'modelo',   // Modelo.
        ];




        /**
         * * *******************************************************************************************
         * PARÂMETROS HERDADOS
         * * *******************************************************************************************
         * DEFINIDOS APENAS PELA CONFIG.
         */

        /**
         * PATHS
         * * *******************
         * Nomes, caminhos completos ou relativos de diretórios da plataforma.
         * Valores são acrescentados na etapa de processamento dos parâmetros.
         * Está aqui só para saber o nome.
         * Não alterar.
         */
        $params['paths'] = VC_PATHS;

        /**
         * INFORMAÇÕES USUÁRIO LOGADO
         * * *******************
         * Valores completos de usuário logado.
         * Valores são acrescentados na etapa de processamento dos parâmetros.
         * Está aqui só para saber o nome.
         * Não alterar.
         */
        $params['infoUser'] = [];

        /**
         * INFORMAÇÕES DA URL
         * * *******************
         * Valores coletados do processamento da url.
         * Valores são acrescentados na etapa de processamento dos parâmetros.
         * Está aqui só para saber o nome.
         * Não alterar.
         */
        $params['infoUrl'] = []; // \v3\Core::getInfoUrl()



        // Retorna os parâmetros da controller para fazer a intersecção com os valores default.
        return $params;
    }















    /**
     * ********************************************************************************************
     * FUNÇÕES DE MENUS
     * ********************************************************************************************
     */


    /**
     * Função padrão de execução de MENUS.
     * Usado para criar os parâmetros e dados disponibilizados na view.
     * É executado depois do preprocessamento()
     *
     * @return bool
     */
    public function index()
    {

        $this->params['info']['html'] = '<br>Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . __CLASS__ . '</b>.<br>';


        // todo TESTE
        // Testes de chamadas.
        // \classes\Teste::start();
        // $qtd = \bds\BdTeste::quantidade();
        // $this->params['info']['html'] = "Quantidade de registros TESTE: " . $qtd;
        // \TesteControllerPage::start();
        // echo '<h1>Teste default controller realizado com sucesso.</h1>';
        // echo '<p>Default Controller</p>';
        // echo '<p>BD ativado.</p>';
        // echo '<h1>Controller Default - Função Index</h1>';

        // echo '<hr>' . __FILE__;
        // echo '<hr>' . __FUNCTION__;
        // echo '<hr>';
        // echo session_save_path();
        print_r($_SESSION);
        echo '<hr>';
        print_r($this->params);
        // exit;


        return true;
    }

    /**
     * Função personalizada de execução de MENUS.
     * Usado para criar os parâmetros e dados disponibilizados na view.
     * É executado depois do preprocessamento()
     *
     * @return bool
     */
    public function post()
    {

        $this->params['info']['html'] = '<br>Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . __CLASS__ . '</b>.<br>';

        return true;
    }

    /**
     * Função personalizada de execução de MENUS.
     * Usado para criar os parâmetros e dados disponibilizados na view.
     * É executado depois do preprocessamento()
     *
     * @return bool
     */
    public function put()
    {

        $this->params['info']['html'] = '<br>Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . __CLASS__ . '</b>.<br>';

        return true;
    }

    /**
     * Função personalizada de execução de MENUS.
     * Usado para criar os parâmetros e dados disponibilizados na view.
     * É executado depois do preprocessamento()
     *
     * @return bool
     */
    public function get()
    {

        $this->params['info']['html'] = '<br>Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . __CLASS__ . '</b>.<br>';

        return true;
    }

    /**
     * Função personalizada de execução de MENUS.
     * Usado para criar os parâmetros e dados disponibilizados na view.
     * É executado depois do preprocessamento()
     *
     * @return bool
     */
    public function getfull()
    {

        $this->params['info']['html'] = '<br>Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . __CLASS__ . '</b>.<br>';

        return true;
    }

    /**
     * Função personalizada de execução de MENUS.
     * Usado para criar os parâmetros e dados disponibilizados na view.
     * É executado depois do preprocessamento()
     *
     * @return bool
     */
    public function delete()
    {

        $this->params['info']['html'] = '<br>Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . __CLASS__ . '</b>.<br>';

        return true;
    }

    /**
     * Função personalizada de execução de MENUS.
     * Usado para criar os parâmetros e dados disponibilizados na view.
     * É executado depois do preprocessamento()
     *
     * @return bool
     */
    public function test()
    {

        $this->params['info']['html'] = '<br>Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . __CLASS__ . '</b>.<br>';

        return true;
    }

    /**
     * Função personalizada de execução de MENUS.
     * Usado para criar os parâmetros e dados disponibilizados na view.
     * É executado depois do preprocessamento()
     *
     * @return bool
     */
    public function dashboard()
    {

        $this->params['info']['html'] = '<br>Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . __CLASS__ . '</b>.<br>';

        return true;
    }















    /**
     * ********************************************************************************************
     * FUNÇÕES DE API
     * ********************************************************************************************
     */

    /**
     * Função personalizada de execução de API.
     * Usado para executar funções sem necessidade de interface gráfica.
     * É executado depois do preprocessamento()
     *
     * @return array
     */
    public function api($params)
    {

        // Mensagens padrão de retorno.
        $ret = '';
        $msg = 'Execução não retornou resultados.';
        $html = '';
        $post = $_POST;
        $get = $_GET;

        if (!empty($params[0])) {
            switch ($params[0]) {
                case 'post':
                    # code...
                    break;
                case 'put':
                    # code...
                    break;
                case 'get':
                    # code...
                    break;
                case 'getfull':
                    # code...
                    break;
                case 'delete':
                    # code...
                    break;
                case 'test':
                    // Tem retorno.
                    $ret = true;
                    // Mensagem de retorno.
                    $msg = 'Teste realizado com sucesso.';
                    break;

                case 'testhtml':
                    // Modifico header padrão html.
                    $this->params['api']['contentType'] = "text/html";
                    // Tem retorno.
                    $ret = '<h1>Teste Html OK</h1>';
                    // Mensagem de retorno.
                    $msg = 'Teste realizado com sucesso.';
                    break;

                default:
                    # code...
                    break;
            }
        }


        // Monta array de retorno.
        $retorno = [
            'ret' => $ret,
            'msg' => $msg,
            'html' => $html,
            'post' => $post,
            'get' => $get,
        ];
        return $retorno;
    }















    /**
     * ********************************************************************************************
     * FUNÇÕES PÚBLICAS REUTILIZÁVEIS POR INCLUSÃO DE CONTROLLER STATIC
     * ********************************************************************************************
     */

    /**
     * Função para teste.
     *
     * @return void
     */
    public static function teste()
    {
        // Teste.
        echo '<hr>';
        echo '<b>Arquivo</b>: ' . __FILE__ . '.<br><b>função</b>: ' . __FUNCTION__;
        echo '<br><br>';
        echo 'Controller da Plataforma.';
        echo '<hr>';

        return true;
    }















    /**
     * ********************************************************************************************
     * FUNÇÕES PRIVADAS
     * ********************************************************************************************
     * Funções de apoio e organização apenas para a controller atual.
     */
}
