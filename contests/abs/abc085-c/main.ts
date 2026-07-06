const fs = require("fs");

const [n, y] = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number);

const ichiman = 10000;
const gosen = 5000;
const sen = 1000;

for (let i = 0; i <= n; i++) {
  for (let j = 0; j <= n - i; j++) {
    const k = n - i - j;
    const total = ichiman * i + gosen * j + sen * k;

    if (total === y) {
      console.log(`${i} ${j} ${k}`);
      process.exit(0);
    }
  }
}

console.log("-1 -1 -1");
