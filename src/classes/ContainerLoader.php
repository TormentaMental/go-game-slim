<?php
namespace classes;

class ContainerLoader{
	
	private $container;

	public function __construct(\Slim\Container $container){
		$this->container = $container;
	}

	public function load(){
		$this->container['logger'] = function($c) {
		    $logger = new \Monolog\Logger('my_logger');
		    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
		    $logger->pushHandler($file_handler);
		    return $logger;
		};

		$this->container['view'] = new \Slim\Views\PhpRenderer('../templates/');
	}
}