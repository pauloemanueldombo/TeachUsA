<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
session_start();

class PerfilController extends Action {

    public $dados;
    public function perfilAluno(){
        $this->render('perfilAluno','layoutClaro');
    }
    public function perfilProfessor(){
        $this->render('perfilProfessor','layoutClaro');
    }

    public function listar_provincia(){
        $provincias = Container::getModel('PerfilUsuario');
        $opcoes = "";
        $lista_provincia = $provincias->get_provincia();
        foreach ($lista_provincia as $key => $valor) {
            $opcoes = $opcoes . '<option value="'.$valor['provincia'].'">'.$valor["provincia"].'</option>';
        }
        print_r('<option value="">Escolha a província...</option>'.$opcoes);
    }

    public function listar_municipio(){
        $provincias = Container::getModel('PerfilUsuario');
        $provincias->__set('id_provincia',$_POST['id_provincia']);
        $opcoes = "";
        $lista_provincia = $provincias->get_municipio();
        foreach ($lista_provincia as $key => $valor) {
            $opcoes = $opcoes . '<option value="'.$valor["municipio"].'">'.$valor["municipio"].'</option>';
        }
        print_r('<option value="">Escolha o município...</option>'.$opcoes);
    }
   


    public function guardar_dado_perfil_aluno(){
    

        $perfilusuario = Container::getModel('PerfilUsuario');
        $perfilusuario->__set('email',$_SESSION['email']);
        $dadosID = $perfilusuario->getID();
        

        $perfilusuario->__set('id_usuario',$dadosID);
        $perfilusuario->__set('id_pais',$_POST['pais']);
        $perfilusuario->__set('data_nasc',$_POST['data_nascimento']);
        $perfilusuario->__set('sexo',$_POST['sexo']);
        $perfilusuario->__set('telefone',$_POST['telefone1']);
        $perfilusuario->__set('bairro', $_POST['bairro']);
        $perfilusuario->__set('rua', $_POST['rua']);
        $perfilusuario->__set('municipio', $_POST['municipio']);
        $perfilusuario->__set('cidade', $_POST['cidade']);
        $perfilusuario->__set('numerocasa', '');
        $perfilusuario->__set('escola', $_POST['escola']);
        $perfilusuario->__set('nivel', $_POST['nivel']);
        $perfilusuario->__set('curso', $_POST['curso']);
        
        $res = $perfilusuario->guardardados();
       
        if($res){
            $this->guardar_foto();
        }
        
    }



    public function guardar_dado_perfil_professor(){

           
        $perfilusuario = Container::getModel('PerfilProfessor');
        $perfilusuario->__set('email',$_SESSION['email']);
        $dadosID = $perfilusuario->getID();
        

        

        $perfilusuario->__set('id_usuario',$dadosID);
        $perfilusuario->__set('id_pais',$_POST['pais']);
        $perfilusuario->__set('data_nasc',$_POST['data_nascimento']);
        $perfilusuario->__set('sexo',$_POST['sexo']);
        $perfilusuario->__set('telefone',$_POST['telefone1']);
        $perfilusuario->__set('cidade',$_POST['cidade']);
        $perfilusuario->__set('bairro', $_POST['bairro']);
        $perfilusuario->__set('rua', $_POST['rua']);
        $perfilusuario->__set('municipio', $_POST['municipio']);
        $perfilusuario->__set('escola', $_POST['escola']);
        $perfilusuario->__set('nivel', $_POST['nivel']);
        $perfilusuario->__set('curso', $_POST['curso']);

       
        $_SESSION['id_professor'] = $perfilusuario->__get('id_usuario');
     
        
        $res = $perfilusuario->guardardados();
        if($res){
            $this->render('concluido','layoutClaro');
        }
            
    }

    public function disciplinaprofessor(){
        
        if(!isset($this->view->adicionados))
        {
            $this->view->adicionados = '';
        }
       
        $perfilusuario = Container::getModel('PerfilProfessor');

        $this->view->lista_area = $perfilusuario->getAllarea();
       

        if(isset($_GET['id_area']) && $_GET['id_area'] != ''){
            $perfilusuario->__set('id_area',$_GET['id_area']);
            $this->view->lista_disciplina = $perfilusuario->getAlldisciplina();
            
        }else{
            $this->view->lista_disciplina = '';
        }
          

        $this->render('disciplinaprofessor','layoutClaro');
    }

    public function guardardisciplina(){
            $perfilusuario = Container::getModel('PerfilProfessor');
            $perfilusuario->__set('email',$_SESSION['email']);
            $dadosID = $perfilusuario->getID();


        
            $perfilusuario->__set('id_disciplina',$_GET['id_disciplina']);
            $perfilusuario->__set('id_professor',$dadosID);
            $perfilusuario->disciplinaprofessor();

            $listar_disciplina_add = $perfilusuario->listar_disciplina_add();
            $dados = $listar_disciplina_add;
            $this->view->adicionados = $dados;
               
        
           $this->disciplinaprofessor();

            
       
    }

    public function iliminar_disciplina_add(){
      
            $perfilusuario = Container::getModel('PerfilProfessor');
            $perfilusuario->__set('id_disciplina',$_GET['id_disciplina']);
            $perfilusuario->__set('email',$_SESSION['email']);
            $dadosID = $perfilusuario->getID();

            $perfilusuario->__set('id_disciplina',$_GET['id_disciplina']);
            $perfilusuario->__set('id_professor',$dadosID);
            $perfilusuario->eliminar_disciplina_add();
            $listar_disciplina_add = $perfilusuario->listar_disciplina_add();
            $dados = $listar_disciplina_add;
            $this->view->adicionados = $dados;

        
        $this->disciplinaprofessor();

    }

    public function lugarprofessor(){
        if(!isset($this->view->professor_lugar)){
            $this->view->professor_lugar = '';
        }

        if(!isset($this->view->municipio)){
            $this->view->municipio = '';
        }
        $perfilusuario = Container::getModel('PerfilProfessor');
        
        $this->view->provincias = $perfilusuario->listar_provincia();

        $this->render('lugarprofessor','layoutClaro');

    }
    public function lista_municipio(){
        $perfilusuario = Container::getModel('PerfilProfessor');
        $perfilusuario->__set('id_provincia',$_POST['id_provincia']);
        $this->view->municipio = $perfilusuario->lista_municipio();
        $this->lugarprofessor();
    }
    public function guardar_professor_luagar(){
        $perfilusuario = Container::getModel('PerfilProfessor');
        $perfilusuario->__set('email',$_SESSION['email']);
        $dadosID = $perfilusuario->getID();
        $perfilusuario->__set('id_municipio',$_POST['id_municipio']);
        $perfilusuario->__set('id_usuario',$dadosID);

        $perfilusuario->guardar_professor_luagar();
        $this->view->professor_lugar = $perfilusuario->lista_professor_lugar();
        $this->lugarprofessor();
    }
    public function iliminar_professor_luagar(){
        $perfilusuario = Container::getModel('PerfilProfessor');

        $perfilusuario->__set('id_professor_lugar',$_GET['id_lugar']);
        $perfilusuario->iliminar_professor_luagar();
        $this->guardar_professor_luagar();

    }
    public function bemvindo_professor(){
        $this->render('bemvindo_professor','layoutClaro');
    }


    public function guardar_foto(){

        $perfilusuario = Container::getModel('PerfilProfessor');

        $perfilusuario->__set('email',$_SESSION['email']);
        $dadosID = $perfilusuario->getID();
        $perfilusuario->__set('nome_foto','foto_perfil.jpg');
        $perfilusuario->__set('id_usuario',$dadosID);
        $perfilusuario->guardar_foto();
        $this->view->foto_perfil = $perfilusuario->carregar_foto();      
        $this->render('bemvindo_professor','layoutClaro');
        
    }
    public function foto_de_perfil(){
        $perfilusuario = Container::getModel('PerfilProfessor');

        $perfilusuario->__set('email',$_SESSION['email']);
        $dadosID = $perfilusuario->getID();
        $perfilusuario->__set('nome_foto','foto_perfil.jpg');
        $perfilusuario->__set('id_usuario',$dadosID);
        $perfilusuario->guardar_foto();
        $this->view->foto_perfil = $perfilusuario->carregar_foto();      
        $this->render('bemvindo_professor','layoutClaro');
    }

   


    
	}

?>