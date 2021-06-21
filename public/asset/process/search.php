<?php
    include("check.php");

    if ($_GET["term"]){
        $username = mysqli_real_escape_string($con, $_GET["term"]);

        // Query
        $procurador = $_SESSION['id'];

        if($_SESSION['perfil'] == '1'){
            $stmt = $con->prepare("SELECT usuario.id as id, usuario.nome as nome, tb_perfil_professor.cidade, tb_perfil_professor.municipio, tb_perfil_professor.bairro, tb_perfil_professor.curso, tb_fotos.nome_foto as foto_de_perfil, tb_relacao.id_relacao,tb_relacao.id_aluno,
            (SELECT count(*) from tb_relacao where id_aluno = $procurador and id_professor = usuario.id) as estado
            from usuario
            inner join tb_perfil_professor on (tb_perfil_professor.id_usuario = usuario.id) inner join  tb_fotos on (tb_fotos.id_usuario = usuario.id) 
            left join tb_relacao on (tb_relacao.id_professor = usuario.id)
            where (SELECT count(*) from tb_relacao where id_aluno = $procurador and id_professor = usuario.id) = 1
            and tb_relacao.id_aluno = $procurador AND tb_relacao.estado = 1 and (nome LIKE '%$username%') ORDER BY nome");
        }else
        if($_SESSION['perfil'] == '2'){
            $stmt = $con->prepare("SELECT usuario.id as id, usuario.nome as nome, tb_perfil_aluno.cidade, tb_perfil_aluno.municipio, tb_perfil_aluno.bairro, tb_perfil_aluno.curso, tb_fotos.nome_foto as foto_de_perfil,tb_relacao.id_relacao,tb_relacao.id_aluno,
            (SELECT count(*) from tb_relacao where usuario.id = id_aluno and id_professor = $procurador) as estado
            from usuario
            inner join tb_perfil_aluno on (tb_perfil_aluno.id_usuario = usuario.id) inner join  tb_fotos on (tb_fotos.id_usuario = usuario.id) 
            left join tb_relacao on (tb_relacao.id_aluno = usuario.id)
            where (SELECT count(*) from tb_relacao where usuario.id = id_aluno and id_professor = $procurador) = 1
            and tb_relacao.id_professor = $procurador AND tb_relacao.estado = 1 and (nome LIKE '%$username%') ORDER BY nome");
        }

       



        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->num_rows;

        if ($count < 1) {
            echo '<p class="noResults">Sem resultados</p>';
        }

        while ($user = $result->fetch_assoc()) {
            ?>
            <div class="row"  onclick="reiniciar('<?php echo $user['id']; ?>')">
                <img src="fotos_de_perfil/<?php echo $user["foto_de_perfil"] ?>" />
                <p><?php echo $user["nome"] ?></p>
            </div>
            <?php
        }
    }
?>