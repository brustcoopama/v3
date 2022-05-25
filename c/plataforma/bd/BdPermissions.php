<?php

class BdPermissions extends \controllers\Bd
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
    private static $tableName = 'permissions';


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

            // Chaves externas  
            "idLogin            INT NULL",          // Id na tabela login.
            "idGrupo            INT NULL",          // Status grupo: "users/idGrupo"
      
            // Informações básicas
            "nome               VARCHAR(32) NULL",  // Título do registro.
            "urlPagina          VARCHAR(128) NULL", // A frente do "/".
            "permissions        VARCHAR(9) NULL",       // [000000000] menu, index, post, put, get, getFull, delete, api, test.

            // Observações do registro (obrigatório).
            "obs                VARCHAR(255) NULL",

            // Controle padrão do registro (obrigatório).
            "idStatus           INT NULL",          // Status grupo: "login/idStatus".
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
        return self::deleteTable(self::$tableName, self::$conn);
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
     * Seleciona permissões pelo id do usuário logado e página.
     *
     * @param PDO $conn
     * @return array
     */
    public static function selecionarPorIdGrupoUrl($idLogin, $idGroup, $urlPage)
    {
        // Ajusta nome real da tabela.
        $table = self::fullTableName(self::$tableName, self::$conn);

        // Monta SQL.
        $sql = "SELECT * FROM $table WHERE (idLogin = $idLogin OR idGrupo IN ($idGroup)) AND urlPagina = '$urlPage'";

        // Executa o select
        $r = self::executeQuery($sql, self::$conn);

        // Verifica se não teve retorno.
        if (!$r)
            return array();

        // Retorna registros.
        return $r;
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

        // Acrescenta permissões iniciais de grupo.
        self::addPermissionsGroup(5, '00-modelo/modelo-bd/');
        self::addPermissionsGroup(5, '00-modelo/modelo-restrito/');
        self::addPermissionsGroup(5, 'api/00-modelo/');

        // Acrescenta permissões iniciais de login.
        self::addPermissionsLogin(1, '00-modelo/modelo-bd/');
        self::addPermissionsLogin(1, '00-modelo/modelo-restrito/');


        // Finaliza a função.
        return $r;
    }

    /**
     * Função que cria permissões para um grupo.
     *
     * @param int $id
     * @param string $urlPage
     * @return bool
     */
    private static function addPermissionsGroup($idGroup, $urlPage, $permissions = '111111111')
    {
        // Administradores
        self::adicionar([ 
            'idGrupo'   => $idGroup,
            'nome'      => 'Acesso Total',
            'urlPagina' => $urlPage,
            'permissions' => (string)$permissions,
            'obs'       => 'Cadastro Inicial.',
        ]);

        return true;
    }

    /**
     * Função que cria permissões para um grupo.
     *
     * @param int $id
     * @param string $urlPage
     * @return bool
     */
    private static function addPermissionsLogin($idLogin, $urlPage, $permissions = '111111111')
    {
        // Administradores
        self::adicionar([ 
            'idLogin'   => $idLogin,
            'nome'      => 'Acesso Total',
            'urlPagina' => $urlPage,
            'permissions' => $permissions,
            'obs'       => 'Cadastro Inicial.',
        ]);

        return true;
    }
}
