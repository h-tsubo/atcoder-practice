const fs = require("fs");

const input = fs.readFileSync(0, "utf8")
  .trim().split(/\s+/).map(Number).slice(1);

let mochis = input;
let count = 0;

while(mochis.length > 0) {
  const maxMochi = Math.max(...mochis);
  mochis = mochis.filter((mochi: number) => mochi !== maxMochi );
  count++;
}

console.log(count);
