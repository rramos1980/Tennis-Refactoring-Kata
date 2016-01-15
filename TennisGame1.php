<?php

class TennisGame1 implements TennisGame
{
    const MIN_DIFFERENCE_TO_WIN = 2;
    const STARTING_ADVANTAGE_SCORE = 4;

    private $player1Score = 0;
    private $player2Score = 0;
    private $player1Name = '';
    private $player2Name = '';

    private $equalsTexts = [
        0 => "Love-All",
        1 => "Fifteen-All",
        2 => "Thirty-All"
    ];

    private $textScores = [
        0 => "Love",
        1 => "Fifteen",
        2 => "Thirty",
        3 => "Forty"
    ];

    const SCORE_DELIMITER = '-';

    public function __construct($player1Name, $player2Name)
    {
        $this->player1Name = $player1Name;
        $this->player2Name = $player2Name;
    }

    public function wonPoint($playerName)
    {
        if ('player1' == $playerName) {
            $this->player1Score++;
        } else {
            $this->player2Score++;
        }
    }

    public function getScore()
    {
        if ($this->isGameEquals()) {
            $score = $this->scoreForGameEquals();
        } elseif ($this->anyPlayerInAdvantage()) {
            $score = $this->scoreForPlayerInAdvantage();
        } else {
            $score = $this->scoreForRegularGame();
        }

        return $score;
    }

    /**
     * @return bool
     */
    private function isGameEquals()
    {
        return $this->player1Score === $this->player2Score;
    }

    /**
     * @return string
     */
    private function scoreForGameEquals()
    {
        return $this->equalsTextScoreFromNumericScore($this->player1Score);
    }

    /**
     * @return string
     */
    private function equalsTextScoreFromNumericScore($numericScore)
    {
        if (isset($this->equalsTexts[$numericScore])) {
            return $this->equalsTexts[$numericScore];
        }

        return "Deuce";
    }

    /**
     * @return bool
     */
    private function anyPlayerInAdvantage()
    {
        return $this->hasAdvantage($this->player1Score)
            || $this->hasAdvantage($this->player2Score);
    }

    /**
     * @return bool
     */
    private function hasAdvantage($score)
    {
        return $score >= self::STARTING_ADVANTAGE_SCORE;
    }

    /**
     * @return string
     */
    private function scoreForRegularGame()
    {
        return $this->scoreTextFromNumericScore($this->player1Score)
            . self::SCORE_DELIMITER
            . $this->scoreTextFromNumericScore($this->player2Score);
    }

    /**
     * @param $aNumericScore
     * @return mixed
     */
    private function scoreTextFromNumericScore($aNumericScore)
    {
        return $this->textScores[$aNumericScore];
    }

    /**
     * @return string
     */
    private function scoreForPlayerInAdvantage()
    {
        $scoreDiference = $this->player1Score - $this->player2Score;

        return $this->typeOfAdvantageFromScore($scoreDiference) . ' ' . $this->playerInAdvantage($scoreDiference);
    }

    private function typeOfAdvantageFromScore($scoreDiference)
    {
        return $this->isWinningDifference($scoreDiference) ? 'Win for' : 'Advantage';
    }

    /**
     * @param $scoreDiference
     * @return bool
     */
    private function isWinningDifference($scoreDiference)
    {
        return abs($scoreDiference) >= self::MIN_DIFFERENCE_TO_WIN;
    }

    private function playerInAdvantage($scoreDiference)
    {
        return ($scoreDiference > 0 ) ? 'player1' : 'player2';
    }
}

