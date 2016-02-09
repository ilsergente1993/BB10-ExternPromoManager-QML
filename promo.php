<?
	//convertitore millisecondi in data
	//http://www.ruddwire.com/handy-code/date-to-millisecond-calculators/
	
	//NB: non sono previste promozioni con lo stesso codice
	$code = isset($_GET['code']) ? $_GET['code'] : exit();
	$sep = "|";
	$str = str_replace($sep ,'', $code);
	$code = strtoupper($code);
	$nomeFile = "promozioni";
	$handle = fopen($nomeFile, "r");
	$nowMill = round(microtime(true) * 1000);
	$trovato = false;
	$daDecrem = false;
	$daSostituire = "";
	$conCosa = "";
	sleep(1);
	if ($handle) {
		while (($line = fgets($handle)) !== false) {
			$promoz = explode($sep, $line);
			//print_r($promoz);
			if($promoz[0] == $code){
				//codice promozione trovato
				$trovato = true;
				if(intval($promoz[2]) < $nowMill){
					echo "-1"; //promozione scaduta
					exit();
				}
				else if(intval($promoz[1]) <= 0){
					echo "-2"; //promozione esaurita
					exit();
				}
				else{
					//decremento il num di download disponibile
					$daDecrem = true;
					$daSostituire = $line;
					$val = intval($promoz[1]) -1;
					$conCosa = $promoz[0].$sep.($val).$sep.$promoz[2];
					echo "1"; //promozione valida
				}
				break;
			}
		}
		fclose($handle);
		if($trovato && $daDecrem){
			$str = file_get_contents($nomeFile);
			$str = str_replace("$daSostituire", "$conCosa", $str);
			file_put_contents($nomeFile, $str);
		}
		else {
			echo "0"; //promozione inesistente		
		}
	} else {
		echo "-3"; //errore imprevisto
	} 
	exit();
?>
