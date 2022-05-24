<?php

class BdStatus extends \controllers\Bd
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
    private static $tableName = 'status';


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
            "nome               VARCHAR(45) NULL",
            "statusGrupo        VARCHAR(90) NULL",    // Nome de um grupo de status para um determinado campo de outra tabela.
            "idStatusPai        INT NULL",

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


        /**
         * ****************** TABELA *
         * Select: Status
         * Qualquer id que não precisa de mais status além de ativo e inativo.
         */
        self::adicionar(['nome'=>'Ativo', 'obs'=>'Status ativo Geral']); // 1
        self::adicionar(['nome'=>'Inativo', 'obs'=>'Status Inativo Geral']); // 2

        /**
         * ****************** TABELA LOGINS
         * Select: Status
         */
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Login ativo.', 'statusGrupo' => 'login/idStatus']);
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Login inativo', 'statusGrupo' => 'login/idStatus']);

        /**
         * ****************** TABELA LOGINS
         * Select: Grupo
         */
        self::adicionar(['nome' => 'Administradores', 'obs' => 'Grupo de Administradores.', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'Público', 'obs' => 'Grupo público para menus e informações genéricas.', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'Colaborador', 'obs' => 'Grupo geral para colaborador.', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'Ferramentas', 'obs' => 'Novo grupo para abrigar as ferramentas dos colaboradores.', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'TI', 'obs' => 'Grupo de TI.', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'RH', 'obs' => 'Grupo de RH.', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'Marketing', 'obs' => 'Grupo de Marketing.', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'Contabilidade', 'obs' => 'Grupo de Contabilidade.', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'Logística', 'obs' => 'Grupo da logística.', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'Coordenadores', 'obs' => 'Coordenadores de área', 'statusGrupo' => 'login/idGrupo']);
        self::adicionar(['nome' => 'Gerentes', 'obs' => 'Gerentes', 'statusGrupo' => 'login/idGrupo']);

        /**
         * ****************** TABELA LOGINS
         * Select: Status Pontuação
         */
        // Campo: idStatusPontuacao
        self::adicionar(['nome' => 'Bloqueado', 'obs' => 'Pontos bloqueados.', 'statusGrupo' => 'users/statusPontuacao']);
        self::adicionar(['nome' => 'Liberado', 'obs' => 'Pontos liberara.', 'statusGrupo' => 'users/statusPontuacao']);

        /**
         * Tabela: Pages
         */
        // Campo: idStatus
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Status ativa.', 'statusGrupo' => 'pages/idStatus']);
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Status inativa', 'statusGrupo' => 'pages/idStatus']);

        /**
         * Tabela: PagesContent
         */
        // Campo: idStatus
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Status ativa.', 'statusGrupo' => 'pagesContent/idStatus']);
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Status inativa', 'statusGrupo' => 'pagesContent/idStatus']);

        /**
         * Tabela: Options
         */
        // Campo: idStatus
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Status ativa.', 'statusGrupo' => 'options/idStatus']);
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Status inativa', 'statusGrupo' => 'options/idStatus']);

        /**
         * Tabela: Permissões
         */
        // Campo: idStatus
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Status ativa.', 'statusGrupo' => 'permissions/idStatus']);
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Status inativa', 'statusGrupo' => 'permissions/idStatus']);



        /**
         * ****************** TABELA MIDIAS
         * Select: Status
         */
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Status ativo', 'statusGrupo' => 'midias/idStatus']); // 38
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Status Inativo', 'statusGrupo' => 'midias/idStatus']); // 39


        /**
         * ****************** TABELA ADRESSES
         * Select: status
         */
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Status ativo', 'statusGrupo' => 'adresses/idStatus']); // 40
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Status Inativo', 'statusGrupo' => 'adresses/idStatus']); // 41


        /**
         * ****************** TABELA ADRESSES
         * Select: Zona
         */
        self::adicionar(['nome' => 'Urbana', 'obs' => 'Propriedade em zona urbana.', 'statusGrupo' => 'adresses/zona']);
        self::adicionar(['nome' => 'Rual', 'obs' => 'Propriedade em zona rural.', 'statusGrupo' => 'adresses/zona']);


        /**
         * ****************** TABELA ADRESSES
         * Select: Logradouro
         * Ref.: http://suporte.quarta.com.br/LayOuts/eSocial/Tabelas/Tabela_20.htm
         */
        self::adicionar(['nome' => 'R.', 'obs' => 'Rua.', 'statusGrupo' => 'adresses/logradouro']);
        self::adicionar(['nome' => 'AV.', 'obs' => 'Avenida.', 'statusGrupo' => 'adresses/logradouro']);
        self::adicionar(['nome' => 'AL.', 'obs' => 'Alameda.', 'statusGrupo' => 'adresses/logradouro']);
        self::adicionar(['nome' => 'EST.', 'obs' => 'Estrada.', 'statusGrupo' => 'adresses/logradouro']);
        self::adicionar(['nome' => 'ROD.', 'obs' => 'Rodovia.', 'statusGrupo' => 'adresses/logradouro']);
        self::adicionar(['nome' => 'PC.', 'obs' => 'Praça.', 'statusGrupo' => 'adresses/logradouro']);


        /**
         * ****************** TABELA CONTACTS
         * Select: Status
         */
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Contato ativo', 'statusGrupo' => 'contacts/idStatus']);
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Contato Inativo', 'statusGrupo' => 'contacts/idStatus']);
        self::adicionar(['nome' => 'Profissional', 'obs' => 'Profissional. Uso da Coopama.', 'statusGrupo' => 'contacts/idStatus']);
        self::adicionar(['nome' => 'Pessoal', 'obs' => 'Pessoal. Acesso apenas RH.', 'statusGrupo' => 'contacts/idStatus']);
        self::adicionar(['nome' => 'Contato', 'obs' => 'Contato de outra pessoa próxima. Acesso apenas RH.', 'statusGrupo' => 'contacts/idStatus']);

        /**
         * ****************** TABELA CONTACTS
         * Select: Tipo
         */
        self::adicionar(['nome' => 'E-mail', 'obs' => 'E-mail geral.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Telefone', 'obs' => 'Telefone geral.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Telefone Fixo', 'obs' => 'Telefone Fixo', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Telefone Fixo Whatsapp', 'obs' => 'Telefone fixo com whatsapp', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Celular', 'obs' => 'Telefone Celular.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Celular Whatsapp', 'obs' => 'Telefone Celular com whatsapp.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Site', 'obs' => 'Site. Link.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'URL', 'obs' => 'Endereço web geral. Link.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Instagram', 'obs' => 'Link completo. Instagram.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Facebook', 'obs' => 'Link completo. Facebook.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Linkedin', 'obs' => 'Link completo. Linkedin.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Youtube', 'obs' => 'Link completo. Youtube.', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Skype', 'obs' => 'E-mail do Skype', 'statusGrupo' => 'contacts/tipo']);
        self::adicionar(['nome' => 'Outro', 'obs' => 'Outra informação de contato.', 'statusGrupo' => 'contacts/tipo']);


        /**
         * ****************** TABELA DEPARTMENTS
         * Select: Status
         */
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Status ativo', 'statusGrupo' => 'departments/idStatus']);
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Status Inativo', 'statusGrupo' => 'departments/idStatus']);


        /**
         * ****************** TABELA QUALIFICATIONS
         * Select: Status
         */
        self::adicionar(['nome' => 'Ativo', 'obs' => 'Status ativo', 'statusGrupo' => 'qualifications/idStatus']);
        self::adicionar(['nome' => 'Inativo', 'obs' => 'Status Inativo', 'statusGrupo' => 'qualifications/idStatus']);


        /**
         * ****************** TABELA USERS
         * Select: Escolaridade
         */
        self::adicionar(['nome' => 'Educação infantil', 'obs' => 'Educação infantil', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Fundamental', 'obs' => 'Fundamental', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Fundamental Incompleto', 'obs' => 'Fundamental Incompleto', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Médio', 'obs' => 'Médio', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Médio Incompleto', 'obs' => 'Médio Incompleto', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Técnico', 'obs' => 'Técnico', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Técnico Incompleto', 'obs' => 'Técnico Incompleto', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Superior (Graduação)', 'obs' => 'Superior (Graduação)', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Superior (Licenciatura)', 'obs' => 'Superior (Licenciatura)', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Superior Incompleto', 'obs' => 'Superior Incompleto', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Pós-graduação', 'obs' => 'Pós-graduação', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Pós-graduação Incompleto', 'obs' => 'Pós-graduação Incompleto', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Mestrado', 'obs' => 'Mestrado', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Mestrado Incompleto', 'obs' => 'Mestrado Incompleto', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Doutorado', 'obs' => 'Doutorado', 'statusGrupo' => 'users/escolaridade']);
        self::adicionar(['nome' => 'Doutorado Incompleto', 'obs' => 'Doutorado Incompleto', 'statusGrupo' => 'users/escolaridade']);

        // Categoria CNH
        self::adicionar(['nome' => 'ACC', 'obs' => 'Veículos ciclomotores de duas ou três rodas de até 50 cilindradas.', 'statusGrupo' => 'users/cnhCategoria']);
        self::adicionar(['nome' => 'A', 'obs' => 'Motos', 'statusGrupo' => 'users/cnhCategoria']);
        self::adicionar(['nome' => 'B', 'obs' => 'Carros e veículos de carga leve (até 3.500 kg ou 8 lugares para passageiros).', 'statusGrupo' => 'users/cnhCategoria']);
        self::adicionar(['nome' => 'C', 'obs' => 'Caminhões pequenos e outros veículos de carga entre 3.500 e 6000 kgs de peso total).', 'statusGrupo' => 'users/cnhCategoria']);
        self::adicionar(['nome' => 'D', 'obs' => 'Ônibus e microônibus com mais de 8 lugares para passageiros.', 'statusGrupo' => 'users/cnhCategoria']);
        self::adicionar(['nome' => 'E', 'obs' => 'Todos os veículos das categorias B,C e D, além de veículos com reboque.', 'statusGrupo' => 'users/cnhCategoria']);
        self::adicionar(['nome' => 'AB', 'obs' => 'Motos e Carros', 'statusGrupo' => 'users/cnhCategoria']);


        // Campo: tipoContrato
        self::adicionar(['nome' => 'CLT', 'obs' => 'Contratação sob as leis trabalhistas.', 'statusGrupo' => 'users/tipoContrato']);
        self::adicionar(['nome' => 'PJ', 'obs' => 'Contratação como pessoa jurídica.', 'statusGrupo' => 'users/tipoContrato']);
        self::adicionar(['nome' => 'Temporário', 'obs' => 'Contratação temporária para volume extra ou transição.', 'statusGrupo' => 'users/tipoContrato']);
        self::adicionar(['nome' => 'Parcial', 'obs' => 'Contratação até 25 horas semanais.', 'statusGrupo' => 'users/tipoContrato']);
        self::adicionar(['nome' => 'Estágio', 'obs' => 'Contratação com vínculo acadêmico.', 'statusGrupo' => 'users/tipoContrato']);
        self::adicionar(['nome' => 'Jovem Aprendiz', 'obs' => 'Contratação de 4 a 6 horas por dia.', 'statusGrupo' => 'users/tipoContrato']);
        self::adicionar(['nome' => 'Terceirização', 'obs' => 'Contratação onde empresa terceira realiza toda a responsabilidade.', 'statusGrupo' => 'users/tipoContrato']);
        self::adicionar(['nome' => 'Home office', 'obs' => 'Contratação onde as regras são firmadas em acordo individual entre colaborador e empresa.', 'statusGrupo' => 'users/tipoContrato']);
        self::adicionar(['nome' => 'Intermitente', 'obs' => 'Contratação onde os trabalhadores recebem por jornada ou hora de serviço.', 'statusGrupo' => 'users/tipoContrato']);
        self::adicionar(['nome' => 'Autônomo', 'obs' => 'Contratação onde trabalhador também pode ser considerado um freelancer, mas é contratado como pessoa física e não jurídica.', 'statusGrupo' => 'users/tipoContrato']);


        /**
         * Tabela: messages
         */
        // Campo: finalidade
        self::adicionar(['nome' => 'Geral', 'obs' => 'Finalidade Geral', 'statusGrupo' => 'messages/finalidade']);


        /**
         * Tabela: notifications
         */
        // Campo: destination
        self::adicionar(['nome' => 'Departamento', 'obs' => 'Notificação para um departamento.', 'statusGrupo' => 'notifications/destination']);
        self::adicionar(['nome' => 'Usuário', 'obs' => 'Notificação para um usuário específico.', 'statusGrupo' => 'notifications/destination']);


        /**
         * Tabela: Mídias
         * Acrescentando valores.
         */
        // Campo: idStatus
        // Registro: 342
        self::adicionar(['nome' => 'Material de Marketing disponível', 'obs' => 'Material de marketing e publicidade distribuido para colaboradores usarem. Objetivo de padronizar e usar a marca.', 'statusGrupo' => 'midias/idStatus']);
        // Registro: 343
        self::adicionar(['nome' => 'Material de Marketing indisponível', 'obs' => 'Material de marketing indisponível.', 'statusGrupo' => 'midias/idStatus']);




        /**
         * OUTROS
         */
        // Registro: 345
        self::adicionar(['nome' => 'POP disponível', 'obs' => 'Documento disponível.', 'statusGrupo' => 'midias/idStatus']);
        // Registro: 346
        self::adicionar(['nome' => 'POP indisponível', 'obs' => 'Documento indisponível.', 'statusGrupo' => 'midias/idStatus']);
        // Registro: 348
        self::adicionar(['nome' => 'Principal', 'obs' => 'Endereço principal.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 349
        self::adicionar(['nome' => 'Correspondência', 'obs' => 'Endereço para recebimento de correspondências.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 350
        self::adicionar(['nome' => 'Cobrança', 'obs' => 'Endereço para realização de cobrança.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 351
        self::adicionar(['nome' => 'Secundário', 'obs' => 'Endereço de familiar, vizinho, empresa, etc.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 352
        self::adicionar(['nome' => 'Outro', 'obs' => 'Endereço com especificação no campo OBS.', 'statusGrupo' => 'adresses/idTipo']);
        // Registro: 353
        self::adicionar(['nome' => 'Solteiro', 'obs' => 'Estado Civil Solteiro.', 'statusGrupo' => 'users/estadoCivil']);
        // Registro: 354
        self::adicionar(['nome' => 'Casado', 'obs' => 'Estado Civil Casado.', 'statusGrupo' => 'users/estadoCivil']);
        // Registro: 355
        self::adicionar(['nome' => 'Divorciado', 'obs' => 'Estado Civil Divorciado.', 'statusGrupo' => 'users/estadoCivil']);
        // Registro: 356
        self::adicionar(['nome' => 'Viúvo', 'obs' => 'Estado Civil Viúvo.', 'statusGrupo' => 'users/estadoCivil']);

        // CNH
        self::adicionar(['nome' => 'AC', 'obs' => 'Motos e Carros.', 'statusGrupo' => 'users/cnhCategoria']);
        self::adicionar(['nome' => 'AD', 'obs' => 'Motos e Caminhões.', 'statusGrupo' => 'users/cnhCategoria']);
        self::adicionar(['nome' => 'AE', 'obs' => 'Motos e Todos os veículos.', 'statusGrupo' => 'users/cnhCategoria']);

        // Status Geral Excluido
        // Registro: 360
        self::adicionar(['nome' => 'Deletado', 'obs' => 'Registro está excluido digitalmente.', 'statusGrupo' => '']);


        // Adress campo país
        self::adicionar(['nome' => 'Afeganistão', 'obs' => 'Afeganistão - Cabul - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'África do Sul', 'obs' => 'África do Sul - Pretória - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Albânia', 'obs' => 'Albânia - Tirana - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Alemanha', 'obs' => 'Alemanha - Berlim - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Andorra', 'obs' => 'Andorra - Andorra-a-Velha - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Angola', 'obs' => 'Angola - Luanda - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Antiga e Barbuda', 'obs' => 'Antiga e Barbuda - São João - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Arábia Saudita', 'obs' => 'Arábia Saudita - Riade - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Argélia', 'obs' => 'Argélia - Argel - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Argentina', 'obs' => 'Argentina - Buenos Aires - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Arménia', 'obs' => 'Arménia - Erevã - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Austrália', 'obs' => 'Austrália - Camberra - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Áustria', 'obs' => 'Áustria - Viena - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Azerbaijão', 'obs' => 'Azerbaijão - Bacu - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Bahamas', 'obs' => 'Bahamas - Nassau - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Bangladexe', 'obs' => 'Bangladexe - Daca - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Barbados', 'obs' => 'Barbados - Bridgetown - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Barém', 'obs' => 'Barém - Manama - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Bélgica', 'obs' => 'Bélgica - Bruxelas - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Belize', 'obs' => 'Belize - Belmopã - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Benim', 'obs' => 'Benim - Porto Novo - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Bielorrússia', 'obs' => 'Bielorrússia - Minsque - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Bolívia', 'obs' => 'Bolívia - Sucre - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Bósnia e Herzegovina', 'obs' => 'Bósnia e Herzegovina - Saraievo - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Botsuana', 'obs' => 'Botsuana - Gaborone - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Brasil', 'obs' => 'Brasil - Brasília - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Brunei', 'obs' => 'Brunei - Bandar Seri Begauã - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Bulgária', 'obs' => 'Bulgária - Sófia - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Burquina Faso', 'obs' => 'Burquina Faso - Uagadugu - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Burúndi', 'obs' => 'Burúndi - Bujumbura - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Butão', 'obs' => 'Butão - Timbu - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Cabo Verde', 'obs' => 'Cabo Verde - Praia - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Camarões', 'obs' => 'Camarões - Iaundé - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Camboja', 'obs' => 'Camboja - Pnom Pene - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Canadá', 'obs' => 'Canadá - Otava - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Catar', 'obs' => 'Catar - Doa - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Cazaquistão', 'obs' => 'Cazaquistão - Astana - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Chade', 'obs' => 'Chade - Jamena - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Chile', 'obs' => 'Chile - Santiago - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'China', 'obs' => 'China - Pequim - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Chipre', 'obs' => 'Chipre - Nicósia - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Colômbia', 'obs' => 'Colômbia - Bogotá - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Comores', 'obs' => 'Comores - Moroni - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Congo-Brazzaville', 'obs' => 'Congo-Brazzaville - Brazavile - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Coreia do Norte', 'obs' => 'Coreia do Norte - Pionguiangue - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Coreia do Sul', 'obs' => 'Coreia do Sul - Seul - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Cosovo', 'obs' => 'Cosovo - Pristina - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Costa do Marfim', 'obs' => 'Costa do Marfim - Iamussucro - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Costa Rica', 'obs' => 'Costa Rica - São José - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Croácia', 'obs' => 'Croácia - Zagrebe - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Cuaite', 'obs' => 'Cuaite - Cidade do Cuaite - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Cuba', 'obs' => 'Cuba - Havana - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Dinamarca', 'obs' => 'Dinamarca - Copenhaga - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Dominica', 'obs' => 'Dominica - Roseau - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Egito', 'obs' => 'Egito - Cairo - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Emirados Árabes Unidos', 'obs' => 'Emirados Árabes Unidos - Abu Dabi - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Equador', 'obs' => 'Equador - Quito - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Eritreia', 'obs' => 'Eritreia - Asmara - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Eslováquia', 'obs' => 'Eslováquia - Bratislava - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Eslovénia', 'obs' => 'Eslovénia - Liubliana - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Espanha', 'obs' => 'Espanha - Madrid - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Essuatíni', 'obs' => 'Essuatíni - Lobamba - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Estado da Palestina', 'obs' => 'Estado da Palestina - Jerusalém Oriental - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Estados Unidos', 'obs' => 'Estados Unidos - Washington, D.C. - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Estónia', 'obs' => 'Estónia - Talim - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Etiópia', 'obs' => 'Etiópia - Adis Abeba - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Fiji', 'obs' => 'Fiji - Suva - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Filipinas', 'obs' => 'Filipinas - Manila - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Finlândia', 'obs' => 'Finlândia - Helsínquia - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'França', 'obs' => 'França - Paris - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Gabão', 'obs' => 'Gabão - Libreville - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Gâmbia', 'obs' => 'Gâmbia - Banjul - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Gana', 'obs' => 'Gana - Acra - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Geórgia', 'obs' => 'Geórgia - Tebilíssi - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Granada', 'obs' => 'Granada - São Jorge - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Grécia', 'obs' => 'Grécia - Atenas - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Guatemala', 'obs' => 'Guatemala - Cidade da Guatemala - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Guiana', 'obs' => 'Guiana - Georgetown - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Guiné', 'obs' => 'Guiné - Conacri - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Guiné Equatorial', 'obs' => 'Guiné Equatorial - Malabo - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Guiné-Bissau', 'obs' => 'Guiné-Bissau - Bissau - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Haiti', 'obs' => 'Haiti - Porto Príncipe - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Honduras', 'obs' => 'Honduras - Tegucigalpa - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Hungria', 'obs' => 'Hungria - Budapeste - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Iémen', 'obs' => 'Iémen - Saná - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Ilhas Marechal', 'obs' => 'Ilhas Marechal - Majuro - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Índia', 'obs' => 'Índia - Nova Déli - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Indonésia', 'obs' => 'Indonésia - Jacarta - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Irão', 'obs' => 'Irão - Teerão - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Iraque', 'obs' => 'Iraque - Bagdade - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Irlanda', 'obs' => 'Irlanda - Dublim - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Islândia', 'obs' => 'Islândia - Reiquiavique - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Israel', 'obs' => 'Israel - Jerusalém - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Itália', 'obs' => 'Itália - Roma - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Jamaica', 'obs' => 'Jamaica - Kingston - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Japão', 'obs' => 'Japão - Tóquio - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Jibuti', 'obs' => 'Jibuti - Jibuti - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Jordânia', 'obs' => 'Jordânia - Amã - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Laus', 'obs' => 'Laus - Vienciana - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Lesoto', 'obs' => 'Lesoto - Maseru - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Letónia', 'obs' => 'Letónia - Riga - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Líbano', 'obs' => 'Líbano - Beirute - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Libéria', 'obs' => 'Libéria - Monróvia - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Líbia', 'obs' => 'Líbia - Trípoli - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Listenstaine', 'obs' => 'Listenstaine - Vaduz - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Lituânia', 'obs' => 'Lituânia - Vílnius - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Luxemburgo', 'obs' => 'Luxemburgo - Luxemburgo - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Macedónia do Norte', 'obs' => 'Macedónia do Norte - Escópia - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Madagáscar', 'obs' => 'Madagáscar - Antananarivo - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Malásia', 'obs' => 'Malásia - Cuala Lumpur - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Maláui', 'obs' => 'Maláui - Lilôngue - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Maldivas', 'obs' => 'Maldivas - Malé - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Mali', 'obs' => 'Mali - Bamaco - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Malta', 'obs' => 'Malta - Valeta - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Marrocos', 'obs' => 'Marrocos - Rebate - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Maurícia', 'obs' => 'Maurícia - Porto Luís - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Mauritânia', 'obs' => 'Mauritânia - Nuaquechote - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'México', 'obs' => 'México - Cidade do México - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Mianmar', 'obs' => 'Mianmar - Nepiedó - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Micronésia', 'obs' => 'Micronésia - Paliquir - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Moçambique', 'obs' => 'Moçambique - Maputo - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Moldávia', 'obs' => 'Moldávia - Quixinau - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Mónaco', 'obs' => 'Mónaco - Mónaco - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Mongólia', 'obs' => 'Mongólia - Ulã Bator - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Montenegro', 'obs' => 'Montenegro - Podgoritsa - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Namíbia', 'obs' => 'Namíbia - Vinduque - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Nauru', 'obs' => 'Nauru - Iarém - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Nepal', 'obs' => 'Nepal - Catmandu - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Nicarágua', 'obs' => 'Nicarágua - Manágua - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Níger', 'obs' => 'Níger - Niamei - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Nigéria', 'obs' => 'Nigéria - Abuja - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Noruega', 'obs' => 'Noruega - Oslo - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Nova Zelândia', 'obs' => 'Nova Zelândia - Wellington - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Omã', 'obs' => 'Omã - Mascate - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Países Baixos', 'obs' => 'Países Baixos - Amesterdão - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Palau', 'obs' => 'Palau - Ngerulmud - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Panamá', 'obs' => 'Panamá - Cidade do Panamá - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Papua Nova Guiné', 'obs' => 'Papua Nova Guiné - Porto Moresby - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Paquistão', 'obs' => 'Paquistão - Islamabade - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Paraguai', 'obs' => 'Paraguai - Assunção - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Peru', 'obs' => 'Peru - Lima - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Polónia', 'obs' => 'Polónia - Varsóvia - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Portugal', 'obs' => 'Portugal - Lisboa - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Quénia', 'obs' => 'Quénia - Nairóbi - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Quirguistão', 'obs' => 'Quirguistão - Bisqueque - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Quiribáti', 'obs' => 'Quiribáti - Taraua do Sul - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Reino Unido', 'obs' => 'Reino Unido - Londres - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'República Centro-Africana', 'obs' => 'República Centro-Africana - Bangui - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'República Checa', 'obs' => 'República Checa - Praga - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'República Democrática do Congo', 'obs' => 'República Democrática do Congo - Quinxassa - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'República Dominicana', 'obs' => 'República Dominicana - São Domingos - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Roménia', 'obs' => 'Roménia - Bucareste - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Ruanda', 'obs' => 'Ruanda - Quigali - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Rússia', 'obs' => 'Rússia - Moscovo - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Salomão', 'obs' => 'Salomão - Honiara - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Salvador', 'obs' => 'Salvador - São Salvador - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Samoa', 'obs' => 'Samoa - Apia - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Santa Lúcia', 'obs' => 'Santa Lúcia - Castries - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'São Cristóvão e Neves', 'obs' => 'São Cristóvão e Neves - Basseterre - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'São Marinho', 'obs' => 'São Marinho - São Marinho - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'São Tomé e Príncipe', 'obs' => 'São Tomé e Príncipe - São Tomé - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'São Vicente e Granadinas', 'obs' => 'São Vicente e Granadinas - Kingstown - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Seicheles', 'obs' => 'Seicheles - Vitória - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Senegal', 'obs' => 'Senegal - Dacar - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Serra Leoa', 'obs' => 'Serra Leoa - Freetown - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Sérvia', 'obs' => 'Sérvia - Belgrado - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Singapura', 'obs' => 'Singapura - Singapura - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Síria', 'obs' => 'Síria - Damasco - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Somália', 'obs' => 'Somália - Mogadíscio - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Sri Lanca', 'obs' => 'Sri Lanca - Sri Jaiavardenapura-Cota - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Sudão', 'obs' => 'Sudão - Cartum - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Sudão do Sul', 'obs' => 'Sudão do Sul - Juba - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Suécia', 'obs' => 'Suécia - Estocolmo - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Suíça', 'obs' => 'Suíça - Berna - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Suriname', 'obs' => 'Suriname - Paramaribo - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Tailândia', 'obs' => 'Tailândia - Banguecoque - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Taiuã', 'obs' => 'Taiuã - Taipé - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Tajiquistão', 'obs' => 'Tajiquistão - Duchambé - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Tanzânia', 'obs' => 'Tanzânia - Dodoma - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Timor-Leste', 'obs' => 'Timor-Leste - Díli - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Togo', 'obs' => 'Togo - Lomé - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Tonga', 'obs' => 'Tonga - Nucualofa - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Trindade e Tobago', 'obs' => 'Trindade e Tobago - Porto de Espanha - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Tunísia', 'obs' => 'Tunísia - Tunes - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Turcomenistão', 'obs' => 'Turcomenistão - Asgabate - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Turquia', 'obs' => 'Turquia - Ancara - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Tuvalu', 'obs' => 'Tuvalu - Funafuti - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Ucrânia', 'obs' => 'Ucrânia - Quieve - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Uganda', 'obs' => 'Uganda - Campala - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Uruguai', 'obs' => 'Uruguai - Montevideu - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Usbequistão', 'obs' => 'Usbequistão - Tasquente - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Vanuatu', 'obs' => 'Vanuatu - Porto Vila - Oceania', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Vaticano', 'obs' => 'Vaticano - Vaticano - Europa', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Venezuela', 'obs' => 'Venezuela - Caracas - América', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Vietname', 'obs' => 'Vietname - Hanói - Ásia', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Zâmbia', 'obs' => 'Zâmbia - Lusaca - África', 'statusGrupo' => 'adresses/pais']);
        self::adicionar(['nome' => 'Zimbábue', 'obs' => 'Zimbábue - Harare - África', 'statusGrupo' => 'adresses/pais']);


        // Adress campo uf
        self::adicionar(['nome' => 'AC', 'obs' => 'Estado: Acre. Capital: Rio Branco. Km2: 152581', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'AL', 'obs' => 'Estado: Alagoas. Capital: Maceió. Km2: 27767', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'AP', 'obs' => 'Estado: Amapá. Capital: Macapá. Km2: 142814', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'AM', 'obs' => 'Estado: Amazonas. Capital: Manaus. Km2: 1570745', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'BA', 'obs' => 'Estado: Bahia. Capital: Salvador. Km2: 564692', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'CE', 'obs' => 'Estado: Ceará. Capital: Fortaleza. Km2: 148825', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'DF', 'obs' => 'Estado: Distrito Federal. Capital: Brasília. Km2: 5822', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'ES', 'obs' => 'Estado: Espírito Santo. Capital: Vitória. Km2: 46077', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'GO', 'obs' => 'Estado: Goiás. Capital: Goiânia. Km2: 340086', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'MA', 'obs' => 'Estado: Maranhão. Capital: São Luís. Km2: 331983', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'MT', 'obs' => 'Estado: Mato Grosso. Capital: Cuiabá. Km2: 903357', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'MS', 'obs' => 'Estado: Mato Grosso do Sul. Capital: Campo Grande. Km2: 357125', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'MG', 'obs' => 'Estado: Minas Gerais. Capital: Belo Horizonte. Km2: 586528', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'PA', 'obs' => 'Estado: Pará. Capital: Belém. Km2: 1247689', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'PB', 'obs' => 'Estado: Paraíba. Capital: João Pessoa. Km2: 56439', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'PR', 'obs' => 'Estado: Paraná. Capital: Curitiba. Km2: 199314', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'PE', 'obs' => 'Estado: Pernambuco. Capital: Recife. Km2: 98311', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'PI', 'obs' => 'Estado: Piauí. Capital: Teresina. Km2: 251529', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'RJ', 'obs' => 'Estado: Rio de Janeiro. Capital: Rio de Janeiro. Km2: 43696', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'RN', 'obs' => 'Estado: Rio Grande do Norte. Capital: Natal. Km2: 52796', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'RS', 'obs' => 'Estado: Rio Grande do Sul. Capital: Porto Alegre. Km2: 281748', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'RO', 'obs' => 'Estado: Rondônia. Capital: Porto Velho. Km2: 237576', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'RR', 'obs' => 'Estado: Roraima. Capital: Boa Vista. Km2: 224299', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'SC', 'obs' => 'Estado: Santa Catarina. Capital: Florianópolis. Km2: 95346', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'SP', 'obs' => 'Estado: São Paulo. Capital: São Paulo. Km2: 248209', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'SE', 'obs' => 'Estado: Sergipe. Capital: Aracaju. Km2: 21910', 'statusGrupo' => 'adresses/uf']);
        self::adicionar(['nome' => 'TO', 'obs' => 'Estado: Tocantins. Capital: Palmas. Km2: 277620', 'statusGrupo' => 'adresses/uf']);


        // Finaliza a função.
        return $r;
    }
}
