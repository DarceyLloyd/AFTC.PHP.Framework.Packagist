'use strict';

module.exports = function (question,callback) {
  const readline = require('readline');
  question.trim(question);
  question += " ";

  const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
  });
  
  rl.question(question, (answer) => {
    rl.close();
    callback(answer);
  });

  // return new Promise((resolve, error) => {
  //   question += " ";
  //   r.question(question, answer => {
  //     r.close();
  //     // resolve(answer);
  //     callback(answer);
  //     //console.log("answer = " + answer);
  //   });
  // })

};