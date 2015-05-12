<?php
  class Verifier
  {
    public static function startIdentifier($char)
    {
      return ctype_alpha($char) || $char == "_";
    }

    public static function startNumber($char)
    {
      return ctype_digit($char);
    }
  }