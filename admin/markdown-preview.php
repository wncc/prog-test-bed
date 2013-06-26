
<?php
use \Michelf\Markdown;
/*
 * Script to preview mardown formatted texts
 */

	if($_POST['action'] == 'preview') {
		// preview for the markdown problem statement
		if($_POST['title']=="" and $_POST['text']=="")
			echo("<div class=\"alert alert-error\">You have not entered either the title or the problem text!</div>");
		else {
			require_once('../markdown.php');
			$out = Markdown::defaultTransform($_POST['text']);
			echo("\n<h1>".$_POST['title']."</h1>\n<hr/>");
			echo($out);
		}
	}
?>
