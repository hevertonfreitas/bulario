<?php

namespace Hevertonfreitas\Bulario;

use Goutte\Client;

class Bulario
{

    /**
     * Retira caracteres desnecessários da função JS fVisualizarBula do sistema
     * da Anvisa e retorna um array com o número da transação e anexo da bula
     * 
     * @param string $jsFunc Função JS no formato <code>fVisualizarBula('xxx', 'xxx')</code>
     * @return array Array com as informações da transacao e anexo da bula
     */
    private static function stripJsFunction($jsFunc)
    {
        $explode = explode(',', $jsFunc);
        $strTransacao = trim(rtrim(str_replace('fVisualizarBula(\'', '', $explode[0]), '\''));
        $strAnexo = trim(rtrim(str_replace('\'', '', $explode[1]), ')'));
        return array(
            'transacao' => $strTransacao,
            'anexo' => $strAnexo
        );
    }

    /**
     * Obtém a lista de medicamentos do sistema da Anvisa e retorna um array
     * com os resultados
     * 
     * @param string $medicamento Nome de medicamento
     * @param string $empresa Nome da fabricante do medicamento
     * @param string $expediente Número do expediente da bula
     * @return array Todas as bulas encontradas
     * @link http://www.anvisa.gov.br/datavisa/fila_bula/frmResultado.asp
     * @throws Exception Caso não for possível trazer os resultados
     */
    public static function buscarMedicamentos($medicamento, $empresa = '', $expediente = '')
    {

        $client = new Client();

        $crawler = $client->request('POST', 'http://www.anvisa.gov.br/datavisa/fila_bula/frmResultado.asp', array(
            'hddLetra' => '',
            'txtMedicamento' => $medicamento,
            'txtEmpresa' => $empresa,
            'txtNuExpediente' => $expediente,
            'txtDataPublicacaoI' => '',
            'txtDataPublicacaoF' => '',
            'txtPageSize' => '1000',
            'btnPesquisar' => '',
        ));

        $medicamentos = array();

        try {
            $crawler->filter('#tblResultado > tbody > tr')->each(function ($node) use (&$medicamentos) {
                $nomeMedicamento = trim($node->filter('td')->eq(0)->text());
                $nomeEmpresa = trim($node->filter('td')->eq(1)->text());
                $exp = trim($node->filter('td')->eq(2)->text());
                $dataPub = trim($node->filter('td')->eq(3)->text());
                $dadosBulaPaciente = self::stripJsFunction($node->filter('td')->eq(4)->filter('a')->attr('onclick'));
                $dadosBulaProfissional = self::stripJsFunction($node->filter('td')->eq(5)->filter('a')->attr('onclick'));

                $medicamentos[] = array(
                    'medicamento' => $nomeMedicamento,
                    'empresa' => $nomeEmpresa,
                    'expediente' => $exp,
                    'data_publicacao' => $dataPub,
                    'dados_bula_paciente' => $dadosBulaPaciente,
                    'link_bula_paciente' => "http://www.anvisa.gov.br/datavisa/fila_bula/frmVisualizarBula.asp?pNuTransacao={$dadosBulaPaciente['transacao']}&pIdAnexo={$dadosBulaPaciente['anexo']}",
                    'dados_bula_profissional' => $dadosBulaProfissional,
                    'link_bula_profissional' => "http://www.anvisa.gov.br/datavisa/fila_bula/frmVisualizarBula.asp?pNuTransacao={$dadosBulaProfissional['transacao']}&pIdAnexo={$dadosBulaProfissional['anexo']}"
                );
            });
        } catch (Exception $ex) {
            throw new Exception('Houve um erro ao obter os medicamentos do sistema da Anvisa!');
        }

        return $medicamentos;
    }
}
