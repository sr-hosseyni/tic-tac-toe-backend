<?php

namespace App\Util\TicTacToe\Exception;

/**
 * Description of BoardNotFinalizedException
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class BoardNotFinalizedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('you can\'t get board\'s analytics informations before finilize', 2002);
    }
}
