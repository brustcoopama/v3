<?php

class BdModelo extends \controllers\Bd
{
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'nomeTabela';

    
    /**
     * Conexão padrão do banco de dados.
     *
     * @var int
     */
    private static $conn = 1;


    /**
     * Cria a função add passando as variaveis $fields e $coon como parametros
     *
     * @param array $fields
     * @param PDO $conn
     * @return bool
     */
    public static function Adicionar($fields, $conn = null)
    {
        // Verifica se foi passada conexão ou se usa a coneão padrão da classe.
        $conn = (empty($conn)) ? Self::$conn : $conn;

        // Retorno da função insert préviamente definida. (true, false)
        return Self::insert(Self::$tableName, $fields, $conn);
    }


    /**
     * Cria função getAll passando a posição, a quantidade e a conexão
     *
     * @param integer $posicao
     * @param integer $qtd
     * @param PDO $conn
     * @return bool
     */
    public static function selecionaTudo($posicao = null, $qtd = 10, $conn = null)
    {
        // Verifica se foi passada conexão ou se usa a coneão padrão da classe.
        $conn = (empty($conn)) ? Self::$conn : $conn;

        // Retorno da função selectAll préviamente definida. (true, false)
        return Self::selectAll(Self::$tableName, $posicao, $qtd, $conn);
    }


    /**
     * Cria função getById que busca por id
     * Retorna um array da linha.
     *
     * @param int $id
     * @param PDO $conn
     * @return array
     */
    public static function selecionaPorId($id, $conn = null)
    {
        // Verifica se foi passada conexão ou se usa a coneão padrão da classe.
        $conn = (empty($conn)) ? Self::$conn : $conn;

        // Retorno da função selectById préviamente definida. (array)
        return Self::selectById(Self::$tableName, $id, $conn);
    }


    /**
     * Cria a função delete passando id e iniciando a conexão
     *
     * @param int $id
     * @param PDO $conn
     * @return bool
     */
    public static function deleta($id, $conn = null)
    {
        // Verifica se foi passada conexão ou se usa a coneão padrão da classe.
        $conn = (empty($conn)) ? Self::$conn : $conn;

        // Retorno da função delete préviamente definida. (true, false)
        return Self::delete(Self::$tableName, $id, $conn);
    }


    /**
     * Cria a função que deleta o registro alterando o status para deletado.
     *
     * @param int $id
     * @param PDO $conn
     * @return bool
     */
    public static function deletaStatus($id, $conn = null)
    {
        // Verifica se foi passada conexão ou se usa a coneão padrão da classe.
        $conn = (empty($conn)) ? Self::$conn : $conn;

        // Retorno da função delete préviamente definida. (true, false)
        return Self::deleteStatus(Self::$tableName, $id, $conn);
    }


    /**
     * Cria a função update que faz alterações em campos existentes
     *
     * @param array $fields
     * @param PDO $conn
     * @return bool
     */
    public static function atualiza($id, $fields, $conn = null)
    {
        // Verifica se foi passada conexão ou se usa a coneão padrão da classe.
        $conn = (empty($conn)) ? Self::$conn : $conn;

        // Retorno da função update préviamente definida. (true, false)
        return Self::update(Self::$tableName, $id, $fields, $conn);
    }


    /**
     * Cria a função quantidade que retorna a quantidade de registros na tabela.
     *
     * @param PDO $conn
     * @return int
     */
    public static function quantidade($conn = null)
    {
        // Verifica se foi passada conexão ou se usa a coneão padrão da classe.
        $conn = (empty($conn)) ? Self::$conn : $conn;

        // Retorno da função update préviamente definida. (true, false)
        return Self::count(Self::$tableName, $conn);
    }


    /**
     * Cria a função para executar uma query personalizada.
     *
     * @param PDO $conn
     * @return int
     */
    public static function ExemploSQL($id, $conn = null)
    {
        // Verifica se foi passada conexão ou se usa a coneão padrão da classe.
        $conn = (empty($conn)) ? Self::$conn : $conn;

        // Verifica se tabela existe.
        if (!Self::getTables(Self::$tableName, $conn))
            return false;

        // Ajusta nome tabela.
        $table = Self::fullTableName(Self::$tableName, $conn);
        // $tableInnerMidia = Self::fullTableName('midia');
        // $tableInnerLogin = Self::fullTableName('login');
        // $tableInnerUsers = Self::fullTableName('users');

        // Monta SQL.
        $sql = "SELECT * FROM $table WHERE id = '$id' LIMIT 1;";

        // Executa o select
        $r = Self::executeQuery($sql, $conn);

        // Verifica se teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0];
    }
}
