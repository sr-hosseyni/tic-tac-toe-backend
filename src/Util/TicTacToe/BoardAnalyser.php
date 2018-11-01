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
     * @param Board $board
     */
    public function __construct(Board $board, $playerUnit = 'X')
    {
        $this->board = $board;
        $this->playerUnit = $playerUnit;
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

        if ($result = $this->makeDoubleChance()) {
            // making double chance
            return $this->makeMoveArray($result);
        }

        if ($result = $this->avoidToMakingDoubleChanceByOpponent()) {
            // avoid making double chance by opponent
            return $this->makeMoveArray($result);
        }

        if ($result = $this->makeChanceAndDestroyOpponentChance()) {
            // make chance and destroy opponent chance
            return $this->makeMoveArray($result);
        }

        if ($result = $this->makePossessionInBestJunctionOfVacantSeries()) {
            // make possession in best junction of vacant series
            return $this->makeMoveArray($result);
        }

        if ($result = $this->selectAVacatSpot()) {
            // select a spot in one of totaly vacant series
            return $this->makeMoveArray($result);
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
    private function makeDoubleChance()
    {
        $chanceSeries = $this->board->getSeriesByStatsIndex(201);

        if (count($chanceSeries) > 1) {
            return $this->checkJunktions($chanceSeries);
        }

        return null;
    }

    /**
     * Check possibility for opponent to making double chance simultaneously in next move
     */
    private function avoidToMakingDoubleChanceByOpponent()
    {
        $dangerSeries = $this->board->getSeriesByStatsIndex(210);

        if (count($dangerSeries) > 1) {
            return $this->checkJunktions($dangerSeries);
        }

        return null;
    }

    /**
     *
     * @param Series[] $series
     */
    private function checkJunktions(array $series, array $notInSeries = [])
    {
        for ($i = 0; $i < count($series); $i++) {
            for ($j = $i + 1; $j < count($series); $j++) {
                $spot = $series[$i]->getJunctionWith($series[$j]);
                if ($spot && $spot->isVacant() && !$this->isSpotOnSeries($spot, $notInSeries)) {
                    return $spot;
                }
            }
        }

        return null;
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
    private function makeChanceAndDestroyOpponentChance()
    {
        $dangerSeries = $this->board->getSeriesByStatsIndex(210);
        $chanceSeries = $this->board->getSeriesByStatsIndex(201);
        $series = array_merge($dangerSeries, $chanceSeries);

        if (count($series) > 1) {
            return $this->checkJunktions($series);
        }

        return null;
    }

    /**
     *
     * @return Spot
     */
    private function makePossessionInBestJunctionOfVacantSeries()
    {
        $vacantSeries = $this->board->getSeriesByStatsIndex(300);
        $opponentSeries = $this->board->getSeriesByStatsIndex(210);

        if (count($vacantSeries) > 1 && $opponentSeries) {
            return $this->checkJunktions($vacantSeries, $opponentSeries);
        }

        return null;
    }

    /**
     *
     * @return Spot
     */
    private function selectAVacatSpot()
    {
        $vacantSeries = $this->board->getSeriesByStatsIndex(300);

        if (!$vacantSeries) {
            return null;
        }

        /* @var $serie Series */
        $serie = $vacantSeries[array_rand($vacantSeries)];
        $vacantSpots = $serie->getVacantSpots();
        return $vacantSpots[array_rand($vacantSpots)];
    }
}
