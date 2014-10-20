<?php 
#<!-- Copyright by FeTTsack -->
# Support: http://www.graphics-for-all.de/

defined ('main') or die ('no direct access'); 


$title = $allgAr['title'].' :: flashgames';
$hmenu = 'flashGames';
$design = new design ( $title , $hmenu );
$design->header();

	$abfrage1 = "SELECT	`fg_id`,
					`fg_name`,
					`fg_img`
			FROM	`prefix_flashgames`
			WHERE 	`fg_fgkname` = ''
			";
	$e_game_name = db_query($abfrage1);

$ansicht = 0;
//wenn Kategorie ausgewählt wurde
if(isset($_POST['submit'])) {
	$ansicht = 1;
	$kname = ($_POST['submit']);
	$abfrage1 = "SELECT	`fg_id`,
					`fg_name`,
					`fg_img`
			FROM	`prefix_flashgames`
			WHERE	`fg_fgkname` = '$kname'
			";
	$e_game_name = db_query($abfrage1);
}
//wenn wieder zurück zur Gamesübersicht gewächselt wird
if(isset($_POST['buttong'])){
	$ansicht = 1;
	$abfrage2 = "SELECT	`fg_fgkname`
			FROM	`prefix_flashgames`
			WHERE		`fg_bolactive` = 1
			";
	$e_game_kat = db_query($abfrage2);
	if($row=db_fetch_assoc($e_game_kat)){
		$kname = $row['fg_fgkname'];
	}
	
	if(strlen($kname)==0){
		$ansicht=0;
	}
	else{
	$abfrage1 = "SELECT	`fg_id`,
					`fg_name`,
					`fg_img`
			FROM	`prefix_flashgames`
			WHERE	`fg_fgkname` = '$kname'
			";
	$e_game_name = db_query($abfrage1);
	}
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

<body>
<?php
	//wenn ein Game angeklickt wird
	if ($_POST['status'] == "update"){
        $id = $_POST['gameid'];
		$control = 1;
		$ansicht = 2;

				
		db_query("UPDATE 	`prefix_flashgames`
				SET 		`fg_bolactive`=1
				WHERE 		`fg_id`='$id' 
				");
				
		$abfrage2 = "SELECT `fg_link`
			FROM	`prefix_flashgames`
			WHERE	`fg_bolactive` is not null
			";
		$e_game_link = db_query($abfrage2);
    }


	//ansicht wenn noch nichts angeklickt wurde		
	if($ansicht==0){
		$e_fg_kategory = db_query("SELECT * FROM `prefix_fgkategory`");
		?>
		<center>
		<table border="1">
		</tr>
		<th title="name der kategroie">Kategorie</th>
		<th title="beschreibung">Beschreibung</th>
		</tr>
		<form method="post" action="?flashgames">
		<?php
			//auflisten der Kategorien
		while($row=db_fetch_assoc($e_fg_kategory)){
			?>
			<tr>
			<td><center><input type="submit" value="<?php echo $row['fgk_kname']; ?>" name="submit"/></center></td>
			<td><?php echo $row['fgk_kbesch']; ?></td>
			</tr>
			<?php
		}
		?>
		</form>
		</table>
		</center>
		<br/>
		<?php
	}
	//Button einfügen wenn eine Kategorie ausgwählt wurde
	if($ansicht==1){
	?>
	<b>Kategorieauswahl: <?php echo $kname; ?></b>
	<br/><br/>
	<form method="post" action="?flashgames">
	<input type="submit" value="Zurück zur Kategorieübersicht" name="buttonk"/>
	</form>
	<br/><br/>
	<?php
	}
	?>
	<hr>
	<?php
	//schleife zum auflisten der Spiele 
while($row=db_fetch_assoc($e_game_name)){
	$id = $row['fg_id'];
	$name = $row['fg_name'];
	$img = $row['fg_img'];
			
	if($ansicht==0||$ansicht==1){
	db_query("UPDATE	`prefix_flashgames`
			SET			`fg_bolactive`=NULL
	");
?>
	<hr>
	<table>
    <tr>
    <?php
	//wenn bild eingebunden wird oder nicht
	if(strlen($img)!=0){
	?>
	<td><p><img src="<?php echo $img; ?>" width="100" height="100" alt="pic"></p></td>
	<?php
	}
	else{
	?>
	<td width="100" />
	<?php
	}
	?>
	<td><b><?php echo $name; ?></b></td>
	<td><button style="background-color:transparent; border: none;" type="submit" name="submit-button" onclick="javascript: post_to_url('?flashgames',{'status':'update','gameid':'<?php echo $id; ?>'}, 'post' );" value="<?php $name; ?>"><?php $name; ?><img src="include/images/buttons/fg_button.png" alt="play"></button></td>
	</tr>
	</table>
<?php
	}
}
//wenn ein game ausgesucht wurde Button wächseln
if($ansicht==2){
?>
	<form method="post" action="?flashgames">
	<input type="submit" value="Zurück zur Gamesübersicht" name="buttong"/>
	</form>
	<br/><br/>
<?php
}

?>
	<hr>
<?php
//das Game einbauen wenn es ausgweählt wurde
if($control==1){ 
	if($row=db_fetch_assoc($e_game_link)){
		$link = $row['fg_link'];
?>
		<center>
		<object 
			width="600" 
			height="600" 
			align="middle" 
			id="flashgame" 
			codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
			<param value="<?php echo $link ?>" name="game">
			<param value="high" name="quality">
			<param value="window" name="wmode">
			<param value="false" name="allowfullscreen">
			<param value="" name="flashvars">
			<embed 
				width="600" 
				height="600" 
				align="middle" 
				pluginspage="http://www.adobe.com/go/getflashplayer" 
				type="application/x-shockwave-flash" 
				flashvars="" 
				allowfullscreen="false" 
				wmode="window" 
				name="flashgame" 
				quality="high" 
				src="<?php echo $link ?>">
		</object>
		</center>
<?php
	}
}
$design->footer();
?>

</body>
</html>