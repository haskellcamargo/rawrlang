<?php
  require_once "Lexer.php";
  require_once "Verifier.php";

  class Tokenizer extends Lexer
  {
    const T_IDENT         = 2;
    const T_DEDENT        = 3;
    const T_ABSTRACT      = 4;
    const T_AND_EQUAL     = 5;
    const T_CAST          = 6;
    const T_AS            = 7;
    const T_BAD_CHARACTER = 8;
    const T_BOOLEAN_AND   = 9;
    const T_BOOLEAN_OR    = 10;
    const T_BREAK         = 11;
    const T_WHEN          = 12;
    const T_CATCH         = 13;
    const T_CLASS         = 14;
    const T_CLONE         = 15;
    const T_COMMENT       = 16;
    const T_CONCAT_EQUAL  = 17;
    const T_CONST         = 18;
    const T_STRING        = 19;
    const T_CONTINUE      = 20;
    const T_DECLARE       = 21;
    const T_OTHERWISE     = 22;
    const T_DIV_EQUAL     = 23;
    const T_NUMBER        = 24;
    const T_INTEGER       = 25;
    const T_DOCCOMMENT    = 26;
    const T_DO            = 27;
    const T_DOUBLE_ARROW  = 28;
    const T_STATIC_ACCESS = 29;
    const T_ELLIPSIS      = 30;
    const T_ELSE          = 31;
    const T_ELIF          = 32;
    const T_WHITESPACE    = 33;
    const T_EXIT          = 34;
    const T_INHERIT       = 35;
    const T_FINAL         = 36;
    const T_FINALLY       = 37;
    const T_FOR           = 38;
    const T_FROM          = 39;
    const T_ITERATE       = 40;
    const T_LAMBDA        = 41;
    const T_DEFUN         = 42;
    const T_GLOBAL        = 43;
    const T_GOTO          = 44;
    const T_IF            = 45;
    const T_CONTRACT      = 46;
    const T_WITH          = 47;
    const T_INCLUDE       = 48;
    const T_INCLUDE_ONCE  = 49;
    const T_REQUIRE       = 50;
    const T_REQUIRE_ONCE  = 51;
    const T_INSTANCEOF    = 52;
    const T_INSTEADOF     = 53;
    const T_FUZZY_EQUAL   = 54;
    const T_STRICT_EQUAL  = 55;
    const T_GREATER_OR_EQ = 56;
    const T_NOT           = 57;
    const T_DIFFERENT     = 58;
    const T_STRICT_DIFF   = 59;
    const T_SMALLER_OR_EQ = 60;
    const T_SMALLER       = 61;
    const T_LIST          = 62;
    const T_LOGICAL_AND   = 63;
    const T_LOGICAL_OR    = 64;
    const T_LOGICAL_XOR   = 65;
    const T_METHOD        = 66;
    const T_MINUS_EQ      = 67;
    const T_MOD_EQ        = 68;
    const T_ASSIGN        = 69;
    const T_MUL_EQ        = 70;
    const T_NS            = 71;
    const T_NS_SEPARATOR  = 72;
    const T_NEW           = 73;
    const T_OBJECT_OP     = 74;
    const T_OR_EQ         = 75;
    const T_PLUS_EQ       = 76;
    const T_POW           = 77;
    const T_POW_EQ        = 78;
    const T_MY            = 79;
    const T_SHARED        = 80;
    const T_PROTECTED     = 81;
    const T_RETURN        = 82;
    const T_SL            = 83;
    const T_SL_EQ         = 84;
    const T_SR            = 85;
    const T_SR_EQ         = 86;
    const T_STATIC        = 87;
    const T_IDENTIFIER    = 88;
    const T_SWITCH        = 89;
    const T_RAISE         = 90;
    const T_TRAIT         = 91;
    const T_TRY           = 92;
    const T_LET           = 93;
    const T_WHILE         = 94;
    const T_XOR_EQ        = 95;
    const T_YIELD         = 96;
    const T_PIPE          = 97;
    const T_CHAIN         = 98;
    const T_ARRAY_ACESS   = 99;
    const T_DOUBLE_COLON  = 100;
    const T_LPAREN        = 101;
    const T_RPAREN        = 102;
    const T_LBRACKET      = 103;
    const T_RBRACKET      = 104;
    const T_AT            = 105;
    const T_THEN          = 106;
    const T_THIS          = 107;
    const T_END           = 108;
    const T_PLUS          = 109;
    const T_MINUS         = 110;
    const T_DIVISION      = 111;
    const T_TIMES         = 112;
    const T_EXP           = 113;
    const T_MOD           = 114;
    const T_NEWLINE       = 115;
    const T_TILDE         = 116;
    const T_COMMA         = 117;
    const T_DOT           = 118;
    const T_SEMICOLON     = 119;
    const T_GREATER       = 120;
    const T_LESSER        = 121;
    const T_LEXER_OR_EQ   = 122;
    const T_CALL          = 123;
    const T_EXPLODE       = 124;
    const T_LBRACE        = 125;
    const T_RBRACE        = 126;
    const T_CYPHER        = 127;

    public static $tokenNames = [
      "n/a", "EOF", "T_IDENT", "T_DEDENT", "T_ABSTRACT", "T_AND_EQUAL",
      "T_CAST", "T_AS", "T_BAD_CHARACTER", "T_BOOLEAN_AND", "T_BOOLEAN_OR",
      "T_BREAK", "T_WHEN", "T_CATCH", "T_CLASS", "T_CLONE", "T_COMMENT",
      "T_CONCAT_EQUAL", "T_CONST", "T_STRING", "T_CONTINUE", "T_DECLARE",
      "T_OTHERWISE", "T_DIV_EQUAL", "T_NUMBER", "T_INTEGER", "T_DOCCOMMENT",
      "T_DO", "T_DOUBLE_ARROW", "T_STATIC_ACCESS", "T_ELLIPSIS", "T_ELSE",
      "T_ELIF", "T_WHITESPACE", "T_EXIT", "T_INHERIT", "T_FINAL", "T_FINALLY",
      "T_FOR", "T_FROM", "T_ITERATE", "T_LAMBDA", "T_DEFUN", "T_GLOBAL",
      "T_GOTO", "T_IF", "T_CONTRACT", "T_WITH", "T_INCLUDE", "T_INCLUDE_ONCE",
      "T_REQUIRE", "T_REQUIRE_ONCE", "T_INSTANCEOF", "T_INSTEADOF",
      "T_FUZZY_EQUAL", "T_STRICT_EQUAL", "T_GREATER_OR_EQ", "T_NOT",
      "T_DIFFERENT", "T_STRICT_DIFF", "T_SMALLER_OR_EQ", "T_SMALLER", "T_LIST",
      "T_LOGICAL_AND", "T_LOGICAL_OR", "T_LOGICAL_XOR", "T_METHOD",
      "T_MINUS_EQ", "T_MOD_EQ", "T_ASSIGN", "T_MUL_EQ", "T_NS",
      "T_NS_SEPARATOR", "T_NEW", "T_OBJECT_OP", "T_OR_EQ", "T_PLUS_EQ", "T_POW",
      "T_POW_EQ", "T_MY", "T_SHARED", "T_PROTECTED", "T_RETURN", "T_SL",
      "T_SL_EQ", "T_SR", "T_SR_EQ", "T_STATIC", "T_IDENTIFIER", "T_SWITCH",
      "T_RAISE", "T_TRAIT", "T_TRY", "T_LET", "T_WHILE", "T_XOR_EQ", "T_YIELD",
      "T_PIPE", "T_CHAIN", "T_ARRAY_ACESS", "T_DOUBLE_COLON", "T_LPAREN",
      "T_RPAREN", "T_LBRACKET", "T_RBRACKET", "T_AT", "T_THEN", "T_THIS",
      "T_END", "T_PLUS", "T_MINUS", "T_DIVISION", "T_TIMES", "T_EXP", "T_MOD",
      "T_NEWLINE", "T_TILDE", "T_COMMA", "T_DOT", "T_SEMICOLON", "T_GREATER",
      "T_LESSER", "T_LESSER_OR_EQ", "T_CALL", "T_EXPLODE", "T_LBRACE",
      "T_RBRACE", "T_CYPHER"
    ];


    public function __construct($input)
    {
      parent::__construct($input);
    }

    public function getTokenName($name)
    {
      return self::$tokenNames[$name];
    }

    public function nextToken()
    {
      while ($this->char != self::EOF) {
        switch ($this->char) {
          // Return here.
          case "\n":
            $this->consume();
            return new Token(self::T_NEWLINE, "");
          case ".":
            $this->consume();
            return new Token(self::T_DOT, ".");
          case "(":
            $this->consume();
            return new Token(self::T_LPAREN, "(");
          case ")":
            $this->consume();
            return new Token(self::T_RPAREN, ")");
          case "[":
            $this->consume();
            return new Token(self::T_LBRACKET, "[");
          case "]":
            $this->consume();
            return new Token(self::T_RBRACKET, "]");
          case ",":
            $this->consume();
            return new Token(self::T_COMMA, ",");
          case "@":
            $this->consume();
            return new Token(self::T_THIS, "@");
          case ";":
            $this->consume();
            return new Token(self::T_SEMICOLON, ";");
          case "{":
            $this->consume();
            return new Token(self::T_LBRACE, "{");
          case "}":
            $this->consume();
            return new Token(self::T_RBRACE, "}");
          case "|":
            $this->consume();
            return new Token(self::T_PIPE, "|");
          case "$":
            $this->consume();
            return new Token(self::T_CYPHER, "$");
          case ">":
            return $this->checkGreaterOperator();
          case "<":
            return $this->checkLesserOperator();
          case "~":
            return $this->checkTilde();
          case "+":
            return $this->checkPlusOperator();
          case "-":
            return $this->checkMinusOperator();
          case " ":
            return $this->T_WHITESPACE();
          case ":":
            return $this->checkDoubleColon();
          case "=":
            return $this->checkEqualOperator();
          case "\"":
            return $this->checkString();
          case "!":
            return $this->checkExclamationOperator();
          case "/":
            return $this->checkSlashOperator();
          default:
            if (Verifier::startIdentifier($this->char)) {
              return $this->checkIdentifier();
            } else if (Verifier::startNumber($this->char)) {
              return $this->checkNumber();
            }
            echo "Ooops. Unexpected '{$this->char}'\n";
            exit;
        }
      }
      return new Token(self::EOF_TYPE, "[EOF]");
    }

    private function checkIdentifier()
    {
      $buffer = $this->char;
      $this->consume();
      while (Verifier::startIdentifier($this->char)) {
        $buffer .= $this->char;
        $this->consume();
      }

      switch ($buffer) {
        case "namespace":
          return new Token(self::T_NS, $buffer);
        case "switch":
          return new Token(self::T_SWITCH, $buffer);
        default:
          return new Token(self::T_IDENTIFIER, $buffer);
      }
    }

    private function T_WHITESPACE()
    {
      $this->consume();
      while ($this->char == " ")
        $this->consume();
      return new Token(self::T_WHITESPACE, " ");
    }

    private function checkDoubleColon()
    {
      $this->consume();
      if ($this->char == ":") {
        return new Token(self::T_STATIC_ACCESS, "::");
        $this->consume();
      }
      return new Token(self::T_DOUBLE_COLON, ":");
    }

    private function checkEqualOperator()
    {
      $this->consume();
      if ($this->char == "=") {
        $this->consume();
        return new Token(self::T_STRICT_EQUAL, "==");
      }
      return new Token(self::T_ASSIGN, "=");
    }

    private function checkTilde()
    {
      $this->consume();
      if ($this->char == "=") {
        $this->consume();
        return new Token(self::T_FUZZY_EQUAL, "~=");
      }
      return new Token(self::T_TILDE, "~");
    }

    private function checkNumber()
    {
      $buffer = $this->char;
      $this->consume();

      while (ctype_digit($this->char)) {
        $buffer .= $this->char;
        $this->consume();
      }

      if ($this->char == ".") {
        if (ctype_digit($this->ahead())) {
          $buffer .= ".";
          $this->consume();
          while (ctype_digit($this->char)) {
            $buffer .= $this->char;
            $this->consume();
          }
        }
      }

      return new Token(self::T_NUMBER, $buffer);
    }

    private function checkPlusOperator()
    {
      $this->consume();
      if ($this->char == "=") {
        $this->consume();
        return new Token(self::T_PLUS_EQ, "+=");
      }
      return new Token(self::T_PLUS, "+");
    }

    private function checkMinusOperator()
    {
      $this->consume();
      if ($this->char == "=") {
        $this->consume();
        return new Token(self::T_MINUS_EQ, "-=");
      }
      return new Token(self::T_MINUS, "-");
    }

    private function checkString()
    {
      $this->consume();
      $buffer = "";
      while ($this->char != "\"") {
        $buffer .= $this->char;
        $this->consume();
      }
      $this->consume();
      return new Token(self::T_STRING, $buffer);
    }

    private function checkGreaterOperator()
    {
      $this->consume();
      switch ($this->char) {
        case ">":
          $this->consume();
          return new Token(self::T_CHAIN, ">>");
        case "=":
          $this->consume();
          return new Token(self::T_GREATER_OR_EQ, ">=");
        default:
          return new Token(self::T_GREATER, ">");
      }
    }

    private function checkLesserOperator()
    {
      $this->consume();
      switch ($this->char) {
        case "=":
          $this->consume;
          return new Token(self::T_LESSER_OR_EQ, "<=");
        default:
          return new Token(self::T_LESSER, "<");
      }
    }

    private function checkExclamationOperator()
    {
      $this->consume();
      switch ($this->char) {
        case "!":
          $this->consume();
          return new Token(self::T_ARRAY_ACESS, "!!");
        default:
          return new Token(self::T_CALL, "!");
      }
    }

    private function checkSlashOperator()
    {
      $this->consume();

      if ($this->char == " ")
        $this->optional(" ", self::T_WHITESPACE);

      return new Token(($this->char == "\"" ? self::T_EXPLODE
                                            : self::T_DIVISION
                       ), "/");
    }
  }
