# ABC083B - Some Sums の TypeScript / PHP 文法メモ

対象問題：

```txt
ABC083B - Some Sums
```

URL：

```txt
https://atcoder.jp/contests/abs/tasks/abc083_b
```

入力：

```txt
N A B
```

ただし、`N` は調べる最大値、`A` と `B` は桁和の範囲。

例：

```txt
20 2 5
```

出力：

```txt
1 以上 N 以下の整数のうち、各桁の和が A 以上 B 以下であるものの総和
```

例：

```txt
84
```

---

## 解法の共通の考え方

この問題は、`1` から `N` までの整数をすべて調べる全探索の問題。

各整数 `i` について、各桁の和を求める。

例えば、

```txt
i = 123
```

なら、桁和は以下になる。

```txt
1 + 2 + 3 = 6
```

この桁和が、

```txt
A <= 桁和 <= B
```

を満たすとき、その整数 `i` を答えに加える。

---

## 解法1：文字列に変換して桁和を求める

数値 `i` を文字列に変換し、1文字ずつ分割して、各桁を数値に戻して合計する。

```txt
123
↓
"123"
↓
["1", "2", "3"]
↓
[1, 2, 3]
↓
1 + 2 + 3 = 6
```

TypeScriptでは、

```ts
String(i).split("").map(Number).reduce((total, digit) => total + digit, 0)
```

PHPでは、

```php
array_sum(array_map('intval', str_split((string) $i)))
```

のように書ける。

文字列処理として考えられるので、学習段階では分かりやすい解法。

---

## 解法2：数値計算で桁和を求める

文字列に変換せず、数値のまま各桁を取り出す。

例えば、`123` の場合、

```txt
123 % 10 = 3
12 % 10 = 2
1 % 10 = 1
```

となるため、

```txt
3 + 2 + 1 = 6
```

で桁和を求められる。

各桁を取り出すには、以下を繰り返す。

```txt
1. num % 10 で一の位を取り出す
2. num / 10 の整数部分を使って、一の位を削る
```

TypeScriptでは、

```ts
num = Math.floor(num / 10);
```

PHPでは、

```php
$num = intdiv($num, 10);
```

または、

```php
$num = floor($num / 10);
```

を使える。

ただし、整数として扱うなら `intdiv()` の方が明確。

---

## TypeScript版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const n = input[0];
const a = input[1];
const b = input[2];

let ansSum = 0;

for (let i = 0; i <= n; i++) {
  const digitSum = String(i).split("").map(Number).reduce((total, digit) => total + digit, 0);

  ansSum = (a <= digitSum && digitSum <= b) ? ansSum + i : ansSum;
}

console.log(ansSum);
```

---

## TypeScript版：数値計算で書く場合

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const n = input[0];
const a = input[1];
const b = input[2];

let ansSum = 0;

for (let i = 0; i <= n; i++) {
  let digitSum = 0;
  let num = i;

  while (num > 0) {
    digitSum += num % 10;
    num = Math.floor(num / 10);
  }

  if (a <= digitSum && digitSum <= b) {
    ansSum += i;
  }
}

console.log(ansSum);
```

---

## この問題で新しく出てきた文法事項

### `String(i)`

```ts
String(i)
```

`String(i)` は、数値 `i` を文字列に変換する。

例えば、

```ts
String(123)
```

結果：

```txt
"123"
```

この問題では、数値を1桁ずつ分割したいため、まず文字列に変換している。

---

### `split("")` で1文字ずつ分割する

```ts
String(i).split("")
```

`split("")` は、文字列を1文字ずつ分割して配列にする。

例えば、

```ts
String(123).split("")
```

結果：

```ts
["1", "2", "3"]
```

このままだと各要素は文字列なので、数値として合計するには `Number` で変換する必要がある。

---

### `.map(Number)`

```ts
String(i).split("").map(Number)
```

`.map(Number)` は、配列の各要素を数値に変換する。

例えば、

```ts
["1", "2", "3"].map(Number)
```

結果：

```ts
[1, 2, 3]
```

この問題では、各桁を数値として合計するために使っている。

---

### `reduce()`

```ts
.reduce((total, digit) => total + digit, 0)
```

`reduce()` は、配列の要素を1つの値にまとめるメソッド。

今回の場合は、配列の各要素を足し合わせている。

例えば、

```ts
[1, 2, 3].reduce((total, digit) => total + digit, 0)
```

結果：

```txt
6
```

`reduce()` の基本形は以下。

```ts
配列.reduce((累積値, 現在の要素) => 次の累積値, 初期値)
```

今回のコードでは、

```ts
(total, digit) => total + digit
```

によって、現在の合計 `total` に、現在の桁 `digit` を足している。

最後の `0` は、合計の初期値。

---

### `const digitSum`

```ts
const digitSum = String(i).split("").map(Number).reduce((total, digit) => total + digit, 0);
```

`digitSum` は、現在調べている整数 `i` の桁和。

例えば、

```txt
i = 123
```

なら、

```txt
digitSum = 6
```

になる。

この問題では、`digitSum` が `a` 以上 `b` 以下かどうかを判定する。

---

### 三項演算子で代入する

```ts
ansSum = (a <= digitSum && digitSum <= b) ? ansSum + i : ansSum;
```

三項演算子は、条件によって値を切り替える書き方。

基本形：

```ts
条件 ? trueのときの値 : falseのときの値
```

今回の場合、

```ts
a <= digitSum && digitSum <= b
```

が true なら、

```ts
ansSum + i
```

を `ansSum` に代入する。

false なら、

```ts
ansSum
```

をそのまま代入する。

つまり、以下の `if` 文と同じ意味。

```ts
if (a <= digitSum && digitSum <= b) {
  ansSum += i;
}
```

学習段階では、`if` 文の方が読みやすい場合もある。

---

### `num % 10`

```ts
digitSum += num % 10;
```

`num % 10` は、`num` の一の位を取り出すために使う。

例えば、

```ts
123 % 10
```

結果：

```txt
3
```

```ts
12 % 10
```

結果：

```txt
2
```

この問題では、数値計算で桁和を求めるために使っている。

---

### `Math.floor(num / 10)`

```ts
num = Math.floor(num / 10);
```

`Math.floor()` は、小数点以下を切り捨てる関数。

例えば、

```ts
Math.floor(12.3)
```

結果：

```txt
12
```

この問題では、

```ts
num / 10
```

によって一の位を削り、その整数部分だけを残している。

例えば、

```ts
Math.floor(123 / 10)
```

結果：

```txt
12
```

これにより、次のループでは `12` の一の位、つまり `2` を取り出せる。

---

### `while (num > 0)`

```ts
while (num > 0) {
  digitSum += num % 10;
  num = Math.floor(num / 10);
}
```

`while` 文は、条件が true の間、同じ処理を繰り返す。

この場合、

```ts
num > 0
```

の間だけ処理を繰り返す。

`num` はループのたびに10で割られて小さくなるため、最終的には `0` になり、ループが終了する。

---

## PHP版

### 文字列に変換して桁和を求める場合

```php
<?php

$input = trim(stream_get_contents(STDIN));
$nums = array_map("intval", preg_split("/\s+/", $input));

$n = $nums[0];
$a = $nums[1];
$b = $nums[2];

$ansSum = 0;

for ($i = 0; $i <= $n; $i++) {
    $digitSum = array_sum(array_map('intval', str_split((string) $i)));

    $ansSum = ($a <= $digitSum && $digitSum <= $b) ? $ansSum + $i : $ansSum;
}

echo $ansSum . PHP_EOL;
```

---

### PHP版：数値計算で書く場合

```php
<?php

$input = trim(stream_get_contents(STDIN));
$nums = array_map("intval", preg_split("/\s+/", $input));

$n = $nums[0];
$a = $nums[1];
$b = $nums[2];

$ansSum = 0;

for ($i = 0; $i <= $n; $i++) {
    $digitSum = 0;
    $num = $i;

    while ($num > 0) {
        $digitSum += $num % 10;
        $num = intdiv($num, 10);
    }

    if ($a <= $digitSum && $digitSum <= $b) {
        $ansSum += $i;
    }
}

echo $ansSum . PHP_EOL;
```

---

### `(string) $i`

```php
(string) $i
```

`(string) $i` は、数値 `$i` を文字列に変換する。

例えば、

```php
(string) 123
```

結果：

```txt
"123"
```

この問題では、数値を1桁ずつ分割したいため、まず文字列に変換している。

---

### `str_split()`

```php
str_split((string) $i)
```

`str_split()` は、文字列を1文字ずつ分割して配列にする関数。

例えば、

```php
str_split((string) 123)
```

結果：

```php
["1", "2", "3"]
```

このままだと各要素は文字列なので、数値として合計するには `intval()` で変換する必要がある。

---

### `array_map('intval', ...)`

```php
array_map('intval', str_split((string) $i))
```

`array_map('intval', ...)` は、配列の各要素に `intval()` を適用する。

例えば、

```php
array_map('intval', ["1", "2", "3"])
```

結果：

```php
[1, 2, 3]
```

この問題では、各桁を整数として合計するために使っている。

---

### `array_sum()`

```php
array_sum(array_map('intval', str_split((string) $i)))
```

`array_sum()` は、配列の要素をすべて足し合わせる関数。

例えば、

```php
array_sum([1, 2, 3])
```

結果：

```txt
6
```

この問題では、各桁の合計を求めるために使っている。

---

### `$digitSum`

```php
$digitSum = array_sum(array_map('intval', str_split((string) $i)));
```

`$digitSum` は、現在調べている整数 `$i` の桁和。

例えば、

```txt
$i = 123
```

なら、

```txt
$digitSum = 6
```

になる。

この問題では、`$digitSum` が `$a` 以上 `$b` 以下かどうかを判定する。

---

### PHPの三項演算子で代入する

```php
$ansSum = ($a <= $digitSum && $digitSum <= $b) ? $ansSum + $i : $ansSum;
```

PHPでも三項演算子が使える。

基本形：

```php
条件 ? trueのときの値 : falseのときの値
```

今回の場合、

```php
$a <= $digitSum && $digitSum <= $b
```

が true なら、

```php
$ansSum + $i
```

を `$ansSum` に代入する。

false なら、

```php
$ansSum
```

をそのまま代入する。

つまり、以下の `if` 文と同じ意味。

```php
if ($a <= $digitSum && $digitSum <= $b) {
    $ansSum += $i;
}
```

学習段階では、`if` 文の方が読みやすい場合もある。

---

### `$num % 10`

```php
$digitSum += $num % 10;
```

`$num % 10` は、`$num` の一の位を取り出すために使う。

例えば、

```php
123 % 10
```

結果：

```txt
3
```

```php
12 % 10
```

結果：

```txt
2
```

この問題では、数値計算で桁和を求めるために使っている。

---

### `intdiv($num, 10)`

```php
$num = intdiv($num, 10);
```

`intdiv()` は、整数除算を行う関数。

例えば、

```php
intdiv(123, 10)
```

結果：

```txt
12
```

```php
intdiv(12, 10)
```

結果：

```txt
1
```

この問題では、一の位を削るために使っている。

PHPで以下のように書くこともできる。

```php
$num = floor($num / 10);
```

ただし、`floor()` は小数点以下を切り捨てる関数で、戻り値は float になる。

整数の桁処理では、

```php
$num = intdiv($num, 10);
```

の方が明確。

---

### PHPの `while ($num > 0)`

```php
while ($num > 0) {
    $digitSum += $num % 10;
    $num = intdiv($num, 10);
}
```

`while` 文は、条件が true の間、同じ処理を繰り返す。

この場合、

```php
$num > 0
```

の間だけ処理を繰り返す。

`$num` はループのたびに10で割られて小さくなるため、最終的には `0` になり、ループが終了する。

---

## TypeScript と PHP の対応表

| 処理            | TypeScript                                    | PHP                                     |
| ------------- | --------------------------------------------- | --------------------------------------- |
| 数値を文字列に変換する   | `String(i)`                                   | `(string) $i`                           |
| 文字列を1文字ずつ分割する | `.split("")`                                  | `str_split(...)`                        |
| 各文字を数値化する     | `.map(Number)`                                | `array_map('intval', ...)`              |
| 配列の合計を求める     | `.reduce((total, digit) => total + digit, 0)` | `array_sum(...)`                        |
| 桁和を表す変数       | `const digitSum`                              | `$digitSum`                             |
| 条件付きで加算する     | `ansSum = 条件 ? ansSum + i : ansSum`           | `$ansSum = 条件 ? $ansSum + $i : $ansSum` |
| 一の位を取り出す      | `num % 10`                                    | `$num % 10`                             |
| 一の位を削る        | `Math.floor(num / 10)`                        | `intdiv($num, 10)`                      |
| while文        | `while (num > 0) {}`                          | `while ($num > 0) {}`                   |
| 加算代入          | `ansSum += i`                                 | `$ansSum += $i`                         |
| 標準出力          | `console.log(ansSum)`                         | `echo $ansSum . PHP_EOL`                |

---

# この問題で重要なポイント

## 1. 桁和を求める方法は2通りある

この問題では、各整数の桁和を求める必要がある。

主な方法は以下の2つ。

```txt
1. 文字列に変換して、1文字ずつ分割して合計する
2. 数値のまま、% 10 と整数除算で1桁ずつ取り出す
```

文字列変換版は直感的で分かりやすい。

数値計算版は、桁処理の基本として重要。

---

## 2. `reduce()` と `array_sum()` はどちらも合計を作る

TypeScriptでは、配列の合計を求めるときに `reduce()` を使える。

```ts
[1, 2, 3].reduce((total, digit) => total + digit, 0)
```

PHPでは、数値配列の合計なら `array_sum()` が使える。

```php
array_sum([1, 2, 3])
```

今回の桁和では、PHPの方が短く書ける。

---

## 3. 数値計算で桁和を求める場合は `intdiv()` が分かりやすい

PHPでは、

```php
$num = floor($num / 10);
```

でも動く。

ただし、`floor()` は小数点以下を切り捨てる関数で、戻り値は float になる。

整数の桁処理では、

```php
$num = intdiv($num, 10);
```

を使う方が明確。

TypeScript：

```ts
num = Math.floor(num / 10);
```

PHP：

```php
$num = intdiv($num, 10);
```

---

## 4. `0` から始めても答えは変わらないが、問題文に合わせるなら `1` からでよい

今回のコードでは、

```ts
for (let i = 0; i <= n; i++)
```

としている。

`i = 0` の桁和は `0` で、足しても答えに影響しない。

そのため、答えは変わらない。

ただし、問題文では `1` 以上 `N` 以下の整数を調べるので、より自然に書くなら以下。

TypeScript：

```ts
for (let i = 1; i <= n; i++)
```

PHP：

```php
for ($i = 1; $i <= $n; $i++)
```

---

# 推奨する書き方

## TypeScript

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const n = input[0];
const a = input[1];
const b = input[2];

let ansSum = 0;

for (let i = 1; i <= n; i++) {
  const digitSum = String(i)
    .split("")
    .map(Number)
    .reduce((total, digit) => total + digit, 0);

  if (a <= digitSum && digitSum <= b) {
    ansSum += i;
  }
}

console.log(ansSum);
```

## TypeScript：数値計算版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const n = input[0];
const a = input[1];
const b = input[2];

let ansSum = 0;

for (let i = 1; i <= n; i++) {
  let digitSum = 0;
  let num = i;

  while (num > 0) {
    digitSum += num % 10;
    num = Math.floor(num / 10);
  }

  if (a <= digitSum && digitSum <= b) {
    ansSum += i;
  }
}

console.log(ansSum);
```

## PHP

```php
<?php

$input = trim(stream_get_contents(STDIN));
$nums = array_map("intval", preg_split("/\s+/", $input));

$n = $nums[0];
$a = $nums[1];
$b = $nums[2];

$ansSum = 0;

for ($i = 1; $i <= $n; $i++) {
    $digitSum = array_sum(array_map('intval', str_split((string) $i)));

    if ($a <= $digitSum && $digitSum <= $b) {
        $ansSum += $i;
    }
}

echo $ansSum . PHP_EOL;
```

## PHP：数値計算版

```php
<?php

$input = trim(stream_get_contents(STDIN));
$nums = array_map("intval", preg_split("/\s+/", $input));

$n = $nums[0];
$a = $nums[1];
$b = $nums[2];

$ansSum = 0;

for ($i = 1; $i <= $n; $i++) {
    $digitSum = 0;
    $num = $i;

    while ($num > 0) {
        $digitSum += $num % 10;
        $num = intdiv($num, 10);
    }

    if ($a <= $digitSum && $digitSum <= $b) {
        $ansSum += $i;
    }
}

echo $ansSum . PHP_EOL;
```
