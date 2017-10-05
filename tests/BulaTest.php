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
}
