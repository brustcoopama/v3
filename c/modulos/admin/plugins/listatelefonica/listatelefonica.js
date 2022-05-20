// Acrescenta html na barra de ferramentas.
$('#nav-tools').prepend('{{conteudo|raw}}');


/**
 * FUNÇÃO QUE ABRE E FECHA FERRAMENTA.
 */
function opemListaTelefonica(){
    estado = $('#dropdownListaTelefonica').css('display');
    if (estado == "block") 
        $('#dropdownListaTelefonica').css('display', 'none');
    else
        $('#dropdownListaTelefonica').css('display', 'block');
}



/**
 * FUNÇÃO QUE CARREGA A PESQUISA FEITA.
 */
// Função que chama função ao apertar tecla "Enter".
function carregaListaContatos(params) {
    // Verifica se apertou a tecla "Enter".
    if(window.event.keyCode=="13"){
        // Exemplo de uso da ajaxDados(url, dados, callback);
        // Neste exemplo o script faz uma consulta na api da página enviando os "dados" e escreve o retorno no console.log.
        dados = new FormData();
        dados.append("f-formToken", "{{formTokenApi}}"); // Token para uso de API
        dados.append("pesquisa", $("#pesquisaListaTelefonica").val()); // Exemplo de inclusão de valores.
        ajaxDadosListaContatos("{{URL_RAIZ}}admin/controle/usuarios/api/get/listacontatos", dados, function(ret){
            // Para testes
            // console.log(ret);

            // Verifica se teve retorno ok.
            if (ret.ret) {

                // Monta contatos pesquisados.
                $('#listaDeContatos').html(ret.ret);

            }else{
                // Notificação.
                Swal.fire({
                    icon: "info",
                    title: "Informação.",
                    text: ret.msg,
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    // timer: 3000,
                    // timerProgressBar: true,
                });
            }
        })
    }
}

// Função Ajax com CallBack.
// Função tem o objetivo de enviar dados POST para uma URL e realizar uma função CALLBACK com o retorno.
// Função tem a estrutura completa para poder usar em outras aplicações.
function ajaxDadosListaContatos(url,data, callback){
    // var dados = false;

    $.ajax({
    type: "POST",
    url: url,
    // async: false,
    myCallback: callback,
    data: data,
    processData: false,
    contentType: false,
    beforeSend: function(data) {
        // Preparação antes do envio.
    },
    success: function(data) {
        // Envio com sucesso.
        // console.log(data);
        // dados = data;
        this.myCallback(data);
    },
    error: function(data){
        // Prepara valores e passa para o callback chamar o erro.
        ret = {ret:"",msg:"Erro na chamada AJAX."};
        this.myCallback(ret);
    },
    complete: function(data) {
        // Ao finalizar toda a execução.
    },
    }).done(function (data) {
        // Para concluir o processo.
    });

    // return dados;
}