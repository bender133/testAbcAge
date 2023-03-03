<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;
use DateTimeInterface;

class PriceHelper {

  private const START_DATE = '2021-01-13';

  public static function salesHistory(int $daysQount): int {
    $fib = [0, 1];

    if ($daysQount <= 0) {
      return 0;
    }

    if ($daysQount >= 2) {
      for ($i = 2; $i <= $daysQount; $i++) {
        $fib[$i] = $fib[$i - 1] + $fib[$i - 2];
      }
    }
    return array_sum($fib);
  }

  public static function dayCount(DateTimeInterface $date): int {
    $dateStart = new DateTimeImmutable(self::START_DATE);
    return (int) $dateStart->diff($date)->format('%R%a');
  }

  public static function getPrice(array $offerData, int $salarySumm, array $quantity): float {

    if (!empty($quantity)) {

      $count = $quantity[0];
      foreach ($quantity as $key => $value) {
        if ($count === $salarySumm) {
          return isset($quantity[$key + 1]) ? $offerData[$key + 1]['price'] : 0;
        }

        if ($count > $salarySumm) {
          return (int) $offerData[$key]['price'];
        }

        if (isset($quantity[$key + 1])) {
          $count += $quantity[$key + 1];
        }

      }
    }
    return 0;
  }

}