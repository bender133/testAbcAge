<?php

declare(strict_types=1);


namespace App;

class ArgumentValidator implements ValidatorInterface {

  public const REQUIRED_FIELDS = [
    ArgumentResolver::DATE,
    ArgumentResolver::PRODUCT_NAME,
  ];

  /**
   * @var \App\LoggerInterface
   */
  private LoggerInterface $logger;


  public function __construct(LoggerInterface $logger) {

    $this->logger = $logger;
  }

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
      $this->logger->setError(ArgumentResolver::DATE, 'Некорректная дата.');
      $result = FALSE;
    }

    if ($dateString > $dateMaxString) {
      $this->logger->setError(ArgumentResolver::DATE, 'Дата не может быть больше текущей.');
      $result = FALSE;
    }

    return $result;
  }

  private function validateRequired(array $data): bool {
    $result = TRUE;

    foreach (self::REQUIRED_FIELDS as $field) {
      if (empty($data[$field])) {
        $this->logger->setError($field, 'Обязательное поле.');

        $result = FALSE;
      }
    }

    return $result;
  }

}