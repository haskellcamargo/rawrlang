module Codegen {
  export module VirtualMachine {
    export var opcode: { [key: string]: number } = {
      OP_ADD: 1
    };

    export class BinaryOperator {
      static ADD(left: any, right: any): string {
        return left + " + " + right;
      }

      static SUB(left: any, right: any): string {
        return left + " - " + right;
      }
    }
  }

  export module Type {
    export enum LangType {
      PROGRAM,
      LITERAL
    };

    export type Literal
      = string
      | number
      | boolean
      ;
  }

  export module Ast {
    interface Symbol {
      name: string;
      type: Type.LangType;
    }

    export interface Program extends Symbol {
      body: Array<Symbol>;
    }

    type Expr = Symbol;

    export interface BinaryOp extends Expr {
      operator: string;
      left: Symbol;
      right: Symbol;
    }

    export interface UnaryOp extends Expr {
      operator: string;
      operand: Symbol;
    }

    export interface Literal {
      value: Type.Literal;
    }
  }
}
