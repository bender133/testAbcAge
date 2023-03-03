<?php


namespace App;

use PDO;

class Offers {

  public function getOffers(string $date, int $productId): array {
    $dbh = DBConnection::getConnection();
    $sth = $dbh->prepare(
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
