<?php
/**
 * Bulário: https://github.com/hevertonfreitas/bulario
 * Copyright (c) Heverton Coneglian de Freitas <hevertonfreitas1@yahoo.com.br>
 *
 * Distribuído sob a licença MIT
 * Para informações completas de copyright e distribuição, veja LICENSE.txt
 * Redistribuições de arquivos devem conter a nota de copyright acima.
 *
 * @copyright     Heverton Coneglian de Freitas <hevertonfreitas1@yahoo.com.br>
 * @link          https://github.com/hevertonfreitas/bulario
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Hevertonfreitas\Bulario;

use Goutte\Client;

/**
 * Classe para auxiliar na busca de informações sobre bulas no Brasil,
 * extraindo dados diretamente do site da ANVISA.
 * @link http://www.anvisa.gov.br/datavisa/fila_bula/frmResultado.asp
 * @author Heverton Coneglian de Freitas <hevertonfreitas1@yahoo.com.br>
 * @package \Hevertonfreitas\Bulario
 */
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
        $result = array(
            'transacao' => $strTransacao,
            'anexo' => $strAnexo
        );
        return $result;
    }

    /**
     * Obtém a lista de medicamentos do sistema da Anvisa e retorna um array
     * com os resultados
     * 
     * @param string $medicamento Nome de medicamento
     * @param string $empresa Nome da fabricante do medicamento
     * @param string $expediente Número do expediente da bula
     * @return array Todas as bulas encontradas
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
            $trs = $crawler->filter('#tblResultado > tbody > tr');
            if ($trs->first()->filter('td')->count() > 1) {
                $trs->each(function ($node) use (&$medicamentos) {
                    if (trim($node->filter('td')->eq(0)->text()) != 'Nenhuma bula na fila de análise') {
                        $nomeMedicamento = trim($node->filter('td')->eq(0)->text());
                        $nomeEmpresa = trim($node->filter('td')->eq(1)->text());
                        $exp = trim($node->filter('td')->eq(2)->text());
                        $dataPub = trim($node->filter('td')->eq(3)->text());
                        $dadosBulaPaciente = self::stripJsFunction($node->filter('td')->eq(4)->filter('a')->attr('onclick'));
                        $dadosBulaProfissional = self::stripJsFunction($node->filter('td')->eq(5)->filter('a')->attr('onclick'));

                        $medicamento = new Bula();

                        $medicamento->setMedicamento($nomeMedicamento);
                        $medicamento->setEmpresa($nomeEmpresa);
                        $medicamento->setExpediente($exp);
                        $medicamento->setDataPublicacao($dataPub);
                        $medicamento->setBulaPaciente(new DadosBula($dadosBulaPaciente['transacao'], $dadosBulaPaciente['anexo']));
                        $medicamento->setBulaProfissional(new DadosBula($dadosBulaProfissional['transacao'], $dadosBulaProfissional['anexo']));
                        $medicamentos[] = $medicamento;
                    }
                });
            }
        } catch (Exception $ex) {
            throw new Exception('Houve um erro ao obter os medicamentos do sistema da Anvisa!');
        }

        return $medicamentos;
    }
}
