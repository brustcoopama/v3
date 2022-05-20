// Shared Worker AGRA

let browserInstancesAGRA = [];
let messageAGRA = '';
let timeAGRA = new Date().getTime();
let countAGRA = 0;
let connAGRA = false;
let urlRaiz = '';



// Atribui função para onconnect.
onconnect = function(e){

    // Pega a instancia local aberta.
    const port = e.ports[0];

    // Guarda as instancias abertas.
    browserInstancesAGRA.push(port);

    // Define a função onmessage.
    port.onmessage = function(e) {

        // enviarAGRA('2');

        // if (!SharedWorker) {
        //     countAGRA++;
        // }
        
        switch (e.data.type) {
            case 'connect':
                // conn = conectaSocket(e.msg, e.jwt, e.matricula);
                messageAGRA = e.data.msg;
                
                // Conexão
                if (!connAGRA) {
                    
                    countAGRA = 1;
                    urlRaiz = messageAGRA.content;

                    messageAGRA.quem = 'tu';
                    messageAGRA.nome = "AGRA";
                    content = 'Oi! Estou a disposição!';
                    messageAGRA.content = btoa(content);
                    connAGRA = true;
                    
                    // Envia a mensagem.
                    enviarAGRA(messageAGRA);


                    messageAGRA.quem = 'tu';
                    messageAGRA.nome = "AGRA";
                    content = 'Sou sua assistente, e executo ações que vc me solicitar. Criamos novas ações tbm.';
                    messageAGRA.content = btoa(content);
                    connAGRA = true;
                    // Envia a mensagem.
                    enviarAGRA(messageAGRA);

                }
                
                break;
            case 'desconnect':
                messageAGRA = 'desconnect';
                break;
            case 'message':
                msgJson = JSON.stringify(e.data.msg);
                messageAGRA = e.data.msg;
                // Envia a mensagem (eu).
                enviarAGRA(messageAGRA);

                // Envia mensagem (tu)
                dados = {'content' : atob(messageAGRA.content)};
                // ajaxAGRA('https://colaborador-v2.local/api/agra/colaborador', dados, function(ret){
                ajaxAGRA(urlRaiz + 'api/agra/colaborador', dados, function(ret){

                    // Verifica se teve retorno ok.
                    if (ret) {
                        // Prepara mensagem.
                        messageAGRA.content = btoa(JSON.parse(ret).content);
                    }else{
                        // Prepara mensagem.
                        content = 'Esta mensagem esta fora de contexto. Foi adicionada em nossa base de dados para análise. Caso precise da resposta entre em contato conosco no <a href="tel:3532950171" target="_BLANK">35 3295 0171</a>.';
                        messageAGRA.content = btoa(content);
                    }

                    messageAGRA.quem = 'tu';
                    messageAGRA.nome = "AGRA";

                    // Envia uma mensagem de retorno.
                    if (!JSON.parse(ret).enviar) {
                        enviarAGRA(messageAGRA);
                    }
                    // enviarAGRA(JSON.parse(ret).content);
                }, 'POST');

                function ajaxAGRA(url, data, callback, type) {
                    var data_array, data_string, idx, req, value;
                    if (data == null) {
                        data = {};
                    }
                    if (callback == null) {
                        callback = function() {};
                    }
                    if (type == null) {
                        //default to a GET request
                        type = 'GET';
                    }
                    data_array = [];
                    for (idx in data) {
                        value = data[idx];
                        data_array.push("" + idx + "=" + value);
                    }
                    data_string = data_array.join("&");
                    req = new XMLHttpRequest();
                    req.open(type, url, false);
                    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    // req.setRequestHeader("Content-type", "application/json");
                    req.onreadystatechange = function() {
                        if (req.readyState === 4 && req.status === 200) {
                            callback(req.responseText);
                        }else{

                            // Prepara mensagem.
                            content = 'Não foi possível conectar com servidor da AGRA. Verifique sua conexão ou realize o acesso novamente na plataforma. Caso precise da resposta entre em contato conosco no <a href="tel:3532950171" target="_BLANK">35 3295 0171</a>.';
                            messageAGRA.content = btoa(content);
                            messageAGRA.quem = 'tu';
                            messageAGRA.nome = "AGRA";
                            // Envia a mensagem.
                            enviarAGRA(messageAGRA);
                        }
                    };
                    req.send(data_string);
                    // return req;

                };

                break;
            default:
                messageAGRA = 'default';
                break;
        }
    }
}

// Função que envia mensagem da AGRA para usuário.
function enviarAGRA(messageAGRA) {
    browserInstancesAGRA.map(instanceAGRA => {
        instanceAGRA.postMessage(messageAGRA);
    })
}



// // Função Ajax com CallBack.
// // Função tem o objetivo de enviar dados POST para uma URL e realizar uma função CALLBACK com o retorno.
// // Função tem a estrutura completa para poder usar em outras aplicações.
// function ajaxDadosAGRA(url,data, callback){
//     // var dados = false;

//     $.ajax({
//         type: 'POST',
//         url: url,
//         // async: false,
//         myCallback: callback,
//         data: data,
//         processData: false,
//         contentType: false,
//         success: function(data) {
//             this.myCallback(data);
//         },
//         error: function(data){
//             console.log('Erro chamada');
//         }
//     });

//     // return dados;
// }