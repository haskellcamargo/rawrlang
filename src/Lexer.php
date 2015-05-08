<?php
  abstract class Lexer
  {
    const EOF      = -1;
    const EOF_TYPE =  1;
    protected $input;
    protected $position = 0;
    protected $char;

    public function __construct($input)
    {
      $this->input = $input;
      $this->char = $input[$this->position];
    }

    public function consume()
    {
      $this->position++;
      if ($this->position >= strlen($this->input)) {
        $this->char = Lexer::EOF;
      } else {
        $this->char = $this->input[$this->position];
      }
    }

    public abstract function nextToken();
    public abstract function getTokenName($tokenType);
  }