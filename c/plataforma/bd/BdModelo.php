<?php

class BdModelo extends \controllers\Bd
{


    /**
     * ********************************************************************************************
     * PARÂMETROS DA CLASSE
     * ********************************************************************************************
     */


    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'modelo';


    /**
     * Conexão padrão do banco de dados.
     * Verificar conexão
     *
     * @var int
     */
    private static $conn = 1;











    /**
     * ********************************************************************************************
     * FUNÇÕES DA CLASSE
     * ********************************************************************************************
     */


    /**
     * Cria tabela no banco de dados.
     * Cria se não existir.
     *
     * @return bool
     */
    public static function tableCreate()
    {
        // Monta os campos da tabela.
        $fields = [
            // Identificador Padrão (obrigatório).
            "id                 INT NOT NULL AUTO_INCREMENT primary key",

            // Informações do registro do tipo numérico.
            "ex_tinyint         TINYINT NULL",      // Campo tipo Inteiro 1 bytes.
            "ex_smallint        SMALLINT NULL",     // Campo tipo Inteiro 2 bytes.
            "ex_mediumint       MEDIUMINT NULL",    // Campo tipo Inteiro 3 bytes.
            "ex_int             INT NULL",          // Campo tipo Inteiro 4 bytes.
            "ex_bigint          BIGINT NULL",       // Campo tipo Inteiro 8 bytes.
            "ex_float           FLOAT(7,2) NULL",   // Campo tipo Flutuante 4 bytes.
            "ex_double          DOUBLE(7,2) NULL",  // Campo tipo Flutuante 8 bytes.

            // Informações do registro do tipo data.
            "ex_date            DATE NULL",         // Campo tipo Data ('0000-00-00').
            "ex_time            TIME NULL",         // Campo tipo Data ('00:00:00').
            "ex_datetime        DATETIME NULL",     // Campo tipo Data e Hora ('0000-00-00 00:00:00').
            "ex_timestamp       TIMESTAMP NULL",    // Campo tipo TimeStamp ('0000-00-00 00:00:00').
            "ex_year            YEAR NULL",         // Campo tipo Ano (0000).

            // Informações do registro do tipo data.
            "ex_varchar         VARCHAR(255) NULL", // Campo tipo Texto.
            "ex_text            TEXT NULL",         // Campo tipo Texto (256 bytes e 2000 parts).
            "ex_mediumtext      MEDIUMTEXT NULL",   // Campo tipo Texto médio (256 bytes e 4000 parts).
            "ex_longtext        LONGTEXT NULL",     // Campo tipo Texto longo (256 bytes e 13948 parts).

            // Observações do registro (obrigatório).
            "obs                VARCHAR(255) NULL",

            // Controle padrão do registro (obrigatório).
            "idStatus           INT NULL",          // Status pelo grupo ou [1] Ativo, [2] Inativo.
            "idLoginCreate      INT NULL",          // Login que realizou a criação.
            "dtCreate           DATETIME NULL",     // Data em que registro foi criado.
            "idLoginUpdate      INT NULL",          // Login que realizou a edição.
            "dtUpdate           DATETIME NULL",     // Data em que registro foi alterado.

        ];
        return Self::createTable(Self::$tableName, $fields, Self::$conn);
    }


    /**
     * Deleta tabela no banco de dados.
     *
     * @return bool
     */
    public static function tableDelete()
    {
        // Deleta a tabela.
        Self::deleteTable(Self::$tableName, Self::$conn);
    }


    /**
     * Inserts iniciais da tabela no banco de dados.
     *
     * @return bool
     */
    public static function tableInserts()
    {
        // Retorno padrão.
        $r = false;

        $r = self::insertsIniciais();

        return $r;
    }


    /**
     * Cria a função adicionar passando um array com os campos e valores.
     * Campos obrigatórios e opcionais.
     *
     * @param array $fields
     * @param PDO $conn
     * @return bool
     */
    public static function adicionar($fields)
    {
        // Retorno da função insert préviamente definida. (true, false)
        return Self::insert(Self::$tableName, $fields, Self::$conn);
    }


    /**
     * Cria a função atualizar que faz alterações em um registro.
     * É passado o id do registro.
     * É passado os campos que vão ser atualizados.
     *
     * @param array $fields
     * @param PDO $conn
     * @return bool
     */
    public static function atualizar($id, $fields)
    {
        // Retorno da função update préviamente definida. (true, false)
        return Self::update(Self::$tableName, $id, $fields, Self::$conn);
    }


    /**
     * Função delete por id de registro.
     * Delete o registro da tabela.
     * ATENÇÃO: Usar o delete por status para não perder o registro.
     *
     * @param int $id
     * @param PDO $conn
     * @return bool
     */
    public static function deletar($id)
    {
        // Retorno da função delete préviamente definida. (true, false)
        return Self::delete(Self::$tableName, $id, Self::$conn);
    }


    /**
     * Função que deleta o registro alterando o status para deletado.
     * Valor padrão para registro deletado: VC_CONFIG['statusDeletado'].
     *
     * @param int $id
     * @param PDO $conn
     * @return bool
     */
    public static function deletarStatus($id)
    {
        // Retorno da função delete préviamente definida. (true, false)
        return Self::deleteStatus(Self::$tableName, $id, Self::$conn);
    }


    /**
     * Função selecionar tudo, retorna todos os registros.
     * É possível passar a posição inicial que exibirá os registros.
     * É possível passar a quantidade de registros retornados.
     *
     * @param integer $posicao
     * @param integer $qtd
     * @param PDO $conn
     * @return bool
     */
    public static function selecionarTudo($posicao = null, $qtd = 10)
    {
        // Retorno da função selectAll préviamente definida. (true, false)
        return Self::selectAll(Self::$tableName, $posicao, $qtd, Self::$conn);
    }


    /**
     * Função seleciona por id. 
     * Busca registro por id.
     * Retorna um array com os campos da linha.
     *
     * @param int $id
     * @param PDO $conn
     * @return array
     */
    public static function selecionarPorId($id)
    {
        // Retorno da função selectById préviamente definida. (array)
        return Self::selectById(Self::$tableName, $id, Self::$conn);
    }


    /**
     * Cria a função quantidade que retorna a quantidade de registros na tabela.
     *
     * @param PDO $conn
     * @return int
     */
    public static function quantidade()
    {
        // Retorno da função update préviamente definida. (true, false)
        return Self::count(Self::$tableName, Self::$conn);
    }


    /**
     * Modelo para criação de uma query personalizada.
     * É possível fazer inner joins e filtros personalizados.
     * ATENÇÃO: Não deixar brechas para SQL Injection.
     *
     * @param PDO $conn
     * @return int
     */
    public static function queryPersonalizada($id)
    {
        // Ajusta nome real da tabela.
        $table = Self::fullTableName(Self::$tableName, Self::$conn);
        // $tableInnerMidia = Self::fullTableName('midia', Self::$conn);
        // $tableInnerLogin = Self::fullTableName('login', Self::$conn);
        // $tableInnerUsers = Self::fullTableName('users', Self::$conn);

        // Monta SQL.
        $sql = "SELECT * FROM $table WHERE id = '$id' LIMIT 1;";

        // Executa o select
        $r = Self::executeQuery($sql, Self::$conn);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0];
    }


    /**
     * Realização de testes.
     * Apenas para testes.
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

        // Finaliza a função.
        return true;
    }











    /**
     * ********************************************************************************************
     * FUNÇÕES DE APOIO DA CLASSE
     * ********************************************************************************************
     */


    /**
     * Realização dos inserts iniciais.
     *
     * @return void
     */
    private static function insertsIniciais()
    {
        // Retorno padrão.
        $r = true;

        // Insert modelo.
        $r = self::adicionar([
            // Informações do registro.
            'campo'         => 'valor',

            // Observações do registro (obrigatório).
			'obs'           => 'Status ativo Geral',

            // Controle padrão do registro (obrigatório).
			'idStatus'      => 1,
			'idLoginCreate' => 1,
			'dtCreate'      => date("Y-m-d H:i:s"),
			'idLoginUpdate' => 1,
			'dtUpdate'      => date("Y-m-d H:i:s"),
		]);


        // Finaliza a função.
        return $r;
    }
}
