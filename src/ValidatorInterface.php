<?php

declare(strict_types=1);


namespace App;

interface ValidatorInterface {
public function validate(array $data): bool;
}