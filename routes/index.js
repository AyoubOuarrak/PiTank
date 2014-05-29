
/*
 * GET home page.
 */

exports.index = function(req, res){
  res.render('index', { title: 'PiTank - Raspberry Pi Tank' })
};
