<?php

namespace App\Util\TicTacToe;

use App\Tests\Util\TicTacToe\Exception\BoardNotFinalizedException;

/**
 * Description of Board
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class Board
{
    const TEAM_X = 'X';
    const TEAM_O = 'O';
    const VACANT = '';

    /**
     *
     * @var Spot[]
     */
    private $spots;

    /**
     *
     * @var Series[]
     */
    private $series;

    /**
     *
     * @var array
     */
    private $stats = [];

    /**
     * Indicate all spots are finalized and nothing will change then
     * @var bool
     */
    private $finalized = false;

    public function __construct()
    {
        $this->series = [
            'y=0' => new Series(new Equation(0, 1, 0)),             // 0x + 1y = 0
            'y=1' => new Series(new Equation(0, 1, 1)),             // 0x + 1y = 1
            'y=2' => new Series(new Equation(0, 1, 2)),             // 0x + 1y = 2
            'x=0' => new Series(new Equation(1, 0, 0)),             // 1x + 0y = 0
            'x=1' => new Series(new Equation(1, 0, 1)),             // 1x + 0y = 1
            'x=2' => new Series(new Equation(1, 0, 2)),             // 1x + 0y = 2
            'y=x' => new Series(new Equation(-1, 1, 0)),            // -1x + 1y = 0
            'y=2-x' => new Series(new Equation(1, 1, 2)),           // 1x + 1y = 2
        ];
    }

    public function addSpot(Spot $spot)
    {
        $this->spots[$spot->getX()][$spot->getY()] = $spot;

        $this->series['y=' . $spot->getY()]->addSpot($spot);
        $this->series['x=' . $spot->getX()]->addSpot($spot);

        if ($spot->getY() === $spot->getX()) {
            $this->series['y=x']->addSpot($spot);
        }

        if ($spot->getY() + $spot->getX() === 2) {
            $this->series['y=2-x']->addSpot($spot);
        }
    }

    public function getSpot($x, $y): Spot
    {
        return $this->spots[$x][$y];
    }

    /**
     *
     * @param string $playerUnit
     * @return \App\Util\TicTacToe\Board
     */
    public function finalize(string $playerUnit): Board
    {
        $this->finalized = true;
        foreach ($this->series as $series) {
            $series->finalize();
        }
        $this->calculate($playerUnit, $playerUnit == self::TEAM_X ? self::TEAM_O : self::TEAM_X);

        return $this;
    }

    /**
     *
     * @param string $team1
     * @param string $team2
     */
    private function calculate(string $team1, string $team2)
    {
        foreach ($this->series as $key => $series) {
            $this->stats[$key] = $series->getStatIndex($team1, $team2);
        }
    }

    /**
     *
     * @throws BoardNotFinalizedException
     */
    private function checkIsFinalized() {
        if (!$this->finalized) {
            throw new BoardNotFinalizedException();
        }
    }

    /**
     *
     * @param type $playerUnit
     * @param type $unitsCountOnSerie
     * @return Series[]
     */
    public function getSeriesByStatsIndex($statIndex): array
    {
        $this->checkIsFinalized();

        $series = [];
        foreach ($this->stats as $key => $stat) {
            if ($stat === $statIndex) {
                $series[] = $this->series[$key];
            }
        }

        return $series;
    }

    /**
     *
     * @param string $key
     * @return Series
     */
    public function getSeries($key)
    {
        return $this->series[$key];
    }

    /**
     *
     * @return Spot[]
     */
    public function getVacantSpots()
    {
        $vacantSpots = [];
        foreach ($this->spots as $spotsRow) {
            foreach ($spotsRow as $spot) {
                if ($spot->isVacant()) {
                    $vacantSpots[] = $spot;
                }
            }
        }

        return $vacantSpots;
    }
}
