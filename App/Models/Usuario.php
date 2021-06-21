<?php
namespace App\Models;

use MF\Model\Model;
use PDO;

class Usuario extends Model {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $perfil;
    private $online;
    private $tema;
    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function salvar(){
    
            $query = "insert into usuario(nome, email, senha) values(:nome,:email,:senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome',$this->__get('nome'));
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->bindValue(':senha',$this->__get('senha'));
        $stmt->execute();

        return $this;
       
        
    }
    public function validarCadastro(){
        $valido = true;

        if(strlen($this->__get('nome')) < 3){
            $valido = false;
        }
        if(strlen($this->__get('email')) < 3){
            $valido = false;
        }
        if(strlen($this->__get('senha')) < 3){
            $valido = false;
        }
        return $valido;
    }
    public function getUsuarioPorEmail(){
        $query = "select nome, email from usuario where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function autenticar(){
        $query = "select id, nome, email, senha, ativo from usuario where email = :email and senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->bindValue('senha',$this->__get('senha'));
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario['id'] != '' && $usuario['nome'] != ''){

            $this->__set('id',$usuario['id']);
            $this->__set('nome',$usuario['nome']);
            $this->__set('online',$usuario['ativo']);

        }
        return $this;
    }
   
    public function fotodeperfil(){
        $query = 'select nome_foto from tb_fotos where id_usuario = :id_usuario';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function seguirUsuario($id_usuario_seguir){
        $query = "insert into usuarios_seguidores(id_usuario, id_usuario_seguindo) values(:seguidor,:seguido)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':seguidor',$this->__get('id'));
        $stmt->bindValue(':seguido',$id_usuario_seguir);
        
        return $stmt->execute();
    }
    public function deixarSeguirUsuario($id_usuario_seguir){
        $query = "delete from usuarios_seguidores where id_usuario = :seguidor and id_usuario_seguindo = :seguido";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':seguidor',$this->__get('id'));
        $stmt->bindValue(':seguido',$id_usuario_seguir);
        
        return $stmt->execute();
    }

    public function tipo_perfil_aluno(){
        $query = 'select * from tb_perfil_aluno where id_usuario = :id_usuario';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function tipo_perfil_professor(){
        $query = 'select * from tb_perfil_professor where id_usuario = :id_usuario';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function emailexiste(){
        $query = "select * from usuario where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->execute();
        return  $stmt->fetch(PDO::FETCH_ASSOC);    
    }

    public function trocartema(){
        $query = 'UPDATE usuario SET tema = :tema where id = :id_usuario';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id'));
        $stmt->bindValue(':tema',$this->__get('tema'));
        $stmt->execute();
        return $this;
    }
    public function atualizar_senha(){
        $query = 'UPDATE usuario SET senha = :senha where email = :email';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->bindValue(':senha',$this->__get('senha'));
        $stmt->execute();
        return $this;
    }

}


?>