<?php
require_once 'classe_pessoa.php';

$host = 'localhost';
$port = '5432';
$dbname = 'cadastro_pessoa';
$user = 'postgres';
$password = '2022';

$p = new Pessoa($host, $port, $dbname, $user, $password);

if (isset($_POST['nome'])) {
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);

    if (!empty($nome) && !empty($telefone) && !empty($email)) {
        if (isset($_GET['edit'])) {
            $id = (int)$_GET['edit'];
            $p->AtualizarDados($nome, $telefone, $email, $id);
            header("Location: index.php");
            exit();
        } else {
            $p->CadastrarPessoa($nome, $telefone, $email);
        }
    } else {
        echo "Preencha todos os campos!";
    }
}

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = $p->BuscarDadosPessoa($id);
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $p->ExcluirPesosa($id);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pessoas</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <section id="esquerda">
        <?php if (!isset($_GET['edit'])) { ?>
            <form method="POST">
                <h2>CADASTRAR PESSOA</h2>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
                <input type="submit" value="Cadastrar">
            </form>
        <?php } else { ?>
            <form method="POST">
                <h2>ATUALIZAR PESSOA</h2>
                <label for="nome">Nome</label>
                <input type="text" name="nome" value="<?php echo $res['nome']; ?>" id="nome">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" value="<?php echo $res['telefone']; ?>" id="telefone">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo $res['email']; ?>" id="email">
                <input type="submit" value="Atualizar">
            </form>
        <?php } ?>
    </section>

    <section id="direita">
        <table>
            <tr>
                <th>NOME</th>
                <th>TELEFONE</th>
                <th>EMAIL</th>
                <th>AÇÕES</th>
            </tr>
            <?php
            $dados = $p->BuscarDados();
            if (count($dados) > 0) {
                foreach ($dados as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['nome']; ?></td>
                        <td><?php echo $value['telefone']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td>
                            <a href="?edit=<?php echo $value['id']; ?>">Editar</a>
                            <a href="?delete=<?php echo $value['id']; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php }
            } else {
                echo "Nenhuma pessoa cadastrada.";
            }
            ?>
        </table>
    </section>
</body>
</html>