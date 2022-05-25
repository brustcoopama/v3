#########################################################################
                PADRÃO DE CRIAÇÃO DO NOME DE PÁGINA WEB
#########################################################################

A criação do nome segue um padrão.
Pode ser feito pelo painel administrativo ou manualmente por aqui.

A criação do nome é feita em 2 partes:
    Nome
    Extensão

-- NOME
Nome: default
Nome que será incluido na URL, podendo ter mais aspectos estéticos.
O nome pode conter espaços e ífens.

    Ex.: "fale conosco".
    Ex.: "fale-conosco".
    Ex.: "faleconosco".
O nome deverá ser minúsculo.

-- EXTENSÃO
Extensão: .html



#########################################################################
                        FORMA DE USO EM PRODUÇÃO
#########################################################################
EXEMPLOS


[1] Uso normal
Com view e controller criados.

    Url acessada:       http://www.seusite.com.br/

    Html:               "c/modulos/site/pages/v/index.html"
    Controller:         "c/modulos/site/pages/c/index.html"



[2] Uso com default
Com view criada e sem controller criado.

    Url acessada:       http://www.seusite.com.br/contato

    Html:               "c/modulos/site/pages/v/contato.html"
    Controller:         X
    Controller Default: "c/modulos/site/pages/c/default.html"



[3] Uso com hierarquia
Com view e controller criados.
Com url amigável ou não.
Dentro de pasta (index) ou não (nome).

    Url acessada:       http://www.seusite.com.br/contato/trabalhe-conosco/
    ou
    Url acessada:       http://www.seusite.com.br/contato/trabalheconosco/
    ou
    Url acessada:       http://www.seusite.com.br/contato/trabalhe conosco/

    Html:               "c/modulos/site/pages/v/contato/trabalheconosco.html"
    Controller:         "c/modulos/site/pages/c/contato/trabalheconosco.html"
    ou
    Html:               "c/modulos/site/pages/v/contato/trabalheconosco/index.html"
    Controller:         "c/modulos/site/pages/c/contato/trabalheconosco/index.html"


