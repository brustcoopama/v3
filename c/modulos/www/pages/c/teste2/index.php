<?php

/**
 * Modelo de controller para páginas.
 */
class IndexControllerPage extends \moduloControllers\Page
{

    /**
     * Inicia o motor da função API.
     *
     * @return bool
     */
    public function start()
    {

        // Teste.
        echo '<hr>';
        echo '<b>Arquivo</b>: ' . __FILE__ . '.<br><b>função</b>: ' . __FUNCTION__;
        self::teste();

        // Finaliza a função.
        return true;
    }
}