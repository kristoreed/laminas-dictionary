# laminas-dictionary

Laminas-dictionary is repository class with simple CRUD functionality, which can be used as base to more complex db dictionaries.
This package base on kristoreed/laminas-db-manager

## Installation

Use the package manager [composer](https://getcomposer.org/) to install laminas-dictionary.

```bash
composer require kristoreed/laminas-dictionary
```

## Base usage

```php
use Kristoreed\Laminas\DbManager\Query\Executor\Executor as QueryExecutor;

$dbAdapter = new Adapter([
    'driver'    => 'pdo',
    'dsn'       => 'mysql:dbname=test;host=localhost',
    'username'  => 'admin',
    'password'  => 'admin',
]);

$queryExecutor = new QueryExecutor($dbAdapter);
$userRepository = new Dictionary($queryExecutor);
$userRepository->setTableName('users');
$user = $userRepository->getElementById(404);

```

## Extend usage
```php
class User extends Dictionary implements UserInterface
{
    /**
     * @var string
     */
    protected $tableName = 'users';

    /**
     * @var QueryExecutorInterface
     */
    protected $queryExecutor;

    /**
     * User constructor
     *
     * @param QueryExecutorInterface $queryExecutor
     */
    public function __construct(QueryExecutorInterface $queryExecutor)
    {
        parent::__construct($queryExecutor);
        $this->queryExecutor = $queryExecutor;
    }

    /**
     * @param string $elementEmail
     *
     * @return array
     *
     * @throws ExecutorException
     */
    public function getElementByEmail(string $elementEmail): array
    {
        $select = new Select();
        $select
            ->from(['u' => $this->tableName])
            ->columns(['*'])
            ->where([
                'email' => $elementEmail
            ]);

        return $this->queryExecutor->getRow($select);
    }
}

$dbAdapter = new Adapter([
    'driver'    => 'pdo',
    'dsn'       => 'mysql:dbname=test;host=localhost',
    'username'  => 'admin',
    'password'  => 'admin',
]);

$queryExecutor = new QueryExecutor($dbAdapter);
$userRepository = new User($queryExecutor);
$user = $userRepository->getElementByEmail("user404@gmail.com");
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
