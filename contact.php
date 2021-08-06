<?php
        $captcha;
        if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){ ?>
          <script language="javascript" type="text/javascript">
				alert('Por favor, revisa el captcha.');
				window.location = 'contact';
		  </script>;
		  <?php
          exit;
        }
        $secretKey = "6LcChPoZAAAAAHFY3_AOHyVj_EVQhOMQLuBJwlh7";
        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        // should return JSON with success as true
        if($responseKeys["success"]) {
            $field_name = $_POST['cf_name'];
$field_email = $_POST['cf_email'];
$field_message = $_POST['cf_message'];

$mail_to = 'info@jordiperez.es';
$subject = 'Message from a site visitor '.$field_name;

$body_message = 'From: '.$field_name."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'Message: '.$field_message;

$headers = 'From: '.$field_email."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";

$mail_status = mail($mail_to, $subject, $body_message, $headers);

if ($mail_status) { ?>
	<script language="javascript" type="text/javascript">
		alert('Gracias por tu mensaje. Contactaré contigo lo antes posible.');
		window.location = 'contact';
	</script>
<?php
}
else { ?>
	<script language="javascript" type="text/javascript">
		alert('Error al enviar mensaje. Por favor, envia un email a info@jordiperez.es');
		window.location = 'contact';
	</script>
<?php
}
        } 
		else {?>
                <script language="javascript" type="text/javascript">
				alert('Hay un poco de spam en tu mensaje.');
				window.location = 'contact';
		  </script>;
				<?php

        }
?>