const fs = require("fs");
let s = fs.readFileSync(0, "utf8").trim();

const words = ["dream", "dreamer", "erase", "eraser"];

while (s.length > 0) {
  let matched = false;

  for (const word of words) {
    if (s.endsWith(word)) {
      s = s.slice(0, s.length - word.length);
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
