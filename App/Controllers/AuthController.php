<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

        public function autenticar(){
                $usuario = Container::getModel('Usuario');
                $usuario->__set('email',$_POST['email']);
                $usuario->__set('senha',md5($_POST['senha']));

                $retorno =  $usuario->autenticar();
                $resultado = $usuario->tipo_perfil_aluno();
                $resultado1 = $usuario->tipo_perfil_professor();
                $emailexiste = $usuario->emailexiste();
                $imagem = $usuario->fotodeperfil();

                if($resultado['tipo_perfil'] == 1){
                        if($emailexiste['email'] != '')
                        {       
                                if($usuario->__get('id') != '' && $usuario->__get('nome') != ''){
                                        session_start();
                                        $_SESSION['id'] = $usuario->__get('id');
                                        $_SESSION['nome'] = $usuario->__get('nome');
                                        $_SESSION['perfil'] = 1;
                                        $_SESSION['foto_perfil'] = $imagem['nome_foto']; 
                                        $_SESSION['senha'] = $emailexiste['senha'];
                                        $_SESSION['tema'] = $emailexiste['tema'];
                                        $_SESSION['online'] = strtotime($usuario->__get('online'));
                                        $_SESSION['limite'] = 0;
                                        $_SESSION['limite_p'] = 0;
                                        
                                        header('Location: /timeline');
                                }
                                else 
                                {
                                        
                                        header('Location: /?login=erro');
                                }
                        }
                        else 
                        {
                                header('Location: /?login=erro');
                        }
                }
                else{
                        if($emailexiste['email'] != '')
                        {
                                if($resultado1['tipo_perfil'] == 2 && $usuario->__get('id') != '' && $usuario->__get('nome') != ''){
                                        session_start();
                                        $_SESSION['id'] = $usuario->__get('id');
                                        $_SESSION['nome'] = $usuario->__get('nome');
                                        $_SESSION['perfil'] = 2;
                                        $_SESSION['online'] = strtotime($usuario->__get('online'));
                                        $_SESSION['foto_perfil'] = $imagem['nome_foto']; 
                                        $_SESSION['tema'] = $emailexiste['tema'];
                                        $_SESSION['senha'] = $emailexiste['senha'];
                                        $_SESSION['limite'] = 0;
                                        $_SESSION['limite_p'] = 0;
                                        
                                        header('Location: /timeline_professor');
                                }
                                else 
                                {
                                        
                                        header('Location: /?login=erro');
                                }
                        }
                        else 
                        {
                                header('Location: /?login=erro');
                        }
                }
               

                
               
                    
                

               
        }
		

	}



?>