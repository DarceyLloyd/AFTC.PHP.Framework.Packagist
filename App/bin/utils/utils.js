const Logger = require(__dirname + '/Logger.js');
let log = new Logger();
const ask = require(__dirname + '/ask.js');


let getCommand = function (index) {
    index++;
    if (typeof (process.argv) == "object") {
        if (process.argv[index]) {
            return process.argv[index];
        } else {
            return null;
        }
    } else {
        return null;
    }
}


let exec = require('child_process').exec;
let runCommand = function (command) {
    let child = exec(command, function (error, successMsg, errorMsg, a) {
        log.log("a = " + a);
        if (successMsg != "" && successMsg != null) {
            log.log(successMsg, "green");
            log.log("Command '" + command + "' should have completed successfully!");
            return true;
        }

        // log('stderr: ' + stderr,"red"); // duplicate of error for some reason
        if (error !== null) {
            // for (let i in error){
            //     log(i + " " + error["+i+"] + " = " + error[i],"cyan");
            // }
            // console.log('exec error: ' + error);
            if (error["cmd"]) {
                log('ERROR Running command: "' + error["cmd"] + "\"", "red");
            }
            log.log("\n");
            log.log("############# E R R O R    M E S S A G E #############", "red")
            errorMsg = errorMsg.replace("\n\n", "\n");
            errorMsg = errorMsg.replace("\r\r", "\r");
            log.log(errorMsg, "red");
            log.log("######################################################", "red")

            return false;
        }
    });
}


// Methods, Aliases and Export
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// let cloned = Object.assign({}, source);
var methods = {
    log: log.log,
    enableLog: log.enable,
    disableLog: log.disable,
    cls: log.cls,
    ask: ask,
    getCommand: getCommand,
    runCommand: runCommand
    // dumpProcessEnv: misc.dumpProcessEnv,
    // logProcessEnv: misc.dumpProcessEnv,
    // dumpObject: misc.dumpObject,
    // dumpArray: misc.dumpObject
}
//console.log(methods);

module.exports = methods;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -