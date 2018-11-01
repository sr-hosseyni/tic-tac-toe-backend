<?php

namespace App\Util\TicTacToe;

/**
 * Description of BoardParserInterface
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
interface BoardParserInterface
{
    /**
     *
     * @param array $board
     * @return Board
     */
    public static function parse(array $board): Board;
}
