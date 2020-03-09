<?php include 'tema_valtozok.php';?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title><?= ws_seo('cim'); ?></title>
	<meta name="description" content="<?= ws_seo('leiras'); ?>">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,600i&display=swap&subset=latin-ext" rel="stylesheet">
	<!-- Fonts -->

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/webshop_2/css/<?= $stilus_css;?>.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/webshop_2/css/extra.css">
	
	
	
	<!-- CSS -->

	<!-- jQuery -->
	<script src="//code.jquery.com/jquery-latest.min.js"></script>

	<!-- slick -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<!-- slick -->
	<meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="<?= beallitasOlvasas('google-signin-client_id')?>">
</head>

<body>
	<div class="loading">Loading&#8230;</div>
	
	
	<!-- start: search popup -->
	<div class="search-overlay">
		<div class="close"></div>
		<div class="wrap">
			<div class="search-inner">
				<input type="text" placeholder="Keresés..." onkeypress="if (event.keyCode == 13) { window.location.href='<?= base_url(); ?>kereses/'+$(this).val(); } ">
				<input type="button" class="search-btn" onclick="window.location.href='<?= base_url(); ?>kereses/'+$(this).prev().val();">
			</div>
		</div>
	</div>
	<!-- end: search popup -->

	<!-- start: header -->
	<header class="header">
		<div class="wrap">

			<div class="top">

				<div class="mobile-menu"></div>

				<div class="left-menu">
					<a href="<?= base_url(); ?>" title="" class="home"><span></span></a>
					<?php if(trim($fejleclink_url)!=''): ?>
					<a href="<?= base_url(); ?><?= $fejleclink_url;?>" title="" class="contact"><?= $fejleclink_felirat;?></a>
					<?php endif; ?>
				</div>

				<a href="<?= base_url(); ?>" title="Főoldal" class="logo">
					<img src="<?= base_url().$logokep;?>" alt="">
				</a>

				<div class="right-menu">
					<?php $tag = ws_belepesEllenorzes(); if($tag):?>
						<a class="login" href="<?= base_url();?>?logout" title="Kilépés">Kilépés</a>
						<?php if($tag->adminjogok>0):?>
						
						<a class="login" href="<?= base_url().beallitasOlvasas('ADMINURL');?>" target="_blank" title="Kilépés">Admin</a>
						<?php endif;?>
						<?php else : ?>
						<a class="reg" href="<?= base_url();?>regisztracio" title="Regisztráció">Regisztráció</a>
						<a class="login" href="<?= base_url();?>belepes" title="">Bejelentkezés</a>
					<?php endif; ?>
					
					<a href="<?= base_url();?>kosar" title="Kosár" class="cart kosarwidget">
					
					</a>
				</div>

			</div>

			<nav class="nav">
				<ul>
					<?php foreach(ws_frontendMenupontok(1) as $sor):?>
					<li><a href="<?= base_url().$sor->url;?>" title="<?= $sor->felirat;?>" class="<?= $sor->aktiv==true?'active':'';?>"><?= $sor->felirat; ?></a></li>
					<?php endforeach; ?>
					<li>
						<div class="search-icon">
							<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								 viewBox="0 0 14 14" style="enable-background:new 0 0 14 14;" xml:space="preserve">
							<g>
								<path d="M13.9,13.3l-3.4-3.4c0.9-1,1.5-2.4,1.5-3.9c0-3.3-2.7-6-6-6C2.7,0,0,2.7,0,6s2.7,6,6,6c1.5,0,2.9-0.6,3.9-1.5l3.4,3.4
									c0.1,0.1,0.2,0.1,0.3,0.1s0.2,0,0.3-0.1C14,13.7,14,13.4,13.9,13.3z M0.8,6c0-2.8,2.3-5.1,5.1-5.1c2.8,0,5.1,2.3,5.1,5.1
									S8.8,11.1,6,11.1C3.1,11.1,0.8,8.8,0.8,6z"/>
							</g>
							</svg>
						</div>
					</li>
				</ul>
			</nav>

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

		<div class="wrap">

			<div class="ups">

				<div class="box">
					<span class="delivery"><?= $ups_1_text; ?></span>
				</div>

				<div class="box">
					<span class="return"><?= $ups_2_text; ?></span>
				</div>

				<div class="box">
					<span class="payment"><?= $ups_3_text; ?></span>
				</div>

			</div>

			<div class="footer-boxes">
				<div class="box">
						<div class="box-title"><?= $doboz1_cim;?></div>
						<div class="box-content">
							<p><?= $doboz1_szoveg;?></p>
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
						<div class="credit-cards">
							<img src="img/credit-cards.svg" alt="">
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

			<div class="copyright">
				<?= @$copyright;?>
			</div>

		</div>
	</footer>
	<!-- end: footer -->

	<!-- js -->
	<script src="<?= base_url().TEMAMAPPA;?>/webshop_2/js/webshop.js"></script>
	<!-- js -->
	<?php include(FCPATH.'temak/kozos_elemek/js/sitejs.php'); ?>	

</body>
</html>




	
