const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const n = input[0];
const a = input[1];
const b = input[2];

let ansSum = 0;

for (let i = 0; i <= n; i++) {
  let digitSum = 0;
  let num = i;

  while(num > 0) {
    digitSum += num %10;
    num = Math.floor(num / 10);
  }

  if (a <= digitSum && digitSum <= b) {
    ansSum += i;
  }
}

console.log(ansSum);
