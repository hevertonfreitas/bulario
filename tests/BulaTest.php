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

class BulaTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException InvalidArgumentException
     */
    public function testDataPublicacao()
    {
        $bula = new Bula();

        $bula->setDataPublicacao('2016-01-01');

        $this->assertEquals('01/01/2016', $bula->getDataPublicacao()->format('d/m/Y'));
    }
}
