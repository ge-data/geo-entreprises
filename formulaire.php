<?php 

// ***********************************************************************//
//  
// ** Exemple d'appel du service Web pour récupérer une liste des activités et
// ** spécialités des géo-entreprises sous la forme de  <select>
// ** 
// ** @author   Webmaster <webmaster@ge-data.com.com>
// ** @date 2013-03-16
// ** @access   private
// ** @param    $selected = valeur selectionnée dans la liste (par défaut)
// ** @param    $options = options du champ
// ** @return   HTML
//      
// ***********************************************************************//



// ===========================================================================// 
// ! PARAMETRES A CHANGER AVEC VOS INFOMRATIONS UTILISATEUR  	      		  //        
// ===========================================================================//  
$login = ''; // nom d'utilisateur du service web (communiqué par email)
$password = ''; // mot de passe utilisateur service web (communiqué par email)
// ===================================	FIN =======================================// 
$selected = '';

// ===========================================================================// 
// ! CHEMIN VERS CLIENT XMLRPC A INCLURE                                       //        
// ===========================================================================// 
require_once('xmlrpc.inc');

/**
 *  Generer contrôle HTML zone de liste des activités
 */

$client = new xmlrpc_client('http://geo-entreprises.afigeo.asso.fr/xmlrpc/');

$message=new xmlrpcmsg('geoentreprises.getActivitesList',array(new xmlrpcval($login, 'string'),new xmlrpcval($password, 'string'),new xmlrpcval($count, 'boolean'),new xmlrpcval($selected, 'string')));
$resultat = $client->send($message);
if (!$resultat) 
{
     print "<p>Could not connect to HTTP server.</p>";
}
elseif ($resultat->faultCode())
{
    print "<p>XML-RPC Fault #" . $resultat->faultCode() . ": " .
    $resultat->faultString();
}

$resultvalue = php_xmlrpc_decode($resultat->value());


if(!empty($resultvalue)){
    $html = '<select name="activite" id="activite" onchange="submitFrm();">';
     $html .= '<option value=""></option>';
     for($x=0;$x<count($resultvalue);$x++){
         $html.= '<option value="'.$resultvalue[$x]['id'].'">'.$resultvalue[$x]['text'].'</option>';
         
     } 
     $html.='</select>';
}
/**
 *  Generer contrôle HTML zone de liste des spécialités
 */
$message=new xmlrpcmsg('geoentreprises.getSpecialitesList',array(new xmlrpcval($login, 'string'),new xmlrpcval($password, 'string'),new xmlrpcval($count, 'boolean'),new xmlrpcval($selected, 'string')));
$resultat = $client->send($message);
if (!$resultat) 
{
     print "<p>Could not connect to HTTP server.</p>";
}
elseif ($resultat->faultCode())
{
    print "<p>XML-RPC Fault #" . $resultat->faultCode() . ": " .
    $resultat->faultString();
}
//$resultvalue = $resultat->value();
$resultvalue2 = php_xmlrpc_decode($resultat->value());

if(!empty($resultvalue2)){
    $html2 = '<select name="specialite" id="specialite" onchange="submitFrm();">';
    $html2 .= '<option value=""></option>';
     for($y=0; $y<count($resultvalue2); $y++){
         $html2.= '<option value="'.$resultvalue2[$y]['id'].'">'.$resultvalue2[$y]['text'].'</option>';
     }
     $html2.='</select>';
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <script type="text/javascript">
            function submitFrm(){
                
                
            }
    
        </script>
    </head>
    <body>
        <h1>Recherche multicritères</h1>
        <form name="frmrecherche" action="rechercher.php" method="post" >
            <table>
                        
                    <tr>
                        <td width="200"><label>Login: </label</td>  
                        <td><input type="text" name="login" id="login" size="30" /></td>
                    </tr>
                    <tr>
                        <td width="200"><label>Mot de passe: </label></td>
                        <td><input type="password" name="password" id="password" value="cd5urad" size="30"/></td>
                    </tr>
                    <tr>
                        <td width="200"><label>Secteur d'activité</label></td>
                        <td><?php echo $html;?></td>
                    </tr>
                    <tr>
                        <td width="200"><label>Spécialité</label></td>
                        <td><?php echo $html2;?></td>
                    </tr>
                    <tr>
                        <td width="200"><label>Mot clef:</label> </td>
                        <td><input type="text" name="keyword" id="keyword" size="30" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><INPUT type="submit" value="rechercher"></td>
                    </tr>
            
            
        </form>
        
        
    </body>
</html>

