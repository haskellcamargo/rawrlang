<?php
  require_once "Tokenizer.php";
  require_once "Token.php";
  require_once "Parser.php";

  $lexer = new Tokenizer($argv[1]);
  $parser = new Parser($lexer);
  $paser->parse();