
<?php
    include("check.php");

    if (isset($_GET["id"]) && $_GET["id"] > 0){
        $user_id = $_GET["id"];

        // Get user
        $getUser = $con->prepare("SELECT nome FROM usuario WHERE (id LIKE ?) LIMIT 1");
        $getUser->bind_param("i", $user_id);
        $getUser->execute();
        $user = $getUser->get_result()->fetch_assoc();

        ?>
        <div class="topMenu">
            <img src="asset/img/close.png" onclick="atualizar()" />
            <p class="title"><?php echo $user["nome"]; ?></p>
        </div>

        <div class="innerContainer"></div>

        <form method="POST" enctype="multipart/form-data" id="sendMessage">
            <input type="number" value="<?php echo $user_id; ?>" name="id" hidden />
            <input type="text" maxlength="500" name="message" id="messageInput" placeholder="Escreva aqui a sua mensagem" />
            <input type='file' name="image" accept="asset/image/x-png,image/jpeg" id="sendImage" hidden />
            <label for="sendImage"><img src="asset/img/image.png" /></label>
        </form>

        <script>
            function sendMessage() {
                var formData = new FormData($("#sendMessage")[0]);
                $.ajax({
                    type: 'post',
                    url: 'asset/process/send.php',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $("#sendMessage")[0].reset();
                    },
                    error: function (error) {
                        $("#sendMessage")[0].reset();
                    }
                });
            }

            $("#messageInput").on('keyup', function (e) {
                if (e.keyCode === 13 && ($("#messageInput").val().length > 0)) {
                    sendMessage()
                }
            });

            $("#sendImage").change(function() {
                sendMessage();
                console.log("SEND");
            });

          setInterval(() => {
                $.ajax({
                    url: 'asset/process/retrieve.php?id=<?php echo $user_id; ?>',
                    success: function (data) {
                        $('#chat .innerContainer').html(data);
                        $('#chat .innerContainer').scrollTop($('#chat .innerContainer').prop("scrollHeight"));
                    },
                    error: function (error) {
                        Swal.fire({
                            title: 'Erro de chat',
                            text: error.statusText,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }
                });
            }, 1500);
            
        </script>
        <?php
    } else {
        ?>
        
        <?php
    }
?>