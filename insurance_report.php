<?php
session_start();

include("connectLangues.php");
include("connect.php");

$annee = date('Y').'-'.date('m').'-'.date('d');

$nomassu = $_GET['nomassu'];
$idassu = $_GET['idassu'];


	$comptAssuConsu=$connexion->query('SELECT *FROM assurances a ORDER BY a.id_assurance');
	
	$comptAssuConsu->setFetchMode(PDO::FETCH_OBJ);
			
	$assuCount = $comptAssuConsu->rowCount();
	
	for($i=1;$i<=$assuCount;$i++)
	{
		
		$getAssuConsu=$connexion->prepare('SELECT *FROM assurances a WHERE a.id_assurance=:idassu ORDER BY a.id_assurance');		
		$getAssuConsu->execute(array(
		'idassu'=>$idassu
		));
		
		$getAssuConsu->setFetchMode(PDO::FETCH_OBJ);

		if($ligneNomAssu=$getAssuConsu->fetch())
		{
			$presta_assu='prestations_'.strtolower($ligneNomAssu->nomassurance);
		}
	}

?>

<!doctype html>
<html lang="en">
<noscript>
Cette page requiert du Javascript.
Veuillez l'activer pour votre navigateur
</noscript>
<head>
	<title><?php echo 'INSURANCE REPORT';?></title>
	
	<link rel="icon" href="images/favicon.ico">
	<link rel="shortcut icon" href="images/favicon.ico" />
	
			<!-------------------barre de menu------------------->

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="source/cssmenu/styles.css">
	<link href="css/font-awesome/css/font-awesome.css" rel="stylesheet">
	
	<script src="script.js"></script>
			
			<!------------------------------------>
			
	<link href="css/form-signin.css" rel="stylesheet" type="text/css"><!--Le "div"==>account-container càd tt le formulaire-->
	
	<link href="css/patients1.css" rel="stylesheet" type="text/css" /><!--Header-->
	
	<link href="AdministrationSOMADO/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" /><!--Header-->
	<link href="AdministrationSOMADO/css/style.css" rel="stylesheet" type="text/css"><!--Header-->
	
		<!-------------------calendrier------------------->
	
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="calender/design.css" />
	<script type="text/javascript" src="calender/calendrier.js"></script>	
	<link href="css/form-signin.css" rel="stylesheet" type="text/css">

	
	<link rel="stylesheet" type="text/css" href="cssPagination/pagination.css" />
	<link rel="stylesheet" href="cssPagination/layout.css" type="text/css" media="screen" />
	<script src="myQuery.js"></script>
	<script type="text/javascript">

function controlFormCustom(theForm){
	var rapport="";
	
	rapport +=controlDateDebut(theForm.customdatedebutPerso);
	rapport +=compareDateDebuFin(theForm.customdatedebutPerso,theForm.customdatefinPerso);
	// rapport +=compareHeures(theForm.heurerdvDebut,theForm.heurerdvFin,theForm.minrdvDebut,theForm.minrdvFin);
	
		if (rapport != "") {
		alert("Check error please :\n" + rapport);
					return false;
		 }
}

function controlDateDebut(fld){
	var erreur="";
	//var illegalChar=/[\(\)\<\>\,\;\:\\\"\[\]\/\à\{\}]/;
	
	if(fld.value.trim()==""){
		erreur="Begining date";
		fld.style.background="cyan";
	}
	return erreur;	
} 

function compareDateDebuFin(fld1,fld2){
	var erreur="";
	var dateDebut=fld1.value;
	var dateFin=fld2.value;
	

	if(dateFin != "")
	{
		if(dateDebut>dateFin)
		{
			fld1.style.background='yellow';
			fld2.style.background='yellow';
			
			erreur="\nInvalid Search\n Check the dates input\n";
		}
	}

	return erreur;	
}


</script>

	<style type="text/css">

	@media print {
	  
		.az
		{
			display:none;
		}

		.buttonBill
		{ 
			display:none;
			
		}
	}
	
	</style>
</head>

<body>
<?php

$id=$_SESSION['id'];

$sqlA=$connexion->query("SELECT *FROM coordinateurs c WHERE c.id_u='$id'");

$comptidA=$sqlA->rowCount();

// echo $_SESSION[''];

$connect=$_SESSION['connect'];
$status=$_SESSION['status'];

if($connect==true AND $comptidA!=0)
{
	if($status==1)
	{
?>

<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<img src="images/logo_large.png" class="brand" />	
			
			<div class="nav-collapse">
			
				<ul class="nav pull-right">
				<li class="">			
					<form method="post" action="insurance_report.php?<?php if(isset($_GET['nomassu'])){ echo '&nomassu='.$_GET['nomassu'];}if(isset($_GET['insugnlreport'])){ echo '&insugnlreport='.$_GET['insugnlreport'];}if(isset($_GET['idassu'])){ echo '&idassu='.$_GET['idassu'];}if(isset($_GET['english'])){ echo 'english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo 'francais='.$_GET['francais'];}}?>" onsubmit="return controlFormPassword(this)">
					
					<span style="color:#333;padding-top:4px;vertical-align:middle;"><?php echo getString(24);?><?php echo ' '.$_SESSION['nom'].' '.$_SESSION['prenom'];?></span>
					
					<a href="deconnect.php?<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn"><?php echo getString(25);?></a>
					
					<?php
					if($langue == 'francais')
					{
					?>
						<a href="insurance_report.php?english=english<?php if(isset($_GET['report'])){ echo '&report='.$_GET['report'];}if(isset($_GET['audit'])){ echo '&audit='.$_GET['audit'];}if(isset($_GET['nomassu'])){ echo '&nomassu='.$_GET['nomassu'];}if(isset($_GET['insugnlreport'])){ echo '&insugnlreport='.$_GET['insugnlreport'];}if(isset($_GET['idassu'])){ echo '&idassu='.$_GET['idassu'];}?>" class="btn"><?php echo getString(30);?></a>
					<?php
					}else{
					?>
						<a href="insurance_report.php?francais=francais<?php if(isset($_GET['report'])){ echo '&report='.$_GET['report'];}if(isset($_GET['audit'])){ echo '&audit='.$_GET['audit'];}if(isset($_GET['nomassu'])){ echo '&nomassu='.$_GET['nomassu'];}if(isset($_GET['insugnlreport'])){ echo '&insugnlreport='.$_GET['insugnlreport'];}if(isset($_GET['idassu'])){ echo '&idassu='.$_GET['idassu'];}?>" class="btn"><?php echo getString(29);?></a>
					<?php
					}					
					?>
						<br/>						
					
						<input type="text" name="Pass" id="Pass" placeholder="<?php echo getString(26);?>" style="margin-top:10px;margin-bottom:0;height:20px;"/>
						
						<input type="submit" name="confirmPass" id="confirmPass" class="btn"  value="<?php echo getString(27);?>"/>
						
					</form>
				</li>	
				</ul>
			</div><!--/.nav-collapse -->
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div><br><br><br><br><br>

<?php
if(isset($_SESSION['codeC']))
{
?>
	<div style="text-align:center;margin-top:20px;">
		
		<a href="report.php?coordi=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn-large" name="savebtn" style="font-size:20px;height:40px; padding:10px 40px;margin-right:10px;">
			<?php echo 'Reports';?>
		</a>

		<a href="facturesedit.php?codeCoord=<?php echo $_SESSION['codeC'];?><?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn-large-inversed" name="billListbtn" style="font-size:20px;height:40px; padding:10px 40px;">
			<?php echo 'Factures';?>
		</a>
	
	</div>
	
<?php
}
?>

<div class="account-container" style="width:90%; text-align:center;">

	<div id='cssmenu' style="text-align:center;margin-bottom:10px;" class="menu">

		<ul>
			<li style="width:50%;"><a onclick="ShowList('Users')" style="margin-right:5px;" data-title="<?php echo getString(48);?>"><i class="fa fa-users fa-1x fa-fw"></i> <?php echo getString(48);?></a></li>
			
				<?php
		$lu=0;
        $selectmsg=$connexion->prepare("SELECT * FROM messages WHERE lu=:lu AND receiverId=:receiverId");
        $selectmsg->execute(array("lu"=>$lu,"receiverId"=>$_SESSION['id']));
        $selectmsg->setFetchMode(PDO::FETCH_OBJ);
        $lignecount=$selectmsg->rowCount();
        /*echo $_SESSION['id'];*/
        /*echo $lignecount;*/
		?>
		<style type="text/css">.badge{background: black;}.badge2{background: rgb(160, 0, 0);}</style>
		<?php if($lignecount!=0){?>
		<li style="width:50%;"><a onclick="ShowList('Msg')" style="margin-left:5px;" data-title="<?php echo getString(49);?> || Unread messages: <?php echo $lignecount; ?>"><i class="fa fa-envelope fa-lg fa-fw"></i> <?php echo getString(49);?> <i class="badge flashing"><?php echo $lignecount; ?></i> </a></li>
        <?php }else{?>
        	<li style="width:50%;"><a onclick="ShowList('Msg')" style="margin-left:5px;" data-title="<?php echo getString(49);?>"><i class="fa fa-envelope fa-lg fa-fw"></i> <?php echo getString(49);?></a></li>
        <?php }?>
			
		</ul>

		<ul style="margin-top:20px;background:none;border:none;">

			<div id="divMenuUser" style="display:inline-block;">
			
				<a href="utilisateurs.php?<?php if(isset($_GET['english'])){ echo 'english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo 'francais='.$_GET['francais'];}}?>" class="btn-large" id="newUser" style="display:none;"><i class="fa fa-user-plus fa-lg fa-fw"></i> <?php echo getString(87);?></a>
			
				<a onclick="ShowList('Liste')" id="listOn" class="btn-large" style="display:none;"><i class="fa fa-eye fa-lg fa-fw"></i> <?php echo getString(55);?></a>
				
				<span onclick="ShowList('ListeNon')" id="listOff" class="btn-large" style="display:none;"><i class="fa fa-eye-slash fa-lg fa-fw"></i> <?php echo getString(56);?></span>
			
			</div>

		</ul>
			
				<div style="display:none;" id="divMenuMsg">

					<a href="messages.php?ecrire=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn-large" name="newMsg" id="EnvoiMsg"><i class="fa fa-pencil fa-lg fa-fw"></i> <?php echo getString(57);?></a>
					
					<?php if($lignecount!=0){?>
                <a href="messages.php?recu=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" id="MsgRecu" class="btn-large" onclick="ShowList('MsgRecu')" ><i class="fa fa-arrow-down fa-lg fa-fw"></i> <?php echo getString(58);?> <i class="badge flashing"><?php echo $lignecount; ?></i></a>
        <?php }else{?>
                <a href="messages.php?recu=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" id="MsgRecu" class="btn-large" onclick="ShowList('MsgRecu')" ><i class="fa fa-arrow-down fa-lg fa-fw"></i> <?php echo getString(58);?></a>
        <?php }?>
					
					<a href="messages.php?envoye=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" id="MsgEnvoye" class="btn-large" onclick="ShowList('MsgEnvoye')" ><i class="fa fa-arrow-up fa-lg fa-fw"></i><?php echo getString(59);?></a>

				</div>
			
			<div style="display:none;margin-top:50px;" id="divListe" align="center">

				<br/>

				<a href="patients1.php?iduser=<?php echo $_SESSION['id'];?>&listPa=1<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn"><?php echo getString(20);?></a>
				
				<a href="medecins1.php?iduser=<?php echo $_SESSION['id'];?><?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn"><?php echo getString(19);?></a>
				
				<a href="infirmiers1.php?iduser=<?php echo $_SESSION['id'];?><?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn"><?php echo getString(21);?></a>
				
				<a href="laborantins1.php?iduser=<?php echo $_SESSION['id'];?><?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn"><?php echo getString(22);?></a>
				
				<a href="radiologues1.php?iduser=<?php echo $_SESSION['id'];?><?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn"><?php echo 'Radiologue';?></a>
				
				<a href="receptionistes1.php?iduser=<?php echo $_SESSION['id'];?><?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn"><?php echo getString(40);?></a>
				
				<a href="caissiers1.php?iduser=<?php echo $_SESSION['id'];?><?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn"><?php echo getString(23);?></a>
				
				<a href="coordinateurs1.php?iduser=<?php echo $_SESSION['id'];?><?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" class="btn"><?php echo 'Manager';?></a>
				
			</div>
		
	</div>
	
	<?php
	
	if(isset($_GET['num']))
	{
		
		$result=$connexion->prepare('SELECT *FROM utilisateurs u, patients p WHERE p.numero=:operation AND u.id_u=p.id_u');
		$result->execute(array(
		'operation'=>$_GET['num']	
		));
		$result->setFetchMode(PDO::FETCH_OBJ);
		
		
		if($ligne=$result->fetch())
		{
			$numPa=$ligne->numero;
			$fullname=$ligne->full_name;
			$sexe=$ligne->sexe;
			$dateN=$ligne->date_naissance;
			$adresse=$ligne->province.','.$ligne->district.','.$ligne->secteur;
			$profession=$ligne->profession;
							
			$old=$dateN[0].''.$dateN[1].''.$dateN[2].''.$dateN[3].'	';//reçoit l'année de naissance
			$month=$dateN[5].''.$dateN[6].'	';//reçoit le mois de naissance

			$an= date('Y')-$old.'	';//recupere l'âge en année
			$mois= date('m')-$month.'	';//recupere l'âge en mois

			if($mois<0)
			{
				$an= ($an-1).' ans	'.(12+$mois).' mois';
				// echo $an= $an-1;

			}else{

				$an= $an.' ans';
				//$an= $an.' ans	'.(date('m')-$month).' mois';// X ans Y mois
				// echo $mois= date('m')-$month;
			}

	?>
			<table style="margin:auto;">
				<tr>
					<td style="font-size:18px; width:33.333%;" id="persobillingstring">
						<b><h2>Individual Report</h2></b>
					</td>
				</tr>
			</table>
			
			<table cellpadding=3 style="background:#fff; border:1px solid #eee; border-radius:4px; margin:auto auto 10px auto; padding: 10px; width:80%;">
				<tr>
					<td style="font-size:18px; text-align:center; width:33.333%;">
						<span style="font-weight:bold;"><?php echo getString(89) ?> : </span></span><?php echo $fullname;?>
					</td>
					
					<td style="font-size:18px; text-align:center; width:33.333%;">
						<span style="font-weight:bold;"><?php echo getString(11) ?> : </span>
						<?php
						if($ligne->sexe=="M")
						{
							$sexe = "Male";
						}elseif($ligne->sexe=="F"){					
							$sexe = "Female";
						}else{
							$sexe="";
						}
						
						echo $sexe;
						?>
					</td>
					
					<td style="font-size:18px; text-align:center; width:33.333%;">
						<span style="font-weight:bold;">Age : </span><?php echo $an;?>
					</td>
				</tr>
				
				<tr>
					<td></td>
				</tr>
			</table>
		
		<?php 
		}
		?>
		
		<table cellpadding=3 style="margin:auto auto 10px auto; padding: 10px; width:80%;">
			<tr>
				<td style="font-size:18px; text-align:center; width:33.333%;"></td>
				
				<td style="font-size:18px; text-align:center; width:33.333%;">					
					<a href="insurance_report.php?num=<?php echo $_GET['num'];?>&audit=<?php echo $_SESSION['id'];?>&report=ok&selectPersoBill=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" style="text-align:center">
					
						<button id="persoBillReport" class="btn-large" onclick="ShowDivReport('divPersoBillReport')">Billing Report</button>
						
					</a>
					
				</td>
				
				<td style="font-size:18px; text-align:right; width:33.333%;">
					
					<a href="reportPrint.php?num=<?php echo $_GET['num'];?>&audit=<?php echo $_SESSION['id'];?>&divPersoMedicReport=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" style="text-align:center;display:none" id="medicalpersopreview">
					
						<button style="width:250px; margin:auto;" type="submit" name="printbill" id="printbill" class="btn-large-inversed">
							<i class="fa fa-desktop fa-lg fa-fw"></i> <?php echo getString(148);?>
						</button>
					
					</a>
			
					<?php
			
					$resultBillReport=$connexion->prepare('SELECT *FROM bills b WHERE b.numero=:numPa');		
					
					$resultBillReport->execute(array(
						'numPa'=>$num
					));
					
					$resultBillReport->setFetchMode(PDO::FETCH_OBJ);//on veut que le résultat soit récupérable sous forme d'objet

					$comptBillReport=$resultBillReport->rowCount();

					if($comptBillReport!=0)
					{
					?>
					<a href="reportPrint.php?num=<?php echo $_GET['num'];?>&audit=<?php echo $_SESSION['id'];?>&divPersoBillReport=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" style="text-align:center;display:none" id="billingpersopreview">
					
						<button style="width:250px; margin:auto;" type="submit" name="printbill" id="printbill" class="btn-large-inversed">
							<i class="fa fa-desktop fa-lg fa-fw"></i> <?php echo getString(148);?>
						</button>
					</a>
					<?php
					}
					?>
					
			
				</td>
			</tr>
			
		</table>
		<?php
		if(isset($_GET['selectPersoBill']))
		{
		?>
		<div id="selectdatePersoBillReport">
		
			<form action="insurance_report.php?num=<?php echo $_GET['num'];?>&audit=<?php echo $_SESSION['id'];?>&report=ok&dmacbillperso=ok&selectPersoBill=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>" method="post" style="margin:auto;padding:5px;width:90%;">
			
				<table id="dmacbillperso">
					<tr>
						<td>
							<span style="text-align:center;" id="dailybtn" onclick="ShowSelectreport('dailybillPerso')" class="btn-large">Daily</span>
						</td>
						
						<td>
							<span style="text-align:center;" id="monthlybtn" onclick="ShowSelectreport('monthlybillPerso')" class="btn-large">Monthly</span>
						</td>
						
						<td>
							<span style="text-align:center;" id="annualybtn" onclick="ShowSelectreport('annualybillPerso')" class="btn-large">Annualy</span>
						</td>
						
						<td>
							<span style="text-align:center;" id="custombtn" onclick="ShowSelectreport('custombillPerso')" class="btn-large">Custom</span>
						</td>
						
					</tr>
					
					<tr>
					
						<td id="dailybillPerso" style="visibility:hidden">Select date
							<input type="text" id="dailydatebillPerso" name="dailydatebillPerso" onclick="ds_sh(this);" value=""/>
						
							<input type="submit"  name="searchdailybillPerso" value="Search" class="btn-large" style="width:150px"/>
						</td>
						
						<td id="monthlybillPerso" style="visibility:hidden">Select Month
						
							<select name="monthlydatebillPerso" id="monthlydatebillPerso">
							
								<option value='1'>January</option>
								<option value='2'>February</option>
								<option value='3'>March</option>
								<option value='4'>April</option>
								<option value='5'>May</option>
								<option value='6'>June</option>
								<option value='7'>July</option>
								<option value='8'>August</option>
								<option value='9'>September</option>
								<option value='10'>October</option>
								<option value='11'>November</option>
								<option value='12'>December</option>
							
							</select>
							
							<br/>
							
							Select Year <select name="monthlydatebillPersoYear" id="monthlydatebillPersoYear">
							<?php 
							for($i=2016;$i<=2030;$i++)
							{
							?>
								<option value='<?php echo $i;?>'><?php echo $i;?></option>
							<?php 
							}
							?>
							</select>
							
							<input type="submit"  name="searchmonthlybillPerso" value="Search" class="btn-large" style="width:150px"/>
							
						</td>
						
						<td id="annualybillPerso" style="visibility:hidden">Select Year
						
							<select name="annualydatebillPerso" id="annualydatebillPerso">
							<?php 
							for($i=2016;$i<=2030;$i++)
							{
							?>
								<option value='<?php echo $i;?>'><?php echo $i;?></option>
							<?php 
							}
							?>
							</select>
						
							<input type="submit"  name="searchannualybillPerso" value="Search" class="btn-large" style="width:150px"/>
						</td>
						
						<td id="custombillPerso" style="visibility:hidden">
						
							<table>
								<tr>
									<td>From</td>
									<td>
										<input type="text" id="customdatedebutbillPerso" name="customdatedebutbillPerso" onclick="ds_sh(this);" value=""/>
									</td>
								</tr>
								<tr>
									<td>To</td>
									<td>
										<input type="text" id="customdatefinbillPerso" name="customdatefinbillPerso" onclick="ds_sh(this);" value=""/>
									</td>
								</tr>
								
								<tr>
									<td></td>
									<td>
										<input type="submit"  name="searchcustombillPerso" value="Search" class="btn-large" style="width:150px"/>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				
				</table>

			</form>
			
		</div>
			
		<?php
		}
		?>
			<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
				<tr>
					<td style="padding:5px;" id="ds_calclass"></td>
				</tr>
			</table>
		<?php
		
		if(isset($_GET['dmacbillperso']) OR isset($_GET['selectPersoBill']))
		{
			$dailydateperso = "";
			$paVisit="gnlPersoBill";
			
			if(isset($_POST['searchdailybillPerso']))
			{
				if(isset($_POST['dailydatebillPerso']))
				{
					$dailydateperso = 'AND datebill LIKE \''.$_POST['dailydatebillPerso'].'%\'';
					
					$paVisit="dailyPersoBill";
				
				}else{
					$dailydateperso = "";
					$paVisit="gnlPersoBill";
				
				}

			}
			
			if(isset($_POST['searchmonthlybillPerso']))
			{
				if(isset($_POST['monthlydatebillPerso']) AND isset($_POST['monthlydatebillPersoYear']))
				{
					$ukwezi = $_POST['monthlydatebillPerso'];
					$umwaka = $_POST['monthlydatebillPersoYear'];
				
					$daysmonth= cal_days_in_month(CAL_GREGORIAN,$ukwezi,$umwaka);
					$paVisit="monthly";
					
					$dailydateperso = 'AND datebill>=\''.$umwaka.'-'.$ukwezi.'-1\' AND datebill<=\''.$umwaka.'-'.$ukwezi.'-'.$daysmonth.'\'';
			
					$paVisit="monthlyPersoBill";
					
				}else{
					$dailydateperso = "";
					$paVisit="gnlPersoBill";
				
				}

			}
			
			if(isset($_POST['searchannualybillPerso']))
			{
				if(isset($_POST['annualydatebillPerso']))
				{
					$year = $_POST['annualydatebillPerso'];
					
					$dailydateperso = 'AND datebill>=\''.$year.'-01-01\' AND datebill<=\''.$year.'-12-31\'';
					$paVisit="annualyPersoBill";
			
				}else{
					$dailydateperso = "";
					$paVisit="gnlPersoBill";
				
				}
			
			}
			
			if(isset($_POST['searchcustombillPerso']))
			{
				if(isset($_POST['customdatedebutbillPerso']) AND isset($_POST['customdatefinbillPerso']))
				{
					$debut = $_POST['customdatedebutbillPerso'];
					$fin = $_POST['customdatefinbillPerso'];
				
					// $daysmonth= cal_days_in_month(CAL_GREGORIAN,$ukwezi,$umwaka);
					
					$dailydateperso = 'AND datebill>=\''.$debut.'\' AND datebill<=\''.$fin.'\'';
					$paVisit="customPersoBill";
			
				}else{
					$dailydateperso = "";
					$paVisit="gnlPersoBill";
				
				}

			}
			
				// echo $dailydateperso; 
				// echo $ukwezi.' et '.$year;
				// echo $year;
		
		?>
		
			<div id="dmacBillReport" style="display:inline">
				
				<a href="dmacinsurance_report.php?num=<?php echo $_GET['num'];?>&dailydateperso=<?php echo $dailydateperso;?>&divPersoBillReport=ok&paVisit=<?php echo $paVisit;?>&nomassu=<?php echo $nomassu;?>&idassu=<?php echo $idassu;?>&createRN=1" style="text-align:center" id="dmacbillpersopreview">
					
					<button style="width:250px; margin:auto;" type="submit" name="printbill" id="printbill" class="btn-large-inversed">
						<i class="fa fa-desktop fa-lg fa-fw"></i> Preview print
					</button>
				
				</a>
				<?php
				
				$resultBillReport=$connexion->prepare('SELECT *FROM bills b WHERE b.numero=:numPa '.$dailydateperso.'');		
				
				$resultBillReport->execute(array(
					'numPa'=>$num
				));
				
				$resultBillReport->setFetchMode(PDO::FETCH_OBJ);//on veut que le résultat soit récupérable sous forme d'objet

				$comptBillReport=$resultBillReport->rowCount();

				if($comptBillReport!=0)
				{
				?>
				<table class="tablesorter tablesorter3" cellspacing="0" style="background:#fff; width:80%; margin-top:10px;"> 
							
					<thead>
						<tr>
							<th>N°</th>
							<th>Date</th>
							<th>Bill number</th>
							<th>Insurance</th>
							<th><?php echo getString(113);?></th>
							<th><?php echo getString(39);?>s</th>
							<th><?php echo getString(98);?></th>
							<th><?php echo getString(99);?></th>
							<th>Total Final</th>
						</tr> 
					</thead> 
					
					<tbody>
				<?php
				$TotalGnlTypeConsu=0;
				$TotalGnlMedConsu=0;
				$TotalGnlMedInf=0;
				$TotalGnlMedLabo=0;
				$TotalGnlPrice=0;
				
				$compteur=1;
				
					while($ligneBillReport=$resultBillReport->fetch())//on recupere la liste des éléments
					{
				?>
				
						<tr style="text-align:center;">
							<td><?php echo $compteur;?></td>
							<td><?php echo $ligneBillReport->datebill;?></td>
							<td><?php echo $ligneBillReport->numbill;?></td>
							<td><?php echo $ligneBillReport->nomassurance.' '.$ligneBillReport->billpercent.' %';?></td>
							<td><?php echo $ligneBillReport->totaltypeconsuprice;?></td>
							<td><?php echo $ligneBillReport->totalmedconsuprice;?></td>
							<td><?php echo $ligneBillReport->totalmedinfprice;?></td>
							<td><?php echo $ligneBillReport->totalmedlaboprice;?></td>
							<td><?php echo $ligneBillReport->totalgnlprice;?></td>
						</tr>
				<?php
						$TotalGnlTypeConsu=$TotalGnlTypeConsu + $ligneBillReport->totaltypeconsuprice;
						$TotalGnlMedConsu= $TotalGnlMedConsu + $ligneBillReport->totalmedconsuprice;
						$TotalGnlMedInf= $TotalGnlMedInf + $ligneBillReport->totalmedinfprice;
						$TotalGnlMedLabo=$TotalGnlMedLabo + $ligneBillReport->totalmedlaboprice;
						$TotalGnlPrice=$TotalGnlPrice + $ligneBillReport->totalgnlprice;
						
						$compteur++;
					}
				?>
						<tr style="text-align:center;">
							<td></td>
							<td></td>
							<td></td>
							<td style="font-size: 13px; font-weight: bold;">
								<?php						
									echo $TotalGnlTypeConsu;
									
								?><span style="font-size:80%; font-weight:normal;">Rwf</span>
							</td>
							<td style="font-size: 13px; font-weight: bold;">
								<?php						
									echo $TotalGnlMedConsu;
									
								?><span style="font-size:80%; font-weight:normal;">Rwf</span>
							</td>
							<td style="font-size: 13px; font-weight: bold;">
								<?php						
									echo $TotalGnlMedInf;
									
								?><span style="font-size:80%; font-weight:normal;">Rwf</span>
							</td>
							<td style="font-size: 13px; font-weight: bold;">
								<?php						
									echo $TotalGnlMedLabo;
									
								?><span style="font-size:80%; font-weight:normal;">Rwf</span>
							</td>
							<td style="font-size: 13px; font-weight: bold;">
								<?php						
									echo $TotalGnlPrice;
									
								?><span style="font-size:80%; font-weight:normal;">Rwf</span>
							</td>
						</tr>
					</tbody>
				</table>
				<?php
				}else{
				?>
					<table class="tablesorter tablesorter4" cellspacing="0" style="background:#fff; width:100%; margin-top:10px;"> 
								
						<thead>
							<tr>
								<th style="width:12%;text-align:center">No Report for this patient</th>
							</tr> 
						</thead> 
					</table> 
					
				<?php
				}
				?>
			</div>
		<?php
		}
		?>
		
				
	<div style="overflow:auto;height:500px;background-color:none;">
			
		<div id="divPersoBillReport" style="display:inline">
			
			<?php
			
			$resultBillReport=$connexion->prepare('SELECT *FROM bills b WHERE b.numero=:numPa');		
			
			$resultBillReport->execute(array(
				'numPa'=>$num
			));
			
			$resultBillReport->setFetchMode(PDO::FETCH_OBJ);//on veut que le résultat soit récupérable sous forme d'objet

			$comptBillReport=$resultBillReport->rowCount();

			if($comptBillReport!=0)
			{
			?>
			<table class="tablesorter tablesorter3" cellspacing="0" style="background:#fff; width:80%; margin-top:10px;"> 
						
				<thead>
					<tr>
						<th>N°</th>
						<th>Date</th>
						<th>Bill number</th>
						<th>Insurance</th>
						<th><?php echo getString(113);?></th>
						<th><?php echo getString(39);?>s</th>
						<th><?php echo getString(98);?></th>
						<th><?php echo getString(99);?></th>
						<th>Total Final</th>
					</tr> 
				</thead> 
				
				<tbody>
			<?php
			$TotalGnlTypeConsu=0;
			$TotalGnlMedConsu=0;
			$TotalGnlMedInf=0;
			$TotalGnlMedLabo=0;
			$TotalGnlPrice=0;
			
			$compteur=1;
			
				while($ligneBillReport=$resultBillReport->fetch())//on recupere la liste des éléments
				{
			?>
			
					<tr style="text-align:center;">
						<td><?php echo $compteur;?></td>
						<td><?php echo $ligneBillReport->datebill;?></td>
						<td><?php echo $ligneBillReport->numbill;?></td>
						<td><?php echo $ligneBillReport->nomassurance.' '.$ligneBillReport->billpercent.' %';?></td>
						<td><?php echo $ligneBillReport->totaltypeconsuprice;?></td>
						<td><?php echo $ligneBillReport->totalmedconsuprice;?></td>
						<td><?php echo $ligneBillReport->totalmedinfprice;?></td>
						<td><?php echo $ligneBillReport->totalmedlaboprice;?></td>
						<td><?php echo $ligneBillReport->totalgnlprice;?></td>
					</tr>
			<?php
					$TotalGnlTypeConsu=$TotalGnlTypeConsu + $ligneBillReport->totaltypeconsuprice;
					$TotalGnlMedConsu= $TotalGnlMedConsu + $ligneBillReport->totalmedconsuprice;
					$TotalGnlMedInf= $TotalGnlMedInf + $ligneBillReport->totalmedinfprice;
					$TotalGnlMedLabo=$TotalGnlMedLabo + $ligneBillReport->totalmedlaboprice;
					$TotalGnlPrice=$TotalGnlPrice + $ligneBillReport->totalgnlprice;
					
					$compteur++;
				}
			?>
					<tr style="text-align:center;">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-size: 13px; font-weight: bold;">
							<?php						
								echo $TotalGnlTypeConsu;
								
							?><span style="font-size:80%; font-weight:normal;">Rwf</span>
						</td>
						<td style="font-size: 13px; font-weight: bold;">
							<?php						
								echo $TotalGnlMedConsu;
								
							?><span style="font-size:80%; font-weight:normal;">Rwf</span>
						</td>
						<td style="font-size: 13px; font-weight: bold;">
							<?php						
								echo $TotalGnlMedInf;
								
							?><span style="font-size:80%; font-weight:normal;">Rwf</span>
						</td>
						<td style="font-size: 13px; font-weight: bold;">
							<?php						
								echo $TotalGnlMedLabo;
								
							?><span style="font-size:80%; font-weight:normal;">Rwf</span>
						</td>
						<td style="font-size: 13px; font-weight: bold;">
							<?php						
								echo $TotalGnlPrice;
								
							?><span style="font-size:80%; font-weight:normal;">Rwf</span>
						</td>
					</tr>
				</tbody>
			</table>
			<?php
			}else{
			?>
				<table class="tablesorter tablesorter4" cellspacing="0" style="background:#fff; width:100%; margin-top:10px;"> 
							
					<thead>
						<tr>
							<th style="width:12%;text-align:center">No Report for this patient</th>
						</tr> 
					</thead> 
				</table> 
				
			<?php
			}
			?>
		</div>
		
	</div>
	<?php
	}
	
	if(isset($_GET['insugnlreport']))
	{
	?>
		<table style="margin:auto;">
			<tr>
				<td style="font-size:18px; width:33.333%;" id="gnlbillstring">
					<b><h2><?php echo $_GET['nomassu'];?> Report</h2></b>
				</td>
			</tr>
		</table>
		
		<?php
		if(isset($_GET['selectPersoBill']))
		{
		?>
		<div id="selectdatePersoBillReport">
		
			<form action="insurance_report.php?num=<?php echo $_GET['num'];?>&audit=<?php echo $_SESSION['id'];?>&report=ok&dmacbillperso=ok&selectPersoBill=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>&insugnlreport=ok&nomassu=<?php echo $_GET['nomassu'];?>" method="post" style="margin:auto;padding:5px;width:90%;">
			
				<table id="dmacbillperso" style="margin:auto auto 20px">
					<tr style="display:inline-block; margin-bottom:25px;">
						<td>
							<span style="text-align:center;width:100px;" id="dailybtn" onclick="ShowSelectreport('dailybillPerso')" class="btn">Daily</span>
						</td>
						
						<td>
							<span style="text-align:center;width:100px;" id="monthlybtn" onclick="ShowSelectreport('monthlybillPerso')" class="btn">Monthly</span>
						</td>
						
						<td>
							<span style="text-align:center;width:100px;" id="annualybtn" onclick="ShowSelectreport('annualybillPerso')" class="btn">Annualy</span>
						</td>
						
						<td>
							<span style="text-align:center;width:100px;" id="custombtn" onclick="ShowSelectreport('custombillPerso')" class="btn">Custom</span>
						</td>
						
						<td>
						<?php
						if(isset($_GET['selectGnlBill']))
						{
						?>
							<a href="insurance_report.php?nomassu=<?php echo $nomassu;?>&idassu=<?php echo $idassu;?>&insugnlreport=ok" id="nomassurance" style="text-align:center;width:100px;" class="btn">Full Report</a></a>
						<?php
						}
						?>
						</td>
					</tr>
					
					<tr style="visibility:visible">
					
						<td id="dailybillPerso" style="display:none">Select date
							<input type="text" id="dailydatebillPerso" name="dailydatebillPerso" onclick="ds_sh(this);" value=""/>
						
							<button type="submit" name="searchdailybillPerso" class="btn-large-inversed" style="width:auto;vertical-align:top;height:38px;">Search</button>
						</td>
						
						<td id="monthlybillPerso" style="display:none">Select Month
						
							<select name="monthlydatebillPerso" id="monthlydatebillPerso" style="width:100px;height:40px;">
							
								<option value='1'>January</option>
								<option value='2'>February</option>
								<option value='3'>March</option>
								<option value='4'>April</option>
								<option value='5'>May</option>
								<option value='6'>June</option>
								<option value='7'>July</option>
								<option value='8'>August</option>
								<option value='9'>September</option>
								<option value='10'>October</option>
								<option value='11'>November</option>
								<option value='12'>December</option>
							
							</select>
							
							<select name="monthlydatebillPersoYear" id="monthlydatebillPersoYear" style="width:100px;height:40px;">
							<?php 
							for($i=2016;$i<=2030;$i++)
							{
							?>
								<option value='<?php echo $i;?>'><?php echo $i;?></option>
							<?php 
							}
							?>
							</select>
							
							<button type="submit"  name="searchmonthlybillPerso" class="btn-large-inversed" style="width:auto;vertical-align:top;height:39px;">Search</button>
							
						</td>
						
						<td id="annualybillPerso" style="display:none">Select Year
						
							<select name="annualydatebillPerso" id="annualydatebillPerso" style="width:100px;height:40px;">
							<?php 
							for($i=2016;$i<=2030;$i++)
							{
							?>
								<option value='<?php echo $i;?>'><?php echo $i;?></option>
							<?php 
							}
							?>
							</select>
						
							<button type="submit"  name="searchannualybillPerso" class="btn-large-inversed" style="width:auto;vertical-align:top;height:39px;">Search</button>
						</td>
						
						<td id="custombillPerso" style="display:none">
						
							<table>
								<tr>
									<td>From</td>
									<td>
										<input type="text" id="customdatedebutbillPerso" name="customdatedebutbillPerso" onclick="ds_sh(this);" value="" style="width:150px"/>
									</td>
								
									<td>&nbsp;&nbsp;&nbsp;&nbsp;To</td>
									<td>
										<input type="text" id="customdatefinbillPerso" name="customdatefinbillPerso" onclick="ds_sh(this);" value="" style="width:150px"/>
									</td>
								
									<td style="vertical-align:top;">
										<button type="submit"  name="searchcustombillPerso" class="btn-large-inversed" style="width:auto;height:38px;margin-left:5px;">Search</button>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				
				</table>

			</form>
			
		</div>
			
		<?php
		}else{
		?>
		<div id="selectdateGnlBillReport" style="display:inline">
		
			<form action="insurance_report.php?audit=<?php echo $_SESSION['id'];?>&dmacbillgnl=ok&selectGnlBill=ok<?php if(isset($_GET['english'])){ echo '&english='.$_GET['english'];}else{ if(isset($_GET['francais'])){ echo '&francais='.$_GET['francais'];}}?>&insugnlreport=ok&nomassu=<?php echo $_GET['nomassu'];?>&idassu=<?php echo $_GET['idassu'];?>" method="post" style="margin:auto;padding:5px;width:90%;">
			
				<table id="dmacbillgnl" style="margin:auto auto 20px">
					<tr style="display:inline-block; margin-bottom:25px;">
						<td>
							<span style="text-align:center;width:100px;" id="dailygnlbtn" onclick="ShowSelectreportGnl('dailybillGnl')" class="btn">Daily</span>
						</td>
						
						<td>
							<span style="text-align:center;width:100px;" id="monthlygnlbtn" onclick="ShowSelectreportGnl('monthlybillGnl')" class="btn">Monthly</span>
						</td>
						
						<td>
							<span style="text-align:center;width:100px;" id="annualygnlbtn" onclick="ShowSelectreportGnl('annualybillGnl')" class="btn">Annualy</span>
						</td>
						
						<td>
							<span style="text-align:center;width:100px;" id="customgnlbtn" onclick="ShowSelectreportGnl('custombillGnl')" class="btn">Custom</span>
						</td>
												
					</tr>
					
					<tr style="visibility:visible">
					
						<td id="dailybillGnl" style="display:none">Select Date/Percent
							<input type="text" id="dailydatebillGnl" name="dailydatebillGnl" onclick="ds_sh(this);" value="<?php echo $annee;?>"/>
						
							<select name="dailypercbillGnl" id="dailypercbillGnl" style="width:60px;height:40px;">
								<option value='<?php echo 'All';?>'><?php echo 'All';?></option>
							<?php 
							for($j=0;$j<=100;$j++)
							{
							?>
								<option value='<?php echo $j;?>'><?php echo $j;?></option>
							<?php 
							}
							?>
							</select><span style="font-size:100%; font-weight:normal;margin-right:50px;">%</span>
							
							<button type="submit"  name="searchdailybillGnl" class="btn-large-inversed" style="width:auto;vertical-align:top;height:38px;">Search</button>
						</td>
						
						<td id="monthlybillGnl" style="display:none">Select Month/Percent
						
							<select name="monthlydatebillGnl" id="monthlydatebillGnl" style="width:100px;height:40px;">
							
								<option value='1'>January</option>
								<option value='2'>February</option>
								<option value='3'>March</option>
								<option value='4'>April</option>
								<option value='5'>May</option>
								<option value='6'>June</option>
								<option value='7'>July</option>
								<option value='8'>August</option>
								<option value='9'>September</option>
								<option value='10'>October</option>
								<option value='11'>November</option>
								<option value='12'>December</option>
							
							</select>
							
							<select name="monthlydatebillGnlYear" id="monthlydatebillGnlYear" style="width:100px;height:40px;">
							<?php 
							for($i=2016;$i<=2030;$i++)
							{
							?>
								<option value='<?php echo $i;?>'><?php echo $i;?></option>
							<?php 
							}
							?>
							</select>
							
							<select name="monthlypercbillGnl" id="monthlypercbillGnl" style="width:60px;height:40px;">
								<option value='<?php echo 'All';?>'><?php echo 'All';?></option>
							<?php 
							for($j=0;$j<=100;$j++)
							{
							?>
								<option value='<?php echo $j;?>'><?php echo $j;?></option>
							<?php 
							}
							?>
							</select><span style="font-size:100%; font-weight:normal;margin-right:50px;">%</span>
									
							<button type="submit"  name="searchmonthlybillGnl" class="btn-large-inversed" style="width:auto;vertical-align:top;height:39px;">Search</button>
							
						</td>
						
						<td id="annualybillGnl" style="display:none">Select Year/Percent
						
							<select name="annualydatebillGnl" id="annualydatebillGnl" style="width:100px;height:40px;">
							<?php 
							for($i=2016;$i<=2030;$i++)
							{
							?>
								<option value='<?php echo $i;?>'><?php echo $i;?></option>
							<?php 
							}
							?>
							</select>
						
							<select name="annualypercbillGnl" id="annualypercbillGnl" style="width:60px;height:40px;">
								<option value='<?php echo 'All';?>'><?php echo 'All';?></option>
							<?php 
							for($j=0;$j<=100;$j++)
							{
							?>
								<option value='<?php echo $j;?>'><?php echo $j;?></option>
							<?php 
							}
							?>
							</select><span style="font-size:100%; font-weight:normal;margin-right:50px;">%</span>
						
							<button type="submit" name="searchannualybillGnl" class="btn-large-inversed" style="width:auto;vertical-align:top;height:39px;">Search</button>
							
						</td>
						
						<td id="custombillGnl" style="display:none">
						
							<table>
								<tr>
									<td>From</td>
									<td>
										<input type="text" id="customdatedebutbillGnl" name="customdatedebutbillGnl" onclick="ds_sh(this);" value="" style="width:150px"/>
									</td>
								
									<td>&nbsp;&nbsp;&nbsp;&nbsp;To</td>
									<td>
										<input type="text" id="customdatefinbillGnl" name="customdatefinbillGnl" onclick="ds_sh(this);" value="" style="width:150px"/>
									</td>
								
									<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
									<td>

										<select name="custompercbillGnl" id="custompercbillGnl" style="width:60px;height:40px;">
											<option value='<?php echo 'All';?>'><?php echo 'All';?></option>
										<?php 
										for($j=0;$j<=100;$j++)
										{
										?>
											<option value='<?php echo $j;?>'><?php echo $j;?></option>
										<?php 
										}
										?>
										</select><span style="font-size:100%; font-weight:normal;margin-right:50px;">%</span>
									
									</td>
								
									<td style="vertical-align:top;">
										<button type="submit" name="searchcustombillGnl" class="btn-large-inversed" style="width:auto;height:38px;margin-left:5px;">Search</button>
									</td>
								</tr>
							</table>
						</td>
						<!-- <td><input type="checkbox" name="checkout" id="checkout" style="display: none;width: 7px;"></td> -->
					</tr>
				
				</table>

			</form>
			
		</div>
			
		<?php
		}
		?>
			<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
				<tr>
					<td style="padding:5px;" id="ds_calclass"></td>
				</tr>
			</table>
		
		<?php
		
		if(isset($_GET['dmacbillgnl']))
		{
			$stringResult = "";
			$dailydategnl = "";
			$paVisitgnl="gnlGnlBill";
			
			if(isset($_POST['searchdailybillGnl']))
			{
				if(isset($_POST['dailydatebillGnl']))
				{
					$percent = $_POST['dailypercbillGnl'];
					
					if($percent != "All")
					{
						$dailydategnl = 'AND datebill LIKE \''.$_POST['dailydatebillGnl'].'%\' AND billpercent='.$percent.' ORDER BY datebill ASC';
					}else{
						$dailydategnl = 'AND datebill LIKE \''.$_POST['dailydatebillGnl'].'%\' ORDER BY datebill ASC';
					}
					
					$paVisitgnl="dailyGnlBill";
					
					$stringResult="Daily results : ".$_POST['dailydatebillGnl'];
				
				}
			}
			
			if(isset($_POST['searchmonthlybillGnl']))
			{
				if(isset($_POST['monthlydatebillGnl']) AND isset($_POST['monthlydatebillGnlYear']))
				{
					
					if($_POST['monthlydatebillGnl']<10)
					{
						$ukwezi = '0'.$_POST['monthlydatebillGnl'];
					}else{						
						$ukwezi = $_POST['monthlydatebillGnl'];
					}
					
					$umwaka = $_POST['monthlydatebillGnlYear'];
					$percent = $_POST['monthlypercbillGnl'];
				
					$daysmonth= cal_days_in_month(CAL_GREGORIAN,$ukwezi,$umwaka);
					
					if($daysmonth<10)
					{
						$daysmonth='0'.$daysmonth;
					}
					
					$paVisitgnl="monthly";
					
					if($percent != "All")
					{
						$dailydategnl = 'AND datebill>=\''.$umwaka.'-'.$ukwezi.'-01\' AND (datebill<\''.$umwaka.'-'.$ukwezi.'-'.$daysmonth.'\' OR datebill LIKE \''.$umwaka.'-'.$ukwezi.'-'.$daysmonth.'%\') AND billpercent='.$percent.' ORDER BY datebill ASC';
					}else{
						$dailydategnl = 'AND datebill>=\''.$umwaka.'-'.$ukwezi.'-01\' AND (datebill<\''.$umwaka.'-'.$ukwezi.'-'.$daysmonth.'\' OR datebill LIKE \''.$umwaka.'-'.$ukwezi.'-'.$daysmonth.'%\') ORDER BY datebill ASC';
					}
					
					$paVisitgnl="monthlyGnlBill";
					
					$stringResult=date("F",mktime(0,0,0,$_POST['monthlydatebillGnl'],10))."-".$_POST['monthlydatebillGnlYear'];
					
				}

			}
			
			if(isset($_POST['searchannualybillGnl']))
			{
				if(isset($_POST['annualydatebillGnl']))
				{
					$year = $_POST['annualydatebillGnl'];
					$percent = $_POST['annualypercbillGnl'];
					
					if($percent != "All")
					{
						$dailydategnl = 'AND datebill>=\''.$year.'-01-01\' AND datebill<=\''.$year.'-12-31\' AND billpercent='.$percent.' ORDER BY datebill DESC';
					}else{
						$dailydategnl = 'AND datebill>=\''.$year.'-01-01\' AND datebill<=\''.$year.'-12-31\' ORDER BY datebill ASC';
					}
					
					$paVisitgnl="annualyGnlBill";
					
					$stringResult="Annualy results : ".$_POST['annualydatebillGnl'];
			
			
				}
			
			}
			
			if(isset($_POST['searchcustombillGnl']))
			{
				if(isset($_POST['customdatedebutbillGnl']) AND isset($_POST['customdatefinbillGnl']))
				{
					$debut = $_POST['customdatedebutbillGnl'];
					$fin = $_POST['customdatefinbillGnl'];
					$percent = $_POST['custompercbillGnl'];
				
					// $daysmonth= cal_days_in_month(CAL_GREGORIAN,$ukwezi,$umwaka);
					
					if($percent != "All")
					{
						$dailydategnl = 'AND datebill>=\''.$debut.'\' AND (datebill<\''.$fin.'\' OR datebill LIKE \''.$fin.'%\') AND billpercent='.$percent.' ORDER BY datebill DESC';
					}else{
						$dailydategnl = 'AND datebill>=\''.$debut.'\' AND (datebill<\''.$fin.'\' OR datebill LIKE \''.$fin.'%\') ORDER BY datebill ASC';
					}
					
					$paVisitgnl="customGnlBill";
					
					$stringResult="Customer results : [ ".$_POST['customdatedebutbillGnl']."/".$_POST['customdatefinbillGnl']." ]";
			
			
				}

			}
			
				// echo $dailydategnl;
				// echo $ukwezi.' et '.$year;
				// echo $year;
		
		?>
			<div id="divGnlBillReport" style="display:inline;">
			
			<table style="width:100%;">
				<tr>
					<td style="text-align:center; width:33.333%;">
										
					</td>
					
					<td style="text-align:center; width:40%;">
						<span style="position:relative; font-size:150%;"></i> <?php echo $stringResult.' ('.$percent.'%)';?></span>
				
					</td>
					
					<td style="font-size:18px; padding-right:20px; text-align:center; width:33.333%;">
						
					</td>
				</tr>			
			</table>
			
			<?php
			
			$resultGnlBillReport=$connexion->prepare('SELECT *FROM bills WHERE nomassurance = :nomassu '.$dailydategnl.'');
			$resultGnlBillReport->execute(array(
			'nomassu'=>$_GET['nomassu']	
			));

			$resultGnlBillReport->setFetchMode(PDO::FETCH_OBJ);//on veut que le résultat soit récupérable sous forme d'objet

			$comptBillReport=$resultGnlBillReport->rowCount();
			
			if($comptBillReport!=0)
			{
			?>
			
			<table style="width:100%;">
				<tr>
					<td style="text-align:left; width:33.333%;">
				
						<a href="<?php if($nomassu=="RSSB"){ echo 'dmacrssb_report.php'; }else{ if($nomassu=="MMI"){ echo 'dmacmmi_report.php'; }else{ if($nomassu=="UAP" OR $nomassu=="BRITAM"){ echo 'dmacuap_report.php'; }else{ if($nomassu=="RADIANT" OR $nomassu=="CORAR" OR $nomassu=="SORAS" OR $nomassu=="SANLAM"){ echo 'dmacradiant_report.php'; }else{ echo 'dmacinsurance_report.php';}}}}?>?dailydategnl=<?php echo $dailydategnl;?>&divGnlBillReport=ok&gnlpatient=ok&paVisitgnl=<?php echo $paVisitgnl;?>&stringResult=<?php echo $stringResult;?>&percent=<?php echo $percent;?>&nomassu=<?php echo $nomassu;?>&idassu=<?php echo $idassu;?><?php if(isset($_POST['checkout'])){echo"&checkout=ok";}?>&createRN=1" style="text-align:center" id="dmacbillgnlpreview">
							
							<button style="width:250px; margin:auto;" type="submit" name="printbill" id="printbill" class="btn-large">
								<i class="fa fa-desktop fa-lg fa-fw"></i> Preview print <span class="badge"><?= $comptBillReport;?></span>
							</button>
						
						</a>
			
						<input type="hidden" name="dateprint" value="<?php  echo $annee;?>"/>
				
					</td>
					
					<td style="text-align:center; width:33.333%;">
						
					</td>
					
					<td style="font-size:18px; padding-right:20px; text-align:right; width:33.333%;">
						<span style="font-weight:bold; color:#a00000;"><i class="fa fa-calendar-o fa-lg fa-fw"></i> <?php echo getString(71) ?>: </span><?php echo date('d-M-Y',strtotime($annee));?>
					</td>
				</tr>			
			</table>
			
			<?php
			}else{
			?>
				<table class="tablesorter tablesorter4" cellspacing="0" style="background:#fff; width:100%; margin-top:10px;text-align:center;"> 
							
					<thead>
						<tr>
							<th style="width:12%;text-align:center;">No report for this search</th>
						</tr> 
					</thead> 
				</table> 
				
			<?php
			}
			?>
			</div>		
		<?php
		}

	}
	?>
	
</div>


<script>

function getXMLHttpRequest() {
var xhr = null;

if (window.XMLHttpRequest || window.ActiveXObject) {
	if (window.ActiveXObject) {
		try {
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
	} else {
		xhr = new XMLHttpRequest(); 
	}
}else {
	alert("Your Browser does not support XMLHTTPRequest object...");
	return null;
}

return xhr;
}


function ShowList(list)
{
	if( list =='Users')
	{
		document.getElementById('divMenuUser').style.display='inline-block';
		
		document.getElementById('listOn').style.display='inline';
		document.getElementById('newUser').style.display='inline';
		
		document.getElementById('listOff').style.display='none';
		
		document.getElementById('divMenuMsg').style.display='none';
		document.getElementById('divListe').style.display='none';
	
	}
	
	if( list =='Msg')
	{
		document.getElementById('divListe').style.display='none';
		document.getElementById('divMenuMsg').style.display='inline-block';
		document.getElementById('divMenuUser').style.display='none';
		
	}
	
	if( list =='Liste')
	{
		document.getElementById('divListe').style.display='inline';
		document.getElementById('listOff').style.display='inline';
		document.getElementById('listOn').style.display='none';
	}
	
	if( list =='ListeNon')
	{
		document.getElementById('divListe').style.display='none';
		document.getElementById('listOn').style.display='inline';
		document.getElementById('listOff').style.display='none';
	}
	
	if( list =='MsgRecu')
	{
		document.getElementById('formMsg').style.display='none';
		document.getElementById('reception').style.display='inline-block';
		document.getElementById('EnvoiMsg').style.display='inline-block';
		document.getElementById('MsgEnvoye').style.display='inline-block';
		document.getElementById('MsgRecu').style.display='none';
		document.getElementById('envoye').style.display='none';
	}
	
	if( list =='MsgEnvoye')
	{
		document.getElementById('formMsg').style.display='none';
		document.getElementById('reception').style.display='none';
		document.getElementById('MsgEnvoye').style.display='none';
		document.getElementById('EnvoiMsg').style.display='inline-block';
		document.getElementById('MsgRecu').style.display='inline-block';
		document.getElementById('envoye').style.display='inline-block';
	}
	
	if( list =='EnvoiMsg')
	{
		document.getElementById('formMsg').style.display='inline-block';
		document.getElementById('MsgEnvoye').style.display='inline-block';
		document.getElementById('MsgRecu').style.display='inline-block';
		document.getElementById('EnvoiMsg').style.display='none';
		document.getElementById('reception').style.display='none';
		document.getElementById('envoye').style.display='none';
	}
	
}

function controlFormPassword(theForm){
	var rapport="";
	
	rapport +=controlPass(theForm.Pass);

		if (rapport != "") {
		alert("Please review the following fields:\n" + rapport);
					return false;
		 }
}


function controlPass(fld){
	var erreur="";
	
	if(fld.value=="")
	{
		erreur="Your new password\n";
		fld.style.background="rgba(0,255,0,0.3)";
	}
	
	return erreur;
}


function ShowSelect(fld){
	
	if(fld=="dailymedicPerso")
	{
		document.getElementById('dailymedicPerso').style.visibility='visible';
	}else{
		document.getElementById('dailymedicPerso').style.visibility='hidden';
	}
	
	if(fld=="monthlymedicPerso")
	{
		document.getElementById('monthlymedicPerso').style.visibility='visible';
	}else{
		document.getElementById('monthlymedicPerso').style.visibility='hidden';
	}
	
	if(fld=="annualymedicPerso")
	{
		document.getElementById('annualymedicPerso').style.visibility='visible';
	}else{
		document.getElementById('annualymedicPerso').style.visibility='hidden';
	}
	
	if(fld=="custommedicPerso")
	{
		document.getElementById('custommedicPerso').style.visibility='visible';
	}else{
		document.getElementById('custommedicPerso').style.visibility='hidden';
	}

}


function ShowSelectGnl(fld){
		
	/*---------For Gnl Medic report---------------*/
	
	if(fld=="dailymedicGnl")
	{
		document.getElementById('dailymedicGnl').style.visibility='visible';
	}else{
		document.getElementById('dailymedicGnl').style.visibility='hidden';
	}
	
	if(fld=="monthlymedicGnl")
	{
		document.getElementById('monthlymedicGnl').style.visibility='visible';
	}else{
		document.getElementById('monthlymedicGnl').style.visibility='hidden';
	}
	
	if(fld=="annualymedicGnl")
	{
		document.getElementById('annualymedicGnl').style.visibility='visible';
	}else{
		document.getElementById('annualymedicGnl').style.visibility='hidden';
	}
	
	if(fld=="custommedicGnl")
	{
		document.getElementById('custommedicGnl').style.visibility='visible';
	}else{
		document.getElementById('custommedicGnl').style.visibility='hidden';
	}
}


function ShowSelectreport(fld){
	
	if(fld=="dailybillPerso")
	{
		document.getElementById('dailybillPerso').style.display='inline-block';
	}else{
		document.getElementById('dailybillPerso').style.display='none';
	}
	
	if(fld=="monthlybillPerso")
	{
		document.getElementById('monthlybillPerso').style.display='inline-block';
	}else{
		document.getElementById('monthlybillPerso').style.display='none';
	}
	
	if(fld=="annualybillPerso")
	{
		document.getElementById('annualybillPerso').style.display='inline-block';
	}else{
		document.getElementById('annualybillPerso').style.display='none';
	}
	
	if(fld=="custombillPerso")
	{
		document.getElementById('custombillPerso').style.display='inline-block';
	}else{
		document.getElementById('custombillPerso').style.display='none';
	}
	
}


function ShowSelectreportGnl(fld){
	
	/*---------For Gnl Bill report---------------*/
	
	
	if(fld=="dailybillGnl")
	{
		document.getElementById('dailybillGnl').style.display='inline-block';
		document.getElementById('checkout').style.display='inline-block';
	}else{
		document.getElementById('dailybillGnl').style.display='none';
	}
	
	if(fld=="monthlybillGnl")
	{
		document.getElementById('monthlybillGnl').style.display='inline-block';
		document.getElementById('checkout').style.display='inline-block';
	}else{
		document.getElementById('monthlybillGnl').style.display='none';
	}
	
	if(fld=="annualybillGnl")
	{
		document.getElementById('annualybillGnl').style.display='inline-block';
		document.getElementById('checkout').style.display='inline-block';
	}else{
		document.getElementById('annualybillGnl').style.display='none';
	}
	
	if(fld=="custombillGnl")
	{
		document.getElementById('custombillGnl').style.display='inline-block';
		document.getElementById('checkout').style.display='inline-block';
	}else{
		document.getElementById('custombillGnl').style.display='none';
	}
}


function ShowDivReport(fld){

	if(fld=="divPersoMedicReport")
	{		
		document.getElementById('divPersoBillReport').style.display='none';
		document.getElementById('persobillingstring').style.display='none';
		document.getElementById('individualstring').style.display='none';
		document.getElementById('billingpersopreview').style.display='none';
		document.getElementById('selectdatePersoBillReport').style.display='none';
		document.getElementById('dmacBillReport').style.display='none';
		document.getElementById('dmacMedicReport').style.display='none';
		document.getElementById('dmacmedicalpersopreview').style.display='none';
		document.getElementById('dmacbillpersopreview').style.display='none';
	}
	
	if(fld=="divPersoBillReport")
	{
		document.getElementById('divPersoMedicReport').style.display='none';
		document.getElementById('persomedicalstring').style.display='none';
		document.getElementById('individualstring').style.display='none';
		document.getElementById('medicalpersopreview').style.display='none';
		document.getElementById('selectdatePersoMedicReport').style.display='none';
		document.getElementById('dmacMedicReport').style.display='none';
		document.getElementById('dmacBillReport').style.display='none';
		document.getElementById('dmacmedicalpersopreview').style.display='none';
		document.getElementById('dmacbillpersopreview').style.display='none';
		
	}
	
	if(fld=="divGnlMedicReport")
	{
		document.getElementById('divGnlBillReport').style.display='none';
		document.getElementById('gnlbillstring').style.display='none';
		document.getElementById('gnlmedicalstring').style.display='none';
		document.getElementById('billinggnlpreview').style.display='none';
		document.getElementById('selectdateGnlMedicReport').style.display='inline';
		document.getElementById('dmacMedicReport').style.display='none';
		document.getElementById('dmacBillReport').style.display='none';
		document.getElementById('dmacmedicalgnlpreview').style.display='none';
		document.getElementById('dmacbillgnlpreview').style.display='none';
	}
	
	if(fld=="divGnlBillReport")
	{
		document.getElementById('divGnlMedicReport').style.display='none';
		document.getElementById('gnlmedicalstring').style.display='none';
		document.getElementById('gnlbillstring').style.display='none';
		document.getElementById('medicalgnlpreview').style.display='none';
		document.getElementById('dmacMedicReport').style.display='none';
		document.getElementById('dmacBillReport').style.display='none';
		document.getElementById('dmacmedicalgnlpreview').style.display='none';
		document.getElementById('dmacbillgnlpreview').style.display='none';
	}
	
}

</script>

<?php
	
	}else{
		echo '<script language="javascript"> alert("Vous avez été désactivé!!\n Demander à l\'administrateur de vous activer");</script>';
		echo '<script language="javascript">document.location.href="index.php"</script>';
	}
	
}else{header('Location:index.php');}



	if(isset($_POST['confirmPass']))
	{
	
		$pass = $_POST['Pass'];
		$iduti = $_SESSION['id'];
				
		$resultats=$connexion->prepare('UPDATE utilisateurs SET password=:pass WHERE id_u=:modifierIduti');
						
		$resultats->execute(array(
		'pass'=>$pass,
		'modifierIduti'=>$iduti
		))or die( print_r($connexion->errorInfo()));
			
		echo '<script type="text/javascript"> alert("Your password have been changed\nYour new password is : '.$pass.'");</script>';
		
	}
?>
	
</body>

</html>