<?php
    function submit($post, &$messages, $to, $from, $anz_teilnehmer) {
    	
		// create E-Mail
		$to .= ", " . $post['mail'];
		//$to = $post['mail'];
		$subject = "Anmeldung zu Ausfahrten der SZ Schwaikheim e.V.";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		// Additional headers
		$headers .= 'From: ' . $from . "\r\n";
					
		$body = '
<html>
	
	<head>
		<title>Anmeldung zu Ausfahrten der SZ Schwaikheim e.V.</title>
	</head>
	
	<body>
		<p><b>Kontaktinformationen</b></p>
		<table border="1">
		';
		$body .= "<tr><td>Name, Vorname:</td><td>"        . $post['bestellname'] . "</td></tr>\n";
		$body .= "<tr><td>Straße:</td><td>"               . $post['strasse'] . "</td></tr>\n";
		$body .= "<tr><td>Postleitzahl:</td><td>"         . $post['plz'] . "</td></tr>\n";
		$body .= "<tr><td>Ort:</td><td>"                  . $post['ort'] . "</td></tr>\n";
		$body .= "<tr><td>Telefon (geschäftl.):</td><td>" . $post['telgesch'] . "</td></tr>\n";
		$body .= "<tr><td>Telefon (privat):</td><td>"     . $post['telpriv'] . "</td></tr>\n";
		$body .= "<tr><td>Telefon (mobil):</td><td>"      . $post['telmob'] . "</td></tr>\n";
		$body .= "<tr><td>Fax:</td><td>"                  . $post['fax'] . "</td></tr>\n";
		$body .= "<tr><td>E-Mail:</td><td>"               . $post['mail'] . "</td></tr></table>\n";
		$body .= "<p><b>Anmeldung zu Ausfahrt/Paket</b></p>\n<table border=\"1\">\n";
		$body .= "<tr><td rowspan=\"2\">Buchung:</td><td>" . $post['buchung'] . "</td><td>nach " . $post['nach'] . "</td></tr>\n";
		$body .= "<tr><td>" . $post['paket'] . "</td><td>Ausfahrten Nr. " . $post['ausfahrtnr'] . "</td></tr></table>\n";
		$body .= "<p><b>Teilnehmer</b></p>\n<table border=\"1\">\n";
		$body .= "<tr>\n<td><b>Jahrgang</b></td>\n<td><b>Name, Vorname</b></td>\n<td><b>Kursgruppe</b></td>\n<td><b>Mitglied</b></td>\n<td><b>Einstiegsort</b></td>\n</tr>\n";
		for($i=0; $i<$anz_teilnehmer; $i++) {
			$body .= "<tr>\n";
			$body .= "<td>" . $post['jahr' . $i] . "</td>\n";
			$body .= "<td>" . $post['teilnname' . $i] . "</td>\n";
			$body .= "<td>" . $post['gruppe' . $i] . "</td>\n";
			$body .= "<td>" . $post['mitglied' . $i] . "</td>\n";
			$body .= "<td>" . $post['einstieg' . $i] . "</td>\n";
			$body .= "</tr>\n";
		}
		$body .= "</table>\n<p><b>Mitteilungen an die Anmeldung:</b></p>\n";
		$body .= "<pre>" . $post['mitteilung'] . "</pre>\n";
		$body .= "<p><b>Zahlungsdaten</b></p>\n";
		$body .= "<p>Der Gesamtbetrag von € " . $post['betrag'] . " wird rechtzeitig auf das Konto 829 791 000 der Skizunft Schwaikheim e.V. bei der Volksbank Rems (BLZ 602 901 10) überwiesen.</p>";
		
		$body = wordwrap($body, 70);
		
		// submit
		$submit_success = mail($to, $subject, $body, $headers);
		if(!$submit_success) $messages['error'] = 'Ein interner Fehler ist aufgetreten, bitte entschuldigen Sie die Unannehmlichkeiten.';
		return $submit_success;
    }
?>