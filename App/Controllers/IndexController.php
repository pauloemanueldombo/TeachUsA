<?php

namespace App\Controllers;
//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
use MF\PHPMailer\PHPMailer;

class IndexController extends Action {

	public function index() {
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('index','layoutClaro');
	}

	public function inscreverse() {
		$this->view->usuario = array(
			'nome' => '',
			'email' => '',
			'senha' => '',
		);
		$this->view->erroCadastro = false;

		$this->render('inscreverse','layoutClaro');
	}


	public function registra() {
		session_start();
			$_SESSION['nome'] = $_POST['nome_u'];
			$_SESSION['email'] = $_POST['email_u'];
			$_SESSION['senha'] = $_POST['senha_u'];

		$usuario = Container::getModel('Usuario');
		$usuario->__set('nome',$_POST['nome_u']);
		$usuario->__set('email',$_POST['email_u']);
		$usuario->__set('senha',md5($_POST['senha_u']));

		if(count($usuario->getUsuarioPorEmail()) == 0 && $usuario->validarCadastro()){
			$usuario->salvar();
			print_r('sucesso');
		}
		else
		{
			print_r('existe');
		}

		

	}
	public function utilizador (){
		$this->render('entracom','layoutClaro');
	}
	public function confirmar_email (){
		$this->render('confirmar_email','layoutClaro');
	}

	public function recuperar_senha(){
		$this->render('recuperar_senha','layoutClaro');
	}
	public function muda_senha(){
		$this->render('trocar_senha','layoutClaro');
	}
	public function atualizar_senha(){
		session_start();
		$usuario = Container::getModel('Usuario');
		$usuario->__set('senha',md5($_POST['senha']));
		$usuario->__set('email',$_SESSION['email']);
		$usuario->atualizar_senha();
		print_r('sucesso');
		
	}

}


?>