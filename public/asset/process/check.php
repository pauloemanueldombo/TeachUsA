<?php
    include("connection/connect.php");
    session_start();
    function timing ($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time<1) ? 1 : $time;
        $tokens = array (
            31536000 => 'ano',
            2592000 => 'mês',
            604800 => 'semana',
            86400 => 'dia',
            3600 => 'hora',
            60 => 'minuto',
            1 => 'segundo'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            if ($text == "segundo") {
                return "agora mesmo";
            }
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }

    

    if(true) {
        // Normalization
        $id = $_SESSION['id'];
       
      
            // Normalize information
            $uid = $_SESSION['id'];
            $username = $_SESSION['nome'];
            $user_picture = $_SESSION['foto_perfil'];
            $user_online = strtotime($_SESSION['online']);
            $user_creation = "2021-02-26 17:57:25";

            // Online status pin-point
            $stmt = $con->prepare("UPDATE usuario SET `ativo` = now() WHERE id = ?");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
       
    }
?>