<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postagens mais populares</title>
</head>

<body>
    <h2>Lista de postagem</h2>

    <div class="postagens">
        <?php
        require_once "conexao.php";

        $sql = "SELECT 
    p.idpostagem,
    p.conteudo,

    (
        SELECT COUNT(*)
        FROM curtida c
        WHERE c.idpostagem = p.idpostagem
    ) AS quantidade_curtidas,
    
    (
        SELECT COUNT(*)
        FROM comentario co
        WHERE co.idpostagem = p.idpostagem
    ) AS quantidade_comentarios,

    (
        (
            SELECT COUNT(*)
            FROM curtida c
            WHERE c.idpostagem = p.idpostagem
        )
        +
        (
            SELECT COUNT(*)
            FROM comentario co
            WHERE co.idpostagem = p.idpostagem
        )
    ) AS popularidade

FROM postagem p, usuario u WHERE p.idusuario = u.idusuario
ORDER BY popularidade DESC;";
        // $sql2 = "SELECT COUNT(*) as quantidade_curtidas FROM curtida, postagem WHERE curtida.idpostagem = postagem.idpostagem;";

        // $curtidas = mysqli_query($conexao, $sql2);
        // while ($curtida = mysqli_fetch_array($curtidas)) {
        //     $quantidade_curtidas = $curtida['quantidade_curtidas'];
        //     echo "Quantidade de curtidas: $quantidade_curtidas";
        // }

        $postagens = mysqli_query($conexao, $sql);
        while ($postagem = mysqli_fetch_array($postagens)) {
            $idpostagem = $postagem['idpostagem'];
            $texto = $postagem['texto'];
            $data_hora = $postagem['data_hora'];
            $idusuario = $postagem['idusuario'];
            $nome_usuario = $postagem['nome'];
            $username = $postagem['username'];
            $foto_usuario = $postagem['foto'];
            $postagem['quantidade_curtidas']

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
            echo "Quantidade de curtidas: " . $postagem['quantidade_curtidas'];
            echo "<br>";

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