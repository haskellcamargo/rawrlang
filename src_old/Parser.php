<?php
  require_once "ParserBase.php";

  class Parser extends BaseParser
  {
    public function __construct(Lexer $input)
    {
      parent::__construct($input);
    }
  }