<?php
$response = array();
/*
 *Handle Email Subscription Form, Use GET instead of POST since Internet Explorer make restriction on POST request
 */
// check email into post data
if (isset($_GET['submit_email'])) {
//    $email = $_GET['email'];  
    $email = filter_var(@$_GET['email'], FILTER_SANITIZE_EMAIL );
    
//    Form validation handles by the server here if required
	/*
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $response['error'] = "A valid email is required.";
    }
	*/

    if (!isset($response['error']) || $response['error'] === '') {

//        PROCESS TO STORE EMAIL GOES HERE
        
        
		/* in this sample code, emails will be stored in a text file */
		$email = str_replace(array('<','>'),array('&lt;','&gt;'),$email);
        

        // -- BELOW : EXAMPLE TO STORE REGISTERED USERS EMAIL IN A FILE "email.txt" (comment to disable it/ uncomment it to enable it)
        
        file_put_contents("email.txt", $email . " \r\n", FILE_APPEND | LOCK_EX);
        
        // -- END OF EXAMPLE TO STORE REGISTERED USERS EMAIL IN A FILE
        

//        End  PROCESS TO STORE EMAIL GOES HERE
                //envio de correo

  
                        $email_from = 'tienda@satelimportadores.com';
                        $email_to = $email;
                        $email_subject = 'Nos gustaría invitarte a conocernos en Expocamacol 2016 ' . $email;
                        

                         include_once('class.phpmailer.php');
                              // Indica si los datos provienen del formulario

                          
                        $correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()
                        $correo->AddEmbeddedImage("../img/Invitaciones.png", "my-attach", "Invitaciones.png");
                        $email_message = '¡Gracias por regístrate! '.$email .' Nos gustaría invitarte a conocernos en Expocamacol 2016 en el centro de convenciones Plaza Mayor de Medellín – Stand 25 del pabellón verde, entre el 24 y 27 de Agosto.' . ' <br><br> ' .' <img alt="PHPMailer" src="cid:my-attach">';
                       
                      //Usamos el SetFrom para decirle al script quien envia el correo
                      $correo->SetFrom($email_from, "Satel Importadores");
                       
                      //Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
                      $correo->AddReplyTo($email_from,"Satel Importadores");
                       
                      //Usamos el AddAddress para agregar un destinatario
                      $correo->AddAddress($email_to);

                      $correo->AddCC($email_from);
                       
                      //Ponemos el asunto del mensaje
                      $correo->Subject = $email_subject;
                       
                      /*
                       * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
                       * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
                       * Si deseamos enviarlo en texto plano, haremos lo siguiente:
                       * $correo->IsHTML(false);
                       * $correo->Body = "Mi mensaje en Texto Plano";
                       */
                      $correo->MsgHTML($email_message);
                       
                      //Si deseamos agregar un archivo adjunto utilizamos AddAttachment
                       $correo->CharSet = 'UTF-8';
                      //Enviamos el correo
                      if(!$correo->Send()) {
                        echo "Hubo un error: " . $correo->ErrorInfo;
                      } else {
                       // echo "Mensaje enviado con exito.";
                      }

        //envio de correo

        $response['success'] = 'You will be notified';
    }
    $response['email'] = $email;
    echo json_encode($response);    
} 

/*
 *Handle Message From-----------------------------------------------------------------------------------
 */
// check email into post data
else if (isset($_GET['submit_message'])) {
    $email = trim($_GET['email']);
    $name = trim($_GET['name']);
    $message = trim($_GET['message']);
    
    
	$email = filter_var(@$_GET['email'], FILTER_SANITIZE_EMAIL );
	
	$name = htmlentities($name);
	$message = htmlentities($message);

//    Form validation handles by the server here if required
	/*
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error']['email'] = "<li>A valid email is required.</li>";
    }
    if (empty($name) || strlen($name) < 3) {
        $response['error']['name'] = '<li>Name is required with at least 3 characters</li>';
    }
    if (empty($message)) {
        $response['error']['message'] = '<li>Empty message is not allowed</li>';
    }
	*/
//    End form validation


    if (!isset($response['error']) || $response['error'] === '') {       

     
//        PROCESS TO STORE MESSAGE GOES HERE
        
        $content = "Name: " . $name . " \r\nEmail: " . $email . " \r\nMessage: " . $message;
        $content = str_replace(array('<','>'),array('&lt;','&gt;'),$content);
        $name = str_replace(array('<','>'),array('&lt;','&gt;'),$name);
        $message = str_replace(array('<','>'),array('&lt;','&gt;'),$message);
        
        // -- BELOW : EXAMPLE SEND YOU AN EMAIL CONTAINING THE MESSAGE (comment to disable it/ uncomment it to enable it)
        // Set the recipient email address.
        // IMPORTANT - FIXME: Update this to your desired email address (relative to your server domaine).
        /*
        $recipient = "your@email.com";

        // Set the email subject.
        $subject = "Message From ".$name;

        // Build the email content.
        $email_content = $message."\n \n";        
        $email_content .= "Sincerely,";
        $email_content .= "From: $name\n\n";
        $email_content .= "Email: $email\n\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
           // http_response_code(200);
            $response['success'] = 'You will be notified';
            //echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
           // http_response_code(500);
            $response['error'] = 'Something went wrong';
            //echo "Oops! Something went wrong and we couldn't send your message.";
        }
        */
        // -- END OF : EXAMPLE YOU AN EMAIL CONTAINING THE MESSAGE 
        
        // -- BELOW : EXAMPLE TO STORE MESSAGE USERS EMAIL IN A FILE "message.txt" (comment to disable it/ uncomment to enable it)
        
        file_put_contents("message.txt", $content . "\r\n---------\r\n", FILE_APPEND | LOCK_EX);
        
        // -- END OF : EXAMPLE TO STORE MESSAGE USERS EMAIL IN A FILE
        
        
//        End  PROCESS TO STORE MESSAGE GOES HERE

                        //envio de correo

  
                        $email_from = 'tienda@satelimportadores.com';
                        $email_to = $email;
                        $email_subject = 'Nos gustaría invitarte a conocernos en Expocamacol 2016 ' . $name ;

                       

                         include_once('class.phpmailer.php');
                              // Indica si los datos provienen del formulario

                          
                          $correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()
                        
                       $correo->AddEmbeddedImage("../img/Invitaciones.png", "my-attach", "Invitaciones.png");
                        $email_message = 
                        'Hemos recibido tu comentario: “'. $message . '”, te contactaremos tan pronto como sea posible. Por ahora, Nos gustaría invitarte a conocernos en Expocamacol 2016 en el centro de convenciones Plaza Mayor de Medellín – Stand 25 del pabellón verde, entre el 24 y 27 de Agosto. ' . ' <br><br> ' .' <img alt="PHPMailer" src="cid:my-attach">';
                      //Usamos el SetFrom para decirle al script quien envia el correo
                      $correo->SetFrom($email_from, "Satel Importadores");
                       
                      //Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
                      $correo->AddReplyTo($email_from,"Satel Importadores");
                       
                      //Usamos el AddAddress para agregar un destinatario
                      $correo->AddAddress($email_to,$name);

                      $correo->AddCC($email_from);
                       
                      //Ponemos el asunto del mensaje
                      $correo->Subject = $email_subject;
                       
                      /*
                       * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
                       * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
                       * Si deseamos enviarlo en texto plano, haremos lo siguiente:
                       * $correo->IsHTML(false);
                       * $correo->Body = "Mi mensaje en Texto Plano";
                       */
                      $correo->MsgHTML($email_message);
                       
                      //Si deseamos agregar un archivo adjunto utilizamos AddAttachment
                       $correo->CharSet = 'UTF-8';
                      //Enviamos el correo
                      if(!$correo->Send()) {
                        echo "Hubo un error: " . $correo->ErrorInfo;
                      } else {
                       // echo "Mensaje enviado con exito.";
                      }

        //envio de correo






        $response['success'] = 'Message sent successfully';
    } else {
        $response['error'] = '<ul>' . $response['error'] . '</ul>';
    }


    $response['email'] = $email;
    echo json_encode($response);
}
