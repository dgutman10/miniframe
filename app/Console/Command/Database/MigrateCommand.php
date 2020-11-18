<?php

namespace App\Console\Command\Database;


use PDO;
use PDOException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
{
    private $connection;
    private $dbParams;
    protected static $defaultName = 'database:migrate';

    protected function configure()
    {
        $this->dbParams = config('database');
        $this->setDescription('Database migration tool');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->createDatabase($output);
            $this->createTables($output);

            return Command::SUCCESS;
        } catch (\Exception $exception) {

            return Command::FAILURE;
        }
    }

    private function createDatabase($output)
    {
        $output->writeln("<info>Creando base de datos...</info>");
        $connection = new PDO(
            "mysql:host={$this->dbParams['host']}",
            $this->dbParams['user'],
            $this->dbParams['passwd']);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->exec("DROP DATABASE IF EXISTS {$this->dbParams['dbname']}");
        $connection->exec("CREATE DATABASE glammit DEFAULT CHARACTER SET utf8");

        $this->connection = new PDO(
            "mysql:dbname={$this->dbParams['dbname']};host={$this->dbParams['host']}",
            $this->dbParams['user'],
            $this->dbParams['passwd']
        );
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createTables($output)
    {
        $output->writeln("<info>Creando tablas...</info>");

        $this->connection->exec("
            CREATE TABLE categories (
              id int(11) NOT NULL AUTO_INCREMENT,
              nombre varchar(45) NOT NULL,
              PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");

        $this->connection->exec("
            CREATE TABLE products (
              id int(11) NOT NULL AUTO_INCREMENT,
              nombre varchar(45) NOT NULL,
              categoria int(11) NOT NULL,
              precio float NOT NULL,
              imagen_url text NOT NULL,
              sku varchar(45) NOT NULL,
              PRIMARY KEY (id),
              KEY categoria (categoria),
              CONSTRAINT products FOREIGN KEY (categoria) REFERENCES categories (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }
}