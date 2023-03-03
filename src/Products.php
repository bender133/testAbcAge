<?php

declare(strict_types=1);


namespace App;

class Products {

  public function getProductIdByName(string $name): int {
    $dbh = DBConnection::getConnection();
    $sth = $dbh->prepare("select id from products WHERE `name` = ?");
    $sth->execute([$name]);
    return (int) $sth->fetchColumn();
  }

}