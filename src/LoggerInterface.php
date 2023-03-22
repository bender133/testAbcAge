<?php

declare(strict_types=1);


namespace App;

interface LoggerInterface {

  public function getErrors(): array;

  public function setError(string $field, string $string): void;

  public function hasErrors(): bool;

}