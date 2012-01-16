<?php
	require_once("formulardaten.php");
  require_once("postvariables.php");
	require_once("validation.php");
	require_once("submission.php");
	require_once("lightbox.php");
	
	$messages = array();
	
	function create_select($name, $values, $selected) {
		echo "<select name=\"$name\">";
		foreach($values as $value) {
			$item = "<option value=\"$value\" ";
			if(htmlentities($value, ENT_QUOTES) == $selected) {
				$item .= 'selected="selected" ';
			}
			$item .= ">$value</option>";
			echo $item;
		}
		echo "</select>";
	}
	
	function create_text_input($name, $value, $messages) {
	  $class = "";
		if(isset($messages[$name])) $class = "input_err";
		$input = '<input type="text" class="' . $class . '" name="' . $name . '" value ="' . $value . '" />';
		echo $input;
	}
?>

<?php echo '<?xml version="1.0" encoding="utf-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">

	<head>
		<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="lightbox.css" />
		<link rel="stylesheet" type="text/css" href="formular.css" />
		<title>Anmeldung</title>
	</head>

	<body>
		<?php
			
			// check if this is a submission request
			if (isset ($_POST['control'])) {
				
				// init
				$submit_success = FALSE;
				$valid          = FALSE;
				
				// inupt validation
				$valid = validate($_POST, $messages, $anz_teilnehmer);
				
				if($valid) {
					
					// create and send E-Mail
					$submit_success = submit($_POST, $messages, $empfaenger, $absender, $anz_teilnehmer);
				}
				
				// check if mail was submitted
				if($submit_success) {
					
					// paint success lightbox
					lightbox(SUCCESS, $messages);
					
					// clear post-array
					foreach($_POST as &$ref) {
						$ref="";
					}
				} else {
					
					// paint fail lightbox with messages
					lightbox(FAIL, $messages);
					
					// convert post-array to html entities
					foreach($_POST as &$ref) {
						$ref = htmlentities($ref, ENT_QUOTES, "UTF-8");
					}
				}
			}
		?>
		
		<h1>Anmeldung zu Ausfahrten der SZ Schwaikheim e.V.</h1>
		<form method="post" action="index.php" name="anmeldung" id="anmeldung">
			<fieldset>
				<legend>Kontaktinformationen</legend>
				<p class="info">(die mit * gekennzeichneten Felder sind Pflichtfelder)</p>
				<table>
					<tr>
						<td>Name, Vorname</td>
						<td><?php create_text_input("bestellname", $bestellname, $messages);?> *</td>
					</tr>
					<tr>
						<td>Straße</td>
						<td><?php create_text_input("strasse", $strasse, $messages);?> *</td>
					</tr>
					<tr>
						<td>Postleitzahl</td>
						<td><?php create_text_input("plz", $plz, $messages);?></td>
					</tr>
					<tr>
						<td>Ort</td>
						<td><?php create_text_input("ort", $ort, $messages);?></td>
					</tr>
					<tr>
						<td>Telefon (geschäftl.)</td>
						<td><?php create_text_input("telgesch", $telgesch, $messages);?></td>
					</tr>
					<tr>
						<td>Telefon (privat)</td>
						<td><?php create_text_input("telpriv", $telpriv, $messages);?> *</td>
					</tr>
					<tr>
						<td>Telefon (mobil)</td>
						<td><?php create_text_input("telmob", $telmob, $messages);?></td>
					</tr>
					<tr>
						<td>Fax</td>
						<td><?php create_text_input("fax", $fax, $messages);?></td>
					</tr>
					<tr>
						<td>E-Mail</td>
						<td><?php create_text_input("mail", $mail, $messages);?> *</td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend>Anmeldung zu Ausfahrt/Paket</legend>
					<table>
						<tr>
							<td rowspan="2">Buchung</td>
							<td>
								<?php
									create_select('buchung', $ausfahrten, $buchung);
								?>
							</td>
							<td>nach <?php create_text_input("nach", $nach, $messages);?></td>
						</tr>
						<tr>
							<td>
								<?php
									create_select('paket', $pakete, $paket);
								?>
							</td>
							<td>Ausfahrten Nr. <?php create_text_input("ausfahrtnr", $ausfahrtnr, $messages);?></td>
						</tr>
					</table>
			</fieldset>
			<fieldset>
				<legend>Teilnehmer</legend>
				<table>
					<tr>
						<td>Jahrgang *</td>
						<td>Name, Vorname</td>
						<td>Kursgruppe</td>
						<td>Mitglied</td>
						<td>Einstieg in</td>
					</tr>
					<?php
						for($i=0; $i<$anz_teilnehmer; $i++) {
							echo "<tr>";
							echo "   <td>"; create_text_input("jahr$i", $_POST["jahr$i"], $messages); echo "</td>";
							echo "   <td>"; create_text_input("teilnname$i", $_POST["teilnname$i"], $messages); echo "</td>";
							echo '   <td>';
							create_select("gruppe$i", $kursgruppen, $_POST["gruppe$i"]);
							echo "</td><td>";
							create_select("mitglied$i", $janein, $_POST["mitglied$i"]);
							echo '</td><td>';
							create_select("einstieg$i", $einstiegsorte, $_POST["einstieg$i"]);
							echo "</td></tr>";
						}
					?>
				</table>
			</fieldset>
			<fieldset>
				<legend>Mitteilungen an die Anmeldung</legend>
				<textarea cols="50" rows="10" wrap="soft" name="mitteilung"><?php echo $mitteilung; ?></textarea>
			</fieldset>
			<fieldset>
				<legend>Zahlung</legend>
				<p>Der Gesamtbetrag von € <?php create_text_input("betrag", $betrag, $messages);?> * wird rechtzeitig auf das Konto 829 791 000
				   der Skizunft Schwaikheim e.V. bei der Volksbank Stuttgart (BLZ 600 901 00) überwiesen.</p>
				<p>Eine Kopie dieses Formulars wird Ihnen per E-Mail zugeschickt.</p>
			</fieldset>
			<input name="control" id="control" type="text" style="display: none;" />
			<input type="submit" value="Anmeldung abschicken" /> <input type="reset" value="Formular zurücksetzen" />
		</form>
	</body>

</html>