# ABC081B - Shift only の TypeScript / PHP 文法メモ

対象問題：

```txt
ABC081B - Shift only
```

URL：

```txt
https://atcoder.jp/contests/abs/tasks/abc081_b
```

入力：

```txt
N
A1 A2 ... AN
```

ただし、`A1, A2, ..., AN` は整数。

例：

```txt
3
8 12 40
```

出力：

```txt
すべての整数を同時に2で割れる回数の最大値
```

例：

```txt
2
```

---

## TypeScript版

```ts
const fs = require("fs");

let numbers = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);

let count = 0;

while (numbers.every((num: number) => num % 2 === 0)) {
  numbers = numbers.map((num: number) => num / 2);
  count++;
}

console.log(count);
```

---

## TypeScript版：for / if で書く場合

```ts
const fs = require("fs");

let numbers = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);

let count = 0;

while (true) {
  let allEven = true;

  for (let i = 0; i < numbers.length; i++) {
    if (numbers[i] % 2 !== 0) {
      allEven = false;
      break;
    }
  }

  if (!allEven) {
    break;
  }

  for (let i = 0; i < numbers.length; i++) {
    numbers[i] = numbers[i] / 2;
  }

  count++;
}

console.log(count);
```

---

## この問題で新しく出てきた文法事項

### `.slice(1)`

```ts
let numbers = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);
```

`.slice(1)` は、配列の1番目以降を取り出す。

今回の入力は、

```txt
3
8 12 40
```

であり、読み取った配列は以下のようになる。

```ts
[3, 8, 12, 40]
```

このうち、先頭の `3` は整数の個数 `N`。

実際に処理したいのは、

```ts
[8, 12, 40]
```

なので、`.slice(1)` で先頭の `N` を除外している。

```ts
[3, 8, 12, 40].slice(1)
```

結果：

```ts
[8, 12, 40]
```

---

### `let numbers`

```ts
let numbers = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);
```

`let` は、あとから値を変更できる変数を宣言する。

この問題では、操作のたびに `numbers` の中身を2で割って更新する。

```ts
numbers = numbers.map((num: number) => num / 2);
```

そのため、`const` ではなく `let` を使っている。

`const` は再代入できない。

```ts
const numbers = [8, 12, 40];
numbers = [4, 6, 20]; // エラー
```

一方で、`let` は再代入できる。

```ts
let numbers = [8, 12, 40];
numbers = [4, 6, 20]; // OK
```

---

### `while` 文

```ts
while (numbers.every((num: number) => num % 2 === 0)) {
  numbers = numbers.map((num: number) => num / 2);
  count++;
}
```

`while` 文は、条件が true の間、同じ処理を繰り返す。

基本形：

```ts
while (条件) {
  処理
}
```

今回の場合、

```ts
numbers.every((num: number) => num % 2 === 0)
```

が true の間だけ、処理を繰り返す。

つまり、

```txt
すべての数が偶数なら
  すべての数を2で割る
  countを1増やす
```

という処理。

---

### `every()`

```ts
numbers.every((num: number) => num % 2 === 0)
```

`every()` は、配列のすべての要素が条件を満たすかどうかを判定するメソッド。

例えば、

```ts
[8, 12, 40].every((num: number) => num % 2 === 0)
```

結果：

```txt
true
```

すべて偶数だから true。

一方で、

```ts
[4, 6, 15].every((num: number) => num % 2 === 0)
```

結果：

```txt
false
```

`15` が奇数なので false。

この問題では、すべての数が偶数の間だけ、全体を2で割れる。

---

### `map()`

```ts
numbers = numbers.map((num: number) => num / 2);
```

`map()` は、配列の各要素を変換して、新しい配列を作るメソッド。

例えば、

```ts
[8, 12, 40].map((num: number) => num / 2)
```

結果：

```ts
[4, 6, 20]
```

今回の問題では、すべての数を2で割るために使っている。

---

### `num % 2 === 0`

```ts
num % 2 === 0
```

`%` は割り算の余りを求める演算子。

`num % 2 === 0` は、`num` が偶数かどうかを判定している。

例えば、

```ts
8 % 2 === 0
```

結果：

```txt
true
```

```ts
15 % 2 === 0
```

結果：

```txt
false
```

この問題では、「すべての数が偶数かどうか」を調べるために使う。

---

### `count++`

```ts
count++;
```

`count++` は、`count` を 1 増やす書き方。

以下と同じ意味。

```ts
count = count + 1;
```

この問題では、すべての数を2で割る操作を1回行うたびに、`count` を1増やしている。

---

### `while (true)`

```ts
while (true) {
  // 処理
}
```

`while (true)` は、条件が常に true なので、そのままだと無限ループになる。

そのため、ループの中で `break` を使って抜ける必要がある。

この問題では、すべての数が偶数でなくなったら、ループを終了する。

```ts
if (!allEven) {
  break;
}
```

---

### `break`

```ts
break;
```

`break` は、ループを途中で終了するために使う。

今回の for / if 版では、奇数が見つかった時点で、これ以上確認する必要がないため `break` している。

```ts
if (numbers[i] % 2 !== 0) {
  allEven = false;
  break;
}
```

---

### `!allEven`

```ts
if (!allEven) {
  break;
}
```

`!` は真偽値を反転する演算子。

```ts
!true
```

結果：

```txt
false
```

```ts
!false
```

結果：

```txt
true
```

`allEven` は「すべて偶数かどうか」を表す変数。

`!allEven` は、

```txt
すべて偶数ではない
```

という意味になる。

---

## PHP版

### `array_map()` / `array_filter()` を使う場合

```php
<?php

$input = trim(stream_get_contents(STDIN));
$numbers = array_map('intval', preg_split('/\s+/', $input));
$numbers = array_slice($numbers, 1);

$count = 0;

while (count(array_filter($numbers, fn($num) => $num % 2 !== 0)) === 0) {
    $numbers = array_map(fn($num) => intdiv($num, 2), $numbers);
    $count++;
}

echo $count . PHP_EOL;
```

---

### PHP版：for / if で書く場合

```php
<?php

$input = trim(stream_get_contents(STDIN));
$numbers = array_map('intval', preg_split('/\s+/', $input));
$numbers = array_slice($numbers, 1);

$count = 0;

while (true) {
    $allEven = true;

    for ($i = 0; $i < count($numbers); $i++) {
        if ($numbers[$i] % 2 !== 0) {
            $allEven = false;
            break;
        }
    }

    if (!$allEven) {
        break;
    }

    for ($i = 0; $i < count($numbers); $i++) {
        $numbers[$i] = intdiv($numbers[$i], 2);
    }

    $count++;
}

echo $count . PHP_EOL;
```

---

### `array_slice()`

```php
$numbers = array_slice($numbers, 1);
```

`array_slice()` は、配列の一部を取り出す関数。

今回の入力は、

```txt
3
8 12 40
```

であり、読み取った配列は以下のようになる。

```php
[3, 8, 12, 40]
```

このうち、先頭の `3` は整数の個数 `N`。

実際に処理したいのは、

```php
[8, 12, 40]
```

なので、`array_slice($numbers, 1)` で先頭の `N` を除外している。

```php
array_slice([3, 8, 12, 40], 1)
```

結果：

```php
[8, 12, 40]
```

---

### PHPの `array_*` 系関数の引数順

PHPの `array_*` 系関数は、元の配列を入れる位置が関数によって違う。

今回出てくる主な関数は以下。

```php
array_map('intval', $tokens)
array_slice($numbers, 1)
array_filter($numbers, fn($num) => $num % 2 !== 0)
```

対応は以下。

| 関数               | 元の配列の位置 | 例                                         |
| ---------------- | ------- | ----------------------------------------- |
| `array_map()`    | 第2引数    | `array_map('intval', $tokens)`            |
| `array_slice()`  | 第1引数    | `array_slice($numbers, 1)`                |
| `array_filter()` | 第1引数    | `array_filter($numbers, fn($num) => ...)` |

特に紛らわしいのは、

```php
array_map(処理, 配列)
array_filter(配列, 条件)
```

という違い。

PHPでは配列メソッドではなく関数として書くため、引数順を確認しながら使う必要がある。

---

### `while` 文

```php
while (count(array_filter($numbers, fn($num) => $num % 2 !== 0)) === 0) {
    $numbers = array_map(fn($num) => intdiv($num, 2), $numbers);
    $count++;
}
```

`while` 文は、条件が true の間、同じ処理を繰り返す。

基本形：

```php
while (条件) {
    処理
}
```

今回の場合、

```php
count(array_filter($numbers, fn($num) => $num % 2 !== 0)) === 0
```

が true の間だけ処理を繰り返す。

これは、

```txt
奇数の個数が0個なら
```

という意味。

つまり、

```txt
すべての数が偶数なら
```

という条件になる。

---

### `array_filter()` で「すべて偶数」を判定する

```php
count(array_filter($numbers, fn($num) => $num % 2 !== 0)) === 0
```

PHPには、TypeScriptの `every()` に完全対応する標準関数がない。

そのため、ここでは以下のように考える。

```txt
奇数の要素だけ取り出す
↓
奇数の個数を数える
↓
奇数が0個なら、すべて偶数
```

例えば、

```php
$numbers = [8, 12, 40];
```

の場合、

```php
array_filter($numbers, fn($num) => $num % 2 !== 0)
```

結果：

```php
[]
```

奇数がないので空配列になる。

```php
count([])
```

結果：

```txt
0
```

したがって、

```php
count(array_filter($numbers, fn($num) => $num % 2 !== 0)) === 0
```

は true になる。

一方で、

```php
$numbers = [4, 6, 15];
```

の場合、

```php
array_filter($numbers, fn($num) => $num % 2 !== 0)
```

結果：

```php
[
    2 => 15,
]
```

奇数があるため、個数は `1`。

したがって、条件は false になる。

---

### `!==`

```php
$num % 2 !== 0
```

`!==` は、値または型が等しくないかを判定する演算子。

PHPには、

```php
!=
```

と

```php
!==
```

がある。

`!=` は型変換をしたうえで比較する場合がある。

`!==` は型変換せずに比較する。

今回のように整数同士を比較する場合でも、基本的には `!==` を使う方が安全。

```php
$num % 2 !== 0
```

は、

```txt
$num を2で割った余りが0ではない
```

という意味。

つまり、奇数かどうかを判定している。

---

### `intdiv()`

```php
$numbers = array_map(fn($num) => intdiv($num, 2), $numbers);
```

`intdiv()` は整数の割り算を行う関数。

例えば、

```php
intdiv(8, 2)
```

結果：

```txt
4
```

```php
intdiv(12, 2)
```

結果：

```txt
6
```

PHPの `/` は通常の割り算で、結果が小数になることがある。

```php
5 / 2
```

結果：

```txt
2.5
```

整数として割りたい場合は、`intdiv()` を使う。

この問題では、すべて偶数であることを確認してから2で割っているので、

```php
$num / 2
```

でも結果は整数になる。

ただし、整数として扱うことを明確にするなら、

```php
intdiv($num, 2)
```

の方がよい。

---

### PHPの `while (true)`

```php
while (true) {
    // 処理
}
```

`while (true)` は、条件が常に true なので、そのままだと無限ループになる。

そのため、ループの中で `break` を使って抜ける必要がある。

```php
if (!$allEven) {
    break;
}
```

この問題では、奇数が見つかった時点で操作を続けられないため、ループを終了する。

---

### PHPの `break`

```php
break;
```

`break` は、ループを途中で終了するために使う。

今回の for / if 版では、奇数が見つかった時点で、これ以上確認する必要がないため `break` している。

```php
if ($numbers[$i] % 2 !== 0) {
    $allEven = false;
    break;
}
```

---

### `!$allEven`

```php
if (!$allEven) {
    break;
}
```

`!` は真偽値を反転する演算子。

```php
!true
```

結果：

```txt
false
```

```php
!false
```

結果：

```txt
true
```

`$allEven` は「すべて偶数かどうか」を表す変数。

`!$allEven` は、

```txt
すべて偶数ではない
```

という意味になる。

---

## TypeScript と PHP の対応表

| 処理             | TypeScript           | PHP                              |
| -------------- | -------------------- | -------------------------------- |
| 先頭要素を除外する      | `.slice(1)`          | `array_slice($numbers, 1)`       |
| すべての要素が条件を満たすか | `numbers.every(...)` | `count(array_filter(...)) === 0` |
| 各要素を変換する       | `numbers.map(...)`   | `array_map(...)`                 |
| 奇数か判定する        | `num % 2 !== 0`      | `$num % 2 !== 0`                 |
| 偶数か判定する        | `num % 2 === 0`      | `$num % 2 === 0`                 |
| 整数除算           | `num / 2`            | `intdiv($num, 2)`                |
| while文         | `while (条件) {}`      | `while (条件) {}`                  |
| 無限ループ          | `while (true) {}`    | `while (true) {}`                |
| ループを抜ける        | `break`              | `break`                          |
| 真偽値の反転         | `!allEven`           | `!$allEven`                      |
| カウントを1増やす      | `count++`            | `$count++`                       |
| 標準出力           | `console.log(count)` | `echo $count . PHP_EOL`          |

---

# この問題で重要なポイント

## 1. 先頭の `N` は処理対象から外す

入力は、

```txt
N
A1 A2 ... AN
```

の形。

読み取った配列には、先頭に `N` が入る。

```ts
[3, 8, 12, 40]
```

処理したいのは `A1 A2 ... AN` だけなので、先頭を除外する。

TypeScript：

```ts
.slice(1)
```

PHP：

```php
array_slice($numbers, 1)
```

---

## 2. 「すべて偶数」の間だけ操作する

この問題は、

```txt
すべての数が偶数なら、全てを2で割る
```

という操作を何回できるかを数える問題。

TypeScriptでは、`every()` を使うと自然に書ける。

```ts
numbers.every((num: number) => num % 2 === 0)
```

PHPでは、奇数だけを取り出して、その個数が0個かどうかで判定する。

```php
count(array_filter($numbers, fn($num) => $num % 2 !== 0)) === 0
```

---

## 3. すべての数を2で割る

TypeScript：

```ts
numbers = numbers.map((num: number) => num / 2);
```

PHP：

```php
$numbers = array_map(fn($num) => intdiv($num, 2), $numbers);
```

各要素を変換して、新しい配列として更新している。

---
