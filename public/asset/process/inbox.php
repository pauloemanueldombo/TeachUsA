<?php
    include("check.php");

    /* ?>
    <div class="chat selected" onclick="chat('<?php echo $user['Id']; ?>')">
        <img src="img/globe.png" />
        <p>Toda a comunidade</p>
    </div>
    <?php */
    
    // Query
    $stmt = $con->prepare("SELECT * FROM conversas WHERE (usuario_principal = ?) ORDER BY modificado DESC");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    if ($count < 1) {
        echo '<div class="empty"><p>Pesquise um utilizador e começe a conversa!</p></div>';
    }

    while ($inbox = $result->fetch_assoc()) {
        $stmt = $con->prepare("SELECT id, nome, foto_de_perfil FROM usuario WHERE (id LIKE ?) LIMIT 1");
        $stmt->bind_param("i", $inbox["outros_usuarios"]);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        $stmt = $con->prepare("SELECT nome_foto FROM tb_fotos WHERE (id_usuario LIKE ?) LIMIT 1");
        $stmt->bind_param("i", $inbox["outros_usuarios"]);
        $stmt->execute();
        $foto = $stmt->get_result()->fetch_assoc();

        if ($user) {
            ?>
            <div class="chat <?php if($inbox["lido"] == "y") { echo "new"; } ?>" onclick="reiniciar('<?php echo $user['id']; ?>')">
                <img src="fotos_de_perfil/<?php echo $foto["nome_foto"]; ?>" />
            <p><?php echo $user["nome"]; ?></p>
            </div>
            <?php
        }
    }
?>
