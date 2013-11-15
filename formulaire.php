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
// ! PARAMETRES A CHANGER AVEC VOS INFOMRATIONS UTILISATEUR		      		  //        
// ===========================================================================//  
$login = 'admin'; // nom d'utilisateur du service web (communiqué par email)
$password = 'cd5urad'; // mot de passe utilisateur service web (communiqué par email)
// ===================================	FIN =======================================// 
$selected = '';

$count = true; // 

// ===========================================================================// 
// ! CHEMIN VERS CLIENT XMLRPC A INCLURE                                       //        
// ===========================================================================// 
require_once('xmlrpc.inc');

/**
 *  Generer contrôle HTML zone de liste des activités
 */

//$client = new xmlrpc_client('http://geo-entreprises.afigeo.asso.fr/xmlrpc/');
$client = new xmlrpc_client('http://localhost/geoentreprisesprod/xmlrpc/');

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

/**
 * Generer control HTML zone de liste région
 * 
 */
$message=new xmlrpcmsg('geoentreprises.getRegionsList',array(new xmlrpcval($login, 'string'),new xmlrpcval($password, 'string'),new xmlrpcval($count, 'boolean'),new xmlrpcval($selected, 'string')));
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
$resultvalue3 = php_xmlrpc_decode($resultat->value());


if(!empty($resultvalue3)){
    $html3 = '<select name="region" id="region" onchange="submitFrm();">';
    $html3 .= '<option value=""></option>';
     for($y=0; $y<count($resultvalue3); $y++){
         $html3.= '<option value="'.$resultvalue3[$y]['id'].'">'.$resultvalue3[$y]['text'].'</option>';
     }
     $html3.='</select>';
}
/**
 * Generer control HTML zone de liste des départements
 * 
 */
$message=new xmlrpcmsg('geoentreprises.getDepartementsList',array(new xmlrpcval($login, 'string'),new xmlrpcval($password, 'string'),new xmlrpcval($count, 'boolean'),new xmlrpcval($selected, 'string')));
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
$resultvalue4 = php_xmlrpc_decode($resultat->value());


if(!empty($resultvalue4)){
    $html4 = '<select name="departement" id="departement" onchange="submitFrm();">';
    $html4 .= '<option value=""></option>';
     for($y=0; $y<count($resultvalue4); $y++){
         $html4.= '<option value="'.$resultvalue4[$y]['id'].'">'.$resultvalue4[$y]['text'].'</option>';
     }
     $html4.='</select>';
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
		<h1>Recherche multicritères - 1/ formulaire de recherche</h1>
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
                        <td width="200"><label>Région</label></td>
                        <td><?php echo $html3;?></td>
                    </tr>
                    <tr>
                        <td width="200"><label>Département</label></td>
                        <td><?php echo $html4;?></td>
                    </tr>
                    
                    <tr>
                        <td width="200"><label>Mot clef:</label> </td>
                        <td><input type="text" name="keyword" id="keyword" size="30" /></td>
                    </tr>
					<tr>
						<td width="200"><label>Limiter le nombre de résultats à (limit):</label> </td>
						<td><input type="text" name="limit" id="limit" size="30" /></td>
					</tr>
					<tr>
					    <td width="200"><label>Commencer la liste à (limitstart):</label> </td>
					    <td><input type="text" name="limitstart" id="limitstart" size="30" /></td>
					</tr>
                    <tr>
                        <td colspan="2" align="center"><INPUT type="submit" value="rechercher"></td>
                    </tr>
			</table>
        </form>
        
        
    </body>
</html>
