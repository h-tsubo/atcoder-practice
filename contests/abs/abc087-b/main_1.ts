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
        count ++;
      }
    }
  }
}

console.log(count);
