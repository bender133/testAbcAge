<?php

declare(strict_types=1);


namespace App;

class ErrorLogger implements LoggerInterface {

  private array $errors = [];

  private static LoggerInterface $logger;

  public static function getLogger(): LoggerInterface {
    if (!isset(self::$logger)) {
      self::$logger = new self();
    }
    return self::$logger;
  }

  private function __construct() {
  }

  private function __clone() {
  }

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