const fs = require("fs");

const input = fs.readFileSync(0, "utf8").trim().split(/\s+/).map(Number).slice(1);

let nums = input;
let count =  1;
let result = 0;

while(nums.length > 0) {
  const max = Math.max(...nums);
  const index = nums.indexOf(max);

  result = count % 2 ? result + max
    : result - max;
  
  nums.splice(index, 1);
  count++;
}

console.log(result);