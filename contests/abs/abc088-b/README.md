# ABC088B - Card Game for Two の TypeScript / PHP 文法メモ

対象問題：

```txt
ABC088B - Card Game for Two
```

URL：

```txt
https://atcoder.jp/contests/abs/tasks/abc088_b
```

入力：

```txt
N
a1 a2 ... aN
```

ただし、`a1, a2, ..., aN` はカードに書かれた整数。

例：

```txt
3
2 7 4
```

出力：

```txt
Alice の合計点 - Bob の合計点
```

例：

```txt
5
```

---

## 解法の共通の考え方

この問題は、Alice と Bob が交互にカードを取るゲーム。

どちらも毎回、残っているカードの中から一番大きいカードを取る。

そのため、カードを大きい順に並べて考えると分かりやすい。

```txt
大きい順に並べる
↓
0番目、2番目、4番目 ... は Alice
1番目、3番目、5番目 ... は Bob
↓
Alice の合計 - Bob の合計を求める
```

---

## 解法1：降順ソートして交互に足し引きする

カードを最初に大きい順に並べる。

その後、配列の添字を見て、

```txt
偶数番目 → Alice が取るので足す
奇数番目 → Bob が取るので引く
```

とする。

例えば、

```txt
2 7 4
```

を降順に並べると、

```txt
7 4 2
```

になる。

このとき、

```txt
Alice: 7 + 2 = 9
Bob: 4
差: 9 - 4 = 5
```

となる。

この問題では、この解法が一番簡単。

---

## 解法2：毎回最大値を探して1枚ずつ削除する

実際のゲームの流れに近い形で解く方法。

毎回、残っているカードの中から最大値を探す。

```txt
1. 最大値を探す
2. Alice の番なら足す、Bob の番なら引く
3. その最大値のカードを1枚削除する
4. カードがなくなるまで繰り返す
```

この解法では、

```txt
最大値を取得する
最大値の位置を取得する
その位置のカードを1枚削除する
```

という処理が必要になる。

TypeScriptでは、

```ts
Math.max(...nums)
nums.indexOf(max)
nums.splice(index, 1)
```

PHPでは、

```php
max($cards)
array_search($max, $cards, true)
array_splice($cards, $index, 1)
```

を使う。

---

## TypeScript版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);

const cards = input.sort((a: number, b: number) => b - a);

let result = 0;

for (let i = 0; i < cards.length; i++) {
  result = i % 2 === 0 ? result + cards[i]
    : result - cards[i];
}

console.log(result);
```

---

## TypeScript版：毎回最大値を探して削除する場合

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);

let nums = input;
let count = 1;
let result = 0;

while (nums.length > 0) {
  const max = Math.max(...nums);
  const index = nums.indexOf(max);

  result = count % 2 ? result + max
    : result - max;

  nums.splice(index, 1);
  count++;
}

console.log(result);
```

---

## この問題で新しく出てきた文法事項

### `.sort((a, b) => b - a)`

```ts
const cards = input.sort((a: number, b: number) => b - a);
```

`sort()` は、配列を並び替えるメソッド。

TypeScript / JavaScript の `sort()` は、そのまま使うと文字列として並び替えるため、数値の大小順にしたい場合は比較関数を書く。

降順、つまり大きい順に並べる場合は以下。

```ts
sort((a, b) => b - a)
```

例えば、

```ts
[2, 7, 4].sort((a, b) => b - a)
```

結果：

```ts
[7, 4, 2]
```

この問題では、強いカードから順番に取っていくため、最初に降順ソートしている。

---

### `sort()` は元の配列を変更する

```ts
const cards = input.sort((a: number, b: number) => b - a);
```

`sort()` は、元の配列自体を並び替える。

例えば、

```ts
const input = [2, 7, 4];
const cards = input.sort((a, b) => b - a);
```

このとき、`cards` だけでなく `input` も並び替わる。

```ts
input // [7, 4, 2]
cards // [7, 4, 2]
```

元の配列を残したい場合は、コピーしてから並び替える。

```ts
const cards = [...input].sort((a, b) => b - a);
```

AtCoderでは元の配列を残す必要がないことが多いため、そのまま `sort()` して問題ない。

---

### `i % 2 === 0`

```ts
i % 2 === 0
```

`i % 2 === 0` は、`i` が偶数かどうかを判定している。

この問題では、降順に並べたカードについて、

```txt
0番目 → Alice
1番目 → Bob
2番目 → Alice
3番目 → Bob
```

となる。

配列の添字は `0` から始まるため、

```txt
偶数番目 → Alice
奇数番目 → Bob
```

として処理できる。

---

### 三項演算子で加算・減算を切り替える

```ts
result = i % 2 === 0 ? result + cards[i]
  : result - cards[i];
```

三項演算子は、条件によって値を切り替える書き方。

基本形：

```ts
条件 ? trueのときの値 : falseのときの値
```

今回の場合、

```ts
i % 2 === 0
```

が true なら Alice の番なので、

```ts
result + cards[i]
```

を代入する。

false なら Bob の番なので、

```ts
result - cards[i]
```

を代入する。

つまり、以下の `if` 文と同じ意味。

```ts
if (i % 2 === 0) {
  result += cards[i];
} else {
  result -= cards[i];
}
```

---

### `Math.max(...nums)`

```ts
const max = Math.max(...nums);
```

`Math.max()` は、最大値を求める関数。

ただし、配列をそのまま渡すことはできない。

誤り：

```ts
Math.max(nums)
```

正しい書き方：

```ts
Math.max(...nums)
```

`...nums` はスプレッド構文で、配列の中身を展開する。

例えば、

```ts
const nums = [2, 7, 4];

Math.max(...nums)
```

は、以下と同じような意味になる。

```ts
Math.max(2, 7, 4)
```

結果：

```txt
7
```

---

### `indexOf()`

```ts
const index = nums.indexOf(max);
```

`indexOf()` は、配列の中から指定した値を探し、その位置を返すメソッド。

例えば、

```ts
const nums = [2, 7, 4];
const index = nums.indexOf(7);
```

結果：

```txt
1
```

配列の添字は `0` から始まるため、`7` の位置は `1` になる。

この問題では、最大値のカードを削除するために、最大値がある位置を取得している。

---

### `splice()`

```ts
nums.splice(index, 1);
```

`splice()` は、配列の一部を削除・追加するメソッド。

今回の使い方は、

```ts
nums.splice(index, 1);
```

で、

```txt
index の位置から1個削除する
```

という意味。

例えば、

```ts
const nums = [2, 7, 4];
nums.splice(1, 1);
```

結果：

```ts
[2, 4]
```

この問題では、最大値のカードを1枚取った後、そのカードを配列から削除するために使っている。

---

### `while (nums.length > 0)`

```ts
while (nums.length > 0) {
  // 処理
}
```

`while` 文は、条件が true の間、同じ処理を繰り返す。

今回の場合、

```ts
nums.length > 0
```

なので、

```txt
カードがまだ残っている間
```

処理を繰り返す。

ループの中で、

```ts
nums.splice(index, 1);
```

によってカードを1枚ずつ削除するため、最終的には `nums.length` が `0` になり、ループが終了する。

---

## PHP版

### 降順ソートして交互に足し引きする場合

```php
<?php

$input = trim(stream_get_contents(STDIN));

$nums = array_map("intval", preg_split("/\s+/", $input));

$cards = array_slice($nums, 1);
rsort($cards);

$result = 0;

for ($i = 0; $i < count($cards); $i++) {
    $result = $i % 2 === 0 ? $result + $cards[$i]
        : $result - $cards[$i];
}

echo $result . PHP_EOL;
```

---

### PHP版：毎回最大値を探して削除する場合

```php
<?php

$input = trim(stream_get_contents(STDIN));
$nums = array_map("intval", preg_split("/\s+/", $input));

$cards = array_slice($nums, 1);

$count = 0;
$result = 0;

while (count($cards) > 0) {
    $max = max($cards);
    $index = array_search($max, $cards, true);

    $result = $count % 2 === 0 ? $result + $max : $result - $max;

    array_splice($cards, $index, 1);

    $count++;
}

echo $result . PHP_EOL;
```

---

### `array_slice()`

```php
$cards = array_slice($nums, 1);
```

`array_slice()` は、配列の一部を取り出す関数。

今回の入力は、

```txt
3
2 7 4
```

であり、読み取った配列は以下になる。

```php
[3, 2, 7, 4]
```

このうち、先頭の `3` はカードの枚数 `N`。

実際に処理したいのは、

```php
[2, 7, 4]
```

なので、`array_slice($nums, 1)` で先頭の `N` を除外している。

---

### `rsort()`

```php
rsort($cards);
```

`rsort()` は、配列を降順、つまり大きい順に並び替える関数。

例えば、

```php
$cards = [2, 7, 4];

rsort($cards);
```

結果：

```php
[7, 4, 2]
```

この問題では、Alice と Bob が常に最大のカードを取るため、最初に降順ソートしている。

注意点として、`rsort()` は元の配列を直接変更する。

また、戻り値は並び替え後の配列ではなく、成功したかどうかを表す `true / false`。

そのため、以下は誤り。

```php
$cards = rsort($cards);
```

正しくは、次のように書く。

```php
rsort($cards);
```

---

### `count($cards)`

```php
for ($i = 0; $i < count($cards); $i++) {
  // 処理
}
```

`count()` は、配列の要素数を数える関数。

例えば、

```php
count([7, 4, 2])
```

結果：

```txt
3
```

この問題では、カードの枚数分だけループするために使っている。

---

### PHPの三項演算子で加算・減算を切り替える

```php
$result = $i % 2 === 0 ? $result + $cards[$i]
    : $result - $cards[$i];
```

PHPでも三項演算子が使える。

基本形：

```php
条件 ? trueのときの値 : falseのときの値
```

今回の場合、

```php
$i % 2 === 0
```

が true なら Alice の番なので、

```php
$result + $cards[$i]
```

を代入する。

false なら Bob の番なので、

```php
$result - $cards[$i]
```

を代入する。

つまり、以下の `if` 文と同じ意味。

```php
if ($i % 2 === 0) {
    $result += $cards[$i];
} else {
    $result -= $cards[$i];
}
```

---

### `max($cards)`

```php
$max = max($cards);
```

`max()` は、配列の中の最大値を取得する関数。

例えば、

```php
$cards = [2, 7, 4];

$max = max($cards);
```

結果：

```txt
7
```

TypeScriptでは配列を展開して、

```ts
Math.max(...nums)
```

と書いたが、PHPでは、

```php
max($cards)
```

で配列の最大値を取得できる。

---

### `array_search()`

```php
$index = array_search($max, $cards, true);
```

`array_search()` は、配列の中から指定した値を探し、その位置を返す関数。

例えば、

```php
$cards = [2, 7, 4];

$index = array_search(7, $cards, true);
```

結果：

```txt
1
```

この問題では、最大値のカードを削除するために、最大値がある位置を取得している。

第3引数の `true` は、厳密比較をする指定。

```php
array_search($max, $cards, true)
```

と書くことで、型変換をせずに値を探す。

AtCoderでは数値配列を扱うため大きな差は出にくいが、基本的には `true` を付けておくと安全。

---

### `array_splice()`

```php
array_splice($cards, $index, 1);
```

`array_splice()` は、配列の一部を削除・置換する関数。

今回の使い方は、

```php
array_splice($cards, $index, 1);
```

で、

```txt
$index の位置から1個削除する
```

という意味。

例えば、

```php
$cards = [2, 7, 4];

array_splice($cards, 1, 1);
```

結果：

```php
[2, 4]
```

この問題では、最大値のカードを1枚取った後、そのカードを配列から削除するために使っている。

注意点として、`array_splice()` の第2引数は、削除したい値ではなく、削除したい位置。

誤り：

```php
array_splice($cards, $max, 1);
```

正しい書き方：

```php
array_splice($cards, $index, 1);
```

---

### `while (count($cards) > 0)`

```php
while (count($cards) > 0) {
    // 処理
}
```

`while` 文は、条件が true の間、同じ処理を繰り返す。

今回の場合、

```php
count($cards) > 0
```

なので、

```txt
カードがまだ残っている間
```

処理を繰り返す。

ループの中で、

```php
array_splice($cards, $index, 1);
```

によってカードを1枚ずつ削除するため、最終的には `count($cards)` が `0` になり、ループが終了する。

---

## TypeScript と PHP の対応表

| 処理             | TypeScript                              | PHP                                          |
| -------------- | --------------------------------------- | -------------------------------------------- |
| 先頭要素を除外する      | `.slice(1)`                             | `array_slice($nums, 1)`                      |
| 降順に並び替える       | `.sort((a, b) => b - a)`                | `rsort($cards)`                              |
| 配列の長さ          | `cards.length`                          | `count($cards)`                              |
| 偶数番目か判定する      | `i % 2 === 0`                           | `$i % 2 === 0`                               |
| 条件で加算・減算を切り替える | `result = 条件 ? result + x : result - x` | `$result = 条件 ? $result + $x : $result - $x` |
| 最大値を取得する       | `Math.max(...nums)`                     | `max($cards)`                                |
| 値の位置を取得する      | `nums.indexOf(max)`                     | `array_search($max, $cards, true)`           |
| 位置を指定して1個削除する  | `nums.splice(index, 1)`                 | `array_splice($cards, $index, 1)`            |
| while文         | `while (nums.length > 0) {}`            | `while (count($cards) > 0) {}`               |
| カウントを1増やす      | `count++`                               | `$count++`                                   |
| 標準出力           | `console.log(result)`                   | `echo $result . PHP_EOL`                     |

---

# この問題で重要なポイント

## 1. 降順ソートすると処理が簡単になる

この問題は、Alice も Bob も毎回一番大きいカードを取る。

そのため、最初に降順ソートしておけば、あとは順番に見ていくだけでよい。

```txt
0番目 → Alice
1番目 → Bob
2番目 → Alice
3番目 → Bob
```

TypeScript：

```ts
const cards = input.sort((a, b) => b - a);
```

PHP：

```php
rsort($cards);
```

---

## 2. `sort()` と `rsort()` は元の配列を変更する

TypeScriptの `sort()` も、PHPの `rsort()` も、元の配列を直接変更する。

TypeScript：

```ts
input.sort((a, b) => b - a);
```

PHP：

```php
rsort($cards);
```

PHPの `rsort()` は、戻り値を代入しない点に注意する。

誤り：

```php
$cards = rsort($cards);
```

正しい書き方：

```php
rsort($cards);
```

---

## 3. 最大値を毎回削除する解法では、値ではなく位置を削除する

最大値を削除する場合、まず最大値を取得する。

TypeScript：

```ts
const max = Math.max(...nums);
```

PHP：

```php
$max = max($cards);
```

次に、その最大値がある位置を取得する。

TypeScript：

```ts
const index = nums.indexOf(max);
```

PHP：

```php
$index = array_search($max, $cards, true);
```

最後に、その位置の要素を1個削除する。

TypeScript：

```ts
nums.splice(index, 1);
```

PHP：

```php
array_splice($cards, $index, 1);
```

PHPで以下のように書くと誤り。

```php
array_splice($cards, $max, 1);
```

`$max` はカードの値であり、配列上の位置ではない。

---

# 推奨する書き方

## TypeScript

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);

const cards = input.sort((a: number, b: number) => b - a);

let result = 0;

for (let i = 0; i < cards.length; i++) {
  result = i % 2 === 0 ? result + cards[i]
    : result - cards[i];
}

console.log(result);
```

## TypeScript：毎回最大値を探して削除する版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);

let nums = input;
let count = 1;
let result = 0;

while (nums.length > 0) {
  const max = Math.max(...nums);
  const index = nums.indexOf(max);

  result = count % 2 ? result + max
    : result - max;

  nums.splice(index, 1);
  count++;
}

console.log(result);
```

## PHP

```php
<?php

$input = trim(stream_get_contents(STDIN));

$nums = array_map("intval", preg_split("/\s+/", $input));

$cards = array_slice($nums, 1);
rsort($cards);

$result = 0;

for ($i = 0; $i < count($cards); $i++) {
    $result = $i % 2 === 0 ? $result + $cards[$i]
        : $result - $cards[$i];
}

echo $result . PHP_EOL;
```

## PHP：毎回最大値を探して削除する版

```php
<?php

$input = trim(stream_get_contents(STDIN));
$nums = array_map("intval", preg_split("/\s+/", $input));

$cards = array_slice($nums, 1);

$count = 0;
$result = 0;

while (count($cards) > 0) {
    $max = max($cards);
    $index = array_search($max, $cards, true);

    $result = $count % 2 === 0 ? $result + $max : $result - $max;

    array_splice($cards, $index, 1);

    $count++;
}

echo $result . PHP_EOL;
```
