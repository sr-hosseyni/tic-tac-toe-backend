<?php

namespace App\Util\TicTacToe;

/**
 * Description of Spot
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class Spot
{
    /**
     *
     * @var int
     */
    private $x;

    /**
     *
     * @var int
     */
    private $y;

    /**
     *
     * @var char
     */
    private $bead = '';

    public function __construct(int $x, int $y, string $bead = '')
    {
        $this->x = $x;
        $this->y = $y;
        $this->bead = $bead;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getBead(): string
    {
        return $this->bead;
    }

    public function setX(int $x): Spot
    {
        $this->x = $x;
        return $this;
    }

    public function setY(int $y): Spot
    {
        $this->y = $y;
        return $this;
    }

    public function setBead(string $bead): Spot
    {
        $this->bead = $bead;
        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isVacant(): bool
    {
        return $this->bead === Board::VACANT;
    }

    public function __toString()
    {
        return sprintf('[%d, %d] => %s', $this->x, $this->y, $this->bead);
    }
}
