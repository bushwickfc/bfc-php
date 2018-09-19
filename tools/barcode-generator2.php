<?
# Originally written by Michael Doherty, modified by Tal Linzen, 2014

include "shared.php";
include "aux_funcs.php";

$con = connect($hostname, $username, $password, $database);

$result = mysqli_query($con,"SELECT * FROM PRODUCTS");
$count = 0;
$lastBarcode = 0;

while ($row = mysqli_fetch_array($result)) {
	if ($row['CODETYPE'] == "UPC" || $row['CODETYPE'] == NULL || $row['CODETYPE'] == "UPC-A" || $row['CODETYPE'] == "UPC-E") {
		if ($row['CODE'][0] == 4 && strlen($row['CODE']) == 12) {
			$code = substr($row['CODE'], 0, -1);
            if ($code > $lastBarcode) {
                $lastBarcode = $code;
            }
		}
	}
	$count++;
}

mysqli_close($con);

echo "new barcode: " . getBarcode((int) $lastBarcode + 1 - 40000000000);

# This function isn't used anymore but kept here in case its ever useful
function checkBarcode($code) {
	if (strlen($code) == 12) {
		$checkDig = substr($code, -1); 
		$checkSum = getCheckDigit($code);
		return ($checkDig == $checkSum);
	}
	else {
		return false;
	}
}

function getBarcode($index) {
	$barcode = $index + 40000000000;
	$barcode = ($barcode * 10) + getCheckDigit(strval($barcode));
	return $barcode;	
}

function getCheckDigit($code) {
    $checkSum = ($code[0] + $code[2] + $code[4] + $code[6] + $code[8] +
       $code[10]) * 3;
	$checkSum += $code[1] + $code[3] + $code[5] + $code[7] + $code[9];
	$checkSum %= 10;
    if ($checkSum != 0) {
        $checkSum = 10 - $checkSum;
    }
	return $checkSum;
}
?>
