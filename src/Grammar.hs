<?php

inner-stmt = stmt
           | function-declaration-stmt
           | shape-declaration-stmt ;

inner-stmt-list = { inner-stmt } ;
stmt = "begin", inner-stmt-list, "end"
     | "if", expr, stmt, { elif-branch } [ else-single ]
     | "while", expr, ":", stmt, "end"
     | "iterate", expr, "as", iterate-variable, [ ";", iterate-variable ], ":",
         stmt, "end"
     | "for", identifier, "from", expr, "to", expr, [ "step", expr ]
     | "forever", ":", stmt, "end"
     | "stop", [ expr ]
     | "continue", [ expr ]
     | "return", [ expr-without-variable | variable ]
     | "expose", exposed-var, { ";", exposed-var }
     | "print", expr, { ";", expr }
     | T_INLINE_HTML_I_DONT_EVEN_CARE
     | expr
     | "with", shape-full-name, { ";", shape-full-name }
     | "declare", declare-list, [ ":", stmt, "end" ]
     | "try", inner-stmt-list, rescue-branch, { rescue-branch }, [ "finally",
         inner-stmt-list ]
     | "raise", expr ;

rescue-branch = "rescue", identifier, [ "::", shape-full-name ] ;

function-declaration-stmt = "define", identifier, [ "*" ], identifier,
  parameter-list, ":", inner-stmt-list, "end" ;

shape-declaration-stmt = shape-entry-type, identifier, [ extending ],
                           [ implementing ], ":", { shape-stmt }, "end"
                       | "contract", identifier [ extending-contract ], ":",
                           { shape-stmt }, "end" ;

shape-entry-type = [ "abstract" | "sealed" ], "shape" ;

extending = "<", shape-full-name, ">" ;

implementing = "[", shape-full-name, [ ";", shape-full-name ], "]" ;

extending-contract = "<", shape-full-name, [ ";", shape-full-name ], ">" ;

declare-list = identifier, "=" static-scalar, { ";", identifier, "=",
  static-scalar } ;

elif-branch = "elif", expr, stmt ;

else-single = [ "else" | "otherwise" ], stmt ;

parameter-list = [ parameter { ";", parameter } ] ;

parameter = [ "*" ], identifier, "::", shape-full-name, [ "~", static-scalar] ;

define change *xs :: List ~ [] ; fn :: Fun

end

function-call-parameter-list = [ function-call-parameter, ";",
  function-call-parameter ] ;

function-call-parameter = expr-without-variable
                        | [ "*" ], variable ;

exposed-var = identifier
            | "<", expr, ">"

static-var = identifier, "=", static-scalar

shape-stmt