<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Util\TicTacToe;

use App\Util\TicTAcToe\Equation;
use PHPUnit\Framework\TestCase;

/**
 * Description of EquationTest
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class EquationTest extends TestCase
{
    /**
     * @dataProvider dataProviderValueByVariable
     */
    public function testValueByVariable(Equation $equation, array $tests)
    {
        foreach ($tests as $x => $y) {
            $this->assertEquals($y, $equation->getYfor($x));
        }
    }

    public function dataProviderValueByVariable()
    {
        return [
            [new Equation(0, 1, 0), [1 => 0, 2 => 0, 3 => 0, 0 => 0, -1 => 0, 1000 => 0, -5 => 0]],
            [new Equation(-1, 1, 0), [1 => 1, 2 => 2, 3 => 3, 0 => 0, -1 => -1, 1000 => 1000, -5 => -5]],
            [new Equation(1, 1, 2), [1 => 1, 2 => 0, 3 => -1, 0 => 2, -1 => 3, 1000 => -998, -5 => 7]],
        ];
    }
}
