
/**
 * AGRA - Sua Assistente Virtual.
 */
// Acrescenta html na barra de ferramentas.
$('#nav-tools').prepend('{{agratool|raw}}');

// Acrescenta html no final da página. (Janela chat)
$('body').append('{{janelaAgra|raw}}');


// Função da tool AGRA.
function agraClick(){
    if ($('#janelaAgra').is(':visible')) {
        $('#janelaAgra').hide();
    }else
    {
        $('#janelaAgra').show();
    }
}




// ****************************************************************************************
// SHARED WORK - AGRA - www.DESV.com.br
// ****************************************************************************************
const urlRaiz = '{{URL_RAIZ}}';
urlSW = '{{PATH_PLUGIN}}agra/shared-worker.js';
const workerAgra = new SharedWorker(urlSW);
// console.log(urlSW);
// console.log(workerAgra);

// Função de troca de mensagens.
workerAgra.port.onmessage = function(e) {
    // console.log(e.data);
    escreverMensagemAGRA(e.data);
}

// workerAgra.port.postMessage('enviei');

// Mensagem para o servidor worker realizar a conexão com WEBSOCKET (SOCKET mais pra frente.).
content = {
    'type': 'connect', 
    msg: {
        'content':urlRaiz, 
        'jwt':'{{jwt|e}}', 
        'matricula': '{{userInfo.matricula}}', 
        'nome': '{{firstName}}', 
        'type':'2'
    }
};
// content = {'type': 'message', 'msg':''};

// Envio de mensagens.
workerAgra.port.postMessage(content);
// console.log(content);





// ****************************************************************************************
// ENVIAR MENSAGEM PARA AGRA.
// ****************************************************************************************
// Envia mensagem apertando "Enter" no input.
$('#mensagem_Agra').keypress(function(e) {
    if (e.which == 13) {
        enviarMensagemAGRA();
    }
});

// Envia mensagem clicando no botão "Enviar" ao lado do input.
$('#btn_agra_enviar').click(function() {
    enviarMensagemAGRA();
});

// Função que envia a mensagem para AGRA.
function enviarMensagemAGRA() {
    // Grava mensagem.
    content = $('#mensagem_Agra').val();

    // Verifica se existe mensagem.
    if(!content){
        return false;
    }

    // Monta o pacote mensagem.
    msg = {
        'jwt':'{{jwt|e}}',
        'type':'2', // [1] Servidor, [2] Mensagem, [3] Notificação
        'content':btoa(content),
        'matricula':'{{userInfo.matricula}}',
        'quem':'eu',
    }
    msgJson = JSON.stringify(msg);

    msgPostMessage = {'type': 'message', 'msg':msg};
    workerAgra.port.postMessage(msgPostMessage);
    // console.log(msgPostMessage);

    // Escreve a mensagem no chat local (HTML).
    // escreverMensagemAGRA(msg);
}

// Função que escreve um texto na parte de mensagens (HTML).
function escreverMensagemAGRA(msg) {

    //TESTE
    // console.log(msg);

    // Prepara variáveis da mensagem.
    // Data atual
    var data = new Date();

    // Traduz conteúdo da mensagem recebida (UTF8).
    msg.content = atob(msg.content);

    // Verifica o nome de quem está enviando.
    if(msg.quem == 'eu'){   
        msg.nome = '{{firstName}}';
        msg.content = (msg.content).toHtmlEntities();
    }

    // Caso receba uma notificação coloca um sino no nome.
    icon = '';
    if (msg.type == 3) {
        icon = '<i class="far fa-bell"></i> ';
    }else if(msg.type == 4) {
        icon = '<i class="fab fa-whatsapp"></i> ';
    }


    // Monta o balão da conversa (DIV).
    tmp_msg = '<div class="chatAgra msg-' + msg.quem + '"><div><nome>' + icon + msg.nome + '</nome>' + msg.content + '<span>' + data.getHours() + ':' + data.getMinutes() + '</span></div></div>';

    // Pega box das mensagens da conversa atual.
    chat = $('#chatuser_' + msg.matricula);
    // console.log(chat);

    // Verifica se box existe, se não já cria.
    if (chat[0]) {
        // Acrescenta
        $(chat).append(tmp_msg);
    }else
    {
        // Cria um box com a mensagem recebida.
        $('#janelaChatAgra').append('<div id="chatuser_'+ msg.matricula +'" class="box_chatuser">'+ tmp_msg +'</div>');
    }
    
    // Roda para o fim.
    // var div = $('#mensagens')[0];
    // var div = $(chat);
    // div.scrollTop = div.scrollHeight;
    document.getElementById('chatuser_' + msg.matricula).scrollIntoView(false);

    // Limpa caixa de mensagem.
    $('#mensagem_Agra').val('');
    // Foco no input de mensagem.
    $('#mensagem_Agra').focus();
}



// ****************************************************************************************
// AJUSTES DE FACILITAÇÃO NA TELA.
// ****************************************************************************************
// Função que esconde chate ao entrar nas ferramentas.
$('#chat-collapse').on('Click', function () {
    // Input recebe o foco para digitar mensagem.
    $(document).ready(function(){
        $('#mensagem_Agra').focus()[0];
    });
});

/**
 * Convert a string to HTML entities
 */
 String.prototype.toHtmlEntities = function() {
    return this.replace(/./gm, function(s) {
        // return "&#" + s.charCodeAt(0) + ";";
        return (s.match(/[a-z0-9\s]+/i)) ? s : "&#" + s.charCodeAt(0) + ";";
    });
};

/**
 * Create string from HTML entities
 */
 String.fromHtmlEntities = function(string) {
    return (string+"").replace(/&#\d+;/gm,function(s) {
        return String.fromCharCode(s.match(/\d+/gm)[0]);
    })
};
