<style>
tr {padding-top:5px; margin:5px 0;}
td {padding:0 10px; border:1px solid black;}
div {}
.barcode-label {font:7pt Times;}
.barcode-number {font-size:11pt;}
table { }
body {text-align:center;margin:0;}
div#page {width:8.5in;height:11in;margin:0 auto;}
</style>
<body>

<table border=0 align="center" cellspacing="0">

<?php require_once('myBarcode.php');
$bc = new myBarcode($value['name'], $value['type'], 0.8);

$codes = $bc->makeHTMLsequence($value['startNum'], $value['prefix'], $value['NumOfBCs']);

echo $codes;

?>
</table>

</body>