<?php

declare(strict_types=1);


namespace App;

use PDO;

class InitOffersCommand implements Command {

  private float $margin;

  public function __construct(float $margin = 1.3) {
    $this->margin = $margin;
  }

  public function execute(): void {
    $dbh = DBConnection::getConnection();
    $sth = $dbh->prepare("SELECT * FROM `deliveries` WHERE is_aprove = ?");
    $sth->execute([0]);
    $deliveries = $sth->fetchAll(PDO::FETCH_ASSOC);

    if ($deliveries) {
      foreach ($deliveries as $k => $delivery) {
        $sth = $dbh->prepare(
          "INSERT INTO `offers` 
                SET `quantity` = :quantity,
                    `delivery_date` = :delivery_date,
                    `product_id` = :product_id,
                    `delivery_id` = :delivery_id,
                    `price` = :price"
        );

        $sth->execute(
          [
            'quantity' => $delivery['quantity'],
            'delivery_date' => $delivery['date'],
            'delivery_id' => $delivery['id'],
            'product_id' => $delivery['product_id'],
            'price' => $delivery['quantity'] ? ($delivery['cost'] / $delivery['quantity']) * $this->margin : 0,
          ]
        );

        $sth = $dbh->prepare("UPDATE `deliveries` SET `is_aprove` = :aprove WHERE `id` = :id");
        $sth->execute(['aprove' => 1, 'id' => $delivery['id']]);
      }
    }
  }

}