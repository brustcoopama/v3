#########################################################################
            Pendências da plataforma V3
#########################################################################


Realizar testes em uma subpasta.
Verificar configurações de paths.

Realizar testes com todas as configurações da controller de página e anotar o comportamento.
    Verificar se o comportamento é o esperado ou se tem como melhorar.

Verificar as configurações de segurança.
    Revisar as funções.

Verificar as configurações de banco de dados.
    Anotar o comportamento e verificar se é o esperado.

Verificar onde incluir sistema de cache.
    cache de página inteira.
    cache de objeto.

Testar as funções de carregamento na c_p.php
    Principalmente a função: carregaControllers();

Criar a documentação em:
https://apiary.io/plans

A documentação irá ajudar a não esquecer os recursos e a manter as melhores práticas.
















#########################################################################
            Configuração e utilização da plataforma V3
#########################################################################
A plataforma V3 visa facilitar a implementação de sites robustos e totalmente personalizados tanto manualmente como por interface gráfica (GUI) dentro de um painel administrativo.



ÍNDICE
    - Integridade
    - Configuração



#########################################################################
                            INTEGRIDADE
#########################################################################
Para verificar a integridade da plataforma é necessário identificar os seguintes itens na raiz:
    Pasta
        - c/                (Contém todos os arquivos para execução da plataforma.)
        - vendor/           (Contém as instalações personalizadas do utilizador.)
    Arquivos
        - .htaccess         (Configuração de leitura da plataforma.)
        - composer.json     (Guarda as informações e dependências de pacotes do projeto.)
        - config.php        (Guarda as configurações iniciais no projeto.)
        - index.php         (Arquivo de inicialização da plataforma.)
        - readme.txt        (Arquivo para informações de configuração e utilização da plataforma.)

Caso todos os arquivos listados acima estejam visíveis, o site já está disponível para uso.



#########################################################################
                            CONFIGURAÇÃO
#########################################################################
Para desenvolver o layout é necessário entrar na url /admin