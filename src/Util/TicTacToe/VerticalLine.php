<?php

namespace App\Util\TicTacToe;

/**
 * Description of Line
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class VerticalLine extends Line
{
    /**
     *
     * @var Equation
     */
    protected $e;

    /**
     *
     * @param int $index
     * @return array
     */
    public function getSpot($index)
    {
        return [$index, $this->e->valueOf($index)];
    }
}
