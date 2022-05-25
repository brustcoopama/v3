<?php

class BdLogins extends \controllers\Bd
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
    private static $tableName = 'logins';


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
            "id               INT NOT NULL AUTO_INCREMENT primary key",

            // Identificadores.
            "matricula        INT NULL",
            "idUser           INT NULL",                // Id do usuário. Tabela com informações detalhadas da entidade.
            "idOld            INT NULL",                // Id identificador de tabela antiga.

            // Chaves externas  
            "idMenu           INT NULL",                // Menu personalizado.

            // Informações básicas
            "fullName         VARCHAR(160) NULL",       // Nome Completo.
            "firstName        VARCHAR(40) NULL",        // Primeiro nome.
            "lastName         VARCHAR(40) NULL",        // Último nome.

            // Login - Pode ser usado para realizar o login.
            "userName         VARCHAR(32) NULL",        // User para logar.
            "email            VARCHAR(160) NULL",       // E-mail principal da coopama.
            "telefone         VARCHAR(11) NULL",        // Telefone (numero only).
            "cpf              VARCHAR(11) NULL",        // CPF.
            "cnpj             VARCHAR(11) NULL",        // CNPJ.

            // Senha
            "senha            VARCHAR(64) NOT NULL",    // criptografia hash('sha256', $senha).
            "expirationDays   INT(11) NULL",
            "strongPass       BOOLEAN NULL",
            "dateChangePass   DATETIME NULL",

            // Controle
            "initialUrl       VARCHAR(255) NOT NULL",   // Redireciona para esta URL após logado. (Personalização)
            "menu             MEDIUMTEXT NOT NULL",     // Menu Personalizado serialize.

            // Observações do registro (obrigatório).
            "obs                VARCHAR(255) NULL",

            // Controle padrão do registro (obrigatório).
            "idStatus           INT NULL",          // Status grupo: "login/idStatus" ou [1] Ativo, [2] Inativo.
            "idLoginCreate      INT NULL",          // Login que realizou a criação.
            "dtCreate           DATETIME NULL",     // Data em que registro foi criado.
            "idLoginUpdate      INT NULL",          // Login que realizou a edição.
            "dtUpdate           DATETIME NULL",     // Data em que registro foi alterado.

        ];
        return self::createTable(self::$tableName, $fields, self::$conn);
    }


    /**
     * Deleta tabela no banco de dados.
     *
     * @return bool
     */
    public static function tableDelete()
    {
        // Deleta a tabela.
        self::deleteTable(self::$tableName, self::$conn);
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
        return self::insert(self::$tableName, $fields, self::$conn);
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
        return self::update(self::$tableName, $id, $fields, self::$conn);
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
        return self::delete(self::$tableName, $id, self::$conn);
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
        return self::deleteStatus(self::$tableName, $id, self::$conn);
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
        return self::selectAll(self::$tableName, $posicao, $qtd, self::$conn);
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
        return self::selectById(self::$tableName, $id, self::$conn);
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
        return self::count(self::$tableName, self::$conn);
    }


    /**
     * Modelo para criação de uma query personalizada.
     * É possível fazer inner joins e filtros personalizados.
     * ATENÇÃO: Não deixar brechas para SQL Injection.
     *
     * @param PDO $conn
     * @return int
     */
    public static function verificaLogin($login, $senha)
    {
        // Obtém dados de conexão.
        $db = self::getConn(self::$conn);
        if (!$db['DB']) {
            return false;
        }

        // Obtém select padrão.
        $sql = self::fullSelect();

        // Acrescenta where no SQL.
        $sql .= "
        WHERE (
            email = :email OR
            userName = :userName OR
            matricula = :matricula
            ) AND
            (senha = :senha)
            AND
            idStatus != 2
        LIMIT 1;
        ";

        $sth = $db['CONN']->prepare($sql);

        $login = \classes\TratamentoDados::limpaInject($login);

        // Substitui os valores. (segurança de sql injection)
        $sth->bindValue(":email", $login);
        $sth->bindValue(":userName", $login);
        $sth->bindValue(":matricula", $login);
        $sth->bindValue(":senha", $senha);

        // Retorna
        $r = self::executeSth($sth, $sql, $db, self::$conn);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0];
    }


    /**
     * Modelo para criação de uma query personalizada.
     * É possível fazer inner joins e filtros personalizados.
     * ATENÇÃO: Não deixar brechas para SQL Injection.
     *
     * @param PDO $conn
     * @return array
     */
    public static function queryPersonalizada($id)
    {
        // Ajusta nome real da tabela.
        $table = self::fullTableName(self::$tableName, self::$conn);
        // $tableInnerMidia = self::fullTableName('midia', self::$conn);
        // $tableInnerLogin = self::fullTableName('login', self::$conn);
        // $tableInnerUsers = self::fullTableName('users', self::$conn);

        // Monta SQL.
        $sql = "SELECT * FROM $table WHERE id = '$id' LIMIT 1;";

        // Executa o select
        $r = self::executeQuery($sql, self::$conn);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0];
    }


    /**
     * SQL padrão.
     * Monta select padrão com todos os campos e junções.
     *
     * @return string
     */
    private static function fullSelect()
    {
        // Ajusta nome real da tabela.
        $tableName = self::fullTableName(self::$tableName, self::$conn);

        // Monta select padrão com todos os campos e junções.
        $sql = "
        SELECT
            id,
            matricula,
            idUser,
            idOld,
            idMenu,
            fullName,
            firstName,
            lastName,
            userName,
            email,
            telefone,
            cpf,
            cnpj,
            expirationDays,
            strongPass,
            dateChangePass,
            initialUrl,
            menu,
            obs,
            idStatus,
            idLoginCreate,
            dtCreate,
            idLoginUpdate,
            dtUpdate

        FROM $tableName 

        ";

        return $sql;
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
            'matricula' => '2142',

            'fullName'  => 'Mateus Rocha Brust',
            'firstName' => 'Mateus',
            'lastName'  => 'Brust',

            'userName' => 'brust',
            'email'    => 'mateus.brust@coopama.com.br',
            'telefone' => '31993265491',
            'cpf'      => '10401141640',

            'senha'          => hash('sha256', '123456'),
            'expirationDays' => '360',
            'strongPass'     => false,
            'dateChangePass' => '2023-05-23',

            // Observações do registro (obrigatório).
            'obs'           => 'Insert Automático.',

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
