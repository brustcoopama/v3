<?php

namespace classes;

class Session
{
    /**
     * Inicia serviço de sessão.
     *
     * @return void
     */
    public static function start()
    {
        // Inicia serviço.
        session_start();
    }













    /**
     * ********************************************************************************************
     * SESSÃO USUÁRIO LOGADO
     * ********************************************************************************************
     * Sessão que guarda informações do usuário logado.
     * Guarda informações de permissões e grupos.
     */

    /**
     * Cria uma sessão vazia ou com informações de usuário.
     * Redireciona para session 'urlTarget'.
     *
     * @param string $sessionName
     * @return void
     */
    public static function create($sessionName, $infoUser = array(), $url)
    {
        // Informações default de usuário. Garante que terá no mínimo esses campos.
        $infoUserDefault = [
            'id'          => '0',           // Identificador único do usuário.
            'nome'        => 'guest',       // Nome para ser exibido.
            'login'       => 'guest',       // Identificação de usuário (user, matricula, email, id).
            'senha'       => '',            // Senha usada para logar. Depois é retirada da sessão.
            'permission'  => '000000000',   // Permissões personalizadas do usuário logado. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
            'groups'      => [],            // Grupos que usuário pertence.
            'urlTarget' => '',            // Redireciona para url após o login.
        ];

        // Mescla com as informações recebidas.
        $infoUser = array_merge($infoUserDefault, $infoUser);

        // Guarda o time atual.
        $_SESSION[$sessionName]['sessionTimeOut'] = time();
        // Guarda informações de usuário logado.
        $_SESSION[$sessionName]['infoUser'] = $infoUser;
        // Guarda opções personalizadas do usuário.
        $_SESSION[$sessionName]['options']['raiz_url'] = '/' . VC_PATHS['M_NAME'] . '/';

        // Caso tenha uma url para ser redirecionado após o login e não tenha perdido sessão.
        if ($infoUser['urlTarget'] && !\classes\Session::getOptions('urlTarget'))
            $url = $infoUser['urlTarget'];

        // Redireciona usuário para login.
        header("location: " . $url);
        // Garante que vai finalizar
        exit;
    }

    /**
     * Acrescenta opções personalizadas na sessão logada.
     * Faz um merge com as opções atuais.
     *
     * @param string $sessionName
     * @param array $options
     * @return bool
     */
    public static function pushSessionOptions($sessionName, $options)
    {
        // Verifica se tem sessão aberta.
        if (isset($_SESSION[$sessionName]) && isset($_SESSION[$sessionName]['options'])) {
            // Mescla opções novas com as que já estavam na sessão.
            $_SESSION[$sessionName]['options'] = array_merge($_SESSION[$sessionName]['options'], $options);
            return true;
        }
        return false;
    }

    /**
     * Adiciona um valor para dentro de options da sessão.
     *
     * @param string $sessionName
     * @param string $name
     * @param string|array $value
     * @return void
     */
    public static function setSessionOptions($sessionName, $name, $value = '')
    {

        // Mescla opções novas com as que já estavam na sessão.
        $_SESSION[$sessionName]['options'] = array_merge($_SESSION[$sessionName]['options'], [$name => $value]);
    }

    /**
     * Obtém opção ou todas as opções da sessão.
     *
     * @param string $sessionName
     * @param string $name
     * @return void
     */
    public static function getSessionOptions($sessionName, $name = null)
    {
        // Verifica se foi passado nome da opção.
        if ($name) {
            // Retorna o valor da oção escolhida.
            return $_SESSION[$sessionName]['options'][$name];
        } else {
            // Retorna todas as opções.
            return $_SESSION[$sessionName]['options'];
        }
    }

    /**
     * Apaga sessão específica ou todas as sessões.
     *
     * @param string $sessionName
     * @return void
     */
    public static function destroy($sessionName = null)
    {
        if ($sessionName) {
            unset($_SESSION[$sessionName]);
        } else {
            session_destroy();
        }
    }

    /**
     * Retorna informações do usuário.
     *
     * @param string $sessionName
     * @return array
     */
    public static function getInfoUser($sessionName, $name = null)
    {
        // Verifica se sessão existe e retorna.
        if (!empty($sessionName) && isset($_SESSION[$sessionName])){
            if ($name) {
                return $_SESSION[$sessionName]['infoUser'][$name];
            }
            return $_SESSION[$sessionName]['infoUser'];
        }else
            return false;
    }

    /**
     * Verifica se está logado.
     *
     * @param string $sessionName
     * @param int $sessionNameTimeOut
     * @return void
     */
    public static function check($sessionName, $sessionNameTimeOut = (60 * 30))
    {
        // Retorno padrão de segurança.
        $check = false;

        // Verifica se existe sessão.
        if (isset($_SESSION[$sessionName])) {

            // Verifica se estorou o limite definido em configurações.
            if ((time() - $_SESSION[$sessionName]['sessionTimeOut']) > ($sessionNameTimeOut)) {

                // Se estourou o limite de tempo, limpa a sessão.
                self::destroy($sessionName);
            } else {

                // Não estourou o tempo limite, zera a contagem novamente.
                $_SESSION[$sessionName]['sessionTimeOut'] = time();

                // Sessão ok.
                $check = true;
            }
        }

        // Retorna se sessão está ok.
        return $check;
    }










    /**
     * ********************************************************************************************
     * SESSÃO GERAL
     * ********************************************************************************************
     * Sessão onde usuário não precisa estar logado.
     * Guarda informações de uso do público.
     */

    /**
     * Acrescenta informações personalizadas na sessão geral.
     * Usuário NÃO logado.
     *
     * @param array $options
     * @return void
     */
    public static function pushOptions($options)
    {

        // Mescla opções novas com as que já estavam na sessão.
        $_SESSION['options'] = array_merge($_SESSION['options'], $options);
    }

    /**
     * Adiciona um valor para dentro de options da sessão geral.
     *
     * @param string $name
     * @param string|array $value
     * @return void
     */
    public static function setOptions($name, $value = '')
    {
        // Caso não tenha a sessão options, cria.
        if (!isset($_SESSION['options'])) {
            $_SESSION['options'] = array();
        }
        // Guarda o time atual.
        $_SESSION['options'] = array_merge($_SESSION['options'], [$name => $value]);
    }

    /**
     * Obtém opção ou todas as opções da sessão geral.
     *
     * @param string $name
     * @return void
     */
    public static function getOptions($name = null)
    {
        // Caso não tenha a sessão options, cria.
        if (!isset($_SESSION['options'])) {
            $_SESSION['options'] = array();
        }

        // Verifica se foi passado nome da opção.
        if ($name) {
            if (isset($_SESSION['options'][$name])) {
                // Retorna o valor da oção escolhida.
                return $_SESSION['options'][$name];
            }
            return false;
        } else {
            // Retorna todas as opções.
            return $_SESSION['options'];
        }
    }

    /**
     * Destroi todas as opções da sessão geral.
     *
     * @param string $name
     * @return void
     */
    public static function destroyOptions()
    {
        // Caso não tenha a sessão options, cria.
        if (!isset($_SESSION['options'])) {
            $_SESSION['options'] = array();
        }

        // Limpa sessão de opções.
        unset($_SESSION['options']);

        // Cria vazio.
        $_SESSION['options'] = array();
    }
}
