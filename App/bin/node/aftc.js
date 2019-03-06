//console.log("__dirname = " + __dirname);
const utils = require(__dirname + '/utils/utils.js');
const log = utils.log;
const cls = utils.cls;
const ask = utils.ask;

cls();
log("AFTC Framework CLI Tool","green");

// process.argv.forEach(function (val, index, array) {
//     console.log(index + ': ' + val);
// });


let command = "";
let commandFound = false;
let arg1 = "";
let arg2 = "";
let arg3 = "";

if (process.argv[2]){
    command = process.argv[2];
}

// Process command
if (command == "sync"){
    commandFound = true;
    log("Processing command \"sync\"","yellow");
}

if (command == "add" || command == "install" || command == "i"){
    commandFound = true;
    log("Processing command \"install\"","yellow");
}

if (command == "remove" || command == "uninstall" || command == "r"){
    commandFound = true;
    log("Processing command \"uninstall\"","yellow");
}




// Command error
if (!commandFound){
    log("AFTC Framework CLI - Unknown command: [" + command + "]","red");
}

