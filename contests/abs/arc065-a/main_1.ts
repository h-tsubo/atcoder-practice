const fs = require("fs");
let s = fs.readFileSync(0, "utf8").trim().split("").reverse().join("");

const words = ["dream", "dreamer", "erase", "eraser"]
  .map((word) => word.split("").reverse().join(""));

while (s.length > 0) {
  let matched = false;

  for (const word of words) {
    if (s.startsWith(word)) {
      s = s.slice(word.length);
      matched = true;
      break;
    }
  }

  if (!matched) {
    console.log("NO");
    process.exit(0);
  }
}

console.log("YES");
