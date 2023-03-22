<?php


namespace App;

use PDO;

class Offers {

  private ConnectionInterface|PDO $connection;

  public function __construct(ConnectionInterface $connection) {

    $this->connection = $connection;
  }

  public function getOffers(string $date, int $productId): array {
    $sth = $this->connection->prepare(
      "select price, quantity, delivery_date
                                from offers
                                where product_id = :product_id
                                AND `delivery_date` <= :delivery_date
                                order by delivery_date"
    );
    $sth->execute([
      'product_id' => $productId,
      'delivery_date' => $date,
    ]);

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

}
