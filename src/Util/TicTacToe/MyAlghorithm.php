<?php

namespace App\Util\TicTacToe;

/**
 * Description of Move
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class MyAlghorithm implements MoveInterface
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
        $unitCoef = [
            $playerUnit => 10,
            $playerUnit === 'X' ? 'O' : 'X' => -1
        ];

        $lines = [
            'y=0' => new Line(new Equation(0)),             // y = 0
            'y=1' => new Line(new Equation(1)),             // y = 1
            'y=2' => new Line(new Equation(2)),             // y = 2

            'x=0' => new VerticalLine(new Equation(0)),     // x = 0
            'x=1' => new VerticalLine(new Equation(1)),     // x = 1
            'x=2' => new VerticalLine(new Equation(2)),     // x = 2

            'y-x=0' => new Line(new Equation(0, 1)),        // y = x
            'y+x=2' => new Line(new Equation(2, -1)),       // y = 2 - x
        ];

        $unitsCountOnLines = [
            [
                'y=0' => 0,
                'y=1' => 0,
                'y=2' => 0,
                'x=0' => 0,
                'x=1' => 0,
                'x=2' => 0,
                'y-x=0' => 0,
                'y+x=2' => 0,
            ]
        ];

        for ($y = 0; $y < 3; $y++) {
            for ($x = 0; $x < 3; $x++) {
                $unitsCountOnLines['y=' . $y] += $unitCoef[[$boardState[$y][$x]]];
                $unitsCountOnLines['x=' . $x] += $unitCoef[[$boardState[$y][$x]]];

                if ($y - $x === 0) {
                    $unitsCountOnLines['y-x=0'] += $unitCoef[[$boardState[$y][$x]]];
                }

                if ($y + $x === 2) {
                    $unitsCountOnLines['y+x=2'] += $unitCoef[[$boardState[$y][$x]]];
                }
            }
        }

        $analytics = [];

        foreach ($unitsCountOnLines as $line => $countOnLine) {
            // role 1
            switch ($countOnLine) {
                case -3:
                    $analytics['lose'][] = $lines[$line];
                    break 2;
                case 30:
                    $analytics['win'][] = $lines[$line];
                    break 2;

//                case 8:
//                case 9:
//                case 19: return 'doesn\'t matter';

                case 20:
                    $analytics['goalFor'][] = $lines[$line];
                    break;
                case -2:
                    $analytics['goalAgaints'][] = $lines[$line];
                    break;
                case -1:
                    $analytics['danger'][] = $lines[$line];
                    break;
                case 0:
                    $analytics['vacant'][] = $lines[$line];
                    break;
                case 10:
                    $analytics['chance'][] = $lines[$line];
                    break;
            }
        }

        if ($analytics['goalFor']) {
            $spots = $analytics['goalFor'][0]->getSpots();
            foreach ($spots as $spot) {
                if ($boardState[$spot[0]][$spot[1]] === '') {
                    return [$spot[0], $spot[1], $playerUnit];
                }
            }
        }

        return [2, 0, 'O'];
    }

    public function findVacantOnLine($line)
    {
        
    }
}
