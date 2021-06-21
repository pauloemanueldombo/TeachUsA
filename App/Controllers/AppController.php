<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
session_start();

class AppController extends Action {

        public function menu_inicial(){
            $this->validalogin();
            if($_SESSION['perfil'] == '1'){
                $this->timeline();
            }else
            if($_SESSION['perfil'] == '2'){
                $this->timeline_professor();
            }
        }

        public function vermais(){
            $this->validalogin();
            $_SESSION['limite'] =  $_SESSION['limite'] + 7;
            if($_SESSION['perfil'] == '1'){
                header('Location: /timeline');
            }else
            if($_SESSION['perfil'] == '2'){
                 header('Location: /timeline_professor');
            }
        }
        
        public function vermenus(){
            $_SESSION['limite'] =  $_SESSION['limite'] - 7;
            if($_SESSION['perfil'] == '1'){
                header('Location: /timeline');
            }else
            if($_SESSION['perfil'] == '2'){
                 header('Location: /timeline_professor');
            }
        }

        public function vermais_p(){
            $this->validalogin();
            $_SESSION['limite_p'] =  $_SESSION['limite_p'] + 7;
            header('Location: /timeline_publico');
        }
        
        public function vermenus_p(){
            $this->validalogin();
            $_SESSION['limite_p'] =  $_SESSION['limite_p'] - 7;
            header('Location: /timeline_publico');
        }


        public function timeline(){
            $this->validalogin();
                   
                    $tweets = Container::getModel('Tweet');
                    $tweets->__set('id_usuario', $_SESSION['id']);
                    $this->view->tweet = $tweets->getAll();
                    $fotos = $tweets->carregar_foto();
                    $this->view->foto_perfil = $fotos[0]['nome_foto'];
                    $this->view->lista_professor = $tweets->lista_professor();
                    $like = [];
                    $arquivado = [];
                    $cont = 0;

                    $postagem = Container::getModel('Acoes');
                    $postagem->__set('id_aluno',$_SESSION['id']);
                    $this->view->lista_prof = $postagem->listar_prof();


                    foreach($this->view->tweet as $key => $valor){
                        $tweets->__set('id_tweet', $valor['id']);

                        $numero_like = $tweets->get_num_like();
                        $numero_arquivado = $tweets->get_num_arquivado();

                        $arquivado[$cont] = $numero_arquivado[0]['count(id_tweet)'];
                        $like[$cont] = $numero_like[0]['count(id_tweet)'];
                        $cont++;
                    }
                    $this->view->num_arquivado = $arquivado;
                    $this->view->num_like = $like;

                    $this->view->professor_total = $tweets->carregar_professor();
                    $this->view->aluno_total = $tweets->carregar_aluno();
                    $this->view->pergunta_total = $tweets->carregar_publicacao();
                    $this->view->resposta_total = $tweets->carregar_respostas();
                    

                    $this->view->tarefa_novo = $tweets->getquant_tarefa_novo();
                    $this->view->respondidas = $tweets->getquant_duvida_respondida_novo();
                    $this->view->notificacao_novo = $tweets->getquant_notificacao_novo();
                    $_SESSION['origem'] = 'aluno';
                    $this->render('timeline',$_SESSION['tema']);

        }
        
        public function timeline_professor(){
                    $this->validalogin();
                    $tweets = Container::getModel('Tweet');
                    $tweets->__set('id_usuario', $_SESSION['id']);
                    $this->view->tweet = $tweets->getAllProfessor();
                    $fotos = $tweets->carregar_foto();
                    $this->view->foto_perfil = $fotos[0]['nome_foto'];
                   
                     //=============================================
                     $usuario = Container::getModel('Acoes');
                     $usuario->__set('id_adm',$_SESSION['id']);
                     $this->view->turma = $usuario->get_turma();
                     //=============================================
                     $usuario->__set('id_professor',$_SESSION['id']);
                     $this->view->lista_alunos = $usuario->listar_aluno();
                     //=============================================
                    
                    $like = [];
                    $arquivado = [];
                    $cont = 0;
                    foreach($this->view->tweet as $key => $valor){
                        $tweets->__set('id_tweet', $valor['id']);

                        $numero_like = $tweets->get_num_like();
                        $numero_arquivado = $tweets->get_num_arquivado();

                        $arquivado[$cont] = $numero_arquivado[0]['count(id_tweet)'];
                        $like[$cont] = $numero_like[0]['count(id_tweet)'];
                        $cont++;
                    }
                   $this->view->num_arquivado = $arquivado;
                    $this->view->num_like = $like;

                    $numeroprofessor = $tweets->carregar_professor();
                    $numeroaluno = $tweets->carregar_aluno();
                    $numeropublicacao = $tweets->carregar_publicacao();
                    $numeroresposta = $tweets->carregar_respostas();

                    $info[0] =  $numeroprofessor['count(id_perfil_professor)'];
                    $info[1] = $numeroaluno['count(id_perfil_aluno)'];
                    $info[2] = $numeropublicacao['count(id)'];
                    $info[3] = $numeroresposta['count(id_resposta)'];
                    $this->view->info = $info;
                    
                    $_SESSION['origem'] = 'professor';
                   $this->view->aluno_novo = $tweets->getquant_novo();
                   $this->view->tarefa_novo = $tweets->getquant_tarefa_novo();
                   $this->view->duvida_novo = $tweets->getquant_duvida_novo();
                   $this->view->notificacao_novo = $tweets->getquant_notificacao_novo();
                   
                   $this->render('timeline_professor',$_SESSION['tema']);
                   

        }
        public function postagens(){
            
                    $this->validalogin();
                    $tweets = Container::getModel('Tweet');
                    $tweets->__set('id_usuario', $_SESSION['id']);
                    $like = [];
                    $arquivado = [];
                    if($_SESSION['perfil'] == '1'){
                        $postagem = $tweets->getAll();
                        $this->view->tweet = $tweets->getAll();
                        $cont = 0;
                        foreach($this->view->tweet as $key => $valor){
                            $tweets->__set('id_tweet', $valor['id']);

                            $numero_like = $tweets->get_num_like();
                            $numero_arquivado = $tweets->get_num_arquivado();

                            $arquivado[$cont] = $numero_arquivado[0]['count(id_tweet)'];
                            $like[$cont] = $numero_like[0]['count(id_tweet)'];
                            $cont++;
                        }
                    }else{
                        $postagem = $tweets->getAllProfessor();
                        $this->view->tweet = $tweets->getAllProfessor();
                        $cont = 0;
                        foreach($this->view->tweet as $key => $valor){
                            $tweets->__set('id_tweet', $valor['id']);

                            $numero_like = $tweets->get_num_like();
                            $numero_arquivado = $tweets->get_num_arquivado();

                            $arquivado[$cont] = $numero_arquivado[0]['count(id_tweet)'];
                            $like[$cont] = $numero_like[0]['count(id_tweet)'];
                            $cont++;
                        }
                    }
                    
        }

        public function timeline_publico(){

            $this->validalogin();
                   $tweets = Container::getModel('Tweet');
                    $tweets->__set('id_usuario', $_SESSION['id']);
                    $this->view->tweet = $tweets->getAllPublico();
                    $this->view->minhas_postagem = $tweets->getAllPublicominhas();
                    $fotos = $tweets->carregar_foto();
                    $this->view->foto_perfil = $fotos[0]['nome_foto'];

                    
                    $like = [];
                    $arquivado = [];
                    $cont = 0;

                    foreach($this->view->tweet as $key => $valor){
                        $tweets->__set('id_tweet', $valor['id']);

                        $numero_like = $tweets->get_num_like();
                        $numero_arquivado = $tweets->get_num_arquivado();

                        $arquivado[$cont] = $numero_arquivado[0]['count(id_tweet)'];
                        $like[$cont] = $numero_like[0]['count(id_tweet)'];
                        $cont++;
                    }
                   $this->view->num_arquivado = $arquivado;
                    $this->view->num_like = $like;

                    $numeroprofessor = $tweets->carregar_professor();
                    $numeroaluno = $tweets->carregar_aluno();
                    $numeropublicacao = $tweets->carregar_publicacao();
                    $numeroresposta = $tweets->carregar_respostas();

                    $info[0] =  $numeroprofessor['count(id_perfil_professor)'];
                    $info[1] = $numeroaluno['count(id_perfil_aluno)'];
                    $info[2] = $numeropublicacao['count(id)'];
                    $info[3] = $numeroresposta['count(id_resposta)'];
                    $this->view->info = $info;
                    
                    if($_SESSION['perfil'] == '1'){
                        $this->view->tarefa_novo = $tweets->getquant_tarefa_novo();
                        $this->view->respondidas = $tweets->getquant_duvida_respondida_novo();
                        $this->view->notificacao_novo = $tweets->getquant_notificacao_novo();
                    }else{
                        $this->view->aluno_novo = $tweets->getquant_novo();
                        $this->view->tarefa_novo = $tweets->getquant_tarefa_novo();
                        $this->view->duvida_novo = $tweets->getquant_duvida_novo();
                        $this->view->notificacao_novo = $tweets->getquant_notificacao_novo();
                    }
                  

                   $this->render('timeline_publico',$_SESSION['tema']);

        }



        public function sair(){
            session_destroy();
            header('Location: /');
        }
        public function tweet(){
                $this->validalogin();

                if($_POST['id_tipo'] != '' && $_POST['tweet'] != '' ){
                $tweet = Container::getModel('Tweet');
                
                $tweet->__set('id_usuario', $_SESSION['id']);
                $tweet->__set('tweet', $_POST['tweet']);
                $tweet->__set('id_tipo', $_POST['id_tipo']);
                $tweet->__set('titulo', $_POST['titulo']); 
                $tweet->__set('pdf', $this->carregar_pdf()); 
                $tweet->__set('pdf_original', $_FILES['pdf']['name']); 
                $tweet->__set('pdf_descricao', "Clica no baixar para começar o download do documento..."); 
                
                if($_FILES['pdf']['name'] != ""){
                    $tweet->__set('imagem_carregada', "indefinido");
                }
                else{
                    $tweet->__set('imagem_carregada', $this->carregar_imagem()); 
                }
                
                $tweet->salvar();
   
                if($_SESSION['perfil'] == '1' && !isset($_POST['turma'])){
                    header('Location: /timeline');
                }else if($_SESSION['perfil'] == '2' && !isset($_POST['turma']))
                {
                    header('Location: /timeline_professor');
                }else if(isset($_POST['turma']))
                {
                    header('Location: /entrar_turma?id_turma='.$_POST['turma']);
                }
            }
            else{
                if($_SESSION['perfil'] == '1' && !isset($_POST['turma'])){
                    header('Location: /timeline?men=erro');
                }else if($_SESSION['perfil'] == '2' && !isset($_POST['turma']))
                {
                    header('Location: /timeline_professor?men=erro');
                }else if(isset($_POST['turma']))
                {
                    header('Location: /entrar_turma?id_turma='.$_POST['turma'].'&men=erro');
                }
            }
               
        }
        public function carregar_imagem(){
            $nome_foto = $_FILES['imagem']['name'];
            $tmp_name = $_FILES['imagem']['tmp_name'];
            move_uploaded_file($tmp_name,"./imagem_carregada/".$nome_foto);
            if($nome_foto == ''){
                return 'indefinido';
            }
            else{
                 return $nome_foto;
            }
           
        }
        public function carregar_pdf(){
            if(isset($_FILES['pdf'])){
                $nome_foto = $_FILES['pdf']['name'];
                $tmp_name = $_FILES['pdf']['tmp_name'];
                $nome_foto = str_replace(" ","_",$nome_foto);
                $nome_foto = str_replace("ç","c",$nome_foto);
                $nome_foto = str_replace("á","a",$nome_foto);
                $nome_foto = str_replace("â","a",$nome_foto);
                $nome_foto = str_replace("ã","a",$nome_foto);

                if(file_exists("./ficheiro_pdf/$nome_foto")){
                    $a = 1;
                    while(file_exists("./ficheiro_pdf/[$a]$nome_foto")){
                        $a++;
                    }
                    $nome_foto = "[".$a."]".$nome_foto;
                }
                if(move_uploaded_file($tmp_name,"./ficheiro_pdf/".$nome_foto)){
                    $tweets = Container::getModel('Tweet');
                    $tweets->Zipar($nome_foto,$nome_foto.".zip","./ficheiro_pdf/");
                    unlink("./ficheiro_pdf/$nome_foto");
                    return $nome_foto.".zip";
                }
                else{
                    return "indefinido";
                }
            }
            else
            {
                return "indefinido";
            }
        }

        public function validalogin(){
            if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
                header('Location: /');
            }
        }

        

        public function trocatema(){
            $usuario = Container::getModel('Usuario');
            $usuario->__set('id',$_SESSION['id']);
            if($_SESSION['tema'] == 'layout'){
                $usuario->__set('tema','layoutClaro');
                $_SESSION['tema'] = 'layoutClaro';
            }else{
                $usuario->__set('tema','layout');
                $_SESSION['tema'] = 'layout';
            }
            $usuario->trocartema();
            if($_SESSION['perfil'] == '1'){
                header('Location: /aluno');
            }else{
                header('Location: /professor');
            }
            
        }

        public function acao(){
            $this->validalogin();
            $id_usuario_seguir = isset($_GET['id_usuario']) ? $_GET['id_usuario']: '';
            $acao = isset($_GET['acao']) ? $_GET['acao']: '';
            $usuario = Container::getModel('Usuario');
            $usuario->__set('id',$_SESSION['id']);

            if($acao == "deixar_de_seguir"){
                $acont = $usuario->deixarSeguirUsuario($id_usuario_seguir);
                if($acont){
                    header('Location: /quem_seguir?acao=seguido');
                } 
            }else 
            if($acao == "segir"){
               $acont = $usuario->seguirUsuario($id_usuario_seguir);
               if($acont){
                   header('Location: /quem_seguir?acao=seguido');
               } 
            }

        }

	}



?>