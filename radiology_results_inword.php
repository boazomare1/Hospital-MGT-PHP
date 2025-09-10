<?php

date_default_timezone_set('Africa/Nairobi'); 
//echo "file path : ".$rsfile = $_POST['rsfile'];
$loopcount = 0;
$skipcount = 0;
$totalcount = 0;
$importedcount = 0;
$errorskipcount = 0;
$errorskipcount2 = 0;
$content = '';

$word = new COM("word.application") or die ("Could not initialise MS Word object.");

$filename1= $_REQUEST['filename'];

//echo date("d-M-Y H:i:s")." - Extraction Process Started";
flush();

//include ("db/db_connect.php");
//opening msword application
set_time_limit(0);
//echo "<br>".date("d-M-Y H:i:s")." - Processing Folder C:/resume_dump";
//echo "<br>".date("d-M-Y H:i:s")." - Processing Folder uploads folder.";
flush();

//$dirpath = "//India/d/Classic Call Drivers";
//$dirpath = "C:/resume_dump";

//$dh = @opendir($dirpath);

//while (false !== ($file = @readdir($dh))) 
//{
//$totalcount = $totalcount + 1;
//Don't list subdirectories

$dirpath = 'c:/xampp/htdocs/medit/uploads';
$file = $filename1;

if (!is_dir("$dirpath/$file")) 
{
	$loopcount = $loopcount + 1;
	//Truncate the file extension and capitalize the first letter
	//echo "<br>".htmlspecialchars(ucfirst(preg_replace('/\..*$/', '', $file)));
	//echo "<br>".$file;
	
	/*
	$file = strtoupper($file);
	$filename = $file;
	//$spfound = strstr($filename, "'");
	//if ($spfound != '') { $stringfound = 1; }
	//$specialcharacters = array("`", "~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "\\", "'", "=", "+", "|", ",", ";", ":", '"', "[", "{", "]", "}", "<", ">", "/", "?");
	$specialcharacters = array("!", "@", "#", "$", "%", "^", "&", "*", "\\", "'", "=", "+", "|", ";", ":", '"', "{", "}", "<", ">", "/", "?");
	$arraycount = count($specialcharacters);
	for ($i=0;$i<=$arraycount;$i++)
	{
		if(stristr($filename, $specialcharacters[$i]) == TRUE) 
		{
			//echo '<br> String Found ';
			//echo $specialcharacters[$i];
			$stringfound = $stringfound + 1;
		}
	}
	
	if ($stringfound == '0')
	{
	*/
		
		//$query2 = "select auto_number from resumedata where originalname = '$file'";
		//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		//$rowcount2 = mysql_num_rows($exec2);
		//if ($rowcount2 == 0)
		//{
		
			$filetype = substr($dirpath.'/'.$file, -4);
			$filesize = filesize($dirpath.'/'.$file);
			$filesize = $filesize / 1000;
			$filesize = round($filesize);
			
			$filetype2 = strtoupper ($filetype);
			if($filetype2 == '.RTF' || $filetype2 == '.DOC')
			{
			
				$importedcount = $importedcount + 1;
				$rawfilecontent = file_get_contents($dirpath.'/'.$file);
				
				$fp = fopen('resumedump.doc', 'w+');
				fwrite($fp, $rawfilecontent);
				fclose($fp);
				
				//$word->Documents->Open($rsarrayvalue2.'\\'.$file);
				$word->Documents->Open(realpath("resumedump.doc"));
				
				// Extract content.
				$content = (string) $word->ActiveDocument->Content;
				$content = addslashes($content);
				//echo $content;
				
				$word->ActiveDocument->Close(false);
				
				$rawfilecontent = addslashes($rawfilecontent);
				
				//$query1 = "insert into resumedata (rawdata, extracteddata, originalname, filetype, filesize) 
				//values ('$rawfilecontent', '$content', '$file', '$filetype', '$filesize')";
				//$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());		
				
				//echo "<br>".date("d-M-Y H:i:s")." - ".$loopcount." Files Completed - ".$file;
				flush();
			
			}
			
			else
			{
				$errorskipcount = $errorskipcount + 1;
				echo "<br><font color='red'>".date("d-M-Y H:i:s")." - ".$loopcount." - Failed. Only .doc & .rtf extension files are allowed. - ".$file."</font>";
				flush();
			}
		
		//}
		
		/*
		else
		{
			$skipcount = $skipcount + 1;
		}
		*/
	}
	else
	{
		$errorskipcount2 = $errorskipcount2 + 1;
		echo "<br><font color='red'>".date("d-M-Y H:i:s")." - ".$loopcount." - Failed. Only hyphen - and underscore _ are allowed. - ".$file."</font>";
		//echo "<br><font color='red'>".date("d-M-Y H:i:s")." - ".$loopcount." - Failed. Special Characters Found In File Name. - ".$file."</font>";
		flush();
	}
	
//}
$stringfound = 0;
//}
//@closedir($dh);

/*
if ($totalcount >= 2) { $totalcount = $totalcount - 2; }
echo "<br>".date("d-M-Y H:i:s")." - Total ".$totalcount." Files In Folder.";
echo "<br>".date("d-M-Y H:i:s")." - Total ".$importedcount." Files Imported Now.";
echo "<br>".date("d-M-Y H:i:s")." - Total ".$skipcount." Files Already Improted And Skipped.";
echo "<br>".date("d-M-Y H:i:s")." - Total ".$errorskipcount." Files Not In Word Format - .DOC or .RTF.";
echo "<br>".date("d-M-Y H:i:s")." - Total ".$errorskipcount2." Files Contain Special Characters Like  ',~!@#$%^&*()+|=\;: etc.";
echo "<br>".date("d-M-Y H:i:s")." - Resume Extraction Process Completed";
flush();
*/

//closing msword application.
$word->Quit();
$word = null;
unset($word);


echo nl2br($content);

?>