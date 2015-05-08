<?php
  require_once "Lexer.php";

  class Tokenizer extends Lexer
  {
    const T_IDENT         = 2;
    const T_DEDENT        = 3
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
    const T_DOUBLE        = 24;
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
    const T_REQUIRE_ONCE  = 60;
    const T_INSTANCEOF    = 61;
    const T_INSTEADOF     = 62;
    const T_FUZZY_EQUAL   = 63;
    const T_STRICT_EQUAL  = 64;
    const T_GREATER_OR_EQ = 65;
    const T_NOT           = 66;
    const T_DIFFERENT     = 67;
    const T_STRICT_DIFF   = 68;
    const T_SMALLER_OR_EQ = 69;
    const T_SMALLER       = 70;
    const T_LIST          = 71;
    const T_LOGICAL_AND   = 72;
    const T_LOGICAL_OR    = 73;
    const T_LOGICAL_XOR   = 74;
    const T_METHOD        = 75;
    const T_MINUS_EQ      = 76;
    const T_MOD_EQ        = 77;
    const T_ASSIGN        = 78;
    const T_MUL_EQ        = 79;
    const T_NS            = 80;
    const T_NS_SEPARATOR  = 81;
    const T_NEW           = 82;
    const T_OBJECT_OP     = 83;
    const T_OR_EQ         = 84;
    const T_PLUS_EQ       = 85;
    const T_POW           = 86;
    const T_POW_EQ        = 86;
    const T_MY            = 88;
    const T_SHARED        = 89;
    const T_PROTECTED     = 90;
    const T_RETURN        = 91;
    const T_SL            = 92;
    const T_SL_EQ         = 93;
    const T_SR            = 94;
    const T_SR_EQ         = 95;
    const T_STATIC        = 96;
    const T_IDENTIFIER    = 97;
    const T_SWITCH        = 98;
    const T_RAISE         = 99;
    const T_TRAIT         = 100;
    const T_TRY           = 101;
    const T_LET           = 102;
    const T_WHILE         = 103;
    const T_XOR_EQ        = 104;
    const T_YIELD         = 105;
    const T_PIPE          = 107;
    const T_CHAIN         = 108;
    const T_ARRAY_ACESS   = 109;
    const T_DOUBLE_COLON  = 110;
    const T_LPAREN        = 111;
    const T_RPAREN        = 112;
    const T_LBRACKET      = 113;
    const T_RBRACKET      = 114;
    const T_AT            = 115;

    switch
      when age then true 




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
          default:
            throw new Exception("Error");
        }
      }
      return new Token(self::EOF_TYPE, "[EOF]");
    }
  }