<?php include 'tema_valtozok.php';?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title><?= ws_seo('cim'); ?></title>
	<meta name="description" content="<?= ws_seo('leiras'); ?>">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap&subset=latin-ext" rel="stylesheet">
	<!-- Fonts -->

	<!-- CSS -->
	<?php if(@$stilus_css!=''):?>
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/webshop_1/css/style-<?= $stilus_css;?>.css">
	<?php endif; ?>
	
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/webshop_1/css/extra.css">
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
		<div class="wrap">

			<!-- cart top-line -->
			<div class="top-line">
				<div class="cs-mobile"></div>
				<div class="c-service">
					<ul>
						<li><a href="tel:" title=""><?= $aruhaztelefon;?></a></li>
						<li><a href="mailto:" title=""><?= $aruhazemail;?></a></li>
					</ul>
				</div>
				<div class="login-mobile"></div>
				<div class="login">
					<ul>
						<?php $tag = ws_belepesEllenorzes(); if($tag):?>
						<li><a href="<?= base_url();?>?logout" title="Kilépés">Kilépés</a></li>
						<li><a href="<?= base_url();?>fiokom" title="Fiókom">Fiók beállítások</a></li>
						<?php if($tag->adminjogok>0):?>
						
						<li><a href="<?= base_url().beallitasOlvasas('ADMINURL');?>" target="_blank" title="Kilépés">Admin</a></li>
						<?php endif;?>
						<?php else : ?>
						<li><a href="<?= base_url();?>regisztracio" title="Regisztráció">Regisztráció</a></li>
						<li><a href="<?= base_url();?>belepes" title="">Bejelentkezés</a></li>
						<?php endif; ?>
						
						
					</ul>
				</div>
				<div class="search-mobile"></div>
				<a href="<?= base_url();?>kosar" title="Kosár" class="cart kosarwidget">
					
				</a>
			</div>

			<!-- cart bottom-line -->
			<div class="bottom-line">
				<div class="menu-mobile"></div>
				<a href="<?= base_url();?>" title="" style="background-image: url('<?= base_url().$logokep;?>')" class="logo"></a>
				<nav class="nav">
					
					<ul>
						<?php foreach(ws_frontendMenupontok(1) as $sor):?>
						<li><a href="<?= base_url().$sor->url;?>" title="<?= $sor->felirat;?>" class="<?= $sor->aktiv==true?'active':'';?>"><?= $sor->felirat; ?></a></li>
						<?php endforeach; ?>
					
					</ul>
				</nav>
				<div class="search">
					<input type="text" placeholder="Keresés..." onchange="window.location.href='<?= base_url(); ?>kereses/'+$(this).val();">
					<label></label>
				</div>
			</div>

		</div>
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

		<!-- copyright -->
		<div class="copyright">
			<div class="wrap">
				<div class="container">
					<a href="" title="" class="footer-logo"></a>
					<div class="copy"><?= @$copyright;?></div>
					<ul class="footer-nav">
						<li><a href="<?= base_url().$cookieinfo_url; ?>" title="">Cookie tájékoztató</a></li>
						<li><a href="<?= base_url().$adatvedelem_url; ?>" title="">Adatvédelem</a></li>
						<li><a href="<?= base_url().$szallitasiinfok_url; ?>" title="">Szállítási infók</a></li>
						<li><a href="<?= base_url().$kapcsolat_url; ?>" title="">Kapcsolat</a></li>
					</ul>
				</div>
			</div>
		</div>

		<!-- seo content -->
		<div class="seo-content">
			<div class="wrap">
				<div class="seo-txt">
					<?= nl2br(ws_seo('hosszuleiras'));?>
				</div>
			</div>
		</div>

	</footer>
	<!-- end: footer -->

	<!-- js -->
	<script src="<?= base_url().TEMAMAPPA;?>/webshop_1/js/webshop.js"></script>
	<!-- js -->
		
	<?php include(FCPATH.'temak/kozos_elemek/js/sitejs.php'); ?>
	
</body>
</html>




	
