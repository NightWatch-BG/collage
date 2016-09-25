<?php
	include 'dbConfig.php';
	define('UPLOAD_DIR', 'images/');

    if(!isset($_POST["design"])){
        die("Post was empty.");
    }
	$img = $_POST['design'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);
    print $success ? $file : 'Unable to save the file.';

    if(!isset($_POST["jcanvas"])){
        die("Post was empty.");
    }
	
	$canvasStmt = "";
	if(!($canvasStmt = $conn->prepare("INSERT INTO design(preview, background_color) VALUES (?, ?)"))){
		die( "Error preparing: (" .$conn->errno . ") " . $conn->error);
	}
	if(!($canvasStmt->bind_param('ss',$file, $_POST['jcanvas']['background']))){
		die( "Error in bind_param: (" .$conn->errno . ") " . $conn->error);
	}
    $canvasStmt->execute();

	$last_id = $conn->insert_id;

	$elementStmt = "";
	$sql = "INSERT INTO element(design_fk, type, src, top, e_left, width, height, fill, radius, e_text) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	if(!($elementStmt = $conn->prepare($sql))){
		die( "Error preparing: (" .$conn->errno . ") " . $conn->error);
	}
	$blank ="";
	$no_radius = 0;
	foreach ($_POST['jcanvas']['objects'] as $element) {
		switch($element['type']) {
			case "image":
				if(!($elementStmt->bind_param('issiiiisis', $last_id, $element['type'], $element['src'], $element['top'], $element['left'], $element['wight'], $element['height'], $blank, $no_radius, $blank))){
					die( "Error in bind_param: (" .$conn->errno . ") " . $conn->error);
				}
				$elementStmt->execute();
				break;
			case "circle":
				if(!($elementStmt->bind_param('issiiiisis', $last_id, $element['type'], $blank, $element['top'], $element['left'], $element['wight'], $element['height'], $element['fill'], $element['radius'], $blank))){
					die( "Error in bind_param: (" .$conn->errno . ") " . $conn->error);
				}
				$elementStmt->execute();				
				break;
			case "rect":
			case "triangle":
				if(!($elementStmt->bind_param('issiiiisis', $last_id, $element['type'], $blank, $element['top'], $element['left'], $element['wight'], $element['height'], $element['fill'], $no_radius, $blank))){
					die( "Error in bind_param: (" .$conn->errno . ") " . $conn->error);
				}
				$elementStmt->execute();		
				break;
			case "text":
				if(!($elementStmt->bind_param('issiiiisis', $last_id, $element['type'], $blank, $element['top'], $element['left'], $element['wight'], $element['height'], $blank, $no_radius ,$element['text']))){
					die( "Error in bind_param: (" .$conn->errno . ") " . $conn->error);
				}
				$elementStmt->execute();			
				break;
		}
	}
/*
	if ($success) {
		$response["img"] = $file;
		$response["elements"] = $_POST['jcanvas'];
		echo json_encode($response); 
	} else {
		echo "Error!";
	}
*/
?>