const router = require('express').Router();
const symbolData = require('./symbolController');
const Student = require('../../models/student');
// const middleware = require('../../helper/middleware');

// var multer = require('multer');
// var storage = multer.diskStorage({
//     destination: function (req, file, cb) {
//         cb(null, 'csvfiles/')
//     },
//     filename: function (req, file, cb) {
//         cb(null, file.originalname)
//     }
// })
// var upload = multer({ storage: storage });

module.exports = (app) => {

    router.route('/insertStudent')
        .post(symbolData.insertStudent);

    app.use(
        '/v1/symbol',
        router
    );
};