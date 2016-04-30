<?php
        
	$source = "PLS PLS PLS PLS PLS PLS PLS PLS PLS PLS CBGN[ NXT PLS PLS PLS PLS PLS PLS PLS NXT PLS PLS PLS PLS PLS PLS PLS PLS PLS PLS NXT PLS PLS PLS LST LST LST MNS ]CEND NXT PLS PLS OUT NXT PLS OUT PLS PLS PLS PLS PLS PLS PLS OUT OUT PLS PLS PLS OUT NXT PLS PLS OUT LST LST PLS PLS PLS PLS PLS PLS PLS PLS PLS PLS PLS PLS PLS PLS PLS OUT NXT OUT PLS PLS PLS OUT MNS MNS MNS MNS MNS MNS OUT MNS MNS MNS MNS MNS MNS MNS MNS OUT NXT PLS OUT NXT PTN OUT";
	$source = array_values(array_filter(preg_split('/ /', $source)));
	
	
	$chain = array(0);
	$cell = 0;
	$brackets = 0;
	for($i=0; $i<count($source); ++$i) {
		switch(strtoupper($source[$i])) {
			case "PTN": 
			$chain[$cell] = $chain[$cell] + 10;
			break;
			case "MTN":
			$chain[$cell] = $chain[$cell] - 10;
			break;
			case "OUTU":
			print htmlspecialchars(chr($chain[0]));
			break;
			case "PUTU":
			print htmlspecialchars($chain[0]);
			break;
			case "NOP":
			
			break;
			case "CLR":
			$chain[$cell] = 0;
			break;
                        case "CLRU":
                        $chain[0] = 0;
                        break;
			case "PUT":
			print htmlspecialchars($chain[$cell]);
			break;
			case "MLT":
			if( $chain[0] != 0 and $chain[1] != 0 ){
				$chain[$cell] = $chain[0] * $chain[1];
			} else {
				$chain[$cell] = 0;
			}
			break;
			case "DIV":
			if( $chain[0] != 0 and $chain[1] != 0 ){
				$chain[$cell] = $chain[0] / $chain[1];
			} else {
				$chain[$cell] = 0;
			}
			break;
			case "POW":
			if( $chain[0] != 0 and $chain[1] != 0 ){
				$chain[$cell] = pow($chain[0],$chain[1]);
			} else {
				$chain[$cell] = 0;
			}
			break;
			case "PLS" : // +
				$chain[$cell]++;
				break;
			case "MNS" : // -
				$chain[$cell]--;
				break;
			case "OUT" : // .
				print htmlspecialchars(chr($chain[$cell]));
				break;
			case "NXT" : // >
				$cell++;
				if(!isset($chain[$cell])) {
					$chain[$cell] = 0;
				}
				break;
			case "LST" : // <
				$cell--;
				if(!isset($chain[$cell])) {
					$chain[$cell] = 0;
				}
				break;
				case "UPR":
				$cell = 0;
				break;
				if(!$chain[$cell]) {
					$brackets = 1;
					while($brackets) {
						$i++;
						if($source[$i] == "CBGN[") {

							$brackets++;
						} else if($source[$i] == "]CEND") {
							$brackets--;
						}
					}
				}
				break;
			case "]CEND" :
				if($chain[$cell]) {
					$brackets = 1;
					while($brackets) {
						$i--;
						if($source[$i] == "]CEND") {
							$brackets++;
						} else if($source[$i] == "CBGN[") {
							$brackets--;
						}
					}
				}
				break;
				default:
				echo "<font color='red'>Error</font>: not exists operator '".$source[$i]."'\n";
				exit(0);
				break;
		}
	}
?> 
