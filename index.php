<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use App\ArgumentResolver;
use App\ArgumentValidator;
use App\InitOffersCommand;
use App\Offers;
use App\PriceHelper;
use App\Products;
use App\Response;

$error = [];
$data = [];
(new InitOffersCommand())->execute();
$httpStatusCode = 200;
$offers = new Offers();

$params = (new ArgumentResolver())->resolve();
$validator = new ArgumentValidator();
$validator->validate($params);

if (!$validator->hasErrors()) {
  $productId = (new Products())->getProductIdByName($params[ArgumentResolver::PRODUCT_NAME]);
  $date = new DateTime($params[ArgumentResolver::DATE]);
  $offersData = $offers->getOffers($date->format('Y-m-d H:i:s:'), $productId);
  $quantity = array_column($offersData, 'quantity');

  $quantityInStock = (int) array_sum($quantity);
  $dayCount = PriceHelper::dayCount($date);
  $salarySumm = PriceHelper::salesHistory($dayCount);

  $data = [
    'price' => PriceHelper::getPrice($offersData, $salarySumm, $quantity),
    'products_balance' => max($quantityInStock - $salarySumm, 0),
  ];
}
else {
  $error = $validator->getErrors();
  $httpStatusCode = 400;
}

(new Response())->send($data, $error, $httpStatusCode);
