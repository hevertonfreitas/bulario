<?php

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
