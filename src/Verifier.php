<?php
  class Verifier
  {
    public static function startIdentifier($char)
    {
      return ctype_alpha($char);
    }
  }