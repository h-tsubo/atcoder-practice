const fs = require("fs");
const input = fs.readFileSync(0, "utf8")
  .trim().split(/\s+/).map(Number).slice(1);

const sortedMochis = input.sort((a: number, b: number) => b - a);

let count = 0;
let prev = -1;

for (const mochi of sortedMochis) {
  if (mochi !== prev) {
    count++;
    prev = mochi;
  }
}

console.log(count);
