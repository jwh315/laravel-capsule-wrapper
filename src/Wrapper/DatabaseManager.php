<?php

namespace CapsuleManager\Wrapper;

use Illuminate\Database\DatabaseManager as EloquentDatabaseManager;
use Illuminate\Database\MySqlConnection;

/**
 * Class DatabaseManager
 * @package CapsuleManager\Wrapper
 */
class DatabaseManager extends EloquentDatabaseManager
{

	/**
	 * @param \PDO $pdo
	 */
	public function addDefaultConnection(\PDO $pdo)
	{
		$this->connections['default'] = new MySqlConnection($pdo);
	}
}