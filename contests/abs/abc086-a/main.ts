const fs = require("fs");

const input = fs.readFileSync(0, "utf-8").trim().split(/\s+/).map(Number);

const [a, b] = input;

const output = a * b % 2 === 0 ? "Even" : "Odd";

console.log(output);