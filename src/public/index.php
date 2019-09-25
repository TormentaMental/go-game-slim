<?php
use GoGame\BoardFactory;
use GoGame\Game;
use GoGame\IntersectionNotEmptyException;
use GoGame\UseCases\PlaceBlackStoneUseCase;
use GoGame\UseCases\PlaceWhiteStoneUseCase;
use GoGame\UseCases\ShowGameUseCase;
use GoGame\WrongColorException;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use classes\ContainerLoader;
use classes\GamePresenter;
use classes\SessionStorage as Storage;

require '../../vendor/autoload.php';
require '../config.php';

session_start();

$app = new \Slim\App(['settings' => $config]);

(new ContainerLoader($app->getContainer()))->load();

$app->get('/', function (Request $request, Response $response, array $args) {
  $this->logger->addInfo("ShowGameUseCase execute");
  return renderGame($response, $this->view);
});

$app->get('/place_black_stone/{row}/{col}', function (Request $request, Response $response, array $args) {
  $this->logger->addInfo("PlaceBlackStoneUseCase execute: col {$args['row']}, col {$args['col']}");
  try {
    placeBlackStone($args['row'], $args['col']);
    return renderGame($response, $this->view);
  } catch (Exception $e) {
    return renderGame($response, $this->view, ["error" => getError($e)]);
  }
});

  function placeBlackStone($row, $col){
    $useCase = new PlaceBlackStoneUseCase(new Storage());
    $useCase->execute($row, $col);  
  }

$app->get('/place_white_stone/{row}/{col}', function (Request $request, Response $response, array $args) {
  $this->logger->addInfo("PlaceWhiteStoneUseCase execute: col {$args['row']}, col {$args['col']}");
  try {
    placeWhiteStone($args['row'], $args['col']);
    return renderGame($response, $this->view);
  } catch (Exception $e) {
    return renderGame($response, $this->view, ["error" => getError($e)]);
  }
});

    function placeWhiteStone($row, $col){
      $useCase = new PlaceWhiteStoneUseCase(new Storage());
      $useCase->execute($row, $col);  
    }

$app->get('/reset', function (Request $request, Response $response) {
  $storage = new Storage();
  $storage->reset();
  return $response->withRedirect('/');
});

  function getError(\Exception $e){
    if($e instanceof IntersectionNotEmptyException) {
      return "Lugar ocupado";
    } else if($e instanceof WrongColorException){
      return "Jugador incorrecto";
    } else{
      throw $e;
    }
  }

  function renderGame($response, $view, Array $extraData=[]){
    $presentedGame = (new GamePresenter(getGame()))->toArray();
    $data = array_merge($presentedGame, $extraData);
    return $view->render($response, 'index.phtml', $data);
  }

    function getGame(){
      $useCase = new ShowGameUseCase(new Storage());
      return $useCase->execute(new Game(BoardFactory::createSmallBoard()));
    }

$app->run();


