<?php
//session_start();
include ("../db/db_connect.php");

$json = array('status'=>0,'msg'=>"");
$html ="";
$hasdata =0;
if(!empty($_REQUEST['group_id'])) {

	$group_id= trim($_REQUEST['group_id']);
	$ref_no = trim($_REQUEST['ref_no']);
	if(isset($_REQUEST['from_page']))
	  $from_page = trim($_REQUEST['from_page']);
	else
		$from_page ="";

	if($group_id==5)
		$group_id=6;


	if($group_id !="" && $ref_no !="")
	{

function processReplacement($one, $two)
{
  return $one . strtoupper($two);
}
	
		
		$query10 = "select auto_number,name from `master_costcenter` where group_id = '$group_id'";
		
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_rows = mysqli_num_rows($exec10);
		if($num_rows > 0)
		{
		   
		 	$i =0;
		 	
			while ($res10 = mysqli_fetch_array($exec10))
			{
				$auto_number = $res10["auto_number"];
				$name = ucfirst(strtolower($res10["name"]));
				
				$name=preg_replace("/(^|[^a-zA-Z])([a-z])/e","processReplacement('$1', '$2')", $name);
				if(!$i)
				{
					if($from_page=='grn')
					{
						$html .= '<select name="costcenter[]" id="costcenter'.$ref_no.'"><option value="">Select Cost Center</option>';
					}
					else
					{
						$html .= '<select name="costcenter'.$ref_no.'" id="costcenter'.$ref_no.'"><option value="">Select Cost Center</option>';
					}
					
				}
			   $html .= '<option value="'.$auto_number.'">'.$name.'</option>';
				$i++;	
				$hasdata++;
			 }

		}
		if($hasdata)
		{
		 	$html .= "</select>";
		 	$json = array('status'=>1,'msg'=>$html);
		}
	 

	}
	
}
echo json_encode($json);
?>
