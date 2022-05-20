/*
 * PADRÃO
 */


// // Exemplo de uso da ajaxDados(url, dados, callback);
// // Neste exemplo o script faz uma consulta na api da página enviando os "dados" e escreve o retorno no console.log.
// dados = new FormData();
// dados.append('f-formToken', '{{page.formTokenApi}}'); // Token para uso de API
// dados.append('f-formToken', '{{page.formToken}}'); // Token para uso na página.
// dados.append('campo', 'valor'); // Exemplo de inclusão de valores.
// ajaxDados('{{global.URL_RAIZ}}admin/controle/PAGINA/api/post/PARAMETRO', dados, function(ret){
//     // Para testes
//     console.log(ret);

//     // Verifica se teve retorno ok.
//     if (ret.ret) {
//         // Notificação.
//         Swal.fire({
//             icon: "success",
//             title: "Sucesso.",
//             text: ret.msg,
//             toast: true,
//             position: "top-end",
//             showConfirmButton: false,
//             timer: 3000,
//             timerProgressBar: true,
//         });
//     }else{
//         // Notificação.
//         Swal.fire({
//             icon: 'error',
//             title: 'Erro.',
//             text: ret.msg,
//             toast: true,
//             position: 'top-end',
//             showConfirmButton: false,
//             // timer: 3000,
//             // timerProgressBar: true,
//         });
//     }
// })



// Função Ajax com CallBack.
// Função tem o objetivo de enviar dados POST para uma URL e realizar uma função CALLBACK com o retorno.
// Função tem a estrutura completa para poder usar em outras aplicações.
function ajaxDados(url,data, callback){
    // var dados = false;

    $.ajax({
    type: 'POST',
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
        ret = {ret:'',msg:'Erro na chamada AJAX.'};
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