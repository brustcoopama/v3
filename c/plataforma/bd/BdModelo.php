<?php

class BdModelo extends \controllers\Bd
{
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
     * Cria tabela
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
            "idStatus           INT NULL",          // Status grupo: "login/idStatus".
            "idLoginCreate      INT NULL",          // Login que realizou a criação
            "dtCreate           DATETIME NULL",     // Data em que registro foi criado.
            "idLoginUpdate      INT NULL",          // Login que realizou a edição
            "dtUpdate           DATETIME NULL",     // Data em que registro foi alterado.

        ];
        return Self::createTable(Self::$tableName, $fields, Self::$conn);
    }


    /**
     * Deleta tabela
     *
     * @return bool
     */
    public static function tableDelete()
    {
        // Deleta a tabela.
        Self::deleteTable(Self::$tableName, Self::$conn);
    }


    /**
     * Cria a função add passando as variaveis $fields e $coon como parametros
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
     * Cria a função update que faz alterações em campos existentes
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
     * Cria a função delete passando id e iniciando a conexão
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
     * Cria a função que deleta o registro alterando o status para deletado.
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
     * Cria função getAll passando a posição, a quantidade e a conexão
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
     * Cria função getById que busca por id
     * Retorna um array da linha.
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
}
