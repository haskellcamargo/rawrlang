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
  namespace RawrLang\CodeGen;

  class CodeGen
  {
    public static $scope = 0;

    public static function php($stmt)
    {
      return "<?php\n" . "// Generated by Rawr 1.0\n\n" . $stmt . "?>\n";
    }

    public static function prettify()
    {
      return str_repeat(" ", self::$scope * 2);
    }

    public static function comment($value)
    {
      return self::prettify() . "#{$value}\n";
    }

    public static function translateName($name)
    {
      return str_replace("[NS_SEPARATOR]", "\\", $name);
    }

    public static function module($value, $stmt)
    {
      $namespace = self::translateName($value);
      $template  = self::prettify();
      $template .="namespace $namespace {\n";
      $template .= self::prettify() . $stmt;
      $template .= "}\n";
      return $template;
    }

    public static function contract($value, $extends, $contractStmt)
    {
      $template  = self::prettify() . "interface $value";
      if (sizeof($extends) > 0) {
        $implementationList = [];
        foreach ($extends as $toExtend) {
          $implementationList[] = self::translateName($toExtend);
        }
        $template .= "extends " . implode(", ", $implements) . " ";
      }
      $template .= "{\n";
      $template .= $contractStmt;
      $template .= self::prettify() . "}\n";

      return $template;
    }

    public static function blueprint(
        $type
      , $value
      , $extends
      , $implements
      , $blueprintStmt
    )
    {
      $template  = self::prettify();
      $template .= implode(" ", $type) ;
      if (sizeof($type) > 0) {
        $template .= " ";
      }
      $template .= "class $value ";
      if (!is_null($extends)) {
        $extending = self::translateName($extends);
        $template .= "extends {$extending} ";
      }

      if (sizeof($implements) > 0) {
        $implementationList = [];
        foreach ($implements as $toImplement) {
          $implementationList[] = self::translateName($toImplement);
        }
        $template .= "implements " . implode(", ", $implements) . " ";
      }

      $template .= "{\n";
      $template .= $blueprintStmt;
      $template .= self::prettify();
      $template .= "}\n";

      return $template;
    }

    public static function sharedDecl($property)
    {
      $template = self::prettify() . "public \${$property};\n";
      return $template;
    }

    public static function protectedDecl($property)
    {
      $template = self::prettify() . "protected \${$property};\n";
      return $template;
    }

    public static function myDecl($property)
    {
      $template = self::prettify() . "private \${$property};\n";
      return $template;
    }

    public static function method($type, $name, $args, $stmt)
    {
      $argumentList = [];
      foreach ($args as $argName => $argType) {
        $argumentList[] = is_null($argType) ? ("$" . $argName)
        /* otherwise */                  : (self::translateName($argType) . " $"
                                             . $argName);
      }
      $template  = self::prettify();
      $template .= implode(" ", $type);
      if (sizeof($type) > 0) {
        $template .= " ";
      }
      $template .= "function $name(";
      $template .= implode(", ", $argumentList);
      $template .= ")\n" . self::prettify() . "{\n";
      $template .= $stmt;
      $template .= self::prettify() . "}\n";
      return $template;
    }

    public static function inlineMethod($type, $name, $args)
    {
      $argumentList = [];
      foreach ($args as $argName => $argType) {
        $argumentList[] = is_null($argType) ? ("$" . $argName)
        /* otherwise */                  : (self::translateName($argType) . " $"
                                             . $argName);
      }
      $template  = self::prettify();
      $template .= implode(" ", $type);
      if (sizeof($type) > 0) {
        $template .= " ";
      }
      $template .= "function $name(";
      $template .= implode(", ", $argumentList);
      $template .= ");\n";
      return $template;
    }

    public static function withStmt($name)
    {
      $namespace = self::translateName($name);
      return self::prettify() . "use $namespace;\n";
    }

    public static function constStmt($name)
    {
      return self::prettify() . "const $name;\n";
    }
  }