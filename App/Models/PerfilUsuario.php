<?php
namespace App\Models;

use MF\Model\Model;
use PDO;

class PerfilUsuario extends Model {

        private $id_usuario;
        private $id_pais;
        private $data_nasc;
        private $sexo;
        private $telefone;
        //===================================
        private $cidade;
        private $municipio;
        private $bairro;
        private $rua;
        private $numerocasa;
        //===================================
        private $escola;
        private $nivel;
        private $curso;
        //===================================
        //======== USUARIO LOGADO ==========
        private $email;

        private $id_provincia;


        public function __get($atributo)
            {
                return $this->$atributo;
            }
        public function __set($atributo, $valor)
        {
            $this->$atributo = $valor;
        }
        
        public function getID(){
            $query = "select id from usuario where email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email',$this->__get('email'));
            $stmt->execute();
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados['id'];
        }
        public function get_provincia(){
            $query = "select * from tb_provincia;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $dados;
        }

        public function get_municipio(){
            $query = "select * from tb_municipio inner join tb_provincia on (tb_municipio.id_provincia = tb_provincia.id_provincia)
            where provincia = :id_provincia";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_provincia',$this->__get('id_provincia'));
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $dados;
        }

        public function guardardados(){
            $query = "insert into tb_perfil_aluno(
                id_usuario,
                pais,
                data_nasc,
                sexo,
                telefone,
                cidade,
                municipio,
                bairro,
                rua,
                numerocasa,
                escola,
                nivel,
                curso
                )
                values('".$this->__get('id_usuario')."','".$this->__get('id_pais')."','".$this->__get('data_nasc')."','".$this->__get('sexo')."','".$this->__get('telefone')."','".$this->__get('cidade') ."','".$this->__get('municipio')."','".$this->__get('bairro')."','".$this->__get('rua')."','".$this->__get('numerocasa')."','".$this->__get('escola')."','".$this->__get('nivel')."','".$this->__get('curso')."');";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                return $this;
               
        }



}


?>