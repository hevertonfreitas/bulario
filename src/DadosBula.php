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
     * @var string
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
     * @return string
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

        $this->url = "http://www.anvisa.gov.br/datavisa/fila_bula/frmVisualizarBula.asp?pNuTransacao={$this->transacao}&pIdAnexo={$this->anexo}";
    }
}
