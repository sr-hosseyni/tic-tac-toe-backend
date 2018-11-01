<?php

namespace App\Util\TicTacToe\Exception;

/**
 * Description of SeriesNotFinalizedException
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class SeriesNotFinalizedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('you can\'t get series\' analytics informations before finilize', 2001);
    }
}
