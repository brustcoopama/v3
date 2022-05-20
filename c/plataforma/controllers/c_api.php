<?php

namespace controllers;

/**
 * Class: Api
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar api da página acessada.
 * Create: 22/04/2022
 * Update: 22/04/2022
 * 
 * Registros:
 * 22/04/2022 - Criação
 * 25/04/2022 - Inclusão das funções.
 * 
 */
class Api extends \controllers\Security
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
	 * Inicia o motor da função API.
	 *
	 * @return bool
	 */
	public function start()
	{
		// Executa a API, caso seja API. (Controller API)
		$this->executeApi();

		// Finaliza a função.
		return true;
	}

	/**
	 * Inicia a api. 
	 * Usada para carregar especificidades da página.
	 * Alivia o carregamento da página e ajuda no dinamismo.
	 *
	 * @return bool
	 */
	public function executeApi()
	{

		// Se não for API, cancela execução.
		if (!(isset($this->params['infoUrl']['attr'][0]) && $this->params['infoUrl']['attr'][0] == 'api') && !$this->params['paths']['A_ATIVO'])  {
			return false;
		}
		
		// Fala que é uma API;
		$this->params['paths']['A_ATIVO'] = true;

		// Limpa primeiro parâmetros "api".
		if (!empty($this->params['infoUrl']['attr'][0]) && $this->params['infoUrl']['attr'][0] == 'api') {
			
			unset($this->params['infoUrl']['attr'][0]);
			$this->params['infoUrl']['attr'] = array_values($this->params['infoUrl']['attr']);
		}

		// Verifica a segurança.
		$seguroApi = $this->segurancaApi();

		// Verifica configurações e carrega dependências personalizadas da controller.
        $this->carregaDependencias();

		// Se seguro.
		if ($seguroApi) {
			// Chama a função principal da api.
			$retorno = $this->api($this->params['infoUrl']['attr']);
		}else{
			$retorno['ret'] = false;
			$retorno['msg'] = 'Sem permissões suficientes para acessar a função.';
		}

		// Seta o cabeçalho específicado nos parâmetros.
		header('Content-Type: ' . $this->params['api']['contentType'] . '; charset=' . $this->params['api']['charset']);

		// Caso seja o padrão de saída JSON.
		if ($this->params['api']['contentType'] == "application/json") {
			// Retorno exemplo para Json.
			$retorno['status'] = 'OK.';
			$retorno['action'] = empty($this->params['infoUrl']['attr'][0]) ? 'index' : $this->params['infoUrl']['attr'][0];
			$retorno['params'] = $this->params['infoUrl']['attr'];

			// Retorna um Json na tela.
			echo json_encode($retorno);
		} else {
			// Caso não seja Json, apenas exibe o resultado proposto.
			print_r($retorno['ret']);
		}

		// Retorna true após a execução de todo o comando.
		return true;
	}

    /**
     * CARREGA OS PARÂMETROS DA CONFIGURAÇÃO
     * Inicia parâmetros gerais da controller, tanto para Módulo quanto para Api.
     *
     * @return bool
     */
    public function carregaDependencias()
    {
        // Carrega as classes de Banco de Dados.
        $this->carregaBDs();

        // Carrega as classes para funções específicas.
        $this->carregaClasses();

        // Carrega as controllers para uso das funções staticas.
        $this->carregaControllers();

    }
}
