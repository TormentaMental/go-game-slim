<?php 
namespace classes;

use GoGame\Game;
use GoGame\Storage;

class SessionStorage implements Storage
{
    private $game;
  
    public function save(Game $game): void
    {
        $_SESSION['GoGame_serialized_game'] = serialize($game);
    }
  
    public function load(): Game
    {
        if ($this->isEmpty()) {
            throw new EmptyStorageException();
        }
        return unserialize($_SESSION['GoGame_serialized_game']);
    }
  
    public function reset(): void
    {
        unset( $_SESSION['GoGame_serialized_game'] );
    }
  
    public function isEmpty(): bool
    {
        return empty($_SESSION['GoGame_serialized_game']);
    }
}
