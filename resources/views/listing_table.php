
<?php 

$server_connect = new PDO( "mysql:host=".$_SESSION['server'], $_SESSION['username'], $_SESSION['password']);

$all_database1 = $server_connect->query( "SELECT schema_name FROM information_schema.schemata WHERE schema_name
   NOT IN ('information_schema', 'mysql', 'performance_schema','sys')");

$all_database2 = $server_connect->query( "SELECT schema_name FROM information_schema.schemata WHERE schema_name
   NOT IN ('information_schema', 'mysql', 'performance_schema','sys')");


if(isset($_POST['db_selected'])) {
	$_SESSION['database1'] = $_POST['database1'];
	$_SESSION['database2'] = $_POST['database2'];

	header('location: ?view=listing_table');
}
?>

<div class="row">
	<div class="col-lg-offset-3 col-lg-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				Listing des tables
			</div>
			<div class="panel-body">
				<?php 

					if(isset($_POST['migrate'])) {

						$show_tables = $server_connect->query("SHOW TABLES FROM ".$_SESSION['database1']); 
						while($table = $show_tables->fetch()) {

							// On recupère son schema
							$bdd1 = new PDO( "mysql:host=".$_SESSION['server'].";dbname=".$_SESSION['database1'], $_SESSION['username'], $_SESSION['password']);

							$statement = $bdd1->query('DESCRIBE ' . $table[0]);
  
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							   
							
							// On se connecte a la bd2
							$bdd2 = new PDO( "mysql:host=".$_SESSION['server'].";dbname=".$_SESSION['database2'], $_SESSION['username'], $_SESSION['password']);

							// On créer les tables
							// $sql = "CREATE TABLE IF NOT EXISTS ".$table." (
							//                 task_id     INT AUTO_INCREMENT PRIMARY KEY,
							//                 subject     VARCHAR (255)        DEFAULT NULL,
							//                 start_date  DATE                 DEFAULT NULL,
							//                 end_date    DATE                 DEFAULT NULL,
							//                 description VARCHAR (400)        DEFAULT NULL
							//             )";
							$chaine_sql = ""; 
							$nbre = count($result);
							foreach($result as $k => $column){
								if($k + 1 == $nbre) {
									$chaine_sql = $chaine_sql.' '.$column['Field'].' '.$column['Type'];
								} else {
									$chaine_sql = $chaine_sql.' '.$column['Field'].' '.$column['Type'].', ';
								}
								
							    // echo $column['Field'] . ' - ' . $column['Type'], '<br>';
							} 

							$sql = "CREATE TABLE IF NOT EXISTS ".$table[0]." (
							                ".$chaine_sql."
							            )"; 
							$statut = $bdd2->exec($sql);
						} 
							?> 
								<div class="alert alert-success">La migration est effectué avec succès ! 
					 			</div>
							<?php
						 
						
					} 

				?>
				<form method="post" action="?view=listing_table">
					<div class="row">
						<div class="col-lg-6">
							<h3> A : <?= $_SESSION['database1'] ?></h3>
							<?php 

								$show_tables_1 = $server_connect->query("SHOW TABLES FROM ".$_SESSION['database1']);

							?>
							 <!-- <button class="btn btn-primary">Migrer toutes les tables</button> -->
							 <table class="table">
							 	<?php while($table1 = $show_tables_1->fetch()): ?>
								 	<tr>
								 		<td><input type="checkbox" name="table[]"></td>
								 		<td><?= $table1[0] ?></td>
								 	</tr>
							    <?php endwhile; ?> 
							 		<tr>
							 			<td></td>
							 			<td><button type="submit" name="migrate" class="btn btn-success">Migrer toutes les tables</button></td>
							 		</tr>
							 </table>
						</div>
						<div class="col-lg-6">
							<h3> B : <?= $_SESSION['database2'] ?></h3>
							<?php 

								$show_tables_2 = $server_connect->query("SHOW TABLES FROM ".$_SESSION['database2']);

							?>
							 <table class="table">
							 	<?php while($table2 = $show_tables_2->fetch()): ?>
								 	<tr>
								 		<td></td>
								 		<td><?= $table2[0] ?></td>
								 	</tr>
							    <?php endwhile; ?>
							 </table>
						</div> 
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>