<?php

namespace App\Util\TicTacToe;

/**
 * Description of Line
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class Line
{
    /**
     *
     * @var Equation
     */
    protected $e;

    /**
     *
     * @param \App\Util\TicTacToe\Equation $e
     */
    public function __construct(Equation $e)
    {
        $this->e = $e;
    }

    /**
     *
     * @param int $index
     * @return array
     */
    public function getSpot($index)
    {
        return [$this->e->valueOf($index), $index];
    }

    /**
     *
     * @return array
     */
    public function getSpots()
    {
        $spots = [];
        for ($i = 0; $i < 3; $i++) {
            $spots[] = $this->getSpot($i);
        }

        return $spots;
    }
}
