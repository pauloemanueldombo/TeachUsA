<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
session_start();

class chatController extends Action {

    public function chat(){
        $this->validalogin();
        $usuario = Container::getModel('Acoes');
        $usuario->__set('id_usuario',$_SESSION['id']);
        $usuario->visualizar_mensagem();
        if($_SESSION['tema'] == 'layout'){
            $this->render('chat','layout3');
        }else{
            $this->render('chat','layout3Claro');
        }
        
    }
    public function validalogin(){
        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
            header('Location: /');
        }
    }

	}



?>