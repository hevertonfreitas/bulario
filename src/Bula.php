<?php
/**
 * Bulário: https://bitbucket.org/hevertonfreitas/bulario
 * Copyright (c) Heverton Coneglian de Freitas <hevertonfreitas1@yahoo.com.br>
 *
 * Distribuído sob a licença MIT
 * Para informações completas de copyright e distribuição, veja LICENSE.txt
 * Redistribuições de arquivos devem conter a nota de copyright acima.
 *
 * @copyright     Heverton Coneglian de Freitas <hevertonfreitas1@yahoo.com.br>
 * @link          https://bitbucket.org/hevertonfreitas/bulario
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Hevertonfreitas\Bulario;

use Carbon\Carbon;
use Stringy\Stringy as Str;

/**
 * Classe que define as propriedades de uma bula
 * @author Heverton Coneglian de Freitas <hevertonfreitas1@yahoo.com.br>
 * @package \Hevertonfreitas\Bulario
 */
class Bula implements \JsonSerializable
{

    /**
     * Nome completo do medicamento
     * @var \Stringy\Stringy
     */
    private $medicamento;

    /**
     * Nome completo da empresa fabricante do medicamento
     * @var \Stringy\Stringy
     */
    private $empresa;

    /**
     * Número de identificação da bula
     * @var string
     */
    private $expediente;

    /**
     * Data de publicação da bula
     * @var \Carbon\Carbon 
     */
    private $dataPublicacao;

    /**
     * Dados da bula do paciente
     * @var \Hevertonfreitas\Bulario\DadosBula
     */
    private $bulaPaciente;

    /**
     * Dados da bula do profissional
     * @var \Hevertonfreitas\Bulario\DadosBula
     */
    private $bulaProfissional;

    /**
     * Retorna o nome do medicamento
     * @return \Stringy\Stringy
     */
    public function getMedicamento()
    {
        return $this->medicamento;
    }

    /**
     * Retorna o nome da empresa fabricante
     * @return \Stringy\Stringy
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Retorna o número de expediente da bula
     * @return string
     */
    public function getExpediente()
    {
        return $this->expediente;
    }

    /**
     * Retorna o objeto Carbon ca a data de publicação da bula
     * @return \Carbon\Carbon
     */
    public function getDataPublicacao()
    {
        return $this->dataPublicacao;
    }

    /**
     * Retorna informações da bula do paciente
     * @return \Hevertonfreitas\Bulario\DadosBula
     */
    public function getBulaPaciente()
    {
        return $this->bulaPaciente;
    }

    /**
     * Retorna informações da bula do profissional
     * @return \Hevertonfreitas\Bulario\DadosBula
     */
    public function getBulaProfissional()
    {
        return $this->bulaProfissional;
    }

    /**
     * Seta o nome do medicamento
     * @param string $medicamento
     */
    public function setMedicamento($medicamento)
    {
        $this->medicamento = Str::create($medicamento);
    }

    /**
     * Seta a empresa fabricante do medicamento
     * @param string $empresa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = Str::create($empresa);
    }

    /**
     * Seta o número de expediente da bula
     * @param string $expediente
     */
    public function setExpediente($expediente)
    {
        $this->expediente = $expediente;
    }

    /**
     * Seta a data de publicação da bula
     * @param string $dataPublicacao deve estar no formato d/m/Y
     */
    public function setDataPublicacao($dataPublicacao)
    {
        $this->dataPublicacao = Carbon::createFromFormat('d/m/Y', $dataPublicacao);
    }

    /**
     * Seta os dados da bula do paciente
     * @param \Hevertonfreitas\Bulario\DadosBula $bulaPaciente
     */
    public function setBulaPaciente(DadosBula $bulaPaciente)
    {
        $this->bulaPaciente = $bulaPaciente;
    }

    /**
     * Seta os dados da bula do profissional
     * @param \Hevertonfreitas\Bulario\DadosBula $bulaProfissional
     */
    public function setBulaProfissional(DadosBula $bulaProfissional)
    {
        $this->bulaProfissional = $bulaProfissional;
    }

    /**
     * Função implementada da interface \JsonSerializable, para serializar
     * o objeto em JSON
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'medicamento' => (string) $this->medicamento,
            'empresa' => (string) $this->empresa,
            'expediente' => $this->expediente,
            'dataPublicacao' => $this->dataPublicacao->format('d/m/Y'),
            'bulaPaciente' => array(
                'transacao' => $this->bulaPaciente->getTransacao(),
                'anexo' => $this->bulaPaciente->getAnexo(),
                'url' => $this->bulaPaciente->getUrl()
            ),
            'bulaProfissional' => array(
                'transacao' => $this->bulaProfissional->getTransacao(),
                'anexo' => $this->bulaProfissional->getAnexo(),
                'url' => $this->bulaProfissional->getUrl()
            )
        );
    }
}
