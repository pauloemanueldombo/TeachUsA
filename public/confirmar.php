<?php

		require("./PHPMailer/PHPMailer.php");
		require("./PHPMailer/Exception.php");
		require("./PHPMailer/SMTP.php");

		if(isset($_POST['nome'])){
			session_start();
			$_SESSION['nome'] = $_POST['nome'];
			$_SESSION['codigo'] = rand(100000,900000);
			$_SESSION['email'] = $_POST['email_u'];
	
			$email = new PHPMailer\PHPMailer\PHPMailer();
			$email->isSMTP();
			$email->Port = "465";
			$email->Host = "smtp.gmail.com";
			$email->IsHTML(true);
			$email->SMTPSecure = "ssl";
			$email->CharSet = "UTF-8";
	
			$email->SMTPAuth = true;
			$email->Username = "pauloedombo@gmail.com";
			$email->Password = "923354674";
	
			$email->SingleTo = true;
	
			$email->From = "pauloedombo@gmail.com";
			$email->FromName = "TeachUs";
			$email->addAddress($_SESSION['email']);
			$email->Subject = "Recuperar Senha";
			$email->Body = "O teu codigo de recuperação da senha é << ". $_SESSION['codigo'] ." >>";
	
			if($email->send()){
				print_r("sucesso");
			}
			else{
				echo "erro";
				$email->ErrorInfo;
			}
		}else{
			session_start();
			$_SESSION['nome'] = $_POST['nome_u'];
			$_SESSION['email'] = $_POST['email_u'];
			$_SESSION['senha'] = $_POST['senha_u'];
			$_SESSION['codigo'] = rand(100000,900000);
			
	
			$email = new PHPMailer\PHPMailer\PHPMailer();
			$email->isSMTP();
			$email->Port = "465";
			$email->Host = "smtp.gmail.com";
			$email->IsHTML(true);
			$email->SMTPSecure = "ssl";
			$email->CharSet = "UTF-8";
	
			$email->SMTPAuth = true;
			$email->Username = "pauloedombo@gmail.com";
			$email->Password = "923354674";
	
			$email->SingleTo = true;
	
			$email->From = "pauloedombo@gmail.com";
			$email->FromName = "TeachUs";
			$email->addAddress($_SESSION['email']);
			$email->Subject = "Confirmar email";
			$email->Body = "O teu codigo de confirmação << ". $_SESSION['codigo'] ." >>";
	
			if($email->send()){
				print_r("sucesso");
			}
			else{
				echo "erro";
				$email->ErrorInfo;
			}
		}
		

?>