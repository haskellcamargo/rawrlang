<?php
  require_once "Tokenizer.php";
  require_once "Token.php";

  $source = file_get_contents($argv[1]);

  $lexer = new Tokenizer($source);
  $token = $lexer->nextToken();

  while ($token->type != 1) {
    echo $token . "\n";
    $token = $lexer->nextToken();
  }