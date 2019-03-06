//console.log("__dirname = " + __dirname);
const utils = require(__dirname + '/utils/utils.js');
const log = utils.log;
const cls = utils.cls;
const ask = utils.ask;

cls();
log("#################################################################################", "cyan");
log("##########                   AFTC Framework CLI Tool                   ##########", "cyan");
log("#################################################################################", "cyan");

// process.argv.forEach(function (val, index, array) {
//     console.log(index + ': ' + val);
// });


let m1 = utils.getCommand(1);
let m2 = utils.getCommand(2);
let m3 = utils.getCommand(3);
let m4 = utils.getCommand(4);

// log("Command 1 = " + m1, "red");
// log("Command 2 = " + m2, "red");
// log("Command 3 = " + m3, "red");
// log("Command 4 = " + m4, "red");






let targetDir = __dirname.replace("\\App\\bin", "");
// log("targetDir = " + targetDir);
//log('Starting directory: ' + process.cwd());


try {
    process.chdir(targetDir);
    //console.log('Current directory: ' + process.cwd());
    log("Running composer please wait...", "yellow");

    let exec = require('child_process').exec;
    //let command = "node --version";
    let command = "composer require ircmaxell/random-lib";

    let child = exec(command,
        function (error, successMsg, errorMsg) {
            if (successMsg != "" && successMsg != null) {
                log('SUCCESS!',"green");
                log('Command: "' + command + '" should have run successfully', "white");
                // log("Success...","green");
                // log(successMsg, "green");
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
                log("\n");
                log("############# E R R O R    M E S S A G E #############", "red")
                errorMsg = errorMsg.replace("\n\n", "\n");
                errorMsg = errorMsg.replace("\r\r", "\r");
                log(errorMsg, "red");
                log("######################################################", "red")
            }
        });
    return false;

}
catch (err) {
    console.log('chdir: ' + err);
}

return false;







switch (m1) {
    case "add":
        switch (m2) {
            case "package":
                log("AFTC: Adding base package [" + m2 + "] to composer.json AFTC main package list", "yellow");
                let cmd = "composer require " + m2;
                log("AFTC: Attempting to run [" + cmd + "]", "yellow");
                log("#### WARNING ####\nIf composer fails to install [" + m2 + "], please run " + cmd + "\" directly and debug the issue.", "cyan");

                let targetDir = __dirname.replace("\\App\\bin", "");
                log("targetDir = " + targetDir);



                // https://stackoverflow.com/questions/3133243/how-do-i-get-the-path-to-the-current-script-with-node-js
                // https://stackoverflow.com/questions/20643470/execute-a-command-line-binary-with-node-js

                break;
            case "module":
                break;
            default:
                break;
        }
    case "remove":
        switch (m2) {
            case "package":
                log("AFTC: Removing base package [" + m2 + "] from composer.json AFTC main package list", "yellow");
                let cmd = "composer remove " + m2;
                log("AFTC: Attempting to run [" + cmd + "]", "yellow");
                log("#### WARNING ####\nIf composer fails to uninstall [" + m2 + "], please run " + cmd + "\" directly and debug the issue.", "cyan");
                break;
            case "module":
                break;
            default:
                break;
        }
        break;
    default:
        log("AFTC Framework CLI - Unknown command: [" + m1 + "]", "red");
        break;
}




//process.chdir('../');


process.exit(1);
//return false;

// // Process command
// if (mainCommand == "sync"){
//     mainCommandFound = true;
//     log("Processing command \"sync\"","yellow");
// }

// if (mainCommand == "add" || mainCommand == "install" || mainCommand == "i"){
//     mainCommandFound = true;
//     log("Processing command \"install\"","yellow");
// }

// if (mainCommand == "remove" || mainCommand == "uninstall" || mainCommand == "r"){
//     mainCommandFound = true;
//     log("Processing command \"uninstall\"","yellow");
// }

// // Command error
// if (!mainCommandFound){
//     log("AFTC Framework CLI - Unknown command: [" + mainCommand + "]","red");
// }

