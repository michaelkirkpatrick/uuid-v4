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
			case 49:
				$string .= '0';
			break;
			case 50:
				$string .= '1';
			break;
			case 51:
				$string .= '0';
			break;
			case 52:
				$string .= '0';
			break;
			case 65:
				$string .= '1';
			break;
			case 66:
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

function validateUUID($uuid){
	// Default
	$valid = false;
	
	// Validate UUID
	if(preg_match('/^([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})$/', $uuid)){
		// Check Version Number
		$time_hi_and_version_hex = substr($uuid, 14, 4);
		$time_hi_and_version_binary = sprintf("%016d", base_convert($time_hi_and_version_hex, 16, 2));
		
		// Check Reserved Sequence
		$clock_seq_hi_and_reserved_hex = substr($uuid, 19, 2);
		$clock_seq_hi_and_reserved_binary = sprintf("%08d", base_convert($clock_seq_hi_and_reserved_hex, 16, 2));
		
		// Validate that the two most significant bits (bits 6 and 7) of clock_seq_hi_and_reserved are zero and one, respectively.
		if(substr($clock_seq_hi_and_reserved_binary, 0, 2) === '10'){
			// Validate that the four most significant bits (bits 12 through 15) of the time_hi_and_version field are 0010, respectively
			if(substr($time_hi_and_version_binary, 0, 4) === '0100'){
				// Valid RFC 4122 v4 UUID
				$valid = true;
			}
		}
	}
	   
	// Return
	return $valid;
}

// Generate a new UUID
echo "Generating UUID...\n";
$uuid = generateUUID();
echo "$uuid\n";

// Validate UUID
$valid = validateUUID($uuid);
if($valid){
	echo "Valid UUID\n";
}else{
	echo "Invalid UUID\n";
}
?>
