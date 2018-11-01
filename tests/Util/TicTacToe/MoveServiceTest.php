<?php

namespace App\Tests\Util\TicTacToe;

use App\Util\MoveService;
use PHPUnit\Framework\TestCase;

/**
 * Description of MoveTest
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class MoveServiceTest extends TestCase
{
    public function testMakeMove()
    {
        $calculator = new MoveService();
        $result = $calculator->makeMove([
            ['X', 'O', '' ],
            ['X', 'O', 'O'],
            ['' , '' , '' ]
        ], 'X');

        // assert that your calculator added the numbers correctly!
        $this->assertEquals([2, 0, 'X'], $result);
    }
}
