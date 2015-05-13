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
          return $this->comment() . $this->stmt();
        case TerminalSymbol::T_MODULE:
          return $this->module();
        case TerminalSymbol::T_BLUEPRINT:
          return $this->blueprint();
        default:
          return "";
          echo "Error. Unexpected {$this->lookahead->value}\n";
          var_dump($this->lookahead);
          exit;
      }
    }

    private function blueprintStmt()
    {
      switch ($this->lookahead->name) {
        case TerminalSymbol::T_SHARED:
          return $this->sharedDecl() . $this->blueprintStmt();
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

    private function blueprint()
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
      return CodeGen::blueprint($buffer["name"], $buffer["inherit"]
        , $buffer["contract"], $buffer["stmt"]);
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
      $this->match(TerminalSymbol::T_IDENTIFIER);
      return CodeGen::sharedDecl($property);
    }
  }