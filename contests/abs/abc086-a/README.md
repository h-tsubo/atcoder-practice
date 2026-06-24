# ABC086A - Product の TypeScript / PHP 文法メモ

対象問題：

```txt
ABC086A - Product
```

URL：

```txt
https://atcoder.jp/contests/abs/tasks/abc086_a
```

入力：

```txt
a b
```

出力：

```txt
a * b が偶数なら Even
a * b が奇数なら Odd
```

---

## TypeScript版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf-8").trim().split(/\s+/).map(Number);

const [a, b] = input;

const output = a * b % 2 === 0 ? "Even" : "Odd";

console.log(output);
```

### `.map(Number)`

```ts
const input = fs.readFileSync(0, "utf-8").trim().split(/\s+/).map(Number);
```

`split(/\s+/)` の結果は、最初は文字列の配列。

例えば、入力が以下の場合、

```txt
3 4
```

`split(/\s+/)` の結果は、

```ts
["3", "4"]
```

になる。

このままだと文字列なので、数値計算に使うために `.map(Number)` で各要素を数値に変換する。

```ts
["3", "4"].map(Number)
```

結果：

```ts
[3, 4]
```

つまり、

```ts
.map(Number)
```

は、配列の各要素に `Number()` を適用する処理。

以下とほぼ同じ意味。

```ts
const input = ["3", "4"].map((value) => Number(value));
```

---

### 配列の分割代入

```ts
const [a, b] = input;
```

配列の中身を、順番に変数へ代入する書き方。

例えば、

```ts
const input = [3, 4];
const [a, b] = input;
```

と書くと、

```ts
const a = input[0];
const b = input[1];
```

と同じ意味になる。

つまり、

```ts
a = 3
b = 4
```

となる。

PracticeAでは、

```ts
const a = Number(input[0]);
const b = Number(input[1]);
```

のように個別に取り出していたが、今回は `.map(Number)` ですでに数値化しているため、分割代入でそのまま受け取れる。

---

### `*` 掛け算

```ts
a * b
```

`*` は掛け算。

例えば、

```ts
3 * 4
```

結果：

```txt
12
```

この問題では、`a * b` が偶数か奇数かを判定する。

---

### `%` 余り

```ts
a * b % 2
```

`%` は割り算の余りを求める演算子。

例えば、

```ts
12 % 2
```

結果：

```txt
0
```

```ts
9 % 2
```

結果：

```txt
1
```

2で割った余りが `0` なら偶数、`1` なら奇数。

この問題では、

```ts
a * b % 2
```

によって、`a * b` を2で割った余りを求めている。

---

### 演算子の優先順位

```ts
a * b % 2 === 0
```

この式は、次の順番で処理される。

```ts
((a * b) % 2) === 0
```

つまり、

```txt
1. a * b を計算する
2. その結果を 2 で割った余りを求める
3. 余りが 0 と等しいか判定する
```

読みやすさを優先するなら、以下のように括弧を付けてもよい。

```ts
const output = (a * b) % 2 === 0 ? "Even" : "Odd";
```

さらに明確にするなら、

```ts
const output = ((a * b) % 2 === 0) ? "Even" : "Odd";
```

---

### `===` 厳密等価演算子

```ts
a * b % 2 === 0
```

`===` は、値が等しいかを判定する演算子。

TypeScript / JavaScript には、

```ts
==
```

と

```ts
===
```

がある。

基本的には `===` を使う方がよい。

`==` は型変換をしたうえで比較する場合があるため、意図しない結果になることがある。

例：

```ts
"0" == 0
```

結果：

```txt
true
```

一方で、

```ts
"0" === 0
```

結果：

```txt
false
```

AtCoderでも通常の実務コードでも、基本は `===` を使う。

---

### 三項演算子

```ts
const output = a * b % 2 === 0 ? "Even" : "Odd";
```

三項演算子は、条件によって値を切り替える書き方。

基本形：

```ts
条件 ? trueのときの値 : falseのときの値
```

今回の場合、

```ts
a * b % 2 === 0
```

が true なら、

```ts
"Even"
```

false なら、

```ts
"Odd"
```

になる。

つまり、以下の `if` 文と同じ意味。

```ts
let output = "";

if ((a * b) % 2 === 0) {
  output = "Even";
} else {
  output = "Odd";
}
```

短く書けるため、単純な条件分岐では三項演算子が便利。

ただし、条件が複雑になる場合は `if` 文の方が読みやすい。

---

### `const output = ...`

```ts
const output = a * b % 2 === 0 ? "Even" : "Odd";
```

`output` という変数に、最終的に出力する文字列を入れている。

このように一度変数に入れてから、

```ts
console.log(output);
```

で出力すると、処理と出力を分けて読める。

直接書くなら以下でもよい。

```ts
console.log((a * b) % 2 === 0 ? "Even" : "Odd");
```

ただし、学習段階では `output` に分けた方が理解しやすい。

---

## PHP版

```php
<?php

$input = trim(stream_get_contents(STDIN));
[$a, $b] = array_map('intval', preg_split('/\s+/', $input));

echo (($a * $b) % 2 === 0 ? "Even" : "Odd") . PHP_EOL;
```

---

## この問題で新しく出てきた文法事項

### `array_map('intval', ...)`

```php
[$a, $b] = array_map('intval', preg_split('/\s+/', $input));
```

`preg_split('/\s+/', $input)` の結果は、最初は文字列の配列。

例えば、入力が以下の場合、

```txt
3 4
```

`preg_split('/\s+/', $input)` の結果は、

```php
["3", "4"]
```

になる。

このままだと文字列なので、整数として計算するために `array_map('intval', ...)` を使う。

```php
array_map('intval', ["3", "4"])
```

結果：

```php
[3, 4]
```

つまり、

```php
array_map('intval', ...)
```

は、配列の各要素に `intval()` を適用する処理。

---

### PHPの配列分割代入

```php
[$a, $b] = array_map('intval', preg_split('/\s+/', $input));
```

配列の中身を、順番に変数へ代入している。

例えば、

```php
$numbers = [3, 4];
[$a, $b] = $numbers;
```

と書くと、

```php
$a = $numbers[0];
$b = $numbers[1];
```

と同じ意味になる。

つまり、

```txt
$a = 3
$b = 4
```

になる。

PracticeAでは、

```php
$a = intval($tokens[0]);
$b = intval($tokens[1]);
```

のように個別に取り出していたが、今回は `array_map('intval', ...)` で数値化した配列を、そのまま分割代入している。

---

### `*` 掛け算

```php
$a * $b
```

`*` は掛け算。

例えば、

```php
3 * 4
```

結果：

```txt
12
```

この問題では、`$a * $b` の結果が偶数か奇数かを判定する。

---

### `%` 余り

```php
($a * $b) % 2
```

`%` は割り算の余りを求める演算子。

例えば、

```php
12 % 2
```

結果：

```txt
0
```

```php
9 % 2
```

結果：

```txt
1
```

2で割った余りが `0` なら偶数、`1` なら奇数。

---

### `===` 厳密比較

```php
($a * $b) % 2 === 0
```

`===` は、値と型が等しいかを判定する演算子。

PHPにも、

```php
==
```

と

```php
===
```

がある。

`==` は型変換をしたうえで比較する場合がある。

例：

```php
"0" == 0
```

結果：

```txt
true
```

一方で、

```php
"0" === 0
```

結果：

```txt
false
```

今回のように整数同士を比較する場合でも、基本的には `===` を使う方が安全。

---

### PHPの三項演算子

```php
(($a * $b) % 2 === 0 ? "Even" : "Odd")
```

PHPでも三項演算子が使える。

基本形：

```php
条件 ? trueのときの値 : falseのときの値
```

今回の場合、

```php
($a * $b) % 2 === 0
```

が true なら、

```php
"Even"
```

false なら、

```php
"Odd"
```

になる。

以下の `if` 文と同じ意味。

```php
if (($a * $b) % 2 === 0) {
    echo "Even" . PHP_EOL;
} else {
    echo "Odd" . PHP_EOL;
}
```

---

### `.` による文字列連結と三項演算子の括弧

```php
echo (($a * $b) % 2 === 0 ? "Even" : "Odd") . PHP_EOL;
```

PHPでは、文字列連結に `.` を使う。

ここでは、

```php
(($a * $b) % 2 === 0 ? "Even" : "Odd")
```

で `"Even"` または `"Odd"` を作り、その後に

```php
. PHP_EOL
```

で改行を連結している。

三項演算子を文字列連結と組み合わせる場合は、括弧を付ける方が安全。

つまり、以下のように書く。

```php
echo (($a * $b) % 2 === 0 ? "Even" : "Odd") . PHP_EOL;
```

括弧を付けることで、

```txt
1. 偶奇判定で Even / Odd を決める
2. その後に改行を連結する
```

という処理の順番が明確になる。

---

## TypeScript と PHP の対応表

| 処理         | TypeScript             | PHP                        |
| ---------- | ---------------------- | -------------------------- |
| 配列の全要素を数値化 | `.map(Number)`         | `array_map('intval', ...)` |
| 配列分割代入     | `const [a, b] = input` | `[$a, $b] = $numbers`      |
| 掛け算        | `a * b`                | `$a * $b`                  |
| 余り         | `(a * b) % 2`          | `($a * $b) % 2`            |
| 厳密比較       | `===`                  | `===`                      |
| 三項演算子      | `condition ? A : B`    | `condition ? A : B`        |
| 出力用変数      | `const output = ...`   | 必要なら `$output = ...`       |
| 文字列連結      | `+` またはテンプレートリテラル      | `.`                        |

---
