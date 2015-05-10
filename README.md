# Rawr Lang

Rawrlang is a powerful and expressive hybrid programming language that compiles to PHP. It fixes several issues in the language
and implements functional concepts, with a syntax Python based and support for LiveScript operators (functions).

# Examples

## Hello World!

```erlang
module Main
  ~IO::write "Hello World!"
end
```

## Map Implementation

```erlang
module Implementation
  exposing map
  import {tail, head} from Prelude
  
  define map (fn :: Fun, list :: array)
    let [x, xs] = [~head list, ~tail list]
    return switch xs
    | []        = []
    | otherwise = (~fn x) ++ (~map fn, list)
  end
end
```


## Console I/O

```erlang
module Main
  ~IO::getLine! >>= *IO::putStrLn 
end
```
## Write in File

```erlang
module TestFile
  with filepath as ~IO::getLine! do
    filepath.toFile! >> open "r" >> puts ~IO::getLine!
  end
end
```

# Operators

| Operator       | Associativity    | Description                         |
| -------------- | ---------------- | ----------------------------------- |
| `+`            | Left             | Sum                                 |
| `-`            | Left             | Subtraction                         |
| `++`           | Left             | String concatenation                |
| `*`            | Left             | Multiplication / string replication |
| `**`           | Left             | Exponential                         |
| `/`            | Left             | Division / string replacement       |
| `+=`           | Right            | Sum with assignment                 |
| `-=`           | Right            | Subtraction with assignment         |
| `*=`           | Right            | Multiplication with assignment      |
| `/=`           | Right            | Division with assignment            |
| `**=`          | Right            | Exponential with assignment         |
| `**=`          |
