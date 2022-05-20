<?php

/**
 * Class: 
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por iniciar toda a aplicação.
 * Create: 11/04/2022
 * Update: 11/04/2022
 * 
 * Registros:
 * 11/04/2022 - Criação
 * 
 */


// Carrega classe motor da aplicação.
require_once 'c/plataforma/Core.php';

// Cria uma instância do motor.
$core = new v3\Core();

// Executa o motor da aplicação.
$core->start();