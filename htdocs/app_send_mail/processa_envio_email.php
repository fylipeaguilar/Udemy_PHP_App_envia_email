<?php

	// Buscando o arquivo na pasta de segurança
	require "../../App_Udemy_private_files/app_envia_email/bibliotecas/PHPMailer/Exception.php";
	require "../../App_Udemy_private_files/app_envia_email/bibliotecas/PHPMailer/OAuth.php";
	require "../../App_Udemy_private_files/app_envia_email/bibliotecas/PHPMailer/PHPMailer.php";
	require "../../App_Udemy_private_files/app_envia_email/bibliotecas/PHPMailer/POP3.php";
	require "../../App_Udemy_private_files/app_envia_email/bibliotecas/PHPMailer/SMTP.php";


	// Arquivo criado para chamar o "arquivo correto fora do diretorio publico"
	require "../../App_Udemy_private_files/app_envia_email/processa_envio_email.php";

?>