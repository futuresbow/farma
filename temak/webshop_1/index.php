<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Webshop layout</title>
	<meta name="description" content="">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap&subset=latin-ext" rel="stylesheet">
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
		<div class="wrap">

			<!-- cart top-line -->
			<div class="top-line">
				<div class="cs-mobile"></div>
				<div class="c-service">
					<ul>
						<li><a href="tel:" title="">+36 1 234 5678</a></li>
						<li><a href="mailto:" title="">info@vitaminshop.hu</a></li>
					</ul>
				</div>
				<div class="login-mobile"></div>
				<div class="login">
					<ul>
						<li><a href="" title="">bejelentkezés</a></li>
						<li><a href="" title="">regisztráció</a></li>
					</ul>
				</div>
				<div class="search-mobile"></div>
				<a href="" title="" class="cart">
					<div class="cart-icon"><span>9</span></div>
					<div class="price">10.234 Ft</div>
				</a>
			</div>

			<!-- cart bottom-line -->
			<div class="bottom-line">
				<div class="menu-mobile"></div>
				<a href="" title="" class="logo"></a>
				<nav class="nav">
					<ul>
						<li><a href="" title="">Főoldal</a></li>
						<li><a href="" title="">Termékek</a></li>
						<li><a href="" title="">Akciók</a></li>
						<li><a href="" title="">Rólunk</a></li>
						<li><a href="" title="">Szállítás</a></li>
						<li><a href="" title="">Kapcsolat</a></li>
					</ul>
				</nav>
				<div class="search">
					<input type="text" placeholder="Keresés...">
					<label></label>
				</div>
			</div>

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
				case "termek": include "termek.html"; break; // in progress
				case "termeklista": include "termeklista.html"; break; // almost same as homepage

				default: include("fooldal.html"); break; // done
			}
		?>

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
					<div class="copy">&copy; 2019 VitaminShop.hu</div>
					<ul class="footer-nav">
						<li><a href="" title="">Cookie tájékoztató</a></li>
						<li><a href="" title="">Adatvédelem</a></li>
						<li><a href="" title="">Szállítási infók</a></li>
						<li><a href="" title="">Kapcsolat</a></li>
					</ul>
				</div>
			</div>
		</div>

		<!-- seo content -->
		<div class="seo-content">
			<div class="wrap">
				<div class="seo-txt">
					<p>SEO content... Lorem Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ullamcorper facilisis purus at tincidunt. Nam lacinia tristique neque, sed congue leo fermentum vel. Donec bibendum enim ultrices diam eleifend vestibulum. Mauris non elementum justo. Vivamus volutpat varius erat. Nunc at nunc eu leo malesuada sodales. <strong>Etiam tincidunt justo sit amet elit vehicula</strong>, a egestas magna volutpat. Proin felis nisl, porttitor vitae turpis vel, scelerisque tincidunt arcu. Duis efficitur pharetra posuere. Fusce pulvinar diam facilisis orci accumsan dignissim. Nullam rutrum, dui lobortis aliquet rutrum, mi lectus varius lacus, ac condimentum dolor lorem in ante. Suspendisse a velit suscipit, imperdiet urna vel, dapibus tortor. Vivamus ornare sapien a ornare dignissim. Suspendisse potenti.</p>
					<p>Sed nisi velit, varius et pellentesque eu, convallis eget erat. Suspendisse tortor tellus, faucibus sit amet sollicitudin eget, vestibulum varius erat. Duis a consectetur ex, ut sollicitudin lectus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam euismod condimentum orci at blandit. Ut hendrerit, leo id volutpat efficitur, eros eros mollis quam, eget venenatis ligula est eget magna. Praesent maximus sit amet lacus sed laoreet. Suspendisse pretium ex vitae mollis facilisis. Nam ullamcorper ligula non lorem molestie tempus. Phasellus pulvinar feugiat erat in ullamcorper.</p>
					<p>Ut fermentum eleifend dui, in vulputate nunc sagittis sed. Ut suscipit ut felis ut blandit. Pellentesque sagittis suscipit felis id tristique. Maecenas vulputate egestas est sit amet vulputate. Nullam accumsan arcu congue magna interdum, nec fringilla mauris tristique. Ut euismod mollis scelerisque. Fusce hendrerit et elit sed facilisis. Phasellus in accumsan ipsum.</p>
 					<p>Integer in luctus massa. Curabitur consequat magna sed mi ultrices congue a ac eros. Quisque ante tellus, suscipit a justo quis, molestie hendrerit lorem. Sed vitae lorem ut dui ornare euismod. Sed vestibulum, <a href="" title="">felis ac tempor ultricies</a>, nulla risus efficitur odio, ac lacinia mi lacus quis augue. Nulla rutrum dignissim est.</p>
					<p>Donec euismod vulputate leo, sit amet hendrerit tellus rhoncus ut. Vivamus a neque nec elit fringilla dictum. Donec id nunc a justo blandit cursus. Ut eget ante purus. Morbi vestibulum luctus eleifend. Etiam in velit odio. Curabitur id diam et turpis aliquet porttitor eget ut ligula. Maecenas vel finibus diam.</p>
					<p>Nulla facilisi. Praesent aliquam augue ut ipsum congue, sit amet fringilla libero mollis. Morbi efficitur risus eros, sed consequat lacus it. Vivamus sit amet efficitur magna.</p>
				</div>
			</div>
		</div>

	</footer>
	<!-- end: footer -->

	<!-- js -->
	<script src="js/webshop.js"></script>
	<!-- js -->

</body>
</html>
