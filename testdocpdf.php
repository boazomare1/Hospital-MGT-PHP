<?php
// htmlviewer.php
// convert a Word doc to an HTML file
//$DocumentPath = str_replace("\\", "\", $DocumentPath);
$DocumentPath='C:/xampp/htdocs/neema/Ultrasoundtemplate.doc';
// create an instance of the Word application
$word = new COM("word.application") or die("Unable to instantiate application object");
// creating an instance of the Word Document object
$wordDocument = new COM("word.document") or die("Unable to instantiate document object");
$word->Visible = 0;
// open up an empty document
$wordDocument = $word->Documents->Open($DocumentPath);
// create the filename for the HTML version
$HTMLPath = substr_replace($DocumentPath, 'txt', -3, 3);
// save the document as HTML
$wordDocument->SaveAs($HTMLPath, 3);
// clean up
$wordDocument = null;
$word->Quit();
$word = null;
// redirect the browser to the newly-created document header("Location:". $HTMLPath);
header("Location:". $HTMLPath);
?>