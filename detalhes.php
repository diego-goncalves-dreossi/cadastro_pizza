<?php
	include('config/conexao.php');
	
	//Verificando se o parâmetro id foi enviado pelo get_browser
	if(isset($_GET['id'])){
		//Limpa os dados de sql injection
		$id = mysqli_real_escape_string($conn,$_GET['id']);
		
		//Monta a query
		$sql = "SELECT * FROM pizza WHERE id = $id;";
		
		//Executa a query e guarda em $result
		$result = mysqli_query($conn,$sql);
		
		//Busca o resultado em forma de vetor
		$pizza = mysqli_fetch_assoc($result);
		
		mysqli_free_result($result);
		
		mysqli_close($conn);		
	}
	
    //REMOVER A PIZZA DO BANCO DE DADOS
    if (isset($_POST['delete'])){
        //Limpando a query
        $id_pizza = mysqli_real_escape_string($conn,$_POST['id_pizza']);

        //Montando a query
        $sql = "DELETE FROM pizza WHERE id = $id_pizza";

        //Removendo do bd
        if (mysqli_query($conn,$sql)){
            //Sucesso
            header('Location: index.php');
        } else{
            echo 'query error'.mysqli_error($conn);
        }
    }

    if (isset($_POST['alter'])){

    }


	//print_r($pizza);
?>


<!DOCTYPE html>
<html>
  <?php include('templates/header.php') ?>
  <section class="container grey-text">
    <h4 class="center">Mais informações</h4>
  </section>  


  <div class ="container center">
  <?php if($pizza): ?>
       <h4> <?php echo $pizza['nomePizza']; ?></h4>
       <p>E-Mail: <?php echo $pizza['email']; ?></p>
       <p><?php echo date($pizza['criadoem']); ?></p>
       <h5>Ingredientes:</h5>
       <p><?php echo $pizza['ingredientes']; ?></p>
       <!-- FORMULARIO DE REMOÇÃO -->
       <form action="detalhes.php" method="POST" >
           <input type="hidden" name="id_pizza" value = "<?php echo $pizza['id'];?>">
           <input type = "submit" name ="delete" value = "Remover" class="btn brand z-depth-0"> 
           
       </form>
       <br>
       <form action="alterarpizza.php" method = "POST">
       <input type="hidden" name="id" value="<?php echo $pizza['id'] ?>">
       <input type = "submit" name="alterD" value = "Alterar" class ="btn brand z-depth-0">
       </form>   
      
  <?php else: ?>
      <h5>Pizza não encontrada. </h5>
  <?php endif ?>  
  </div>   



  <?php include('templates/footer.php') ?>



</html>