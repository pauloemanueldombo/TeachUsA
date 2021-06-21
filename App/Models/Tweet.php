<?php
namespace App\Models;

use MF\Model\Model;
use PDO;
use ZIPARCHIVE;

class Tweet extends Model {

        private $id;
        private $id_usuario;
        private $tweet;
        private $data;
        private $id_tipo;
        private $id_tweet;
        private $imagem_carregada;
        private $pdf;
        private $pdf_original;
        private $pdf_descricao;
        private $limite;

        public function __get($atributo)
            {
                return $this->$atributo;
            }
        public function __set($atributo, $valor)
        {
            $this->$atributo = $valor;
        }

        public function salvar(){
            $query = "INSERT into tweets(id_usuario,id_tipo,titulo,tweet,imagem_carregada,pdf,pdf_original,pdf_descricao) values(:id_usuario,:id_tipo,:titulo,:tweet,:imagem_carregada,:pdf,:pdf_original,:pdf_descricao)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->bindValue(':tweet',$this->__get('tweet'));
            $stmt->bindValue(':id_tipo',$this->__get('id_tipo'));
            $stmt->bindValue(':titulo',$this->__get('titulo'));
            $stmt->bindValue(':imagem_carregada',$this->__get('imagem_carregada'));
            $stmt->bindValue(':pdf',$this->__get('pdf'));
            $stmt->bindValue(':pdf_original',$this->__get('pdf_original'));
            $stmt->bindValue(':pdf_descricao',$this->__get('pdf_descricao'));
            $stmt->execute();
            return $this;
        }


        public function getAll(){
            $query = "SELECT 
            tweets.id, tweets.id_usuario, usuario.nome,tweets.titulo, tweets.tweet, tweets.pdf, tweets.pdf_original, tweets.pdf_descricao, tweets.id_tipo, tweets.imagem_carregada, date_format(tweets.data,'%d-%m-%Y %H:%i') as data, tb_fotos.nome_foto,
            (select count(id_like) from tb_like where id_usuario = :id_usuario and id_tweet = tweets.id) as estado_like
          from tweets 
            left join usuario
            on (tweets.id_usuario = usuario.id)
            inner join tb_fotos on (tb_fotos.id_usuario = usuario.id)
            where tweets.id_grupo = 0 and  tweets.id_usuario = :id_usuario or
            not (select count(*) from tb_relacao where (SELECT count(*) from tb_relacao where id_professor = tweets.id_usuario and id_aluno = :id_usuario and estado = 1))= 0 
            and tweets.id_grupo = 0
                order by tweets.data desc
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getAllProfessor(){
            $query = "SELECT 
            tweets.id, tweets.id_usuario, usuario.nome,tweets.titulo, tweets.tweet,tweets.pdf, tweets.pdf_original, tweets.pdf_descricao, tweets.imagem_carregada, date_format(tweets.data,'%d-%m-%Y %H:%i') as data, tb_fotos.nome_foto,
            (select count(id_like) from tb_like where id_usuario = :id_usuario and id_tweet = tweets.id) as estado_like
          from tweets 
            left join usuario
            on (tweets.id_usuario = usuario.id)
            inner join tb_fotos on (tb_fotos.id_usuario = usuario.id)
            where tweets.id_grupo = 0 and tweets.id_usuario = :id_usuario or
            not (select count(*) from tb_relacao where (SELECT count(*) from tb_relacao where id_professor = :id_usuario and id_aluno = tweets.id_usuario and estado = 1))= 0
            and tweets.id_grupo = 0  order by tweets.data desc
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->bindValue(':limite',$this->__get('limite'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }



        public function getAllPublico(){
            $query = " SELECT tweets.id, tweets.id_tipo, tweets.id_usuario, tweets.titulo,tweets.pdf, tweets.pdf_original, tweets.pdf_descricao, tweets.tweet,tweets.imagem_carregada, tweets.data, usuario.nome, tb_fotos.nome_foto, 
            (select count(id_like) from tb_like where id_usuario = :id_usuario and id_tweet = tweets.id) as estado_like
             from tweets inner join usuario on (usuario.id = tweets.id_usuario)
            
            inner join tb_fotos on (tb_fotos.id_usuario = usuario.id) where id_tipo = 2  and tweets.id_grupo = 0
                        order by data desc;";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getAllPublicominhas(){
            $query = " SELECT tweets.id, tweets.id_tipo, tweets.id_usuario, tweets.titulo,tweets.pdf, tweets.pdf_original, tweets.pdf_descricao, tweets.tweet,tweets.imagem_carregada, tweets.data, usuario.nome, tb_fotos.nome_foto, 
            (select count(id_like) from tb_like where id_usuario = :id_usuario and id_tweet = tweets.id) as estado_like
             from tweets inner join usuario on (usuario.id = tweets.id_usuario)
            
            inner join tb_fotos on (tb_fotos.id_usuario = usuario.id) where id_tipo = 2  and tweets.id_grupo = 0 and tweets.id_usuario = :id_usuario
                        order by data desc;";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function carregar_foto(){
            $query = 'select * from tb_fotos where id_usuario = :id_usuario';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function lista_professor(){
            $query = "select usuario.nome, tb_fotos.nome_foto, tb_perfil_professor.cidade, tb_perfil_professor.municipio, tb_perfil_professor.curso  from usuario inner join tb_perfil_professor on (tb_perfil_professor.id_usuario = usuario.id) inner join tb_fotos on (tb_fotos.id_usuario = usuario.id);";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function carregar_professor(){
            $query = 'select  count(id_perfil_professor) from tb_perfil_professor';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function carregar_aluno(){
            $query = 'select  count(id_perfil_aluno) from tb_perfil_aluno';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function carregar_publicacao(){
            $query = 'select  count(id) from tweets';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function carregar_respostas(){
            $query = 'select  count(id_resposta) from tb_resposta';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function get_num_like(){
            $query = 'select count(id_tweet) from tb_like where id_tweet = :id_tweet';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_tweet',$this->__get('id_tweet'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_num_arquivado(){
            $query = 'select count(id_tweet) from tb_favorito where id_tweet = :id_tweet';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_tweet',$this->__get('id_tweet'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getquant_novo(){
            $query = 'SELECT count(id_relacao) as quantidade from tb_relacao where id_professor = :id_usuario && estado = 0 && visualizacao = 0';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        //============ DUVIDA =========================================================
        public function getquant_duvida_novo(){
            $query = 'SELECT count(id_duvida) as quantidade from tb_duvida where id_professor = :id_usuario and visualizacao = 0';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        //=========== TAREFA ==========================================================
        public function getquant_tarefa_novo(){
            $query = 'SELECT count(id_resposta) as quantidade from tb_resposta where id_dono_pergunta = :id_usuario and visualizacao = 0';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
         //=========== NOTIFICAÇÃO ==========================================================
         public function getquant_notificacao_novo(){
            $query = 'SELECT count(id_notificacao) as quantidade from tb_notificacao where id_destino = :id_usuario and visualizacao = 0';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function getquant_duvida_respondida_novo(){
            $query = 'SELECT count(id_duvida_respondida) as quantidade from tb_duvida_respondida where id_aluno = :id_usuario and visualizacao = 0';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function getquant_mensagem(){
            $query = 'select count(Id) as quantidade from chat where Reciever = :id_usuario and lido = :n';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->bindValue(':n','n');
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function Zipar($arquivo,$nomeZip,$caminho){
            $zip = new ZipArchive();
            if($zip->open("./ficheiro_pdf/".$nomeZip, ZIPARCHIVE::CREATE) != TRUE){
                return false;
            }
            $zip->addFile($caminho.$arquivo, $arquivo);
            $zip->close();
            return true;
        }

}


?>