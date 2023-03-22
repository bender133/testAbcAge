<?php

declare(strict_types=1);


namespace App;

interface CommandInterface {

  public function execute(): void;

}