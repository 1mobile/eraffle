<!DOCTYPE HTML>
<html>
<head>
	<title>Project #1: Form Processing</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<style>
	
body{
 background-color: #3C247F;
}	
.form-style-6 {
    font : 95% Arial, Helvetica, sans-serif;
    max-width : 400px;
    margin : 10px auto;
    padding : 16px;
    background : #fff;
}

.form-style-6 h2 {
    padding : 20px 0;
    font-size : 140%;
    font-weight : 300;
    text-align : center;
    color : #000;
    margin : -16px -16px 16px -16px;
}

.form-style-6 input[type="text"],
.form-style-6 input[type="date"],
.form-style-6 input[type="datetime"],
.form-style-6 input[type="email"],
.form-style-6 input[type="number"],
.form-style-6 input[type="search"],
.form-style-6 input[type="time"],
.form-style-6 input[type="url"],
.form-style-6 textarea,
.form-style-6 select {
    -webkit-transition : all 0.30s ease-in-out;
    -moz-transition : all 0.30s ease-in-out;
    -ms-transition : all 0.30s ease-in-out;
    -o-transition : all 0.30s ease-in-out;
    outline : none;
    box-sizing : border-box;
    -webkit-box-sizing : border-box;
    -moz-box-sizing : border-box;
    width : 100%;
    background : #fff;
    margin-bottom : 4%;
    border : 1px solid #ccc;
    padding : 3%;
    color : #555;
    font : 95% Arial, Helvetica, sans-serif;
}

.form-style-6 input[type="text"]:focus,
.form-style-6 input[type="date"]:focus,
.form-style-6 input[type="datetime"]:focus,
.form-style-6 input[type="email"]:focus,
.form-style-6 input[type="number"]:focus,
.form-style-6 input[type="search"]:focus,
.form-style-6 input[type="time"]:focus,
.form-style-6 input[type="url"]:focus,
.form-style-6 textarea:focus,
.form-style-6 select:focus {
    box-shadow : 0 0 5px #133783;
    padding : 3%;
    border : 1px solid #133783;
}

.form-style-6 input[type="submit"],
.form-style-6 input[type="button"],
.form-style-6 button[type="submit"] {
    box-sizing : border-box;
    -webkit-box-sizing : border-box;
    -moz-box-sizing : border-box;
    width : 100%;
    padding : 3%;
    background : #3a5795;
    border-bottom : 1px solid #133783;
    border-top-style : none;
    border-right-style : none;
    border-left-style : none;
    color : #fff;
}

.form-style-6 input[type="submit"]:hover,
.form-style-6 input[type="button"]:hover,.form-style-6 button[type="submit"]:hover {
    background : #133783;
}

.form-image {

}

.form-line {

}

.form-description-content {

}

.form-section.page-section {

}

.form-header-group {

}

h1{
 font-family: bowlby;
 color: #b64610;
 text-align: center;
}

hr{
 border:1px solid;
 color: #EC7171;
}

.logo{
 margin-left:auto;
 margin-right:auto;
 display:block;
}

@font-face {
    font-family: bowlby;
    src: url(<?php echo base_url(); ?>fonts/bowlby.ttf);
}

	</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="form-style-6">
			<img src='<?php echo base_url(); ?>img/chocologo.png' class= 'logo' height='194' width='303'>
			<hr>
			<h1> Raffle Entry</h1>
			<form method="POST" action="/eraffle/codes/redeem">
			<input type="text" name="name" placeholder="Name" required />
			<input type="email" name="emailaddress" placeholder="Email Address" required />
			<input type="text" name="rafflecode5" placeholder="Raffle Code" required />
			<input type="submit" value="Send" />
			</form>
		</div>
	</div>
</div>
</body>
</html>