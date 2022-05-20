

// Acrescenta html na barra de ferramentas. (Mensagens)
$('#nav-tools').prepend('{{raspadinhatool|raw}}');



$( document ).ready(function() {
    var scratch = new Scratch({
        canvasId: 'js-scratch-canvas',
        imageBackground: '{{PATH_PLUGIN}}raspadinha/raspadinha_vazio.jpg',
        pictureOver: '{{PATH_PLUGIN}}raspadinha/raspou_ganhou.png',
        cursor: {
            png: '{{PATH_PLUGIN}}raspadinha/raspadinha/piece.png',
            cur: '{{PATH_PLUGIN}}raspadinha/raspadinha/piece.cur',
            x: '17',
            y: '20'
        },
        radius: 26,
        nPoints: 80,
        percent: 30,
        callback: function () {
            // alert('Não teve sorte dessa vez.');
        },
        pointSize: { x: 3, y: 3}
    });
});