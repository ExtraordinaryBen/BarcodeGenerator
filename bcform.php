<html>
<head>
<title>Barcode Generator</title>
<style>
input, select {
width: 200px;
}
h1 { margin-bottom:10px;}
hr {margin:0 auto;}
body { background-color:#4AA6E8; }
#container { text-align:center;padding-bottom:15px;margin:0 auto;width:400px;background-color:white; }
#form { border:1px solid black;width:320px;padding:10px 15px;text-align:right;margin:0 auto; }
</style>
</head>
<body>
<div id="container">
<h1>Barcode Generator</h1>
<div id="form">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method=GET>
Library Name: <input type=text name="name" value="Castle Rock Public Library"/><br/><br/>
Prefix (Optional): <input type=text name="prefix" value=""/><br/><br/>
Last number: <input type=text name="startNum" value=""/><br/><br/>
Quantity: <input type=text name="NumOfBCs" value=""/><br/><br/>
Barcode Type: <select name="type">
<option value='C39'>Code 39</option>
<option value='C93'>Code 93</option>
<option value='C128 '>Code 128</option>
<option value='EAN8'>EAN 8</option>
<option value='EAN13'>EAN 13</option>
<option value='UPCA'>UPC-A</option>
<option value='CODABAR '>CODABAR </option>
</select><br/><br/>

<input type=submit name="submit" value="Submit"/>
</form>
</div>
</div>
</body>
</html>