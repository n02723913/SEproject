<!DOCTYPE html>
<html lang="en"> 
	<head>
		<?php
			
			include("php/config.php");

			
			
			include("php/db.php");			
			
			include("includes/head.php");
			
			include("/~dallingn1/2014fall/pro/php/Qmessage.php");
			
			if(isset($_POST['submit'])){
				$index = 0;
				$message = "";
				while(isset($_POST["answer_$index"])){
					$message += $_POST["answer_$index"] . '\n';
					$index++;
				}
				
				q_message($message, $_SESSION['id'], 0);
			}
		?>
	</head>
	<body>
		<?php
			include 'includes/UserNavBar.php';
			if($_SESSION['privilige'] != 2 ) {
				print "You are not authorized to view this content.";
				die();
			}
		?>
		<div class="container">
		<header><h1>Questionnaire page </h1></header>
		<h2>Please anwser 3 out of 5 questions below:</h2>
		<form action="questionarie.php" method="post">
			<table class="table table-hover">
					<thead>
						<tr>
							<th>Question #</th>
							<th>Question Descriptions</th>
							<th>Answer</th>
						</tr>
					</thead>
					<tbody>
			<?php
						
						print"<h3>REQUIRED Questions are in red  (User must awsner these questions)</h3>";
							$query = "SELECT * 
									FROM  `question` 
									WHERE  `required` =1 &&  `active` =1";
							$stm = $dbh->query($query);
							$results = $stm->fetchAll();
							
							foreach ($results as $question) {
								$id = $question['id'];
								$require = $question['required'];
								$description= $question['description'];
								print "
								<tr style=' background-color: 	#FAEBD7;'>
									<th >$id</th>
									<td >$description</td>
									<td><input type='text' id ='$id' name='answer[]'/></td>
								";
								
								
							}
							
							$query = "SELECT * 
									FROM  `question` 
									WHERE  `required` =0 &&  `active` =1";
									$stm = $dbh->query($query);
							$results = $stm->fetchAll();
							$index = 0;
									foreach ($results as $question) {
								$id = $question['id'];
								$description= $question['description'];
								print "
								<tr >
									<th class='col-xs-12 col-sm-1'>$id</th>
									<td class='col-xs-12 col-sm-5'>$description</td>
									<td><input type='text' id ='$id' name='anwser_$index'/></td>
								
								";
								$index++;
								
							}
						?>
						
					</tbody></table>
			<input type="submit" name="submit" id="submit" value="Submit" />			
		</form>
		</div>
	</body>
</html>