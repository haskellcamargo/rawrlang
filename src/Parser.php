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
  namespace RawrLang\Parser;
  use \RawrLang\CodeGen\CodeGen;
  use \RawrLang\Lexer\TerminalSymbol;

  class Parser extends ParserBase
  {
    public function __construct(\RawrLang\Lexer\Lexer $input)
    {
      parent::__construct($input);
    }

    public function init()
    {
      echo CodeGen::php($this->stmt());
    }

    private function stmt()
    {
      switch ($this->lookahead->name) {
        case TerminalSymbol::T_COMMENT:
          return $this->comment()
          . $this->stmt();
        case TerminalSymbol::T_MODULE:
          return $this->module()
          . $this->stmt();
        case TerminalSymbol::T_BLUEPRINT:
          return $this->blueprint()
          . $this->stmt();
        case TerminalSymbol::T_ABSTRACT:
          return $this->abstractBlueprint()
          . $this->stmt();
        case TerminalSymbol::T_FINAL:
          return $this->finalBlueprint()
          . $this->stmt();
        case TerminalSymbol::T_WITH:
          return $this->withStmt()
          . $this->stmt();
        default:
          return "";
          echo "Error. Unexpected {$this->lookahead->value}\n";
          exit;
      }
    }

    private function blueprintStmt()
    {
      switch ($this->lookahead->name) {
        case TerminalSymbol::T_SHARED:
          return $this->sharedDecl()
          . $this->blueprintStmt();
        case TerminalSymbol::T_PROTECTED:
          return $this->protectedDecl()
          . $this->blueprintStmt();
        case TerminalSymbol::T_MY:
          return $this->myDecl()
          . $this->blueprintStmt();
        case TerminalSymbol::T_METHOD:
          return $this->method()
          . $this->blueprintStmt();
        case TerminalSymbol::T_STATIC:
          return $this->staticMethod()
          . $this->blueprintStmt();
        case TerminalSymbol::T_FINAL:
          return $this->finalMethod()
          . $this->blueprintStmt();
        case TerminalSymbol::T_CONST:
          return $this->constStmt()
          . $this->blueprintStmt();
        default:
          return "";
      }
    }

    private function comment()
    {
      $comment = CodeGen::comment($this->lookahead->value);
      $this->match(TerminalSymbol::T_COMMENT);
      return $comment;
    }

    private function blueprint($type = [])
    {
      $buffer = [];
      $this->match(TerminalSymbol::T_BLUEPRINT);
      $buffer["name"] = $this->lookahead->value;
      $this->match(TerminalSymbol::T_IDENTIFIER);
      $this->match(TerminalSymbol::T_DOUBLE_COLON);
      list ($buffer["inherit"], $buffer["contract"]) =
        $this->blueprintDefinitions();
      CodeGen::$scope++;
      $buffer["stmt"] = $this->blueprintStmt();
      CodeGen::$scope--;
      $this->match(TerminalSymbol::T_END);
      return CodeGen::blueprint($type, $buffer["name"], $buffer["inherit"]
        , $buffer["contract"], $buffer["stmt"]);
    }

    private function abstractBlueprint()
    {
      $this->match(TerminalSymbol::T_ABSTRACT);
      return $this->blueprint(["abstract"]);
    }

    private function finalBlueprint()
    {
      $this->match(TerminalSymbol::T_FINAL);
      return $this->blueprint(["final"]);
    }

    private function blueprintDefinitions()
    {
      $inherit = null;
      $contract = [];

      if ($this->lookahead->name == TerminalSymbol::T_INHERIT) {
        $this->match(TerminalSymbol::T_INHERIT);
        $inherit = $this->lookahead->value;
        $this->match(TerminalSymbol::T_IDENTIFIER);
      }

      while ($this->lookahead->name == TerminalSymbol::T_WITH) {
        $this->match(TerminalSymbol::T_WITH);
        $this->match(TerminalSymbol::T_CONTRACT);
        $contract[] = $this->lookahead->value;
        $this->match(TerminalSymbol::T_IDENTIFIER);
      }

      return [$inherit, $contract];
    }

    private function module()
    {
      $buffer = [];
      $this->match(TerminalSymbol::T_MODULE);
      $buffer["name"] = $this->moduleName();
      $this->match(TerminalSymbol::T_DOUBLE_COLON);
      CodeGen::$scope++;
      $buffer["stmt"] = $this->stmt();
      CodeGen::$scope--;
      $this->match(TerminalSymbol::T_END);
      return CodeGen::module($buffer["name"], $buffer["stmt"]);
    }

    private function moduleName()
    {
      $name = "";
      if ($this->lookahead->name == TerminalSymbol::T_DOT) {
        $name .= "[NS_SEPARATOR]";
        $this->match(TerminalSymbol::T_DOT);
      }

      while ($this->lookahead->name == TerminalSymbol::T_IDENTIFIER) {
        $name .= $this->lookahead->value;
        $this->match(TerminalSymbol::T_IDENTIFIER);
        if ($this->lookahead->name == TerminalSymbol::T_DOT) {
          $name .= "[NS_SEPARATOR]";
          $this->match(TerminalSymbol::T_DOT);
        }
      }

      return $name;
    }

    private function sharedDecl()
    {
      $this->match(TerminalSymbol::T_SHARED);
      $property = $this->lookahead->value;
      if ($this->lookahead->name == TerminalSymbol::T_IDENTIFIER) {
        $this->match(TerminalSymbol::T_IDENTIFIER);
        return CodeGen::sharedDecl($property);
      }
      
      if ($this->lookahead->name == TerminalSymbol::T_STATIC) {
        $this->match(TerminalSymbol::T_STATIC);
        return $this->method(["public"]);
      }

      if ($this->lookahead->name == TerminalSymbol::T_ABSTRACT) {
        $this->match(TerminalSymbol::T_ABSTRACT);
        return $this->method(["abstract"]);
      }
      
    }

    private function protectedDecl()
    {
      $this->match(TerminalSymbol::T_PROTECTED);
      $property = $this->lookahead->value;
      if ($this->lookahead->name == TerminalSymbol::T_IDENTIFIER) {
        $this->match(TerminalSymbol::T_IDENTIFIER);
        return CodeGen::protectedDecl($property);
      }

      return $this->method(["protected"]);
    }

    private function myDecl()
    {
      $this->match(TerminalSymbol::T_MY);
      $property = $this->lookahead->value;
      if ($this->lookahead->name == TerminalSymbol::T_IDENTIFIER) {
        $this->match(TerminalSymbol::T_IDENTIFIER);
        return CodeGen::myDecl($property);
      }

      return $this->method(["private"]);
    }

    private function staticMethod()
    {
      $this->match(TerminalSymbol::T_STATIC);
      return $this->method(["static"]);
    }

    private function finalMethod()
    {
      $this->match(TerminalSymbol::T_FINAL);
      var_dump($this->lookahead);
      switch ($this->lookahead->name) {
        case TerminalSymbol::T_SHARED:
          $this->match(TerminalSymbol::T_SHARED);
          return $this->method(["final", "public"]);
        case TerminalSymbol::T_PROTECTED:
          $this->match(TerminalSymbol::T_PROTECTED);
          return $this->method(["final", "protected"]);
        case TerminalSymbol::T_MY:
          return $this->method(["final", "private"]);
      }
    }

    private function method($type = [])
    {
      $buffer = [];
      $this->match(TerminalSymbol::T_METHOD);
      $buffer["name"] = $this->lookahead->value;
      $this->match(TerminalSymbol::T_IDENTIFIER);
      $buffer["args"] = ($this->lookahead->name == TerminalSymbol::T_LPAREN) ?
        $this->methodArguments()
      : [] ;
      $this->match(TerminalSymbol::T_DOUBLE_COLON);
      $this->match(TerminalSymbol::T_END);
      return CodeGen::method($type, $buffer["name"], $buffer["args"]);
    }

    private function methodArguments()
    {
      $args = [];
      $this->match(TerminalSymbol::T_LPAREN);
      while ($this->lookahead->name == TerminalSymbol::T_IDENTIFIER) {
        $args[] = $this->lookahead->value;
        $this->match(TerminalSymbol::T_IDENTIFIER);
        if ($this->lookahead->name == TerminalSymbol::T_SEMICOLON) {
          $this->match(TerminalSymbol::T_SEMICOLON);
        }
      }
      $this->match(TerminalSymbol::T_RPAREN);
      return $args;
    }

    private function withStmt()
    {
      $this->match(TerminalSymbol::T_WITH);
      $name = $this->moduleName($this->lookahead->value);
      return CodeGen::withStmt($name);
    }

    private function constStmt()
    {
      $this->match(TerminalSymbol::T_CONST);
      $name = $this->lookahead->value;
      $this->match(TerminalSymbol::T_IDENTIFIER);
      return CodeGen::constStmt($name);
    }
  }