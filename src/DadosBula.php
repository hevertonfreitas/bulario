<?php
/**
 * Bulário: https://github.com/hevertonfreitas/bulario
 * Copyright (c) Heverton Coneglian de Freitas <hevertonconeglian@gmail.com>.
 *
 * Distribuído sob a licença MIT
 * Para informações completas de copyright e distribuição, veja LICENSE.txt
 * Redistribuições de arquivos devem conter a nota de copyright acima.
 *
 * @copyright     Heverton Coneglian de Freitas <hevertonconeglian@gmail.com>
 *
 * @link          https://github.com/hevertonfreitas/bulario
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Hevertonfreitas\Bulario;

use League\Uri\Schemes\Http;

/**
 * Classe que define o id da transação e do anexo de uma bula.
 *
 * @author Heverton Coneglian de Freitas <hevertonconeglian@gmail.com>
 */
class DadosBula
{
    /**
     * ID da transação da bula.
     *
     * @var string
     */
    private $transacao;

    /**
     * ID do anexo da bula.
     *
     * @var string
     */
    private $anexo;

    /**
     * URL para acessar o PDF da bula.
     *
     * @var \League\Uri\Schemes\Http
     */
    private $url;

    /**
     * Retorna o ID da transação da bula.
     *
     * @return string
     */
    public function getTransacao()
    {
        return $this->transacao;
    }

    /**
     * Retorna o ID do anexo da bula.
     *
     * @return string
     */
    public function getAnexo()
    {
        return $this->anexo;
    }

    /**
     * Retorna a URL para o PDF da bula.
     *
     * @return \League\Uri\Schemes\Http
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Constrói os dados da bula.
     *
     * @param string $transacao
     * @param string $anexo
     */
    public function __construct($transacao, $anexo)
    {
        $this->transacao = $transacao;
        $this->anexo = $anexo;

        $uri = Http::createFromComponents([
            'scheme' => 'http',
            'host' => 'www.anvisa.gov.br',
            'path' => '/datavisa/fila_bula/frmVisualizarBula.asp',
            'query' => http_build_query([
                'pNuTransacao' => $this->transacao,
                'pIdAnexo' => $this->anexo,
            ]),
        ]);

        $this->url = $uri;
    }
}
