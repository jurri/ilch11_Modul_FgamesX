<?php 
#   Copyright by: FeTTsack
#   Support: http://www.graphics-for-all.de

defined ('main') or die ( 'no direct access' );
defined ('admin') or die ( 'only admin access' );

$design = new design ( 'Admins Area', 'Admins Area', 2 );
$design->header();

$abfrage1 = "SELECT *
			FROM	`prefix_flashgames`
			";
$e_game_name = db_query($abfrage1);

$erg = db_query('SELECT * FROM `prefix_fgkategory`');

if($row = db_fetch_assoc($erg)){
	$kname = $row['fgk_kname'];
}
$row2 = db_fetch_assoc($erg);

if (isset($_POST['sub'])){
	$kbeschreibung = ($_POST['fgk_kbesch']);
	$knameinsert = ($_POST['fgk_kname']);
	$insert = "INSERT INTO `prefix_fgkategory`
				(`fgk_kname`, `fgk_kbesch`)
				VALUES
				('$knameinsert', '$kbeschreibung')";
	db_query($insert);
}

if (isset($_POST['submit'])){
	$name = ($_POST["fg_name"]);
	$link = ($_POST["fg_link"]);
	$img = ($_POST["fg_img"]);
	$kategory = ($_POST["kategory"]);
}

if (isset($_POST['subdel'])){
	$kategory = ($_POST["kategory"]);
	db_query("DELETE FROM `prefix_fgkategory` 
		WHERE `fgk_kname`='$kategory'
	");
}
?>
<script type="text/javascript">
function post_to_url(path, params, method) {
    method = method || "post"; // Set method to post by default, if not specified.
 
    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
 
    var addField = function( key, value ){
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", key);
        hiddenField.setAttribute("value", value );
 
        form.appendChild(hiddenField);
    }; 
 
    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            if( params[key] instanceof Array ){
                for(var i = 0; i < params[key].length; i++){
                    addField( key, params[key][i] )
                }
            }
            else{
                addField( key, params[key] ); 
            }
        }
    }
 
    document.body.appendChild(form);
    form.submit();
}
</script>

<table>
<br/>
<form method="post" action="admin.php?flashgamesadmin">
<td>
Kategorie erstellen:<br/>
<input type="text" name="fgk_kname" size="50" value="" style="margin-top:5px; border: 1; color:#000000;"/><br/>
<input type="submit" name="sub" value="Insert" onclick="alert('Kategorie erfolgreich erstellt.')" style="margin-top:5px;  background-color:#AAAAAA; border:4; height: 17px; width: 55px;"/>
</td>
<td>
Kategorie beschreibung:<br/>
<textarea name="fgk_kbesch" rows="3" cols="70" style="color:#000000" wrap="virtual"></textarea><br/>
</td>
</form>


</table>

<table>
	<td>
	<form method="post" action="admin.php?flashgamesadmin">
		<br/>Kategorie wählen: 	
		<select name="kategory" size="1">
		<option selected="selected"></option>
		<?php
		$erg2 = db_query('SELECT * FROM `prefix_fgkategory`');
		while($row=db_fetch_assoc($erg2)){
			$kid = $row['fgk_kname'];
			echo     "<option>";
			echo	 $row['fgk_kname'];
			echo	 "</option>";
		}
		?>
        </select>
		<input type="submit" value="" name="subdel" onclick="alert('Kategorie delete!')" style="background-image:url(include/images/icons/del.gif); background-color:transparent; border:none; height: 12px; width: 13px;"></input>
		<br/>Name vom flashGame eintragen:<br/>
		<input type="text" name="fg_name" size="50" value="" style="margin-top:5px; border: 1; color:#000000;"/><br/>
		<br/>Link vom flashGame eintragen:<br/>
		<input type="text" name="fg_link" size="50" value="" style="margin-top:5px; border: 1; color:#000000;"/><br/>
		<br/>Link vom Bild eintragen:<br/>
		<input type="text" name="fg_img" size="50" value="" style="margin-top:5px; border: 1; color:#000000;"/><br/>
		<input type="submit" value="Insert" name="submit" onclick="alert('das Game wird eingetragen.')" style="margin-top:5px;  background-color:#AAAAAA; border:4; height: 17px; width: 55px;"/>
			

	
	</form>
	</td>
	
<?php

	if(strlen($name)==0){
		echo "<hr>";
	}
	elseif(strlen($link)<=12){
		echo "<hr>";
		echo "<font color=\"#FF0000\">";
		echo "Name nicht eingetragen oder zu kurz!";
		echo "<br/>";
		echo "Link falsch oder nicht eingetragen!";
		echo "<br/>";
		echo "Link bitte mit http:// eintragen";
		echo "</font>";
	}
	else{
		$einfuegen = "INSERT INTO `prefix_flashgames`
				(`fg_link`, `fg_name`, `fg_img`, `fg_fgkname`)
				VALUES
				('$link', '$name', '$img', '$kategory')";
				db_query($einfuegen);
	?>
		<meta http-equiv="refresh" content="0; URL=?flashgamesadmin" >
	<?php
	}
	?>
	<td>
		<table border="1">
		</tr>
		<th title="flashgames löschen"></th>
		<th title="name der flashgames">GameName</th>
		<th title="kategorie vom game">Kategory</th>
		<th title="Link zu den games">GameLink</th>
		</tr>
	<?php
	while($row=db_fetch_assoc($e_game_name)){
		$id = $row['fg_id'];
		$name = $row['fg_name'];
		$link = $row['fg_link'];
		$img = $row['fg_img'];
		$fg_kname = $row['fg_fgkname'];
	?>
			<tr>
			<td><button style="background-color:transparent; border: none;" type="submit" name="submit-button" onclick="alert('Game: <?php echo $name; ?> delete!'); javascript: post_to_url('?flashgamesadmin',{'status':'update','gameid':'<?php echo $id; ?>'}, 'post' );" value="<?php $name; ?>"><?php $name; ?><img src="include/images/icons/del.gif" alt="play"></button></td>
			<td><b><font color="#000000"><a href="<?php echo $img; ?>" target="_blank"><?php echo $name; ?></a></font></b></td>
			<td><font color="#000000"><?php echo $fg_kname ?></font></td>
			<td><font color="#000000"><?php echo $link; ?></font></td>
			</tr>
	<?php
	}
	?>
	</table>
	</td>
	<?php
		if ($_POST['status'] == "update"){
        $id = $_POST['gameid'];
				
		db_query("DELETE FROM `prefix_flashgames` 
				WHERE `fg_id`='$id'
				");
	?>
		<meta http-equiv="refresh" content="0; URL=?flashgamesadmin" >
	<?php
    }
?>
</table>
<?php
$design->footer();
?>