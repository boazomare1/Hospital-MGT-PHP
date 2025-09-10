<?php



	//Create copy of existing running software folder with folder_date_name format.
	
	//$source = '../sourcefolder';
	//$destination = '../destinationfolder';
	
	$dateonly = date('Ymd');
	$timeonly = date('His');
	$originalfoldername = $appfoldername; //Folder Name From db_connect.php
	$backupfoldername = 'Simacle_Hospital_Backup_'.$dateonly.'_'.$timeonly;

	///*
	$source = '../'.$originalfoldername;
	//$destination = '../'.$backupfoldername;
	$destination = 'C:/'.$backupfoldername;
	
	copy_directory ( $source, $destination );
	
	function copy_directory( $source, $destination ) 
	{
		if ( is_dir( $source ) ) 
		{
			@mkdir( $destination );
			$directory = dir( $source );
			while ( FALSE !== ( $readdirectory = $directory->read() ) ) 
			{
				if ( $readdirectory == '.' || $readdirectory == '..' ) 
				{
					continue;
				}
				$PathDir = $source . '/' . $readdirectory; 
				if ( is_dir( $PathDir ) ) 
				{
					copy_directory( $PathDir, $destination . '/' . $readdirectory );
					continue;
				}
				copy( $PathDir, $destination . '/' . $readdirectory );
			}
			
			$directory->close();
		}
		else 
		{
			copy( $source, $destination );
		}
	}
	
	//*/




?>