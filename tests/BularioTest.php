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

use PHPUnit_Framework_TestCase;

class BularioTest extends PHPUnit_Framework_TestCase
{

    public function testarBuscaMedicamento()
    {
        $medicamentos = Bulario::buscarMedicamentos('dipirona');
        foreach ($medicamentos as $medicamento) {
            $this->assertInternalType('int', $medicamento['dados_bula_paciente']['transacao']);
            $this->assertInternalType('int', $medicamento['dados_bula_paciente']['anexo']);
        }
    }

    public function testBuscaVazia()
    {
        $medicamentos = Bulario::buscarMedicamentos('astofo');

        $this->assertEmpty($medicamentos);
    }
}
