<?php

namespace bds;
 
/**
 * TESTE
 */
class BdTeste extends \controllers\Bd
{
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'teste';

    
    /**
     * Conexão padrão do banco de dados.
     *
     * @var int
     */
    private static $conn = 1;


    public static function start()
    {
        // echo '<h3>BD 00-modelo Teste</h3>';
        // print_r(self::$conn);
        print_r(self::quantidade());
        // print_r(self::getConn());
        // print_r(\classes\FeedBackMessagens::get());
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
}