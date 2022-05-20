<?php


namespace controllers;


use Twig\Extra\Intl\IntlExtension;


/**
 * Class: Render
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar html.
 * Create: 22/04/2022
 * Update: 22/04/2022
 * 
 * Registros:
 * 22/04/2022 - Criação
 * 
 */
class Render
{

    


    /**
     * Renderiza a parte gráfica (html) do site.
     * Recebe os arquivos modelos HTML e o seu conteúdo.
     * Recebe parâmetros de variáveis para serem usados dentros dos modelos.
     *
     * @param array $params
     * @return void
     */
    public static function renderPage($params)
    {
        // Carrega arquivo chache.
        if ($params['config']['cache']) {

            // Fazer uma função que resolve os problemas de chace.
            $html = '<br>Desenvolver a função de uso e controle de cache.';
            $html .= '<br>Arquivo: ' .  __FILE__;
            $html .= '<br>Função: ' .  __FUNCTION__;
            // Retorna o html.
            return $html;
        }

        // Arquivos locais.
        $vurll = new \Twig\Loader\ArrayLoader(
            $params['structure']
        );

        // Todo: Não implementado. Apenas exemplo.
        // Arquivos virtuais.
        // Variável receberá a estrutura serialize do banco de dados.
        $estruturaVirtual = [
            'html' => '<div id="html"><div id="head"><title>Banco de dados</title>{% block head %}{% endblock %}</div><div id="body">{% block body %}{% endblock %}</div></div>',
            'head' => '{% block head %}<div value="teste">array head</div>{% endblock %}',
        ];
        $vurlv = new \Twig\Loader\ArrayLoader($estruturaVirtual);

        // Monta quais são as partes (pastas) que se usa no template da página atual.
        $base = '';
        foreach (array_keys($params['structure']) as $key => $value) {
            if (!$key == 0)
                $base .= '{% use "' . $value . '" %}';
        }

        // Base html. Aqui controla quais arquivos o TWIG irá renderizar.
        $html_base = new \Twig\Loader\ArrayLoader([
            'base' => '{% extends "html" %}' . $base
        ]);

        // Sequência de prioridade. Arquivos físicos depois Virtuais.
        $loader = new \Twig\Loader\ChainLoader([$vurll, $vurlv, $html_base]);
        $twig   = new \Twig\Environment($loader);
        $twig->addExtension(new IntlExtension());

        // Limpa valores de estrutura para não sujar view.
        unset($params['structure']);

        // Após carregar os templates HTML, e passar os parmâmetros, desenha página na tela.
        return $twig->render('base', $params);
    }

    /**
     * Renderiza objetos.
     * Renderiza um objeto html com os parâmetros passados.
     * Retorna uma string HTML.
     *
     * @param string $objName
     * @param array $params
     * @return string
     */
    public static function obj($objName, $params = array())
    {
        // Renderiza
        return self::twig(VC_PATHS['M_PATH_OBJS'], $objName, $params);
    }

    /**
     * Renderiza objetos.
     * Renderiza um objeto html com os parâmetros passados.
     * Retorna uma string HTML.
     *
     * @param string $objName
     * @param array $params
     * @return string
     */
    public static function objPlatforma($objName, $params = array())
    {
        // Renderiza
        return self::twig(VC_PATHS['P_PATH_OBJS'], $objName, $params);
    }

    /**
     * Renderiza objetos.
     * Renderiza um objeto html com os parâmetros passados.
     * Retorna uma string HTML.
     *
     * @param string $path
     * @param string $objName
     * @param array $params
     * @return string
     */
    public static function twig($path, $objName, $params = array())
    {
        // Verifica se arquivo NÃO existe e retorna.
        if (!file_exists($path . $objName . '.html')) {
            return 'Arquivo não encontrado: ' . $path . $objName . '.html';
        }

        // Inicia a construção do objeto HTML
        $loader   = new \Twig\Loader\FilesystemLoader($path);   // Verifica a pasta objs.
        $twig     = new \Twig\Environment($loader);             // Instancia objeto twig.
        $twig->addExtension(new IntlExtension());
        $template = $twig->load($objName . '.html');            // Retorna template html.
        return $template->render($params);                      // Junta parametros com template. (array associativo)
    }

    /**
     * Renderiza uma string html passando parâmetros.
     *
     * @param string $html
     * @param array $params
     * @return HTML
     */
    public static function renderHtml($html, $params = array())
    {

        // Inicia a construção do HTML
        $loader = new \Twig\Loader\ArrayLoader([
            'index' => $html,
        ]);
        $twig = new \Twig\Environment($loader);
        $twig->addExtension(new IntlExtension());

        return $twig->render('index', $params);
    }






























    // todo old - VERIFICAR PEGAR AS FUNÇÕES QUE VAI USAR E APAGAR

    public static $test = true;

    /**
     * Renderiza objetos da pasta v/plugin/.
     * Renderiza um objeto html passando parâmetros (pasta/nomeobj - sem mencionar a extenção .html).
     * Retorna uma string HTML.
     *
     * @param string $objName
     * @param array $params
     * @return string
     */
    public static function renderPluginView($objName, $params = array())
    {
        // Inicia a construção do objeto HTML
        $loader   = new \Twig\Loader\FilesystemLoader('m/plugins/');  // Verifica a pasta objs.
        $twig     = new \Twig\Environment($loader);                   // Instancia objeto twig.
        $twig->addExtension(new IntlExtension());
        $template = $twig->load($objName . '.html');                  // Retorna template html.
        return $template->render($params);                            // Junta parametros com template. (array associativo)
    }

    /**
     * Renderiza objetos da pasta m/plugin/.
     * Renderiza um objeto js passando parâmetros (pasta/nomeobj - sem mencionar a extenção .js).
     * Retorna uma string js.
     *
     * @param string $objName
     * @param array $params
     * @return string
     */
    public static function renderPluginJs($objName, $params = array())
    {
        // Inicia a construção do objeto HTML
        $loader   = new \Twig\Loader\FilesystemLoader('m/plugins/');  // Verifica a pasta objs.
        $twig     = new \Twig\Environment($loader);                   // Instancia objeto twig.
        $twig->addExtension(new IntlExtension());
        $template = $twig->load($objName . '.js');                    // Retorna template html.
        return $template->render($params);                            // Junta parametros com template. (array associativo)
    }
}
