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
class TesteControllerApi extends apiControllers\Api
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
            'ativo'             => false,

            // Usuário só acessa a controller logado.
            'session'           => false,

            // Nome da sessão deste projeto.
            'sessionName'       => $this->params['paths']['A_NAME'],

            // Tempo para sessão acabar.
            'sessionTimeOut'    => (60 * 30),

            // Caminho para página de login.
            'loginPage'         => $this->params['paths']['M_NAME'] . '/login/',

            // Caminho para página restrita.
            'restrictPage'      => $this->params['paths']['M_NAME'] . '/admin/',

            // Permissões personalizadas da página atual. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
            'permission'        => '111111111',

            // Transações de dados (GET - POST) apenas com token. Usar classe Tokens. Exemplo: (<input name="token" type="text" value="{{token}}" hidden>').
            'token'             => false, // Só aceitar com token.

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
            'ids'               => [
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
