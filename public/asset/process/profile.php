<?php
    include("check.php");

    if(isset($_GET["id"])) {
        $id = $_GET["id"];
    } else {
        die(header("HTTP/1.0 401 Falta de parametros na chamada"));
    }
   
    // Check if is logged user
    if($id == 0) {
        $id = $uid;
        $user_creation = date('d/m/Y', strtotime($user_creation));
        ?>
        <form method="POST" enctype="multipart/form-data" id="uploadPic">
            <input type='file' name="imgInp" accept="image/x-png,image/jpeg" id="imgInp" hidden />
            <div class="pictureContainer">
                <img id="userImg" src="fotos_de_perfil/<?php echo $user_picture; ?>" />
                <label for="imgInp"></label>
            </div>
        </form>
        <?php
    } else {
        // Query
        $stmt = $con->prepare("SELECT * from usuario inner join tb_fotos on (usuario.id = tb_fotos.id_usuario) WHERE (id = ?) LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        
        // Does user exists
        if(!$user) {
            die(header("HTTP/1.0 401 Erro ao carregar dados do perfil do utilizador"));
        } else {
            $username = $user["nome"];
            $user_picture = $user["nome_foto"];
            $user_online = strtotime($user['ativo']);
            $user_creation = date('d/m/Y', strtotime($user_creation));
        }

        ?>
        <div class="pictureContainer">
            <img id="userImg" src="../fotos_de_perfil/<?php echo $user_picture; ?>" />
        </div>
        <?php
    }
?>

<p class="name"><?php echo $username; ?></p>

<?php if($_SESSION['id'] != $id) { ?>
<p class="row">Online <?php echo timing($user_online); ?></p>
<?php }?>

<?php if($_SESSION['id'] == $id) { ?>
<p class="row">Online agora</p>
<?php }?>

