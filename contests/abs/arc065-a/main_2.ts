const fs = require("fs");

const s = fs.readFileSync(0, "utf8").trim();

const regex = /^(dream|dreamer|erase|eraser)+$/;

console.log(regex.test(s) ? "YES" : "NO");