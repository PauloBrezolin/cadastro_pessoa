<?php

class Pessoa {
    private $pdo;

    public function __construct($host, $port, $dbname, $user, $password) {
        try {
            $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro com banco de dados: '.$e->getMessage();
            exit();
        } catch (Exception $e) {
            echo 'Erro genérico: '.$e->getMessage();
            exit();
        }
    }

    public function BuscarDados()
    {
        $res = array();
        $sql = $this->pdo->prepare("SELECT * FROM pessoa ORDER BY id");
        $sql->execute();
        $res = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function CadastrarPessoa($nome, $telefone, $email)
    {
            $sql = $this->pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES (?, ?, ?)");

            $sql->execute(array(
                $_POST['nome'], 
                $_POST['telefone'], 
                $_POST['email']));
            echo 'Pessoa adicionada com sucesso!';
    }

    public function ExcluirPesosa($id)
    {
        $this->pdo->exec("DELETE FROM pessoa WHERE id = $id");
        echo 'Pessoa deletada com sucesso!';
    }

    public function BuscarDadosPessoa($id){
        $res = array();
        $sql = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = ?");
        $sql->execute(array($id));
        $res = $sql->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function AtualizarDados($nome, $telefone, $email, $id)
    {
        $sql = $this->pdo->prepare("UPDATE pessoa SET nome = ?, telefone = ?, email = ? WHERE id = ?");

        $sql->execute(array(
            $_POST['nome'], 
            $_POST['telefone'], 
            $_POST['email'], 
            $id));

            echo 'Pessoa atualizada com sucesso!';
    }
}

?>