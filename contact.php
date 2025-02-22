<?php

//Let's clean harmful characters from raw POST data using PHP Sanitize filters.
$postName 		= filter_var($_POST["postName"], FILTER_SANITIZE_STRING); 
$postEmail 		= filter_var($_POST["postEmail"], FILTER_SANITIZE_EMAIL);
$postPhone 		= filter_var($_POST["postPhone"], FILTER_SANITIZE_STRING);
$postMessage 	= filter_var($_POST["postMessage"], FILTER_SANITIZE_STRING);

//Let's put additional php validation here

$toEmail 		= "ricardo@sowee.com.br"; //Replace it recipient email address
$subject 		= '[MSG Satori Hanzo] '.$_POST["postName"].''; //Subject line for emails

if(strlen($postName)<1) // If length is less than 1 we will throw an HTTP error.
{
	header('HTTP/1.1 500 Name Field Empty'); 
	exit();
}
//similar validation applies to all data, unless you want to replace with some other strong validation.
if(strlen($postEmail)<1)
{
	header('HTTP/1.1 500 Email Field Empty'); 
	exit();
}
if(strlen($postPhone)<1)
{
	header('HTTP/1.1 500 Phone Field Empty'); 
	exit();
}
if(strlen($postMessage)<1)
{
	header('HTTP/1.1 500 Message Field Empty'); 
	exit();
}

//Finally we can proceed with PHP email.
$headers = 'From: '.$postEmail.'' . "\r\n" .
    'Reply-To: '.$postEmail.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
//Email Body
$Body = "";
$Body .= "Name: ";
$Body .= $postName;
$Body .= "\n";
$Body .= "\n";
$Body .= "Email: ";
$Body .= $postEmail;
$Body .= "\n";
$Body .= "\n";
$Body .= "Phone: ";
$Body .= $postPhone;
$Body .= "\n";
$Body .= "\n";
$Body .= "Message: ";
$Body .= $postMessage;
$Body .= "\n";
$Body .= "\n";


@$sentMail = mail($toEmail, $subject, $Body .'  -'.$postName,  $headers);

if(!$sentMail)
	{
		header('HTTP/1.1 500 Email não enviado, desculpe tente depois..'); 
		exit();
	}else{
		echo '<h3>Oi  '.$postName.', obrigado pela mensagem!</h3>
		<p>Seu email foi enviado com sucesso aguarde nosso breve retorno...
		<br />Tenha um bom dia.</p>';
	}

?>