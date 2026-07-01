const fs = require("fs");

let numbers = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);
let count = 0;

while(numbers.every((num: number) => num % 2 === 0)) {
  numbers = numbers.map((num: number) => num / 2);
  count ++;
}

console.log(count);