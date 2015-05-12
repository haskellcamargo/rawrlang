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

  abstract class LexerBase
  {
    const EOF   =  -1    ;
    const T_EOF = "T_EOF";

    protected $input;
    protected $position = 0;
    protected $char;

    public function __construct($input)
    {
      $this->input = $input;
      $this->char = $input[$this->position];
    }

    public function ahead($plus = 1)
    {
      return $this->input[$this->position + $plus];
    }

    public function maybe($value)
    {
      for ($i = 0; $i < strlen($value); $i++) {
        if ($this->ahead($i) !== $value[$i])
          return false;
      }
      return true;
    }

    public function consume($amount = 1)
    {
      $this->position += $amount;
      if ($this->position >= strlen($this->input)) {
        $this->char = self::EOF;
      } else {
        $this->char = $this->input[$this->position];
      }
    }

    public abstract function nextToken();
  }