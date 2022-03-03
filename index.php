<?php
  
  include('config/conexao.php');

  //Query para buscar
  $sql = 'SELECT nomePizza, ingredientes, id FROM pizza ORDER BY criadoem';
  
  //resultado como um conjunto de linhas
  $result = mysqli_query($conn,$sql);

  // busca a query
  $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

  //limpa a memoria de result
  mysqli_free_result($result);

  //fecha conexão
  mysqli_close($conn);

  //print_r($pizzas);
  print_r(explode(',',$pizzas[0]['ingredientes']));
  # Mesma finalidade do comando split

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>
	
	<h4 class="center grey-text">Pizzas!</h4>
	
	<div class="container">
		<div class="row">
			<?php foreach($pizzas as $pizza) {?>
				<div class="col s6 md3">
					<div class="card z-depth-0">
						<div class="card-content center">
							<h6><b><?php echo htmlspecialchars($pizza['nomePizza']); ?></b></h6>
							<ul class ="grey-text">
                <?php foreach(explode(',', $pizza['ingredientes']) as $ing ) { ?>
                  <li><?php echo htmlspecialchars($ing); ?> </li>
                  <?php } ?>
              </ul>
              
              
						</div>
						<div class="card-action right-align">
							<a class="brand-text" href="detalhes.php?id=<?php echo $pizza['id']?>">Mais informações</a>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php include('templates/footer.php'); ?>

</html.