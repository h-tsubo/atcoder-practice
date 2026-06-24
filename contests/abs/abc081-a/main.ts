const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split("");

const count = input.filter((v: string) => v === "1").length;

console.log(count);

// 以下と同じ
// let result = 0;
// for (let i = 0; i < input.length; i++) {
//   if (input[i] === "1") {
//     result ++;
//   }
// }

// console.log(result);
