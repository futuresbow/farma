<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Webshop layout</title>
	<meta name="description" content="">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&display=swap&subset=latin-ext" rel="stylesheet">
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

	<!-- start: header -->
	<header class="header">

		<!-- start: top-line -->
		<div class="top-line">

			<div class="wrap top-line-inner">

				<div class="left-side">
					<ul>
						<li><a href="tel:" title="" class="phone"><span>+36 1 234 5678</span></a></li>
						<li><a href="mailto:" title="" class="mail"><span>info@loremipsum.hu</span></a></li>
					</ul>
				</div>

				<div class="right-side">
					<ul>
						<li><a href="" title="" class="reg"><span>Regisztráció</span></a></li>
						<li><a href="" title="" class="login"><span>Bejelentkezés</span></a></li>
					</ul>
				</div>

			</div>

		</div>
		<!-- end: top-line -->

		<!-- start: middle -->
		<div class="middle">

			<div class="wrap middle-inner">

				<div class="mobile-menu"></div>

				<a href="" title="" class="logo">
					<img src="img/logo-orange.png" alt="">
				</a>

				<div class="search-mobile"></div>

				<div class="search">
					<input type="text" placeholder="Keresés...">
					<input type="button" value="Keresés">
				</div>

				<a href="" title="" class="cart">
					<div class="icon"><div class="counter">99</div></div>
					<div class="price">12.345 Ft</div>
				</a>

			</div>

		</div>
		<!-- end: middle -->

		<!-- start: nav-->
		<div class="nav-outer">
			<div class="wrap">
				<nav class="nav">
					<ul>
						<li><a href="" title="" class="active">Lorem ipsum</a></li>
						<li><a href="" title="">Lorem ipsum</a></li>
						<li><a href="" title="">Lorem ipsum</a></li>
						<li><a href="" title="">Lorem ipsum</a></li>
						<li><a href="" title="">Lorem ipsum</a></li>
						<li><a href="" title="">Lorem ipsum</a></li>
						<li><a href="" title="">Lorem ipsum</a></li>
						<li><a href="" title="">Lorem ipsum</a></li>
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
				case "termeklista": include "termeklista.html"; break; // done
				case "kategorialista": include "kategorialista.html"; break; // ?

				default: include("fooldal.html"); break; // done
			}
		?>

		</div>
	</main>
	<!-- end: main -->

	<!-- start: footer -->
	<footer class="footer">

		<!-- start: boxes -->
		<div class="boxes">
			<div class="wrap boxes-inner">

				<div class="box">
					<div class="box-title">Rólunk</div>
					<div class="box-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum lorem eget nulla euismod, vel semper ex gravida. Quisque eros erat, semper ut ultrices in, posuere eget libero. Sed luctus non magna et fringilla.</p>
						<p>Etiam accumsan bibendum velit ac tincidunt. Nunc convallis mattis magna eu tincidunt. Suspendisse nec eros non sapien ultricies pretium.</p>
						<p><a href="" title="" class="read-more">Bővebben rólunk</a></p>
					</div>
				</div>

				<div class="box">
					<div class="box-title">Termékkategóriák</div>
					<div class="box-content">
						<ul>
							<li><a href="" title="">Televíziók</a></li>
							<li><a href="" title="">Mosógépek</a></li>
							<li><a href="" title="">Mosogatógépek</a></li>
							<li><a href="" title="">Játék konzolok</a></li>
							<li><a href="" title="">Play Station</a></li>
							<li><a href="" title="">XBox</a></li>
							<li><a href="" title="">Okostelefonok</a></li>
							<li><a href="" title="">Apple</a></li>
							<li><a href="" title="">Microsoft</a></li>
							<li><a href="" title="">Televíziók</a></li>
							<li><a href="" title="">Mosógépek</a></li>
							<li><a href="" title="">Mosogatógépek</a></li>
							<li><a href="" title="">Játék konzolok</a></li>
							<li><a href="" title="">Play Station</a></li>
							<li><a href="" title="">XBox</a></li>
							<li><a href="" title="">Okostelefonok</a></li>
							<li><a href="" title="">Apple</a></li>
							<li><a href="" title="">Microsoft</a></li>
						</ul>
						<p><a href="" title="" class="read-more">Minden kategória</a></p>
					</div>
				</div>

				<div class="box">
					<div class="box-title">Maradjunk kapcsolatban</div>
					<div class="box-content">

						<div class="input-container">
							<input type="text" class="user" placeholder="Hogyan szólíthatunk?">
						</div>

						<div class="input-container">
							<input type="text" class="mail" placeholder="email@cimed.hu">
						</div>

						<div class="input-container">
							<input type="checkbox" id="aszf">
							<label for="aszf">Elfogadom az <a href="" title="">ÁSZF</a>-et.</label>
						</div>

						<a href="" title="" class="btn">Feiratkozom</a>

						<div class="social-links">
							<a href="" title="" class="facebook"></a>
							<a href="" title="" class="twitter"></a>
							<a href="" title="" class="youtube"></a>
							<a href="" title="" class="instagram"></a>
						</div>
					</div>
				</div>

				<div class="box">
					<div class="box-title">Ügyfélszolgálat</div>
					<div class="box-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum lorem eget nulla euismod, vel semper.</p>
						<p>Telefon: <a href="tel:" title="">+36 1 234 5678</a><br>
							E-mail: <a href="mailto:" title="">info@loremipsum.hu</a></p>
						<p><a href="" title="" class="read-more">További elérhetőségek</a></p>
					</div>
				</div>

			</div>
		</div>
		<!-- end: boxes -->

		<!-- start: copyright -->
		<div class="copyright">

			<div class="wrap">

				<div class="copy">&copy; 2008 - 2019 Lorem Ipsum Kft.</div>

				<div class="center-links">
					<ul>
						<li><a href="" title="">Adatvédelem</a></li>
						<li><a href="" title="">ÁSZF</a></li>
						<li><a href="" title="">Cookie tájékoztató</a></li>
					</ul>
				</div>

				<div class="credit-cards">
					<img src="img/credit-cards.svg" alt="">
				</div>

			</div>

		</div>
		<!-- end: copyright -->

	</footer>
	<!-- end: footer -->

	<!-- js -->
	<script src="js/webshop.js"></script>
	<!-- js -->

</body>
</html>
