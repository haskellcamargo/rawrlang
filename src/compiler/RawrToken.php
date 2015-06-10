<?php

namespace Compiler
{
  ini_set('display_startup_errors',1);
  ini_set('display_errors',1);
  error_reporting(-1);

  class RawrToken
  {
    private $name;
    private $value;

    public function __construct(int $name, $value)
    {
      $this->name = $name;
      $this->value = $value;
    }
  }
}