<?php

namespace Compiler
{
  use \Exception;

  abstract class RawrLexerBase
  {
    const EOF = -1;

    protected $input;
    protected $position = 0;
    protected $char;

    public function __construct(string $input)
    {
      $this->input = $input;
      $this->char = $char;
    }

    public function lookNth(int $nth): string
    {
      $lookaheadToken = $this->input[$this->position + $nth] ?? -1;
      if ($lookaheadToken === -1) {
        throw new Exception;
      }
      return $lookaheadToken;
    }

    public function nextMatch(string $value): boolean
    {
      for ($i = 0, $len = strlen($value); $i < $len; $i++) {
        if ($this->lookNth($i) !== $value[$i]) {
          return false;
        }
      }
      return true;
    }

    public function eat(int $nth)
    {
      $this->position += $amount;
      if ($this->position >= strlen($this->input)) {
        $this->char = self::EOF;
      } else {
        $this->char = $this->input[$this->position];
      }
    }

    public abstract function nextToken();
  }
}