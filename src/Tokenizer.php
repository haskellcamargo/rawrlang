<?php
  require_once "Lexer.php";
  require_once "Verifier.php";

  class Tokenizer extends Lexer
  {
    const T_IDENT         = 2; # REMOVE
    const T_DEDENT        = 3; # REMOVE
    const T_ABSTRACT      = 4; # DONE
    const T_AND_EQUAL     = 5;
    const T_CAST          = 6;
    const T_AS            = 7; # DONE
    const T_BAD_CHARACTER = 8;
    const T_BOOLEAN_AND   = 9;
    const T_BOOLEAN_OR    = 10;
    const T_STOP          = 11; # DONE
    const T_WHEN          = 12; # DONE
    const T_RESCUE        = 13; # DONE
    const T_BLUEPRINT     = 14; # DONE
    const T_CLONE         = 15; # DONE
    const T_COMMENT       = 16;
    const T_CONCAT_EQUAL  = 17;
    const T_CONST         = 18; # DONE
    const T_STRING        = 19; # DONE
    const T_LOOP          = 20; # DONE
    const T_DECLARE       = 21; # DONE
    const T_OTHERWISE     = 22; # DONE
    const T_DIV_EQUAL     = 23;
    const T_NUMBER        = 24; # DONE
    const T_INTEGER       = 25; # REMOVE
    const T_DOCCOMMENT    = 26;
    const T_DO            = 27; # DONE
    const T_DOUBLE_ARROW  = 28; # REMOVE
    const T_STATIC_ACCESS = 29; # DONE
    const T_ELLIPSIS      = 30; 
    const T_ELSE          = 31; # DONE
    const T_ELIF          = 32; # DONE
    const T_WHITESPACE    = 33;
    const T_EXIT          = 34;
    const T_INHERIT       = 35;
    const T_FINAL         = 36; # DONE
    const T_FINALLY       = 37; # DONE
    const T_FOR           = 38; # DONE
    const T_FROM          = 39; # DONE
    const T_ITERATE       = 40; # DONE
    const T_LAMBDA        = 41; # DONE
    const T_DEFINE        = 42; # DONE
    const T_EXPOSED       = 43; # DONE
    const T_GOTO          = 44; # DONE
    const T_IF            = 45; # DONE
    const T_CONTRACT      = 46; # DONE
    const T_WITH          = 47; # DONE
    const T_INCLUDE       = 48; # DONE
    const T_INCLUDE_ONCE  = 49; # DONE
    const T_REQUIRE       = 50; # DONE
    const T_REQUIRE_ONCE  = 51; # DONE
    const T_BASED         = 52; # DONE
    const T_INSTEADOF     = 53;
    const T_FUZZY_EQUAL   = 54; # DONE
    const T_STRICT_EQUAL  = 55; # DONE
    const T_GREATER_OR_EQ = 56; # DONE
    const T_NOT           = 57; # DONE
    const T_DIFFERENT     = 58;
    const T_STRICT_DIFF   = 59;
    const T_SMALLER_OR_EQ = 60; # REMOVE
    const T_SMALLER       = 61; # REMOVE
    const T_LIST          = 62; # REMOVE
    const T_LOGICAL_AND   = 63;
    const T_LOGICAL_OR    = 64;
    const T_LOGICAL_XOR   = 65;
    const T_METHOD        = 66; # DONE
    const T_MINUS_EQ      = 67;
    const T_MOD_EQ        = 68;
    const T_ASSIGN        = 69; # DONE
    const T_MUL_EQ        = 70;
    const T_MODULE        = 71; # DONE
    const T_NS_SEPARATOR  = 72;
    const T_NEW           = 73; # DONE
    const T_OBJECT_OP     = 74;
    const T_OR_EQ         = 75;
    const T_PLUS_EQ       = 76;
    const T_POW           = 77;
    const T_POW_EQ        = 78;
    const T_MY            = 79; # DONE
    const T_SHARED        = 80; # DONE
    const T_PROTECTED     = 81; # DONE
    const T_RETURN        = 82; # DONE
    const T_SL            = 83;
    const T_SL_EQ         = 84;
    const T_SR            = 85;
    const T_SR_EQ         = 86;
    const T_STATIC        = 87; # DONE
    const T_IDENTIFIER    = 88;
    const T_SWITCH        = 89; # DONE
    const T_RAISE         = 90; # DONE
    const T_TRAIT         = 91;
    const T_TRY           = 92; # DONE
    const T_LET           = 93; # DONE
    const T_WHILE         = 94; # DONE
    const T_XOR_EQ        = 95; 
    const T_YIELD         = 96; # DONE
    const T_PIPE          = 97; # DONE
    const T_CHAIN         = 98; # DONE
    const T_ARRAY_ACESS   = 99; # DONE
    const T_DOUBLE_COLON  = 100; # DONE
    const T_LPAREN        = 101; # DONE
    const T_RPAREN        = 102; # DONE
    const T_LBRACKET      = 103; # DONE
    const T_RBRACKET      = 104; # DONE
    const T_AT            = 105; # REMOVE
    const T_THEN          = 106; # DONE
    const T_THIS          = 107; # DONE
    const T_END           = 108; # DONE
    const T_PLUS          = 109; # DONE
    const T_MINUS         = 110; # DONE
    const T_DIVISION      = 111; # DONE
    const T_TIMES         = 112; # DONE
    const T_EXP           = 113;
    const T_MOD           = 114; # DONE
    const T_NEWLINE       = 115; # DONE
    const T_TILDE         = 116; # DONE
    const T_COMMA         = 117; # DONE
    const T_DOT           = 118; # DONE
    const T_SEMICOLON     = 119; # DONE
    const T_GREATER       = 120; # DONE
    const T_LESSER        = 121; # DONE
    const T_LESSER_OR_EQ  = 122; # DONE
    const T_CALL          = 123; # DONE
    const T_EXPLODE       = 124; # DONE
    const T_LBRACE        = 125; # DONE
    const T_RBRACE        = 126; # DONE
    const T_CYPHER        = 127; # DONE
    const T_AND           = 128; # DONE
    const T_OR            = 129; # DONE
    const T_XOR           = 130; # DONE
    const T_RECORD        = 131; # DONE
    const T_PUSH          = 132; # DONE
    const T_NULL          = 133; # DONE
    const T_CONSTRUCTOR   = 134; # DONE
    const T_REPLICATE     = 135; # DONE
    const T_TRUE          = 136; # DONE
    const T_FALSE         = 137; # DONE

    public static $keyword = [
      "module"      => self::T_MODULE,
      "define"      => self::T_DEFINE,
      "let"         => self::T_LET,
      "end"         => self::T_END,
      "blueprint"   => self::T_BLUEPRINT,
      "my"          => self::T_MY,
      "shared"      => self::T_SHARED,
      "method"      => self::T_METHOD,
      "if"          => self::T_IF,
      "else"        => self::T_ELSE,
      "elif"        => self::T_ELIF,
      "abstract"    => self::T_ABSTRACT,
      "and"         => self::T_AND,
      "or"          => self::T_OR,
      "xor"         => self::T_XOR,
      "like"        => self::T_FUZZY_EQUAL,
      "is"          => self::T_STRICT_EQUAL,
      "with"        => self::T_WITH,
      "contract"    => self::T_CONTRACT,
      "record"      => self::T_RECORD,
      "return"      => self::T_RETURN,
      "iterate"     => self::T_ITERATE,
      "as"          => self::T_AS,
      "for"         => self::T_FOR,
      "null"        => self::T_NULL,
      "constructor" => self::T_CONSTRUCTOR,
      "try"         => self::T_TRY,
      "raise"       => self::T_RAISE,
      "finally"     => self::T_FINALLY,
      "rescue"      => self::T_RESCUE,
      "while"       => self::T_WHILE,
      "otherwise"   => self::T_OTHERWISE,
      "switch"      => self::T_SWITCH,
      "when"        => self::T_WHEN,
      "static"      => self::T_STATIC,
      "loop"        => self::T_LOOP,
      "stop"        => self::T_STOP,
      "then"        => self::T_THEN,
      "True"        => self::T_TRUE,
      "False"       => self::T_FALSE,
      "exit"        => self::T_EXIT,
      "yield"       => self::T_YIELD,
      "mod"         => self::T_MOD,
      "final"       => self::T_FINAL,
      "goto"        => self::T_GOTO,
      "exposed"     => self::T_EXPOSED,
      "inherit"     => self::T_INHERIT,
      "do"          => self::T_DO,
      "clone"       => self::T_CLONE,
      "require"     => self::T_REQUIRE,
      "include"     => self::T_INCLUDE,
      "protected"   => self::T_PROTECTED,
      "const"       => self::T_CONST,
      "based"       => self::T_BASED,
      "not"         => self::T_NOT,
      "declare"     => self::T_DECLARE
    ];

    public static $composedKeyword = [
      "is not" => self::T_STRICT_DIFF,
      "like not"     => self::T_DIFFERENT,
      "require once" => self::T_REQUIRE_ONCE,
      "include once" => self::T_INCLUDE_ONCE
    ];

    public static $hygienize = [
      "class", "function", "list", "foreach", "implements", "extends"
    ];

    public static $tokenNames = [
      "n/a", "EOF", "T_IDENT", "T_DEDENT", "T_ABSTRACT", "T_AND_EQUAL",
      "T_CAST", "T_AS", "T_BAD_CHARACTER", "T_BOOLEAN_AND", "T_BOOLEAN_OR",
      "T_STOP", "T_WHEN", "T_RESCUE", "T_BLUEPRINT", "T_CLONE", "T_COMMENT",
      "T_CONCAT_EQUAL", "T_CONST", "T_STRING", "T_LOOP", "T_DECLARE",
      "T_OTHERWISE", "T_DIV_EQUAL", "T_NUMBER", "T_INTEGER", "T_DOCCOMMENT",
      "T_DO", "T_DOUBLE_ARROW", "T_STATIC_ACCESS", "T_ELLIPSIS", "T_ELSE",
      "T_ELIF", "T_WHITESPACE", "T_EXIT", "T_INHERIT", "T_FINAL", "T_FINALLY",
      "T_FOR", "T_FROM", "T_ITERATE", "T_LAMBDA", "T_DEFINE", "T_EXPOSED",
      "T_GOTO", "T_IF", "T_CONTRACT", "T_WITH", "T_INCLUDE", "T_INCLUDE_ONCE",
      "T_REQUIRE", "T_REQUIRE_ONCE", "T_BASED", "T_INSTEADOF",
      "T_FUZZY_EQUAL", "T_STRICT_EQUAL", "T_GREATER_OR_EQ", "T_NOT",
      "T_DIFFERENT", "T_STRICT_DIFF", "T_SMALLER_OR_EQ", "T_SMALLER", "T_LIST",
      "T_LOGICAL_AND", "T_LOGICAL_OR", "T_LOGICAL_XOR", "T_METHOD",
      "T_MINUS_EQ", "T_MOD_EQ", "T_ASSIGN", "T_MUL_EQ", "T_MODULE",
      "T_NS_SEPARATOR", "T_NEW", "T_OBJECT_OP", "T_OR_EQ", "T_PLUS_EQ", "T_POW",
      "T_POW_EQ", "T_MY", "T_SHARED", "T_PROTECTED", "T_RETURN", "T_SL",
      "T_SL_EQ", "T_SR", "T_SR_EQ", "T_STATIC", "T_IDENTIFIER", "T_SWITCH",
      "T_RAISE", "T_TRAIT", "T_TRY", "T_LET", "T_WHILE", "T_XOR_EQ", "T_YIELD",
      "T_PIPE", "T_CHAIN", "T_ARRAY_ACESS", "T_DOUBLE_COLON", "T_LPAREN",
      "T_RPAREN", "T_LBRACKET", "T_RBRACKET", "T_AT", "T_THEN", "T_THIS",
      "T_END", "T_PLUS", "T_MINUS", "T_DIVISION", "T_TIMES", "T_EXP", "T_MOD",
      "T_NEWLINE", "T_TILDE", "T_COMMA", "T_DOT", "T_SEMICOLON", "T_GREATER",
      "T_LESSER", "T_LESSER_OR_EQ", "T_CALL", "T_EXPLODE", "T_LBRACE",
      "T_RBRACE", "T_CYPHER", "T_AND", "T_OR", "T_XOR", "T_RECORD", "T_PUSH",
      "T_NULL", "T_CONSTRUCTOR", "T_REPLICATE", "T_TRUE", "T_FALSE"
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
          case "\r":
          case "\r\n":
            $this->consume();
            return $this->newLine();
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
            $this->consume();
            continue;
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
          case "*":
            return $this->checkAsteriskOperator();
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

      if (array_key_exists($buffer, self::$keyword)) {
        return new Token(self::$keyword[$buffer], $buffer);
      }

      if ($this->char == "[" && $this->ahead() == "]") {
        $this->consume();
        $this->consume();
        return new Token(self::T_PUSH, $buffer);
      }

      if (in_array($buffer, self::$hygienize))
        $buffer = "_" . $buffer;

      return new Token(self::T_IDENTIFIER, $buffer);
    }

    private function checkDoubleColon()
    {
      $this->consume();
      if ($this->char == ":") {
        $this->consume();
        return new Token(self::T_STATIC_ACCESS, "::");
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
      } else if (ctype_alpha($this->char) || $this->char == "_") {
        return new Token(self::T_NEW, "+");
      }
      return new Token(self::T_PLUS, "+");
    }

    private function checkMinusOperator()
    {
      $this->consume();
      if ($this->char == "=") {
        $this->consume();
        return new Token(self::T_MINUS_EQ, "-=");
      } else if ($this->char == ">") {
        $this->consume();
        return new Token(self::T_LAMBDA, "->");
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

    private function newLine()
    {
      while ($this->char == "\n"
          || $this->char == "\r"
          || $this->char == "\r\n") {
        $this->consume();
      }
      return new Token(self::T_NEWLINE, "");
    }

    private function checkAsteriskOperator()
    {
      $this->consume();
      if ($this->char == " ")
        $this->optional(" ", self::T_WHITESPACE);

      return new Token(($this->char == "\"" ? self::T_REPLICATE
                                            : self::T_TIMES
                      ), "*");
    }
  }
