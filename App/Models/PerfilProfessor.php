<?php
namespace App\Models;

use MF\Model\Model;
use PDO;

class PerfilProfessor extends Model {

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
        
        private $escola;
        private $nivel;
        private $curso;
        //===================================
        private $id_area;
        private $area_pesquisada;
        private $disciplina;
        private $id_disciplina;
        private $id_professor;
        //======== USUARIO LOGADO ==========
        private $id_provincia;
        private $id_municipio;
        private $id_professor_lugar;
        //==================================
        private $id_foto;
        private $nome_foto;
        private $email;


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

        public function guardardados(){
            $query = "insert into tb_perfil_professor(
                id_usuario,
                pais,
                data_nasc,
                sexo,
                telefone,
                cidade,
                municipio,
                bairro,
                rua,
                escola,
                nivel,
                curso
                )
                values('".$this->__get('id_usuario')."','".$this->__get('id_pais')."','".$this->__get('data_nasc')."','".$this->__get('sexo')."','".$this->__get('telefone')."','".$this->__get('cidade') ."','".$this->__get('municipio')."','".$this->__get('bairro')."','".$this->__get('rua')."','".$this->__get('escola')."','".$this->__get('nivel')."','".$this->__get('curso')."');";
                $stmt = $this->db->prepare($query);
                 $stmt->execute();
    
                return $this;
                
               
        }

        public function getAllarea(){
            $query = "select * from tb_area where area like :area_pesquisada;";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':area_pesquisada','%'.$this->__get('area_pesquisada').'%');
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAlldisciplina(){
            $query = "select * from tb_disciplina where disciplina like :disciplina and id_area = :id_area ";
            $stmt = $this->db->prepare($query); 
            $stmt->bindValue(':disciplina','%'.$this->__get('disciplina').'%');
            $stmt->bindValue(':id_area',$this->__get('id_area'));

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function disciplinaprofessor(){
            $query = 'insert into tb_professor_disciplina(id_usuario,id_disciplina) value(:id_professor,:id_disciplina)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor',$this->__get('id_professor'));
            $stmt->bindValue(':id_disciplina',$this->__get('id_disciplina'));
            $stmt->execute();
            return $this;
        }

        public function listar_disciplina_add(){
            $query = "select * from tb_professor_disciplina inner join tb_disciplina on (tb_disciplina.id_disciplina = tb_professor_disciplina.id_disciplina) where id_usuario = :id_professor;";
                     $stmt = $this->db->prepare($query);
                     $stmt->bindValue(':id_professor',$this->__get('id_professor'));
                     $stmt->execute();

                     return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function eliminar_disciplina_add(){
            $query = 'delete from tb_professor_disciplina where id_professor_disciplina = :id_disciplina';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_disciplina',$this->__get('id_disciplina'));
            $stmt->execute();
            return $this;
        }

        public function listar_provincia(){
            $query = 'select * from tb_provincia';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function lista_municipio(){
            $query = 'select * from tb_municipio where id_provincia = :id_provincia';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_provincia',$this->__get('id_provincia'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function guardar_professor_luagar(){
            $query = 'insert into tb_professor_lugar(id_usuario,id_municipio) value(:id_usuario,:id_municipio)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->bindValue(':id_municipio',$this->__get('id_municipio'));
            $stmt->execute();
            return $this;
        }
        public function lista_professor_lugar(){
            $query = 'select * from tb_professor_lugar inner join tb_municipio on (tb_professor_lugar.id_municipio = tb_municipio.id_municipio) inner join tb_provincia on (tb_provincia.id_provincia = tb_municipio.id_provincia) where id_usuario = :id_usuario;';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function iliminar_professor_luagar(){
            $query = 'delete from tb_professor_lugar where id_professor_lugar = :id_professor_lugar';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor_lugar',$this->__get('id_professor_lugar'));
            $stmt->execute();
            return $this;
        }
        public function guardar_foto(){
            $query = "insert into tb_fotos(id_usuario,nome_foto) value(:id_usuario,:nome_foto)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->bindValue(':nome_foto',$this->__get('nome_foto'));
            $stmt->execute();
            return $this;
        }
        public function carregar_foto(){
            $query = 'select * from tb_fotos where id_foto = (select max(id_foto) from tb_fotos)';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }




}


?>