<?php

namespace controllers;

/**
 * Class: BD
 * Version: 3.0.0
 * Autor: Mateus Brust
 * Description: 
 * Classe responsável por gerenciar operações com Banco de Dados.
 * Create: 22/04/2022
 * Update: 22/04/2022
 * 
 * Registros:
 * 22/04/2022 - Criação
 * 
 */


/**
 * Classe pai para as conexões com o banco de dados.
 */
class Bd
{


	/**
	 * ********************************************************************************************
	 * PARÂMETROS DA CLASSE
	 * ********************************************************************************************
	 */


	/**
	 * Conexões do banco de dados.
	 * Guarda um array com os objetos de conexão com o banco de dados.
	 *
	 * @var array|PDO
	 */
	private static $conn;










	/**
	 * * *******************************************************************************************
	 * FUNÇÕES PÚBLICAS DA CLASSE
	 * * *******************************************************************************************
	 */


	/**
	 * Retorna os dados do usuário logado
	 *
	 * @return array
	 */
	public static function infoUser($name = null)
	{
		// Verifica se sessão vem de API ou Módulo.
		if (VC_PATHS['A_ATIVO']) {
			$sessionName = VC_PATHS['A_NAME'];
		} else {
			$sessionName = VC_PATHS['M_NAME'];
		}

		// Monta as informações.
		$infoUser = \classes\Session::getInfoUser($sessionName, $name);

		// Retorna o array com informações do usuário logado.
		return $infoUser;
	}


	/**
	 * Função responsável por gravar os logs da aplicação.
	 *
	 * @param string $obs
	 * @param string $type
	 * @param string $sql
	 * @param integer $conn
	 * @return boolean
	 */
	public static function gravaLog($obs = 'Log Simples', $type = 'ND', $sql = 'ND', $tableName = 'ND', $conn = 0)
	{
		// Verifica se no tipo EXECUTE tem os seguintes tipos para realizar gravação de log.
		$queryType = self::verificaTipo($sql);

		// Caso a execução do select for uma consulta (SELECT), não grava log.
		if ($queryType == 'SELECT') {
			return true;
		}

		// Acrescenta valores padrão.
		$fields = [

			'url'           => VC_INFOURL['url_friendly'],        // Url atual.
			'attr'          => json_encode(VC_INFOURL['attr']),   // Parametros da url atual.
			'post'          => json_encode($_POST),               // POST.
			'get'           => json_encode($_GET),                // GET.
			'controller'    => VC_INFOURL['controller_path'],     // GET.
			'conn'          => $conn,                             // Conexão utilizada.
			'query'         => $sql,                              // Query executada.
			'tableName'     => $tableName,                        // Tabela principal da Query executada.
			'queryType'     => $queryType,                        // Tipo da query.
			'type'          => $type,                             // Tipo da query.
			'obs'           => $obs,                              // Observação aberta.
		];

		// Acrescenta valores default caso não exista.
		$fields = array_merge(self::acrescentaValoresObrigatorios(true), $fields);

		// Realiza a insersão do log gerado.
		self::insert('log', $fields);

		// Gravou log.
		return true;
	}


	/**
	 * Retorna o nome completo da tabela.
	 * Prefixo + Nome da tabela.
	 *
	 * @param  string $tableName
	 * @param  int $conn
	 * @return string
	 */
	public static function fullTableName($tableName, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);
		if (!$db['DB']) {
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $conn . '</b>].');
			return false;
		}

		// Retorna o prefixo da tabela na conexão selecionada.
		return $db['PREFIX_TABLE'] . $tableName;
	}


	/**
	 * Retorna todas as tabelas ou a solicitada.
	 * [$tableName] já acrescenta o prefixo. Basta colocar o nome final da tabela.
	 *
	 * @param string $tableName
	 * @param PDO $conn
	 * @return void
	 */
	public static function getTables($tableName = '', $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Caso passe o nome da tabela, filtra por essa tabela.
		if ($tableName)
			$tableName =  "WHERE Tables_in_" . $db['DBNAME'] . " LIKE '" . $db['PREFIX_TABLE'] . "$tableName'";

		// Monta a Sql com filtro ou sem nada.
		$sql = "SHOW TABLES $tableName";

		// Executa a query e retorna um PDO Object.
		$result = $db['CONN']->query($sql, \PDO::FETCH_ASSOC);

		// Retorna um array associativo dos valores.
		return $result->fetchAll();
	}


	/**
	 * Função genérica para criação de tabelas conforme os parâmetros passados.
	 * Preencha o nome da tabela.
	 * Preencha o array com "nome_campo tipo_campo" (sem chave, apenas valores).
	 *
	 * @param string $tableName
	 * @param array $fields
	 * @param PDO $conn
	 * @return bool
	 */
	public static function createTable($tableName, $fields, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);
		if (!$db['DB']) {
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível obter dados da conexão [<b>' . $conn . '</b>].');
			return false;
		}

		// Constroi SQL.
		$sql = "CREATE TABLE IF NOT EXISTS " . $db['PREFIX_TABLE'] . "$tableName (";
		$sql .= implode(',', $fields);
		$sql .= ") engine=InnoDB default charset " . $db['CHARSET'] . ";";

		// Executa query de criação.
		if (!$db['CONN']->query($sql, \PDO::FETCH_ASSOC)) {
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível criar a tabela. ' . print_r($db['CONN']->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'CREATE TABLE';
		self::gravaLog($obs, $type, $sql, $tableName, $conn);

		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Tabela criada com sucesso. Tabela [<b>' . $tableName . '</b>].');

		return true;
	}


	/**
	 * Função genérica para deletar tabela.
	 *
	 * @param string $tableName
	 * @param int $conn
	 * @return bool
	 */
	public static function deleteTable($tableName, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Constroi sql.
		$sql = "DROP TABLE IF EXISTS " . $db['PREFIX_TABLE'] . "$tableName";

		// Prepara a Query.
		$sth = $db['CONN']->prepare($sql);

		// Executa query de criação.
		if (!$sth->execute()) {
			die("\n\nNão foi possível deletar tabela.\n\n" . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'DROP TABLE';
		self::gravaLog($obs, $type, $sql, $tableName, $conn);

		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Tabela deletada com sucesso. Tabela [<b>' . $tableName . '</b>].');

		// Caso ocorra tudo corretamente.
		return true;
	}










	/**
	 * * *******************************************************************************************
	 * FUNÇÕES PROTEGIDAS DA CLASSE
	 * * *******************************************************************************************
	 * Uso até dentro das heranças.
	 * Não é acessada de fora.
	 */


	/**
	 * Retorna os dados da conexão escolhida e já realiza a conexão.
	 * As informações de conexão estão em config.php
	 *
	 * @param PDO $conn
	 * @return array
	 */
	protected static function getConn($conn = 1)
	{
		// Variável de retonro.
		$db = [
			'CONN'            => $conn,
			'DB'              => false,
		];

		// Verifica se foi passada conexão, se tem dados de conexão e se conexão está ativa.
		if ($conn && isset(VC_DB[$conn]) && VC_DB[$conn]) {

			// Monta array com as informações de conexão.
			$db = [
				'CONN_ID'         => $conn,
				'CONN'            => '',  // Conexão logo abaixo. Fica em self::$conn[$conn] também.
				'DB'              => VC_DB[$conn],
				'API'          => VC_DB[$conn]['API'],
				'DBMANAGER'    => VC_DB[$conn]['DBMANAGER'],
				'HOST'         => VC_DB[$conn]['HOST'],
				'PORT'         => VC_DB[$conn]['PORT'],
				'USER'         => VC_DB[$conn]['USER'],
				'PASSWORD'     => VC_DB[$conn]['PASSWORD'],
				'DBNAME'       => VC_DB[$conn]['DBNAME'],
				'CHARSET'      => VC_DB[$conn]['CHARSET'],
				'PREFIX_TABLE' => VC_DB[$conn]['PREFIX_TABLE'],
			];

			// Caso a conexão não seja por API.
			if (!$db['API']) {
				// Realiza a conexão com o banco de dados.
				if (empty(self::$conn[$conn])) {
					try {
						$pdo_conn = new \PDO($db['DBMANAGER'] . ":host=" . $db['HOST'] . ';port=' . $db['PORT'] . ';dbname=' . $db['DBNAME'] . ';charset=' . $db['CHARSET'], $db['USER'], $db['PASSWORD']);
						$pdo_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
						self::$conn[$conn] = $pdo_conn;
					} catch (\PDOException $error) {
						// echo $error->getMessage();
						\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível conectar com [' . $db['DBMANAGER'] . '].' . $error->getMessage());
					}
				}
				// Guarda a conexão no array.
				$db['CONN'] = self::$conn[$conn];
			}

			$db['PASSWORD'] = ''; // Apaga password da memoria.
		}

		// Retorna os dados de conexão escolhido.
		return $db;
	}


	/**
	 * Fecha as conexões.
	 */
	protected static function close()
	{
		// Verifica se não foi aberta conexões.
		if (!self::$conn) {
			return true;
		}

		// Finaliza todas as conexões criadas.
		foreach (self::$conn as $key => $value) {
			$value->query('KILL CONNECTION_ID()');
		}
	}



	/**
	 * Função genérica para inserts.
	 * Preencha o nome da tabela.
	 * Preencha o array com nome_campo => valor_campo.
	 *
	 * @param string $tableName
	 * @param array $fields
	 * @param int $conn
	 * @return bool
	 */
	protected static function insert($tableName, $fields, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Verifica qual tipo de execução.
		if ($db['API']) {
			// Obtém as chaves (nome dos campos).
			$cols = implode(', ', array_keys($fields));
			// Obtém as chaves como parâmetro (incluido em values), para depois trocar pelos valores.
			$params = implode("', '", array_values($fields));

			// Constrói sql.
			$sql = "INSERT INTO " . $db['PREFIX_TABLE'] . "$tableName ($cols) VALUES('$params')";

			return self::executeAPI($sql, $db);
		} else {

			// INSERT NORMAL

			// Acrescenta valores default caso não exista.
			$fields = array_merge(self::acrescentaValoresObrigatorios(true), $fields);

			// Obtém as chaves (nome dos campos).
			$cols = implode(', ', array_keys($fields));
			// Obtém as chaves como parâmetro (incluido em values), para depois trocar pelos valores.
			$params = implode(', :', array_keys($fields));

			// Constrói sql.
			$sql = "INSERT INTO " . $db['PREFIX_TABLE'] . "$tableName ($cols) VALUES(:$params)";

			// Prepara a Query.
			$sth = $db['CONN']->prepare($sql);

			// Percorre os valores e adiciona ao bind.
			foreach ($fields as $key => $value) {
				// Monta sql com os valores.
				$sql = str_replace(":$key", $value, $sql);
				// Trata os valores para dentro da query preparada.
				$sth->bindValue(":$key", $value);
			}

			// Executa query de criação.
			if (!$sth->execute()) {
				// die("\n\nNão foi possível inserir os dados.\n\n" . print_r($sth->errorInfo(), true));
				\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível inserir o registro. Tabela [<b>' . $tableName . '</b>].' . print_r($sth->errorInfo(), true));
				return false;
			}
			$id = $db['CONN']->lastInsertId();

			// Insere um log caso não seja a própria tabela log.
			if ($tableName != 'log') {

				// LOG Das ações na plataforma.
				$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
				$type = 'INSERT';
				self::gravaLog($obs, $type, $sql, $tableName, $conn);

				// FeedBack
				\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro inserido com sucesso. Tabela [<b>' . $tableName . '</b>].');
			}

			// Caso ocorra tudo corretamente.
			return $id;
		}

		return false;
	}


	/**
	 * Função genérica para update.
	 * Preencha o nome da tabela.
	 * Preencha o array com nome_campo => valor_campo.
	 *
	 * @param string $tableName
	 * @param array $fields
	 * @param int $conn
	 * @return bool
	 */
	protected static function update($tableName, $id, $fields, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Acrescenta valores default caso não exista.
		$fields = array_merge(self::acrescentaValoresObrigatorios(), $fields);

		// Prepara o SET (key, values)
		$set = '';
		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			$set .= ", $key=:$key";
		}
		$set[0] = ' '; // Tira a virgula inicial.

		// Constrói sql.
		$sql = "UPDATE " . $db['PREFIX_TABLE'] . "$tableName SET$set  WHERE id = $id";

		// Prepara a Query.
		$sth = $db['CONN']->prepare($sql);

		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			// Monta sql com os valores.
			$sql = str_replace(":$key", $value, $sql);
			// Trata os valores para dentro da query preparada.
			$sth->bindValue(":$key", $value);
		}

		// Executa query de criação.
		if (!$sth->execute()) {
			// die("\n\nNão foi possível atualizar registro.\n\n" . print_r($sth->errorInfo(), true));
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível atualizar o registro. Tabela [<b>' . $tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'UPDATE';
		self::gravaLog($obs, $type, $sql, $tableName, $conn);

		// FeedBack
		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro [' . $id . '] atualizado com sucesso. Tabela [<b>' . $tableName . '</b>].');

		// Caso ocorra tudo corretamente.
		return true;
	}




	/**
	 * Função que deleta registro por id.
	 *
	 * @param string $tableName
	 * @param int $id
	 * @param int $conn
	 * @return bool
	 */
	protected static function delete($tableName, $id, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Constrói sql.
		$sql = "DELETE FROM " . $db['PREFIX_TABLE'] . "$tableName WHERE id = $id";

		// Verifica se registro não existe (já foi deletado).
		if (!self::selectById($tableName, $id)) {

			// LOG Das ações na plataforma.
			$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '. Registro já deletado';
			$type = 'DELETE STATUS';
			self::gravaLog($obs, $type, $sql, $tableName, $conn);

			// FeedBack
			\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro já foi deletado. Tabela [<b>' . $tableName . '</b>].');

			// Registro já deletado.
			return true;
		}

		// Prepara a Query.
		$sth = $db['CONN']->prepare($sql);

		// Executa query de criação.
		if (!$sth->execute()) {
			// die("\n\nNão foi possível deletar os dados.\n\n" . print_r($sth->errorInfo(), true));
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível deletar o registro. Tabela [<b>' . $tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'DELETE';
		self::gravaLog($obs, $type, $sql, $tableName, $conn);

		// FeedBack
		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro deletado com sucesso. Tabela [<b>' . $tableName . '</b>].');

		// Caso ocorra tudo corretamente.
		return true;
	}




	/**
	 * Função que deleta registro por status.
	 * Altera status do registro informado.
	 *
	 * @param string $tableName
	 * @param int $id
	 * @param int $conn
	 * @return bool
	 */
	protected static function deleteStatus($tableName, $id, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Constrói sql.
		$sql = "UPDATE " . $db['PREFIX_TABLE'] . "$tableName SET idStatus = " . VC_CONFIG['statusDeletado'] . " WHERE id = $id";

		// Prepara a Query.
		$sth = $db['CONN']->prepare($sql);

		// Executa query de criação.
		if (!$sth->execute()) {
			// die("\n\nNão foi possível deletar os dados.\n\n" . print_r($sth->errorInfo(), true));
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível deletar o registro. Tabela [<b>' . $tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'DELETE STATUS';
		self::gravaLog($obs, $type, $sql, $tableName, $conn);

		// FeedBack
		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro deletado com sucesso. Tabela [<b>' . $tableName . '</b>].');

		// Caso ocorra tudo corretamente.
		return true;
	}


	/**
	 * Função genérica para selecionar por id.
	 * Retorna um vetor da linha selecionada.
	 *
	 * @param string $tableName
	 * @param int $id
	 * @param int $conn
	 * @return array
	 */
	protected static function selectAll($tableName, $posicao = 0, $qtd = 10, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db, $tableName))
			return false;

		// Limpa variáveis.
		$qtd = self::limpaInject($qtd);
		$posicao = self::limpaInject($posicao);

		// Constrói sql.
		$limit = '';

		// Grava SQL final.
		$sql = '';

		// Tipo de SQL.
		switch ($db['DBMANAGER']) {
			case 'mysql':
				if ($posicao > 0)
					$limit = "LIMIT " . ((int)$posicao - 1) . ", $qtd;";
				// Grava SQL final.
				$sql = "SELECT * FROM " . $db['PREFIX_TABLE'] . "$tableName ORDER BY id DESC $limit";
				break;

			case 'oci':
				// NÃO TEM COMO APLICAR LIMITE (VERSÃO DO ORACLE ATUAL É 11);
				// Grava SQL final. 
				$sql = "SELECT * FROM " . $db['PREFIX_TABLE'] . "$tableName";
				break;
		}

		// Verifica qual tipo de execução.
		if ($db['API']) {
			return self::executeAPI($sql, $db);
		} else {

			// Prepara a Query.
			$sth = $db['CONN']->prepare($sql);

			// Executa query de criação.
			if (!$sth->execute()) {

				// FeedBack
				\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar a query. Tabela [<b>' . $tableName . '</b>].' . print_r($sth->errorInfo(), true));
				return false;
			}

			// LOG Das ações na plataforma.
			$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
			$type = 'SELECT ALL';
			self::gravaLog($obs, $type, $sql, $tableName, $conn);

			// Caso ocorra tudo corretamente.
			return $sth->fetchAll(\PDO::FETCH_ASSOC);
		}
	}



	/**
	 * Função que busca registro por id.
	 * Retorna um array da linha.
	 *
	 * @param string $tableName
	 * @param int $id
	 * @param int $conn
	 * @return array
	 */
	protected static function selectById($tableName, $id, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Constrói sql.
		$sql = "SELECT * FROM " . $db['PREFIX_TABLE'] . "$tableName WHERE id = $id";

		// Prepara a Query.
		$sth = $db['CONN']->prepare($sql);

		// Executa query de criação.
		if (!$sth->execute()) {

			// FeedBack
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar a query. Tabela [<b>' . $tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// Transforma resultado em array.
		$r = $sth->fetchAll(\PDO::FETCH_ASSOC);

		// Caso seja um array e não tenha resultados.
		if (!isset($r[0]))
			return false;

		// LOG Das ações na plataforma.
		$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
		$type = 'SELECT ID';
		self::gravaLog($obs, $type, $sql, $tableName, $conn);

		// Caso ocorra tudo corretamente.
		return $r[0];
	}



	/**
	 * Função genérica para retornar a quantidade de registros da tabela.
	 * Retorna um vetor da linha selecionada.
	 *
	 * @param string $tableName
	 * @param PDO $conn
	 * @return int
	 */
	protected static function count($tableName, $conn = null)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db, $tableName))
			return false;

		// Constrói sql.
		$sql = "SELECT count(*) QTD FROM " . $db['PREFIX_TABLE'] . "$tableName";

		// Verifica qual tipo de execução.
		if ($db['API']) {
			return (self::executeAPI($sql, $db))[0]['QTD'];
		} else {

			// Prepara a Query.
			$sth = $db['CONN']->prepare($sql);

			// Executa query de criação.
			if (!$sth->execute()) {

				// FeedBack
				\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível contar os registros. Tabela [<b>' . $tableName . '</b>].' . print_r($sth->errorInfo(), true));
				return false;
			}

			// LOG Das ações na plataforma.
			$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
			$type = 'SELECT QTD';
			self::gravaLog($obs, $type, $sql, $tableName, $conn);

			// Caso ocorra tudo corretamente.
			return $sth->fetchAll(\PDO::FETCH_ASSOC)[0]['QTD'];
		}
	}


	/**
	 * Função genérica para executar funções em tabelas mysql.
	 *
	 * @param string $query
	 * @param int $conn
	 * @return array
	 */
	protected static function executeQuery($query, $conn = 1)
	{

		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Constroi sql.
		$sql = $query;

		// Verifica qual tipo de execução.
		if ($db['API']) {

			// Chama a execução via API.
			return self::executeAPI($sql, $db);
		} else {

			// Prepara a Query.
			$sth = $db['CONN']->prepare($sql);

			// Executa query de criação.
			if (!$sth->execute()) {

				// FeedBack
				\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar a query. ' . print_r($sth->errorInfo(), true));
				return false;
			}

			// LOG Das ações na plataforma.
			$obs = 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__ . '.';
			$type = 'EXECUTE QUERY';
			self::gravaLog($obs, $type, $sql, 'Personalizado', $conn);

			// Verifica se não é SELECT e cria feedback.
			if (!strpos($sql, "ELECT"))
				\classes\FeedBackMessagens::add('success', 'Sucesso.', 'SQL executado com sucesso.');

			// Grava Retorno
			$r = $sth->fetchAll(\PDO::FETCH_ASSOC);
		}



		// Caso ocorra tudo corretamente.
		if (is_array($r)) {
			return $r;
		}
	}










	/**
	 * * *******************************************************************************************
	 * FUNÇÕES PRIVADAS DA CLASSE (APOIO)
	 * * *******************************************************************************************
	 * Uso somente dentro dessa controller.
	 */


	/**
	 * Verifica em uma string se contém recorrência de palavras (tipos).
	 * Usado para auxiliar a função gravalog().
	 *
	 * @param string $string
	 * @param array $tipos
	 * @return bool
	 */
	private static function verificaTipo($sql)
	{

		// Se sql está vazio, encerra.
		if (empty($sql)) {
			return 'LESS';
		}

		// Tipos de query encontradas no select.
		$tipos = ['UPDATE', 'CREATE', 'DROP', 'INSERT', 'DELETE', 'PROCEDURE', 'SELECT'];

		// Converte para upper case.
		$string = strtoupper($sql);

		// Procura os tipos (palavras chave) na sql.
		foreach ($tipos as $key => $value) {
			// Caso encontre o tipo. finaliza com true.
			if (mb_strpos($string, strtoupper($value)) !== false) {
				return $value;
			}
		}

		// Caso não encontre o tipo retorna false.
		return 'ND';
	}


	/**
	 * Função que preenche os campos obrigatórios com valores default e valores de sessão.
	 *
	 * @param boolean $insert
	 * @return array
	 */
	private static function acrescentaValoresObrigatorios($insert = false)
	{

		// Monta valores de update.
		$fields = [
			'idStatus'      => 1,                      // Observação aberta.
			'idLoginUpdate' => self::infoUser('id'),   // ID usuário. (só que não altera mais).
			'dtUpdate'      => date("Y-m-d H:i:s"),    // Data. (só que não altera mais)
		];

		// Monta valores de insert.
		if ($insert) {
			$fields['obs']           = 'Preenchimento padrão.';  // Observação.
			$fields['idStatus']      = 1;                        // Status 1 [Ativo].
			$fields['idLoginCreate'] = self::infoUser('id');     // ID usuário logado.
			$fields['dtCreate']      = date("Y-m-d H:i:s");      // Data de criação deste log.
		}

		return $fields;
	}




	/**
	 * VERIFICAÇÕES DE PRÉ EXECUÇÃO DE QUERY.
	 */
	// Verifica se conexão está ok.
	private static function verificaTudo($db)
	{
		// Se tem BD
		if (!$db['DB']) {
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Conexão [<b>' . $db['CONN'] . '</b>] não está ativa.');
			return false;
		}

		return true;
	}

	// Limpa variável de SQL injection.
	private static function limpaInject($variavel)
	{
		return preg_replace('/[^[:alnum:]_]/', '', $variavel);
	}














































































	/**
	 * ********************************************************************************************
     // todo OLD - Avaliar e limpar.
	 * ********************************************************************************************
	 */


	/**
	 * Executa o sth com os demais parametros e log.
	 *
	 * @param STH $sth
	 * @param string $sql
	 * @param array $db
	 * @return array|int
	 */
	protected static function executeSth($sth, $sql, $db)
	{
		// Executa query de criação.
		if (!$sth->execute()) {
			// die("\n\nNão foi possível executar query.\n\n" . print_r($conn->errorInfo(), true));
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar a query. ' . print_r($sth->errorInfo(), true));
			return false;
		}
		// LOG Das ações na plataforma.
		self::gravaLog([
			'conn' => $db['CONN_ID'],
			'sql'  => $sql,
			'tipo' => 'EXECUTE',
			'obs'  => 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__,
		]);
		if (!strpos($sql, "ELECT"))
			\classes\FeedBackMessagens::add('success', 'Sucesso.', 'STH executado com sucesso.');
		// Caso ocorra tudo corretamente.
		return $sth->fetchAll(\PDO::FETCH_ASSOC);
	}


	/**
	 * Função que executa QUERYs API OCI.
	 * Função versão v2. (execOCI - deprecated)
	 *
	 * @param string $sql
	 * @return array|bool|string
	 */
	protected static function executeOCI($sql, $prod, $mysql_intranet = false, $bdMySqli = null)
	{

		// Permite fazer crossDomain.
		header('Access-Control-Allow-Origin: *');

		// Qual conexão escolher.
		//		switch ($db['HOST']) {
		//			case '10.0.1.27/ORAPRD':
		//				$prod = true;
		//				break;
		//			case '10.0.1.27/ORATST':
		//				$prod = false;
		//				break;
		//		}


		// Prepara as variáveis para envio.
		$arraypost = [
			'sql' => $sql,
			'token' =>  CONF_GERAL_URL_OCI_TOKEN,
			'prod' => $prod,
			'mySqlIntranet' => $mysql_intranet,
			'bdMysqli' => $bdMySqli,
			// 'conn' => $conn,						// Escolhe a conexão da API.
		];
		$meuPost = http_build_query($arraypost);

		// Monta o CURL (AJAX)
		$ch = curl_init(CONF_GERAL_URL_OCI);
		// Envio POST
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $meuPost);
		// Captura
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, CONF_GERAL_URL_OCI);
		$result = curl_exec($ch);
		curl_close($ch);


		// Caso resultado, de erro.
		if (!$result) {
			return false;
		}

		// resultado em array
		$result = json_decode($result, true);
		// print_r($result);
		// exit;

		// Verifica se ocorreu erro, ou se não retornou nada.
		if (!$result['r']) {
			if (is_array($result['error'])) {
				$error = implode('. ', $result['error']);
			} else
			    if (!is_array($result)) {
				$error = $result['error'];
				\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar consulta. ' . $error);
			}
		}

		// LOG Das ações na plataforma.
		//		self::gravaLog([
		//			'conn' => $prod['CONN_ID'],
		//			'sql'  => $sql,
		//			'tipo' => 'EXECUTE ' . substr($sql, 0, 7),
		//			'obs'  => 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__,
		//		]);

		// Verifica se não é SELECT e cria feedback.
		if (!strpos($sql, "ELECT")) {
			\classes\FeedBackMessagens::add('success', 'Sucesso.', 'SQL OCI executado com sucesso.');
		}

		return $result['r'];
	}

	/**
	 * Função que executa QUERYs API OCI.
	 * Função versão v2. (execOCI - deprecated)
	 *
	 * @param string $sql
	 * @return array|bool|string
	 */
	protected static function executeMysql($sql, $dbName)
	{

		// Permite fazer crossDomain.
		header('Access-Control-Allow-Origin: *');

		// Qual conexão escolher.
		//		switch ($db['HOST']) {
		//			case '10.0.1.27/ORAPRD':
		//				$prod = true;
		//				break;
		//			case '10.0.1.27/ORATST':
		//				$prod = false;
		//				break;
		//		}

		// Prepara as variáveis para envio.
		$arraypost = [
			'sql' => $sql,
			'token' =>  CONF_GERAL_URL_MYSQL_TOKEN,
			'name' => $dbName,						// Escolhe a conexão da API.
		];
		$meuPost = http_build_query($arraypost);

		// Monta o CURL (AJAX)
		$ch = curl_init(CONF_GERAL_URL_OCI);
		// Envio POST
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $meuPost);
		// Captura
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, CONF_GERAL_URL_MYSQL);
		$result = curl_exec($ch);
		curl_close($ch);



		// Caso resultado, de erro.
		if (!$result) {
			return false;
		}

		// resultado em array
		$result = json_decode($result, true);
		//      print_r($result['r']);
		//      exit();

		// Verifica se ocorreu erro, ou se não retornou nada.
		if (!$result['r']) {
			if (is_array($result['error']))
				$error = implode('. ', $result['error']);
			else
				$error = $result['error'];
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível executar consulta. ' . $error);
		}

		// Verifica se não é SELECT e cria feedback.
		if (!strpos($sql, "ELECT"))
			\classes\FeedBackMessagens::add('success', 'Sucesso.', 'SQL OCI executado com sucesso.');

		return $result['r'];
	}


	/**
	 * Função que execute QUERYs em uma ponte.
	 * Função versão v2. (execOCI - deprecated)
	 *
	 * @param string $sql
	 * @return array|bool|string
	 */
	protected static function executeAPI($sql, $db)
	{
		//	    print_r($db);
		$r = false;

		/**
		 * Qual tipo de API será usada.
		 */
		switch ($db['DBMANAGER']) {

			case 'oci':
				# oracle ...
				$r = self::executeOCI($sql, $db);
				break;

			case 'mysql':
				$r = self::executeMysql($sql, $db);
				break;

			case 'postgres':
				# postgres ...
				$r = false;
				break;

			default:
				# default ...
				$r = false;
				break;
		}

		return $r;
	}




	/**
	 * Seleciona ID passando tabela e filtro.
	 *
	 * @param  string $tableName
	 * @param  array $where
	 * @param  int $conn
	 * @return void
	 */
	protected static function selectIdWhereAnd($tableName, $where, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Obtém a conexão selecionada.
		$conn = self::$conn[$conn]; // todo RETIRAR ESSA LINHA: 


		$select_where = '';
		// Percorre os valores e adiciona ao bind.
		foreach ($where as $key => $value) {
			$select_where .= "$key = :$key and ";
		}
		$select_where .= '1';

		// Constrói sql.
		$sql = "SELECT id FROM " . $db['PREFIX_TABLE'] . "$tableName WHERE $select_where";
		$sth = $db['CONN']->prepare($sql);

		// Percorre os valores e adiciona ao bind.
		foreach ($where as $key => $value) {
			$sth->bindValue(":$key", $value);
		}

		// Executa query de criação.
		if (!$sth->execute()) {
			// die("\n\nNão foi possível selecionar com where.\n\n" . print_r($sth->errorInfo(), true));
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível selecionar o registro. Tabela [<b>' . $tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		// self::gravaLog([
		//   'conn' => $db['CONN_ID'],
		//   'sql'  => $sql,
		//   'tipo' => 'SELECT',
		//   'obs'  => 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__,
		// ]);

		// Caso ocorra tudo corretamente.
		return $sth->fetchAll(\PDO::FETCH_ASSOC);
	}



	/**
	 * Função update com WHERE dinâmico.
	 * Preencha o nome da tabela.
	 * Preencha o array com nome_campo => valor_campo.
	 *
	 * @param string $tableName
	 * @param array $fields
	 * @param int $conn
	 * @return bool
	 */
	protected static function updateDinamico($tableName, $id, $fields, $where, $conn = 1)
	{
		// Verifica e obtém os dados de conexão solicitada.
		$conn = (empty($conn)) ? 1 : $conn;
		$db = self::getConn($conn);

		// Verifica se conexão está ok.
		if (!self::verificaTudo($db))
			return false;

		// Obtém a conexão selecionada.
		$conn = self::$conn[$conn]; // todo RETIRAR ESSA LINHA: 

		// Prepara o SET (key, values)
		$set = '';
		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			$set .= ", $key=:$key";
		}
		$set[0] = ' '; // Tia a virgual inicial.

		// Constrói sql.
		$sql = "UPDATE " . $db['PREFIX_TABLE'] . "$tableName SET$set  WHERE $where = $id";
		$sth = $db['CONN']->prepare($sql);

		// echo $sql;
		// exit;

		// Percorre os valores e adiciona ao bind.
		foreach ($fields as $key => $value) {
			$sth->bindValue(":$key", $value);
		}
		// echo $sql;
		//exit();
		// Executa query de criação.
		if (!$sth->execute()) {
			// die("\n\nNão foi possível atualizar registro.\n\n" . print_r($sth->errorInfo(), true));
			\classes\FeedBackMessagens::add('danger', 'Erro.', 'Não foi possível atualizar o registro. Tabela [<b>' . $tableName . '</b>].' . print_r($sth->errorInfo(), true));
			return false;
		}

		// LOG Das ações na plataforma.
		self::gravaLog([
			'conn' => $db['CONN_ID'],
			'sql'  => $sql,
			'tipo' => 'UPDATE',
			'obs'  => 'Classe: ' . get_called_class() . ' Função ' . __FUNCTION__,
		]);


		\classes\FeedBackMessagens::add('success', 'Sucesso.', 'Registro atualizado com sucesso. Tabela [<b>' . $tableName . '</b>].');

		// Caso ocorra tudo corretamente.
		return true;
	}


	/**
	 * todo: Depecated.
	 * Função que execute QUERYs dentro do oracle.
	 *
	 * @param string $sql
	 * @return array|bool|string
	 */
	public static function execOCI($sql, $prod, $mysql_intranet = false, $bdMySqli = null)
	{
		// Permite fazer crossDomain.
		header('Access-Control-Allow-Origin: *');

		// Prepara as variáveis para envio.
		$arraypost = [
			'sql' => $sql,
			'token' =>  CONF_GERAL_URL_OCI_TOKEN,
			'prod' => $prod,
			'mySqlIntranet' => $mysql_intranet,
			'bdMysqli' => $bdMySqli,
		];
		$meuPost = http_build_query($arraypost);

		// Monta o CURL (AJAX)

		$ch = curl_init(CONF_GERAL_URL_OCI);
		// Envio POST
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $meuPost);
		// Captura
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, CONF_GERAL_URL_OCI);
		$result = curl_exec($ch);
		curl_close($ch);
		//        print_r($sql);
		//        print_r($result);
		//        echo "
		//
		//        ";
		// resultado em array
		$result = json_decode($result, true);
		//        print_r($result);
		//
		//        exit();
		return $result['r'];
	}


	/**
	 * Função que execute QUERYs dentro do oracle.
	 *
	 * @param string $sql
	 * @return array|bool|string
	 */
	protected static function execInsertOCI($sql, $prod = true)
	{

		// Prepara as variáveis para envio.
		$arraypost = [
			'sql' => $sql,
			'token' => CONF_GERAL_URL_OCI_TOKEN,
			'prod' => $prod,
		];
		$meuPost = http_build_query($arraypost);

		// Monta o CURL (AJAX)
		$ch = curl_init(CONF_GERAL_URL_OCI);
		// Envio POST
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $meuPost);
		// Captura
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, CONF_GERAL_URL_OCI);
		$result = curl_exec($ch);
		curl_close($ch);

		// resultado em array
		$result = json_decode($result, true);
		//        print_r($result);
		//        exit();
		if (is_array($result)) {
			return true;
		}


		$ch = curl_init(CONF_GERAL_URL_OCI);
		// Envio POST
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $meuPost);
		// Captura
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, CONF_GERAL_URL_OCI);
		$result = curl_exec($ch);
		curl_close($ch);

		// resultado em array
		$result = json_decode($result, true);
		return $result['r'];
	}
}
