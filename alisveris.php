<?php
include("bilgi.php");
session_start();
						 
if(!isset($_SESSION["login"])){
	//echo "Bu sayfayı görüntüleme yetkiniz yoktur.";
	header('location:index.php');
}
else{
	echo "hosgeldiniz<br>";
}

if(isset($_GET['islem']) && $_GET['islem'] == 'cikis'){
	session_destroy();
	header('location:index.php');
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8">
<title>alisveris</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<nav class = "navbar navbar-default navbar-fixed-top">
  <div class ="conteiner-fluid">
	   <div class = "row">
			 <div class = "col-xs-12 col-md-8">
				<h3>Alışveriş</h3>
				<a  href="index.php?islem=cikis">ÇIKIŞ</a>
			 </div>
			 
	  </div>
	  </div>
 </div>
</nav>




<div class=" container" style="margin-top:150px; ">
  
						
						<div class="container" style="margin-top:100px;">

                        <div class="row">
                        <div class="col-xs-4">
                        <div class="well"> 
						
							<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
								  <div class="form-group">
									<label for="miktar">Miktar:</label>
									<input type="text" class="form-control" name="miktar">
								  </div>
								  <div class="form-group">
									<label for="tur">Tür:</label>
									<select name="tur">
									<option value="kg">Kg</option>
									<option value="litre">Litre</option>
									<option value="gram">Gram</option>
									</select>
								  </div>
								  <div class="form-group">
									<label for="istenen">İstenen:</label>
									<input type="text" class="form-control" name="istenen">
								  </div>
								  
								  <button type="submit" name="kontrol" class="btn btn-default" >Ekle</button>
							</form>
																
                        </div>
                        </div>
                        
                       <div class="col-xs-8">
                       <div class="well">
					   <div class="site-content">
							
					   
							<?php
							
							 
						   
							
                                    if(isset($_POST["miktar"]) && isset($_POST["istenen"]) && isset($_POST["tur"])){
										
										$dosya = fopen( "yazi.txt", "r" ) or exit( "Dosya bulunamadı." ); //dosyayı okumak için açtık
										
										$miktar = $_POST["miktar"];
										$istenen = $_POST["istenen"];
										$tur = $_POST["tur"];
										
										//eğer dosya içinde aynı eleman varsa
										$sonuc = "";
										$formdanGeleniEkledikmi = false; //formdan gelenin yazıldığını kontrol edeceğiz
						
										while( !feof( $dosya ) ){ // Dosya bitene kadar oku
										 $satir = fgets( $dosya ); //dosyayı satır satır okuttuk
											
												$sutunlar = explode('_', $satir); // _ 
										
												if(isset($sutunlar[1]) && $tur == $sutunlar[1] && $istenen == trim($sutunlar[2])){ //formdan gelenle dosyada yazılı olanların eşit olup olmadığına baktık
													//burada değerleri toplatacağız ve yukarıda trimle sağ ve soldan kalan boslukları temizledik
													$miktar = $sutunlar[0] + $miktar;											
													$sonuc .= $miktar.'_'.$tur.'_'.$istenen."\r\n"; //satırı sonuc degiskenine atadık
													$formdanGeleniEkledikmi = true; 
													
													
												} 
												else {
													$sonuc .= $satir; //esit olmayanları normal bir sekilde sonuca atadık.
												}
										}
										
										
										if($formdanGeleniEkledikmi == false){ //eger formdan gelen veri yazılmadıysa yazdırdık
												$sonuc .= $miktar.'_'.$tur.'_'.$istenen."\r\n";
											}
										fclose($dosya); //dosyayı kapattık
										
										$dosya = fopen( "yazi.txt", "w" ) or exit( "Dosya bulumamadı." ); //dosyayı yazmak icin actık
										fwrite($dosya, $sonuc); //sonuc degiskenini dosyaya yazdırdık.
										fclose($dosya); //dosyayı kapattık
									}
							?> 
							
							<?php
							$lines = file('yazi.txt');
							?>
							<div class="site-content">
							<table class="tablom" border="px">
							 <tr>
							 <th>Miktar</th>
							 <th>Tür</th>
							 <th>İstenen</th>
							 <th>Kontrol</th>
							 </tr>
							 <?php 
							 foreach ($lines as $line) {
							 list($miktar,$tur,$istenen) = explode('_', $line);
							 echo "
								<tr>
								<td width=100>$miktar</td>
								<td width=100>$tur</td>
								<td width=100>$istenen</td>
								<td width=100><a href='aldim.php?param=$line' class='btn btn-default'>Aldım</a></td>
								</tr>"; 
							}
							 ?>
							</table>
							
                       </div>
					   
					  
					 
</div>







</body>
</html>
