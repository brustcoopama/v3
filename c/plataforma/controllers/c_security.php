<?php

namespace controllers;

use BdLoginsGroups;
use BdPermissions;
use Respect\Validation\Rules\Length;

/**
 * Class: Security
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar toda a segurança.
 * Create: 22/04/2022
 * Update: 22/04/2022
 * 
 * Registros:
 * 22/04/2022 - Criação
 * 
 */

class Security extends \controllers\Plataforma
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
     * Inicia pré execução da segurança.
     *
     * @return bool
     */
    public function startSecurity()
    {
        // verifica se usa segurança.
        if (!$this->params['security']['ativo']) {
            return true;
        }

        // Caso exija sessão (usuário logado).
        if ($this->params['security']['session']) {

            // Checa se sessão está ativa.
            $this->checkSession();

            // Joga informações de usuário em parâmetros.
            $this->pushInfoUser();

            // Permissões
            $this->permissions();
        }
    }


    /**
     * Verifica se uso da API está seguro de acordo com as parametrizações.
     * true para seguro.
     * false para inseguro.
     *
     * @return int
     */
    public function segurancaApi()
    {
        // Padrão.
        $checked = true;

        // Caso não exija sessão (usuário logado).
        if (!$this->params['security']['ativo'])
            return true;

        // Caso não exija sessão (usuário logado).
        if ($this->params['security']['session'] && !isset($this->params['infoUser']['permission']))
            $checked = false;

        // Verifica se não tem token.
        if (!$this->checkToken())
            $checked = false;

        // Verifica se tem permissões para func.
        if (!$this->segurancaApiFunc())
            $checked = false;

        // Retorna resultado de segurança.
        return $checked;
    }

    /**
     * Verifica se uso da Função Página está seguro de acordo com as parametrizações.
     * true para seguro.
     * false para inseguro.
     *
     * @return int
     */
    public function segurancaApiFunc()
    {
        // Caso não exija sessão (usuário logado).
        if (!$this->params['security']['ativo'] || !$this->params['security']['session'])
            return true;

        // Verifica se as permissões do menu são compatíveis com as permissões do usuário logado.
        $exige = $this->params['security']['permission'];
        $tem = $this->params['infoUser']['permission'];

        // Retorna resultado de segurança.
        $r = $this->verificaNiveisAcesso($exige, $tem);

        return $r;
    }

    /**
     * Verifica se uso da Página está seguro de acordo com as parametrizações.
     * true para seguro.
     * false para inseguro.
     *
     * @return int
     */
    public function segurancaPage()
    {

        // Padrão é não ter permissão.
        $checked = true;

        // Verifica se não tem token.
        if (!$this->checkToken())
            $checked = false;

        // Caso não exija sessão (usuário logado).
        if (!$this->params['security']['ativo'] || !$this->params['security']['session'])
            return true;

        // Verifica se usuário tem permissões para a página atual.
        if (!$this->verificaNiveisAcesso($this->params['security']['permission'], $this->params['infoUser']['permission'], false)) {
            $checked = false;
        }

        // Retorna resultado de segurança.
        return $checked;
    }

    /**
     * Verifica se uso da Função Página está seguro de acordo com as parametrizações.
     * true para seguro.
     * false para inseguro.
     *
     * @return int
     */
    public function segurancaPageFunc($menu)
    {
        // Caso não exija sessão (usuário logado).
        if (!$this->params['security']['ativo'] || !$this->params['security']['session'])
            return true;

        // Verifica se as permissões do menu são compatíveis com as permissões do usuário logado.
        $exige = $this->params['menus'][$menu]['permission'];
        $tem = $this->params['infoUser']['permission'];

        // Retorna resultado de segurança.
        return $this->verificaNiveisAcesso($exige, $tem);
    }


    /**
     * Função que faz a parte de logar OFF BD.
     * Para logar personalizado, edite a função logar na controller do módulo.
     *
     * @param string $login
     * @param string $senha
     * @return void
     */
    public function logarOffBD($login, $senha, $options = null, $sessionName = null)
    {

        // Se não foi passado sessão, loga na padrão do módulo.
        if (!$sessionName) {
            $sessionName = $this->params['security']['sessionName'];
        }

        // Guarda usuário.
        $infoUser = null;

        // Percorre lista offline de usuários.
        foreach (VC_INFOUSER as $key => $value) {

            // Verifica se credenciais do usuário batem.
            if ($value['login'] == $login && $value['senha'] == $senha) {

                // Tira a senha do vetor.
                unset($value['senha']);

                // Salva informações do usuário.
                $infoUser = $value;

                // Finaliza foreach.
                break;
            }
        }

        // Verifica se achou usuário.
        if ($infoUser) {

            // Monta as permissões de grupo padronizadas do usuário off BD.
            $permissionsGroups = array();
            // Percorre os ids de grupos.
            foreach ($infoUser['groups'] as $key => $value) {
                $tmp = [
                    'id'         => $key,
                    'idEntity'   => $value,
                    'entity'     => 1,                                          // [1] Grupo
                    'name'       => 'Permissão Total',
                    'urlPage'    => $this->params['infoUrl']['url_friendly'],
                    'obs'        => 'Grupo. Off BD.',
                    'permissions' => $infoUser['permission'],
                ];
                $permissionsGroups[$value] = $tmp;
            }
            // Joga permissões de grupo organizadas e padronizadas dentro de info user.
            $infoUser['groups'] = $permissionsGroups;

            // Faz a parte de criar a sessão com todas as informações passadas.
            $this->createSession($sessionName, $infoUser, $options);
        } else {
            // Guarda informação de que não logou.
            if ($this->params['security']['feedback'])
                \classes\FeedBackMessagens::addWarning('Não logado!', 'Login e Senha não correspondem. Verificar se foram digitados corretamente. Ou contate a administração.');
        }
    }


    /**
     * Função que faz a parte de logar com BD.
     * Para logar personalizado, edite a função logar na controller do módulo.
     *
     * @param string $login
     * @param string $senha
     * @return void
     */
    public function logarBD($login, $senha, $options = null, $sessionName = null)
    {
        // Verifica se controller usa BD.
        if (!$this->params['config']['bd']) {
            // FeedBack
            \classes\FeedBackMessagens::addWarning('Banco de Dados', 'Ative o banco de dados na controller para poder usar o login via BD.');
            return true;
        }

        // Se não foi passado sessão, loga na padrão do módulo.
        if (!$sessionName) {
            $sessionName = $this->params['security']['sessionName'];
        }

        // Criptografa senha.
        $senha = hash('sha256', $senha);

        // Guarda usuário.
        $infoUser = \BdLogins::verificaLogin($login, $senha);

        // Acessa BdLogins
        $grupos = BdLoginsGroups::selecionarPorLogin($infoUser['id']);

        // Monta as permissões de grupo padronizadas do usuário off BD.
        $permissionsGroups = array();

        // Percorre os ids de grupos.
        foreach ($grupos as $key => $value) {
            $tmp = [
                'id'          => $value['id'],
                'idEntity'    => $value['idGroup'],
                'entity'      => $value['idGroup'],   // [1] Grupo
                'name'        => '',
                'urlPage'     => '',
                'obs'         => '',
                'permissions' => '000000000',
            ];
            $permissionsGroups[$value['idGroup']] = $tmp;
        }

        // Verifica se achou usuário.
        if ($infoUser) {

            // Informações default de usuário. Garante que terá no mínimo esses campos.
            $infoUserDefault = [
                'id'         => $infoUser['id'],      // Identificador único do usuário.
                'nome'       => $infoUser['fullName'],      // Nome para ser exibido.
                'login'      => $infoUser['userName'],      // Identificação de usuário (user, matricula, email, id).
                'permission' => '000000000',          // Permissões personalizadas do usuário logado. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
                'groups'     => $permissionsGroups,   // Grupos que usuário pertence.
                'urlTarget'  => $infoUser['initialUrl'],                   // Redireciona para url após o login.
            ];

            // Mescla com as informações recebidas.
            $infoUser = array_merge($infoUserDefault, $infoUser);

            // Faz a parte de criar a sessão com todas as informações passadas.
            $this->createSession($sessionName, $infoUser, $options);
        } else {

            if ($this->params['security']['feedback'])
                // Guarda informação de que não logou.
                \classes\FeedBackMessagens::addWarning('Não logado!', 'Login e Senha não correspondem. Verificar se foram digitados corretamente. Ou contate a administração.');
        }
    }

    /**
     * Função que limpa sessão atual.
     *
     * @return void
     */
    public function deslogar($sessionName = null)
    {
        // Verifica se foi passada sessão específica.
        if ($sessionName)
            \classes\Session::destroy($sessionName);
        else
            \classes\Session::destroy($this->params['security']['sessionName']);
    }


    /**
     * Verifica se o parâmetro passado é uma função a ser executada. 
     * Alivia o carregamento da página e ajuda no dinamismo.
     *
     * @return string
     */
    public function checkMenu()
    {
        // Menu default padrão
        $menu = 'index';

        // Verifica se primeiro parâmetro é uma função da controller ou apenas parâmetro.
        if (!empty($this->params['infoUrl']['attr'][0]) && !empty($this->params['menus'][$this->params['infoUrl']['attr'][0]]) && method_exists(new $this->params['infoUrl']['controller_class_name'], $this->params['infoUrl']['attr'][0])) {
            $menu = $this->params['infoUrl']['attr'][0];
        }

        // Acrescenta nas informações de variável qual função (menu) está sendo chamado.
        $this->params['infoUrl']['func'] = $menu;

        // Retorna o menu ao qual a controller irá executar.
        return $menu;
    }









    /**
     * ********************************************************************************************
     * FUNÇÕES DE APOIO DA CLASSE
     * ********************************************************************************************
     */

    /**
     * Checa se exige sessão (config).
     * Caso não esteja logado, redireciona para login (config). 
     * Guarda a url que estava querendo acessar, para voltar nela depois de logar.
     *
     * @return void
     */
    protected function checkSession()
    {
        // checa se sessão está dentro do tempo de segurança.
        $check = \classes\Session::check($this->params['security']['sessionName'], $this->params['security']['sessionTimeOut']);

        // Verifica se sessão do usuário não está ativa.
        if (!$check) {

            // Não recarrega se tiver na própria página de login.
            if ($this->params['infoUrl']['url'] != $this->params['security']['loginPage']) {

                // Monta caminho para página de login
                $url_login = $this->params['security']['loginPage'];

                // Guarda URL que quer ir (urlTarget) na sessão geral.
                \classes\Session::setOptions('urlTarget', '/' . $this->params['infoUrl']['url']);

                // Se estiver em uma API não manda para login.
                if (!$this->params['paths']['A_ATIVO']) {
                    // Redireciona usuário para login.
                    header("location: " . $url_login);

                    // Garante que vai redirecionar.
                    exit;
                } else {
                    echo '{"msg":"Sem permissão."}';
                    exit;
                }
            }
        }
    }


    /**
     * Função que faz o trabalho de criar a sessão do usuário logado.
     *
     * @param array $infoUser
     * @param array $options
     * @return void
     */
    protected function createSession($sessionName, $infoUser, $options = null)
    {
        // Prepara parâmetros de login.
        $url = $this->params['security']['restrictPage'];
        if (\classes\Session::getOptions('urlTarget')) {
            $url = \classes\Session::getOptions('urlTarget');
            // Limpa target.
            \classes\Session::setOptions('urlTarget');
        }
        // CRIA SESSÃO com usuário fíxo (off BD).
        // informações de usuário tem que seguir padrão da config.
        \classes\Session::create($sessionName, $infoUser, $url);

        // Se tiver opções.
        if ($options) {
            // Acrescenta opções a sessão do usuário.
            \classes\Session::pushSessionOptions($sessionName, $options);
        }
    }

    /**
     * Joga informações de usuário em parâmetros.
     *
     * @return void
     */
    protected function pushInfoUser()
    {

        // Caso tenha sessão, pega as informações do usuário logado.
        $this->params['infoUser'] = \classes\Session::getinfoUser($this->params['security']['sessionName']);
    }

    /**
     * Faz o calculo de todas as permissões e gera a permissão final para a página atual.
     *
     * @return void
     */
    protected function permissions()
    {
        // Permissão default. (Sem permissão)
        $permission = '000000000';

        // Permissão inicial do usuário.
        $permission = (string)$this->params['infoUser']['permission'];

        // Caso usuário já tenha todas as permissões sai da função.
        if ($this->fullPermissions($permission)) {
            return true;
        }

        // Somar permissões de grupos da controller.
        foreach ($this->params['security']['groups'] as $key => $value) {
            // Verifica se tem o grupo na controller.
            if (isset($this->params['infoUser']['groups'][$value])) {
                $permission = $this->somaPermissions($permission, '111111111');
            }
        }

        // Caso usuário já tenha todas as permissões sai da função.
        if ($this->fullPermissions($permission)) {
            return true;
        }

        // Somar permissões de usuários (ids) da controller..
        foreach ($this->params['security']['ids'] as $key => $value) {
            // Verifica se tem o grupo na controller.
            if ($this->params['infoUser']['id'] == $value) {
                $permission = $this->somaPermissions($permission, '111111111');
            }
        }

        // Caso usuário já tenha todas as permissões sai da função.
        if ($this->fullPermissions($permission)) {
            return true;
        }

        // Somar permissões de grupos do usuário.
        foreach ($this->params['infoUser']['groups'] as $key => $value) {
            // Verifica se tem o grupo na controller.
            $permission = $this->somaPermissions($permission, (string)$value['permissions']);
        }

        // Caso usuário já tenha todas as permissões sai da função.
        if ($this->fullPermissions($permission)) {
            return true;
        }

        // Busca no banco de dados as permissões para a página atual.
        if ($this->params['config']['bd'] && !isset($this->params['infoUser']['off'])) {

            // Carrega os grupos do usuário logado.
            $this->params['infoUser']['groups'] = BdLoginsGroups::selecionarPorLogin($this->params['infoUser']['id']);

            $in = '';
            // Somar permissões de grupos do usuário.
            foreach ($this->params['infoUser']['groups'] as $key => $value) {
                // Verifica se tem o grupo na controller.
                $in .= ',' . $value['idGroup'];
            }
            $in[0] = ' ';

            // Pesquisa todas as permissões para página atual e com os grupos do usuário logado.
            $r = BdPermissions::selecionarPorIdGrupoUrl($this->params['infoUser']['id'], $in, $this->params['infoUrl']['url_friendly']);

            // Percorre e soma todas as permissões que usuário tem nesta página.
            foreach ($r as $key => $value) {
                $permission = $this->somaPermissions($permission, $value['permissions']);
            }
        }

        // Cria o vetor associativo de permissões para ser usado nos parâmetros.
        $this->createInfoUserPermissions($permission);

        return true;
    }

    /**
     * Verifica se usuário já tem todas as permissões.
     *
     * @param string $permission
     * @return bool
     */
    protected function fullPermissions($permission)
    {
        $fullPermission = true;
        foreach (str_split($permission) as $key => $value) {
            if ($value == 0)
                $fullPermission = false;
        }

        // Se tem todas as permissões, já inclui nas permissões de usuário.
        if ($fullPermission) {
            // Monta as permissões finais do usuário.
            $this->createInfoUserPermissions('111111111');
        }
        return $fullPermission;
    }

    /**
     * Joga permissão string em array associativo permissions do usuário.
     *
     * @param string $permission
     * @return void
     */
    protected function createInfoUserPermissions($permission)
    {

        // Atualiza permissões do usuário.
        $this->params['infoUser']['permission'] = $permission;

        // Monta as permissões finais nos parâmetros.
        $this->params['infoUser']['permissions'] = [
            'menu'    => $permission[0],
            'index'   => $permission[1],
            'post'    => $permission[2],
            'put'     => $permission[3],
            'get'     => $permission[4],
            'getFull' => $permission[5],
            'delete'  => $permission[6],
            'api'     => $permission[7],
            'test'    => $permission[8],
        ];
    }

    /**
     * Faz a soma OR de permissões.
     *
     * @param string $permission1
     * @param string $permission2
     * @return string
     */
    protected function somaPermissions($permission1, $permission2)
    {
        $permission1[0] = $permission2[0] == '1' ? 1 : $permission1[0];
        $permission1[1] = $permission2[1] == '1' ? 1 : $permission1[1];
        $permission1[2] = $permission2[2] == '1' ? 1 : $permission1[2];
        $permission1[3] = $permission2[3] == '1' ? 1 : $permission1[3];
        $permission1[4] = $permission2[4] == '1' ? 1 : $permission1[4];
        $permission1[5] = $permission2[5] == '1' ? 1 : $permission1[5];
        $permission1[6] = $permission2[6] == '1' ? 1 : $permission1[6];
        $permission1[7] = $permission2[7] == '1' ? 1 : $permission1[7];
        $permission1[8] = $permission2[8] == '1' ? 1 : $permission1[8];

        return $permission1;
    }

    /**
     * Verifica se token passado está de acordo com o token solicitado.
     *
     * @return bool
     */
    protected function checkToken()
    {
        // Verifica se NÃO usa token e sai.
        if (!$this->params['security']['token'] || !$this->params['security']['ativo']) {
            return true;
        }

        // Verifica se é uma API e se tem token.
        if ($this->params['paths']['A_ATIVO'] && !(isset($_POST['token']) || isset($_GET['token'])))
            return false;




        // CRIA OS TOKENS DE PÁGINA E API
        // ************************************************

        // PAGE
        // Monta os valores para criação do token.
        $url = $this->params['infoUrl']['url_friendly'];
        $func = $this->checkMenu();
        // Cria o token e joga para view.
        $this->params['tokens']['pageFunc'] = \classes\TokenPlataforma::createPage($url, $func);
        
        // API
        // Monta os valores para criação do token de API.
        $url = $this->params['infoUrl']['url_friendly'];
        // Cria o token e joga para view.
        $this->params['tokens']['pageApi'] = \classes\TokenPlataforma::createApi($url);


        
        // Verifica se NÃO tem dados de transações e sai.
        if (empty($_POST) && (sizeof($_GET) == 0 || (sizeof($_GET) == 1 && isset($_GET['url'])))) {
            return true;
        }

        // Verifica se foi passado token pela transação.
        if (!(isset($_POST['token']) || isset($_GET['token']))) {

            // Mensagem para usuário.
            \classes\FeedBackMessagens::addDanger('Transações', 'Token não informado. Transações de dados interrompida.');
            
            return false;
        }

        // Retorno padrão.
        $check = true;
        $token = null;

        // Pega o token nas transações GET.
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
        }

        // Pega o token nas transações POST.
        if (isset($_POST['token'])) {
            $token = $_POST['token'];
        }

        // Se for página, cria e verifica token.
        if (!(isset($this->params['infoUrl']['attr'][0]) && $this->params['infoUrl']['attr'][0] == 'api') && !$this->params['paths']['A_ATIVO']) {

            // Verifica se token de página NÃO está correto.
            if ($token != $this->params['tokens']['pageFunc']) {

                // Mensagem para usuário.
                \classes\FeedBackMessagens::addDanger('Transações', 'Token inválido. Transações de dados interrompida.');

                $check = false;
            }
        }

        // Se for API, cria e verifica token.
        if ((isset($this->params['infoUrl']['attr'][0]) && $this->params['infoUrl']['attr'][0] == 'api') || $this->params['paths']['A_ATIVO']) {

            // Verifica se token de API NÃO está correto.
            if ($token != $this->params['tokens']['pageApi']) {

                // Mensagem para usuário.
                \classes\FeedBackMessagens::addDanger('Transações', 'Token inválido. Transações de dados interrompida.');

                $check = false;
            }
        }

        if (!$check) {
            $_GET = [];
            $_POST = [];
        }

        // Retorna 
        return $check;
    }



    /**
     * Retorna os dados do usuário logado
     *
     * @return array
     */
    public static function infoUser()
    {
        if (VC_PATHS['A_ATIVO']) {
            $sessionName = VC_PATHS['A_NAME'];
        } else {
            $sessionName = VC_PATHS['M_NAME'];
        }

        // Monta as informações.
        $infoUser = \classes\Session::getInfoUser($sessionName);

        // Retorna o array com informações do usuário logado.
        return $infoUser;
    }










    /**
     * * *******************************************************************************************
     * FUNÇÕES PRIVADAS DA CLASSE (APOIO)
     * * *******************************************************************************************
     * Uso somente dentro dessa controller.
     */


    /**
     * Verifica níveis de acesso de cada permissão.
     *
     * @param array $exige
     * @param array $tem
     * @return void
     */
    private function verificaNiveisAcesso($exige, $tem, $feedBack = true)
    {
        $checked = true;

        // Verifica se tem as permissões específicas.
        if ($exige[0] && !$tem[0]) {
            if ($this->params['security']['feedback'] && $feedBack)
                \classes\FeedBackMessagens::addWarning('Menu', 'Sem permissão para acessar as funções de menu');
            $checked = false;
        }
        if ($exige[1] && !$tem[1]) {
            if ($this->params['security']['feedback'] && $feedBack)
                \classes\FeedBackMessagens::addWarning('Index', 'Sem permissão para acessar as funções de index');
            $checked = false;
        }
        if ($exige[2] && !$tem[2]) {
            if ($this->params['security']['feedback'] && $feedBack)
                \classes\FeedBackMessagens::addWarning('Post', 'Sem permissão para acessar as funções de post');
            $checked = false;
        }
        if ($exige[3] && !$tem[3]) {
            if ($this->params['security']['feedback'] && $feedBack)
                \classes\FeedBackMessagens::addWarning('Put', 'Sem permissão para acessar as funções de put');
            $checked = false;
        }
        if ($exige[4] && !$tem[4]) {
            if ($this->params['security']['feedback'] && $feedBack)
                \classes\FeedBackMessagens::addWarning('Get', 'Sem permissão para acessar as funções de get');
            $checked = false;
        }
        if ($exige[5] && !$tem[5]) {
            if ($this->params['security']['feedback'] && $feedBack)
                \classes\FeedBackMessagens::addWarning('GetFull', 'Sem permissão para acessar as funções de getFull');
            $checked = false;
        }
        if ($exige[6] && !$tem[6]) {
            if ($this->params['security']['feedback'] && $feedBack)
                \classes\FeedBackMessagens::addWarning('Delete', 'Sem permissão para acessar as funções de delete');
            $checked = false;
        }
        if ($exige[7] && !$tem[7]) {
            if ($this->params['security']['feedback'] && $feedBack)
                \classes\FeedBackMessagens::addWarning('Api', 'Sem permissão para acessar as funções de api');
            $checked = false;
        }
        if ($exige[8] && !$tem[8]) {
            if ($this->params['security']['feedback'] && $feedBack)
                \classes\FeedBackMessagens::addWarning('Test', 'Sem permissão para acessar as funções de test');
            $checked = false;
        }

        return $checked;
    }
}
