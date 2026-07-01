const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);

const cards = input.sort((a: number, b: number) => b - a);

let result = 0;

for (let i = 0; i < cards.length; i++) {
  result = i % 2 === 0 ? result + cards[i]
    : result - cards[i];
}

console.log(result);
