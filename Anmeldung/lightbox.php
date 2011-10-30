<?php
	define('SUCCESS', 1);
	define('FAIL', 0);
	
   function lightbox($success, $messages) {
   	
		//create lightbox content
		$body = "";
		$class = "";
		$image = "";
		
		if($success) {
			$body='<h1>Übermittlung erfolgreich</h1>
			       <p>Ihre Anmeldung wurde erfolgreich entgegengenommen. Wir freuen uns, Sie auf unseren Ausfahrten begrüßen zu dürfen.</p>
			       <p>Eine Kopie der Anmeldung wurde Ihnen an die angegebene E-Mail-Adresse geschickt.</p>';
			$image="check.jpg";
			$class="success";
		}
		else {
			$body = '<h1>Übermittlung fehlgeschlagen</h1>
			         <p>Ihre Anmeldung konnte leider nicht entgegengenommen werden.</p>';
			foreach($messages as $message) {
				$body .= "<p>$message</p>";
			}
			$image="cross.jpg";
			$class="error";
		}
		
		// paint lightbox
		echo '<div id="light" class="white_content ' . $class . '">';
		echo '<div style="float:right;"><img src="' . $image . '" /></div>';
		echo $body;
		echo '<div class="close" onclick="document.getElementById(\'light\').style.display=\'none\'
															  document.getElementById(\'fade\').style.display=\'none\';">Schließen</div>
		     </div>
		     <div id="fade" class="black_overlay"></div>';
   }
?>