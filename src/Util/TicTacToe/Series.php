<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Util\TicTacToe;

use App\Tests\Util\TicTacToe\Exception\SeriesNotFinalizedException;
use App\Util\TicTAcToe\Equation;

/**
 * Description of Series
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class Series
{
    /**
     *
     * @var Spot[]
     */
    private $spots = [];

    /**
     * Indicate all spots are finalized and nothing will change then
     * @var bool
     */
    private $finilized = false;

    /**
     *
     * @var \App\Util\TicTacToe\Equation
     */
    private $equation;

    /**
     *
     * @var array
     */
    private $stats = [
        Board::TEAM_X => 0,
        Board::TEAM_O => 0,
        Board::VACANT => 0
    ];

    public function __construct(Equation $equation)
    {
        $this->equation = $equation;
    }

    /**
     *
     * @param Spot $spot
     * @return Series
     */
    public function addSpot(Spot $spot): Series
    {
        $this->spots[$spot->getX() . ',' . $spot->getY()] = $spot;

        return $this;
    }

    private function calculateStats()
    {
        foreach ($this->spots as $spot) {
            $this->stats[$spot->getBead()]++;
        }
    }

    public function finalize(): Series
    {
        $this->finilized = true;
        $this->calculateStats();
        return $this;
    }

    /**
     *
     * @param string $team
     * @return int
     */
    public function getCountsOfBeads(string $team): int
    {
        $this->checkIsFinalized();
        return $this->stats[$team] ?? 0;
    }

    /**
     *
     * @param string $ones
     * @param string $tens
     * @param string $hundreds
     * @return int
     */
    public function getStatIndex(string $ones, string $tens = '', string $hundreds = ''): int
    {
        return $this->stats[$hundreds] * 100 + $this->stats[$tens] * 10 + $this->stats[$ones];
    }

    /**
     *
     * @throws SeriesNotFinalizedException
     */
    private function checkIsFinalized() {
        if (!$this->finilized) {
            throw new SeriesNotFinalizedException();
        }
    }

    public function getVacantSpots(): array
    {
        $vacantSpots = [];
        foreach ($this->spots as $spot) {
            if ($spot->isVacant()) {
                $vacantSpots[] = $spot;
            }
        }

        return $vacantSpots;
    }

    /**
     *
     * @param Series $serie
     * @return Spot
     */
    public function getJunctionWith(Series $serie)
    {
        $key = $this->equation->getJunktionWith($serie->getEquation());

        if ($key) {
            return $this->spots[$key];
        }

        return null;
    }

    public function isConsistOf(Spot $spot): bool
    {
        if (($y = (int)$this->equation->getYfor($spot->getX())) !== null) {
            return $y === $spot->getY();
        }
        if (($x = (int)$this->equation->getXfor($spot->getY())) !== null) {
            return $x === $spot->getX();
        }
        return false;
    }

    /**
     *
     * @return Equation
     */
    public function getEquation(): Equation
    {
        return $this->equation;
    }

    /**
     *
     * @return Spot[]
     */
    public function getSpots()
    {
        return $this->spots;
    }

    public function __toString()
    {
        return (string)$this->equation;
    }
}
