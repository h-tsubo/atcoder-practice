const fs = require("fs");

const input = fs.readFileSync(0, "utf8")
  .trim().split(/\s+/).map(Number).slice(1);

const mochiSets = new Set(input);

console.log(mochiSets.size);
