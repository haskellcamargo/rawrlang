<?php
  require_once "Tokenizer.php";
  require_once "Token.php";

  $lexer = new Tokenizer($argv[1]);
  $token = $lexer->nextToken();

  while ($token->type != 1) {
    echo $token . "\n";
    $token = $lexer->nextToken();
  }