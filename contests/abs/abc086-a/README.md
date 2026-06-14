# ABC086A - Product

## URL

<https://atcoder.jp/contests/abs/tasks/abc086_a>

## 問題の要約

2つの整数 a, b を受け取り、積が偶数なら Even、奇数なら Odd を出力する。

## 方針

a * b が 2 で割り切れるかを判定する。

## 計算量

O(1)

## 実装メモ

### TypeScript

標準入力を `fs.readFileSync(0, "utf8")` で読み取り、空白区切りで数値化する。

### PHP

`stream_get_contents(STDIN)` で標準入力全体を読み取り、`preg_split` で分割する。

## 詰まった点

特になし。

## 学んだこと

標準入力の基本形と、偶奇判定の書き方。
