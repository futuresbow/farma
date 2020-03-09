<?php include 'tema_valtozok.php';?><!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title><?= ws_seo('cim'); ?></title>
	<meta name="description" content="<?= ws_seo('leiras'); ?>">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800&display=swap&subset=latin-ext" rel="stylesheet">
	<!-- Fonts -->

	<!-- CSS -->
	<?php if(@$stilus_css!=''):?>
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/webshop_4/css/<?= $stilus_css;?>.css">
	<?php endif; ?>
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/webshop_4/css/extra.css">
	
	
	
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

	
<body class="<?= globalisMemoria('bodyclass');?>"> <!-- "home" class if homepage -->
	<div class="loading">Loading&#8230;</div>

	<!-- start: header -->
	<header class="header">
		<div class="wrap">

			<div class="top">

				<div class="search-icon"></div>
				<div class="login-reg-icon"></div>
				<div class="cart-icon"></div>

				<div class="search tes">
					<div class="search-inner">
						<input type="text" placeholder="Keresés..." onkeypress="if (event.keyCode == 13) { window.location.href='<?= base_url(); ?>kereses/'+$(this).val(); } ">
						<input type="button" value="OK" onclick="window.location.href='<?= base_url(); ?>kereses/'+$(this).prev().val();">
					</div>
				</div>

				<div class="login-reg">
					<div class="login-reg-inner">
						<?php $tag = ws_belepesEllenorzes(); if($tag):?>
						<a class="reg" href="<?= base_url();?>?logout" title="Kilépés">Kilépés</a> &amp;
						<a class="reg" href="<?= base_url();?>fiokom" title="Fiók">Saját fiók</a> 
						
						<?php if($tag->adminjogok>0):?>
						
						 &amp; <a class="reg" href="<?= base_url().beallitasOlvasas('ADMINURL');?>" target="_blank" title="Kilépés">Admin</a>
						<?php endif;?>
						<?php else : ?>
						<a class="reg" href="<?= base_url();?>regisztracio" title="Regisztráció">Regisztráció</a> &amp; 
						<a class="login" href="<?= base_url();?>belepes" title="">Bejelentkezés</a>
						<?php endif; ?>
					
						
					</div>
				</div>

				<div class="cart">
					<div class="cart-inner">
						<a href="<?= base_url().beallitasOlvasas('kosar.oldal.url');?>" title="Kosár" class="kosarwidget"></a>
					</div>
					
				</div>

			</div>

			<div class="nav-outer">

				<a href="<?= base_url(); ?>" title="Főoldal" class="logo" style="background-image: url('<?= base_url().$logokep;?>');"></a>

				<div class="mobile-menu"></div>

				<nav class="nav">
					<ul>
						<?php foreach(ws_frontendMenupontok(1) as $sor):?>
						<li><a href="<?= base_url().$sor->url;?>" title="<?= $sor->felirat;?>" class="<?= $sor->aktiv==true?'active':'';?>"><?= $sor->felirat; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>

			</div>

		</div>

	</header>
	<!-- end: header -->

	<!-- start: main -->
	<main class="main">

		<?= $modulKimenet; ?>

	</main>
	<!-- end: main -->

	<!-- start: footer -->
	<footer class="footer">

		<div class="footer-top">

			<div class="wrap">

				<div class="footer-boxes">

					<div class="box">
						<div class="box-title"><?= $doboz1_cim;?></div>
						<div class="box-content">
							<p><?= nl2br($doboz1_szoveg);?></p>
							<p><a href="<?= base_url().$doboz1_linkurl ?>" title="<?= $doboz1_linkszoveg;?>" class="more"><?= $doboz1_linkszoveg;?></a></p>
						</div>
					</div>

					<div class="box">
						<div class="box-title">Hírek</div>
						<div class="box-content">
							<ul>
								<?php ws_autoload('post');$k = new Post_osztaly();$lista = $k->listaKategoriaSlugSzerint("hirek",6, " datum DESC");?>
								<?php foreach($lista as $sor):?>
								<li><a href="<?= $sor->link; ?>" title="<?= $sor->cim; ?>"><?= $sor->cim; ?></a></li>
								<?php endforeach ;?>
							</ul>
						</div>
					</div>

					<div class="box">
						
						
						<div class="box-title"><?= @$feliratkozas_szoveg?></div>
						<div class="box-content">
							<form id="hlform" method="post" action="<?= base_url();?>hirlevel-feliratkozas">
						
								<div class="input-container ">
									<label class="user"></label>
									<input type="text" class=" hluser" name="hu[nev]" placeholder="Hogyan szólíthatunk?">
								</div>

								<div class="input-container">
									<label class="email"></label>
									<input type="text" class=" hlemail" name="hu[email]" placeholder="email@cimed.hu">
								</div>

								<div class="input-container">
									<input type="checkbox" id="aszf" name="hladatk" class="hlaszf">
									<label for="aszf">Elfogadom az <a target="_blank" href="<?= base_url();?>aszf" title="ÁSZF">ÁSZF</a>-et.</label>
								</div>

								<a href="javascript:void(0);" onclick="$('#hlform').submit();" title="" class="btn">Feiratkozom</a>
							
							</form>
						</div>
						
						
						
					</div>
					
					<div class="box">
						<div class="box-title"><?= $doboz4_cim;?></div>
						<div class="box-content">
							<?= $doboz4_html;?>
					
							
							<div class="social">
								<?php if(@$fb_url!=''):?><a target="_blank" href="<?= $fb_url; ?>" title="" class="facebook"></a><?php endif; ?>
							<?php if(@$twitter_url!=''):?><a target="_blank" href="<?= $twitter_url; ?>" title="" class="twitter"></a><?php endif; ?>
							<?php if(@$youtube_url!=''):?><a target="_blank" href="<?= $youtube_url; ?>" title="" class="youtube"></a><?php endif; ?>
							<?php if(@$instagram_url!=''):?><a target="_blank" href="<?= $instagram_url; ?>" title="" class="instagram"></a><?php endif; ?>
						
								
							</div>
						</div>
					</div>

				</div>

			</div>

		</div>

		<div class="copyright">
			<div class="wrap">
				<p><?= $footermondat; ?></p>
				<p><span><?= $copyright; ?></span></p>
			</div>
		</div>


	</footer>
	<!-- end: footer -->

	<!-- js -->
	<script src="<?= base_url().TEMAMAPPA;?>/webshop_4/js/webshop.js"></script>
	<!-- js -->
	<?php include(FCPATH.'temak/kozos_elemek/js/sitejs.php'); ?>
</body>
</html>


