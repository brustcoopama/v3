<?php

use Dompdf\Dompdf;

namespace classes;

require ('m/assets/admin/plugins/dompdf/autoload.inc.php');
/**
 * Classe para criação de pdf padrão e personalizado.
 */
class PDF
{

	/**
	 * Função que cria o pdf.
	 *
	 * @param string $cabecalho
	 * @param string $corpo
	 * @param string $rodape
	 * @return void
	 */
	public static function criaPDF($cabecalho, $corpo)
	{
        //Instância a classe
        $domPDF = new Dompdf();

        //Cria o documento com HTML
        $domPDF ->loadHtml('<h1>'.$cabecalho.'</h1><div class="corpo">'.$corpo.'</div><footer>Teste</footer>');

        //Renderiza o HTML
        $domPDF -> render();

        //Exibir a página
        $domPDF -> stream('relatorio_colaborador.pdf',
        array(
            "Attachment" => false, //False desativa o download direto true habilita
        )
        );

	}

    public static function base64($html)
    {

        /**
         * DOM PDF
         */
        // Instancia a classe DOMPDF
        $domPDF = new Dompdf();
        // Carrega um HTML dentro do DOM.
        $domPDF->loadHtml($html);
        // Define tamanho do papel.
        $domPDF->setPaper('A4', 'portrait');
        // Renderiza o Html para PDF.
        $domPDF->render();
        // Retorna o conteúdo do Arquivo.
        $pdf_gen = $domPDF->output();
        // Transforma o Arquivo em base64.
        $pdf = base64_encode($pdf_gen);

        return $pdf;
    }

	/**
	 * Função que cria um rodapé do padrão TI para os relatórios.
	 * @return void
	 */
	public static function rodapePDF(){
	    echo 'Teste';
	}
}
