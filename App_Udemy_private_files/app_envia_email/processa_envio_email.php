<?php


	// ********** Importando a Biblioteca PHPMailer ***************//

	// ******* IMPORTANTE ******
	// Esse requires fora transportados para o arquivo
	// processa_envio_email.php da pasta publica

	// require "./bibliotecas/PHPMailer/Exception.php";
	// require "./bibliotecas/PHPMailer/OAuth.php";
	// require "./bibliotecas/PHPMailer/PHPMailer.php";
	// require "./bibliotecas/PHPMailer/POP3.php";
	// require "./bibliotecas/PHPMailer/SMTP.php";

	//use namespacez\(recurso)classe;
	use  PHPMailer\PHPMailer\PHPMailer; 
	use  PHPMailer\PHPMailer\Exception;

	// echo '<pre>';
	// 	print_r($_POST);
	// echo '</pre>';

	class Mensagem {

		// criando os atributos para o envio dos dados do send mail
		private $email_destino = null;
		private $assunto = null;
		private $mensagem = null;
		public $status = array('codigo_status' => null, 'descricao_status' => '');

		// crinado o método mágico "get"
		public function __get($atributo) {
			return $this->$atributo;
		}

		// crinado o método mágico "set"
		public function __set($atributo , $valor) {
			$this->$atributo = $valor;
		}

		public function mensagemValida() {

			// Vamos fazer uma validação simple
			// Apenas verificar se todos os campos estão preenchidos
			// A função "empty" (determina se a variável é vazia)
			if (empty($this->email_destino) || empty($this->assunto) || empty($this->mensagem)) {
				return false;
			}

			return true;
		}

	}


	// Instaciando o objeto para a apicação
	$mensagem = new Mensagem();

	// Recuperando os valores 
	// Os valores dos índices dos "post" não definidos pela variável "name"
	// OBS.: A palavra POST tem que ser escrita em letra maiuscula
	$mensagem->__set('email_destino', $_POST['email_destino']);
	$mensagem->__set('assunto', $_POST['assunto']);
	$mensagem->__set('mensagem', $_POST['mensagem']);

	// // DEBUG: Verificando no browser o valor recebido
	// echo '<pre>';
	// 	print_r($mensagem);
	// echo '</pre>';

	// // Pegando o valor do atributo setado e colocando uma variável
	// // Obs.: Temos que usar o método mágico "__get", para esses atributos são privados
	// echo '</hr>';
	// echo $email = $mensagem->__get('email_destino') . '<br>';
	// echo $assunto = $mensagem->__get('assunto') . '<br>';
	// echo $texto_mensagem = $mensagem->__get('mensagem') . '<br>';


	// Validando se os dados são válidos
	if(!$mensagem->mensagemValida()) {
		// DEBUG: Verificando no browser o valor recebido
		echo "Mensagem válida";

		// Matar = Não executa o resto do processamento do código
		header('Location: index.php');
	} 

	// Trazendo o código do exemplo do github (Crtl C / Crtl V)
	$mail = new PHPMailer(true);
	try {
	    //Server settings
	    $mail->SMTPDebug = false;                                 // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    
	    // ******** Configurando o host do servidor de email ********
	    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    
	    //********* Configurando user/pass **********
	    $mail->Username = 'username@gmail.com';                 // SMTP username
	    $mail->Password = 'password';                           // SMTP password

	    //********* Configurando criptografia **********
	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted

	    //********* Configurando porta **********
	    $mail->Port = 587;                                    // TCP port to connect to

	    //Recipients
	    //********* Configurando remetente **********
	    $mail->setFrom('email@gmail.com', 'Udemy_PHP_App_Envio de email');
	    $mail->addAddress($mensagem->__get('email_destino'));     // Add a recipient
	    
	    //$mail->addReplyTo('info@example.com', 'Information'); // Responder o e-mail para que recebeu
	    //$mail->addCC('cc@example.com'); // Destinatário de cópia
	    //$mail->addBCC('bcc@example.com'); // Destinatário de cópia oculta

	    //Attachments
	    // ******* Não ativando a opção de enviar anexo *****
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $mensagem->__get('assunto');
	    $mail->Body    = $mensagem->__get('mensagem');
	    $mail->AltBody = 'É necessário usar um cliente que suporte HTML para ter acesso toral ao conteúdo dessa mensagem.';

	    $mail->send();

	    $mensagem->status['codigo_status'] = 1;
	    $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso';
	    
		
		}

		catch (Exception $e) {
		    // Mensagem original
		    //echo 'Message could not be sent.';
		    //echo 'Não foi possivel enviar esse email. Por favor tente novamente mais tarde';
			$mensagem->status['codigo_status'] = 2;
	    	$mensagem->status['descricao_status'] = 'E-mail enviado com sucesso Detalhes do erro: ' . $mail->ErrorInfo;

		    // Mensagem original
		    // echo 'Mailer Error: ' . $mail->ErrorInfo;
		    //echo 'Detalhes do erro: ' . $mail->ErrorInfo;
	    

		}

?>


<html>
	<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>

	<body>
		<div class="container">
			<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>

			<div class="row">
				<div class="col-md-12">
					
					<? if($mensagem->status['codigo_status'] == 1) {?>
						<div class="container">
							<h1 class="display-4 text-success">Sucesso</h1>
							<p><?= $mensagem->status['descricao_status'] ?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
						</div>
					<? } ?>

					<? if($mensagem->status['codigo_status'] == 2) {?>
						<div class="container">
							<h1 class="display-4 text-danger">Ops!!</h1>
							<p><?= $mensagem->status['descricao_status'] ?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
						</div>
					<? } ?>

				</div>
				
			</div>
		</div>
	</body>
</html>