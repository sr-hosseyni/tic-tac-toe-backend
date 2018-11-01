<?php

namespace App\Util\TicTacToe;

/**
 * Simple Equation class in form ax + by = c
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 */
class Equation
{
    /**
     *
     * @var int the coefficient of variable x
     */
    private $a;

    /**
     *
     * @var int the coefficient of variable y
     */
    private $b;

    /**
     * 
     * @var int the constant
     */
    private $c;

    /**
     * ax + by = c
     * @param int $const
     * @param int $coeff
     */
    public function __construct(int $a, int $b, int $c = 0)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    /**
     *
     * @param int $x
     * @return float
     */
    public function getYfor($x)
    {
        if ($this->b) {
            return ($this->c - $this->a * $x) / $this->b;
        }

        return null;
    }

    /**
     *
     * @param int $y
     * @return float
     */
    public function getXfor($y)
    {
        if ($this->a) {
            return ($this->b * $y - $this->c) / -$this->a;
        }

        return null;
    }

    /**
     *
     * @param \App\Util\TicTacToe\Equation $equation
     * @return string
     */
    public function getJunktionWith(Equation $equation): string
    {
        $determinant = $this->a * $equation->b - $this->b * $equation->a;
        if ($determinant === 0) {
            return '';
        }

        $mul = 1 / $determinant;
        $expressionMatrixInverse = [
            [$mul * $equation->b, $mul * -$this->b],
            [$mul * -$equation->a, $mul * $this->a]
        ];

        $x = $expressionMatrixInverse[0][0] * $this->c + $expressionMatrixInverse[0][1] * $equation->c;
        $y = $expressionMatrixInverse[1][0] * $this->c + $expressionMatrixInverse[1][1] * $equation->c;

        return $x . ',' . $y;
    }

    public function __toString()
    {
        return sprintf('%dx + %dy = %d', $this->a, $this->b, $this->c);
    }
}
