<?php

namespace App\Util\TicTacToe;

/**
 * Description of ArrayBoardParser
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class ArrayBoardParser implements BoardParserInterface
{
    /**
     *
     * @param array $boardArray
     */
    public static function parse(array $boardArray): Board
    {
        if (!count($boardArray) === 3) {
            throw new \Exception(sprintf('invalid board array, Dimention must be 3x3'));
        }
        $board = new Board();
        for ($x = 0; $x < count($boardArray); $x++) {
            for ($y = 0; $y < count($boardArray[$x]); $y++) {
                if (!isset($boardArray[$x][$y])) {
                    throw new \Exception(sprintf('invalid board array, x=[%d],y=[%d] not found', $x, $y));
                }

                $board->addSpot(new Spot($x, $y, $boardArray[$x][$y]));
            }
        }

        return $board;
    }
}
