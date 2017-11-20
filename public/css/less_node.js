//require less@1.7.5
var express = require('express');
var less = require('less');
var app = express();
var cleanCSS = require('clean-css');
var pub_dir = __dirname + '/less';
var css_comments = "/*\n\
Theme Name: name. \n\
Description: Theme para name.\n\
Author: AVE\n\
Version: 1.0\n\
Copyright 2016.\n\
*/\n\
";

app.get('/', function(req, res){
	res.send('');
});

var parser = new(less.Parser)({
	paths: ['.', './less'],
	filename: 'bootstrap.less'
});

var fs = require('fs');
var str_data = '';
fs.readFile(__dirname + '/less/bootstrap.less', 'ascii', function(err,data){
	if(err) {
		console.error("Could not open file: %s", err);
		process.exit(1);
	}
	str_data = data.toString('ascii');
});

app.get('/bootstrap.css', function(req, res){
	parser.parse(str_data, function (e, tree) {
		var minified_css = tree.toCSS();//{compress: true}
		fs.writeFile(__dirname+"/style.css", css_comments+minified_css, function(err) {
			if(err) {
				console.log(err);
			}
		}); 
		res.contentType('text/css');
		res.send(minified_css);
	});
});

app.get('*.jpg', function(req, res){
	res.sendfile(__dirname + req.url);
});
app.get('*.png', function(req, res){
	res.sendfile(__dirname + req.url);
});
app.get('*.gif', function(req, res){
	res.sendfile(__dirname + req.url);
});

app.get('*.ttf', function(req, res){
        res.header("Access-Control-Allow-Origin", "*");
        res.header("Access-Control-Allow-Headers", "X-Requested-With");
        res.sendfile(path.join(__dirname, '..', req.url));
});
app.get('*.woff', function(req, res){
        res.header("Access-Control-Allow-Origin", "*");
        res.header("Access-Control-Allow-Headers", "X-Requested-With");
        res.sendfile(__dirname + req.url);
});


//app.use(app.router);
app.use(express.static(pub_dir));
app.listen(5004);

