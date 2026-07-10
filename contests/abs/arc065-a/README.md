# ARC065A / ABC049C - Daydream の TypeScript / PHP 文法メモ

対象問題：

```txt
ARC065A / ABC049C - Daydream
```

URL：

```txt
https://atcoder.jp/contests/abs/tasks/arc065_a
```

入力：

```txt
S
```

出力：

```txt
YES
```

または、

```txt
NO
```

---

## 解法の共通の考え方

この問題では、文字列 `S` が以下の4つの単語をつなげて作れるかを判定する。

```txt
dream
dreamer
erase
eraser
```

例えば、

```txt
erasedream
```

は、

```txt
erase + dream
```

で作れるので `YES`。

一方で、

```txt
dreamerer
```

は、4つの単語の組み合わせでは作れないので `NO`。

---

## 注意点：先頭からそのまま削ると難しい

この問題では、

```txt
dream
dreamer
```

や、

```txt
erase
eraser
```

のように、片方がもう片方の先頭部分になっている単語がある。

そのため、先頭から単純に一致するものを削ると、誤判定しやすい。

例えば、

```txt
dreameraser
```

は本来、

```txt
dream + eraser
```

なので `YES`。

しかし、先頭から `dreamer` を優先して削ると、

```txt
dreamer + aser
```

となり、残りの `aser` が作れず失敗する。

そのため、この問題では以下のような方法が使いやすい。

```txt
1. 後ろから削る
2. 文字列を反転して先頭から削る
3. 正規表現で全体を判定する
```

---

# 解法1：後ろから削る

## 考え方

文字列の末尾が、

```txt
dream
dreamer
erase
eraser
```

のいずれかで終わっているかを調べる。

一致したら、その末尾部分を削る。

これを文字列が空になるまで繰り返す。

途中でどの単語にも一致しなければ `NO`。

空文字まで削れたら `YES`。

例えば、

```txt
erasedream
```

なら、

```txt
erasedream
↓ dream を削る
erase
↓ erase を削る
空文字
```

となるので `YES`。

---

## TypeScript版

```ts
const fs = require("fs");

let s = fs.readFileSync(0, "utf8").trim();

const words = ["dream", "dreamer", "erase", "eraser"];

while (s.length > 0) {
  let matched = false;

  for (const word of words) {
    if (s.endsWith(word)) {
      s = s.slice(0, s.length - word.length);
      matched = true;
      break;
    }
  }

  if (!matched) {
    console.log("NO");
    process.exit(0);
  }
}

console.log("YES");
```

---

## PHP版

```php
<?php

$s = trim(stream_get_contents(STDIN));

$words = ["dream", "dreamer", "erase", "eraser"];

while (strlen($s)) {
    $matched = false;

    foreach ($words as $word) {
        if (str_ends_with($s, $word)) {
            $s = substr($s, 0, strlen($s) - strlen($word));
            $matched = true;
            break;
        }
    }

    if (!$matched) {
        echo "NO" . PHP_EOL;
        exit;
    }
}

echo "YES" . PHP_EOL;
```

---

## この解法で新しく出てきた文法事項

### `endsWith()`

```ts
s.endsWith(word)
```

`endsWith()` は、文字列が指定した文字列で終わっているかを判定するメソッド。

例えば、

```ts
"erasedream".endsWith("dream")
```

結果：

```txt
true
```

一方で、

```ts
"erasedream".endsWith("erase")
```

結果：

```txt
false
```

この問題では、現在の文字列の末尾が `dream`, `dreamer`, `erase`, `eraser` のどれかかを調べるために使っている。

PHPでは、対応する関数として `str_ends_with()` を使う。

```php
str_ends_with($s, $word)
```

---

### 末尾を削る `slice()`

```ts
s = s.slice(0, s.length - word.length);
```

これは、文字列 `s` の先頭から、末尾の `word` の長さを除いた部分までを取り出す処理。

例えば、

```ts
let s = "erasedream";
const word = "dream";

s = s.slice(0, s.length - word.length);
```

結果：

```txt
erase
```

`slice()` は元の文字列を直接変更しない。

そのため、以下のように代入する必要がある。

```ts
s = s.slice(...);
```

代入しないと、`s` は元のままになる。

---

### PHPの `substr()`

```php
$s = substr($s, 0, strlen($s) - strlen($word));
```

`substr()` は、文字列の一部を取り出す関数。

今回の書き方は、

```txt
$s の先頭から、末尾の $word の長さを除いた部分まで取り出す
```

という意味。

例えば、

```php
$s = "erasedream";
$word = "dream";

$s = substr($s, 0, strlen($s) - strlen($word));
```

結果：

```txt
erase
```

TypeScriptの以下に対応する。

```ts
s = s.slice(0, s.length - word.length);
```

---

### `break`

```ts
break;
```

`break` は、ループを途中で終了する命令。

今回のコードでは、どれか1つの単語に一致した時点で、それ以上ほかの単語を調べる必要がない。

そのため、

```ts
matched = true;
break;
```

として、`for` ループを抜けている。

PHPでも同じように使える。

```php
break;
```

---

### `process.exit(0)` と `exit`

TypeScriptでは、`NO` が確定した時点で、

```ts
process.exit(0);
```

を使ってプログラムを終了している。

これを書かないと、最後の

```ts
console.log("YES");
```

まで実行されてしまう可能性がある。

PHPでは、

```php
exit;
```

を使う。

---

# 解法2：文字列を反転して先頭から削る

## 考え方

後ろから削る代わりに、文字列全体を反転する。

単語も同じように反転する。

```txt
dream  → maerd
dreamer → remaerd
erase → esare
eraser → resare
```

元の文字列を反転すると、「後ろから削る問題」を「先頭から削る問題」に変えられる。

例えば、

```txt
erasedream
```

を反転すると、

```txt
maerdesare
```

になる。

これは、

```txt
maerd + esare
```

として先頭から削れる。

---

## TypeScript版

```ts
const fs = require("fs");

let s = fs.readFileSync(0, "utf8").trim().split("").reverse().join("");

const words = ["dream", "dreamer", "erase", "eraser"]
  .map((word) => word.split("").reverse().join(""));

while (s.length > 0) {
  let matched = false;

  for (const word of words) {
    if (s.startsWith(word)) {
      s = s.slice(word.length);
      matched = true;
      break;
    }
  }

  if (!matched) {
    console.log("NO");
    process.exit(0);
  }
}

console.log("YES");
```

---

## PHP版

```php
<?php

$s = trim(stream_get_contents(STDIN));
$s = strrev($s);

$words = ["dream", "dreamer", "erase", "eraser"];
$words = array_map(fn($w) => strrev($w), $words);

while (strlen($s) > 0) {
    $matched = false;

    foreach ($words as $word) {
        if (str_starts_with($s, $word)) {
            $s = substr($s, strlen($word));
            $matched = true;
            break;
        }
    }

    if (!$matched) {
        echo "NO" . PHP_EOL;
        exit;
    }
}

echo "YES" . PHP_EOL;
```

---

## この解法で新しく出てきた文法事項

### 文字列を反転する

TypeScriptでは、文字列を直接 `reverse()` できない。

そのため、いったん文字の配列にしてから反転する。

```ts
s.split("").reverse().join("")
```

意味は以下。

```txt
split("")  → 1文字ずつ配列にする
reverse()  → 配列を逆順にする
join("")   → 配列を文字列に戻す
```

例えば、

```ts
"erase".split("").reverse().join("")
```

結果：

```txt
esare
```

PHPでは、文字列を反転する `strrev()` がある。

```php
strrev($s)
```

例えば、

```php
strrev("erase")
```

結果：

```txt
esare
```

---

### `map()`

```ts
const words = ["dream", "dreamer", "erase", "eraser"]
  .map((word) => word.split("").reverse().join(""));
```

`map()` は、配列の各要素を変換して新しい配列を作るメソッド。

今回の場合、各単語を反転している。

```txt
dream  → maerd
dreamer → remaerd
erase → esare
eraser → resare
```

PHPでは `array_map()` を使う。

```php
$words = array_map(fn($w) => strrev($w), $words);
```

---

### `startsWith()`

```ts
s.startsWith(word)
```

`startsWith()` は、文字列が指定した文字列で始まっているかを判定するメソッド。

例えば、

```ts
"maerdesare".startsWith("maerd")
```

結果：

```txt
true
```

PHPでは `str_starts_with()` を使う。

```php
str_starts_with($s, $word)
```

---

### 先頭を削る `slice()`

```ts
s = s.slice(word.length);
```

これは、先頭から `word.length` 文字分を削った残りを取得する処理。

例えば、

```ts
let s = "maerdesare";
const word = "maerd";

s = s.slice(word.length);
```

結果：

```txt
esare
```

PHPでは以下に対応する。

```php
$s = substr($s, strlen($word));
```

---

# 解法3：正規表現で判定する

## 考え方

文字列全体が、

```txt
dream
dreamer
erase
eraser
```

の繰り返しだけでできているかを正規表現で判定する。

---

## TypeScript版

```ts
const fs = require("fs");

const s = fs.readFileSync(0, "utf8").trim();

const regex = /^(dream|dreamer|erase|eraser)+$/;

console.log(regex.test(s) ? "YES" : "NO");
```

---

## PHP版

```php
<?php

$s = trim(stream_get_contents(STDIN));

$matched = preg_match('/^(dream|dreamer|erase|eraser)+$/', $s);

echo ($matched ? "YES" : "NO") . PHP_EOL;
```

---

## 正規表現の意味

```txt
^(dream|dreamer|erase|eraser)+$
```

それぞれの意味は以下。

```txt
^                         文字列の先頭
dream|dreamer|erase|eraser いずれかの単語
+                         1回以上の繰り返し
$                         文字列の末尾
```

つまり、

```txt
文字列全体が dream / dreamer / erase / eraser の繰り返しでできているか
```

を判定している。

TypeScriptでは、

```ts
regex.test(s)
```

で正規表現に一致するかを判定する。

PHPでは、

```php
preg_match('/^(dream|dreamer|erase|eraser)+$/', $s)
```

で判定する。

---

# TypeScript と PHP の対応表

| 処理          | TypeScript                           | PHP                                         |
| ----------- | ------------------------------------ | ------------------------------------------- |
| 入力を読む       | `fs.readFileSync(0, "utf8")`         | `stream_get_contents(STDIN)`                |
| 前後の空白を削る    | `.trim()`                            | `trim(...)`                                 |
| 文字列の長さ      | `s.length`                           | `strlen($s)`                                |
| 末尾が一致するか    | `s.endsWith(word)`                   | `str_ends_with($s, $word)`                  |
| 先頭が一致するか    | `s.startsWith(word)`                 | `str_starts_with($s, $word)`                |
| 末尾を削る       | `s.slice(0, s.length - word.length)` | `substr($s, 0, strlen($s) - strlen($word))` |
| 先頭を削る       | `s.slice(word.length)`               | `substr($s, strlen($word))`                 |
| 文字列を反転する    | `s.split("").reverse().join("")`     | `strrev($s)`                                |
| 配列の各要素を変換する | `.map(...)`                          | `array_map(...)`                            |
| 配列を順に見る     | `for (const word of words)`          | `foreach ($words as $word)`                 |
| 正規表現判定      | `regex.test(s)`                      | `preg_match(...)`                           |
| 出力          | `console.log(...)`                   | `echo ... . PHP_EOL`                        |
| プログラム終了     | `process.exit(0)`                    | `exit`                                      |

---

# この問題で重要なポイント

## 1. 先頭から普通に削ると誤判定しやすい

`dream` と `dreamer`、`erase` と `eraser` のように、単語同士に重なりがある。

そのため、先頭から単純に短い単語を削る、または長い単語を削るだけでは、ケースによって誤判定することがある。

---

## 2. 後ろから削ると安定する

後ろから見て、

```txt
dream
dreamer
erase
eraser
```

のどれかで終わっているかを判定する方が扱いやすい。

一致したら、その末尾部分を削る。

これを繰り返して空文字になれば `YES`。

---

## 3. 反転版は「後ろから削る」を「先頭から削る」に変換したもの

文字列も単語も反転すれば、後ろから削る処理を先頭から削る処理として書ける。

TypeScriptでは `startsWith()` が使えるため、処理の意味が分かりやすい。

---

## 4. 正規表現版は短いが、アルゴリズム練習としては補足扱いでよい

正規表現版は非常に短い。

ただし、なぜ正しいかを理解するには正規表現の知識が必要になる。

AtCoder Beginners Selection の学習としては、まずは後ろから削る版、次に反転版を理解すればよい。

---

# 推奨する書き方

## TypeScript：後ろから削る版

```ts
const fs = require("fs");

let s = fs.readFileSync(0, "utf8").trim();

const words = ["dream", "dreamer", "erase", "eraser"];

while (s.length > 0) {
  let matched = false;

  for (const word of words) {
    if (s.endsWith(word)) {
      s = s.slice(0, s.length - word.length);
      matched = true;
      break;
    }
  }

  if (!matched) {
    console.log("NO");
    process.exit(0);
  }
}

console.log("YES");
```

## PHP：後ろから削る版

```php
<?php

$s = trim(stream_get_contents(STDIN));

$words = ["dream", "dreamer", "erase", "eraser"];

while (strlen($s)) {
    $matched = false;

    foreach ($words as $word) {
        if (str_ends_with($s, $word)) {
            $s = substr($s, 0, strlen($s) - strlen($word));
            $matched = true;
            break;
        }
    }

    if (!$matched) {
        echo "NO" . PHP_EOL;
        exit;
    }
}

echo "YES" . PHP_EOL;
```

## TypeScript：反転して先頭から削る版

```ts
const fs = require("fs");

let s = fs.readFileSync(0, "utf8").trim().split("").reverse().join("");

const words = ["dream", "dreamer", "erase", "eraser"]
  .map((word) => word.split("").reverse().join(""));

while (s.length > 0) {
  let matched = false;

  for (const word of words) {
    if (s.startsWith(word)) {
      s = s.slice(word.length);
      matched = true;
      break;
    }
  }

  if (!matched) {
    console.log("NO");
    process.exit(0);
  }
}

console.log("YES");
```

## PHP：反転して先頭から削る版

```php
<?php

$s = trim(stream_get_contents(STDIN));
$s = strrev($s);

$words = ["dream", "dreamer", "erase", "eraser"];
$words = array_map(fn($w) => strrev($w), $words);

while (strlen($s) > 0) {
    $matched = false;

    foreach ($words as $word) {
        if (str_starts_with($s, $word)) {
            $s = substr($s, strlen($word));
            $matched = true;
            break;
        }
    }

    if (!$matched) {
        echo "NO" . PHP_EOL;
        exit;
    }
}

echo "YES" . PHP_EOL;
```

## TypeScript：正規表現版

```ts
const fs = require("fs");

const s = fs.readFileSync(0, "utf8").trim();

const regex = /^(dream|dreamer|erase|eraser)+$/;

console.log(regex.test(s) ? "YES" : "NO");
```

## PHP：正規表現版

```php
<?php

$s = trim(stream_get_contents(STDIN));

$matched = preg_match('/^(dream|dreamer|erase|eraser)+$/', $s);

echo ($matched ? "YES" : "NO") . PHP_EOL;
```
