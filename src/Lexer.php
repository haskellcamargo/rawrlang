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

  class Lexer extends LexerBase
  {
    public function __construct($input)
    {
      parent::__construct($input);
    }

    public function nextToken()
    {
      while ($this->char != self::EOF) {
        switch ($this->char) {
          case " ":
            $this->consume();
            continue;
          case "(":
            return $this->checkLeftParen();
          case ")":
            return $this->checkRightParen();
          case ",":
            return $this->checkComma();
          case "-":
            return $this->checkMinus();
          case "+":
            return $this->checkPlus();
          case "=":
            return $this->checkEqual();
          case "@":
            return $this->checkAt();
          case "~":
            return $this->checkTilde();
          case "\"":
            return $this->checkDoubleQuote();
          case ":":
            return $this->checkDoubleColon();
          case "[":
            return $this->checkLeftBracket();
          case "]":
            return $this->checkRightBracket();
          case ";":
            return $this->checkSemicolon();
          case "|":
            return $this->checkPipe();
          case ">":
            return $this->checkGreater();
          case "<":
            return $this->checkLesser();
          case "!":
            return $this->checkExclamation();
          case "/":
            return $this->checkSlash();
          case "*":
            return $this->checkAsterisk();
          case "?":
            return $this->checkInterrogation();
          case "\n":
          case "\r":
          case "\r\n":
            return $this->checkNewLine();
          case "%":
            return $this->checkLineComment();
          case ".":
            return $this->checkDot();
          case "^":
            return $this->checkCircunflex();
          default:
            if (Verifier::isAlpha($this->char) || Verifier::isUnderscore($this->char)) {
              return $this->checkWord();
            }

            if (Verifier::isDigit($this->char)) {
              return $this->checkDigit();
            }

            throw new Exception("Unexpected {$this->char}", 1);
        }
      }
      return new Token(self::T_EOF);
    }

    private function checkWord()
    {
      $buffer = "";
      while (Verifier::isAlpha($this->char) || Verifier::isDigit($this->char)
          || Verifier::isUnderscore($this->char)) {
        $buffer .= $this->char;
        $this->consume();
      }

      if (array_key_exists($buffer, TerminalSymbol::$keywordTerminalFor)) {
        return new Token(TerminalSymbol::$keywordTerminalFor[$buffer]);
      }
      return new Token(TerminalSymbol::T_IDENTIFIER, $buffer);
    }

    private function checkLineComment()
    {
      $buffer = "";
      while ($this->char === "%") {
        $this->consume();
      }

      while ($this->char !== "\n"
         && $this->char !== "\r\n"
         && $this->char !== "\r") {
        $buffer .= $this->char;
        $this->consume();
      }

      $this->ignoreNewLine();
      return new Token(TerminalSymbol::T_COMMENT, $buffer);
    }

    private function checkNewLine()
    {
      while (Verifier::isNewLine($this->char)) {
        $this->consume();
      }
      return new Token(TerminalSymbol::T_NEWLINE);
    }

    private function ignoreNewLine()
    {
      while (Verifier::isNewLine($this->char)) {
        $this->consume();
      }
    }

    private function checkDot()
    {
      if ($this->maybe(".&.")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_BITWISE_AND);
      }

      if ($this->maybe(".|.")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_BITWISE_OR);
      }

      if ($this->maybe(".^.")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_BITWISE_XOR);
      }

      if ($this->maybe(".~.")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_BITWISE_NOT);
      }

      if ($this->maybe(".<<.")) {
        $this->consume(4);
        return new Token(TerminalSymbol::T_LEFT_SHIFT);
      }

      if ($this->maybe(".>>.")) {
        $this->consume(4);
        return new Token(TerminalSymbol::T_RIGHT_SHIFT);
      }

      if ($this->maybe(".>>>.")) {
        $this->consume(5);
        return new Token(TerminalSymbol::T_ZRIGHT_SHIFT);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_DOT);
    }

    private function checkLeftParen()
    {
      if ($this->maybe("(.")) {
        $this->consume(2);
        # TODO: APPLY PARTIAL FUNCTION.
      } else {
        $this->consume();
        return new Token(TerminalSymbol::T_LPAREN);
      }
    }

    private function checkRightParen()
    {
      $this->consume();
      return new Token(TerminalSymbol::T_RPAREN);
    }

    private function checkComma()
    {
      $this->consume();
      return new Token(TerminalSymbol::T_COMMA);
    }

    private function checkEqual()
    {
      if ($this->maybe("==")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_STRICT_EQUAL);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_ASSIGN);
    }

    private function checkDigit()
    {
      $buffer = "";
      while (Verifier::isDigit($this->char)) {
        $buffer .= $this->char;
        $this->consume();
      }

      if ($this->char === ".") {
        if (Verifier::isDigit($this->ahead())) {
          $buffer .= $this->char;
          $this->consume();
          while(Verifier::isDigit($this->char)) {
            $buffer .= $this->char;
            $this->consume();
          }
        } else {
          $buffer .= "0";
        }
      }

      return new Token(TerminalSymbol::T_NUMBER, $buffer);
    }

    private function checkMinus()
    {
      if ($this->maybe("-=")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_MINUS_EQ);
      }

      if ($this->maybe("->")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_LAMBDA);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_MINUS);
    }

    private function checkAt()
    {
      $this->consume();
      return new Token(TerminalSymbol::T_THIS);
    }

    private function checkDoubleQuote()
    {
      $this->consume();
      $buffer = "";
      while ($this->char !== "\"") {
        $buffer .= $this->char;
        $this->consume();
      }
      $this->consume();
      return new Token(TerminalSymbol::T_STRING, $buffer);
    }

    private function checkPlus()
    {
      if ($this->maybe("+=")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_PLUS_EQ);
      }

      if ($this->maybe("++=")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_CONCAT_EQ);
      }

      if ($this->maybe("++")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_CONCAT);
      }

      if ($this->maybe("+++")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_CONCAT_ARRAY);
      }

      $this->consume();
      if (Verifier::isAlpha($this->char)
       || Verifier::isUnderscore($this->char)) {
        return new Token(TerminalSymbol::T_NEW);
      }
      return new Token(TerminalSymbol::T_PLUS);
    }

    private function checkTilde()
    {
      if ($this->maybe("~=")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_FUZZY_EQUAL);
      }

      $this->consume();

      if (Verifier::isAlpha($this->char)) {
        $buffer = $this->char;
        $this->consume();
        while (Verifier::isAlpha($this->char)
            || Verifier::isDigit($this->char)
            || Verifier::isUnderscore($this->char)) {
          $buffer .= $this->char;
          $this->consume();
        }

        return new Token(TerminalSymbol::T_CALL, $buffer);
      }


      return new Token(TerminalSymbol::T_TILDE);
    }

    private function checkDoubleColon()
    {
      if ($this->maybe("::")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_STATIC_ACCESS);
      }

      if ($this->maybe(":>")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_CURRY);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_DOUBLE_COLON);
    }

    private function checkCircunflex()
    {
      if ($this->maybe("^^")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_CLONE);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_BAD_CHARACTER, "^");
    }

    private function checkLeftBracket()
    {
      $this->consume();
      return new Token(TerminalSymbol::T_LBRACKET); 
    }

    private function checkRightBracket()
    {
      if ($this->maybe("]>")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_RSTRINGLIST);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_RBRACKET);
    }

    private function checkSemicolon()
    {
      $this->consume();
      return new Token(TerminalSymbol::T_SEMICOLON);
    }

    private function checkPipe()
    {
      $this->consume();
      return new Token(TerminalSymbol::T_PIPE);
    }

    private function checkGreater()
    {
      if ($this->maybe(">=")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_GREATER_OR_EQ);
      }

      if ($this->maybe(">>")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_CHAIN);
      }

      if ($this->maybe(">?")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_MAXIMUM);
      }

      if ($this->maybe(">.<")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_COMPOSE);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_GREATER);
    }

    private function checkLesser()
    {
      if ($this->maybe("<=")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_LESSER_OR_EQ);
      }

      if ($this->maybe("<>")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_DIFFERENT);
      }

      if ($this->maybe("<<<<")) {
        $this->consume(4);
        return new Token(TerminalSymbol::T_PREPEND);
      }

      if ($this->maybe("<<<")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_APPEND);
      }

      if ($this->maybe("<<")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_LCHAIN);
      }

      if ($this->maybe("<[")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_LSTRINGLIST);
      }

      if ($this->maybe("<?")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_MINIMUM);
      }

      if ($this->maybe("<!>")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_STRICT_DIFF);
      }

      if ($this->maybe("<$>")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_MAP);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_LESSER);
    }

    private function checkExclamation()
    {
      if ($this->maybe("!!")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_ARRAY_ACCESS);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_CALL);
    }

    private function checkSlash()
    {
      if ($this->maybe("/=")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_DIV_EQ);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_DIVISION);
    }

    private function checkAsterisk()
    {
      if ($this->maybe("*=")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_TIMES_EQ);
      }

      if ($this->maybe("**=")) {
        $this->consume(3);
        return new Token(TerminalSymbol::T_EXP_EQ);
      }

      if ($this->maybe("**")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_EXP);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_TIMES);
    }

    private function checkInterrogation()
    {
      if ($this->maybe("??")) {
        $this->consume(2);
        return new Token(TerminalSymbol::T_NULLCOALESCE);
      }

      $this->consume();
      return new Token(TerminalSymbol::T_ISSET);
    }
  }