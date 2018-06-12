<?php /*

// This is a simplified example, which doesn't cover security of uploaded files. 
// This example just demonstrate the logic behind the process.

copy($_FILES['file']['tmp_name'], '/files/'.$_FILES['file']['name']);
					
$array = array(
	'filelink' => '/files/'.$_FILES['file']['name'],
	'filename' => $_FILES['file']['name']
);

echo stripslashes(json_encode($array));
	*/
	$dir = $_SERVER['DOCUMENT_ROOT'].'/projects/online_audio_training/components/images/';
 
$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
 
if ($_FILES['file']['type'] == 'application/pdf')
{	
    // setting file's mysterious name
    $filename =$_FILES['file']['name'];
    $file = $dir.$filename;

    // copying
    copy($_FILES['file']['tmp_name'], $file);
	
    // displaying file    
	$array = array(
	'filelink' => '/projects/online_audio_training/components/images/'.$_FILES['file']['name'],
	'filename' => $_FILES['file']['name']
	);

	
	echo stripslashes(json_encode($array));   
    
}
 
?>