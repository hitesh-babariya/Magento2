const glob = require('glob'); // eslint-disable-line import/no-unresolved

module.exports = (app) => {
    glob(`${__dirname}/resources/**/*Routes.js`, {}, (er, files) => {
        if (er) throw er;
        files.forEach((file) => require(file)(app)); //eslint-disable-line
    });
};
