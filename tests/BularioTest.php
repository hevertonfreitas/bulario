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

use PHPUnit_Framework_TestCase;

class BularioTest extends PHPUnit_Framework_TestCase
{

    public function testBuscaVazia()
    {
        $medicamentos = Bulario::buscarMedicamentos('astofo');

        $this->assertEmpty($medicamentos);
    }

    public function testBulaPacienteValida()
    {
        $medicamentos = Bulario::buscarMedicamentos('', '', '0870281/15-1');

        foreach ($medicamentos as $medicamento) {
            $headers = get_headers($medicamento->getBulaPaciente()->getUrl(), 1);
            $this->assertContains('pdf', $headers['Content-Type']);
        }
    }
}
