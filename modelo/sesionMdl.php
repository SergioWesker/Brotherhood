<?php
	class sesionMdl
	{
		function correo(){
			
		                  	$to = "michelle.torres@corb.mx";
                        $subject = "Correo de prueba";
                        $message = "Este es sólo un mensaje de prueba.";
                        $from = "sergio06_20@sergiowesker.byethost22.com";
                        $headers = "From:" . $from; 
                        mail($to,$subject,$message,$headers);
                        echo "Correo enviado";
                    
		}
	}
?>	
