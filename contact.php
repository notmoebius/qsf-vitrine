<?php 
	if($_POST) {

		$to = "dct.talentland@gmail.com"; // Your email here
		$subject = 'Mail test de contact'; // Subject message here

	}

	//Send mail function
	function send_mail($to,$subject,$message,$headers){
		if(@mail($to,$subject,$message,$headers)){
			echo json_encode(array('info' => 'success', 'msg' => "Votre message a été envoyé. Merci !"));
		} else {
			echo json_encode(array('info' => 'error', 'msg' => "Erreur, votre message n'a pas pu être envoyé"));
		}
	}

	//Check if $_POST vars are set
	if(!isset($_POST['name']) || !isset($_POST['mail']) || !isset($_POST['comment'])){
		echo json_encode(array('info' => 'error', 'msg' => 'Remplir tous les champs s\'il vou plait'));
	}

	//Sanitize input data, remove all illegal characters	
	$name    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$mail    = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
	$website = filter_var($_POST['website'], FILTER_SANITIZE_STRING);
	$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

	//Validation
	if($name == '') {
		echo json_encode(array('info' => 'error', 'msg' => "Saisir votre nom, svp."));
		exit();
	}
	if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
		echo json_encode(array('info' => 'error', 'msg' => "Saisir votre e-mail, svp."));
		exit();
	}
	if($comment == ''){
		echo json_encode(array('info' => 'error', 'msg' => "PSaisir votre message, svp."));
		exit();
	}

	//Send Mail
	$headers = 'From: ' . $mail .''. "\r\n".
	'Reply-To: '.$mail.'' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	send_mail($to, $subject, $comment . "\r\n\n"  .'Name: '.$name. "\r\n" .'Email: '.$mail, $headers);
?>