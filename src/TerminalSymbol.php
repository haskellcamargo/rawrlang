<?php
  # Copyright (c) 2014 Marcelo Camargo <marcelocamargo@linuxmail.org>
  #
  # Permission is hereby granted, free of charge, to any person
  # obtaining a copy of this software and associated documentation files
  # (the "Software"), to deal in the Software without restriction,
  # including without limitation the rights to use, copy, modify, merge,
  # publish, distribute, sublicense, and/or sell copies of the Software,
  # and to permit persons to whom the Software is furnished to do so,
  # subject to the following conditions:
  #
  # The above copyright notice and this permission notice shall be
  # included in all copies or substantial of portions the Software.
  #
  # THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
  # EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
  # MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
  # NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
  # LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
  # OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
  # WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
  namespace RawrLang\Lexer;
  use \Exception;
  use \ReflectionClass;

  /**
   * Terminal symbols must be defined here and have the following name:
   * - Must be uppercase.
   * - Must start with "T_".
   * - Must be (implicitly) public.
   */
  class TerminalSymbol
  {
    const T_ABSTRACT      = "T_ABSTRACT"      ;
    const T_AND           = "T_AND"           ;
    const T_AND_EQUAL     = "T_AND_EQUAL"     ; # Operator: &=
    const T_AS            = "T_AS"            ;
    const T_ASSIGN        = "T_ASSIGN"        ; # Operator: =
    const T_BAD_CHARACTER = "T_BAD_CHARACTER" ;
    const T_BEGIN         = "T_BEGIN"         ;
    const T_BITWISE_AND   = "T_BITWISE_AND"   ; # Operator .&.
    const T_BITWISE_NOT   = "T_BITWISE_NOT"   ; # Operator .~.
    const T_BITWISE_OR    = "T_BITWISE_OR"    ; # Operator .|.
    const T_BITWISE_XOR   = "T_BITWISE_XOR"   ; # Operator .^.
    const T_BLUEPRINT     = "T_BLUEPRINT"     ;
    const T_CALL          = "T_CALL"          ;
    const T_CAST          = "T_CAST"          ; # Operator: *
    const T_CLONE         = "T_CLONE"         ;
    const T_COMMA         = "T_COMMA"         ; # Operator: ,
    const T_COMMENT       = "T_COMMENT"       ;
    const T_CONCAT        = "T_CONCAT"        ; # Operator ++
    const T_CONCAT_ARRAY  = "T_CONCAT_ARRAY"  ; # Operator +++
    const T_CONCAT_EQ     = "T_CONCAT_EQ"     ; # Operator: ++=
    const T_CONTRACT      = "T_CONTRACT"      ;
    const T_CONST         = "T_CONST"         ;
    const T_CURRY         = "T_CURRY"         ; # Operator :>
    const T_DECLARE       = "T_DECLARE"       ;
    const T_DEFINE        = "T_DEFINE"        ;
    const T_DIV_EQUAL     = "T_DIV_EQUAL"     ; # Operator: /=
    const T_DO            = "T_DO"            ;
    const T_DOT           = "T_DOT"           ;
    const T_DOUBLE_COLON  = "T_DOUBLE_COLON"  ; # Operator: :
    const T_ELIF          = "T_ELIF"          ;
    const T_ELLIPSIS      = "T_ELLIPSIS"      ; # Operator: ...
    const T_ELSE          = "T_ELSE"          ;
    const T_END           = "T_END"           ;
    const T_EXIT          = "T_EXIT"          ;
    const T_EXPOSING      = "T_EXPOSING"      ;
    const T_FALSE         = "T_FALSE"         ;
    const T_FINAL         = "T_FINAL"         ;
    const T_FINALLY       = "T_FINALLY"       ;
    const T_FOR           = "T_FOR"           ;
    const T_FROM          = "T_FROM"          ;
    const T_FUZZY_EQUAL   = "T_FUZZY_EQUAL"   ; # Operator: ~=
    const T_GOTO          = "T_GOTO"          ;
    const T_IDENTIFIER    = "T_IDENTIFIER"    ;
    const T_IF            = "T_IF"            ;
    const T_IS            = "T_IS"            ;
    const T_IMPORT        = "T_IMPORT"        ;
    const T_INCLUDE       = "T_INCLUDE"       ;
    const T_INCLUDE_ONCE  = "T_INCLUDE_ONCE"  ;
    const T_ITERATE       = "T_ITERATE"       ;
    const T_INHERIT       = "T_INHERIT"       ;
    const T_LAMBDA        = "T_LAMBDA"        ;
    const T_LEFT_SHIFT    = "T_LEFT_SHIFT"    ; # Operator .<<.
    const T_LET           = "T_LET"           ;
    const T_LPAREN        = "T_LPAREN"        ;
    const T_LOOP          = "T_LOOP"          ;
    const T_MESSAGE       = "T_MESSAGE"       ;
    const T_METHOD        = "T_METHOD"        ;
    const T_MINUS         = "T_MINUS"         ; # Operator -
    const T_MINUS_EQ      = "T_MINUS_EQ"      ; # Operator -=
    const T_MOD           = "T_MOD"           ;
    const T_MODULE        = "T_MODULE"        ;
    const T_MY            = "T_MY"            ;
    const T_NEWLINE       = "T_NEWLINE"       ;
    const T_NOT           = "T_NOT"           ;
    const T_NULL          = "T_NULL"          ;
    const T_NUMBER        = "T_NUMBER"        ;
    const T_OR            = "T_OR"            ;
    const T_OTHERWISE     = "T_OTHERWISE"     ;
    const T_PARENT        = "T_PARENT"        ;
    const T_PLUS          = "T_PLUS"          ; # Operator +
    const T_PLUS_EQ       = "T_PLUS_EQ"       ; # Operator +=
    const T_PROTECTED     = "T_PROTECTED"     ;
    const T_RAISE         = "T_RAISE"         ;
    const T_RIGHT_SHIFT   = "T_RIGHT_SHIFT"   ; # Operator .>>.
    const T_RPAREN        = "T_RPAREN"        ;
    const T_RECORD        = "T_RECORD"        ;
    const T_REQUIRE       = "T_REQUIRE"       ;
    const T_REQUIRE_ONCE  = "T_REQUIRE_ONCE"  ;
    const T_RESCUE        = "T_RESCUE"        ;
    const T_RETURN        = "T_RETURN"        ;
    const T_SHARED        = "T_SHARED"        ;
    const T_STATIC        = "T_STATIC"        ;
    const T_STATIC_ACCESS = "T_STATIC_ACCESS" ; # Operator ::
    const T_STOP          = "T_STOP"          ;
    const T_STRICT_EQUAL  = "T_STRICT_EQUAL"  ; # Operator ==
    const T_STRING        = "T_STRING"        ;
    const T_THEN          = "T_THEN"          ;
    const T_THIS          = "T_THIS"          ; # Operator @
    const T_TILDE         = "T_TILDE"         ; # Operator ~
    const T_TO            = "T_TO"            ;
    const T_TRUE          = "T_TRUE"          ;
    const T_TRY           = "T_TRY"           ;
    const T_TYPESIGN      = "T_TYPESIGN"      ;
    const T_XOR           = "T_XOR"           ;
    const T_YIELD         = "T_YIELD"         ;
    const T_WHEN          = "T_WHEN"          ;
    const T_WHILE         = "T_WHILE"         ;
    const T_WITH          = "T_WITH"          ;
    const T_ZRIGHT_SHIFT  = "T_ZRIGHT_SHIFT"  ; # Operator .>>>.

    public static $keywordTerminalFor = [
      "abstract"     => self::T_ABSTRACT,
      "and"          => self::T_AND,
      "as"           => self::T_AS,
      "begin"        => self::T_BEGIN,
      "blueprint"    => self::T_BLUEPRINT,
      "clone"        => self::T_CLONE,
      "contract"     => self::T_CONTRACT,
      "const"        => self::T_CONST,
      "declare"      => self::T_DECLARE,
      "def"          => self::T_DEFINE,
      "define"       => self::T_DEFINE,
      "do"           => self::T_DO,
      "end"          => self::T_END,
      "elif"         => self::T_ELIF,
      "else"         => self::T_ELSE,
      "exit"         => self::T_EXIT,
      "False"        => self::T_FALSE,
      "final"        => self::T_FINAL,
      "finally"      => self::T_FINALLY,
      "for"          => self::T_FOR,
      "from"         => self::T_FROM,
      "goto"         => self::T_GOTO,
      "if"           => self::T_IF,
      "import"       => self::T_IMPORT,
      "include"      => self::T_INCLUDE,
      "include_once" => self::T_INCLUDE_ONCE,
      "inherit"      => self::T_INHERIT,
      "is"           => self::T_IS,
      "iterate"      => self::T_ITERATE,
      "let"          => self::T_LET,
      "like"         => self::T_FUZZY_EQUAL,
      "loop"         => self::T_LOOP,
      "method"       => self::T_METHOD,
      "mod"          => self::T_MOD,
      "module"       => self::T_MODULE,
      "my"           => self::T_MY,
      "not"          => self::T_NOT,
      "Null"         => self::T_NULL,
      "or"           => self::T_OR,
      "parent"       => self::T_PARENT,
      "protected"    => self::T_PROTECTED,
      "raise"        => self::T_RAISE,
      "record"       => self::T_RECORD,
      "require"      => self::T_REQUIRE,
      "require_once" => self::T_REQUIRE_ONCE,
      "rescue"       => self::T_RESCUE,
      "return"       => self::T_RETURN,
      "shared"       => self::T_SHARED,
      "static"       => self::T_STATIC,
      "stop"         => self::T_STOP,
      "then"         => self::T_THEN,
      "to"           => self::T_TO,
      "True"         => self::T_TRUE,
      "try"          => self::T_TRY,
      "xor"          => self::T_XOR,
      "yield"        => self::T_YIELD,
      "when"         => self::T_WHEN,
      "while"        => self::T_WHILE,
      "with"         => self::T_WITH,
    ];

    public static $phpKeyword = [
      "break", "continue", "class", "interface", "function", "foreach"
    ];

    public static $unambiguousToken = [

    ];

    /**
     * Returns the name of a token by application of reflection to get defined
     * constants.
     */
    public static function getTokenName($name)
    {
      try {
        return (new ReflectionClass(__CLASS__))
        ->getConstants()[$name];
      } catch (Exception $e) {
        return false;
      }
    }
  }