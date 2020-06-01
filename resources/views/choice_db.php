
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
				Choisissez les bases de données
			</div>
			<div class="panel-body">
				<form method="post" action="?view=choice_db">
					<div class="row">
						<div class="col-lg-6">
							<label>Selectionnez La BD de depart</label>
							<select name="database1" class="form-control" required>
								<?php while($db_name = $all_database1->fetchColumn()): ?>
									<option value="<?= $db_name ?>"><?= $db_name ?></option>
								<?php endwhile; ?>
							</select>
						</div>
						<div class="col-lg-6">
							<label>Selectionnez La BD destination</label>
							<select name="database2" class="form-control" required>
								<?php while($db_name2 = $all_database2->fetchColumn()): ?>
									<option value="<?= $db_name2 ?>"><?= $db_name2 ?></option>
								<?php endwhile; ?>
							</select>
							<a href="#"><small>+ Ajouter une BD</small></a><br>
							<button type="submit" name="db_selected" class="btn btn-info btn-block pull-right">Continuez</button>
						</div> 
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>