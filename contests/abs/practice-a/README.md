# PracticeA の TypeScript / PHP 文法メモ

対象問題：

```txt
PracticeA - Welcome to AtCoder
```

入力：

```txt
a
b c
s
```

出力：

```txt
a + b + c と s を空白区切りで出力する
```

---

## TypeScript版

```ts
const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s/);

const a = Number(input[0]);
const b = Number(input[1]);
const c = Number(input[2]);
const s = input[3];

console.log(`${a + b + c} ${s}`);
```

---

### `const fs = require("fs");`

```ts
const fs = require("fs");
```

Node.js の `fs` モジュールを読み込んでいる。

`fs` は file system の略で、ファイルや標準入力を読み込むために使う。

AtCoder の TypeScript / JavaScript では、標準入力を読むために `fs.readFileSync()` を使うことが多い。

---

### `fs.readFileSync(0, "utf8")`

```ts
fs.readFileSync(0, "utf8")
```

標準入力をすべて文字列として読み込む。

`0` は標準入力を意味する。

```txt
0 = stdin
1 = stdout
2 = stderr
```

`"utf8"` は文字コードの指定。

`"urf8"` のように書くと存在しない文字コードなのでエラーになる。

---

### `trim()`

```ts
.trim()
```

文字列の前後の空白や改行を削除する。

例えば、

```txt
"1 2 3 test\n"
```

は、

```txt
"1 2 3 test"
```

になる。

AtCoder の入力には末尾に改行があることが多いため、`trim()` を使うと扱いやすい。

---

### `split(/\s/)`

```ts
.split(/\s/)
```

文字列を空白文字で分割する。

`\s` は、空白・改行・タブなどを表す正規表現。

例えば、入力が以下の場合、

```txt
1
2 3
test
```

`split(/\s/)` によって、次の配列になる。

```ts
["1", "2", "3", "test"]
```

ただし、通常は以下のように `\s+` を使う方が安全。

```ts
.split(/\s+/)
```

`\s+` は「空白文字が1個以上続く部分」をまとめて区切る。

連続する空白や改行があっても、余計な空文字が入りにくい。

---

### `input[0]` などの配列アクセス

```ts
const a = Number(input[0]);
const b = Number(input[1]);
const c = Number(input[2]);
const s = input[3];
```

`input` は配列。

```ts
["1", "2", "3", "test"]
```

なので、

```ts
input[0] // "1"
input[1] // "2"
input[2] // "3"
input[3] // "test"
```

となる。

TypeScript / JavaScript の配列は 0 番目から始まる。

---

### `Number()`

```ts
Number(input[0])
```

文字列を数値に変換する。

標準入力で読み込んだ値は、最初はすべて文字列。

```ts
"1"
```

これを数値として計算するために、

```ts
Number("1")
```

として、

```ts
1
```

に変換する。

この変換をしないと、足し算が文字列連結になる場合がある。

例：

```ts
"1" + "2" + "3"
```

結果：

```txt
123
```

数値に変換すると、

```ts
1 + 2 + 3
```

結果：

```txt
6
```

---

### テンプレートリテラル

```ts
console.log(`${a + b + c} ${s}`);
```

バッククォート `` ` `` を使った文字列。

`${...}` の中に変数や式を書ける。

```ts
`${a + b + c} ${s}`
```

は、例えば `a = 1`, `b = 2`, `c = 3`, `s = "test"` のとき、

```txt
6 test
```

という文字列になる。

通常の文字列連結で書くなら、以下と同じ。

```ts
console.log((a + b + c) + " " + s);
```

---

### `console.log()`

```ts
console.log(...)
```

標準出力に値を出す。

AtCoder では、最終的な答えを `console.log()` で出力する。

`console.log()` は末尾に自動で改行を付ける。

---

## PHP版

```php
<?php

$input = trim(stream_get_contents(STDIN));
$tokens = preg_split('/\s+/', $input);

$a = intval($tokens[0]);
$b = intval($tokens[1]);
$c = intval($tokens[2]);
$s = $tokens[3];

echo ($a + $b + $c) . ' ' . $s . PHP_EOL;
```

---

### `<?php`

```php
<?php
```

PHPコードの開始を表す。

PHPファイルでは、基本的に先頭に書く。

AtCoder の `main.php` でも必要。

---

### `$input`

```php
$input = ...
```

PHPでは変数名の先頭に `$` を付ける。

TypeScript では、

```ts
const input = ...
```

だが、PHPでは、

```php
$input = ...
```

となる。

---

### `stream_get_contents(STDIN)`

```php
stream_get_contents(STDIN)
```

標準入力をすべて文字列として読み込む。

`STDIN` は標準入力を表す。

AtCoder の入力全体をまとめて読むときに使える。

---

### `trim()`

```php
trim(stream_get_contents(STDIN))
```

文字列の前後の空白や改行を削除する。

TypeScript の `trim()` と役割はほぼ同じ。

---

### `preg_split('/\s+/', $input)`

```php
$tokens = preg_split('/\s+/', $input);
```

正規表現を使って文字列を分割する。

`/\s+/` は「空白・改行・タブなどが1個以上続く部分」を意味する。

例えば、入力が以下の場合、

```txt
1
2 3
test
```

`$tokens` は次の配列になる。

```php
["1", "2", "3", "test"]
```

TypeScript の、

```ts
split(/\s+/)
```

に近い。

---

### 配列アクセス

```php
$tokens[0]
$tokens[1]
$tokens[2]
$tokens[3]
```

PHPでも配列は 0 番目から始まる。

```php
$tokens[0] // "1"
$tokens[1] // "2"
$tokens[2] // "3"
$tokens[3] // "test"
```

---

### `intval()`

```php
$a = intval($tokens[0]);
```

文字列を整数に変換する。

標準入力から読んだ値は、最初は文字列。

```php
"1"
```

これを数値として計算するために、

```php
intval("1")
```

として、

```php
1
```

に変換する。

TypeScript の `Number()` に近い。

```ts
Number(input[0])
```

PHPでは、

```php
intval($tokens[0])
```

と書く。

---

### 文字列の連結

```php
echo ($a + $b + $c) . ' ' . $s . PHP_EOL;
```

PHPでは文字列連結に `.` を使う。

TypeScript / JavaScript では `+` を使うことが多いが、PHPでは `.`。

例えば、

```php
'Hello' . ' ' . 'World'
```

結果：

```txt
Hello World
```

このコードでは、

```php
($a + $b + $c) . ' ' . $s
```

で、

```txt
6 test
```

のような文字列を作っている。

---

### `echo`

```php
echo ...
```

標準出力に値を出す。

AtCoder では、最終的な答えを `echo` で出力する。

---

### `PHP_EOL`

```php
PHP_EOL
```

改行を表すPHPの定数。

`EOL` は End Of Line の略。

AtCoder の環境では、実質的に以下と同じと考えてよい。

```php
"\n"
```

つまり、

```php
echo 'test' . PHP_EOL;
```

は、

```php
echo "test\n";
```

とほぼ同じ。

## TypeScript と PHP の対応表

| 処理      | TypeScript                   | PHP                           |
| ------- | ---------------------------- | ----------------------------- |
| 標準入力を読む | `fs.readFileSync(0, "utf8")` | `stream_get_contents(STDIN)`  |
| 前後の空白削除 | `.trim()`                    | `trim()`                      |
| 空白で分割   | `.split(/\s+/)`              | `preg_split('/\s+/', $input)` |
| 数値変換    | `Number(value)`              | `intval($value)`              |
| 変数      | `const a`                    | `$a`                          |
| 配列アクセス  | `input[0]`                   | `$tokens[0]`                  |
| 文字列連結   | `+` またはテンプレートリテラル            | `.`                           |
| 出力      | `console.log()`              | `echo`                        |
| 改行      | `console.log()` が自動で付ける      | `PHP_EOL` を付ける                |
