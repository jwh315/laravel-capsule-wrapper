<?php

namespace CapsuleManager\Wrapper;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Events\Dispatcher;

/**
 * Class Manager
 * @package CapsuleManager\Wrapper
 */
class Manager extends Capsule
{

	/**
	 * @var \PDO
	 */
	protected $existing_connection;


	/**
	 * Manager constructor.
	 *
	 * @param \PDO           $pdo
	 * @param Container|null $container
	 */
	public function __construct(\PDO $pdo, Container $container = null)
	{
		$this->existing_connection = $pdo;

		parent::__construct($container);
	}


	/**
	 * Build the database manager instance.
	 *
	 * @return void
	 */
	protected function setupManager()
	{
		$factory = new ConnectionFactory($this->container);

		$this->manager = new DatabaseManager($this->container, $factory);

		$this->manager->addDefaultConnection($this->existing_connection);
	}


	/**
	 * @param \PDO $pdo
	 *
	 * @return static
	 */
	public static function init(\PDO $pdo)
	{
		$capsule = new static($pdo);

		$capsule->setEventDispatcher(new Dispatcher(new Container));

		$capsule->setAsGlobal();

		$capsule->bootEloquent();

		return $capsule;
	}
}