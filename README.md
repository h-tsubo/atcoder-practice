# atcoder-practice

AtCoder の練習記録用リポジトリ。

## 目的

このリポジトリは、AtCoder の問題を通してコーディング基礎力を上げるための学習用プロジェクトです。

主な目的は以下です。

* TypeScript / PHP / Python / C++ の基礎文法に慣れる
* 標準入力・標準出力の扱いに慣れる
* 配列、文字列、Map、Set、sort、ループ、条件分岐などの基本処理を練習する
* 同じ問題を複数言語で解き、言語ごとの差分を理解する
* 解法メモを `README.md` に残し、後から復習しやすくする
* VS Code 上でコードを書き、ローカルでサンプルテストできる環境を作る

提出は、現状では CLI 提出が不安定な場合があるため、基本的にブラウザ提出を前提とする。

---

## 基本方針

このリポジトリでは、言語ごとではなく、**問題ごとにディレクトリを分ける**。

例えば `ABC086A - Product` の場合は、以下のように配置する。

```txt
contests/abs/abc086-a/
├── README.md
├── main.ts
├── main.php
├── main.py
├── main.cpp
└── test/
```

この構成にすることで、同じ問題を TypeScript / PHP / Python / C++ で比較しやすくする。

---

## ディレクトリ構造

```txt
atcoder-practice/
├── README.md
├── package.json
├── tsconfig.json
├── .gitignore
├── contests/
│   └── abs/
│       ├── practice-a/
│       │   ├── README.md
│       │   ├── main.ts
│       │   ├── main.php
│       │   ├── main.py
│       │   ├── main.cpp
│       │   └── test/
│       ├── abc086-a/
│       │   ├── README.md
│       │   ├── main.ts
│       │   ├── main.php
│       │   ├── main.py
│       │   ├── main.cpp
│       │   └── test/
│       └── ...
└── notes/
    ├── standard-input.md
    ├── array.md
    ├── string.md
    └── map-set.md
```

---

## 各ディレクトリの役割

| パス                       | 役割                                   |
| ------------------------ | ------------------------------------ |
| `contests/`              | AtCoder の問題をまとめる                     |
| `contests/abs/`          | AtCoder Beginners Selection の問題をまとめる |
| `contests/abs/abc086-a/` | 個別問題の解答・メモを置く                        |
| `main.ts`                | TypeScript 解答                        |
| `main.php`               | PHP 解答                               |
| `main.py`                | Python 解答                            |
| `main.cpp`               | C++ 解答                               |
| `test/`                  | `oj download` で取得したサンプル入力・出力         |
| `README.md`              | 問題ごとの解法メモ                            |
| `notes/`                 | 標準入力、配列、文字列などの学習メモ                   |

---

## 環境

主に以下を使う。

```txt
Node.js
TypeScript
tsx
PHP
Python
C++
online-judge-tools
```

`online-judge-tools` の `oj` コマンドは、主に以下に使う。

```txt
サンプル取得
ローカルテスト
```

CLI提出は環境やAtCoder側の仕様変更で不安定な場合があるため、基本的にはブラウザ提出を使う。

---

## よく使うコマンド

### プロジェクトルートに移動

```bash
cd atcoder-practice
```

### 問題ディレクトリに移動

例：`ABC086A - Product`

```bash
cd contests/abs/abc086-a
```

### サンプルを取得

```bash
oj download https://atcoder.jp/contests/abs/tasks/abc086_a
```

### TypeScript のサンプルテスト

```bash
oj test -c "npx tsx main.ts"
```

### PHP のサンプルテスト

```bash
oj test -c "php main.php"
```

### Python のサンプルテスト

```bash
oj test -c "python3 main.py"
```

### C++ のサンプルテスト

```bash
g++ -std=c++20 -O2 main.cpp -o main.out && oj test -c "./main.out"
```

### Git に保存

```bash
git status
git add .
git commit -m "Solve ABC086A"
git push
```

---

## 提出方法

現状では、提出はブラウザから行う。

手順：

```txt
1. VS Code でコードを書く
2. oj test でサンプルを確認する
3. AtCoder の提出画面を開く
4. 言語を選ぶ
5. main.ts / main.php / main.py / main.cpp の中身を貼る
6. 提出する
7. ACしたら GitHub に保存する
```

---

# 標準入力・標準出力の基本

AtCoder では、問題ごとに標準入力から値を受け取り、標準出力に答えを出す。

例えば、以下のような入力が与えられる。

```txt
3 4
```

この入力を受け取り、答えを出力する。

```txt
Even
```

---

# TypeScript

## 標準入力の受け取り方

TypeScript / Node.js では、`fs.readFileSync(0, "utf8")` を使って標準入力を読み取る。

```ts
import * as fs from "fs";

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);
```

意味：

```txt
fs.readFileSync(0, "utf8")
→ 標準入力を文字列としてまとめて読む

trim()
→ 前後の空白や改行を削除する

split(/\s+/)
→ 空白・改行・タブで分割する

map(Number)
→ 文字列を数値に変換する
```

## 例：2つの整数を受け取る

```ts
import * as fs from "fs";

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const [a, b] = input;
```

## 標準出力

```ts
console.log("Even");
```

変数を出力する場合：

```ts
const answer = 10;
console.log(answer);
```

## プログラムの途中で止める

TypeScript / Node.js では `process.exit(0)` を使う。

```ts
console.log("Yes");
process.exit(0);
```

例：

```ts
for (let i = 0; i < 10; i++) {
  if (i === 5) {
    console.log(i);
    process.exit(0);
  }
}
```

`process.exit(0)` は正常終了を意味する。

---

# PHP

## 標準入力の受け取り方

PHP では `stream_get_contents(STDIN)` を使って標準入力をまとめて読む。

```php
<?php

$input = trim(stream_get_contents(STDIN));
$tokens = preg_split('/\s+/', $input);
```

意味：

```txt
stream_get_contents(STDIN)
→ 標準入力を文字列としてまとめて読む

trim()
→ 前後の空白や改行を削除する

preg_split('/\s+/', $input)
→ 空白・改行・タブで分割する
```

## 例：2つの整数を受け取る

```php
<?php

$input = trim(stream_get_contents(STDIN));
[$a, $b] = array_map('intval', preg_split('/\s+/', $input));
```

## 標準出力

```php
<?php

echo 'Even' . PHP_EOL;
```

`PHP_EOL` は改行を表す定数。

AtCoder の Linux 環境では、実質的に `"\n"` と同じ。

```php
echo "Even\n";
```

でもよい。

## プログラムの途中で止める

PHP では `exit;` を使う。

```php
<?php

echo 'Yes' . PHP_EOL;
exit;
```

例：

```php
<?php

for ($i = 0; $i < 10; $i++) {
    if ($i === 5) {
        echo $i . PHP_EOL;
        exit;
    }
}
```

`exit;` により、その時点でプログラムを終了する。

---

# Python

## 標準入力の受け取り方

Python では `sys.stdin.read()` を使うと、標準入力をまとめて読める。

```py
import sys

tokens = sys.stdin.read().strip().split()
```

意味：

```txt
sys.stdin.read()
→ 標準入力を文字列としてまとめて読む

strip()
→ 前後の空白や改行を削除する

split()
→ 空白・改行・タブで分割する
```

## 例：2つの整数を受け取る

```py
import sys

tokens = sys.stdin.read().strip().split()
a, b = map(int, tokens)
```

1行入力だけなら、以下でもよい。

```py
a, b = map(int, input().split())
```

ただし、AtCoder では複数行入力に対応しやすい `sys.stdin.read()` の形もよく使う。

## 標準出力

```py
print("Even")
```

変数を出力する場合：

```py
answer = 10
print(answer)
```

## プログラムの途中で止める

Python では `sys.exit()` を使う。

```py
import sys

print("Yes")
sys.exit()
```

例：

```py
import sys

for i in range(10):
    if i == 5:
        print(i)
        sys.exit()
```

`sys.exit()` を使う場合は、先頭で `import sys` する。

---

# C++

## 標準入力の受け取り方

C++ では `cin` を使う。

```cpp
#include <iostream>
using namespace std;

int main() {
    int a, b;
    cin >> a >> b;

    return 0;
}
```

## 標準出力

```cpp
#include <iostream>
using namespace std;

int main() {
    cout << "Even" << endl;

    return 0;
}
```

`endl` は改行を出す。
AtCoder では以下のように `"\n"` を使ってもよい。

```cpp
cout << "Even\n";
```

`"\n"` の方が軽いので、競プロではこちらもよく使う。

## プログラムの途中で止める

C++ では `return 0;` を使って `main` 関数を終了する。

```cpp
#include <iostream>
using namespace std;

int main() {
    cout << "Yes" << endl;
    return 0;
}
```

ループの途中で答えが出た場合：

```cpp
#include <iostream>
using namespace std;

int main() {
    for (int i = 0; i < 10; i++) {
        if (i == 5) {
            cout << i << endl;
            return 0;
        }
    }

    return 0;
}
```

`return 0;` は正常終了を意味する。

## include について

AtCoder の多くのC++解答では、以下が使われる。

```cpp
#include <bits/stdc++.h>
using namespace std;
```

ただし、`bits/stdc++.h` は GCC 用の非標準ヘッダー。
Mac標準の Apple Clang では使えない場合がある。

Macでも通しやすい基本形は以下。

```cpp
#include <iostream>
#include <vector>
#include <string>
#include <algorithm>
#include <set>
#include <map>
using namespace std;
```

---

# 言語別テンプレート

## TypeScript

```ts
import * as fs from "fs";

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

// 処理を書く

console.log("answer");
```

## PHP

```php
<?php

$input = trim(stream_get_contents(STDIN));
$tokens = preg_split('/\s+/', $input);

// 処理を書く

echo 'answer' . PHP_EOL;
```

## Python

```py
import sys

tokens = sys.stdin.read().strip().split()

# 処理を書く

print("answer")
```

## C++

```cpp
#include <iostream>
#include <vector>
#include <string>
#include <algorithm>
#include <set>
#include <map>
using namespace std;

int main() {
    // 処理を書く

    cout << "answer" << endl;

    return 0;
}
```

---

# 問題ごとの README.md テンプレート

各問題ディレクトリには、以下の形式で `README.md` を置く。

```md
# 問題名

## URL

https://atcoder.jp/contests/xxx/tasks/xxx

## 問題の要約

## 方針

## 計算量

## 実装メモ

### TypeScript

### PHP

### Python

### C++

## 詰まった点

## 学んだこと
```

---

# 学習メモ

## まず優先すること

最初は高度なアルゴリズムより、以下を優先する。

```txt
標準入力
標準出力
if
for
while
配列
文字列
sort
Set
Map
全探索
```

## AIの使い方

最初から答えのコードを出してもらうのではなく、以下の使い方を優先する。

```txt
1. まず自分で解く
2. 詰まったらヒントだけもらう
3. 自分のコードを貼って間違いを指摘してもらう
4. AC後に解法を説明してもらう
5. README.md に自分の言葉でまとめる
```

---

# 現在の基本運用

```txt
VS Codeでコードを書く
↓
oj test でサンプル確認
↓
ブラウザで提出
↓
ACしたら README.md を書く
↓
GitHubにcommit / push
```

CLI提出は便利だが、AtCoder側の仕様変更や `online-judge-tools` 側の問題で不安定になる場合がある。
そのため、当面は提出のみブラウザで行う。
