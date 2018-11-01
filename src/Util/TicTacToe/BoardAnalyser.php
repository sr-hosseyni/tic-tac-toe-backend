<?php

namespace App\Util\TicTacToe;

use App\Util\TicTAcToe\Series;

/**
 * Description of BoardAnalyzer
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class BoardAnalyser
{
    /**
     * @var Board
     */
    private $board;

    /**
     *
     * @var string
     */
    private $playerUnit;

    /**
     *
     * @var int[][]
     */
    private $poitns;

    /**
     *
     * @param Board $board
     */
    public function __construct(Board $board, $playerUnit = 'X')
    {
        $this->board = $board;
        $this->playerUnit = $playerUnit;
        $this->poitns = [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ];
    }

    /**
     *
     * @param Board $board
     * @return spot
     */
    public function analyse()
    {
        if ($result = $this->checkGameIsFinished()) {
            // game is finished
            return $result;
        }

        if ($result = $this->moveToWin()) {
            // go to win
            return $this->makeMoveArray($result);
        }

        if ($result = $this->avoidLosing()) {
            // avoid losing
            return $this->makeMoveArray($result);
        }

        // making double chance
        $this->makeDoubleChance();

        // avoid making double chance by opponent
        $this->avoidToMakingDoubleChanceByOpponent();
        
        // destroy opponent chance
        $this->destroyOpponentChance();

//        // make possession in best junction of vacant series
//        $this->makePossessionInBestJunctionOfVacantSeries();

        // select a spot in one of totaly vacant series
        $this->selectAVacatSpot();

        if ($spot = $this->getBestMoveByMaxPoint()) {
            return $this->makeMoveArray($spot);
        }
        
        if ($result = $this->board->getVacantSpots()) {
            // select a vacant spot on board
            return $this->makeMoveArray($result[0]);
        }
        
        // No any move available, game is over with draw
        return [-1, -1, 'OX'];
    }

    /**
     *
     * @param Spot $spot
     * @return array
     */
    private function makeMoveArray(Spot $spot): array
    {
        return [$spot->getX(), $spot->getY(), $this->playerUnit];
    }

    private function checkGameIsFinished(): array
    {
        // Is Player winner
        if ($this->board->getSeriesByStatsIndex(3)) {
            // Indicates no more move, game is over, player has won the game
            return [-1, -1, $this->playerUnit];
        }

        // Is Player losser
        if ($this->board->getSeriesByStatsIndex(30)) {
            // Indicates no more move, game is over, player has lost the game
            return [-1, -1, ''];
        }

        return [];
    }

    /**
     *
     * @return array
     */
    private function moveToWin()
    {
        // Has Player move to win
        if ($series = $this->board->getSeriesByStatsIndex(102)) {
            $vacantSpotsOnSerie = $series[0]->getVacantSpots();
            return $vacantSpotsOnSerie[0];
        }

        return ;
    }

    /**
     * Has Player critical move to avoid losing
     * @return Spot
     */
    private function avoidLosing()
    {
        // 120 meanse there is one vacant spot and 2 unit of opponent (zero count of current team)
        if ($series = $this->board->getSeriesByStatsIndex(120)) {
            $vacantSpotsOnSerie = $series[0]->getVacantSpots();
            return $vacantSpotsOnSerie[0];
        }

        return null;
    }

    /**
     * Check Possibility Of Enforcing Opponent To Lose with making double chance simultaneously in next move
     * @return Spot
     */
    private function makeDoubleChance(): void
    {
        $chanceSeries = $this->board->getSeriesByStatsIndex(201);

        if (count($chanceSeries) > 1) {
            $this->addPoint($this->checkJunktions($chanceSeries), 5);
        }
    }

    /**
     * Check possibility for opponent to making double chance simultaneously in next move
     */
    private function avoidToMakingDoubleChanceByOpponent()
    {
        $dangerSeries = $this->board->getSeriesByStatsIndex(210);
        $chanceSeries = $this->board->getSeriesByStatsIndex(201);

        if (count($dangerSeries) > 1) {
            $oppDoubleChancesSpots = $this->checkJunktions($dangerSeries);
            $this->addPoint($oppDoubleChancesSpots, 10);
            foreach ($chanceSeries as $serie) {
                foreach ($vacantSpots = $serie->getVacantSpots() as $key => $vspot) {
                    foreach ($oppDoubleChancesSpots as $sdcSpot) {
                        if ($vspot === $sdcSpot) {
                            continue 2;
                        }
                    }
                    unset($vacantSpots[$key]);
                    $this->addPoint($vacantSpots, 20);
                }
            }
        }
    }

    /**
     *
     * @param Series[] $series
     * @param Series[] $notInSeries
     * @return Spot[]
     */
    private function checkJunktions(array $series, array $notInSeries = []): array
    {
        $junctions = [];
        for ($i = 0; $i < count($series); $i++) {
            for ($j = $i + 1; $j < count($series); $j++) {
                $spot = $series[$i]->getJunctionWith($series[$j]);
                if ($spot && $spot->isVacant() && !$this->isSpotOnSeries($spot, $notInSeries)) {
                    $junctions[] = $spot;
                }
            }
        }

        return $junctions;
    }

    private function isSpotOnSeries($spot, array $series)
    {
        foreach ($series as $serie) {
            if ($serie->isConsistOf($spot)) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * @return array
     */
    private function destroyOpponentChance()
    {
        $dangerSeries = $this->board->getSeriesByStatsIndex(210);
        foreach ($dangerSeries as $serie) {
            $this->addPoint($serie->getVacantSpots(), 3);
        }
    }

    /**
     *
     * @return Spot
     */
    private function makePossessionInBestJunctionOfVacantSeries(): void
    {
        $vacantSeries = $this->board->getSeriesByStatsIndex(300);
        $opponentSeries = $this->board->getSeriesByStatsIndex(210);

        if (count($vacantSeries) > 1 && $opponentSeries) {
            $this->addPoint($this->checkJunktions($vacantSeries, $opponentSeries), 3);
        }
    }

    /**
     *
     * @return Spot
     */
    private function selectAVacatSpot(): void
    {
        $vacantSeries = $this->board->getSeriesByStatsIndex(300);

        if (!$vacantSeries) {
            return;
        }

        foreach ($vacantSeries as $vacantSerie) {
            $this->addPoint($vacantSerie->getVacantSpots(), 1);
        }
    }

    /**
     *
     * @param \App\Util\TicTacToe\Spot[] $spots
     */
    private function addPoint(array $spots, int $point)
    {
        foreach ($spots as $spot) {
            if ($spot->isVacant()) {
                $this->poitns[$spot->getX()][$spot->getY()] += $point;
            }
        }
    }

    /**
     *
     * @return type
     */
    private function getBestMoveByMaxPoint()
    {
        $max = -1;
        $bestSpot = null;
        foreach ($this->board->getVacantSpots() as $spot) {
            if ($this->poitns[$spot->getX()][$spot->getY()] > $max) {
                $max = $this->poitns[$spot->getX()][$spot->getY()];
                $bestSpot = $spot;
            }
        }

        return $bestSpot;
    }
}
