<?php

if(isset($_POST["from_date"], $_POST["to_date"], $_POST["which_data"], $_POST['table_name'], $_POST['column_name']))
{
	$connect = mysqli_connect("localhost", "", "" , "");
	$column_name =[];
	$table_name = $connect -> real_escape_string($_POST['table_name']);
	$column_name = $connect -> real_escape_string($_POST['column_name']);
	$data1 =$connect -> real_escape_string( $_POST["from_date"]);
	$data2 = $connect -> real_escape_string($_POST["to_date"])
	$dat1 = $data1."%";
	$dat2 = $data2."%";
	$which_data = $_POST["which_data"];
	
	if($which_data == "all_data_table")
	{
	$query = sprintf(
		'SELECT * FROM %s WHERE data BETWEEN "%s" AND "%s 23:59:59"',
		$table_name,
		$data1,
		$data2
	); 
	}
	else if($which_data == "data_between_two_dates")
	{
		$query = sprintf(
		'SELECT  id, data, %s FROM %s WHERE data BETWEEN "%s" AND "%s 23:59:59"',
		$column_name[0],
		$table_name,
		$data1,
		$data2
	); 
	
	}
	else if($which_data == "data_two_days")
	{
		$query = sprintf(
		'SELECT id, data, %s FROM %s WHERE data LIKE "%s" OR data LIKE "%s"',
		$column_name[0],
		$table_name,
		$dat1,
		$dat2
	);
	}
	else 
	{
		$query = sprintf(
		'SELECT id, data, %s, %s FROM %s WHERE data BETWEEN "%s" AND "%s 23:59:59"',
		$column_name[0],
		$column_name[1],
		$table_name,
		$data1,
		$data2
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
