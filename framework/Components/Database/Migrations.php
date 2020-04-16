<?php


namespace TestFramework\Components\Database;


class Migrations
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var bool
     */
    private $rollback;

    /**
     * @var int
     */
    private $count;

    /**
     * @var array
     */
    private $migrationsFiles = [];

    /**
     * Migrations constructor.
     */
    public function __construct()
    {
        $this->pdo = DB::getInstance()->getConnecting();
    }

    public function createTableMigrate(): void
    {
        $query = "create table if not exists `versions` (
            `id` int(10) unsigned not null auto_increment,
            `name` varchar(255) not null,
            `created` timestamp default current_timestamp,
            primary key (id)
            )
            engine = innodb
            auto_increment = 1
            character set utf8
            collate utf8_general_ci;";

        $this->pdo->query($query);
    }

    /**
     * @param string $path
     * @param array $params
     */
    public function init(string $path, array $params = []): void
    {
        $this->setParams($params);
        $this->setMigrationsFiles($path);

        if ($this->rollback) {
            $this->down();
        } else {
            $this->up();
        }
    }

    /**
     * @param array $params
     */
    private function setParams(array $params = []): void
    {
        if (count($params) > 1) {
            $this->rollback = ($params[1] === "rollback") ? true : false;
            $this->count = !empty($params[2]) ? $params[2] : 0;
        }
    }

    /**
     * @param string $path
     */
    private function setMigrationsFiles(string $path): void
    {
        $this->migrationsFiles = glob($path . '*.php');
    }

    /**
     *
     */
    private function up()
    {
        foreach($this->migrationsFiles as $file) {
            $migrationName =  $this->getMigrationName($file);
            $className = $this->getClassName($migrationName);

            if (!$this->existInBase($migrationName)) {
                include_once ($file);
                $class = new $className();
                $action = "up";
                $this->pdo->query($class->$action());
                $this->addMigrations($migrationName);

                echo "Create to migrate " . $migrationName;
            } else {
                echo "Nothing to migrate " . $migrationName;
            }
        }
    }

    /**
     *
     */
    private function down()
    {
        $this->setMigrationsFilesDown();
        foreach($this->migrationsFiles as $file) {
            $migrationName =  $this->getMigrationName($file);
            $className = $this->getClassName($migrationName);

            if ($this->existInBase($migrationName)) {
                include_once ($file);
                $class = new $className();
                $action = "down";
                $this->pdo->query($class->$action());
                $this->deleteMigrations($migrationName);

                echo "Rollback to migrate " . $migrationName;
            } else {
                echo "Migrate is not exist " . $migrationName;
            }
        }
    }

    /**
     * @param string $migrationName
     * @return bool
     */
    private function existInBase(string $migrationName): bool
    {
        $stmt = $this->pdo->prepare('SELECT id FROM versions WHERE name = :name');
        $stmt->bindValue(':name', $migrationName);
        $stmt->execute();

        return !empty($stmt->fetch()) ? true : false;
    }

    /**
     * @param string $migrationName
     */
    public function addMigrations(string $migrationName): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO versions (name) VALUES (:name)");
        $stmt->bindParam(':name',  $migrationName);
        $stmt->execute();
    }

    /**
     * @param string $migrationName
     */
    private function deleteMigrations(string $migrationName): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM versions WHERE name = :name");
        $stmt->bindValue(':name', $migrationName);
        $stmt->execute();
    }

    private function setMigrationsFilesDown(): void
    {
        if ($this->count > 1) {
            $countFiles = count($this->migrationsFiles);
            $this->migrationsFiles = array_slice($this->migrationsFiles,
                ($countFiles - $this->count - 1),
                $countFiles - 1
            );
        }
    }

    /**
     * @param string $migrationName
     * @return string
     */
    private function getClassName(string $migrationName): string
    {
        $className = '';
        foreach ($this->getDataClass($migrationName) as $value) {
            $className .= ucfirst($value);
        }

        return $className;
    }

    /**
     * @param string $path
     * @return string
     */
    private function getMigrationName(string $path): string
    {
        return array_shift(explode('.php', $this->getFileName($path)));
    }

    /**
     * @param string $path
     * @return string
     */
    private function getFileName(string $path): string
    {
        return array_pop(explode(DIRECTORY_SEPARATOR, $path));
    }

    /**
     * @param string $migrationName
     * @return array
     */
    private function getDataClass(string $migrationName): array
    {
        $dataClass = explode("_", $migrationName);

        return array_slice($dataClass, 1, count($dataClass));
    }
}