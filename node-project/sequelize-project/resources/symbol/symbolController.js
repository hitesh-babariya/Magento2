// const { con } = require("../../helper/dbConnection");
// const csv = require("csvtojson");
// var jwt = require("jsonwebtoken");
// const bcrypt = require('bcrypt');
// const saltRounds = 10;
// const fs = require('fs');
// // var moment = require('moment');

module.exports = {

    insertStudent: async (req, res) => {
        const Student = req.app.locals.models.Student;
        const student = await Student.create({ name: "Sunny", age: "21" }).catch(err=>{
            console.error(err);
        });
        console.log("asdkashjdgaksdghjaskdhgaskdhg",student);

    }

};