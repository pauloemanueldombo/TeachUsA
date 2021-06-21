function responder_duvida(id_pergunta,id_aluno){
    
    // Criar o formulario
    let form = document.createElement('div')
   
    form.className = 'm-2'

    // Criar a input de texto
    let input = document.createElement('textarea')
    input.name = 'resposta'
    input.className = 'form-control mb-1'
    input.id = 'resposta'+id_pergunta+''
    input.rows ='4'
    input.placeholder = "Digite aqui a tua resposta!"


    // Criar botão de envio
    let button = document.createElement('button')
    button.type = 'submit'
    button.className = 'btn btn-success'
    button.id = 'botao'+id_pergunta+''
    button.innerHTML = 'Enviar resposta'

    // Incluir os imputs

    form.appendChild(input)
    form.appendChild(button)
  
  //=============================

  let postagem = document.getElementById('professor_'+id_pergunta)
  postagem.innerHTML = ''
  postagem.insertBefore(form,postagem[0])
  // ===========================================
  $('#botao'+id_pergunta+'').on('click',() =>{
    resposta = $('#resposta'+id_pergunta).val()
    
    $.ajax({
      type: 'POST',
      url: '/responder_duvida',
      data: `id_aluno=${id_aluno}&id_pergunta=${id_pergunta}&resposta=${resposta}`, 
      success: dados => { 
        $('#professor_'+id_pergunta+'').hide(1000);
        $('#texto_'+id_pergunta+'').html('Duvida respondida');
      },
      error: erro => { console.log(erro) }
  })
  })
  
}
  //===================================================
  
  function enviar_duvida(id_usuario){
    // Criar o formulario
    let form = document.createElement('div')
    
    form.className = 'm-2'

    // Criar a input de texto
    let inputtitulo = document.createElement('input')
    inputtitulo.name = 'titulo'
    inputtitulo.id = 'titulo'+id_usuario+''
    inputtitulo.className = 'form-control mb-1'
    inputtitulo.placeholder = "Título!"

    // Criar a input de texto
    let input = document.createElement('textarea')
    input.name = 'duvida'
    input.className = 'form-control mb-1'
    input.id ='duvida'+id_usuario+''
    input.rows ='4'
    input.placeholder = "Digite aqui a tua dúvida!"


    // Criar botão de envio
    let button = document.createElement('button')
    button.type = 'submit'
    button.className = 'btn btn-success'
    button.id = 'botao'+id_usuario+''
    button.innerHTML = 'Enviar Dúvida'

    // Incluir os imputs
    form.appendChild(inputtitulo)
    form.appendChild(input)
    form.appendChild(button)
  
  //=============================

  let postagem = document.getElementById('professor_'+id_usuario)
  postagem.innerHTML = ''
  postagem.insertBefore(form,postagem[0])
// =========================================================

  $('#botao'+id_usuario+'').on('click',() =>{
    duvida = $('#duvida'+id_usuario).val()
    titulo = $('#titulo'+id_usuario).val()
    
    $.ajax({
      type: 'POST',
      url: '/enviar_duvida',
      data: `id_usuario=${id_usuario}&titulo=${titulo}&duvida=${duvida}`, 
      success: dados => { 
        $('#professor_'+id_usuario+'').hide(1000);
        $('#texto_'+id_usuario+'').html('Duvida Enviada');
      },
      error: erro => { console.log(erro) }
  })
  })


}
  //=====================================================
  function editar(id_postagem,texto){
    // Criar o formulario
    let form = document.createElement('div')
   
    form.className = 'm-2'

    // Criar a input de texto
    let input = document.createElement('textarea')
    input.name = 'texto'
    input.id = 'texto'+id_postagem+''
    input.className = 'form-control mb-1'
    input.rows ='4'
    input.value = texto
  

    // Criar botão de envio
    let button = document.createElement('button')
    button.type = 'submit'
    button.className = 'btn btn-primary m-auto'
    button.id = 'botao'+id_postagem+''
    button.innerHTML = 'Concluir'

    // Incluir os imputs
    form.appendChild(input)
    
    form.appendChild(button)
  
  //=============================

  let postagem = document.getElementById('post_'+id_postagem)
  postagem.innerHTML = ''
  postagem.insertBefore(form,postagem[0])

$('#botao'+id_postagem+'').on('click',() =>{
  novo_texto = $('#texto'+id_postagem).val()
  $.ajax({
    type: 'POST',
    url: '/editar_postagem',
    data: `id=${id_postagem}&texto=${novo_texto}`, 
    success: dados => { 
      $('#post_'+id_postagem+'').html(novo_texto);
    },
    error: erro => { console.log(erro) }
})
})

}

function responder(id_postagem,id_usuario){
  var imagem_carregada = "";
  var pdf = "";
  var pdf_descricao = "";
  var pdf_original = "";
 


  if($('#imagem_carregada_responder'+id_postagem).val() == 'undefined'){
    imagem_carregada = "indefinido";
  }else{
    imagem_carregada = $('#imagem_carregada_responder'+id_postagem).val();
  }

  if($('#pdf_responder'+id_postagem).val() == 'undefined'){
    pdf = "indefinido";
    pdf_descricao = "indefinido";
    pdf_original = "indefinido";
  }else{
    pdf = $('#pdf_responder'+id_postagem).val();
    pdf_descricao = $('#pdf_descricao_responder'+id_postagem).val();
    pdf_original = $('#pdf_original_responder'+id_postagem).val();
  }
    // Criar o formulario
    let form = document.createElement('div')
    
    form.className = 'm-2'
    form.id = 'formulario'+id_postagem+''

    // Criar a input de texto
    let input = document.createElement('textarea')
    input.name = 'resposta'
    input.className = 'form-control mb-1'
    input.id = 'text'+id_postagem+''
    input.rows ='4'
    input.placeholder = "Digite aqui a resposta da pergunta em questão!"

    // Criar input que levara o id no back end
    let inputid = document.createElement('input')
    inputid.type = 'hidden'
    inputid.name = 'id'
    inputid.value = id_postagem
    // Criar input que levara o id_usuario no back end
     let inputid_usuario = document.createElement('input')
    inputid_usuario.type = 'hidden'
    inputid_usuario.name = 'id_usuario'
    inputid_usuario.value = id_usuario

    // Criar botão de envio
    let button = document.createElement('button')
    button.type = 'submit'
    button.className = 'btn btn-primary'
    button.id = 'botao'+id_postagem+''
    button.innerHTML = 'Responder'

    // Incluir os imputs
    form.appendChild(input)
    form.appendChild(inputid)
    form.appendChild(inputid_usuario)
    form.appendChild(button)
  
  //=============================

  let postagem = document.getElementById('postagem_'+id_postagem)
  postagem.innerHTML = ''
  postagem.insertBefore(form,postagem[0])

  $('#botao'+id_postagem+'').on('click',() =>{
    let resposta = $('#text'+id_postagem+'').val()
    $.ajax({
      type: 'POST',
      url: '/responder',
      data: `id_usuario=${id_usuario}&id=${id_postagem}&resposta=${resposta}&imagem_carregada=${imagem_carregada}&pdf=${pdf}&pdf_descricao=${pdf_descricao}&pdf_original=${pdf_original}`,
      success: dados => {
        $('#formulario'+id_postagem+'').html('<small class = "text-success">Resposta Enviada</small>')
        
      },
      error: erro => {console.log(erro)} 
    })
    
  })

}

//========================================================================
//========================================================================
//========================================================================
//========================================================================
//========================================================================



   function like(id_publicacao,id_usuario){
    sera = id_usuario;
    $.ajax({
        type: 'GET',
        url: '/like_publicacao',
        data: `id=${id_publicacao}&id_destino=${id_usuario}`, //x-www-form-urlencoded
        success: dados => { 
            $('#numeroLike'+id_publicacao+'').html(dados +'  <img onclick = "remover_like('+`${id_publicacao}`+','+`${id_usuario}`+')"  src="assets/img/coracao.png" style="width: 1.6rem;" />')
        },
        error: erro => { console.log(erro) }
    })
    
   }
   function remover_like(id_publicacao,id_usuario){
    $.ajax({
      
      type: 'GET',
      url: '/remover_like',
      data: `id=${id_publicacao}`,
      success: dados => { 
          $('#numeroLike'+id_publicacao+'').html(dados +'  <img onclick = "like('+`${id_publicacao}`+','+`${id_usuario}`+')"  src="assets/img/coracao1.png" style="width: 1.4rem;" />')
      },
      error: erro => { console.log(erro) }
    })
   }

   function salvar(id_publicacao,id_usuario){
  
    $.ajax({
        type: 'GET',
        url: '/salvar_publicacao',
        data: `id=${id_publicacao}&id_dono=${id_usuario}`, //x-www-form-urlencoded
        success: dados => { 
            $('#numeroSalvar'+id_publicacao+'').html(dados +'  <img  src="assets/img/salve.png" style="width: 1rem;" />')
        },
        error: erro => { console.log(erro) }
    })
    
   }
   //========================================================================================================
   //========================================================================================================
   //========================================================================================================
   //========================================================================================================
   //========================================================================================================

function depois(id){

    $('#estrelas'+id+'').hide(1000);

}
let estrelas
function avaliar(id_usuario,id){
  
  let avaliacao = estrelas

  $.ajax({
    type: 'GET',
    url: '/avaliar',
    data: `id_usuario=${id_usuario}&avaliacao=${avaliacao}&id_resposta=${id}`, 
    success: dados => { 
      $('#estrelas'+id+'').hide(1000);
    },
    error: erro => { console.log(erro) }
})

}
function clicke(id,estrela){
  
    if (estrela == 1){
      
      $('#estrela1'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela2'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      $('#estrela3'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      $('#estrela4'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      $('#estrela5'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      estrelas = 1
    }else if (estrela == 2){
      $('#estrela1'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela2'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela3'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      $('#estrela4'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      $('#estrela5'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      estrelas = 2
    }else
    if (estrela == 3){
      $('#estrela1'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela2'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela3'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela4'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      $('#estrela5'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      estrelas = 3
    }else
    if (estrela == 4){
      $('#estrela1'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela2'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela3'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela4'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela5'+id+'').attr('src','assets/img/estrelas/estrela1.png')
      estrelas = 4
    }else
    if (estrela == 5){
      $('#estrela1'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela2'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela3'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela4'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      $('#estrela5'+id+'').attr('src','assets/img/estrelas/estrela2.png')
      estrelas = 5
    }
    
}
function enviar_pedido(id_professor){
  $.ajax({
    type: 'GET',
    url: '/enviar_pedido',
    data: `id_professor=${id_professor}`, 
    success: dados => { 
      $('#professor'+id_professor+'').hide(1000);
    },
    error: erro => { console.log(erro) }
})
}


function deletar(id_publicacao){
  let modal = document.querySelector('.modalalert');
  modal.style.display = 'none';
  $('#postagem'+id_publicacao+'').hide(1000);
  $.ajax({
    type: 'GET',
    url: '/delete_publicacao',
    data: `id=${id_publicacao}`,
    success: dados => {
     
      
      
    },
    error: erro =>{console.log(erro)} 

})
}
function iliminar_resposta(id_resposta){
  $.ajax({

    type: 'GET',
    url: '/duvidas_respondidas',
    data: `id_duvida=${id_resposta}`,
    success: dados => {
      $('#resposta'+id_resposta+'').hide(1000);
      
    },
    error: erro =>{console.log(erro)} 

})
}

function iliminar_resposta_enviada(id_resposta){
  $.ajax({

    type: 'GET',
    url: '/duvida',
    data: `id_duvida=${id_resposta}`,
    success: dados => {
      $('#resposta'+id_resposta+'').hide(1000);
      
    },
    error: erro =>{console.log(erro)} 

})
}

function aceitar_pedido(id_relacao,id_destino){
  $.ajax({

    type: 'GET',
    url: '/aceitar',
    data: `id_relacao=${id_relacao}&id_destino=${id_destino}`,
    success: dados => {
      $('#aluno'+id_relacao+'').hide(1000);
      
    },
    error: erro =>{alert('erro')} 

})
}
function gosta_resposta(id_resposta,pb){
  $.ajax({

    type: 'GET',
    url: '/gosto_resposta',
    data: `id_usuario=${id_resposta}`,
    success: dados => {
      $('#resposta'+pb).hide(1000)
    },
    error: erro =>{alert('erro')} 

})
}

function criar_turma(){

  // Criar o formulario
  let form = document.createElement('div')
  
  form.className = 'm-2'

  // Criar a input de texto
  let inputtitulo = document.createElement('input')
  inputtitulo.name = 'nome_turma'
  inputtitulo.id = 'nome_turma'
  inputtitulo.className = 'form-control mb-1'
  inputtitulo.placeholder = "Nome da turma"

  // Criar a input de texto
  let input = document.createElement('textarea')
  input.name = 'descricacao'
  input.className = 'form-control mb-1'
  input.id ='descricao_turma'
  input.rows ='3'
  input.placeholder = "Adiciona uma descrição para a turma!"


  // Criar botão de envio
  let button = document.createElement('button')
  button.type = 'submit'
  button.className = 'btn btn-success'
  button.style = "width: 100%"
  button.id = 'botao'
  button.innerHTML = 'Criar Turma'

  // Incluir os imputs
  form.appendChild(inputtitulo)
  form.appendChild(input)
  form.appendChild(button)

//=============================

let postagem = document.getElementById('formulario')
postagem.innerHTML = ''
postagem.insertBefore(form,postagem[0])
// =========================================================

$('#botao').on('click',() =>{
  let nome_turma = $('#nome_turma').val()
  let descricao_turma = $('#descricao_turma').val()

  $.ajax({
    type: 'POST',
    url: '/criar_turma',
    data: `nome_turma=${nome_turma}&descricao_turma=${descricao_turma}`,
    success: dados => {
      $('#formulario').html('<a onclick = "criar_turma()" class = "btn btn-success" style="width: 95%; margin: 10px; " type="submit">Nova Turma  <img style="width: 1rem;" class="text-center" src="assets/img/erro.png" alt=""></a>')
    },
    error: erro => {console.log(erro)} 
  })
  
})

}

function publicar_turma(id_turma){
  titulo = $('#titulo').val()
  postagem = $('#postagem').val()
  imagem_carregada = $('#foto_carregada').val()
  $.ajax({

      type: 'POST',
      url: '/publicar_turma',
      data: `titulo=${titulo}&tweet=${postagem}&id_turma=${id_turma}&imagem_carregada=${imagem_carregada}`,
      success: dados => {
        $('#mensagem').html('Matéria Publicada');
        $('#titulo').val('')
        postagem = $('#postagem').val('')
        $('#container_imagem').hide(1000)
      },
      error: erro =>{console.log(erro)} 

  })
}

function add_turma(id_aluno,id_turma){

  $.ajax({

    type: 'POST',
    url: '/add_turma',
    data: `id_aluno=${id_aluno}&id_turma=${id_turma}`,
    success: dados => {
      $('#aluno'+id_aluno+'').hide(1000);
     
    },
    error: erro =>{console.log(erro)} 

})
  
}

function comentar(id_postagem,id_usuario,turma){
   resposta = $('#resposta'+id_postagem).val()
  $.ajax({

    type: 'POST',
    url: '/responder_pergunta_publica',
    data: `id_postagem=${id_postagem}&id_usuario=${id_usuario}&resposta=${resposta}&nome_turma=${turma}`,
    success: dados => {
      $('#resposta'+id_postagem+'').val('');
     
    },
    error: erro =>{console.log(erro)} 

})

}

function abrir_pdf(){
  $('#imagemff').html('')
  $('#ficheiropdf').html('<input id = "imagem" class = "uploadbox" name = "pdf" type="file">')
}
function abrir_img(){
  $('#ficheiropdf').html('')
  $('#imagemff').html('<input id = "imagem" class = "uploadbox" name = "imagem" type="file"></input>')
}




function notificacao(){
  $.ajax({

    type: 'POST',
    url: '/new_notificacao',
    data: `id_postagem=2`,
    success: dados => {
      const dadosp = dados.split(" ");
      if(dadosp[0] == 2){
          $('#notificacao').attr("src","assets/img/menu/notificacao/"+ dadosp[4] +".png");
          $('#tarefa').attr("src","assets/img/menu/Tarefa/"+ dadosp[2] +".png");
          $('#duvida').attr("src","assets/img/menu/duvida/"+ dadosp[3] +".png");
          $('#aluno').attr("src","assets/img/menu/aluno/"+ dadosp[1] +".png");
          $('#mensagem').attr("src","assets/img/menu/mensagem/"+ dadosp[5] +".png");
      }else{
        $('#notificacao').attr("src","assets/img/menu/notificacao/"+ dadosp[3] +".png");
        $('#duvida').attr("src","assets/img/menu/duvida/"+ dadosp[2] +".png");
        $('#tarefa').attr("src","assets/img/menu/Tarefa/"+ dadosp[1] +".png");
        $('#mensagem').attr("src","assets/img/menu/mensagem/"+ dadosp[4] +".png");
      }
      
    },
    error: erro =>{console.log(erro)} 

})
}



function get_postagem_professor(numero_postagem){
  

  if(numero_postagem != 7){
    numero_postagem = numero_postagem + 5;
  }
  $.ajax({
    url: '/postagem_professor',
    method: 'POST',
    data: {
      numero_p: numero_postagem
    },
    success: dados => {
      $('#postagemff').html('')
      $('#postagemff').append(dados)
    },
    error: erro =>{console.log(erro)} 

})
}
function dados_inscricao(){
  var nome = $('#nome').val();
  var idade = $('#idade').val();
  var disciplina = $('#disciplina').val();
  var nome = $('#nome').val();
  var nome = $('#nome').val();
  var nome = $('#nome').val();
  var nome = $('#nome').val();
  var nome = $('#nome').val();
  $.ajax({
    url: '/enviar_inscricao',
    method: 'POST',
    data: {
      numero_p: numero_postagem
    },
    success: dados => {
      $('#postagemff').append(dados)
    },
    error: erro =>{console.log(erro)} 

})
}
function get_disciplinas(){
  $.ajax({
    url: '/get_disciplina',
    method: 'POST',
    data: {
      numero_p: 'oi'
    },
    success: dados => {
      $('#disc').append(dados)
    },
    error: erro =>{console.log(erro)} 

})
}
function get_provincia(){
  $.ajax({
    url: '/get_provincia',
    method: 'POST',
    data: {
      numero_p: 'oi'
    },
    success: dados => {
      $('#disc').append(dados)
    },
    error: erro =>{console.log(erro)} 

})
}
function get_new_comentario(){
  const id_perg = $('#id').val();
  $.ajax({
    type: 'GET',
    url: '/lista_comentario',

    success: dados => {
      $('#comentariosff').html(dados)
    },
    error: erro =>{console.log(erro)} 

})
}

function listar_turma(){
  $.ajax({
    type: 'GET',
    url: '/listar_tuma',

    success: dados => {
      $('#turma_lista').html(dados)
    },
    error: erro =>{console.log(erro)} 

})
}

function trocar_nome(){
  $.ajax({
    type: 'GET',
    url: '/trocar_nome',
    data: {
      nome: $('#novo_nome').val()
    },
    success: dados => {
      if(dados == 'sucesso'){
        alert("Sucesso")
      }else
      {
        alert("Erro")
      }
    },
    error: erro =>{console.log(erro)} 

})
}

function trocar_senha(){

var nova_senha = $('#nova_senha').val()
var confirmar_senha = $('#confirmar_senha').val()

if(nova_senha != confirmar_senha){
  alert('A senha de confirmação esta erra!')
}else{
  $.ajax({
    type: 'GET',
    url: '/trocar_senha',
    data: {
      senha: nova_senha,
      senha_antiga: $('#senha_antiga').val()
    },
    success: dados => {
      if(dados == "erro2"){
        alert("A palavra passe antiga esta errado!")
      }else
      if(dados == 'sucesso'){
        alert("Sucesso")
      }else
      {
        alert("Erro banco de dado")
      }
     

    },
    error: erro =>{console.log(erro)} 

})
}
 
}

function trocar_nome(){
  $.ajax({
    type: 'GET',
    url: '/trocar_nome',
    data: {
      nome: $('#novo_nome').val()
    },
    success: dados => {
      if(dados == 'sucesso'){
        alert("Sucesso")
      }else
      {
        alert("Erro")
      }
    },
    error: erro =>{console.log(erro)} 

})
}

function enviar_codigo(){

  var senha = $('#email').val()
  if(senha == ''){
    let modal = document.querySelector('.modalalert');
    modal.style.display = 'block';
    $('#mensagem_erro').html("Adiciona o teu email!")
  }else
  {
    $("#corpo").html('<center><div class="col-12"><h5 class="text-center">Enviando mensagem de confirmação</h5><img  src="./assets/img/loading.gif" alt=""></div></center>')
    $.ajax({
      type: 'POST',
      url: '/confirmar.php',
      data: {
        nome: 'recupera',
        email_u: senha
      },
      success: dados => {
        if(dados == "sucesso"){
          window.location = "/muda_senha"
        }else
        if(dados == "erro"){
          let modal = document.querySelector('.modalalert');
        modal.style.display = 'block';
        $('#mensagem_erro').html("ERRO NA CONEXÃO!")
  }

      },
      error: erro =>{console.log(erro)} 

  })
  }
 
}

function registrar(){

  var senha = $('#pass').val()
  var confirmar_senha = $('#confirma_pass').val()
  var nome = $('#nome').val()
  var email = $('#email').val()


  if(senha == "" || confirmar_senha == "" || email == "" || nome == ""){
    $('#mensagem_erro_ins').html("Prencha os campos corretamente!")
  }else
  if(senha != confirmar_senha){
    $('#mensagem_erro_ins').html("A senha de confirmação esta errada!")
  }else
  {
    $("#corpo").html('<center><div class="col-12"><h5 class="text-center">Enviando mensagem de confirmação</h5><img  src="./assets/img/loading.gif" alt=""></div></center>')
    $.ajax({
      type: 'POST',
      url: '/confirmar.php',
      // url: '/registra',
      data: {
        senha_u: senha,
        nome_u: nome,
        email_u: email
      },
      success: dados => {
        if(dados == "sucesso"){
          window.location = "/confirmar_email"
          // window.location = "/utilizador"
        }else
        if(dados == "erro"){
          let modal = document.querySelector('.modalalert');
        modal.style.display = 'block';
        $('#mensagem_erro').html("ERRO NA CONEXÃO!")
  }

      },
      error: erro =>{console.log(erro)} 

  })
  }
 
}
function registrar_usuario(){
  var codigo = $('#codigo').val()
  var codigo_enviado = $('#codigo_enviado').val()
  var nome = $('#nome').val()
  var email = $('#email').val()
  var senha = $('#senha').val()

      if(codigo != codigo_enviado){
        let modal = document.querySelector('.modalalert');
        modal.style.display = 'block';
        $('#mensagem_erro').html("CODIGO ERRADO TENTE NOVAMENTE!")
      }else{

      $.ajax({
        type: 'POST',
        url: '/registra',
        data: {
          senha_u: senha,
          nome_u: nome,
          email_u: email
        },
        success: dados => {
          if(dados == "sucesso"){
            window.location = "/utilizador"
          }else
          if(dados == "existe"){
            let modal = document.querySelector('.modalalert');
            modal.style.display = 'block';
            $('#mensagem_erro').html("EMAIL EXISTENTE!")
            window.location = "/inscreverse"
          }

        },
        error: erro =>{console.log(erro)} 

    })

  }
}

function trocar_foto(){
  $("#confirma_foto").html('<button class = "btn btn-success">Trocar</button>')
}

function abrir_modal(mensagem){
  $('#mensagem_modal').html(mensagem)

  if(mensagem == "DESEJAS SAIR?"){
  $('#confirmar').html('<div class="col-6 m-auto" ><button style="width: 90%;" onclick = "sair()" class = "btn btn-light border border-primary">SIM</button></div><div class="col-6 m-auto" ><button style="width: 90%;" onclick = "fechar_modal()" class = "btn btn-light border border-primary">NÃO</button></div>')
  }

  let modal = document.querySelector('.modalalert');

  modal.style.display = 'block';

}
function apagar_modal(id){
  $('#mensagem_modal').html("DESEJAS APAGAR?")

  $('#confirmar').html('<div class="col-6 m-auto" ><button style="width: 90%;" onclick = "deletar('+ id +')"  class = "btn btn-light border border-primary">SIM</button></div><div class="col-6 m-auto" ><button style="width: 90%;" onclick = "fechar_modal()" class = "btn btn-light border border-primary">NÃO</button></div>')


  let modal = document.querySelector('.modalalert');

  modal.style.display = 'block';

}
function fechar_modal(){
  let modal = document.querySelector('.modalalert');
  modal.style.display = 'none';
}
function sair(){
  window.location = '/sair'
}

function listar_municipio(){
  id = $('#provincia').val();
  $.ajax({
    url: '/listar_municipio',
    method: 'POST',
    data: {
      id_provincia: id
    },
    success: dados => {
      $('#municipio').html(dados)
    },
    error: erro =>{console.log(erro)} 

})
}
function listar_provincias(){
  $.ajax({
    type: 'POST',
    url: '/listar_provincia',
    success: dados => {
     $('#provincia').html(dados)
    },
    error: erro =>{console.log(erro)} 

})
}

function confirmar_cod_senha(codigo){
  var senhaP = $('#pass').val()
  var confirmar_senha = $('#confirma_pass').val()
  var codigo_digitado = $('#codigo').val()

  if(senhaP == "" && confirmar_senha == "" && codigo_digitado == ""){
    $('#mensagem_erro_ins').html("Nenhum campo pode estar fazio!")
  }
  else
  if(senhaP != confirmar_senha){
    $('#mensagem_erro_ins').html("Senha de confirmação incorreto")
  }
  else
  if(codigo_digitado != codigo){
    $('#mensagem_erro_ins').html("Codigo de confirmação incorreto!")
  }
  else{
      id = $('#provincia').val();
      $.ajax({
      url: '/atualizar_senha',
      method: 'POST',
      data: {
        senha: senhaP
      },
      success: dados => {
        if(dados == 'sucesso'){
          alert('Alterado!')
          window.location = "/"
        }
      },
      error: erro =>{console.log(erro)} 

})
  }

  
}

function remove_turma(id_aluno,id_turma){
  $.ajax({
    url: '/remove_turma',
    method: 'POST',
    data: {
      id_aluno: id_aluno,
      id_turma: id_turma
    },
    success: dados => {
      if(dados == 'sucesso'){
        $('#aluno'+id_aluno).hide(1000)
      }
    },
    error: erro =>{console.log(erro)} 

})
}

function iliminar_conta(){
  
    $.ajax({
      url: '/apagar_conta',
      method: 'POST',
      data: {
        pass: $('#pass').val(),
      },
      success: dados => {
        if(dados == 'erro'){
          alert("FALHA NA CONEXÃO COM A BASE DE DADOS!")
        }else
        if(dados == 'sucesso'){
          alert("CONTA APAGADA COM SUCESSO!")
          window.location = '/sair'
        }else
        if(dados == 'senha_errada'){
          alert("A SENHA ESTA ERRADA, TENTE NOVAMENTE!")
        }
        
      },
      error: erro =>{console.log(erro)} 
  
  })
  
}

function iliminar_conexao(id_usuario){
  if(confirm("DESEJAS MESMO APAGAR A CONEÇÃO COM ESTE USUÁRIO!")){
    $.ajax({
      url: '/apagar_conexao',
      method: 'POST',
      data: {
        id_usuario: id_usuario,
      },
      success: dados => {
        if(dados == 'erro'){
          alert("FALHA NA CONEXÃO COM A BASE DE DADOS!")
        }else
        if(dados == 'sucesso'){
          alert("CONEXÃO REMOVIDA COM SUCESSO!")
          window.location = '/timeline'
        }
        
      },
      error: erro =>{console.log(erro)} 
  
  })
  }
}

// ==============================
$(document).ready(function() {
  notificacao()
  setInterval(() => {
      notificacao();
      get_new_comentario();
      listar_turma();
  }, 2000);

  get_postagem_professor(7)
  listar_provincias()

});

// ============================================================================
// ============================================================================
function vermais(){
  window.location = window.location.href
}


$("#imgInp").change(function() {
  alert("Ola como vai")
});













