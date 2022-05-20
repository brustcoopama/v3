<?php

class BdLog extends \controllers\Bd
{
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'log';


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
        $fields = [
            // Identificador Padrão (obrigatório).
            "id                 INT NOT NULL AUTO_INCREMENT primary key",

            // Informações do registro.
            "url                VARCHAR(256) NULL",     // Url atual.
            "attr               VARCHAR(256) NULL",     // Parametros da url atual.
            "post               VARCHAR(256) NULL",     // POST.
            "get                VARCHAR(256) NULL",     // GET.
            "controller         VARCHAR(64) NULL",      // GET.
            "conn               INT(1) NULL",           // Conexão utilizada.
            "query              VARCHAR(256) NULL",     // Query executada.
            "tableName          VARCHAR(256) NULL",     // Tabela principal da Query executada.
            "queryType          VARCHAR(32) NULL",      // Tipo da query.
            "type               VARCHAR(32) NULL",      // Tipo da query.

            // Observações do registro (obrigatório).
            "obs                VARCHAR(256) NULL",

            // Controle padrão do registro (obrigatório).
            "idStatus           INT NULL",            // Status grupo: "login/idStatus".
            "idLoginCreate      INT NULL",            // Login que realizou a criação
            "dtCreate           DATETIME NULL",       // Data em que registro foi criado.
            "idLoginUpdate      INT NULL",            // Login que realizou a edição
            "dtUpdate           DATETIME NULL",       // Data em que registro foi alterado.

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
        Self::deleteTable(Self::$tableName, Self::$conn);
    }


    // todo PEGAR O CÓDIGO AJUSTADO DO MODELO PLATAFORMA.
}
