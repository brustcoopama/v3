
// Acrescenta html no final da página. (Janela chat)
$('body').append('{{conteudo|raw}}');

// Acrescenta html na barra de ferramentas. (Mensagens)
$('#nav-tools').prepend('{{chattools|raw}}');




// ****************************************************************************************
// SHARED WORK - SOCKET - DESV
// ****************************************************************************************
urlSW = '{{URL_RAIZ}}m/assets/public/js/shared-worker.js';
const worker = new SharedWorker(urlSW);
console.log(urlSW);
console.log(worker);

// Função de troca de mensagens.
worker.port.onmessage = function(e) {
    console.log(e.data);
}

content = {'type': 'connect', 'msg':'opa', 'jwt':'{{jwt|e}}', 'matricula': '{{userInfo.matricula}}', 'url':'{{CONF_GERAL_SOCKET}}'};
// content = {'type': 'message', 'msg':''};

// Envio de mensagens.
worker.port.postMessage(content);









// Conexão servidor;
// var conn = conectaSocket();




/*
    ABRE CONEXÃO COM SERVIDOR.
*/
function conectaSocket() {
    
    // Url de conexão.
    var url = 'c';
    // console.log(url);

    // Conexão
    conn = new WebSocket(url);
    // console.log(conn);

    // Inicia conexão.
    conn.onopen = function(e) {
        // console.log('Conexão estabelecia.');
        console.log('Socket conectado.');
        // console.log(e);
        // conn.send('Opa!');

        // Formaliza o acesso.
        // Monta o pacote mensagem.
        msg = {
            'jwt':'{{jwt|e}}',
            'type':'1', // [1] Servidor, [2] Mensagem, [3] Notificação
            'content':btoa('ok'),
            'matricula':'{{userInfo.matricula}}',
        }
        msgJson = JSON.stringify(msg);

        // Envia a mensagem para servidor.
        conn.send(msgJson);


        // Mostra que está conectado na ferramenta Contatos.
        $('#statusSocket').removeClass('desconectado');
        $('#statusSocket').addClass('conectado');

        // Mostra que está conectado na foto de perfil.
        $('.meusdados > div > div > div').removeClass('borderDesonectado');
        $('.meusdados > div > div > div').addClass('borderConectado');

        // Foco no input de mensagem.
        $('#mensagem').focus();
    }

    // Lê as mensagens do servidor.
    conn.onmessage = function(e) {
        // console.log(e.data);
        msg = JSON.parse(e.data);
        // console.log(msg);
        // console.log(msg.type);

        switch (msg.type) {
            case 1: // SERVIDOR
                escreverMensagem(msg, 'tu');
                break;
            case '2': // MENSAGEM
                escreverMensagem(msg, 'tu');
                break;
            case '3': // NOTIFICAÇÃO
                escreverMensagem(msg, 'tu');
                notificaBrowser({title: 'CHAT - ' + msg.nome, body: msg.content, icon: "{{userInfo.urlFoto}}"});
                break;
            case '4': // WHATSAPP
                escreverMensagem(msg, 'tu');
                // Implementar envio de mensagem whatsapp.
                break;
            default:
                break;
        }
    };

    // Retorna conexão.
    return conn;
}



/*
    FUNÇÃO QUE CANCELA EXECUÇÃO DO CHAT (SOCKET)
*/
function closeServerSocket() {
    // Monta o pacote mensagem.
    msg = {
        'jwt':'{{jwt|e}}',
        'type':'1',
        'content':btoa('sair123'),
        'matricula':'coopama'
    }
    msgJson = JSON.stringify(msg);

    // Envia a mensagem para servidor.
    conn.send(msgJson);

    // Mostra que está conectado na ferramenta Contatos.
    $('#statusSocket').removeClass('conectado');
    $('#statusSocket').addClass('desconectado');

    // Mostra que está conectado na foto de perfil.
    $('.meusdados > div > div > div').removeClass('borderConectado');
    $('.meusdados > div > div > div').addClass('borderDesonectado');
}



/*
    FUNÇÕES DE ENVIAR MENSAGEM DO CHAT ABERTO
*/
// Envia mensagem apertando "Enter".
$('#mensagem').keypress(function(e) {
    if (e.which == 13) {
        enviarMensagem();
    }
});

// Envia mensagem clicando no botão "Enviar".
$('#btn_chat_enviar').click(function() {
    enviarMensagem();
});

// Envia notificação clicando no botão "Sino".
$('#btn_whatsapp_enviar').click(function() {
    // Grava mensagem.
    content = $('#mensagem').val();

    // Verifica se existe mensagem.
    if(!content){
        return false;
    }

    // Monta o pacote mensagem.
    msg = {
        'jwt':'{{jwt|e}}',
        'type':'4', // [4] whatsapp.
        'content':btoa(content),
        'matricula':'coopama',
    }
    msgJson = JSON.stringify(msg);

    // Escreve a mensagem no chat local (HTML).
    escreverMensagem(msg, 'eu');

    // Envia a mensagem para servidor.
    conn.send(msgJson);
});


/*
    FUNÇÃO DE ENVIAR NOTIFICAÇÃO DO CHAT ABERTO
*/
// Envia notificação clicando no botão "Sino".
$('#btn_notification_enviar').click(function() {
    // Grava mensagem.
    content = $('#mensagem').val();

    // Verifica se existe mensagem.
    if(!content){
        return false;
    }

    // Monta o pacote mensagem.
    msg = {
        'jwt':'{{jwt|e}}',
        'type':'3', // [1] Servidor, [2] Mensagem, [3] Notificação
        'content':btoa(content),
        'matricula':'coopama',
    }
    msgJson = JSON.stringify(msg);

    // Escreve a mensagem no chat local (HTML).
    escreverMensagem(msg, 'eu');

    // Envia a mensagem para servidor.
    conn.send(msgJson);
});



/*
    FUNÇÃO DE ENVIAR MENSAGEM PARA DESTINATÁRIO
*/
// Função que envia a mensagem (type: 2).
function enviarMensagem() {
    // Grava mensagem.
    content = $('#mensagem').val();

    // Verifica se existe mensagem.
    if(!content){
        return false;
    }

    // Monta o pacote mensagem.
    msg = {
        'jwt':'{{jwt|e}}',
        'type':'2', // [1] Servidor, [2] Mensagem, [3] Notificação
        'content':btoa(content),
        'matricula':'coopama',
    }
    msgJson = JSON.stringify(msg);

    worker.port.postMessage({'type': 'message', 'msg':msg});

    // Escreve a mensagem no chat local (HTML).
    escreverMensagem(msg, 'eu');

    // Envia a mensagem para servidor.
    conn.send(msgJson);
}

/*
    FUNÇÃO QUE DESENHA A MENSAGEM NO CHAT
*/
// Função que escreve um texto na parte de mensagens (HTML).
function escreverMensagem(msg, quem = 'eu') {

    //TESTE
    // console.log(msg);

    // Prepara variáveis da mensagem.
    // Data atual
    var data = new Date();

    // Verifica o nome de quem está enviando.
    if(quem == 'eu')
        msg.nome = '{{firstName}}';

    // Caso receba uma notificação coloca um sino no nome.
    icon = '';
    if (msg.type == 3) {
        icon = '<i class="far fa-bell"></i> ';
    }else if(msg.type == 4) {
        icon = '<i class="fab fa-whatsapp"></i> ';
    }

    // Traduz conteúdo da mensagem recebida (UTF8).
    msg.content = atob(msg.content);

    // Monta o balão da conversa (DIV).
    tmp_msg = '<div class="msg-chat msg-' + quem + '"><div><nome>' + icon + msg.nome + '</nome>' + msg.content + '<span>' + data.getHours() + ':' + data.getMinutes() + '</span></div></div>';

    // Pega box das mensagens da conversa atual.
    chat = $('#chatuser_' + msg.matricula);
    
    // Verifica se box existe, se não já cria.
    if (chat[0]) {
        // Acrescenta
        $(chat).append(tmp_msg);
    }else
    {
        // Cria um box com a mensagem recebida.
        $('#mensagens').append('<div id="chatuser_'+ msg.matricula +'" class="box_chatuser">'+ tmp_msg +'</div>');
    }    
    
    // Roda para o fim.
    // var div = $('#mensagens')[0];
    var div = $(chat);
    div.scrollTop = div.scrollHeight;

    // Limpa caixa de mensagem.
    $('#mensagem').val('');
    // Foco no input de mensagem.
    $('#mensagem').focus();
}

$('#chat-collapse').on('Click', function () {

    // Input recebe o foco para digitar mensagem.
    $(document).ready(function(){
        $('#mensagem').focus()[0];
    });

})


// Abre o chat com a conversa da pessoa selecionada na ferramenta Contatos.
function openChat(e) {
    // Input recebe o foco para digitar mensagem.
    $(document).ready(function(){
        $('#mensagem').focus()[0];
    });

    $('.chatBox').show();
    $('.chatBox').removeClass('collapsed-card');
    $('.chatBox .card-body').show();
}

// minimiza o chat quando acessa alguma ferramenta.
$('.nav-item.dropdown > a.nav-link').on('click', function () {
    $('.chatBox').addClass('collapsed-card');
    $('.chatBox .card-body').hide();
});







// ****************************************************************************************
// TESTE
// ****************************************************************************************
// function ajaxDados(url,data, callback){
//     // var dados = false;

//     $.ajax({
//     type: 'POST',
//     url: url,
//     // async: false,
//     myCallback: callback,
//     data: data,
//     processData: false,
//     contentType: false,
//     beforeSend: function(data) {
//         // Preparação antes do envio.
//     },
//     success: function(data) {
//         // Envio com sucesso.
//         // console.log(data);
//         // dados = data;
//         this.myCallback(data);
//     },
//     error: function(data){
//         // Erro ao realizar a chamada.
//         console.log('Erro.');
//     },
//     complete: function(data) {
//         // Ao finalizar toda a execução.
//     },
//     }).done(function (data) {
//         // Para concluir o processo.
//     });

//     // return dados;
// }

// dados = new FormData();

// Exemplo
// ajaxDados('{{global.URL_RAIZ}}admin/controle/options/', dados, function(ret){
//     if (ret) {
//         console.log(ret);
//     }
// })


