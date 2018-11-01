<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Util\TicTacToe;

use App\Util\TicTAcToe\Equation;
use App\Util\TicTacToe\Series;
use App\Util\TicTacToe\Spot;
use PHPUnit\Framework\TestCase;

/**
 * Description of SeriesTest
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class SeriesTest extends TestCase
{
    /**
     * @dataProvider dataProviderIsConsistOf
     */
    public function testIsConsistOf(Series $serie, array $spots)
    {
        foreach ($spots as $spot) {
            $this->assertTrue($serie->isConsistOf($spot));
        }
    }

    public function dataProviderIsConsistOf()
    {
        return [
            [new Series(new Equation(0, 1, 0)), [new Spot(1, 0), new Spot(2,0), new Spot(0,0)]],
            [new Series(new Equation(-1, 1, 0)), [new Spot(1, 1), new Spot(2,2), new Spot(0,0)]],
            [new Series(new Equation(1, 1, 2)), [new Spot(1, 1), new Spot(2,0), new Spot(0,2)]],
        ];
    }
}
