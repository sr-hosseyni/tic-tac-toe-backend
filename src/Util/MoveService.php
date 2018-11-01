<?php

namespace App\Util;

use App\Util\TicTacToe\ArrayBoardParser;
use App\Util\TicTacToe\BoardAnalyser;
use App\Util\TicTacToe\BoardAnalyser2;
use App\Util\TicTacToe\BoardAnalyserFinal;

/**
 * Description of Move
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class MoveService implements MoveInterface
{
    /**
     * Makes a move using the $boardState * $boardState contains 2 dimensional array of the game field
     * X represents one team, O - the other team, empty string means field is not yet taken.
     * example
     *   [
     *     ['X', 'O', '' ]
     *     ['X', 'O', 'O']
     *     ['' , '' , '' ]
     *   ]
     *
     * Returns an array, containing x and y coordinates for next move, and the unit that now occupies it.
     * Example: [2, 0, 'O'] - upper right corner - O player
     *
     * @param array $boardState Current board state
     * @param string $playerUnit Player unit representation
     * @return array
     */
    public function makeMove($boardState, $playerUnit = 'X')
    {
        $board = ArrayBoardParser::parse($boardState);
        $board->finalize($playerUnit);
//        $analyser = new BoardAnalyser($board, $playerUnit);
//        $analyser = new BoardAnalyser2($board, $playerUnit);
        $analyser = new BoardAnalyserFinal($board, $playerUnit);
        return $analyser->analyse();
    }
}
