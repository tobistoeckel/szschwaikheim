<?php
	 function validate($post, &$messages, $anz_teilnehmer) {
    	
		$valid = TRUE;
		
		// Check Name, Vorname
		if($post['bestellname'] == "") {
			$valid = FALSE;
			$messages['bestellname'] = 'Bitte geben Sie Vor- und Nachname an.';
			}
				
			// Check Straße
			if($post['strasse'] == "") {
				$valid = FALSE;
				$messages['strasse'] = 'Bitte geben Sie Straße und Hausnummer an.';
			}
			
			// Check PLZ
			if(!preg_match('/^[0-9]*$/', $post['plz'])) {
				$valid = FALSE;
				$messages['plz'] = 'Die angegebene Postleitzahl enthält ungültige Zeichen. Die Postleitzahl darf nur aus Ziffern bestehen.';
			}
			
			// Check Telefon (geschäftl.)
			if(!preg_match('/^[0-9\+\(\)\ \-\/]*$/', $post['telgesch'])) {
				$valid = FALSE;
				$messages['telgesch'] = 'Die angegebene geschäftliche Telefonnummer enthält ungültige Zeichen. Telefonnummern dürfen nur die folgenden Zeichen enthalten: +-/() sowie Ziffern und Leerzeichen.';
			}
		
			// Check Telefon
			if(!preg_match('/^[0-9\+\(\)\ \-\/]+$/', $post['telpriv'])) {
				$valid = FALSE;
				$messages['telpriv'] = 'Bitte geben Sie eine gültige private Telefonnummer an. Telefonnummern dürfen nur die folgenden Zeichen enthalten: +-/() sowie Ziffern und Leerzeichen.';
			}
			
			// Check Telefon (mobil)
			if(!preg_match('/^[0-9\+\(\)\ \-\/]*$/', $post['telmob'])) {
				$valid = FALSE;
				$messages['telmob'] = 'Die angegebene Handynummer enthält ungültige Zeichen. Handynummern dürfen nur die folgenden Zeichen enthalten: +-/() sowie Ziffern und Leerzeichen.';
			}
			
			// Check Fax
			if(!preg_match('/^[0-9\+\(\)\ \-\/]*$/', $post['fax'])) {
				$valid = FALSE;
				$messages['fax'] = 'Die angegebene Faxnummer enthält ungültige Zeichen. Faxnummern dürfen nur die folgenden Zeichen enthalten: +-/() sowie Ziffern und Leerzeichen.';
			}
			
			// Check Mail
			if(!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$/', $post['mail'])) {
				$valid = FALSE;
				$messages['mail'] = 'Bitte geben Sie eine gültige E-Mail-Adresse an. Die E-Mail-Adresse wird für eventuelle Rückfragen benötigt. Sie erhalten außerdem an die angegebene E-Mail-Adresse eine Bestätigung dieser Anmeldung.';
			}
			
			// Check Jahr
			for ($i=0; $i<$anz_teilnehmer; $i++)
			{
				if($post["teilnname$i"] != "") {
					if($post["jahr$i"] == "") {
						$valid = FALSE;
						$messages["jahr$i"] = "Bitte geben Sie das Geburtsjahr von " . $post["teilnname$i"] . " an.";
					}
				}
			}
			
			// Check Betrag
			if($post['betrag'] == "") {
				$valid = FALSE;
				$messages['betrag'] = 'Bitte tragen Sie den korrekten Gesamtbetrag ein.';
			}
			return $valid;
    }
?>