<?php
/**
 * Bulário: https://github.com/hevertonfreitas/bulario
 * Copyright (c) Heverton Coneglian de Freitas <hevertonfreitas1@yahoo.com.br>.
 *
 * Distribuído sob a licença MIT
 * Para informações completas de copyright e distribuição, veja LICENSE.txt
 * Redistribuições de arquivos devem conter a nota de copyright acima.
 *
 * @copyright     Heverton Coneglian de Freitas <hevertonfreitas1@yahoo.com.br>
 *
 * @link          https://github.com/hevertonfreitas/bulario
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Hevertonfreitas\Bulario;

use Collections\ArrayList;
use Doctrine\Common\Cache\FilesystemCache;
use Goutte\Client;

/**
 * Classe para auxiliar na busca de informações sobre bulas no Brasil,
 * extraindo dados diretamente do site da ANVISA.
 *
 * @link http://www.anvisa.gov.br/datavisa/fila_bula/frmResultado.asp
 *
 * @author Heverton Coneglian de Freitas <hevertonfreitas1@yahoo.com.br>
 */
class Bulario
{
    /**
     * Retira caracteres desnecessários da função JS fVisualizarBula do sistema
     * da Anvisa e retorna um array com o número da transação e anexo da bula.
     *
     * @param string $jsFunc Função JS no formato <code>fVisualizarBula('xxx', 'xxx')</code>
     *
     * @return array Array com as informações da transacao e anexo da bula
     */
    private static function stripJsFunction($jsFunc)
    {
        $explode = explode(',', $jsFunc);
        $strTransacao = trim(rtrim(str_replace('fVisualizarBula(\'', '', $explode[0]), '\''));
        $strAnexo = trim(rtrim(str_replace('\'', '', $explode[1]), ')'));
        $result = [
            'transacao' => $strTransacao,
            'anexo' => $strAnexo,
        ];

        return $result;
    }

    /**
     * Obtém a lista de medicamentos do sistema da Anvisa e retorna um array
     * com os resultados.
     *
     * @param string $medicamento Nome de medicamento
     * @param string $empresa     Nome da fabricante do medicamento
     * @param string $expediente  Número do expediente da bula
     *
     * @throws \Exception Caso não for possível trazer os resultados
     *
     * @return \Collections\ArrayList Todas as bulas encontradas
     */
    public static function buscarMedicamentos($medicamento = '', $empresa = '', $expediente = '')
    {
        if (empty($medicamento) && empty($empresa) && empty($expediente)) {
            throw new \InvalidArgumentException('Informe pelo menos um parâmetro para o método!');
        }
        $Client = new Client();

        $crawler = $Client->request('POST', 'http://www.anvisa.gov.br/datavisa/fila_bula/frmResultado.asp', [
            'hddLetra' => '',
            'txtMedicamento' => $medicamento,
            'txtEmpresa' => $empresa,
            'txtNuExpediente' => $expediente,
            'txtDataPublicacaoI' => '',
            'txtDataPublicacaoF' => '',
            'txtPageSize' => '1000',
            'btnPesquisar' => '',
        ]);

        $Medicamentos = new ArrayList();

        try {
            $trs = $crawler->filter('#tblResultado > tbody > tr');
            if ($trs->first()->filter('td')->count() > 1) {
                $trs->each(function ($node) use (&$Medicamentos) {
                    if (trim($node->filter('td')->eq(0)->text()) != 'Nenhuma bula na fila de análise') {
                        $nomeMedicamento = trim($node->filter('td')->eq(0)->text());
                        $nomeEmpresa = trim($node->filter('td')->eq(1)->text());
                        $exp = trim($node->filter('td')->eq(2)->text());
                        $dataPub = trim($node->filter('td')->eq(3)->text());
                        $dadosBulaPaciente = self::stripJsFunction($node->filter('td')->eq(4)->filter('a')->attr('onclick'));
                        $dadosBulaProfissional = self::stripJsFunction($node->filter('td')->eq(5)->filter('a')->attr('onclick'));

                        $Bula = new Bula();

                        $Bula->setMedicamento($nomeMedicamento);
                        $Bula->setEmpresa($nomeEmpresa);
                        $Bula->setExpediente($exp);
                        $Bula->setDataPublicacao($dataPub);
                        $Bula->setBulaPaciente(new DadosBula($dadosBulaPaciente['transacao'], $dadosBulaPaciente['anexo']));
                        $Bula->setBulaProfissional(new DadosBula($dadosBulaProfissional['transacao'], $dadosBulaProfissional['anexo']));

                        $Medicamentos->add($Bula);
                    }
                });
            }
        } catch (\Exception $ex) {
            throw new Exception('Houve um erro ao obter os medicamentos do sistema da Anvisa!');
        }

        return $Medicamentos;
    }

    /**
     * Retorna a lista de todos os medicamentos cadastrados na Anvisa.
     *
     * @return array
     */
    public static function listarMedicamentos()
    {
        $cacheDriver = new FilesystemCache(sys_get_temp_dir());
        $cacheDriver->setNamespace('hevertonfreitas_bulario_');

        $result = $cacheDriver->fetch('lista_medicamentos');

        if (empty($result)) {
            $listaMedicamentos = file_get_contents('http://www.anvisa.gov.br/datavisa/fila_bula/funcoes/ajax.asp?opcao=getsuggestion&ptipo=1');

            $result = json_decode(utf8_encode($listaMedicamentos));

            $cacheDriver->save('lista_medicamentos', $result);
        }

        return $result;
    }

    /**
     * Retorna a lista de todos as empresas cadastradas na Anvisa.
     *
     * @return array
     */
    public static function listarEmpresas()
    {
        $cacheDriver = new FilesystemCache(sys_get_temp_dir());
        $cacheDriver->setNamespace('hevertonfreitas_bulario_');

        $result = $cacheDriver->fetch('lista_empresas');

        if (empty($result)) {
            $listaEmpresas = file_get_contents('http://www.anvisa.gov.br/datavisa/fila_bula/funcoes/ajax.asp?opcao=getsuggestion&ptipo=2');

            $result = json_decode(utf8_encode($listaEmpresas));

            $cacheDriver->save('lista_empresas', $result);
        }

        return $result;
    }
}
