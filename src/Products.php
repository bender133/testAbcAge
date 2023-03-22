<?php

declare(strict_types=1);


namespace App;

use PDO;

class Products {

  /**
   * @var \App\ConnectionInterface|PDO
   */
  private ConnectionInterface|PDO $connection;

  public function __construct(ConnectionInterface $connection) {

    $this->connection = $connection;
  }

  public function getProductIdByName(string $name): int {
    $sth = $this->connection->prepare("select id from products WHERE `name` = ?");
    $sth->execute([$name]);
    return (int) $sth->fetchColumn();
  }

}