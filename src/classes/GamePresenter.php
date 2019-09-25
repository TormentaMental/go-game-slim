<?php

namespace classes;

use GoGame\Game;

class GamePresenter
{
	protected $game;

  public function __construct(Game $game)
  {
    $this->game = $game;
  }

  public function toArray(): Array
  {
    return (Array) $this->toObj();
  }
  
  public function toObj(): \stdClass
  {
    $obj = new \stdClass();
    $obj->boardIntersections = $this->game->getBoardIntersections();
    $obj->whiteScore = $this->game->getWhiteScore();
    $obj->blackScore = $this->game->getBlackScore();
    $obj->whoPlaysNext = $this->game->getNextColor();
    return $obj;
  }
}
