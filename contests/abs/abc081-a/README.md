# ABC081A - Placing Marbles の TypeScript / PHP 文法メモ

対象問題：

```txt
ABC081A - Placing Marbles
```

URL：

```txt
https://atcoder.jp/contests/abs/tasks/abc081_a
```

入力：

```txt
s
```

ただし、`s` は `0` と `1` からなる3文字の文字列。

例：

```txt
101
```

出力：

```txt
s に含まれる 1 の個数
```

例：

```txt
2
```

---

## TypeScript版

```ts
const fs = require("fs");

const s = fs.readFileSync(0, "utf8").trim();

const chars = s.split("");

const count = chars.filter((v: string) => v === "1").length;

console.log(count);
```

---

## TypeScript版：for / if で書く場合

```ts
const fs = require("fs");

const s = fs.readFileSync(0, "utf8").trim();

let result = 0;

for (let i = 0; i < s.length; i++) {
  if (s[i] === "1") {
    result++;
  }
}

console.log(result);
```

---

## この問題で新しく出てきた文法事項

### `split("")`

```ts
const chars = s.split("");
```

`split("")` は、文字列を1文字ずつ分割する。

例えば、

```ts
const s = "101";
const chars = s.split("");
```

結果：

```ts
["1", "0", "1"]
```

PracticeA や ABC086A では、入力を空白や改行で分割するために以下を使っていた。

```ts
split(/\s+/)
```

しかし、今回の入力は、

```txt
101
```

のように空白がない文字列。

そのため、

```ts
split(/\s+/)
```

を使うと、

```ts
["101"]
```

になってしまい、1文字ずつ数えることができない。

今回のように文字列を1文字ずつ扱いたい場合は、

```ts
split("")
```

を使う。

---

### `filter()`

```ts
const count = chars.filter((v: string) => v === "1").length;
```

`filter()` は、配列の中から条件に合う要素だけを残すメソッド。

例えば、

```ts
const chars = ["1", "0", "1"];
const ones = chars.filter((v: string) => v === "1");
```

結果：

```ts
["1", "1"]
```

`v === "1"` を満たす要素だけが残る。

---

### アロー関数

```ts
(v: string) => v === "1"
```

これはアロー関数。

以下のような関数を短く書いたもの。

```ts
function isOne(v: string) {
  return v === "1";
}
```

`filter()` の中では、配列の各要素に対してこの関数が実行される。

```ts
chars.filter((v: string) => v === "1")
```

は、

```txt
chars の各要素 v について、v が "1" なら残す
```

という意味。

---

### `(v: string)`

```ts
(v: string) => v === "1"
```

`v: string` は、引数 `v` が文字列であることを表す型注釈。

TypeScriptでは、変数や引数に型を書ける。

```ts
const name: string = "test";
```

今回の `chars` は文字列の配列なので、`filter()` の中の `v` も文字列。

そのため、

```ts
(v: string)
```

と書いている。

ただし、型推論で分かる場合は省略できる。

```ts
const count = chars.filter((v) => v === "1").length;
```

AtCoder用の短いコードなら、省略しても問題ない。

---

### `.length`

```ts
chars.filter((v: string) => v === "1").length
```

`.length` は、文字列や配列の長さを取得する。

配列の場合：

```ts
["1", "1"].length
```

結果：

```txt
2
```

文字列の場合：

```ts
"101".length
```

結果：

```txt
3
```

この問題では、

```ts
chars.filter((v: string) => v === "1")
```

で `"1"` だけの配列を作り、その配列の長さを `.length` で数えている。

---

## PHP版

### `array_filter()` を使う場合

```php
<?php

$s = trim(stream_get_contents(STDIN));

$chars = str_split($s);

$count = count(array_filter($chars, fn($v) => $v === "1"));

echo $count . PHP_EOL;
```

---

### PHP版：for / if で書く場合

```php
<?php

$s = trim(stream_get_contents(STDIN));

$result = 0;

for ($i = 0; $i < strlen($s); $i++) {
    if ($s[$i] === "1") {
        $result++;
    }
}

echo $result . PHP_EOL;
```

---

### `str_split()`

```php
$chars = str_split($s);
```

`str_split()` は、文字列を1文字ずつ分割して配列にする関数。

例えば、

```php
$s = "101";
$chars = str_split($s);
```

結果：

```php
["1", "0", "1"]
```

今回の問題では、入力が空白区切りではなく、

```txt
101
```

のような1つの文字列なので、`preg_split('/\s+/', $s)` ではなく `str_split($s)` を使う。

---

### `preg_split()` と `str_split()` の違い

`preg_split()` は、正規表現に一致する部分で文字列を分割する関数。

例えば、空白・改行・タブで分割する場合：

```php
$tokens = preg_split('/\s+/', $input);
```

入力が以下なら、

```txt
3 4
```

結果：

```php
["3", "4"]
```

一方で、`str_split()` は文字列を指定文字数ごとに分割する関数。

通常は1文字ずつ分割するために使う。

```php
$chars = str_split("101");
```

結果：

```php
["1", "0", "1"]
```

使い分けは以下。

```txt
空白・改行・タブなど、正規表現で区切る → preg_split()
1文字ずつ分割する → str_split()
固定文字で区切る → explode()
```

---

### `preg` の由来

`preg_split()` の `preg` は、

```txt
Perl-compatible regular expression
```

の略。

日本語では「Perl互換正規表現」という意味。

PHP の `preg_*` 系関数は、正規表現を扱うための関数群。

代表例：

```php
preg_match()
preg_match_all()
preg_replace()
preg_split()
```

それぞれの意味：

| 関数                 | 役割                  |
| ------------------ | ------------------- |
| `preg_match()`     | 正規表現に一致するか調べる       |
| `preg_match_all()` | 正規表現に一致するものをすべて取得する |
| `preg_replace()`   | 正規表現に一致した部分を置換する    |
| `preg_split()`     | 正規表現に一致した部分で分割する    |

---

### `array_filter()`

```php
$count = count(array_filter($chars, fn($v) => $v === "1"));
```

`array_filter()` は、配列の中から条件に合う要素だけを残す関数。

例えば、

```php
$chars = ["1", "0", "1"];

$ones = array_filter($chars, fn($v) => $v === "1");
```

結果：

```php
["1", "1"]
```

正確には、PHPの配列キーは保持されるため、内部的には以下のような形になることがある。

```php
[
    0 => "1",
    2 => "1",
]
```

ただし、個数を数えるだけなら問題ない。

```php
count($ones)
```

結果：

```txt
2
```

---

### PHPのアロー関数 `fn`

```php
fn($v) => $v === "1"
```

PHPのアロー関数。

以下のような無名関数を短く書いたもの。

```php
function ($v) {
    return $v === "1";
}
```

つまり、

```php
array_filter($chars, fn($v) => $v === "1")
```

は、

```txt
$chars の各要素 $v について、$v が "1" なら残す
```

という意味。

---

### `count()`

```php
count(array_filter($chars, fn($v) => $v === "1"))
```

`count()` は、配列の要素数を数える関数。

例えば、

```php
count(["1", "1"])
```

結果：

```txt
2
```

この問題では、`array_filter()` で `"1"` だけを残し、その個数を `count()` で数えている。

---

### `strlen()`

```php
strlen($s)
```

`strlen()` は、文字列の長さを取得する関数。

例えば、

```php
strlen("101")
```

結果：

```txt
3
```

for文では、文字列の各文字を順番に見るために使っている。

```php
for ($i = 0; $i < strlen($s); $i++) {
    // 処理
}
```

---

## TypeScript と PHP の対応表

| 処理          | TypeScript                           | PHP                     |
| ----------- | ------------------------------------ | ------------------------|
| 文字列を1文字ずつ分割 | `s.split("")`                        | `str_split($s)`       |
| 条件に合う要素だけ残す | `array.filter(...)`                  | `array_filter(...)`   |
| 要素数を数える     | `.length`                            | `count(...)`         |
| 文字列の長さ      | `s.length`                           | `strlen($s)`         |
| アロー関数       | `(v) => v === "1"`                   | `fn($v) => $v === "1"` |
| for文        | `for (let i = 0; i < s.length; i++)` | `for ($i = 0; $i < strlen($s); $i++)`|
| if文         | `if (s[i] === "1")`                  | `if ($s[$i] === "1")`        |
| 文字列の添字アクセス  | `s[i]`                               | `$s[$i]`               |
| カウントを1増やす   | `result++`                           | `$result++`              |
| 標準出力        | `console.log(count)`                 | `echo $count . PHP_EOL`     |

---
