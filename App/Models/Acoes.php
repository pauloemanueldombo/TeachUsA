<?php
namespace App\Models;

use MF\Model\Model;
use PDO;
use ZipArchive;

class Acoes extends Model {
        private $imagem_carregada;
        private $pdf;
        private $pdf_original;
        private $pdf_descricao;
        private $numero_Like;
        private $id_dono_pergunta;
        private $id_responde;
        private $id_pergunta;
        private $data_resposta;
        private $resposta;
        private $id_usuario;
        private $novo_texto;
        private $nome_responde;
        private $nome_foto;
        private $id_dono;
        //=================================
        private $titulo;
        private $tweet;
        private $id_tweet;
        private $data;
        private $nome;
        private $nome_foto_perfil;
        private $id_relacao;
        private $id_duvida;
        //================================

        private $id_aluno;
        private $id_professor;
        private $duvida;
        private $id_destino;
        private $origem;
        private $avaliacao;
        private $id_avaliacao;
        private $tipo_perfil;
        private $id_publicacao;
        private $id_postagem;
        private $id_pessoa;

        private $nome_turma;
        private $id_adm;
        private $descricao_turma;
        private $id_turma;
        private $novo_nome;
        private $nova_senha;
        private $nova_foto;
        

        
    
        

        public function __get($atributo)
            {
                return $this->$atributo;
            }
        public function __set($atributo, $valor)
        {
            $this->$atributo = $valor;
        }

        public function responder(){
            $query = "INSERT into tb_resposta(id_pergunta,id_dono_pergunta,id_responde,resposta,imagem_carregada,pdf,pdf_original,pdf_descricao) values(:id_pergunta,:id_dono_pergunta,:id_responde,:resposta,:imagem_carregada,:pdf,:pdf_original,:pdf_descricao)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_pergunta',$this->__get('id_pergunta'));
            $stmt->bindValue(':id_dono_pergunta',$this->__get('id_dono_pergunta'));
            $stmt->bindValue(':id_responde',$this->__get('id_responde'));
            $stmt->bindValue(':resposta',$this->__get('resposta'));

            $stmt->bindValue(':imagem_carregada',$this->__get('imagem_carregada'));
            $stmt->bindValue(':pdf',$this->__get('pdf'));
            $stmt->bindValue(':pdf_original',$this->__get('pdf_original'));
            $stmt->bindValue(':pdf_descricao',$this->__get('pdf_descricao'));
            return $stmt->execute();
        }
        public function donopostagem(){
            $query = "  SELECT tweets.id, tweets.id_tipo, tweets.id_usuario, tweets.titulo, tweets.tweet, tweets.data, tweets.imagem_carregada, usuario.nome, tb_fotos.nome_foto from tweets inner join usuario on (usuario.id = tweets.id_usuario) 
            inner join tb_fotos on (tb_fotos.id_usuario = usuario.id) where id_tipo = 2 and tweets.id_usuario = :id_dono_pergunta and tweets.id = :id_pergunta
                        order by data desc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_dono_pergunta',$this->__get('id_dono_pergunta'));
            $stmt->bindValue(':id_pergunta',$this->__get('id_pergunta'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function delete_publicacao(){
            $query = "delete from tweets where id = :id_pergunta";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_pergunta', $this->__get('id_pergunta'));
            $stmt->execute();
            return $this;
        }
        public function salvar_publicacao(){
            $query = "INSERT into tb_favorito(id_usuario,id_tweet,id_dono,nome,tweet,titulo,data,nome_foto) value(:id_usuario,:id_tweet,:id_dono,:nome,:tweet,:titulo,:data,:nome_foto_perfil)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':id_dono', $this->__get('id_dono'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':tweet', $this->__get('tweet'));
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->bindValue(':data', $this->__get('data'));
            $stmt->bindValue(':id_tweet', $this->__get('id_tweet'));
            $stmt->bindValue(':nome_foto_perfil', $this->__get('nome_foto_perfil'));
            $stmt->execute();
            return $this;
        }
        public function like_publicacao(){
            $query = "INSERT into tb_like(id_usuario,id_tweet) value(:id_usuario,:id_pergunta)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':id_pergunta', $this->__get('id_pergunta'));
            $stmt->execute();
            return $this;
        }

        public function editar_postagem(){
            $query = "update tweets set tweet = :texto_novo   where id = :id_pergunta";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':texto_novo', $this->__get('novo_texto'));
            $stmt->bindValue(':id_pergunta', $this->__get('id_pergunta'));
            $stmt->execute();
            return $this;
        }
        public function getresposta(){
            $query = "SELECT * from tb_resposta_publica where id_pergunta = :id_pergunta";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_pergunta',$this->__get('id_pergunta'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_numero_resposta(){
            $query = "SELECT count(id_resposta) from tb_resposta_publica where id_pergunta = :id_pergunta";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_pergunta',$this->__get('id_pergunta'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function comentador(){
            $query = "SELECT * from tb_resposta_publica where id_pergunta = :id_pergunta order by id_responde;";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_pergunta',$this->__get('id_pergunta'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function responder_publica(){
            $query = "INSERT into tb_resposta_publica(id_pergunta,nome,nome_foto,resposta,id_responde) value(:id_pergunta,:nome_responde,:nome_foto,:resposta,:id_responde)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_pergunta',$this->__get('id_pergunta'));
            $stmt->bindValue(':id_responde',$this->__get('id_responde'));
            $stmt->bindValue(':nome_responde',$this->__get('nome_responde'));
            $stmt->bindValue(':nome_foto',$this->__get('nome_foto'));
            $stmt->bindValue(':resposta',$this->__get('resposta'));
            $stmt->execute();
            
        }
        public function listar_postagem(){
            $query = "SELECT tweets.id, tweets.id_tipo, tweets.id_usuario, tweets.titulo, tweets.tweet, tweets.data,tweets.pdf, tweets.pdf_original, tweets.pdf_descricao, usuario.nome, tb_fotos.nome_foto, tweets.imagem_carregada,
            (select count(id_like) from tb_like where id_usuario = :id_usuario and id_tweet = tweets.id) as estado_like,
            (select fc_calcular_avaliacao(usuario.id)) as avaliacao 
            from tweets inner join usuario on (usuario.id = tweets.id_usuario) 
            inner join tb_fotos on (tb_fotos.id_usuario = usuario.id) where  tweets.id_usuario = :id_usuario
            and tweets.id_grupo = 0           order by data desc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_dados_pessoal(){
            $query = " SELECT *, (select fc_calcular_avaliacao(usuario.id)) as avaliacao from usuario inner join tb_perfil_professor on (tb_perfil_professor.id_usuario = usuario.id) where usuario.id = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_dados_pessoal_aluno(){
            $query = " SELECT * from usuario inner join tb_perfil_aluno on (tb_perfil_aluno.id_usuario = usuario.id) where usuario.id = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_disciplina_lecionar(){
            $query = "SELECT disciplina from tb_professor_disciplina right join tb_disciplina on (tb_disciplina.id_disciplina = tb_professor_disciplina.id_disciplina) where id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_lugares_lecionar(){
            $query = "SELECT tb_municipio.municipio, tb_provincia.provincia from tb_professor_lugar right join tb_municipio on (tb_municipio.id_municipio = tb_professor_lugar.id_municipio) right join tb_provincia on (tb_provincia.id_provincia = tb_municipio.id_provincia) where id_usuario = :id_usuario;";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function arquivadas(){
            $query = "SELECT * from tb_favorito where id_usuario = :id_usuario order by data desc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_dados(){
            $query = "SELECT tweets.id, tweets.id_usuario, tweets.titulo, tweets.tweet, tweets.data, tweets.pdf, tweets.pdf_original, tweets.pdf_descricao, usuario.nome, tb_fotos.nome_foto, tweets.imagem_carregada from tweets inner join usuario on (usuario.id = tweets.id_usuario) 
            inner join tb_fotos on (tb_fotos.id_usuario = usuario.id) where tweets.id = :id_usuario
                        order by data desc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_pergunta'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function lista_professores(){
            $query = " SELECT usuario.id, usuario.nome, tb_perfil_professor.cidade,tb_perfil_professor.municipio,tb_perfil_professor.bairro,tb_perfil_professor.curso, tb_fotos.nome_foto,
            (select fc_calcular_avaliacao(usuario.id)) as avaliacao
            from
            usuario inner join tb_perfil_professor on (tb_perfil_professor.id_usuario = usuario.id) inner join tb_fotos on (tb_fotos.id_usuario = usuario.id)
            
            where (SELECT count(*) from tb_relacao where id_professor = usuario.id and estado = 1 and id_aluno = :id_aluno) = 0 and
            (SELECT count(*) from tb_relacao where id_aluno = :id_aluno and id_professor = usuario.id and estado = 0) = 0;
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno', $this->__get('id_aluno'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        


        public function getAll(){
            $query = "SELECT usuario.id, usuario.nome, tb_perfil_professor.cidade,tb_perfil_professor.municipio,tb_perfil_professor.bairro,tb_perfil_professor.curso, tb_fotos.nome_foto,
            (select fc_calcular_avaliacao(usuario.id)) as avaliacao
            from
            usuario inner join tb_perfil_professor on (tb_perfil_professor.id_usuario = usuario.id) inner join tb_fotos on (tb_fotos.id_usuario = usuario.id)
            
             where usuario.nome like :nome || tb_perfil_professor.municipio like :nome  and 
            (SELECT count(*) from tb_relacao where id_aluno = :id_aluno and id_professor = usuario.id and estado = 1) = 0 and
            (SELECT count(*) from tb_relacao where id_professor = usuario.id and estado = 0 and id_aluno = :id_aluno) = 0
            
            
            ";
            
             $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome','%'.$this->__get('nome').'%');
            $stmt->bindValue(':id_aluno',$this->__get('id'));
            $stmt->execute();
            $lista_nome = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return $lista_nome;
        }
        public function enviar_pedido(){
            $query = "INSERT into tb_relacao(id_aluno,id_professor) value(:id_aluno,:id_professor)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno', $this->__get('id_aluno'));
            $stmt->bindValue(':id_professor', $this->__get('id_professor'));
            $stmt->execute();
            return $this;
        }

        public function pedidos_enviados(){
            $query = " SELECT usuario.id, usuario.nome, tb_perfil_aluno.cidade, tb_perfil_aluno.municipio, tb_perfil_aluno.bairro, tb_perfil_aluno.curso, tb_fotos.nome_foto,tb_relacao.id_relacao,tb_relacao.id_aluno,
            (SELECT count(*) from tb_relacao where usuario.id = id_aluno and id_professor = :id_professor) as estado
            from usuario
            inner join tb_perfil_aluno on (tb_perfil_aluno.id_usuario = usuario.id) inner join  tb_fotos on (tb_fotos.id_usuario = usuario.id) 
            left join tb_relacao on (tb_relacao.id_aluno = usuario.id)
            where (SELECT count(*) from tb_relacao where usuario.id = id_aluno and id_professor = :id_professor) = 1
            and tb_relacao.id_professor = :id_professor AND tb_relacao.estado = 0
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor', $this->__get('id_professor'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function cancelar(){
            $query = "DELETE from tb_relacao where id_relacao = :id_relacao";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_relacao', $this->__get('id_relacao'));
            $stmt->execute();
            return $this;
        }
        public function aceitar(){
            $query = "UPDATE tb_relacao SET estado = 1 WHERE (id_relacao = :id_relacao )";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_relacao', $this->__get('id_relacao'));
            $stmt->execute();
            return $this;
        }
        public function listar_aluno(){
            $query = " SELECT usuario.id, usuario.nome, tb_perfil_aluno.cidade, tb_perfil_aluno.municipio, tb_perfil_aluno.bairro, tb_perfil_aluno.curso, tb_fotos.nome_foto,tb_relacao.id_relacao,tb_relacao.id_aluno,
            (SELECT count(*) from tb_relacao where usuario.id = id_aluno and id_professor = :id_professor) as estado
            from usuario
            inner join tb_perfil_aluno on (tb_perfil_aluno.id_usuario = usuario.id) inner join  tb_fotos on (tb_fotos.id_usuario = usuario.id) 
            left join tb_relacao on (tb_relacao.id_aluno = usuario.id)
            where (SELECT count(*) from tb_relacao where usuario.id = id_aluno and id_professor = :id_professor) = 1
            and tb_relacao.id_professor = :id_professor AND tb_relacao.estado = 1
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor', $this->__get('id_professor'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function listar_prof(){
            $query = "SELECT usuario.id, usuario.nome, tb_perfil_professor.cidade, tb_perfil_professor.municipio, tb_perfil_professor.bairro, tb_perfil_professor.curso, tb_fotos.nome_foto,tb_relacao.id_relacao,tb_relacao.id_aluno,
            (SELECT count(*) from tb_relacao where id_aluno = :id_aluno and id_professor = usuario.id) as estado
            from usuario
            inner join tb_perfil_professor on (tb_perfil_professor.id_usuario = usuario.id) inner join  tb_fotos on (tb_fotos.id_usuario = usuario.id) 
            left join tb_relacao on (tb_relacao.id_professor = usuario.id)
            where (SELECT count(*) from tb_relacao where id_aluno = :id_aluno and id_professor = usuario.id) = 1
            and tb_relacao.id_aluno = :id_aluno AND tb_relacao.estado = 1
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno', $this->__get('id_aluno'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function listar_respostas(){
            $query = "SELECT tb_resposta.id_dono_pergunta,tb_resposta.imagem_carregada,tb_resposta.pdf,tb_resposta.pdf_original,tb_resposta.pdf_descricao,tb_resposta.id_responde, tb_resposta.data_resposta, tb_resposta.resposta, tweets.tweet,usuario.nome,usuario.id, tweets.titulo, tb_fotos.nome_foto 
            from tb_resposta
            inner join tweets on (tweets.id = tb_resposta.id_pergunta)
            inner join usuario on (usuario.id = tb_resposta.id_responde)
            inner join tb_fotos on(tb_fotos.id_usuario = usuario.id) where id_dono_pergunta = :id_professor order by data desc
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor', $this->__get('id_professor'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function enviar_duvida(){
            $query = "insert into tb_duvida(titulo,duvida,id_professor,id_aluno) values(:titulo,:duvida,:id_professor,:id_aluno)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':titulo',$this->__get('titulo'));
            $stmt->bindValue(':duvida',$this->__get('duvida'));
            $stmt->bindValue(':id_professor',$this->__get('id_professor'));
            $stmt->bindValue(':id_aluno',$this->__get('id_aluno'));
            $stmt->execute();
            return $this;
        }
        public function getduvidas(){
            $query = "SELECT tb_duvida.id_duvida, tb_duvida.titulo, tb_duvida.duvida,tb_duvida.id_professor,tb_duvida.data, usuario.nome, tb_fotos.nome_foto
            from tb_duvida
            inner join usuario on (usuario.id = tb_duvida.id_professor)
            inner join tb_fotos on (tb_fotos.id_usuario = tb_duvida.id_professor) where tb_duvida.id_aluno = :id_aluno order by tb_duvida.data desc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno',$this->__get('id_aluno'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function delete_duvida(){
            $query = "delete from tb_duvida where id_duvida = :id_duvida";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_duvida',$this->__get('id_duvida'));
            $stmt->execute();
            return $this;
        }
        public function getduvidas_enviadas(){
            $query = "SELECT tb_duvida.id_duvida, tb_duvida.titulo, tb_duvida.duvida,tb_duvida.id_aluno,tb_duvida.data, usuario.nome, tb_fotos.nome_foto
            from tb_duvida
            inner join usuario on (usuario.id = tb_duvida.id_aluno)
            inner join tb_fotos on (tb_fotos.id_usuario = tb_duvida.id_aluno) where tb_duvida.id_professor = :id_professor order by tb_duvida.data desc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor',$this->__get('id_professor'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function enviar_resposta(){
            $query = "INSERT into tb_duvida_respondida(id_duvida,id_aluno,id_professor,resposta) values(:id_duvida,:id_aluno,:id_professor,:resposta)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_duvida',$this->__get('id_duvida'));
            $stmt->bindValue(':id_professor',$this->__get('id_professor'));
            $stmt->bindValue(':id_aluno',$this->__get('id_aluno'));
            $stmt->bindValue(':resposta',$this->__get('resposta'));

            $stmt->execute();
            return $this;
        }
        public function listar_duvidas_respondidas(){
            $query = "SELECT tb_duvida.id_duvida, tb_duvida.titulo, tb_duvida.duvida,tb_duvida.id_professor,tb_duvida.data, usuario.nome, tb_fotos.nome_foto,tb_duvida_respondida.resposta,tb_duvida_respondida.id_duvida_respondida
            from tb_duvida_respondida
            inner join tb_duvida on (tb_duvida.id_duvida = tb_duvida_respondida.id_duvida)
            inner join usuario on (usuario.id = tb_duvida_respondida.id_aluno)
            inner join tb_fotos on (tb_fotos.id_usuario = tb_duvida_respondida.id_aluno) where tb_duvida_respondida.id_professor = :id_professor order by tb_duvida_respondida.data_resposta desc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor',$this->__get('id_professor'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function visualizar(){
            $query = "UPDATE tb_relacao set visualizacao = 1   where id_professor = :id_professor";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor', $this->__get('id_professor'));
            $stmt->execute();
            return $this;
        }
        public function visualizar_duvida(){
            $query = "UPDATE tb_duvida set visualizacao = 1   where id_professor = :id_professor";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor', $this->__get('id_professor'));
            $stmt->execute();
            return $this;
        }
        public function visualizar_respostas(){
            $query = "UPDATE tb_resposta set visualizacao = 1   where id_dono_pergunta = :id_professor";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor', $this->__get('id_professor'));
            $stmt->execute();
            return $this;
        }
        public function visualizar_mensagem(){
            $query = "UPDATE chat set lido = 'y'   where Reciever = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $this;
        }
       
        public function listar_notificacao(){
            $query = "SELECT usuario.id, usuario.nome, tb_notificacao.notificacao, tb_notificacao.data_notificacao,tb_notificacao.tipo_perfil, tb_fotos.nome_foto
            from tb_notificacao
            left join usuario on (usuario.id = tb_notificacao.id_envia) 
            inner join tb_fotos on (usuario.id = tb_fotos.id_usuario) 
            where tb_notificacao.id_destino = :id_usuario
            order by tb_notificacao.data_notificacao desc;";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function visualizar_notificacao(){
            $query = "UPDATE tb_notificacao set visualizacao = 1   where id_destino = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $this;
        }
        public function listar_duvidas_respondidas_aluno(){
            $query = "SELECT tb_duvida.id_duvida, tb_duvida.titulo, tb_duvida.duvida,tb_duvida.id_aluno,tb_duvida.data,usuario.id, usuario.nome, tb_fotos.nome_foto,tb_duvida_respondida.resposta,tb_duvida_respondida.id_duvida_respondida,tb_duvida_respondida.avaliacao
            from tb_duvida_respondida
            inner join tb_duvida on (tb_duvida.id_duvida = tb_duvida_respondida.id_duvida)
            inner join usuario on (usuario.id = tb_duvida_respondida.id_professor)
            inner join tb_fotos on (tb_fotos.id_usuario = tb_duvida_respondida.id_professor) where tb_duvida_respondida.id_aluno = :id_aluno order by tb_duvida_respondida.data_resposta desc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno',$this->__get('id_aluno'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function enviar_notificacao(){
            $query;
            if($this->__get('origem') == '1'){
                $query = "INSERT INTO tb_notificacao(id_destino,id_envia,notificacao,tipo_perfil) values(:id_destino,:id_envia,'Gostou da tua matéria',:tipo_perfil)";
            }
            if($this->__get('origem') == '2'){
                $query = "INSERT INTO tb_notificacao(id_destino,id_envia,notificacao,tipo_perfil) values(:id_destino,:id_envia,'Gostou da tua Resposta',:tipo_perfil)";
            }
            if($this->__get('origem') == '3'){
                $query = "INSERT INTO tb_notificacao(id_destino,id_envia,notificacao,tipo_perfil) values(:id_destino,:id_envia,'Aceitou o teu pedido de aula',:tipo_perfil)";
            }
            if($this->__get('origem') == '4'){
                $query = "INSERT INTO tb_notificacao(id_destino,id_envia,notificacao,tipo_perfil) values(:id_destino,:id_envia,'Adicionou-te na sua turma',:tipo_perfil)";
            }
            if($this->__get('origem') == '5'){
                $query = "INSERT INTO tb_notificacao(id_destino,id_envia,notificacao,tipo_perfil) values(:id_destino,:id_envia,:nome_turma,:tipo_perfil)";
            }
            if($this->__get('origem') == '6'){
                $query = "INSERT INTO tb_notificacao(id_destino,id_envia,notificacao,tipo_perfil) values(:id_destino,:id_envia,:publico,:tipo_perfil)";
            }
            if($this->__get('origem') == '7'){
                $query = "INSERT INTO tb_notificacao(id_destino,id_envia,notificacao,tipo_perfil) values(:id_destino,:id_envia,:mensagem_turma,:tipo_perfil)";
            }
            if($this->__get('origem') == '8'){
                $query = "INSERT INTO tb_notificacao(id_destino,id_envia,notificacao,tipo_perfil) values(:id_destino,:id_envia,:mensagem,:tipo_perfil)";
            }
           
            if($this->__get('origem') == '9'){
                $query = "INSERT INTO tb_notificacao(id_destino,id_envia,notificacao,tipo_perfil) values(:id_destino,:id_envia,:nome_turma,:tipo_perfil)";
            }
           
            $stmt = $this->db->prepare($query);
            
            $stmt->bindValue(':id_destino',$this->__get('id_destino'));
         

            if($this->__get('origem') == '7'){
                $stmt->bindValue(':mensagem_turma','<a class = "text-info" href="/entrar_turma?id_turma='.$this->__get('id_turma').'">Publicou em uma turma em que na qual és membro</a>');
            }
            $stmt->bindValue(':id_envia',$this->__get('id_usuario'));
            $stmt->bindValue(':tipo_perfil',$this->__get('tipo_perfil'));

            if($this->__get('origem') == '9'){
                $comen = "Também comentou a tua publicação feita na turma ";
                $stmt->bindValue(':nome_turma','<a class = "text-info" href="/comentarios?id='.$this->__get('id_postagem').'">'.$comen.' <b>'.$this->__get('nome_turma').'</b></a>');
            }

            if($this->__get('origem') == '8'){
                $stmt->bindValue(':mensagem','<a class = "text-info" href="/comentarios?id='.$this->__get('id_postagem').'"><b>Também comentou numa publicação</b></a>');
            }

            if($this->__get('origem') == '6'){
                $stmt->bindValue(':publico','<a class = "text-info" href="/comentarios?id='.$this->__get('id_postagem').'">Comentou a tua publicação </a>');
            }
            
            
            if($this->__get('origem') == '5'){
                $comen = "Comentou a tua publicação";
                $stmt->bindValue(':nome_turma','<a class = "text-info" href="/comentarios?id='.$this->__get('id_postagem').'">'.$comen.' <b>'.$this->__get('nome_turma').'</b></a>');
            }
            
            $stmt->execute();
            return $this;
        }
        public function delete_duvida_respondida(){
            $query = "delete from tb_duvida_respondida where id_duvida_respondida = :id_duvida";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_duvida',$this->__get('id_duvida'));
            $stmt->execute();
            return $this;
        }
        public function visualizar_resposta(){
            $query = "UPDATE tb_duvida_respondida set visualizacao = 1   where id_aluno = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_aluno'));
            $stmt->execute();
            return $this;
        }
        public function numero_like(){
            $query = 'select count(*) as likes from tb_like where id_tweet = :id_pergunta';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_pergunta',$this->__get('id_pergunta'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ)->likes;
        }
        public function numero_salvo(){
            $query = 'select count(*) as salvo from tb_favorito where id_tweet = :id_pergunta';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_pergunta',$this->__get('id_pergunta'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ)->salvo;
        }
        public function avaliar(){
            $query = "INSERT into tb_avaliacao(id_usuario,avaliacao) value(:id_usuario,:avaliacao)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':avaliacao', $this->__get('avaliacao'));
            $stmt->execute();
            return $this;
        }
        public function mudar_avaliacao(){
            $query = "UPDATE tb_duvida_respondida set avaliacao = :id_avaliacao   where id_duvida_respondida = :id_resposta";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_avaliacao', $this->__get('id_avaliacao'));
            $stmt->bindValue(':id_resposta', $this->__get('id_duvida'));
            $stmt->execute();
            return $this;
        }
        public function selecionar_id_avaliacao(){
            $query = 'SELECT id_avaliacao from tb_avaliacao order by data_avaliacao desc';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_avaliacao(){
           $query = "select fc_calcular_avaliacao(:id_usuario) as avaliacao";
           $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ)->avaliacao;
        }
        public function get_foto(){
            $query = "SELECT nome_foto from tb_fotos WHERE id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
             $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
             $stmt->execute();
             return $stmt->fetch(PDO::FETCH_OBJ)->nome_foto;
         }

         public function remover_like(){
             $query = "DELETE from tb_like where id_usuario = :id_usuario and id_tweet = :id_publicacao";
             $stmt = $this->db->prepare($query);
             $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
             $stmt->bindValue(':id_publicacao',$this->__get('id_publicacao'));
             $stmt->execute();
             return $this;
         }
         public function criar_turma(){
            $query = "INSERT into tb_turma(id_adm,nome_turma,descricao_turma) value(:id_adm,:nome_turma,:descricao_turma)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_adm',$this->__get('id_adm'));
            $stmt->bindValue(':nome_turma',$this->__get('nome_turma'));
            $stmt->bindValue(':descricao_turma',$this->__get('descricao_turma'));
            $stmt->execute();
            return $this;
        }
        public function get_turma(){
            $query = "SELECT * from tb_turma where id_adm = :id_adm";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_adm',$this->__get('id_adm'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_dados_turma(){
            $query = "SELECT * from tb_turma where id_turma = :id_turma";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_turma',$this->__get('id_turma'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_aluno(){
            $query = " SELECT usuario.id, usuario.nome, tb_perfil_aluno.cidade, tb_perfil_aluno.municipio, tb_perfil_aluno.bairro, tb_perfil_aluno.curso, tb_fotos.nome_foto,tb_relacao.id_relacao,tb_relacao.id_aluno,
            (SELECT count(*) from tb_relacao where usuario.id = id_aluno and id_professor = :id_professor) as estado
            from usuario
            inner join tb_perfil_aluno on (tb_perfil_aluno.id_usuario = usuario.id) inner join  tb_fotos on (tb_fotos.id_usuario = usuario.id) 
            left join tb_relacao on (tb_relacao.id_aluno = usuario.id)
            where (SELECT count(*) from tb_relacao where usuario.id = id_aluno and id_professor = :id_professor) = 1
            and tb_relacao.id_professor = :id_professor AND tb_relacao.estado = 1 and
            (select count(*) from tb_aluno_turma where id_aluno = usuario.id and id_turma = :id_turma) = 0
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_professor', $this->__get('id_adm'));
            $stmt->bindValue(':id_turma', $this->__get('id_turma'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_membro_turma(){
            $query = "SELECT usuario.id, usuario.nome, tb_perfil_aluno.cidade, tb_perfil_aluno.municipio, tb_perfil_aluno.bairro, tb_perfil_aluno.curso, tb_fotos.nome_foto
            
            from usuario
            inner join tb_perfil_aluno on (tb_perfil_aluno.id_usuario = usuario.id) inner join  tb_fotos on (tb_fotos.id_usuario = usuario.id) 
            
            where 
            (select count(*) from tb_aluno_turma where id_aluno = usuario.id and id_turma = :id_turma) = 1;
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_turma', $this->__get('id_turma'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function publicar_turma(){
            $query = "INSERT into tweets(id_tipo,id_usuario,titulo,tweet,id_grupo,imagem_carregada,pdf,pdf_original,pdf_descricao) values(:id_tipo,:id_usuario,:titulo,:tweet,:id_grupo,:imagem_carregada,:pdf,:pdf_original,:pdf_descricao)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_tipo',-1);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->bindValue(':titulo',$this->__get('titulo'));
            $stmt->bindValue(':tweet',$this->__get('tweet'));
            $stmt->bindValue(':id_grupo',$this->__get('id_turma'));
            $stmt->bindValue(':imagem_carregada',$this->__get('imagem_carregada'));
            $stmt->bindValue(':pdf',$this->__get('pdf'));
            $stmt->bindValue(':pdf_original',$this->__get('pdf_original'));
            $stmt->bindValue(':pdf_descricao',$this->__get('pdf_descricao'));
            $stmt->execute();
            return $this;
        }
        public function get_postagem(){
            $query = "SELECT tweets.id, tweets.id_tipo, tweets.id_usuario, tweets.titulo, tweets.tweet, tweets.data, tweets.pdf, tweets.pdf_original, tweets.pdf_descricao, tweets.imagem_carregada, usuario.nome, tb_fotos.nome_foto, 
            (select count(id_like) from tb_like where id_usuario = :id_usuario and id_tweet = tweets.id) as estado_like,
            (select fc_calcular_avaliacao(usuario.id)) as avaliacao 
            from tweets inner join usuario on (usuario.id = tweets.id_usuario) 
            inner join tb_fotos on (tb_fotos.id_usuario = usuario.id) where tweets.id_grupo = :id_turma
                        order by data desc";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_turma', $this->__get('id_turma'));
            $stmt->bindValue(':id_usuario', $this->__get('id_adm'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function add_turma(){
            $query = "INSERT into tb_aluno_turma (id_aluno,id_turma) values(:id_aluno,:id_turma)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno', $this->__get('id_aluno'));
            $stmt->bindValue(':id_turma', $this->__get('id_turma'));
            $stmt->execute();
            return $this;
        }

        public function get_turma_aluno(){
            $query = "select tb_turma.id_turma, tb_turma.nome_turma, tb_turma.descricao_turma,tb_turma.foto_turma
            from tb_turma 
            where (select count(id_aluno_turma) from tb_aluno_turma where id_aluno = :id_aluno and id_turma = tb_turma.id_turma) = 1;";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno',$this->__get('id_aluno'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        public function get_disciplina(){
            $query = "SELECT * from tb_disciplina ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_provincia(){
            $query = "SELECT * from tb_provincia ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function dados_publicacao(){
            $query = "select 
            tweets.id,
            tweets.id_usuario,
            tweets.titulo,
            tweets.id,
            tweets.id_usuario,
            tweets.tweet,
            tweets.data,
            tweets.imagem_carregada,
            tweets.pdf,
            tweets.pdf_original,
            tweets.pdf_descricao,
            usuario.nome,
            tb_fotos.nome_foto
            
            from tweets inner join usuario on (tweets.id_usuario = usuario.id) inner join tb_fotos on (usuario.id = tb_fotos.id_usuario) where tweets.id = :id_pergunta;";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_pergunta',$this->__get('id_pergunta'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function trocar_nome(){
            $query = "UPDATE usuario set nome = :novo_nome where id = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':novo_nome', $this->__get('novo_nome'));
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            return $stmt->execute();
        }

        public function trocar_senha(){
            $query = "UPDATE usuario set senha = :nova_senha where id = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nova_senha', $this->__get('nova_senha'));
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            return $stmt->execute();
        }
        public function trocar_foto_perfil(){
            $query = "UPDATE tb_fotos set nome_foto = :nova_foto where id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nova_foto', $this->__get('nova_foto'));
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $this;
        }

        public function remover_turma(){
            $query = "DELETE from tb_aluno_turma where id_aluno = :id_aluno and id_turma = :id_turma";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno',$this->__get('id_aluno'));
            $stmt->bindValue(':id_turma',$this->__get('id_turma'));
            $stmt->execute();
            return $this;
        }
        // $this->apagar_usuario();
        //    $this->apagar_foto();
        //    $this->apagar_tweet();
        //    $this->apagar_chat();
        //    $this->apagar_conversa();
        //    $this->apagar_avaliacao();
        //    $this->apagar_duvida();
        //    $this->apagar_duvida_respondida();
        //    $this->apagar_favorito();
        //    $this->apagar_like();
        //    $this->apagar_notificacao();
        //    $this->apagar_perfil_aluno();
        //    $this->apagar_perfil_professor();
        //    $this->apagar_relacao();
        //    $this->apagar_resposta();
        //    $this->apagar_resposta_publica();
        //    $this->apagar_();
        public function apagar_conta(){
            $query = "DELETE from usuario where id = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->execute();
            return $this;
        }
        public function apagar_conexaos(){
            $query = "DELETE from tb_relacao where id_aluno = :id_usuario and id_professor = :id_pessoa or  id_aluno = :id_pessoa and id_professor = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->bindValue(':id_pessoa',$this->__get('id_pessoa'));
            $stmt->execute();
            return $this;
        }

        public function get_dados_pessoa(){
            $query = "SELECT * from usuario inner join tb_fotos on (usuario.id = tb_fotos.id_usuario) where usuario.id = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }



}


?>