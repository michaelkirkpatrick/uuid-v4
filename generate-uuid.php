<?php
function generateUUID(){
	/*---
	RFC 4122 Compliant Version 4 UUID Generator
	https://tools.ietf.org/html/rfc4122
	---*/
	$string = '';
	$uuid = '';
	$bitCount = 1;
	$charCount = 1;
	for($i=1;$i<=128;$i++){
		/*--
		Generate Bit
		Bits 6 & 7 are 0 and 1 respectively
		Bits 12-15 are 0100, representing a "Version 4" UUID
		See Section 4.4 of RFC 4122
		--*/
		switch($i){
			case 6:
				$string .= '0';
			break;
			case 7:
				$string .= '1';
			break;
			case 12:
				$string .= '0';
			break;
			case 13:
				$string .= '1';
			break;
			case 14:
				$string .= '0';
			break;
			case 15:
				$string .= '0';
			break;
			default:
				$string .= rand(0, 1);
		}

		if($bitCount === 4){
			// Generate Character
			$uuid .= base_convert($string, 2, 16);
			$string = '';

			// Reset Bit Count
			$bitCount = 1;

			// Add Dashes
			switch($charCount){
				case 8:
					$uuid .= '-';
					break;
				case 12:
					$uuid .= '-';
					break;
				case 16:
					$uuid .= '-';
					break;
				case 20:
					$uuid .= '-';
					break;
			}
			$charCount++;
		}else{
			$bitCount++;
		}
	}
	return $uuid;
}

echo generateUUID();
?>
