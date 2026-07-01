# ABC087B - Coins の TypeScript / PHP 文法メモ

対象問題：

```txt
ABC087B - Coins
```

URL：

```txt
https://atcoder.jp/contests/abs/tasks/abc087_b
```

入力：

```txt
A
B
C
X
```

ただし、`A` は500円玉の枚数、`B` は100円玉の枚数、`C` は50円玉の枚数、`X` は作りたい合計金額。

例：

```txt
2
2
2
100
```

出力：

```txt
500円玉、100円玉、50円玉を使って X 円を作る方法の個数
```

例：

```txt
2
```

---

## 解法の共通の考え方

この問題は、500円玉・100円玉・50円玉をそれぞれ何枚使うかを全探索する問題。

使う枚数をそれぞれ、

```txt
500円玉: i 枚
100円玉: j 枚
50円玉: k 枚
```

とすると、合計金額は以下になる。

```txt
500 * i + 100 * j + 50 * k
```

この値が `X` と等しい組み合わせの個数を数える。

---

## 解法1：3重ループで全探索

500円玉、100円玉、50円玉の枚数をすべて試す。

```txt
i = 0 から A
j = 0 から B
k = 0 から C
```

まで全探索し、

```txt
500 * i + 100 * j + 50 * k === X
```

となる組み合わせを数える。

最も素直で分かりやすい解法。

---

## 解法2：2重ループ + 残額から50円玉の枚数を判定

500円玉と100円玉の枚数だけを全探索する。

```txt
i = 0 から A
j = 0 から B
```

まで試し、残り金額を求める。

```txt
rest = X - 500 * i - 100 * j
```

この `rest` を50円玉で作れるなら、組み合わせとして数える。

条件は以下。

```txt
rest >= 0
rest が 50 で割り切れる
rest / 50 <= C
```

3重ループより少し効率がよい。

---

## TypeScript版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const A = input[0];
const B = input[1];
const C = input[2];
const X = input[3];

let count = 0;

for (let i = A; i >= 0; i--) {
  for (let j = B; j >= 0; j--) {
    const rest = X - 500 * i - 100 * j;

    if (rest >= 0 && rest % 50 === 0 && rest / 50 <= C) {
      count++;
    }
  }
}

console.log(count);
```

---

## TypeScript版：3重ループで書く場合

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const a = input[0];
const b = input[1];
const c = input[2];
const x = input[3];

let count = 0;

for (let i = 0; i <= a; i++) {
  for (let j = 0; j <= b; j++) {
    for (let k = 0; k <= c; k++) {
      const total = 500 * i + 100 * j + 50 * k;

      if (total === x) {
        count++;
      }
    }
  }
}

console.log(count);
```

---

## この問題で新しく出てきた文法事項

### 複数の入力値を個別に取り出す

```ts
const A = input[0];
const B = input[1];
const C = input[2];
const X = input[3];
```

`input` は、標準入力を数値配列にしたもの。

入力が以下の場合、

```txt
2
2
2
100
```

`input` は以下になる。

```ts
[2, 2, 2, 100]
```

そのため、

```ts
input[0] // 2
input[1] // 2
input[2] // 2
input[3] // 100
```

として取り出せる。

この問題では、

```txt
A = 500円玉の枚数
B = 100円玉の枚数
C = 50円玉の枚数
X = 作りたい金額
```

として使っている。

---

### `for` 文の減少ループ

```ts
for (let i = A; i >= 0; i--) {
  // 処理
}
```

`for` 文は、値を増やすだけでなく、減らしながら繰り返すこともできる。

基本形：

```ts
for (初期化; 条件; 更新) {
  処理
}
```

今回の場合：

```ts
for (let i = A; i >= 0; i--) {
  // 処理
}
```

意味：

```txt
1. i = A から始める
2. i が 0 以上の間だけ繰り返す
3. 1回処理するたびに i を 1 減らす
```

`i--` は、`i` を1減らす書き方。

以下と同じ意味。

```ts
i = i - 1;
```

この問題では、500円玉を何枚使うかを `A` 枚から `0` 枚まで試している。

---

### 3重ループ

```ts
for (let i = 0; i <= a; i++) {
  for (let j = 0; j <= b; j++) {
    for (let k = 0; k <= c; k++) {
      // 処理
    }
  }
}
```

3重ループは、ループの中にループがあり、さらにその中にループがある形。

この問題では、

```txt
i: 500円玉を使う枚数
j: 100円玉を使う枚数
k: 50円玉を使う枚数
```

をすべて試している。

例えば、`A = 2`, `B = 2`, `C = 2` なら、

```txt
i = 0, 1, 2
j = 0, 1, 2
k = 0, 1, 2
```

のすべての組み合わせを調べる。

---

### `const total`

```ts
const total = 500 * i + 100 * j + 50 * k;
```

`total` は、現在の組み合わせで作れる合計金額。

例えば、

```txt
i = 1
j = 2
k = 0
```

の場合、

```txt
500 * 1 + 100 * 2 + 50 * 0 = 700
```

になる。

この問題では、`total` が `X` と等しいとき、条件を満たす組み合わせとして数える。

---

### `const rest`

```ts
const rest = X - 500 * i - 100 * j;
```

`rest` は、500円玉と100円玉を使った後に残る金額。

例えば、

```txt
X = 1000
i = 1
j = 2
```

の場合、

```txt
1000 - 500 * 1 - 100 * 2 = 300
```

になる。

この残り金額を50円玉で作れるかどうかを判定する。

---

### `rest >= 0`

```ts
rest >= 0
```

`>=` は「以上」を表す比較演算子。

```ts
rest >= 0
```

は、

```txt
rest が 0 以上である
```

という意味。

残り金額がマイナスの場合、その時点で金額を超えてしまっているため、組み合わせとして不正。

---

### `rest % 50 === 0`

```ts
rest % 50 === 0
```

`%` は割り算の余りを求める演算子。

`rest % 50 === 0` は、

```txt
rest が 50 で割り切れる
```

という意味。

50円玉で残り金額を作るには、残り金額が50の倍数である必要がある。

例えば、

```ts
300 % 50 === 0
```

結果：

```txt
true
```

```ts
320 % 50 === 0
```

結果：

```txt
false
```

---

### `rest / 50 <= C`

```ts
rest / 50 <= C
```

`rest / 50` は、必要な50円玉の枚数。

例えば、

```txt
rest = 300
```

なら、

```txt
300 / 50 = 6
```

なので、50円玉が6枚必要。

```ts
rest / 50 <= C
```

は、

```txt
必要な50円玉の枚数が、使える50円玉の枚数 C 以下である
```

という意味。

---

### 複数条件を `&&` でつなぐ

```ts
if (rest >= 0 && rest % 50 === 0 && rest / 50 <= C) {
  count++;
}
```

`&&` は「かつ」を表す演算子。

すべての条件が true のときだけ、全体が true になる。

今回の場合、

```txt
1. rest が 0 以上
2. rest が 50 で割り切れる
3. 必要な50円玉の枚数が C 以下
```

のすべてを満たすとき、条件成立となる。

---

## PHP版

### 2重ループ + 残額で判定する場合

```php
<?php

$input = trim(stream_get_contents(STDIN));

$nums = array_map('intval', preg_split('/\s+/', $input));

$a = $nums[0];
$b = $nums[1];
$c = $nums[2];
$x = $nums[3];

$count = 0;

for ($i = 0; $i <= $a; $i++) {
    for ($j = 0; $j <= $b; $j++) {
        $rest = $x - 500 * $i - 100 * $j;

        if ($rest >= 0 && $rest % 50 === 0 && $rest / 50 <= $c) {
            $count++;
        }
    }
}

echo $count . PHP_EOL;
```

---

### PHP版：3重ループで書く場合

```php
<?php

$input = trim(stream_get_contents(STDIN));

$nums = array_map('intval', preg_split('/\s+/', $input));

$a = $nums[0];
$b = $nums[1];
$c = $nums[2];
$x = $nums[3];

$count = 0;

for ($i = 0; $i <= $a; $i++) {
    for ($j = 0; $j <= $b; $j++) {
        for ($k = 0; $k <= $c; $k++) {
            $total = 500 * $i + 100 * $j + 50 * $k;

            if ($total === $x) {
                $count++;
            }
        }
    }
}

echo $count . PHP_EOL;
```

---

### 複数の入力値を個別に取り出す

```php
$a = $nums[0];
$b = $nums[1];
$c = $nums[2];
$x = $nums[3];
```

`$nums` は、標準入力を数値配列にしたもの。

入力が以下の場合、

```txt
2
2
2
100
```

`$nums` は以下になる。

```php
[2, 2, 2, 100]
```

そのため、

```php
$nums[0] // 2
$nums[1] // 2
$nums[2] // 2
$nums[3] // 100
```

として取り出せる。

この問題では、

```txt
$a = 500円玉の枚数
$b = 100円玉の枚数
$c = 50円玉の枚数
$x = 作りたい金額
```

として使っている。

---

### PHPの3重ループ

```php
for ($i = 0; $i <= $a; $i++) {
    for ($j = 0; $j <= $b; $j++) {
        for ($k = 0; $k <= $c; $k++) {
            // 処理
        }
    }
}
```

PHPでも、ループの中にループを書ける。

この問題では、

```txt
$i: 500円玉を使う枚数
$j: 100円玉を使う枚数
$k: 50円玉を使う枚数
```

をすべて試している。

例えば、`$a = 2`, `$b = 2`, `$c = 2` なら、

```txt
$i = 0, 1, 2
$j = 0, 1, 2
$k = 0, 1, 2
```

のすべての組み合わせを調べる。

---

### `$total`

```php
$total = 500 * $i + 100 * $j + 50 * $k;
```

`$total` は、現在の組み合わせで作れる合計金額。

例えば、

```txt
$i = 1
$j = 2
$k = 0
```

の場合、

```txt
500 * 1 + 100 * 2 + 50 * 0 = 700
```

になる。

この問題では、`$total` が `$x` と等しいとき、条件を満たす組み合わせとして数える。

注意点として、

```php
$total = 500 * $i * 100 * $j + 50 * $k;
```

のように書くと誤り。

500円玉の合計と100円玉の合計は掛けるのではなく、足す。

正しくは、

```php
$total = 500 * $i + 100 * $j + 50 * $k;
```

である。

---

### `$rest`

```php
$rest = $x - 500 * $i - 100 * $j;
```

`$rest` は、500円玉と100円玉を使った後に残る金額。

例えば、

```txt
$x = 1000
$i = 1
$j = 2
```

の場合、

```txt
1000 - 500 * 1 - 100 * 2 = 300
```

になる。

この残り金額を50円玉で作れるかどうかを判定する。

---

### `$rest >= 0`

```php
$rest >= 0
```

`>=` は「以上」を表す比較演算子。

```php
$rest >= 0
```

は、

```txt
$rest が 0 以上である
```

という意味。

残り金額がマイナスの場合、その時点で金額を超えてしまっているため、組み合わせとして不正。

---

### `$rest % 50 === 0`

```php
$rest % 50 === 0
```

`%` は割り算の余りを求める演算子。

`$rest % 50 === 0` は、

```txt
$rest が 50 で割り切れる
```

という意味。

50円玉で残り金額を作るには、残り金額が50の倍数である必要がある。

例えば、

```php
300 % 50 === 0
```

結果：

```txt
true
```

```php
320 % 50 === 0
```

結果：

```txt
false
```

---

### `$rest / 50 <= $c`

```php
$rest / 50 <= $c
```

`$rest / 50` は、必要な50円玉の枚数。

例えば、

```txt
$rest = 300
```

なら、

```txt
300 / 50 = 6
```

なので、50円玉が6枚必要。

```php
$rest / 50 <= $c
```

は、

```txt
必要な50円玉の枚数が、使える50円玉の枚数 $c 以下である
```

という意味。

---

### 複数条件を `&&` でつなぐ

```php
if ($rest >= 0 && $rest % 50 === 0 && $rest / 50 <= $c) {
    $count++;
}
```

`&&` は「かつ」を表す演算子。

すべての条件が true のときだけ、全体が true になる。

今回の場合、

```txt
1. $rest が 0 以上
2. $rest が 50 で割り切れる
3. 必要な50円玉の枚数が $c 以下
```

のすべてを満たすとき、条件成立となる。

---

## TypeScript と PHP の対応表

| 処理          | TypeScript                                 | PHP                                        |
| ----------- | ------------------------------------------ | ------------------------------------------ |
| 入力値を個別に取り出す | `const A = input[0]`                       | `$a = $nums[0]`                            |
| 2重ループ       | `for (...) { for (...) {} }`               | `for (...) { for (...) {} }`               |
| 3重ループ       | `for (...) { for (...) { for (...) {} } }` | `for (...) { for (...) { for (...) {} } }` |
| 合計金額を作る     | `500 * i + 100 * j + 50 * k`               | `500 * $i + 100 * $j + 50 * $k`            |
| 残り金額を求める    | `const rest = X - 500 * i - 100 * j`       | `$rest = $x - 500 * $i - 100 * $j`         |
| 0以上か判定する    | `rest >= 0`                                | `$rest >= 0`                               |
| 50で割り切れるか   | `rest % 50 === 0`                          | `$rest % 50 === 0`                         |
| 必要な50円玉の枚数  | `rest / 50`                                | `$rest / 50`                               |
| 複数条件をつなぐ    | `&&`                                       | `&&`                                       |
| カウントを1増やす   | `count++`                                  | `$count++`                                 |
| 標準出力        | `console.log(count)`                       | `echo $count . PHP_EOL`                    |

---

# この問題で重要なポイント

## 1. 金額の合計は足し算で作る

500円玉、100円玉、50円玉の合計は以下で求める。

```txt
500 * 枚数 + 100 * 枚数 + 50 * 枚数
```

例えば、

```txt
500円玉を1枚
100円玉を2枚
50円玉を0枚
```

なら、

```txt
500 * 1 + 100 * 2 + 50 * 0 = 700
```

になる。

掛け算でつながないように注意する。

誤り：

```txt
500 * i * 100 * j + 50 * k
```

正しい式：

```txt
500 * i + 100 * j + 50 * k
```

---

## 2. 3重ループは素直だが、2重ループでも書ける

3重ループでは、500円玉・100円玉・50円玉の枚数をすべて試す。

一方で、2重ループでは、500円玉と100円玉の枚数だけを試し、残り金額から50円玉の枚数を判定する。

3重ループ：

```txt
i, j, k をすべて試す
```

2重ループ：

```txt
i, j を試す
残りを50円玉で作れるか判定する
```

---

## 3. 2重ループでは50で割り切れるかも確認する

残り金額 `rest` から50円玉の枚数を求める場合、

```txt
rest / 50
```

を使う。

ただし、50円玉で作るには、`rest` が50で割り切れる必要がある。

そのため、条件には以下を入れる。

```txt
rest % 50 === 0
```

TypeScript：

```ts
if (rest >= 0 && rest % 50 === 0 && rest / 50 <= C) {
  count++;
}
```

PHP：

```php
if ($rest >= 0 && $rest % 50 === 0 && $rest / 50 <= $c) {
    $count++;
}
```

---

# 推奨する書き方

## TypeScript

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const A = input[0];
const B = input[1];
const C = input[2];
const X = input[3];

let count = 0;

for (let i = 0; i <= A; i++) {
  for (let j = 0; j <= B; j++) {
    const rest = X - 500 * i - 100 * j;

    if (rest >= 0 && rest % 50 === 0 && rest / 50 <= C) {
      count++;
    }
  }
}

console.log(count);
```

## TypeScript：3重ループ版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const a = input[0];
const b = input[1];
const c = input[2];
const x = input[3];

let count = 0;

for (let i = 0; i <= a; i++) {
  for (let j = 0; j <= b; j++) {
    for (let k = 0; k <= c; k++) {
      const total = 500 * i + 100 * j + 50 * k;

      if (total === x) {
        count++;
      }
    }
  }
}

console.log(count);
```

## PHP

```php
<?php

$input = trim(stream_get_contents(STDIN));

$nums = array_map('intval', preg_split('/\s+/', $input));

$a = $nums[0];
$b = $nums[1];
$c = $nums[2];
$x = $nums[3];

$count = 0;

for ($i = 0; $i <= $a; $i++) {
    for ($j = 0; $j <= $b; $j++) {
        $rest = $x - 500 * $i - 100 * $j;

        if ($rest >= 0 && $rest % 50 === 0 && $rest / 50 <= $c) {
            $count++;
        }
    }
}

echo $count . PHP_EOL;
```

## PHP：3重ループ版

```php
<?php

$input = trim(stream_get_contents(STDIN));

$nums = array_map('intval', preg_split('/\s+/', $input));

$a = $nums[0];
$b = $nums[1];
$c = $nums[2];
$x = $nums[3];

$count = 0;

for ($i = 0; $i <= $a; $i++) {
    for ($j = 0; $j <= $b; $j++) {
        for ($k = 0; $k <= $c; $k++) {
            $total = 500 * $i + 100 * $j + 50 * $k;

            if ($total === $x) {
                $count++;
            }
        }
    }
}

echo $count . PHP_EOL;
```
