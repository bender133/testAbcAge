<?php

declare(strict_types=1);


namespace App;

class ArgumentResolver {

  public const DATE = 'date';

  public const PRODUCT_NAME = 'poduct_name';

  public function resolve(): array {
    $params = $_GET;

    return [
      self::DATE => $params['date'] ?? NULL,
      self::PRODUCT_NAME => empty($params['product_name']) ? NULL : $this->normalizeString($params['product_name']),
    ];
  }

  private function normalizeString(string $string): string {
    return trim(htmlspecialchars($string));
  }

}