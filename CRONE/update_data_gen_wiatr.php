<?php
/*curl --silent http://zsepw.webd.pl/CRONE/update_data_gen_wiatr.php > /dev/null 2>&1*/
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
function send_to_MySQL($exploded_result, $table_name, $connect)
{
	$arrayElements = count($exploded_result[0]);
	foreach($exploded_result as $row)
		{
			$date_int = (string) $row[0];
			if($row[1] != 24)
				$date = "'". substr($date_int, 0, 4) . '-' . substr($date_int, 4, 2) . '-' . substr($date_int, 6, 2) . ' ' . ($row[1] < 10 ? '0' : '') . $row[1] . ':00:00' . "'";
			else
				$date = "'". substr($date_int, 0, 4) . '-' . substr($date_int, 4, 2) . '-' . substr($date_int, 6, 2) . ' ' . ($row[1] < 10 ? '0' : '') .'23:59:59' . "'";
			$values = [$date];
			for($i = 1; $i< ($arrayElements-1); $i++)
			{
				$values[$i] = $row[$i+1];
			}
			$query = 'INSERT IGNORE INTO '.$table_name.' VALUES(NULL, ' . implode(',', $values) . ')';
			mysqli_query($connect, $query);
		}
}
	
function explode_date($result)
{

	$lines = explode("\n", $result);
	foreach ($lines as $l => $line)
	{
		$lines[$l] = explode(';', $line);
	}
	$arrayElements2 = count($lines[1]);
		
	array_splice($lines, 0 , 1);
	$arrayElements = count($lines);
	if(empty($lines[$arrayElements-1][0]))
		array_splice($lines, ($arrayElements-1) , 1);	
	$arrayElements = count($lines);
	for($i=0; $i<$arrayElements;$i++)
	{
		if(empty($lines[$i][$arrayElements2-1]))
			unset($lines[$i][$arrayElements2-1]);
	}

	if($arrayElements2 == 4) $arrayElements2 = $arrayElements2-1;
	for($i=0; $i<($arrayElements);$i++)
	{
			for($j=0; $j<($arrayElements2);$j++)
			{
				$lines[$i][$j]= str_replace("," , ".",$lines[$i][$j]);
				if($lines[$i][$j] == "-")
				{
					$lines[$i][$j]= str_replace("-" , "0",$lines[$i][$j]);
				}
			}
	}
	
	if($arrayElements2 == 7) 
	{
		for($i=0; $i<($arrayElements);$i++)
		{
				$lines[$i] += array_splice($lines[$i], 4, 0 , "NULL");
				$lines[$i] += array_splice($lines[$i], 4, 0 , "NULL");
		}
	}
	return($lines);
}

function get_data_from_pse($category,$date_from,$date_to)
{
		$start = microtime(true);
		$ch = curl_init();
		if($date_from == '20140901'){
		curl_setopt($ch, CURLOPT_URL, "https://www.pse.pl/getcsv/-/export/csv/".$category."/data_od/20140901/data_do/20140910");}
		else{
		curl_setopt($ch, CURLOPT_URL, "https://www.pse.pl/getcsv/-/export/csv/".$category."/data_od/".$date_from."/data_do/".$date_to);}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
		
		$headers = array();
		$headers[] = "Pragma: no-cache";
		$headers[] = "Accept-Encoding: gzip, deflate, br";
		$headers[] = "Accept-Language: en-US,en;q=0.9";
		$headers[] = "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/62.0.3202.75 Chrome/62.0.3202.75 Safari/537.36";
		$headers[] = "Accept: /";
		$headers[] = "Referer: https://www.pse.pl/dane-systemowe/funkcjonowanie-kse/raporty-dobowe-z-pracy-kse/generacja-zrodel-wiatrowych";
		$headers[] = "Cookie: JSESSIONID=E489B29847B6787BEF62913EBAD3AEAF.liferay2; ROUTEID=.lifereay2; _pk_ref.1.c235=%5B%22%22%2C%22%22%2C1510776340%2C%22https%3A%2F%2Fwww.google.pl%2F%22%5D; eu_cookieClosed=true; LFR_SESSION_STATE_20159=1510776485471; _pk_id.1.c235=30644e34ecba48f7.1510776340.1.1510776486.1510776340.; _pk_ses.1.c235=*";
		$headers[] = "Connection: keep-alive";
		$headers[] = "Cache-Control: no-cache";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$end = microtime(true);
		//echo ($end - $start).' seconds';	
		if(($end - $start).' seconds' > 60)
			die;
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
		$exploded_result = explode_date($result);
		return $exploded_result;
}

function update_data()
{
	$category  = "GEN_WIATR";
	$connect = mysqli_connect("", "", "" , "");
    $sql='SELECT data FROM '.strtolower($category).' ORDER BY id DESC LIMIT 1';
	$result = mysqli_query($connect, $sql);
	$checked_date = $result->fetch_array(MYSQLI_ASSOC);

	if($checked_date == false)
	{
		$exploded_result = get_data_from_pse($category, '20140901', '20140910');
		send_to_MySQL($exploded_result , strtolower($category),$handler);
	}
    else
	{
		$checked_date["data"] = (string)$checked_date["data"];
		$checked_date["data"]=substr($checked_date["data"], 0, 10);
		$checked_date["data"]=str_replace("-", "",$checked_date["data"]);
		$date_from = new DateTime($checked_date["data"]);

		$date_from = $date_from->format('Ymd');
		$date_to = (new DateTime($checked_date["data"]));
		$date_to = $date_to -> add(new DateInterval('P30D'));
		$date_to = $date_to ->format('Ymd');
		
		$exploded_result = get_data_from_pse($category, $date_from, $date_to);
		send_to_MySQL( $exploded_result, strtolower($category),$connect);
		}
}
update_data();
?>