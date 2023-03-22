<?php

declare(strict_types=1);


namespace App;

use JetBrains\PhpStorm\NoReturn;

class JsoneHttpResponse implements ResponseInterface {

  /**
   * @throws \JsonException
   */
  #[NoReturn] public function response(array $data = [], array $errors = [], int $statusCode = 200): void {
    header('Access-Control-Allow-Origin: *', TRUE, $statusCode);
    echo json_encode(
      [
        'errors' => $errors,
        'data' => $data,
      ], JSON_THROW_ON_ERROR);
    exit();
  }

}