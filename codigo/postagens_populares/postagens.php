<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        div {
            border-style: solid;
        }

        .postagens {
            border-color: blue;
            padding: 10px;
        }

        .postagem {
            border-color: red;
            padding: 10px;
            margin: 10px;
        }
    </style>
</head>

<body>
    <h2>Lista de postagem</h2>

    <div class="postagens">
        <?php
        require_once "../conexao.php";
        $sql = "SELECT postagem.idpostagem, postagem.texto, postagem.data_hora, postagem.idusuario, usuario.username, usuario.nome, usuario.foto, (SELECT COUNT(*) FROM curtida WHERE curtida.idpostagem = postagem.idpostagem) AS quantidade_curtidas, (SELECT COUNT(*) FROM comentario WHERE comentario.idpostagem = postagem.idpostagem) AS quantidade_comentario
            FROM postagem, usuario
            WHERE postagem.idusuario = usuario.idusuario
            ORDER BY (quantidade_curtidas + quantidade_comentario) DESC;";

        $postagens = mysqli_query($conexao, $sql);

        while ($postagem = mysqli_fetch_array($postagens)) {
            $idpostagem = $postagem['idpostagem'];
            $texto = $postagem['texto'];
            $data_hora = $postagem['data_hora'];
            $idusuario = $postagem['idusuario'];
            $nome_usuario = $postagem['nome'];
            $username = $postagem['username'];
            $foto_usuario = $postagem['foto'];
            $quantidade_curtidas = $postagem['quantidade_curtidas'];
            $quantidade_comentario = $postagem['quantidade_comentario'];

            echo "<div class='postagem'>";
            echo "<img src='fotos_usuario/$foto_usuario'>";
            echo "$nome_usuario ($username)";
            echo "<br>";
            echo $idpostagem;
            echo "<br>";
            echo $texto;
            echo "<br>";
            echo $data_hora;
            echo "<br>";
            echo "Quantidade de curtidas: $quantidade_curtidas";
            echo "<br>";
            echo "Quantidade de cometarios: $quantidade_comentario";

            echo "<div>";
            $sql2 = "SELECT comentario.idcomentario, comentario.idusuario, comentario.texto, usuario.username, usuario.nome, usuario.foto
                FROM comentario, usuario
                WHERE idpostagem = $idpostagem
                AND comentario.idusuario = usuario.idusuario ORDER BY comentario.idcomentario;";
            $comentarios = mysqli_query($conexao, $sql2);
            $quantidade_comentario = mysqli_num_rows($comentarios);
            if ($quantidade_comentario == 0) {
                echo "Seja o primeiro a comentar...";
            } else {
                while ($comentario = mysqli_fetch_array($comentarios)) {
                    $idcomentario = $comentario['idcomentario'];
                    $comentario_idusuario = $comentario['idusuario'];
                    $comentario_texto = $comentario['texto'];
                    $comentario_nome_usuario = $comentario['nome'];
                    $comentario_username_usuario = $comentario['username'];
                    $comentario_foto_usuario = $comentario['foto'];

                    echo "<br>";
                    echo $idcomentario;
                    echo "<img src='fotos_usuario/$comentario_foto_usuario'>";
                    echo "$comentario_nome_usuario ($comentario_username_usuario)";
                    echo $comentario_texto;
                }
            }
        ?>
            <br>
            <input type="text">
            <input type="submit" value="Comentar">
        <?php
            echo "</div>";

            echo "</div>";
        }
        ?>
    </div>
</body>

</html>