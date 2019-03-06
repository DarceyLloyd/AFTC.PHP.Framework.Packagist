const Logger = require(__dirname + '/Logger.js');
let log = new Logger();
const ask = require(__dirname + '/ask.js');


// Methods, Aliases and Export
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// let cloned = Object.assign({}, source);
var methods = {    
    log: log.log,
    enableLog: log.enable,
    disableLog: log.disable,
    cls: log.cls,
    ask: ask
    // dumpProcessEnv: misc.dumpProcessEnv,
    // logProcessEnv: misc.dumpProcessEnv,
    // dumpObject: misc.dumpObject,
    // dumpArray: misc.dumpObject
}
//console.log(methods);

module.exports = methods;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -