<div class="row">
	<div class="col-lg-offset-4 col-lg-4">
		<?php 

			 if(isset($_POST['connect'])) {
			 	$_SESSION['server_name'] = $_POST['server_name'];
			 	$_SESSION['port'] = $_POST['port'];
			 	$_SESSION['username'] = $_POST['username'];
			 	$_SESSION['password'] = $_POST['password'];

			 	$server_connect = new PDO( "mysql:host=".$_SESSION['server'], $_SESSION['username'], $_SESSION['password']);

			 	if($server_connect != NULL) {
			 		?>
			 			<div class="alert alert-success">Connexion au serveur <?= $_SESSION['server_name'] ?> etablit avec succès !<br>
			 				<a href="?view=choice_db">
			 					<button class="btn btn-default">Cliquez ici pour commencer la migration</button>
			 				</a>
			 			</div>
			 		<?php
			 	} else {
			 		?>
			 			<div class="alert alert-danger">Une erreur est survenue lors de la connexion au seveur <?= $_SESSION['server_name'] ?>, reéssayer à nouveau !</div>
			 		<?php
			 	}
			 }

		?>
		<div class="panel panel-info">
			<div class="panel-heading">
				Connexion au serveur mysql
			</div>
			<div class="panel-body">
				<form method="post" action="?view=db_connect&schema=mysql_to_mysql">
					<div class="form-group">
						<label>Serveur name</label>
						<input type="text" class="form-control" name="server_name" placeholder="Server name" required>
					</div>
					<div class="form-group">
						<label>Port</label>
						<input type="text" class="form-control" name="port" placeholder="Port" required>
					</div>
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="username" placeholder="Username" required>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="text" class="form-control" name="password" placeholder="Password" required>
					</div>
					<button  name="connect" class="btn btn-primary pull-right" type="submit">Connecter</button>
				</form>
			</div>
		</div>
	</div>
</div>