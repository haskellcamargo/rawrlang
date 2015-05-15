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


  # TODO:
  # REMODELAR COMPLETAMENTE ESSA BOSTA!
  
  namespace RawrLang\Parser;
  use \RawrLang\CodeGen\CodeGen;
  use \RawrLang\Lexer\LexerBase;
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
        case TerminalSymbol::T_TRAIT:
          return $this->_trait()
          . $this->stmt();
        case TerminalSymbol::T_CONTRACT:
          return $this->contract()
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
        case LexerBase::T_EOF:
          $this->match(LexerBase::T_EOF);
          return "";
        default:
          var_dump($this->lookahead);
          echo "Error. Unexpected {$this->lookahead->name}\n";
          exit;
      }
    }

    private function contractStmt()
    {
      switch ($this->lookahead->name) {
        case TerminalSymbol::T_SHOULD:
          return $this->should()
          . $this->contractStmt();
        case TerminalSymbol::T_CONST:
          return $this->constStmt()
          . $this->contractStmt();
        default:
          return "";
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
        case TerminalSymbol::T_COMMENT:
          return $this->comment()
          . $this->blueprintStmt();
        case TerminalSymbol::T_MAGIC:
          return $this->magic()
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

    private function contract()
    {
      $buffer = [];
      $this->match(TerminalSymbol::T_CONTRACT);
      $buffer["name"] = $this->lookahead->value;
      $this->match(TerminalSymbol::T_IDENTIFIER);
      $this->match(TerminalSymbol::T_DOUBLE_COLON);
      $buffer["inherit"] = $this->contractDefinitions();
      CodeGen::$scope++;
      $buffer["stmt"] = $this->contractStmt();
      CodeGen::$scope--;
      $this->match(TerminalSymbol::T_END);
      return CodeGen::contract($buffer["name"], $buffer["inherit"]
        , $buffer["stmt"]);
    }

    private function contractDefinitions()
    {
      $inherit = [];
      while ($this->lookahead->name == TerminalSymbol::T_INHERIT) {
        $this->match(TerminalSymbol::T_INHERIT);
        $inherit[] = $this->moduleName();
      }
      return $inherit;
    }

    private function _trait()
    {
      $buffer = [];
      $this->match(TerminalSymbol::T_TRAIT);
      $buffer["name"] = $this->lookahead->value;
      $this->match(TerminalSymbol::T_IDENTIFIER);
      $this->match(TerminalSymbol::T_DOUBLE_COLON);
      $buffer["with"] = $this->traitDefinitions();
      CodeGen::$scope++;
      $buffer["stmt"] = $this->blueprintStmt();
      CodeGen::$scope--;
      $this->match(TerminalSymbol::T_END);
      return CodeGen::_trait($buffer["name"], $buffer["with"], $buffer["stmt"]);
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
        $inherit = $this->moduleName();
      }

      while ($this->lookahead->name == TerminalSymbol::T_WITH) {
        $this->match(TerminalSymbol::T_WITH);
        $this->match(TerminalSymbol::T_CONTRACT);
        $contract[] = $this->moduleName();
      }

      return [$inherit, $contract];
    }

    private function traitDefinitions()
    {
      $with = [];
      while ($this->lookahead->name == TerminalSymbol::T_WITH) {
        $this->match(TerminalSymbol::T_WITH);
        $with[] = $this->moduleName();
      }
      return $with;
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

      do {
        $name .= $this->lookahead->value;
        $this->match(TerminalSymbol::T_IDENTIFIER);
        if ($this->lookahead->name == TerminalSymbol::T_DOT) {
          $name .= "[NS_SEPARATOR]";
          $this->match(TerminalSymbol::T_DOT);
        }
      } while ($this->lookahead->name == TerminalSymbol::T_IDENTIFIER);

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
        return $this->method(["public", "static"]);
      }

      if ($this->lookahead->name == TerminalSymbol::T_ABSTRACT) {
        $this->match(TerminalSymbol::T_ABSTRACT);
        return $this->method(["public", "abstract"]);
      }

      if ($this->lookahead->name == TerminalSymbol::T_METHOD) {
        return $this->method(["public"]);
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
      if ($this->lookahead->name == TerminalSymbol::T_DOUBLE_COLON) {
        $this->match(TerminalSymbol::T_DOUBLE_COLON);
        CodeGen::$scope++;
        $buffer["stmt"] = $this->stmt();
        CodeGen::$scope--;
        $this->match(TerminalSymbol::T_END);
        return CodeGen::method($type, $buffer["name"], $buffer["args"]
          , $buffer["stmt"]);
      } else {
        $out = CodeGen::inlineMethod($type, $buffer["name"], $buffer["args"]);
        return $out;
      }
    }

    private function methodArguments()
    {
      $args = [];
      $this->match(TerminalSymbol::T_LPAREN);

      while ($this->lookahead->name == TerminalSymbol::T_IDENTIFIER
          || $this->lookahead->name == TerminalSymbol::T_TIMES) {

        $byRef = false;
        if ($this->lookahead->name == TerminalSymbol::T_TIMES) {
          $this->match(TerminalSymbol::T_TIMES);
          $byRef = true;
        }

        $name = $this->lookahead->value;
        $args[$byRef ? "&" . $name : $name] = null;

        $this->match(TerminalSymbol::T_IDENTIFIER);

        if ($this->lookahead->name == TerminalSymbol::T_STATIC_ACCESS) {
          $this->match(TerminalSymbol::T_STATIC_ACCESS);
          $type = $this->moduleName();
          $args[$byRef ? "&" . $name : $name] = $type;
        }

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

    private function should()
    {
      $this->match(TerminalSymbol::T_SHOULD);
      $buffer["name"] = $this->lookahead->value;
      $this->match(TerminalSymbol::T_IDENTIFIER);
      $buffer["args"] = ($this->lookahead->name == TerminalSymbol::T_LPAREN) ?
        $this->methodArguments()
      : [] ;
      return CodeGen::inlineMethod(["public"], $buffer["name"], $buffer["args"]);
    }

    private function magic()
    {
      $buffer = [];
      $this->match(TerminalSymbol::T_MAGIC);
      $buffer["name"] = "__" . $this->lookahead->value;
      $this->match(TerminalSymbol::T_IDENTIFIER);
      $buffer["args"] = ($this->lookahead->name == TerminalSymbol::T_LPAREN) ?
        $this->methodArguments()
      : [] ;
      if ($this->lookahead->name == TerminalSymbol::T_DOUBLE_COLON) {
        $this->match(TerminalSymbol::T_DOUBLE_COLON);
        CodeGen::$scope++;
        $buffer["stmt"] = $this->stmt();
        CodeGen::$scope--;
        $this->match(TerminalSymbol::T_END);
        return CodeGen::method(["public"], $buffer["name"], $buffer["args"]
          , $buffer["stmt"]);
      } else {
        $out = CodeGen::inlineMethod(["public", "abstract"], $buffer["name"], $buffer["args"]);
        return $out;
      }
    }
  }