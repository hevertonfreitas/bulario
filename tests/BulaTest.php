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

use PHPUnit\Framework\TestCase;

class BulaTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDataPublicacao()
    {
        $bula = new Bula();

        $bula->setDataPublicacao('2016-01-01');

        $this->assertEquals('01/01/2016', $bula->getDataPublicacao()->format('d/m/Y'));
    }

    public function testJsonSerialize()
    {
        $bula = new Bula();

        $bulaPaciente = new DadosBula('19540482017', '9488711');
        $bulaProfissional = new DadosBula('19540482017', '9488712');

        $bula
            ->setDataPublicacao('01/09/2017')
            ->setEmpresa('APSEN FARMACEUTICA S/A')
            ->setExpediente('1862861/17-3')
            ->setMedicamento('DOBEVEN')
            ->setBulaPaciente($bulaPaciente)
            ->setBulaProfissional($bulaProfissional);

        $this->assertJson(json_encode($bula));
    }

    public function testGetMedicamento()
    {
        $bula = new Bula();

        $bulaPaciente = new DadosBula('19540482017', '9488711');
        $bulaProfissional = new DadosBula('19540482017', '9488712');

        $bula
            ->setDataPublicacao('01/09/2017')
            ->setEmpresa('APSEN FARMACEUTICA S/A')
            ->setExpediente('1862861/17-3')
            ->setMedicamento('DOBEVEN')
            ->setBulaPaciente($bulaPaciente)
            ->setBulaProfissional($bulaProfissional);

        $expected = 'DOBEVEN';
        $actual = $bula->getMedicamento();

        $this->assertEquals($expected, $actual);
    }

    public function testGetEmpresa()
    {
        $bula = new Bula();

        $bulaPaciente = new DadosBula('19540482017', '9488711');
        $bulaProfissional = new DadosBula('19540482017', '9488712');

        $bula
            ->setDataPublicacao('01/09/2017')
            ->setEmpresa('APSEN FARMACEUTICA S/A')
            ->setExpediente('1862861/17-3')
            ->setMedicamento('DOBEVEN')
            ->setBulaPaciente($bulaPaciente)
            ->setBulaProfissional($bulaProfissional);

        $expected = 'APSEN FARMACEUTICA S/A';
        $actual = $bula->getEmpresa();

        $this->assertEquals($expected, $actual);
    }

    public function testGetExpediente()
    {
        $bula = new Bula();

        $bulaPaciente = new DadosBula('19540482017', '9488711');
        $bulaProfissional = new DadosBula('19540482017', '9488712');

        $bula
            ->setDataPublicacao('01/09/2017')
            ->setEmpresa('APSEN FARMACEUTICA S/A')
            ->setExpediente('1862861/17-3')
            ->setMedicamento('DOBEVEN')
            ->setBulaPaciente($bulaPaciente)
            ->setBulaProfissional($bulaProfissional);

        $expected = '1862861/17-3';
        $actual = $bula->getExpediente();

        $this->assertEquals($expected, $actual);
    }

    public function testGetDataPublicacao()
    {
        $bula = new Bula();

        $bulaPaciente = new DadosBula('19540482017', '9488711');
        $bulaProfissional = new DadosBula('19540482017', '9488712');

        $bula
            ->setDataPublicacao('01/09/2017')
            ->setEmpresa('APSEN FARMACEUTICA S/A')
            ->setExpediente('1862861/17-3')
            ->setMedicamento('DOBEVEN')
            ->setBulaPaciente($bulaPaciente)
            ->setBulaProfissional($bulaProfissional);

        $expected = '01/09/2017';
        $actual = $bula->getDataPublicacao()->format('d/m/Y');

        $this->assertEquals($expected, $actual);
    }

    public function testGetBulaPaciente()
    {
        $bula = new Bula();

        $bulaPaciente = new DadosBula('19540482017', '9488711');
        $bulaProfissional = new DadosBula('19540482017', '9488712');

        $bula
            ->setDataPublicacao('01/09/2017')
            ->setEmpresa('APSEN FARMACEUTICA S/A')
            ->setExpediente('1862861/17-3')
            ->setMedicamento('DOBEVEN')
            ->setBulaPaciente($bulaPaciente)
            ->setBulaProfissional($bulaProfissional);

        $expected = '\Hevertonfreitas\Bulario\DadosBula';
        $actual = $bula->getBulaPaciente();

        $this->assertInstanceOf($expected, $actual);
    }

    public function testGetBulaProfissional()
    {
        $bula = new Bula();

        $bulaPaciente = new DadosBula('19540482017', '9488711');
        $bulaProfissional = new DadosBula('19540482017', '9488712');

        $bula
            ->setDataPublicacao('01/09/2017')
            ->setEmpresa('APSEN FARMACEUTICA S/A')
            ->setExpediente('1862861/17-3')
            ->setMedicamento('DOBEVEN')
            ->setBulaPaciente($bulaPaciente)
            ->setBulaProfissional($bulaProfissional);

        $expected = '\Hevertonfreitas\Bulario\DadosBula';
        $actual = $bula->getBulaProfissional();

        $this->assertInstanceOf($expected, $actual);
    }
}
