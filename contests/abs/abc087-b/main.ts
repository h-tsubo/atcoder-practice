const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const A = input[0];
const B = input[1];
const C = input[2];
const X = input[3];

let count = 0;

for (let i = A; i >= 0; i-- ) {
  for(let j = B; j >= 0; j--) {
    let zan = X - 500 * i - 100 * j;
    if (zan >= 0 && zan / 50 <= C) {
      count ++;
    }
  }
}

console.log(count);