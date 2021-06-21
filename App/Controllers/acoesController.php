<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
session_start();

class AcoesController extends Action {

        public function responder_pergunta(){
            $responder = Container::getModel('Acoes');
            $responder->__set('id_dono_pergunta',$_POST['id_usuario']);
            $responder->__set('id_responde',$_SESSION['id']);
            $responder->__set('resposta',$_POST['resposta']);
            $responder->__set('id_pergunta',$_POST['id']);
            $responder->__set('imagem_carregada',$_POST['imagem_carregada']);
            $responder->__set('pdf',$_POST['pdf']);
            $responder->__set('pdf_descricao',$_POST['pdf_descricao']);
            $responder->__set('pdf_original',$_POST['pdf_original']);
            $estado = $responder->responder();
        }

        public function responder_pergunta_publica(){
            $responder = Container::getModel('Acoes');
            $responder->__set('id_pergunta',$_POST['id_postagem']);
            $responder->__set('nome_responde',$_SESSION['nome']);
            $responder->__set('id_responde',$_SESSION['id']);
            $responder->__set('tipo_perfil',$_SESSION['perfil']);
            $responder->__set('nome_foto',$_SESSION['foto_perfil']);
            $responder->__set('resposta',$_POST['resposta']);
            $responder->responder_publica();
            
            $comentador = $responder->comentador();

            if(isset($_POST['nome_turma']) && $_POST['nome_turma'] != 'publico'){
                $responder->__set('tipo_perfil',$_SESSION['perfil']);
                $responder->__set('id_destino',$_POST['id_usuario']);
                $responder->__set('id_pergunta',$_POST['id_postagem']);
                $responder->__set('id_usuario',$_SESSION['id']);
                $responder->__set('nome_turma',$_POST['nome_turma']);
                $responder->__set('id_postagem',$_POST['id_postagem']);
                
                if(true){
                    $responder->__set('origem','5');
                    if($_POST['id_usuario'] != $_SESSION['id']){
                        $responder->enviar_notificacao();
                    }
                }
                else{
                    $responder->__set('origem','9');
                    foreach ($comentador as $key => $valor)
                    {
                        $novo = $valor['id_responde'];
                        if($ax != $novo)
                        {
                            if($valor['id_responde'] != $_SESSION['id'])
                            {
                                $responder->__set('id_destino',$valor['id_responde']);
                                $responder->enviar_notificacao();
                            }
                            $ax = $valor['id_responde'];
                        }
                        
                    }
                }
                
                
            }else
            if(isset($_POST['nome_turma']) && $_POST['nome_turma'] == 'publico')
            {
                $responder->__set('tipo_perfil',$_SESSION['perfil']);
                $responder->__set('id_destino',$_POST['id_usuario']);
                $responder->__set('id_pergunta',$_POST['id_postagem']);
                $responder->__set('id_postagem',$_POST['id_postagem']);
                $responder->__set('id_usuario',$_SESSION['id']);
                
                
                if(count($comentador) < 1){
                        $responder->__set('origem','6');
                        if($_POST['id_usuario'] != $_SESSION['id']){
                        $responder->enviar_notificacao();
                    }
                }else{
                    $responder->__set('origem','8');
                    $ax = 0;
                    foreach ($comentador as $key => $valor)
                    {
                        $novo = $valor['id_responde'];
                        if($ax != $novo)
                        {
                            if($valor['id_responde'] != $_SESSION['id'])
                            {
                                $responder->__set('id_destino',$valor['id_responde']);
                                $responder->enviar_notificacao();
                            }
                            $ax = $valor['id_responde'];
                        }
                        
                    }
                }
                

                

                

            }
            

        }

        
        public function comentarios(){
            $this->validalogin();
            
            if(isset($_GET['destino']) && $_GET['destino'] == 'turma'){
                $responder = Container::getModel('Acoes');
                $responder->__set('id_pergunta',$_GET['id']);
                $responder->__set('id_turma',$_GET['id_turma']);
                $this->view->comentarios = $responder->getresposta();
                

                $this->view->listar_postagem = $responder->get_postagem();
                $this->view->dado_postagem = $responder->dados_publicacao();
                $this->view->nome_turma = $_GET['nome_turma'];
                $_SESSION['id_postagem'] = $_GET['id'];
                $this->render('comentarioturma',$_SESSION['tema']);

            }
            else{
                $responder = Container::getModel('Acoes');
                $responder->__set('id_pergunta',$_GET['id']);
                $this->view->comentarios = $responder->getresposta();
                
                $this->view->dado_postagem = $responder->dados_publicacao();
                $_SESSION['id_postagem'] = $_GET['id'];
                $this->render('comentarios',$_SESSION['tema']);
            }
            
        }




        public function lista_comentario(){
            $this->validalogin();
            $responder = Container::getModel('Acoes');
            $responder->__set('id_pergunta',$_SESSION['id_postagem']);
            $comentarios = $responder->getresposta();
            $retorno = "";
            foreach ($comentarios as $key => $valor) {
                if($valor['resposta'] != ''){
                $retorno = $retorno . '           
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="container">
                        
                            <div class = "ml-2">
                                <div class="row">
                                    <div class="col-3">
                                        <img class="rounded-circle border border-primary" src="/fotos_de_perfil/'.$valor["nome_foto"].'" style="width: 3rem;" />

                                    </div>
                                    <div class="col-7">
                                    <div class="row">
                                        <h5>'.$valor['nome'].'</h5> 
                                    </div>
                                    <div class="row">
                                    <p>'.$valor['resposta'].'</p>
                                    </div>
                                    
                                </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
                ';
            }
        }
            exit($retorno);
        }

        public function delete_publicacao(){
            $postagem = Container::getModel('Acoes');
            $postagem->__set('id_pergunta',$_GET['id']);
            $postagem->delete_publicacao();
            
            
        }
        //==================================================================
        public function salvar_publicacao(){
            $postagem = Container::getModel('Acoes');
            $postagem->__set('id_pergunta',$_GET['id']);
            $postagem->__set('id_dono',$_GET['id_dono']);
            $postagem->__set('id_usuario',$_SESSION['id']);

            $dados_postagem = $postagem->get_dados();
            $postagem->__set('titulo', $dados_postagem[0]['titulo']);
            $postagem->__set('tweet', $dados_postagem[0]['tweet']);
            $postagem->__set('id_tweet', $_GET['id']);
            $postagem->__set('data', $dados_postagem[0]['data']);
            $postagem->__set('nome_foto_perfil', $dados_postagem[0]['nome_foto']);
            $postagem->__set('nome', $dados_postagem[0]['nome']);
            $d = $postagem->salvar_publicacao();
            print_r($postagem->numero_salvo());
            
               
        }
        public function like_publicacao(){
            $postagem = Container::getModel('Acoes');
            $postagem->__set('tipo_perfil',$_SESSION['perfil']);
            $postagem->__set('id_destino',$_GET['id_destino']);
            $postagem->__set('id_pergunta',$_GET['id']);
            $postagem->__set('id_usuario',$_SESSION['id']);
            $postagem->__set('origem','1');
            $postagem->like_publicacao();
            
            if($_GET['id_destino'] != $_SESSION['id']){
                $postagem->enviar_notificacao();
            }
            print_r($postagem->numero_like());
        }
       
        //===================================================================
        public function editar_postagem(){
            $postagem = Container::getModel('Acoes');
            $postagem->__set('id_pergunta',$_POST['id']);
            $postagem->__set('novo_texto',$_POST['texto']);
            $postagem->editar_postagem();

        }

      
        
        public function perfil_aluno(){
            $this->validalogin();
            $postagem = Container::getModel('Acoes');
            if(isset($_GET['id_aluno'])){
                $postagem->__set('id_usuario',$_GET['id_aluno']);
                $postagem->__set('id_aluno',$_GET['id_aluno']);
                $this->contagem($_GET['id_aluno']);
            }
            else{
                $postagem->__set('id_usuario',$_SESSION['id']);
                $postagem->__set('id_aluno',$_SESSION['id']);
                $this->contagem($_SESSION['id']);
            }
            $this->view->lista_prof = $postagem->listar_prof();
            $this->view->minhas_foto = $postagem->get_foto();
            $this->view->dados_pessoal = $postagem->get_dados_pessoal_aluno();
            $this->view->minhas_postagem = $postagem->listar_postagem();
           
            
             
            $this->render('perfil_aluno',$_SESSION['tema']);
        }
        public function contagem($id){
            
            $tweets = Container::getModel('Tweet');
            $tweets->__set('id_usuario', $id);
            $this->view->tweet = $tweets->getAll();
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

        }
        public function new_notificacao(){
            $this->validalogin();
            //============= NÃO VISTOS ================================
            $tweets = Container::getModel('Tweet');
            $tweets->__set('id_usuario',$_SESSION['id']);
            $icone = [];
            if($_SESSION['perfil'] == '2'){
            $icone['aluno_novo'] = $tweets->getquant_novo()['quantidade'];
            $icone['tarefa_nova'] = $tweets->getquant_tarefa_novo()['quantidade'];
            $icone['duvida_nova'] = $tweets->getquant_duvida_novo()['quantidade'];
            $icone['notificacao_nova'] = $tweets->getquant_notificacao_novo()['quantidade'];
            $icone['mensagem_nova'] = $tweets->getquant_mensagem()['quantidade'];
            print_r($_SESSION['perfil']." ".$icone['aluno_novo']. " ".$icone['tarefa_nova']. " ".$icone['duvida_nova']. " ".$icone['notificacao_nova']. " " .$icone['mensagem_nova']);

            }else{
            $icone['tarefa_nova'] = $tweets->getquant_tarefa_novo()['quantidade'];
            $icone['respondidas'] = $tweets->getquant_duvida_respondida_novo()['quantidade'];
            $icone['notificacao_nova'] = $tweets->getquant_notificacao_novo()['quantidade'];
            $icone['mensagem_nova'] = $tweets->getquant_mensagem()['quantidade'];
            print_r($_SESSION['perfil']." ".$icone['tarefa_nova']. " ".$icone['respondidas']. " ".$icone['notificacao_nova']. " ". $icone['mensagem_nova']);
            
            }
            
            
            //=========================================================
            
        }

        public function perfil_professor(){
            $this->validalogin();
            $postagem = Container::getModel('Acoes');
            if(isset($_GET['id_professor'])){
                $postagem->__set('id_usuario',$_GET['id_professor']);
                $usuario = Container::getModel('Acoes');
                $usuario->__set('id_professor',$_GET['id_professor']);
                $usuario->__set('id_adm',$_GET['id_professor']);
                $this->contagem($_GET['id_professor']);
            }else{
                $postagem->__set('id_usuario',$_SESSION['id']);
                $usuario = Container::getModel('Acoes');
                $usuario->__set('id_professor',$_SESSION['id']);
                $usuario->__set('id_adm',$_SESSION['id']);
                $this->contagem($_SESSION['id']);
            }
            
             
            $this->view->turma = $usuario->get_turma();
            
            $this->view->dados_pessoal = $postagem->get_dados_pessoal();
            $this->view->disciplina_lecionar = $postagem->get_disciplina_lecionar();
            $this->view->lugares_lecionar = $postagem->get_lugares_lecionar();
            $this->view->minhas_postagem = $postagem->listar_postagem();
            $this->view->minhas_avaliacao = $postagem->get_avaliacao();
            $this->view->minhas_foto = $postagem->get_foto();

            
            
            $this->view->lista_alunos = $usuario->listar_aluno();
            $_SESSION['origem'] = 'perfil_professor';
            
             
            $this->render('perfil_professor',$_SESSION['tema']);
        }
        public function lista_arquivado(){
            $this->validalogin();
            $postagem = Container::getModel('Acoes');
            $postagem->__set('id_usuario',$_SESSION['id']);
            $this->view->arquivadas = $postagem->arquivadas();
             
            $this->render('arquivado',$_SESSION['tema']);
        }
        public function pesquisar(){
            $professores = Container::getModel('Acoes');
            $professores->__set('id_aluno',$_SESSION['id']);
            $this->view->lista_professores = $professores->lista_professores();
             
            $this->render('pesquisar',$_SESSION['tema']);
        }


        public function pesquisar_professor(){
            $this->validalogin();
            $pesquisado = isset($_GET['procurado']) ? $_GET['procurado'] : '';
            if($pesquisado != ''){
                
                $this->view->vazio = true;

                $usuario = Container::getModel('Acoes');
                $usuario->__set('nome',$_GET['procurado']);
                $usuario->__set('id',$_SESSION['id']);
                $this->view->procurados = $usuario->getAll();
               
                
            }
            else
            {
                $this->view->vazio = false;
            }
           
             
            $this->render('pesquisar',$_SESSION['tema']);
        }
        public function enviar_pedido(){
            $this->validalogin();
                $usuario = Container::getModel('Acoes');
                $usuario->__set('id_professor',$_GET['id_professor']);
                $usuario->__set('id_aluno',$_SESSION['id']);
                $usuario->enviar_pedido();
                 
                header('Location: /pesquisar');
        }

        public function alunos(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_professor',$_SESSION['id']);
            $usuario->visualizar();
            $this->view->pedidos = $usuario->pedidos_enviados();
             
            $this->render('alunos',$_SESSION['tema']);
        }
        public function cancelar(){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_relacao',$_GET['id_relacao']);
            $usuario->cancelar();
             
            header('Location: /pesquisar');
        }
        public function aceitar(){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('tipo_perfil',$_SESSION['perfil']);
            $usuario->__set('id_relacao',$_GET['id_relacao']);
            
            $usuario->__set('id_destino',$_GET['id_destino']);
            $usuario->__set('id_usuario',$_SESSION['id']);
            $usuario->__set('origem','3');
            $usuario->aceitar();
            $usuario->enviar_notificacao();
             

        }
        public function listar_aluno(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_professor',$_SESSION['id']);
            
            $this->view->lista_alunos = $usuario->listar_aluno();
             
            $this->render('professor',$_SESSION['tema']);
        }
        
        public function meus_professor(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_aluno',$_SESSION['id']);
            
            $this->view->lista_prof = $usuario->listar_prof();
             
            $this->render('meus_professores',$_SESSION['tema']);
        }
        public function tarefa_respondida(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_professor',$_SESSION['id']);
            
            $this->view->lista_respostas = $usuario->listar_respostas();
             
            $usuario->visualizar_respostas();
            $this->render('tarefa_respondida',$_SESSION['tema']);
        }
        public function pergunta_respondida(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_professor',$_SESSION['id']);
            
            $this->view->lista_respostas = $usuario->listar_respostas();
            $usuario->visualizar_respostas();
             
            $this->render('pergunta_respondida',$_SESSION['tema']);
        }
        
        public function enviar_duvida(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_professor',$_POST['id_usuario']);
            $usuario->__set('id_aluno',$_SESSION['id']);
            $usuario->__set('titulo',$_POST['titulo']);
            $usuario->__set('duvida',$_POST['duvida']);
            $usuario->enviar_duvida();
             
            
        }
        public function listar_duvidas(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_aluno',$_SESSION['id']);
            if(isset($_GET['id_duvida']))
            {
                $usuario->__set('id_duvida',$_GET['id_duvida']);
                $usuario->delete_duvida();
            }
            
            $this->view->duvidas = $usuario->getduvidas();
             
            $this->render('duvidas',$_SESSION['tema']);
        }
        public function duvidas_enviadas(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_professor',$_SESSION['id']);
            if(isset($_GET['id_duvida']))
            {
                $usuario->__set('id_duvida',$_GET['id_duvida']);
                $usuario->delete_duvida();
            }
            
            $this->view->duvidas = $usuario->getduvidas_enviadas();
             
            $usuario->visualizar_duvida();
            $this->render('duvidas_enviadas',$_SESSION['tema']);
        }

        public function perguntas_enviadas(){
            $this->validalogin();
                       $usuario = Container::getModel('Acoes');
            $usuario->__set('id_aluno',$_SESSION['id']);
           
            $this->view->duvidas = $usuario->getduvidas();
             
            $this->render('perguntas_enviadas',$_SESSION['tema']);
        }
         public function responder_duvida(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_professor',$_SESSION['id']);
            $usuario->__set('id_aluno',$_POST['id_aluno']);
            $usuario->__set('id_duvida',$_POST['id_pergunta']);
            $usuario->__set('resposta',$_POST['resposta']);
            $usuario->enviar_resposta();
             
           
        }
        public function listar_duvidas_respondidas(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_professor',$_SESSION['id']);
            $this->view->respostas = $usuario->listar_duvidas_respondidas();
             
            $this->render('listar_respostas',$_SESSION['tema']);
        }
        public function notificacao(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario',$_SESSION['id']);
            $this->view->notificacao = $usuario->listar_notificacao();
            $usuario->visualizar_notificacao();
             
            $this->render('notificacao',$_SESSION['tema']);
        }
        public function duvidas_respondidas(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_aluno',$_SESSION['id']);
            if(isset($_GET['id_duvida']))
            {
                $usuario->__set('id_duvida',$_GET['id_duvida']);
                $usuario->delete_duvida_respondida();
            }
            $usuario->visualizar_resposta();

            $this->view->respostas = $usuario->listar_duvidas_respondidas_aluno();
             
            $this->render('duvidas_respondidas',$_SESSION['tema']);
        }
        public function gosto_resposta(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('tipo_perfil',$_SESSION['perfil']);
            $usuario->__set('id_usuario',$_SESSION['id']);
            $usuario->__set('id_destino',$_GET['id_usuario']);
            $usuario->__set('origem','2');
            $usuario->enviar_notificacao();
            
        }

       
        public function avaliar(){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario',$_GET['id_usuario']);
            $usuario->__set('avaliacao',$_GET['avaliacao']);
            $usuario->__set('id_duvida',$_GET['id_resposta']);
            
            $usuario->avaliar();
            $id = $usuario->selecionar_id_avaliacao();
            $usuario->__set('id_avaliacao',$id[0]['id_avaliacao']);
            $usuario->mudar_avaliacao();
            print_r($usuario->selecionar_id_avaliacao());
        }
        public function remover_like(){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario',$_SESSION['id']);
            $usuario->__set('id_publicacao',$_GET['id']);
            $usuario->__set('id_pergunta',$_GET['id']);
            $usuario->remover_like();
            print_r($usuario->numero_like());
        }

        public function turma(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario',$_SESSION['id']);
            $usuario->__set('id_adm',$_SESSION['id']);
             
            $this->view->turma = $usuario->get_turma();
            $this->render('turma_lista',$_SESSION['tema']);
        }
        public function listar_tuma(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario',$_SESSION['id']);
            $usuario->__set('id_adm',$_SESSION['id']);
            $retorno = "";
            $lista = $usuario->get_turma();
            foreach ($lista as $key => $valor) {
                $retorno = $retorno . '
                    <div class="row mb-2">
                      <div class="col-12">
                        
                    <div class="row m-2">
                      <div class="col-12">
                        <div class="card">
                          
                                  
                          <div class="card-header">
                          <div class="row">
                          <div class="col-12 text-center">
                              <img class="rounded-circle border border-primary" src="/fotos_de_perfil/'.$valor['foto_turma'].'" style="width: 5rem;" />
                              </div>
                          </div>
                            <div class="row">
                              
                              <div class="col-8 m-auto text-center">
                                <h2 >'.$valor['nome_turma'].'</h2>
                                <small >'.$valor['descricao_turma'].'</small>
                              </div>
                              
                              
                            </div>
                          </div>
                          
                            <div style="margin: 10px;">
                              
                          <div class="row">
                            
                              <div class="col-12">
                                  <div class = "text-center" id = "postagem_'.$valor['id_turma'].'" >

                                      <a href = "/entrar_turma?id_turma='.$valor['id_turma'].'" class = "btn btn-primary" style="width: 95%; margin: 10px; " type="submit"  >
                                          Entrar 
                                      </a>
                                    
                                  </div>
                              </div>
                             
                              
                          </div>
                                      
                          
                        </div>
                      </div>
                    </div>
                        </div>
                  
                ';
            }
            exit($retorno);

        }
        public function criar_turma(){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_adm',$_SESSION['id']);
            $usuario->__set('nome_turma',$_POST['nome_turma']);
            $usuario->__set('descricao_turma',$_POST['descricao_turma']);
            $usuario->criar_turma();

        }
        public function entrar_turma(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_turma',$_GET['id_turma']);
            $usuario->__set('id_adm',$_SESSION['id']);
             
            $this->view->dados_turma = $usuario->get_dados_turma();
            $this->view->listar_membros = $usuario->get_membro_turma();
            $this->view->listar_alunos = $usuario->get_aluno();
            $this->view->listar_postagem = $usuario->get_postagem();
            $this->view->turma = $usuario->get_turma();
            $this->view->id_turma = $_GET['id_turma'];
            $this->like_arquivado();
            $this->render('turma',$_SESSION['tema']);
        }
        public function publicar_turma(){
            $this->validalogin();
            if( $_POST['tweet'] != '' ){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario',$_SESSION['id']);
            $usuario->__set('id_envia',$_SESSION['id']);
            $usuario->__set('id_turma',$_POST['id_turma']);
            $usuario->__set('titulo',$_POST['titulo']);
            $usuario->__set('tweet',$_POST['tweet']);
            $usuario->__set('tipo_perfil',$_SESSION['perfil']);
            $usuario->__set('pdf', $this->carregar_pdf()); 
            $usuario->__set('pdf_original', $_FILES['pdf']['name']); 
            $usuario->__set('pdf_descricao', $_POST['pdf_descricao']); 
            $usuario->__set('imagem_carregada', $this->carregar_imagem());
            $usuario->publicar_turma();
            $usuario->__set('origem','7');

            $destino = $usuario->get_membro_turma();
            foreach ($destino as $key => $valor) {
                $usuario->__set('id_destino',$valor['id']);
                $usuario->enviar_notificacao();
            }


            header('Location: /entrar_turma?id_turma='.$_POST['id_turma']);
            }else{
                header('Location: /entrar_turma?id_turma='.$_POST['id_turma'].'&men=erro');
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
                    $tweets = Container::getModel('Acoes');
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
        public function like_arquivado(){
            $tweets = Container::getModel('Tweet');
            $tweets->__set('id_usuario', $_SESSION['id']);
            $this->view->tweet = $tweets->getAll();
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
        }
        
        public function add_turma(){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario', $_SESSION['id']);
            $usuario->__set('id_turma',$_POST['id_turma']);
            $usuario->__set('id_aluno',$_POST['id_aluno']);
            $usuario->add_turma();
            $usuario->__set('tipo_perfil',$_SESSION['perfil']);
            $usuario->__set('id_usuario',$_SESSION['id']);
            $usuario->__set('id_destino',$_POST['id_aluno']);
            $usuario->__set('origem','4');
            $usuario->enviar_notificacao(); 
        }
        public function turmas(){
            $this->validalogin();
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario',$_SESSION['id']);
            $usuario->__set('id_aluno',$_SESSION['id']);
             
            $this->view->turma = $usuario->get_turma_aluno();
            $this->render('turmas_alunos',$_SESSION['tema']);
        }
        
        public function get_disciplina(){
            $disciplinas = Container::getModel('Acoes');
            $disc = $disciplinas->get_disciplina();
            $opcoes = "";
            foreach ($disc as $key => $valor) {
                $opcoes = $opcoes . '<option value="'.$valor['id_disciplina'].'">'.$valor['disciplina'].'</option><br>';
            }
            exit($opcoes);
        }
        
        public function trocar_nome(){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario',$_SESSION['id']);
            $usuario->__set('novo_nome',$_GET['nome']);

            if($usuario->trocar_nome()){
                print_r('sucesso');
                $_SESSION['nome'] = $_GET['nome'];
            }else{
                print_r('erro');
            }

        }
        public function trocar_senha(){
            if(md5($_GET['senha_antiga']) == $_SESSION['senha']){

                $usuario = Container::getModel('Acoes');
                $usuario->__set('id_usuario',$_SESSION['id']);
                $usuario->__set('nova_senha',md5($_GET['senha']));
    
                if($usuario->trocar_senha()){
                    print_r('sucesso');
                    $_SESSION['senha'] = md5($_GET['senha']);
                }else{
                    print_r('erro');
                }
            }else{
                print_r ("erro2");
            }
           

        }
        public function alterar_foto(){
            $username = $_SESSION['nome'];
            $imagename = $username."_".rand(999, 999999).$_FILES['imagem']['name'];
            $imagetemp = $_FILES['imagem']['tmp_name'];

            $imagePath = "./fotos_de_perfil/";

            if (is_uploaded_file($imagetemp)) {
                if (move_uploaded_file($imagetemp, $imagePath . $imagename)) {
                    $usuario = Container::getModel('Acoes');
                    $usuario->__set('id_usuario',$_SESSION['id']);
                    $usuario->__set('nova_foto',$imagename);
                    $usuario->trocar_foto_perfil();
                    $_SESSION['nome_foto'] = $imagename;

                    if($_SESSION['perfil'] == '2'){
                        header("Location: /professor");
                   }else
                   if($_SESSION['perfil'] == '1')
                   {
                    header("Location: /aluno");
                   }
                   
                } 
            } 
            
        }
        public function remover_amizade(){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_usuario',$_GET['id_usuario']);
            $this->view->pessoa = $usuario->get_dados_pessoa();
            $this->render('remover_amizade',$_SESSION['tema']);
        }
        public function apagar_conta(){
            if(md5($_POST['pass']) == $_SESSION['senha']){
                $usuario = Container::getModel('Acoes');
                $usuario->__set('id_usuario',$_SESSION['id']);
                if($usuario->apagar_conta()){
                    print_r('sucesso');
                }else{
                    print_r('erro');
                }
            }else
            {
                print_r('senha_errada');
            }
            

        }


        public function apagar_conexao(){

                $usuario = Container::getModel('Acoes');
                $usuario->__set('id_pessoa',$_POST['id_usuario']);
                $usuario->__set('id_usuario',$_SESSION['id']);

                if($usuario->apagar_conexaos()){
                    print_r('sucesso');
                }else{
                    print_r('erro');
                }

            

        }

        public function iliminar_conta(){
            $this->render('iliminar_conta',$_SESSION['tema']);
        }
        

       public function remove_turma(){
            $usuario = Container::getModel('Acoes');
            $usuario->__set('id_aluno',$_POST['id_aluno']);
            $usuario->__set('id_turma',$_POST['id_turma']);
            if($usuario->remover_turma()){
                 print_r('sucesso');
            }

          
       }


        //=================================================================================================
        public function validalogin(){
            if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
                header('Location: /');
            }
        }



	}



?>