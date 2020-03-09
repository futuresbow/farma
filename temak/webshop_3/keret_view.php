<?php include 'tema_valtozok.php';?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title><?= ws_seo('cim'); ?></title>
	<meta name="description" content="<?= ws_seo('leiras'); ?>">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&display=swap&subset=latin-ext" rel="stylesheet">
	<!-- Fonts -->

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/webshop_3/css/style-<?= $stilus_css;?>.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/webshop_3/css/extra.css">
	
	<!-- CSS -->

	<!-- jQuery -->
	<script src="//code.jquery.com/jquery-latest.min.js"></script>

	<!-- slick -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<link href="<?= base_url();?>js/slicklightbox/slick-lightbox.css" rel="stylesheet">
	<script src="<?= base_url();?>js/slicklightbox/slick-lightbox.js"></script>
	<!-- slick -->
	<meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="<?= beallitasOlvasas('google-signin-client_id')?>">
</head>
<body>
	<div class="loading">Loading&#8230;</div>
	<!-- start: header -->
	<header class="header">

		<!-- start: top-line -->
		<div class="top-line">

			<div class="wrap top-line-inner">

				<div class="left-side">
					<ul>
						<li><a href="tel:<?= $aruhaztelefon;?>" title="" class="phone"><span><?= $aruhaztelefon;?></span></a></li>
						<li><a href="mailto:<?= $aruhazemail;?>" title="" class="mail"><span><?= $aruhazemail;?></span></a></li>
					</ul>
				</div>

				<div class="right-side">
					<ul>
						<?php $tag = ws_belepesEllenorzes(); if($tag):?>
						
						<li><a class="reg" href="<?= base_url();?>?logout" title="Kilépés">Kilépés</a></li>
						<li><a class="reg" href="<?= base_url();?>fiokom" title="Fiók">Saját fiók</a></li> 
						
						<?php if($tag->adminjogok>0):?>
						
						<li><a class="reg" href="<?= base_url().beallitasOlvasas('ADMINURL');?>" target="_blank" title="Kilépés">Admin</a></li>
						<?php endif;?>
						<?php else : ?>
						<li><a class="reg" href="<?= base_url();?>regisztracio" title="Regisztráció">Regisztráció</a></li>
						<li><a class="login" href="<?= base_url();?>belepes" title="">Bejelentkezés</a></li>
						<?php endif; ?>
					
					
						
					</ul>
				</div>

			</div>

		</div>
		<!-- end: top-line -->

		<!-- start: middle -->
		<div class="middle">

			<div class="wrap middle-inner">

				<div class="mobile-menu"></div>

				<a href="<?= base_url();?>" title="" class="logo" >
					<img src="<?= base_url().$logokep;?>" alt="">
				</a>

				<div class="search-mobile"></div>

				<div class="search">
					<input type="text" placeholder="Keresés..." onkeypress="if (event.keyCode == 13) { window.location.href='<?= base_url(); ?>kereses/'+$(this).val(); } " >
					<input type="button" value="Keresés" onclick="window.location.href='<?= base_url(); ?>kereses/'+$(this).prev().val();">
				</div>

				<a href="<?= base_url().beallitasOlvasas('kosar.oldal.url');?>" title="Kosár" class="cart kosarwidget">
					
				</a>

			</div>

		</div>
		<!-- end: middle -->

		<!-- start: nav-->
		<div class="nav-outer">
			<div class="wrap">
				<nav class="nav">
					<ul>
						<?php foreach(ws_frontendMenupontok(1) as $sor):?>
						<li><a href="<?= base_url().$sor->url;?>" title="<?= $sor->felirat;?>" class="<?= $sor->aktiv==true?'active':'';?>"><?= $sor->felirat; ?></a></li>
						<?php endforeach; ?>
						
					</ul>
				</nav>
			</div>
		</div>
		<!-- end: nav-->

	</header>
	<!-- end: header -->

	<!-- start: main -->
	<main class="main">
		<div class="wrap">

		<?= $modulKimenet; ?>

		</div>
	</main>
	<!-- end: main -->

	<!-- start: footer -->
	<footer class="footer">

		<!-- start: boxes -->
		<div class="boxes">
			<div class="wrap boxes-inner">

				<div class="box">
						<div class="box-title"><?= $doboz1_cim;?></div>
						<div class="box-content">
							<p><?= $doboz1_szoveg;?></p>
							<p><a href="<?= base_url().$doboz1_linkurl ?>" title="<?= $doboz1_linkszoveg;?>" class="more"><?= $doboz1_linkszoveg;?></a></p>
						</div>
					</div>

				<div class="box">
					<div class="box-title">Termékkategóriák</div>
					<div class="box-content">
						<ul>
							<?php ws_autoload('termek');$k = new Kategoriak_osztaly();$lista = $k->kategoriaLista(20,"nev ASC");?>
							<?php foreach($lista as $sor):?>
							<li><a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$sor->slug; ?>" title="<?= $sor->nev; ?>"><?= $sor->nev; ?></a></li>
							<?php endforeach ;?>
						</ul>
						<p><a href="<?= base_url();?>termekek" title="" class="read-more">Minden kategória</a></p>
					</div>
				</div>

				<div class="box">
					<div class="box-title"><?= @$feliratkozas_cim?></div>
					<div class="box-content">
						<p><?= @$feliratkozas_szoveg?></p>
						<form id="hlform" method="post" action="<?= base_url();?>hirlevel-feliratkozas">
							<div class="input-container ">
								<input type="text" class="user hluser" name="hu[nev]" placeholder="Hogyan szólíthatunk?">
							</div>

							<div class="input-container">
								<input type="text" class="mail hlemail" name="hu[email]" placeholder="email@cimed.hu">
							</div>

							<div class="input-container">
								<input type="checkbox" id="aszf" name="hladatk" class="hlaszf">
								<label for="aszf">Elfogadom az <a  target="_blank" href="<?= base_url();?>aszf" title="ÁSZF">ÁSZF</a>-et.</label>
							</div>

							<a href="javascript:void(0);" onclick="$('#hlform').submit();" title="" class="btn">Feiratkozom</a>
						</form>
						<div class="social-links">
							<?php if(@$fb_url!=''):?><a target="_blank" href="<?= $fb_url; ?>" title="" class="facebook"></a><?php endif; ?>
							<?php if(@$twitter_url!=''):?><a target="_blank" href="<?= $twitter_url; ?>" title="" class="twitter"></a><?php endif; ?>
							<?php if(@$youtube_url!=''):?><a target="_blank" href="<?= $youtube_url; ?>" title="" class="youtube"></a><?php endif; ?>
							<?php if(@$instagram_url!=''):?><a target="_blank" href="<?= $instagram_url; ?>" title="" class="instagram"></a><?php endif; ?>
						</div>
					</div>
				</div>

				<div class="box">
					<div class="box-title"><?= $doboz4_cim;?></div>
					<div class="box-content">
						<?= $doboz4_html;?>
					</div>
				</div>
			


			</div>
		</div>
		<!-- end: boxes -->

		<!-- start: copyright -->
		<div class="copyright">

			<div class="wrap">

				<div class="copy"><?= @$footercopyright;?></div>

				<div class="center-links">
					<ul>
						<?php if($jogi_link1!=''):?>
						<li><a href="<?= base_url().$jogi_link1;?>" title="<?= $jogi_link1_cim;?>"><?= $jogi_link1_cim;?></a></li>
						<?php endif;?>
						
						<?php if($jogi_link2!=''):?>
						<li><a href="<?= base_url().$jogi_link2;?>" title="<?= $jogi_link2_cim;?>"><?= $jogi_link2_cim;?></a></li>
						<?php endif;?>
						
						<?php if($jogi_link3!=''):?>
						<li><a href="<?= base_url().$jogi_link3;?>" title="<?= $jogi_link3_cim;?>"><?= $jogi_link3_cim;?></a></li>
						<?php endif;?>
						
						
					</ul>
				</div>

				<div class="credit-cards">
					<img src="<?= base_url().TEMAMAPPA;?>/webshop_3/img/credit-cards.svg" alt="">
				</div>

			</div>

		</div>
		<!-- end: copyright -->

	</footer>
	<!-- end: footer -->

	<!-- js -->
	<script src="<?= base_url().TEMAMAPPA;?>/webshop_3/js/webshop.js"></script>
	<!-- js -->
	<?php include(FCPATH.'temak/kozos_elemek/js/sitejs.php'); ?>
</body>
</html>
