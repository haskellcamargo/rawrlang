<?php

namespace Compiler
{
  class RawrTokenList
  {
    // Some tokens are kept untouchable from PHP
    const T_ABSTRACT                 = T_ABSTRACT;
    const T_AND_EQUAL                = T_AND_EQUAL;
    const T_ARRAY_CAST               = T_ARRAY_CAST;
    const T_BAD_CHARACTER            = T_BAD_CHARACTER;
    const T_BOOLEAN_AND              = T_BOOLEAN_AND;
    const T_BOOLEAN_OR               = T_BOOLEAN_OR;
    const T_BOOL_CAST                = T_BOOL_CAST;
    const T_CLASS_C                  = T_CLASS_C;
    const T_CLONE                    = T_CLONE;
    const T_CLOSE_TAG                = T_CLOSE_TAG;
    const T_COMMENT                  = T_COMMENT;
    const T_CONCAT_EQUAL             = T_CONCAT_EQUAL;
    const T_CONST                    = T_CONST;
    const T_CONSTANT_ENCAPSED_STRING = T_CONSTANT_ENCAPSED_STRING;
    const T_DECLARE                  = T_DECLARE;
    const T_DIR                      = T_DIR;
    const T_DIV_EQUAL                = T_DIV_EQUAL;
    const T_DNUMBER                  = T_DNUMBER;
    const T_DOC_COMMENT              = T_DOC_COMMENT;
    const T_DO                       = T_DO;
    const T_DOUBLE_CAST              = T_DOUBLE_CAST;
    const T_DOUBLE_COLON             = T_DOUBLE_COLON;
    const T_ECHO                     = T_ECHO;
    const T_ELLIPSIS                 = T_ELLIPSIS;
    const T_ELSE                     = T_ELSE;
    const T_END_HEREDOC              = T_END_HEREDOC;
    const T_FILE                     = T_FILE;
    const T_FINAL                    = T_FINAL;
    const T_FOR                      = T_FOR;
    const T_FUNC_C                   = T_FUNC_C;
    const T_GLOBAL                   = T_GLOBAL;
    const T_GOTO                     = T_GOTO;
    const T_IF                       = T_IF;
    const T_INLINE_HTML              = T_INLINE_HTML;
    const T_INSTANCEOF               = T_INSTANCEOF;
    const T_INSTEADOF                = T_INSTEADOF;
    const T_IS_GREATER_OR_EQUAL      = T_IS_GREATER_OR_EQUAL;
    const T_IS_IDENTICAL             = T_IS_IDENTICAL;
    const T_IS_NOT_EQUAL             = T_IS_NOT_EQUAL;
    const T_IS_SMALLER_OR_EQUAL      = T_IS_SMALLER_OR_EQUAL;
    const T_SPACESHIP                = T_SPACESHIP;
    const T_LINE                     = T_LINE;
    const T_LNUMBER                  = T_LNUMBER;
    const T_LOGICAL_AND              = T_LOGICAL_AND;
    const T_LOGICAL_OR               = T_LOGICAL_OR;
    const T_LOGICAL_XOR              = T_LOGICAL_XOR;
    const T_METHOD_C                 = T_METHOD_C;
    const T_MINUS_EQUAL              = T_MINUS_EQUAL;
    const T_MOD_EQUAL                = T_MOD_EQUAL;
    const T_MUL_EQUAL                = T_MUL_EQUAL;
    const T_NS_C                     = T_NS_C;
    const T_NEW                      = T_NEW;
    const T_OBJECT_CAST              = T_OBJECT_CAST;
    const T_OPEN_TAG                 = T_OPEN_TAG;
    const T_OR_EQUAL                 = T_OR_EQUAL;
    const T_PAAMAYIM_NEKUDOTAYIM     = T_PAAMAYIM_NEKUDOTAYIM;
    const T_PLUS_EQUAL               = T_PLUS_EQUAL;
    const T_POW                      = T_POW;
    const T_POW_EQUAL                = T_POW_EQUAL;
    const T_RETURN                   = T_RETURN;
    const T_SL                       = T_SL;
    const T_SL_EQUAL                 = T_SL_EQUAL;
    const T_SR                       = T_SR;
    const T_SR_EQUAL                 = T_SR_EQUAL;
    const T_START_HEREDOC            = T_START_HEREDOC;
    const T_STATIC                   = T_STATIC;
    const T_STRING                   = T_STRING;
    const T_STRING_CAST              = T_STRING_CAST;
    const T_TRAIT_C                  = T_TRAIT_C;
    const T_TRY                      = T_TRY;
    const T_UNSET_CAST               = T_UNSET_CAST;
    const T_VAR                      = T_VAR;
    const T_VARIABLE                 = T_VARIABLE;
    const T_WHILE                    = T_WHILE;
    const T_XOR_EQUAL                = T_XOR_EQUAL;
    const T_YIELD                    = T_YIELD;
    const T_WHITESPACE               = T_WHITESPACE; 
  }
}
