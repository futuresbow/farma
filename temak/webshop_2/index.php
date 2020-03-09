<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Webshop layout</title>
	<meta name="description" content="">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,600i&display=swap&subset=latin-ext" rel="stylesheet">
	<!-- Fonts -->

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- CSS -->

	<!-- jQuery -->
	<script src="//code.jquery.com/jquery-latest.min.js"></script>

	<!-- slick -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<!-- slick -->

</head>
<body>

	<!-- start: search popup -->
	<div class="search-overlay">
		<div class="close"></div>
		<div class="wrap">
			<div class="search-inner">
				<input type="text" placeholder="Keresés...">
				<input type="button" class="search-btn">
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
					<a href="" title="" class="home"><span></span></a>
					<a href="" title="" class="contact">Elérhetőség</a>
				</div>

				<a href="" title="" class="logo">
					<img src="img/logo.svg" alt="">
				</a>

				<div class="right-menu">
					<a href="" title="" class="login"><span>Belépés</span></a>
					<a href="" title="" class="reg"><span>Reg.</span></a>
					<a href="" title="" class="cart"><span>Kosár</span></a>
				</div>

			</div>

			<nav class="nav">
				<ul>
					<li><a href="" title="">Lorem ipsum</a></li>
					<li><a href="" title="">Lorem ipsum dolor</a></li>
					<li><a href="" title="">Lorem ipsum</a></li>
					<li><a href="" title="">Lorem ipsum sit amet</a></li>
					<li><a href="" title="">Lorem ipsum</a></li>
					<li><a href="" title="">Lorem ipsum</a></li>
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

		<?php
			$url = basename($_SERVER['REQUEST_URI']);
			switch($url)
			{
				case "jelszo": include "jelszo.html"; break; // done
				case "belepes": include "belepes.html"; break; // done
				case "regisztracio": include "regisztracio.html"; break; // done
				case "kosar": include "kosar.html"; break; // done
				case "statikus": include "statikus.html"; break; // done
				case "termek": include "termek.html"; break; //
				case "termeklista": include "termeklista.html"; break; //

				default: include("fooldal.html"); break; // done
			}
		?>

		</div>
	</main>
	<!-- end: main -->

	<!-- start: footer -->
	<footer class="footer">
		<div class="wrap">

			<div class="ups">

				<div class="box">
					<span class="delivery">Ingyenes szállítás 10.000 Ft felett</span>
				</div>

				<div class="box">
					<span class="return">14 napos ingyenes visszaküldés</span>
				</div>

				<div class="box">
					<span class="payment">Kényelmes, bankkártyás fizetés</span>
				</div>

			</div>

			<div class="footer-boxes">

				<div class="box">
					<div class="box-title">Rólunk</div>
					<div class="box-content">
						<p>Integer interdum eu risus id auctor. Suspendisse potenti. Etiam sit amet vestibulum erat. Morbi non odio in sem volutpat pellentesque. Nulla pulvinar volutpat ante ut dapibus. Donec commodo, ante eu viverra feugiat, nibh elit tempor lorem, eget consequat tortor justo in nisi. Ut fringilla, nisl et pretium venenatis, nulla ligula volutpat libero, quis hendrerit sapien nunc in tortor. Etiam facilisis pulvinar lobortis</p>
						<p><a href="" title="">Bővebben...</a></p>
					</div>
				</div>

				<div class="box">
					<div class="box-title">Hasznos</div>
					<div class="box-content">
						<ul>
							<li><a href="" title="">Lorem ipsum</a></li>
							<li><a href="" title="">Dolor sit amet</a></li>
							<li><a href="" title="">Lorem ipsum</a></li>
							<li><a href="" title="">Lorem </a></li>
							<li><a href="" title="">Lorem ipsum</a></li>
							<li><a href="" title="">Lorem ipsum</a></li>
							<li><a href="" title="">Dolor sit amet</a></li>
							<li><a href="" title="">Lorem ipsum</a></li>
							<li><a href="" title="">Lorem </a></li>
							<li><a href="" title="">Lorem ipsum</a></li>
						</ul>
						<div class="credit-cards">
							<img src="img/credit-cards.svg" alt="">
						</div>
					</div>
				</div>

				<div class="box">
					<div class="box-title">Ügyfélszolgálat</div>
					<div class="box-content">
						<p>Integer interdum eu risus id auctor. Suspendisse potenti. Etiam sit amet vestibulum erat.:</p>
						<p>Telefon: <a href="tel:" title="">+36 1 234 5678</a><br>
							E-mail: <a href="mailto:" title="">info@loremipsum.hu</a></p>
						<p>Nyitva tartás:</p>
						<p>Hétfő - péntek: 07:00 - 20:00<br>
							Hétvégén zárva.
						</p>
						<p><a href="" title="">Bővebben...</a></p>
					</div>
				</div>

			</div>

			<div class="copyright">
				&copy; 2019 Lorem Ipsum dolor sit amet
			</div>

		</div>
	</footer>
	<!-- end: footer -->

	<!-- js -->
	<script src="js/webshop.js"></script>
	<!-- js -->

</body>
</html>
