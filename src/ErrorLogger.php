<?php

declare(strict_types=1);


namespace App;

class ErrorLogger implements LoggerInterface {

  public array $errors = [];

  public function setError(string $field, string $string): void {
    $this->errors[] = [$field . ' - ' . $string];
  }

  public function hasErrors(): bool {
    return !empty($this->errors);
  }

  /**
   * @return array
   */
  public function getErrors(): array {
    return $this->errors;
  }

}