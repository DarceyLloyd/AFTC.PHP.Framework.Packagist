// REF: https://ourcodeworld.com/articles/read/298/how-to-show-colorful-messages-in-the-console-in-node-js

module.exports = class Logger {

    constructor() {
        this.a = 1;
    }

    log(arg_str, arg_txtColor = "", arg_bgColor = "") {
        let params = {
            me: this,
            enabled: true,
            colors: {
                reset: "0m",
                special: {
                    bright: "1m",
                    dim: "2m",
                    underline: "4m",
                    blink: "5m",
                    inverse: "7m",
                    hidden: "8m",
                },
                text: {
                    black: "30m",
                    red: "31m",
                    green: "32m",
                    yellow: "33m",
                    blue: "34m",
                    magenta: "35m",
                    purple: "35m",
                    cyan: "36m",
                    white: "37m",
                },
                bg: {
                    black: "40m",
                    red: "41m",
                    green: "42m",
                    yellow: "43m",
                    blue: "44m",
                    magenta: "45m",
                    cyan: "46m",
                    white: "47m"
                }
            }
        };

         
        // build text color string if available
        let textColor = "";
        if (params.colors.text.hasOwnProperty(arg_txtColor)) {
            let part1 = "\x1b[";
            let part2 = "";
            let part3 = "\x1b[0m";

            part2 = params.colors.text[arg_txtColor];
            console.log(part1 + part2 + arg_str + part3);
        } else {
            console.log(arg_str);
        }


    }

    logParams() {
        console.log(this.params);
    }

    logThis() {
        console.log(this);
    }

    enable() {
        this.enabled = true;
    }

    disable() {
        this.enabled = false;
    }

    cls() {
        // both work
        process.stdout.write('\u001B[2J\u001B[0;0f');
        // process.stdout.write('\033c'); // Octal excape squence may not be allowed
    }


    red() {
        console.log("RED!");
    }

}