<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Webshop layout</title>
	<meta name="description" content="">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800&display=swap&subset=latin-ext" rel="stylesheet">
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
<body class=""> <!-- "home" class if homepage -->


	<!-- start: header -->
	<header class="header">
		<div class="wrap">

			<div class="top">

				<div class="search-icon"></div>
				<div class="login-reg-icon"></div>
				<div class="cart-icon"></div>

				<div class="search">
					<div class="search-inner">
						<input type="text" placeholder="Keresés...">
						<input type="button" value="OK">
					</div>
				</div>

				<div class="login-reg">
					<div class="login-reg-inner">
						<a href="" title="">Bejelentkezés</a> &amp; <a href="" title="">Regisztráció</a>
					</div>
				</div>

				<div class="cart">
					<div class="cart-inner">
						<a href="" title="">2 termék, <span>12.345 Ft</span></a>
					</div>
				</div>

			</div>

			<div class="nav-outer">

				<a href="" title="" class="logo"></a>

				<div class="mobile-menu"></div>

				<nav class="nav">
					<ul>
						<li><a href="" title="" class="active">Főoldal</a></li>
						<li><a href="" title="">Bio terméke</a></li>
						<li><a href="" title="">Parfümök</a></li>
						<li><a href="" title="">Kozmetikumok</a></li>
						<li><a href="" title="">Sminkek</a></li>
						<li><a href="" title="">Hajápolás</a></li>
						<li><a href="" title="">Kiegészítők</a></li>
					</ul>
				</nav>

			</div>

		</div>

	</header>
	<!-- end: header -->

	<!-- start: main -->
	<main class="main">

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

				default: include("fooldal.html"); break; //
			}
		?>

	</main>
	<!-- end: main -->

	<!-- start: footer -->
	<footer class="footer">

		<div class="footer-top">

			<div class="wrap">

				<div class="footer-boxes">

					<div class="box">
						<div class="box-title">Rólunk</div>
						<div class="box-content">
							<p>Integer interdum eu risus id auctor. Suspendisse potenti. Etiam sit amet vestibulum erat. Morbi non odio in sem volutpat pellentesque. Nulla pulvinar volutpat ante ut dapibus. Donec commodo, ante eu viverra feugiat, nibh elit tempor lorem, eget consequat tortor justo in nisi.</p>
							<p>Ut fringilla, nisl et pretium venenatis, nulla ligula volutpat libero, quis hendrerit sapien nunc in tortor. Etiam facilisis pulvinar lobortis</p>
							<p><a href="" title="" class="btn">Bővebben...</a></p>
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
						</div>
					</div>

					<div class="box">
						<div class="box-title">Maradjunk kapcsolatban</div>
						<div class="box-content">

							<div class="input-container">
								<label class="user"></label>
								<input type="text" placeholder="Hogyan szólíthatunk?">
							</div>

							<div class="input-container">
								<label class="email"></label>
								<input type="text" placeholder="email@cimed.hu">
							</div>

							<div class="input-container">
								<input type="checkbox" id="aszf">
								<label for="aszf">Elfogadom az <a href="" title="">ÁSZF</a>-et.</label>
							</div>

							<a href="" title="" class="btn">Feiratkozom</a>

						</div>
					</div>

					<div class="box">
						<div class="box-title">Ügyfélszolgálat</div>
						<div class="box-content">
							<p>Integer interdum eu risus id auctor. Suspendisse potenti. Etiam sit amet vestibulum erat.:</p>
							<p>Telefon: <a href="tel:" title="">+36 1 234 5678</a><br>
								E-mail: <a href="mailto:" title="">info@loremipsum.hu</a></p>
							<div class="social">
								<a href="" title="" class="facebook"></a>
								<a href="" title="" class="twitter"></a>
								<a href="" title="" class="instagram"></a>
								<a href="" title="" class="youtube"></a>
							</div>
						</div>
					</div>

				</div>

			</div>

		</div>

		<div class="copyright">
			<div class="wrap">
				<p>Vivamus pulvinar lorem lectus, id commodo eros egestas vel. Nunc egestas velit vitae purus faucibus, a auctor elit porttitor. Vestibulum blandit hendrerit feugiat. Phasellus porta a erat eu facilisis. Mauris a aliquam nunc, quis <a href="" title="">condimentum eros</a>.</p>
				<p><span>&copy; 2019 Lorem Ipsum dolor sit amet</span></p>
			</div>
		</div>


	</footer>
	<!-- end: footer -->

	<!-- js -->
	<script src="js/webshop.js"></script>
	<!-- js -->

</body>
</html>
