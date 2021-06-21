<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['enviar_email'] = array(
			'route' => '/enviar_email',
			'controller' => 'indexController',
			'action' => 'enviar_email'
		);
		$routes['inscreverse'] = array(
			'route' => '/inscreverse',
			'controller' => 'indexController',
			'action' => 'inscreverse'
		);
		$routes['utilizador'] = array(
			'route' => '/utilizador',
			'controller' => 'indexController',
			'action' => 'utilizador'
		);
		$routes['confirmar_email'] = array(
			'route' => '/confirmar_email',
			'controller' => 'indexController',
			'action' => 'confirmar_email'
		);
		$routes['recuperar_senha'] = array(
			'route' => '/recuperar_senha',
			'controller' => 'indexController',
			'action' => 'recuperar_senha'
		);
		$routes['muda_senha'] = array(
			'route' => '/muda_senha',
			'controller' => 'indexController',
			'action' => 'muda_senha'
		);
		$routes['atualizar_senha'] = array(
			'route' => '/atualizar_senha',
			'controller' => 'indexController',
			'action' => 'atualizar_senha'
		);
		$routes['registra'] = array(
			'route' => '/registra',
			'controller' => 'indexController',
			'action' => 'registra'
		);
		$routes['entracom'] = array(
			'route' => '/entracom',
			'controller' => 'indexController',
			'action' => 'entracom'
		);
		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);
		$routes['timeline'] = array(
			'route' => '/timeline',
			'controller' => 'AppController',
			'action' => 'menu_inicial'
		);
		$routes['timeline_professor'] = array(
			'route' => '/timeline_professor',
			'controller' => 'AppController',
			'action' => 'menu_inicial'
		);
		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AppController',
			'action' => 'sair'
		);
		$routes['tweet'] = array(
			'route' => '/tweet',
			'controller' => 'AppController',
			'action' => 'tweet'
		);
		$routes['quem_seguir'] = array(
			'route' => '/quem_seguir',
			'controller' => 'AppController',
			'action' => 'quem_seguir'
		);
		$routes['acao'] = array(
			'route' => '/acao',
			'controller' => 'AppController',
			'action' => 'acao'
		);
		//=================================================
		$routes['perfil_aluno'] = array(
			'route' => '/perfil_aluno',
			'controller' => 'PerfilController',
			'action' => 'perfilAluno'
		);

		$routes['listar_provincia'] = array(
			'route' => '/listar_provincia',
			'controller' => 'PerfilController',
			'action' => 'listar_provincia'
		);

		$routes['listar_municipio'] = array(
			'route' => '/listar_municipio',
			'controller' => 'PerfilController',
			'action' => 'listar_municipio'
		);

		$routes['perfil_professor'] = array(
			'route' => '/perfil_professor',
			'controller' => 'PerfilController',
			'action' => 'perfilProfessor'
		);

		$routes['guardar_dado_perfil_aluno'] = array(
			'route' => '/guardar_dado_perfil_aluno',
			'controller' => 'PerfilController',
			'action' => 'guardar_dado_perfil_aluno'
		);
		$routes['guardar_dado_perfil_professor'] = array(
			'route' => '/guardar_dado_perfil_professor',
			'controller' => 'PerfilController',
			'action' => 'guardar_dado_perfil_professor'
		);
		$routes['disciplinaprofessor'] = array(
			'route' => '/disciplinaprofessor',
			'controller' => 'PerfilController',
			'action' => 'disciplinaprofessor'
		);
		$routes['guardardisciplina'] = array(
			'route' => '/guardardisciplina',
			'controller' => 'PerfilController',
			'action' => 'guardardisciplina'
		);
		$routes['disciplina_add'] = array(
			'route' => '/disciplina_add',
			'controller' => 'PerfilController',
			'action' => 'disciplina_add'
		);
		$routes['iliminar_disciplina_add'] = array(
			'route' => '/iliminar_disciplina_add',
			'controller' => 'PerfilController',
			'action' => 'iliminar_disciplina_add'
		);
		

		$routes['lugarprofessor'] = array(
			'route' => '/lugarprofessor',
			'controller' => 'PerfilController',
			'action' => 'lugarprofessor'
		);
		$routes['lista_municipio'] = array(
			'route' => '/lista_municipio',
			'controller' => 'PerfilController',
			'action' => 'lista_municipio'
		);
		$routes['guardar_professor_luagar'] = array(
			'route' => '/guardar_professor_luagar',
			'controller' => 'PerfilController',
			'action' => 'guardar_professor_luagar'
		);
		$routes['iliminar_professor_luagar'] = array(
			'route' => '/iliminar_professor_luagar',
			'controller' => 'PerfilController',
			'action' => 'iliminar_professor_luagar'
		);
		$routes['bemvindo_professor'] = array(
			'route' => '/bemvindo_professor',
			'controller' => 'PerfilController',
			'action' => 'bemvindo_professor'
		);
		$routes['guardar_foto'] = array(
			'route' => '/guardar_foto',
			'controller' => 'PerfilController',
			'action' => 'guardar_foto'
		);
		$routes['foto_de_perfil'] = array(
			'route' => '/foto_de_perfil',
			'controller' => 'PerfilController',
			'action' => 'foto_de_perfil'
		);
		$routes['responder'] = array(
			'route' => '/responder',
			'controller' => 'acoesController',
			'action' => 'responder_pergunta'
		);
		$routes['timeline_publico'] = array(
			'route' => '/timeline_publico',
			'controller' => 'AppController',
			'action' => 'timeline_publico'
		);
		$routes['trocatema'] = array(
			'route' => '/trocatema',
			'controller' => 'AppController',
			'action' => 'trocatema'
		);
		$routes['delete_publicacao'] = array(
			'route' => '/delete_publicacao',
			'controller' => 'acoesController',
			'action' => 'delete_publicacao'
		);
		$routes['salvar_publicacao'] = array(
			'route' => '/salvar_publicacao',
			'controller' => 'acoesController',
			'action' => 'salvar_publicacao'
		);
		$routes['like_publicacao'] = array(
			'route' => '/like_publicacao',
			'controller' => 'acoesController',
			'action' => 'like_publicacao'
		);
		$routes['editar_postagem'] = array(
			'route' => '/editar_postagem',
			'controller' => 'acoesController',
			'action' => 'editar_postagem'
		);
		$routes['comentarios'] = array(
			'route' => '/comentarios',
			'controller' => 'acoesController',
			'action' => 'comentarios'
		);
		$routes['lista_comentario'] = array(
			'route' => '/lista_comentario',
			'controller' => 'acoesController',
			'action' => 'lista_comentario'
		);
		$routes['listar_tuma'] = array(
			'route' => '/listar_tuma',
			'controller' => 'acoesController',
			'action' => 'listar_tuma'
		);
		$routes['responder_pergunta_publica'] = array(
			'route' => '/responder_pergunta_publica',
			'controller' => 'acoesController',
			'action' => 'responder_pergunta_publica'
		);
		$routes['aluno'] = array(
			'route' => '/aluno',
			'controller' => 'acoesController',
			'action' => 'perfil_aluno'
		);
		$routes['professor'] = array(
			'route' => '/professor',
			'controller' => 'acoesController',
			'action' => 'perfil_professor'
		);
		$routes['lista_arquivado'] = array(
			'route' => '/lista_arquivado',
			'controller' => 'acoesController',
			'action' => 'lista_arquivado'
		);
		$routes['pesquisar'] = array(
			'route' => '/pesquisar',
			'controller' => 'acoesController',
			'action' => 'pesquisar'
		);
		$routes['pesquisar_professor'] = array(
			'route' => '/pesquisar_professor',
			'controller' => 'acoesController',
			'action' => 'pesquisar_professor'
		);
		$routes['enviar_pedido'] = array(
			'route' => '/enviar_pedido',
			'controller' => 'acoesController',
			'action' => 'enviar_pedido'
		);
		$routes['alunos'] = array(
			'route' => '/alunos',
			'controller' => 'acoesController',
			'action' => 'alunos'
		);
		$routes['cancelar'] = array(
			'route' => '/cancelar',
			'controller' => 'acoesController',
			'action' => 'cancelar'
		);
		$routes['aceitar'] = array(
			'route' => '/aceitar',
			'controller' => 'acoesController',
			'action' => 'aceitar'
		);
		$routes['listar_aluno'] = array(
			'route' => '/listar_aluno',
			'controller' => 'acoesController',
			'action' => 'listar_aluno'
		);
		
		$routes['meus_professor'] = array(
			'route' => '/meus_professor',
			'controller' => 'acoesController',
			'action' => 'meus_professor'
		);
		$routes['tarefa_respondida'] = array(
			'route' => '/tarefa_respondida',
			'controller' => 'acoesController',
			'action' => 'tarefa_respondida'
		);
		$routes['pergunta_respondida'] = array(
			'route' => '/pergunta_respondida',
			'controller' => 'acoesController',
			'action' => 'pergunta_respondida'
		);
		$routes['enviar_duvida'] = array(
			'route' => '/enviar_duvida',
			'controller' => 'acoesController',
			'action' => 'enviar_duvida'
		);
		$routes['duvidas'] = array(
			'route' => '/duvida',
			'controller' => 'acoesController',
			'action' => 'listar_duvidas'
		);
		$routes['duvidas_enviadas'] = array(
			'route' => '/duvidas_enviadas',
			'controller' => 'acoesController',
			'action' => 'duvidas_enviadas'
		);
		$routes['perguntas_enviadas'] = array(
			'route' => '/perguntas_enviadas',
			'controller' => 'acoesController',
			'action' => 'perguntas_enviadas'
		);
		$routes['responder_duvida'] = array(
			'route' => '/responder_duvida',
			'controller' => 'acoesController',
			'action' => 'responder_duvida'
		);
		$routes['listar_respostas'] = array(
			'route' => '/listar_respostas',
			'controller' => 'acoesController',
			'action' => 'listar_respostas'
		);
		$routes['todas_respostas'] = array(
			'route' => '/todas_respostas',
			'controller' => 'acoesController',
			'action' => 'listar_duvidas_respondidas'
		);
		$routes['apagar_conta'] = array(
			'route' => '/apagar_conta',
			'controller' => 'acoesController',
			'action' => 'apagar_conta'
		);
		$routes['iliminar_conta'] = array(
			'route' => '/iliminar_conta',
			'controller' => 'acoesController',
			'action' => 'iliminar_conta'
		);
		$routes['remover_amizade'] = array(
			'route' => '/remover_amizade',
			'controller' => 'acoesController',
			'action' => 'remover_amizade'
		);
		$routes['apagar_conexao'] = array(
			'route' => '/apagar_conexao',
			'controller' => 'acoesController',
			'action' => 'apagar_conexao'
		);
		$routes['notificacao'] = array(
			'route' => '/notificacao',
			'controller' => 'acoesController',
			'action' => 'notificacao'
		);
		$routes['duvidas_respondidas'] = array(
			'route' => '/duvidas_respondidas',
			'controller' => 'acoesController',
			'action' => 'duvidas_respondidas'
		);
		$routes['gosto_resposta'] = array(
			'route' => '/gosto_resposta',
			'controller' => 'acoesController',
			'action' => 'gosto_resposta'
		);
		$routes['avaliar'] = array(
			'route' => '/avaliar',
			'controller' => 'acoesController',
			'action' => 'avaliar'
		);
		$routes['ficha_contrato'] = array(
			'route' => '/ficha_contrato',
			'controller' => 'admController',
			'action' => 'ficha_contrato'
		);
		$routes['remover_like'] = array(
			'route' => '/remover_like',
			'controller' => 'acoesController',
			'action' => 'remover_like'
		);
		$routes['turma'] = array(
			'route' => '/turma',
			'controller' => 'acoesController',
			'action' => 'turma'
		);
		$routes['criar_turma'] = array(
			'route' => '/criar_turma',
			'controller' => 'acoesController',
			'action' => 'criar_turma'
		);
		$routes['entrar_turma'] = array(
			'route' => '/entrar_turma',
			'controller' => 'acoesController',
			'action' => 'entrar_turma'
		);
		$routes['publicar_turma'] = array(
			'route' => '/publicar_turma',
			'controller' => 'acoesController',
			'action' => 'publicar_turma'
		);
		$routes['add_turma'] = array(
			'route' => '/add_turma',
			'controller' => 'acoesController',
			'action' => 'add_turma'
		);
		$routes['turmas'] = array(
			'route' => '/turmas',
			'controller' => 'acoesController',
			'action' => 'turmas'
		);
		$routes['carregar_imagem'] = array(
			'route' => '/carregar_imagem',
			'controller' => 'acoesController',
			'action' => 'carregar_imagem'
		);
		$routes['new_notificacao'] = array(
			'route' => '/new_notificacao',
			'controller' => 'acoesController',
			'action' => 'new_notificacao'
		);
		$routes['chat'] = array(
			'route' => '/chat',
			'controller' => 'chatController',
			'action' => 'chat'
		);
		$routes['ficha_de_contrato'] = array(
			'route' => '/ficha_de_contrato',
			'controller' => 'acoesController',
			'action' => 'ficha_de_contrato'
		);
		$routes['inscricao_enviada'] = array(
			'route' => '/inscricao_enviada',
			'controller' => 'acoesController',
			'action' => 'inscricao_enviada'
		);
		$routes['postagem_professor'] = array(
			'route' => '/postagem_professor',
			'controller' => 'AppController',
			'action' => 'postagem_professor'
		);
		$routes['get_disciplina'] = array(
			'route' => '/get_disciplina',
			'controller' => 'acoesController',
			'action' => 'get_disciplina'
		);
		$routes['get_provincia'] = array(
			'route' => '/get_provincia',
			'controller' => 'acoesController',
			'action' => 'get_provincia'
		);

		$routes['trocar_nome'] = array(
			'route' => '/trocar_nome',
			'controller' => 'acoesController',
			'action' => 'trocar_nome'
		);

		$routes['remove_turma'] = array(
			'route' => '/remove_turma',
			'controller' => 'acoesController',
			'action' => 'remove_turma'
		);

		$routes['trocar_senha'] = array(
			'route' => '/trocar_senha',
			'controller' => 'acoesController',
			'action' => 'trocar_senha'
		);
		$routes['alterar_foto'] = array(
			'route' => '/alterar_foto',
			'controller' => 'acoesController',
			'action' => 'alterar_foto'
		);
		$routes['vermais'] = array(
			'route' => '/vermais',
			'controller' => 'AppController',
			'action' => 'vermais'
		);
		$routes['vermais_p'] = array(
			'route' => '/vermais_p',
			'controller' => 'AppController',
			'action' => 'vermais_p'
		);
		$routes['vermenus'] = array(
			'route' => '/vermenus',
			'controller' => 'AppController',
			'action' => 'vermenus'
		);

		$routes['vermenus_p'] = array(
			'route' => '/vermenus_p',
			'controller' => 'AppController',
			'action' => 'vermenus_p'
		);

		

		

	
		//=================================================

		$this->setRoutes($routes);
	}

}

?>