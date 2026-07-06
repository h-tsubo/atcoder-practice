const fs = require("fs");

const [n, y] = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const target = y / 1000 - n;

for (let i = 0; i <= n; i++) {
  const rest = target - 9 * i;

  if (rest < 0) {
    continue;
  }

  if (rest % 4 !== 0) {
    continue;
  }

  const j = rest / 4;
  const k = n - i - j;

  if (j >= 0 && k >= 0) {
    console.log(`${i} ${j} ${k}`);
    process.exit(0);
  }
}

console.log("-1 -1 -1");