<?php

declare(strict_types=1);


namespace App;

class ArgumentValidator {

  public const REQUIRED_FIELDS = [
    ArgumentResolver::DATE,
    ArgumentResolver::PRODUCT_NAME,
  ];

  public array $errors = [];

  public function validate(array $data): bool {
    return $this->validateRequired($data) && $this->dateValidator($data);
  }

  private function dateValidator(array $data): bool {

    $result = TRUE;
    $date = $data['date'];
    $now = $data['now'] ?? 'now';

    $dateString = strtotime($date);
    $dateMaxString = strtotime($now);

    if (!$dateString) {
      $this->setErrors(ArgumentResolver::DATE, 'Некорректная дата.');
      $result = false;
    }

    if ($dateString > $dateMaxString) {
      $this->setErrors(ArgumentResolver::DATE, 'Дата не может быть больше текущей.');
      $result = false;
    }

    return $result;
  }

  /**
   * @return array
   */
  public function getErrors(): array {
    return $this->errors;
  }

  private function validateRequired(array $data): bool {
    $result = TRUE;

    foreach (self::REQUIRED_FIELDS as $field) {
      if (empty($data[$field])) {
        $this->setErrors($field, 'Обязательное поле.');

        $result = FALSE;
      }
    }

    return $result;
  }

  private function setErrors(mixed $field, string $string): void {
    $this->errors[] = [$field . ' - ' . $string];
  }

  public function hasErrors(): bool {
    return !empty($this->errors);
  }

}