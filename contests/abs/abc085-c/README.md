# ABC085C - Otoshidama の TypeScript / PHP 文法メモ

対象問題：

```txt id="sohkh8"
ABC085C - Otoshidama
```

URL：

```txt id="2941dk"
https://atcoder.jp/contests/abs/tasks/abc085_c
```

入力：

```txt id="b2zpjp"
N Y
```

* `N` はお札の枚数
* `Y` は合計金額

出力：

```txt id="6df6d1"
10000円札の枚数 5000円札の枚数 1000円札の枚数
```

条件を満たす組み合わせが存在しない場合は、

```txt id="2evisx"
-1 -1 -1
```

を出力する。

---

## 解法の共通の考え方

この問題では、以下の3種類のお札の枚数を求める。

```txt id="op6dmb"
10000円札の枚数
5000円札の枚数
1000円札の枚数
```

それぞれを、

```txt id="21s6i4"
i: 10000円札の枚数
j: 5000円札の枚数
k: 1000円札の枚数
```

とすると、条件は次の2つ。

```txt id="xzef7j"
i + j + k = N
10000i + 5000j + 1000k = Y
```

この2つの条件を満たす `i, j, k` を1つ見つければよい。

複数の答えがある場合は、どれを出力してもよい。

---

## 注意点：この問題は正解が複数ある

この問題は、条件を満たす組み合わせが複数存在する場合がある。

例えば、

```txt id="vdyil9"
9 45000
```

に対して、サンプル出力は、

```txt id="1d36li"
4 0 5
```

だが、以下も条件を満たす。

```txt id="o1r7p0"
0 9 0
```

実際に、

```txt id="c8gzcx"
0 + 9 + 0 = 9
10000 * 0 + 5000 * 9 + 1000 * 0 = 45000
```

なので正しい。

AtCoder本番では、条件を満たす組み合わせであればどれでもACになる。

ただし、`oj test` はサンプル出力と完全一致で比較するため、正しい答えを出していてもサンプル出力と違う場合は fail することがある。

---

# 解法1：2重ループで全探索する

## 考え方

10000円札の枚数 `i` と、5000円札の枚数 `j` を全探索する。

このとき、1000円札の枚数 `k` は自動的に決まる。

```txt id="7sun7n"
k = N - i - j
```

つまり、3重ループにしなくてもよい。

`i`, `j`, `k` が決まったら、合計金額を計算する。

```txt id="g0tr19"
total = 10000i + 5000j + 1000k
```

この `total` が `Y` と一致すれば、その組み合わせを出力して終了する。

---

## TypeScript版

```ts id="yjxwqo"
const fs = require("fs");

const [n, y] = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const ichiman = 10000;
const gosen = 5000;
const sen = 1000;

for (let i = 0; i <= n; i++) {
  for (let j = 0; j <= n - i; j++) {
    const k = n - i - j;
    const total = ichiman * i + gosen * j + sen * k;

    if (total === y) {
      console.log(`${i} ${j} ${k}`);
      process.exit(0);
    }
  }
}

console.log("-1 -1 -1");
```

---

## PHP版

```php id="wxc34h"
<?php

$input = trim(stream_get_contents(STDIN));
[$n, $y] = array_map("intval", preg_split("/\s+/", $input));

$ichiman = 10000;
$gosen = 5000;
$sen = 1000;

for ($i = 0; $i <= $n; $i++) {
    for ($j = 0; $j <= $n - $i; $j++) {
        $k = $n - $i - $j;
        $total = $ichiman * $i + $gosen * $j + $sen * $k;

        if ($total === $y) {
            echo "{$i} {$j} {$k}" . PHP_EOL;
            exit;
        }
    }
}

echo "-1 -1 -1" . PHP_EOL;
```

---

## この解法のポイント

### `j <= n - i`

```ts id="h7p9nf"
for (let j = 0; j <= n - i; j++) {
```

10000円札を `i` 枚使った時点で、残りのお札の枚数は、

```txt id="f2iqdl"
n - i
```

枚。

そのため、5000円札の枚数 `j` は最大でも `n - i` 枚まででよい。

PHPでも同じ。

```php id="7w8p34"
for ($j = 0; $j <= $n - $i; $j++) {
```

---

### `k = n - i - j`

```ts id="6jo4z5"
const k = n - i - j;
```

`i` と `j` が決まれば、1000円札の枚数 `k` は自動的に決まる。

```txt id="v2zpze"
i + j + k = n
```

なので、

```txt id="1vivxa"
k = n - i - j
```

とできる。

これにより、3重ループではなく2重ループで済む。

PHPではこう書く。

```php id="al2ir2"
$k = $n - $i - $j;
```

---

### `process.exit(0)` と `exit`

TypeScriptでは、答えを見つけたら、

```ts id="049jsy"
process.exit(0);
```

でプログラムを終了している。

これを書かないと、答えを出力したあともループが続き、最後の

```ts id="n29krq"
console.log("-1 -1 -1");
```

まで実行される可能性がある。

PHPでは、

```php id="ybli3h"
exit;
```

を使う。

```php id="rrh8co"
if ($total === $y) {
    echo "{$i} {$j} {$k}" . PHP_EOL;
    exit;
}
```

---

# 解法2：1重ループ + 方程式で解く

## 考え方

条件は次の2つ。

```txt id="zg6uxc"
i + j + k = n
10000i + 5000j + 1000k = y
```

金額の式を1000で割る。

```txt id="vym5b2"
10i + 5j + k = y / 1000
```

また、

```txt id="lrw5it"
k = n - i - j
```

なので、これを代入する。

```txt id="w3gc1b"
10i + 5j + n - i - j = y / 1000
```

整理すると、

```txt id="hygt3t"
9i + 4j + n = y / 1000
```

したがって、

```txt id="l45sel"
9i + 4j = y / 1000 - n
```

となる。

ここで、

```txt id="nwekhj"
target = y / 1000 - n
```

と置くと、

```txt id="ld9zv0"
9i + 4j = target
```

になる。

`i` を決めれば、`j` を計算できる。

```txt id="2ttsw9"
4j = target - 9i
j = (target - 9i) / 4
```

そのため、`i` だけをループすればよい。

---

## TypeScript版

```ts id="i62b5o"
const fs = require("fs");

const [n, y] = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const target = y / 1000 - n;

for (let i = 0; i <= n; i++) {
  const rest = target - 9 * i;

  if (rest < 0) {
    continue;
  }

  if (rest % 4 !== 0) {
    continue;
  }

  const j = rest / 4;
  const k = n - i - j;

  if (j >= 0 && k >= 0) {
    console.log(`${i} ${j} ${k}`);
    process.exit(0);
  }
}

console.log("-1 -1 -1");
```

---

## PHP版

現在の `main_1.php` の形でも動く。

```php id="mj8ea7"
<?php

$input = trim(stream_get_contents(STDIN));
[$n, $y] = array_map("intval", preg_split("/\s+/", $input));

$target = $y / 1000 - $n;

for ($i = 0; $i <= $n; $i++) {
    $rest = $target - 9 * $i;

    if ($rest < 0) {
        continue;
    }

    if ($rest % 4 !== 0) {
        continue;
    }

    $j = $rest / 4;
    $k = $n - $i - $j;

    if ($j >= 0 && $k >= 0) {
        echo "{$i} {$j} {$k}" . PHP_EOL;
        exit;
    }
}

echo "-1 -1 -1" . PHP_EOL;
```

ただし、PHPでは `/` の結果が float になる。

そのため、整数として扱いたい場合は `intdiv()` を使うとよい。

```php id="0dn7lw"
<?php

$input = trim(stream_get_contents(STDIN));
[$n, $y] = array_map("intval", preg_split("/\s+/", $input));

$target = intdiv($y, 1000) - $n;

for ($i = 0; $i <= $n; $i++) {
    $rest = $target - 9 * $i;

    if ($rest < 0) {
        continue;
    }

    if ($rest % 4 !== 0) {
        continue;
    }

    $j = intdiv($rest, 4);
    $k = $n - $i - $j;

    if ($j >= 0 && $k >= 0) {
        echo "{$i} {$j} {$k}" . PHP_EOL;
        exit;
    }
}

echo "-1 -1 -1" . PHP_EOL;
```

---

## この解法のポイント

### `target = y / 1000 - n`

```ts id="fbtxql"
const target = y / 1000 - n;
```

これは、式変形した結果、

```txt id="80crwc"
9i + 4j = y / 1000 - n
```

になるため。

PHPでは、整数除算にするなら以下。

```php id="vuoffy"
$target = intdiv($y, 1000) - $n;
```

---

### `rest = target - 9 * i`

```ts id="bkfrvt"
const rest = target - 9 * i;
```

`target` から `9i` を引くことで、

```txt id="vnikmr"
4j
```

にあたる部分を求めている。

つまり、

```txt id="069r4p"
rest = 4j
```

になる。

PHPでも同じ。

```php id="a15t7q"
$rest = $target - 9 * $i;
```

---

### `rest % 4 !== 0`

```ts id="mo9b0d"
if (rest % 4 !== 0) {
  continue;
}
```

`rest` は `4j` でなければならない。

そのため、`4` で割り切れない場合は、整数の `j` を作れない。

よって、その `i` は候補から外す。

PHPでも同じ。

```php id="g8zlfo"
if ($rest % 4 !== 0) {
    continue;
}
```

---

### `continue`

```ts id="fh1hc8"
continue;
```

`continue` は、現在のループ処理をそこで打ち切り、次のループに進む命令。

例えば、

```ts id="l2dj7e"
if (rest < 0) {
  continue;
}
```

は、

```txt id="p4m4l9"
rest が負なら、その i では解にならないので次の i に進む
```

という意味。

PHPでも同じように使える。

```php id="vzizxk"
continue;
```

---

### PHPの `/` と `intdiv()`

PHPでは、`/` を使うと結果は float になる。

```php id="cbbes8"
$j = $rest / 4;
```

例えば値としては `3` でも、内部的には `3.0` になることがある。

整数として割り算したい場合は、

```php id="lzzcpr"
intdiv($rest, 4)
```

を使う。

ただし、`intdiv()` は割り切れない場合でも小数を切り捨てるので、先に `%` で割り切れるか確認するのが安全。

```php id="rug8h2"
if ($rest % 4 !== 0) {
    continue;
}

$j = intdiv($rest, 4);
```

---

# TypeScript と PHP の対応表

| 処理         | TypeScript                        | PHP                               |
| ---------- | --------------------------------- | --------------------------------- |
| 入力を読む      | `fs.readFileSync(0, "utf8")`      | `stream_get_contents(STDIN)`      |
| 前後の空白を除く   | `.trim()`                         | `trim(...)`                       |
| 空白で分割する    | `.split(/\s+/)`                   | `preg_split("/\s+/", $input)`     |
| 数値に変換する    | `.map(Number)`                    | `array_map("intval", ...)`        |
| 分割代入       | `const [n, y] = ...`              | `[$n, $y] = ...`                  |
| 変数宣言       | `const`, `let`                    | `$変数名`                            |
| for文       | `for (let i = 0; ...)`            | `for ($i = 0; ...)`               |
| if文        | `if (条件) {}`                      | `if (条件) {}`                      |
| 現在のループを飛ばす | `continue`                        | `continue`                        |
| プログラム終了    | `process.exit(0)`                 | `exit`                            |
| 出力         | ``console.log(`${i} ${j} ${k}`)`` | `echo "{$i} {$j} {$k}" . PHP_EOL` |
| 余り         | `rest % 4`                        | `$rest % 4`                       |
| 整数除算       | 通常 `/`                            | `intdiv($rest, 4)`                |
| 厳密比較       | `===` / `!==`                     | `===` / `!==`                     |

---

# この問題で重要なポイント

## 1. 3重ループではなく2重ループにできる

条件は、

```txt id="2jkhmy"
i + j + k = n
```

なので、`i` と `j` が決まれば `k` は自動的に決まる。

```txt id="8l9vov"
k = n - i - j
```

そのため、`i`, `j`, `k` をすべてループする必要はない。

---

## 2. 2重ループ解法が一番バランスが良い

2重ループ版は、式変形が少なく、実装も分かりやすい。

```txt id="z4ku9t"
10000円札の枚数を決める
5000円札の枚数を決める
1000円札の枚数は残りで決まる
合計金額を確認する
```

AtCoder Beginners Selection の学習段階では、この解法をメインにしてよい。

---

## 3. 1重ループ解法は式変形が必要

1重ループ版は、計算量が少ない。

ただし、

```txt id="t6si85"
9i + 4j = y / 1000 - n
```

という式変形が必要になる。

実装量は短いが、考え方は少し難しい。

---

## 4. `oj test` では fail する場合がある

この問題は正解が複数存在する。

そのため、条件を満たす出力でも、サンプル出力と完全一致しなければ `oj test` では fail する場合がある。

AtCoder本番では、条件を満たしていればACになる。

---

# 推奨する書き方

## TypeScript：2重ループ版

```ts id="dsldkn"
const fs = require("fs");

const [n, y] = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

for (let i = 0; i <= n; i++) {
  for (let j = 0; j <= n - i; j++) {
    const k = n - i - j;
    const total = 10000 * i + 5000 * j + 1000 * k;

    if (total === y) {
      console.log(`${i} ${j} ${k}`);
      process.exit(0);
    }
  }
}

console.log("-1 -1 -1");
```

## PHP：2重ループ版

```php id="t0h7iu"
<?php

$input = trim(stream_get_contents(STDIN));
[$n, $y] = array_map("intval", preg_split("/\s+/", $input));

for ($i = 0; $i <= $n; $i++) {
    for ($j = 0; $j <= $n - $i; $j++) {
        $k = $n - $i - $j;
        $total = 10000 * $i + 5000 * $j + 1000 * $k;

        if ($total === $y) {
            echo "{$i} {$j} {$k}" . PHP_EOL;
            exit;
        }
    }
}

echo "-1 -1 -1" . PHP_EOL;
```

## TypeScript：1重ループ版

```ts id="3f5khg"
const fs = require("fs");

const [n, y] = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const target = y / 1000 - n;

for (let i = 0; i <= n; i++) {
  const rest = target - 9 * i;

  if (rest < 0) {
    continue;
  }

  if (rest % 4 !== 0) {
    continue;
  }

  const j = rest / 4;
  const k = n - i - j;

  if (j >= 0 && k >= 0) {
    console.log(`${i} ${j} ${k}`);
    process.exit(0);
  }
}

console.log("-1 -1 -1");
```

## PHP：1重ループ版

```php id="q6tv14"
<?php

$input = trim(stream_get_contents(STDIN));
[$n, $y] = array_map("intval", preg_split("/\s+/", $input));

$target = intdiv($y, 1000) - $n;

for ($i = 0; $i <= $n; $i++) {
    $rest = $target - 9 * $i;

    if ($rest < 0) {
        continue;
    }

    if ($rest % 4 !== 0) {
        continue;
    }

    $j = intdiv($rest, 4);
    $k = $n - $i - $j;

    if ($j >= 0 && $k >= 0) {
        echo "{$i} {$j} {$k}" . PHP_EOL;
        exit;
    }
}

echo "-1 -1 -1" . PHP_EOL;
```
