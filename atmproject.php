<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>ATM Project</title>
<meta http-equiv="content-type"
content="text/html; charset=iso-8859-1" />

</head>

<body>

<h1>ATM Project</h1><hr />

<?php

$Total = 0;
$initial_total = 0;

//Currency Breakdown
$Currency =array(50,20);

//Number of currency notes 
$Currency_amount = array(50=>5,20=>5);

//Calculating Total money present in ATM
foreach($Currency_amount as $k=>$v)
{
	$Total += ($k * $v);
}

$initial_total = $Total;


if(isset($_GET['Payment']))
{
	$change = '';
	
	$Payment = $_GET['Payment'];
	$Withdraw = $Payment;

	if($Payment <= $Total)
	{
    	// ensure the array is sorted in descending order
    	rsort($Currency);
    	$itemsOfEach = array();
    	
    	// loop through all the money units
    	foreach ($Currency as $unit)
    	{
        	// Use this money unit for the largest possible
        	// amount of money

    		$result = intval($Payment / $unit);

        	if($Currency_amount[$unit] >= $result)
        	{
        		$itemsOfEach[$unit] = $result;
        		$Payment %= $unit;
        		// and once you're done, you'll continue with the remainder
        	}
        	else
        	{
        		$itemsOfEach[$unit] = $Currency_amount[$unit];
        		$Payment -= ($Currency_amount[$unit] * $unit);
        	}
    	}

		if($Payment > 0)
		{
			$change = "Correct currency note are not available.";
		}
		else
		{
			foreach($itemsOfEach as $key=>$value)
			{	
				$change .= "$".$key." Bills : ".$value."<br />";
			}

			$Total = $Total-$Withdraw;
		}	
	}
	else
	{
		$change = "Not enough currency in ATM.";
	}
	
	echo "<br />Available Amount : ".$Total;
		
}

?>

<p>Initial Total : <?=$initial_total?></p>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="get" enctype="applicatio/x-www-form-urlencoded">
<p>Withdraw :<input type="text" name="Payment" value="<?php if(isset($_GET['Payment'])){echo $_GET['Payment'];} ?>"></p><p><input type="Submit" value="Withdraw"></p>
</form><hr/>

<?php
	if(isset($change))
	{
		echo $change;
	}
?>
</body>
</html>
