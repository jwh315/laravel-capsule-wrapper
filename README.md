# eloquent-capsule-wrapper
Use the Eloquent ORM outside of the Laravel Framework with an existing PDO database connection.

### disclaimer

This project is currently a proof of concept, without tests. I have manually tested it using a few standard 
Laravel operations with success, but I cannot currently vouch for its robustness in a real world PHP application.

One of the main issues I have not fully fleshed out is the database name parameter that you would normally
pass into an eloquent connection.  I have chosen to omit this parameter as my use case requires a database connection, 
with the ability to access multiple databases on the same connection.  From my limited testing, this hasn't posed a problem, 
but I could be missing something.

Lastly, this only works for Mysql currently. This is done in `CapsuleManager\Wrapper\DatabaseManager::addDefaultConnection()`, 
theoretically you should be able to swap out any of the other `Illuminate\Database` connection classes as needed.

### usage

This is pretty much the same as the usage instructions on the [Illuminate\Database](https://github.com/illuminate/database)
repository. It should be noted that I have not tested the `Schema Builder`

	use CapsuleManager\Wrapper\Manager;
    use Illuminate\Container\Container;
    use Illuminate\Events\Dispatcher;
    
    $dsn = "mysql:host=" . DBHOST;
    $pdo = new \PDO($dsn, DBUSER, DBPASS);
    
    $capsule = new Manager($pdo);
    
    // Set the event dispatcher used by Eloquent models... (optional)
    $capsule->setEventDispatcher(new Dispatcher(new Container));
    
    // Make this Capsule instance available globally via static methods... (optional)
    $capsule->setAsGlobal();
    
    // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
    $capsule->bootEloquent();
    
    
    $t = $capsule::table('mysql.db')
    			 ->where('Host', 'localhost')
    			 ->get();
    
    dd($t);

I also added a static accessor to encapsulate all of this boilerplate inside of the wrapper class, if you are
going to use the defaults settings in the above example, this will also work.

	use CapsuleManager\Wrapper\Manager as Capsule;
    
    $dsn = "mysql:host=" . DBHOST;
    $pdo = new \PDO($dsn, DBUSER, DBPASS);
    
    $capsule = Capsule::init($pdo);
    
	$t = $capsule::table('mysql.db')
				 ->where('Host', 'localhost')
				 ->get();
	
	dd($t);
	
Using the Eloquent ORM

This is exactly the same as you would expect, except as mentioned above, I did not add a way to set the database name
so you will have to set it explicitly

	//initialize the capsule manager
	use CapsuleManager\Wrapper\Manager as Capsule;
	
	$dsn = "mysql:host=" . DBHOST;
	$pdo = new \PDO($dsn, DBUSER, DBPASS);
	
	$capsule = Capsule::init($pdo);

	//user model example
	use Illuminate\Database\Eloquent\Model;
    
    class User extends Model
    {
    	//this needs to be set on all your models
    	protected $table = 'test.users';
    }
    
    //using the user model
   	dd(User::all()->last()->login);

