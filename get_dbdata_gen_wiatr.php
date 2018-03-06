<?php
if(isset($_POST["from_date"], $_POST["to_date"], $_POST["which_data"]))
{
	$connect = mysqli_connect("localhost", "", "" , "");
	$data1 = $connect -> real_escape_string($_POST["from_date"]);
	$data2 = $connect -> real_escape_string($_POST["to_date"]);
	$dat1 = $data1."%";
	$dat2 = $data2."%";
	$which_data = $connect -> real_escape_string($_POST["which_data"]);
	
	if($which_data == "data_between_two_dates")
	{
		$query = sprintf(
		'SELECT * FROM gen_wiatr WHERE data BETWEEN "%s" AND "%s 23:59:59"',
		$data1,
		$data2
	); 
	}
	else
	{
		$query = sprintf(
		'SELECT * FROM gen_wiatr WHERE data LIKE "%s" OR data LIKE "%s"',
		$dat1,
		$dat2
		);
	}
	$result = mysqli_query($connect, $query);
	$myArray = [];
	
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $myArray[] = $row;
    }
    echo json_encode($myArray);
}
?>