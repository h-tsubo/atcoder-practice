# ABC085B - Kagami Mochi の TypeScript / PHP 文法メモ

対象問題：

```txt
ABC085B - Kagami Mochi
```

URL：

```txt
https://atcoder.jp/contests/abs/tasks/abc085_b
```

入力：

```txt
N
d1
d2
...
dN
```

ただし、`d1, d2, ..., dN` は餅の直径。

例：

```txt
4
10
8
8
6
```

出力：

```txt
作ることができる鏡餅の最大段数
```

例：

```txt
3
```

---

## 解法の共通の考え方

この問題は、直径が異なる餅を何種類使えるかを数える問題。

同じ直径の餅は、重ねるときに同じ段として扱えないため、重複を除いた直径の種類数を求めればよい。

例えば、

```txt
10
8
8
6
```

の場合、直径の種類は、

```txt
10, 8, 6
```

なので、答えは `3`。

---

## 解法1：Set / array_unique で重複を除く

最も簡単な解法。

TypeScriptでは `Set` を使うと、重複を除いた値だけを管理できる。

PHPでは `array_unique()` を使うと、配列から重複を取り除ける。

```txt
[10, 8, 8, 6]
↓
[10, 8, 6]
↓
個数は 3
```

この問題では、この解法が一番短く書ける。

---

## 解法2：最大値を取り、同じ値をすべて削除する

残っている餅の中から最大値を取り、その最大値と同じ直径の餅をすべて削除する。

これを餅がなくなるまで繰り返す。

```txt
[10, 8, 8, 6]
↓
最大値 10 を数えて、10 を削除
[8, 8, 6]
↓
最大値 8 を数えて、8 をすべて削除
[6]
↓
最大値 6 を数えて、6 を削除
[]
```

数えた回数が、直径の種類数になる。

---

## 解法3：ソートして、前と違う値だけ数える

餅を降順に並べる。

その後、前に見た直径と違う場合だけ `count` を増やす。

```txt
[10, 8, 8, 6]
```

を順に見ると、

```txt
10 → 前と違うので count++
8  → 前と違うので count++
8  → 前と同じなので数えない
6  → 前と違うので count++
```

答えは `3`。

---

## TypeScript版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8")
  .trim().split(/\s+/).map(Number).slice(1);

const mochiSets = new Set(input);

console.log(mochiSets.size);
```

---

## TypeScript版：最大値を取って削除する場合

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8")
  .trim().split(/\s+/).map(Number).slice(1);

let mochis = input;
let count = 0;

while (mochis.length > 0) {
  const maxMochi = Math.max(...mochis);
  mochis = mochis.filter((mochi: number) => mochi !== maxMochi);
  count++;
}

console.log(count);
```

---

## TypeScript版：ソートして前と比較する場合

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8")
  .trim().split(/\s+/).map(Number).slice(1);

const sortedMochis = input.sort((a: number, b: number) => b - a);

let count = 0;
let prev = -1;

for (const mochi of sortedMochis) {
  if (mochi !== prev) {
    count++;
    prev = mochi;
  }
}

console.log(count);
```

---

## この問題で新しく出てきた文法事項

### `new Set(input)`

```ts
const mochiSets = new Set(input);
```

`Set` は、重複しない値だけを保持するデータ構造。

例えば、

```ts
const input = [10, 8, 8, 6];
const mochiSets = new Set(input);
```

とすると、内部的には以下のように重複が除かれる。

```txt
10, 8, 6
```

同じ値である `8` は1つだけ残る。

この問題では、餅の直径の種類数を求めればよいので、`Set` を使うと簡単に書ける。

---

### `.size`

```ts
console.log(mochiSets.size);
```

`.size` は、`Set` に含まれる要素数を取得する。

例えば、

```ts
const set = new Set([10, 8, 8, 6]);
```

の場合、重複が除かれるため、

```txt
set.size = 3
```

になる。

配列の要素数は `.length` で取得していたが、`Set` の要素数は `.size` で取得する。

```txt
配列 → .length
Set → .size
```

---

### `Math.max(...mochis)`

```ts
const maxMochi = Math.max(...mochis);
```

`Math.max()` は、最大値を求める関数。

配列をそのまま渡すことはできないため、スプレッド構文 `...` を使って配列の中身を展開する。

例えば、

```ts
const mochis = [10, 8, 8, 6];

Math.max(...mochis)
```

は、以下と同じような意味になる。

```ts
Math.max(10, 8, 8, 6)
```

結果：

```txt
10
```

この問題では、残っている餅の中で一番大きい直径を取り出すために使っている。

---

### `filter()` で最大値以外を残す

```ts
mochis = mochis.filter((mochi: number) => mochi !== maxMochi);
```

`filter()` は、条件を満たす要素だけを残すメソッド。

今回の条件は、

```ts
mochi !== maxMochi
```

なので、

```txt
最大値ではない餅だけを残す
```

という意味になる。

例えば、

```ts
const mochis = [10, 8, 8, 6];
const maxMochi = 10;
```

の場合、

```ts
mochis.filter((mochi) => mochi !== maxMochi)
```

結果：

```ts
[8, 8, 6]
```

になる。

次に最大値が `8` になり、`8` はすべて削除される。

```ts
[8, 8, 6].filter((mochi) => mochi !== 8)
```

結果：

```ts
[6]
```

このように、同じ直径の餅をまとめて削除できる。

---

### `while (mochis.length > 0)`

```ts
while (mochis.length > 0) {
  // 処理
}
```

`while` 文は、条件が true の間、同じ処理を繰り返す。

今回の場合、

```txt
餅がまだ残っている間
```

処理を繰り返す。

ループの中で、最大値と同じ餅をすべて削除するため、最終的には `mochis.length` が `0` になり、ループが終了する。

---

### `sort((a, b) => b - a)`

```ts
const sortedMochis = input.sort((a: number, b: number) => b - a);
```

`sort()` は、配列を並び替えるメソッド。

数値を降順、つまり大きい順に並べるには、以下のように書く。

```ts
sort((a, b) => b - a)
```

例えば、

```ts
[10, 8, 8, 6].sort((a, b) => b - a)
```

結果：

```ts
[10, 8, 8, 6]
```

別の例では、

```ts
[8, 10, 6, 8].sort((a, b) => b - a)
```

結果：

```ts
[10, 8, 8, 6]
```

この問題では、同じ直径の餅を隣り合わせにするために使っている。

---

### `for...of`

```ts
for (const mochi of sortedMochis) {
  // 処理
}
```

`for...of` は、配列の要素を1つずつ取り出して処理する書き方。

例えば、

```ts
const sortedMochis = [10, 8, 8, 6];

for (const mochi of sortedMochis) {
  console.log(mochi);
}
```

出力：

```txt
10
8
8
6
```

通常の `for` 文では添字 `i` を使っていたが、`for...of` では配列の値そのものを直接取り出せる。

---

### `prev`

```ts
let prev = -1;
```

`prev` は、直前に見た餅の直径を保存するための変数。

この問題では、餅の直径は正の整数なので、最初の値として存在しない値 `-1` を入れている。

```ts
let prev = -1;
```

その後、現在の餅 `mochi` が `prev` と違う場合だけ、新しい直径として数える。

```ts
if (mochi !== prev) {
  count++;
  prev = mochi;
}
```

例えば、

```txt
10, 8, 8, 6
```

を見る場合、

```txt
mochi = 10, prev = -1 → 違うので count++
mochi = 8,  prev = 10 → 違うので count++
mochi = 8,  prev = 8  → 同じなので数えない
mochi = 6,  prev = 8  → 違うので count++
```

となる。

---

## PHP版

### `array_unique()` を使う場合

```php
<?php

$input = trim(stream_get_contents(STDIN));

$mochis = array_slice(array_map("intval", preg_split("/\s+/", $input)), 1);

$uniqueMochis = array_unique($mochis);

echo count($uniqueMochis) . PHP_EOL;
```

---

### PHP版：最大値を取って削除する場合

```php
<?php

$input = trim(stream_get_contents(STDIN));
$mochis = array_slice(array_map("intval", preg_split("/\s+/", $input)), 1);

$count = 0;

while (count($mochis) > 0) {
    $maxMochi = max($mochis);
    $mochis = array_filter($mochis, fn($mochi) => $mochi !== $maxMochi);

    $count++;
}

echo $count . PHP_EOL;
```

---

### PHP版：ソートして前と比較する場合

```php
<?php

$input = trim(stream_get_contents(STDIN));
$mochis = array_slice(array_map("intval", preg_split("/\s+/", $input)), 1);

rsort($mochis);

$count = 0;
$prev = -1;

foreach ($mochis as $mochi) {
    if ($mochi !== $prev) {
        $count++;
        $prev = $mochi;
    }
}

echo $count . PHP_EOL;
```

---

### `array_unique()`

```php
$uniqueMochis = array_unique($mochis);
```

`array_unique()` は、配列から重複した値を取り除く関数。

例えば、

```php
$mochis = [10, 8, 8, 6];

$uniqueMochis = array_unique($mochis);
```

結果：

```php
[10, 8, 6]
```

正確には、PHPでは元のキーが保持されることがある。

```php
[
    0 => 10,
    1 => 8,
    3 => 6,
]
```

ただし、今回のように個数を数えるだけなら問題ない。

```php
count($uniqueMochis)
```

結果：

```txt
3
```

---

### `count(array_unique(...))`

```php
echo count($uniqueMochis) . PHP_EOL;
```

`count()` は、配列の要素数を数える関数。

`array_unique()` で重複を除いた後に `count()` することで、直径の種類数を求められる。

1行で書くなら、以下でもよい。

```php
echo count(array_unique($mochis)) . PHP_EOL;
```

---

### `max($mochis)`

```php
$maxMochi = max($mochis);
```

`max()` は、配列の中の最大値を取得する関数。

例えば、

```php
$mochis = [10, 8, 8, 6];

$maxMochi = max($mochis);
```

結果：

```txt
10
```

TypeScriptでは、

```ts
Math.max(...mochis)
```

と書いていたが、PHPでは配列をそのまま渡せる。

```php
max($mochis)
```

---

### `array_filter()` で最大値以外を残す

```php
$mochis = array_filter($mochis, fn($mochi) => $mochi !== $maxMochi);
```

`array_filter()` は、条件を満たす要素だけを残す関数。

今回の条件は、

```php
$mochi !== $maxMochi
```

なので、

```txt
最大値ではない餅だけを残す
```

という意味になる。

例えば、

```php
$mochis = [10, 8, 8, 6];
$maxMochi = 10;
```

の場合、

```php
array_filter($mochis, fn($mochi) => $mochi !== $maxMochi)
```

結果：

```php
[8, 8, 6]
```

次に最大値が `8` になり、`8` はすべて削除される。

```php
array_filter([8, 8, 6], fn($mochi) => $mochi !== 8)
```

結果：

```php
[6]
```

このように、同じ直径の餅をまとめて削除できる。

---

### `while (count($mochis) > 0)`

```php
while (count($mochis) > 0) {
    // 処理
}
```

PHPでは、配列の要素数を `count()` で取得する。

```php
count($mochis) > 0
```

は、

```txt
餅がまだ残っている
```

という意味。

ループの中で、最大値と同じ餅をすべて削除するため、最終的には `count($mochis)` が `0` になり、ループが終了する。

---

### `rsort()`

```php
rsort($mochis);
```

`rsort()` は、配列を降順、つまり大きい順に並び替える関数。

例えば、

```php
$mochis = [8, 10, 6, 8];

rsort($mochis);
```

結果：

```php
[10, 8, 8, 6]
```

この問題では、同じ直径の餅を隣り合わせにするために使っている。

注意点として、`rsort()` は元の配列を直接変更する。

また、戻り値は並び替え後の配列ではなく、成功したかどうかを表す `true / false`。

そのため、以下は誤り。

```php
$mochis = rsort($mochis);
```

正しくは、次のように書く。

```php
rsort($mochis);
```

---

### `foreach`

```php
foreach ($mochis as $mochi) {
    // 処理
}
```

`foreach` は、配列の要素を1つずつ取り出して処理する構文。

例えば、

```php
$mochis = [10, 8, 8, 6];

foreach ($mochis as $mochi) {
    echo $mochi . PHP_EOL;
}
```

出力：

```txt
10
8
8
6
```

TypeScriptの `for...of` に近い書き方。

TypeScript：

```ts
for (const mochi of sortedMochis) {
  // 処理
}
```

PHP：

```php
foreach ($mochis as $mochi) {
    // 処理
}
```

---

### `$prev`

```php
$prev = -1;
```

`$prev` は、直前に見た餅の直径を保存するための変数。

この問題では、餅の直径は正の整数なので、最初の値として存在しない値 `-1` を入れている。

```php
$prev = -1;
```

その後、現在の餅 `$mochi` が `$prev` と違う場合だけ、新しい直径として数える。

```php
if ($mochi !== $prev) {
    $count++;
    $prev = $mochi;
}
```

例えば、

```txt
10, 8, 8, 6
```

を見る場合、

```txt
$mochi = 10, $prev = -1 → 違うので count++
$mochi = 8,  $prev = 10 → 違うので count++
$mochi = 8,  $prev = 8  → 同じなので数えない
$mochi = 6,  $prev = 8  → 違うので count++
```

となる。

---

## TypeScript と PHP の対応表

| 処理          | TypeScript                          | PHP                           |
| ----------- | ----------------------------------- | ----------------------------- |
| 先頭要素を除外する   | `.slice(1)`                         | `array_slice($mochis, 1)`     |
| 重複を除く       | `new Set(input)`                    | `array_unique($mochis)`       |
| 重複除去後の個数    | `mochiSets.size`                    | `count($uniqueMochis)`        |
| 最大値を取得する    | `Math.max(...mochis)`               | `max($mochis)`                |
| 条件に合う要素だけ残す | `mochis.filter(...)`                | `array_filter($mochis, ...)`  |
| 配列の長さ       | `mochis.length`                     | `count($mochis)`              |
| 降順に並び替える    | `.sort((a, b) => b - a)`            | `rsort($mochis)`              |
| 配列を順に見る     | `for (const mochi of sortedMochis)` | `foreach ($mochis as $mochi)` |
| 直前の値を保存する変数 | `prev`                              | `$prev`                       |
| 等しくないか判定する  | `mochi !== prev`                    | `$mochi !== $prev`            |
| カウントを1増やす   | `count++`                           | `$count++`                    |
| 標準出力        | `console.log(count)`                | `echo $count . PHP_EOL`       |

---

# この問題で重要なポイント

## 1. 答えは「餅の直径の種類数」

この問題では、餅を大きい順に積む必要がある。

同じ直径の餅を複数使っても、段数を増やせない。

そのため、必要なのは、

```txt
直径が何種類あるか
```

を数えること。

例えば、

```txt
10
8
8
6
```

なら、種類は、

```txt
10, 8, 6
```

なので、答えは `3`。

---

## 2. `Set` / `array_unique()` が最も簡単

この問題は、重複を除いて数えればよい。

TypeScript：

```ts
const mochiSets = new Set(input);
console.log(mochiSets.size);
```

PHP：

```php
$uniqueMochis = array_unique($mochis);
echo count($uniqueMochis) . PHP_EOL;
```

この解法が最も短く、意図も分かりやすい。

---

## 3. 最大値削除版は、同じ値をまとめて削除する

最大値を1つずつ削除するのではなく、同じ最大値をすべて削除する。

TypeScript：

```ts
mochis = mochis.filter((mochi: number) => mochi !== maxMochi);
```

PHP：

```php
$mochis = array_filter($mochis, fn($mochi) => $mochi !== $maxMochi);
```

例えば、

```txt
10, 8, 8, 6
```

で最大値が `8` の段階では、`8` をすべて削除する。

```txt
8, 8, 6
↓
6
```

これにより、直径の種類数を数えられる。

---

## 4. ソート版は「前と違うか」を見る

ソートすると、同じ値が隣り合う。

```txt
10, 8, 8, 6
```

そのため、前の値と違うときだけ数えればよい。

TypeScript：

```ts
if (mochi !== prev) {
  count++;
  prev = mochi;
}
```

PHP：

```php
if ($mochi !== $prev) {
    $count++;
    $prev = $mochi;
}
```

---

# 推奨する書き方

## TypeScript

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8")
  .trim().split(/\s+/).map(Number).slice(1);

const mochiSets = new Set(input);

console.log(mochiSets.size);
```

## TypeScript：最大値を取って削除する版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8")
  .trim().split(/\s+/).map(Number).slice(1);

let mochis = input;
let count = 0;

while (mochis.length > 0) {
  const maxMochi = Math.max(...mochis);
  mochis = mochis.filter((mochi: number) => mochi !== maxMochi);
  count++;
}

console.log(count);
```

## TypeScript：ソートして前と比較する版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8")
  .trim().split(/\s+/).map(Number).slice(1);

const sortedMochis = input.sort((a: number, b: number) => b - a);

let count = 0;
let prev = -1;

for (const mochi of sortedMochis) {
  if (mochi !== prev) {
    count++;
    prev = mochi;
  }
}

console.log(count);
```

## PHP

```php
<?php

$input = trim(stream_get_contents(STDIN));

$mochis = array_slice(array_map("intval", preg_split("/\s+/", $input)), 1);

$uniqueMochis = array_unique($mochis);

echo count($uniqueMochis) . PHP_EOL;
```

## PHP：最大値を取って削除する版

```php
<?php

$input = trim(stream_get_contents(STDIN));
$mochis = array_slice(array_map("intval", preg_split("/\s+/", $input)), 1);

$count = 0;

while (count($mochis) > 0) {
    $maxMochi = max($mochis);
    $mochis = array_filter($mochis, fn($mochi) => $mochi !== $maxMochi);

    $count++;
}

echo $count . PHP_EOL;
```

## PHP：ソートして前と比較する版

```php
<?php

$input = trim(stream_get_contents(STDIN));
$mochis = array_slice(array_map("intval", preg_split("/\s+/", $input)), 1);

rsort($mochis);

$count = 0;
$prev = -1;

foreach ($mochis as $mochi) {
    if ($mochi !== $prev) {
        $count++;
        $prev = $mochi;
    }
}

echo $count . PHP_EOL;
```
