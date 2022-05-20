<?php

namespace moduloControllers;

/**
 * Class: Security
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar a segurança personalizada do módulo acessado.
 * Create: 12/04/2022
 * Update: 18/04/2022
 * 
 * Registros:
 * 22/04/2022 - Criação.
 * 
 */
class Security extends \controllers\Page
{


    /**
     * ********************************************************************************************
     * PARÂMETROS DA CLASSE
     * ********************************************************************************************
     */



    /**
     * ********************************************************************************************
     * FUNÇÕES PERSONALIZADAS DA CLASSE NESTE MÓDULO
     * ********************************************************************************************
     */

    /**
     * Função que faz a parte de logar OFF BD.
     * Para logar personalizado, habilite e edite essa função.
     *
     * @param string $login
     * @param string $senha
     * @return void
     */
    // public function logarOffBD($login, $senha){}

    /**
     * Função que faz a parte de logar com BD.
     * Para logar personalizado, habilite e edite essa função.
     *
     * @param string $login
     * @param string $senha
     * @return void
     */
    // public function logarBD($login, $senha){}


    /**
     * Realiza o carregamento dos parâmetros de Segurança.
     * Substitui os defaults.
     */
    // public function loadParamsSecurity(){return array();}


}