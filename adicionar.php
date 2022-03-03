<?php
    include('config/conexao.php');

    $erros = array('email'=>'','nomePizza'=>'','ingredientes'=>'');
	$email = $nomePizza = $ingredientes = '';

	if (isset($_POST['enviar'])){
        //Verificar email, se esta vazio ou não
        if(empty($_POST['email'])){
            echo 'O email é obrigatório <br />';
        }else{
        $email = $_POST['email'];
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            //Verifica se o email escrito é valido, se tem o @ e o .com 
            $erros['email'] = 'Insira um e-mail válido <br/>';
            $email = '';
        }else{
		    echo htmlspecialchars($_POST['email']).'<br/>';
        }
        }
        //Verificar nome de piza
        if(empty($_POST['nomePizza'])){
            echo 'O nome da pizza é obrigatório <br />';
        }else{
        $nomePizza = $_POST['nomePizza'];
        if(!preg_match('/^[a-zA-Z\s]+$/',$nomePizza)){
            //Verifica se o que foi escrito é uma letra, maiscula ou miniscula, ou um espaço
            //o + permite que seja mais que um caractere, o ^  o $ sinalizam o começo e fim da 
            //string
            $erros['nomePizza'] = 'O nome deve conter somente letras e espaços </br>';
            $nomePizza = '';
        }else{    
		echo htmlspecialchars($_POST['nomePizza']).'<br/>';
        }
        }

        if(empty($_POST['ingredientes'])){
            echo 'Deve ter ao menos um ingrediente <br />';
        }else{
            $ingredientes = $_POST['ingredientes'];
			if (!preg_match('/^([a-zA-z\s]+)(,\s*[a-zA-Z\s]*)*$/',$ingredientes)){
				$erros['ingredientes'] = 'O nome deve conter somente letras e separados por vírgula. </br>';
		        $ingredientes = '';
            } else{
                echo htmlspecialchars($_POST['ingredientes']).'<br/>';
            }
        }

        if (array_filter($erros)){
			//echo 'Erro no formulário <br/>';
		}else {
			//echo 'Formulário válido <br/>';
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $nomePizza = mysqli_real_escape_string($conn, $_POST['nomePizza']);
            $ingredientes = mysqli_real_escape_string($conn,$_POST['ingredientes']);

            //Criando a Query
            $sql = "INSERT INTO pizza (nomePizza,email,ingredientes) VALUES('$nomePizza','$email','$ingredientes')";

            //Salva no banco de dados
            if (mysqli_query($conn, $sql)){
                //Sucesso
                header('Location: index.php'); 
            } else{
                echo 'query error'.mysqli_error($conn);
            }

			
		}

	}

    # htmlspecialchars le os caracteres especiais e evita que o programa
    # leia scripts de terceiros

    /*if (isset($_GET['enviar'])){
        O get passa os valores das variaveis por url, tornando as visiveis
        O post não, as variaveis ficam escondidas, usado para login por exemplo
        ou outras funcionalidades em que os dados precisam ser protegidos 
		echo $_GET['email'].'<br/>';
		echo $_GET['nomePizza'].'<br/>';
		echo $_GET['ingredientes'].'<br/>';
	}*/
?>


<!DOCTYPE html>
<html>
	<?php include('templates/header.php')?>
	
	<section class="container grey-text">
		<h4 class="center">Adicionar Novo Tipo de Pizza</h4>
		<form class="white" action="adicionar.php" method="POST">
			<label>E-mail</label>
			<input type="text" name="email" value="<?php echo $email?>">
			<div class="red-text"><?php echo $erros['email'].'<br/>'?></div>
			<label>Nome da Pizza</label>
			<input type="text" name="nomePizza" value="<?php echo $nomePizza?>">
			<div class="red-text"><?php echo $erros['nomePizza'].'<br/>'?></div>
			<label>Ingredientes (separados por vírgula)</label>
			<input type="text" name="ingredientes" value="<?php echo $ingredientes?>">
			<div class="red-text"><?php echo $erros['ingredientes'].'<br/>'?></div>
			<div class="center" style="margin-top: 10px;">
				<input type="submit" name="enviar" value="Enviar" class="btn brand z-depth-0">
			</div>
		</form>
	</section>
	<?php include('templates/footer.php')?>
</html>

