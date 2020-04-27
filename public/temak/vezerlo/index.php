<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Webshop Admin</title>
	<meta name="description" content="">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="format-detection" content="telephone=no">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Raleway:600,700&amp;subset=latin-ext" rel="stylesheet">
	<!-- Fonts -->

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- CSS -->

	<!-- jQuery & jQUI for sortable -->

	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>

	<!-- start: header -->
	<header class="header">
		<div class="mobile-menu">
			<div class="menu-icon"></div>
		</div>
		<div class="logo-container">
			<a href="" title="" class="logo">
				<img src="img/logo-sample.svg" alt="LOGO">
			</a>
		</div>
		<div class="control-container">
			<div class="search">
				<div class="search-container">
					<input type="text" id="search" placeholder="Keresés...">
					<label for="search">
						<svg version="1.1" id="search-label" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
							 y="0px" viewBox="-12 89 24 24" xml:space="preserve">
						<path d="M-1.5,108c-4.7,0-8.5-3.8-8.5-8.5S-6.2,91-1.5,91S7,94.8,7,99.5S3.2,108-1.5,108z M-1.5,93C-5.1,93-8,95.9-8,99.5
							s2.9,6.5,6.5,6.5S5,103.1,5,99.5S2.1,93-1.5,93z"/>
						<path d="M9,111c-0.3,0-0.5-0.1-0.7-0.3l-5.2-5.2c-0.4-0.4-0.4-1,0-1.4s1-0.4,1.4,0l5.2,5.2c0.4,0.4,0.4,1,0,1.4
							C9.5,110.9,9.3,111,9,111z"/>
						</svg>
					</label>
					<!-- style display:block if search input isn't empty. function: delete search input-->
					<a href="" title="Keresés törlése" class="search-delete" style="display:none"></a>
				</div>
			</div>
			<div class="header-btn-container">
				<div class="header-btn notif-btn">
					<div class="counter">1</div>
				</div>
			</div>
			<div class="header-btn-container">
				<div class="header-btn message-btn">
					<div class="counter">99+</div>
				</div>
			</div>
			<div class="profile">
				<div class="profile-btn">
					<div class="img-container">
						AS
						<div class="user-pic" style="background-image:url('pics/me.jpg');"></div>
					</div>
					<div class="user-name">Attila Szita</div>
				</div>
				<div class="profile-dropdown">
					<ul>
						<li><a href="belepett-felhasznalo" title="">Profil beállítások (X)</a></li>
						<li class="separator"></li>
						<li><a href="" title="">Értesítések<span>1</span></a></li>
						<li><a href="" title="">Rendszer üzenetek<span>99+</span></a></li>
						<li class="separator"></li>
						<li><a href="" title="">Kijelentkezés</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<!-- end: header -->

	<div class="app-body">

		<!-- start: nav -->
		<nav class="nav">
			<ul>
				<li><a href="." title="" class="dashboard active">Dashboard</a></li>
				<li><a href="" title="" class="orders nav-dropdown">Rendelések</a>
					<ul>
						<li><a href="osszes-rendeles" title="">Összes rendelés (X)</a></li>
						<li><a href="uj-rendeles-hozzaadasa" title="">Új rendelés hozzáadása (X)</a></li>
						<li><a href="rendeles-szerkesztese" title="">Rendelés szerkesztése (X)</a></li>
					</ul>
				</li>
				<li><a href="" title="" class="products nav-dropdown">Termékek</a>
					<ul>
						<li><a href="termekek" title="">Összes termék (x)</a></li>
						<li><a href="uj-termek-hozzaadasa" title="">Új termék hozzáadása (x)</a></li>
						<li><a href="termek-szerkesztese" title="">Termék szerkesztése (x)</a></li>
						<li class="separator"></li>
						<li><a href="kategoriak" title="">Kategória listázás (x)</a></li>
						<li><a href="kategoria-hozzaadasa" title="">Új kategória hozzáadás (x)</a></li>
						<li><a href="kategoria-szerkesztese" title="">Kategória szerkesztese (x)</a></li>
						<li class="separator"></li>
						<li><a href="raktarkeszlet" title="">Raktárkészlet (x)</a></li>
					</ul>
				</li>
				<li><a href="" title="" class="users nav-dropdown">Vásárlók</a>
					<ul>
						<li><a href="osszes-vasarlo" title="">Összes vásárló (X)</a></li>
						<li><a href="uj-vasarlo-hozzaadasa" title="">Új vásárló hozzáadása (X)</a></li>
						<li><a href="vasarlo-szerkesztese" title="">Vásárló szerkesztése (X)</a></li>
					</ul>
				</li>
				<li><a href="" title="" class="cms nav-dropdown">Tartalomkezelés</a>
					<ul>
						<li><a href="menupontok-listazasa" title="">Menüpontok listázása (x)</a></li>
						<li><a href="uj-menupont-hozzaadasa" title="">Új menü hozzáadása (x)</a></li>
						<li class="separator"></li>
						<li><a href="tartalmak-listazasa" title="">Tartalmak listázása (x)</a></li>
						<li><a href="uj-tartalom-hozzaadasa" title="">Új tartalom hozzáadása (x)</a></li>
						<li><a href="tartalom-szerkesztese" title="">Tartalom szerkesztése (x)</a></li>
						<li class="separator"></li>
						<li><a href="banner-lista" title="">Banner lista (x)</a></li>
						<li><a href="banner-hozzaadasa" title="">Banner hozzáadása (x)</a></li>
						<li><a href="banner-szerkesztese" title="">Banner szerkesztése (x)</a></li>
						<li class="separator"></li>
						<li><a href="cimkek" title="">Címkekezelő (x)</a></li>
						<li><a href="uj-cimke-hozzaadasa" title="">Új címke hozzáadása (x)</a></li>
						<li><a href="cimke-szerkesztese" title="">Címke szerkesztése (x)</a></li>
					</ul>
				</li>
				<li><a href="" title="" class="settings nav-dropdown">Beállítások</a>
					<ul>
						<li><a href="altalanos-beallitasok" title="">Általános beállítások (X)</a></li>
						<li class="separator"></li>
						<li><a href="fizetesi-modok" title="">Fizetési módok (X)</a></li>
						<li><a href="uj-fizetesi-mod-hozzaadasa" title="">Új fizetési mód hozzáadása (X)</a></li>
						<li><a href="fizetesi-mod-szerkesztese" title="">Fizetési mód szerkesztése (X)</a></li>
						<li class="separator"></li>
						<li><a href="szallitasi-modok" title="">Szállítási módok (X)</a></li>
						<li><a href="uj-szallitasi-mod-hozzaadasa" title="">Új szállítási mód hozzáadása (X)</a></li>
						<li><a href="szallitasi-mod-szerkesztese" title="">Szállítási mód szerkesztése (X)</a></li>
						<li class="separator"></li>
						<li><a href="afa-kulcsok" title="">ÁFA-kulcsok (X)</a></li>
						<li><a href="uj-afa-kulcs-hozzaadasa" title="">Új ÁFA-kulcs hozzáadása (X)</a></li>
						<li><a href="afa-kulcs-szerkesztese" title="">ÁFA-kulcs szerkesztése (X)</a></li>
						<li class="separator"></li>
						<li><a href="felhasznalokezeles" title="">Felhasználókezelés (X)</a></li>
						<li><a href="uj-admin-felhasznalo" title="">Új admin felhasználó (X)</a></li>
						<li><a href="admin-felhasznalo-szerkesztese" title="">Admin felhasználó szerkesztése (X)</a></li>
					</ul>
				</li>
				<li><a href="" title="" class="help">Súgó</a></li>
				<li><a href="controls" title="">Controls</a></li>
			</ul>
		</nav>
		<!-- end: nav -->

		<!-- start: main -->
		<main class="main">

			<div class="breadcrumb">
				<ul>
					<li><a href="" title="">Home</a></li>
					<li><a href="" title="">Sublevel</a></li>
					<li>Actual level (not link)</li>
				</ul>
				<div class="public-link">
					<a href="" title="">Webshop megtekintése</a>
				</div>
			</div>

			<!-- start: main content -->
			<div class="content">

				<?php
					$url = basename($_SERVER['REQUEST_URI']);
					switch($url)
					{

						case "lorem": include "lorem.html"; break;
						case "lorem": include "lorem.html"; break;

						case "termek-szerkesztese": include "termek-szerkesztese.html"; break;
						case "uj-termek-hozzaadasa": include "uj-termek-hozzaadasa.html"; break;
						case "kategoria-szerkesztese": include "kategoria-szerkesztese.html"; break;
						case "kategoria-hozzaadasa": include "kategoria-hozzaadasa.html"; break;
						case "kategoriak": include "kategoriak.html"; break;
						case "raktarkeszlet": include "raktarkeszlet.html"; break;
						case "termekek": include "termekek.html"; break;
						case "cimke-szerkesztese": include "cimke-szerkesztese.html"; break;
						case "uj-cimke-hozzaadasa": include "uj-cimke-hozzaadasa.html"; break;
						case "cimkek": include "cimkek.html"; break;

						case "banner-szerkesztese": include "banner-szerkesztese.html"; break;
						case "banner-hozzaadasa": include "banner-hozzaadasa.html"; break;
						case "banner-lista": include "banner-lista.html"; break;
						case "tartalom-szerkesztese": include "tartalom-szerkesztese.html"; break;
						case "uj-tartalom-hozzaadasa": include "uj-tartalom-hozzaadasa.html"; break;
						case "tartalmak-listazasa": include "tartalmak-listazasa.html"; break;
						case "uj-menupont-hozzaadasa": include "uj-menupont-hozzaadasa.html"; break;
						case "menupontok-listazasa": include "menupontok-listazasa.html"; break;
						case "afa-kulcs-szerkesztese": include "afa-kulcs-szerkesztese.html"; break;
						case "uj-afa-kulcs-hozzaadasa": include "uj-afa-kulcs-hozzaadasa.html"; break;
						case "afa-kulcsok": include "afa-kulcsok.html"; break;
						case "vasarlo-szerkesztese": include "vasarlo-szerkesztese.html"; break;
						case "uj-vasarlo-hozzaadasa": include "uj-vasarlo-hozzaadasa.html"; break;
						case "osszes-vasarlo": include "osszes-vasarlo.html"; break;
						case "admin-felhasznalo-szerkesztese": include "admin-felhasznalo-szerkesztese.html"; break;
						case "uj-admin-felhasznalo": include "uj-admin-felhasznalo.html"; break;
						case "felhasznalokezeles": include "felhasznalokezeles.html"; break;
						case "szallitasi-modok": include "szallitasi-modok.html"; break;
						case "uj-szallitasi-mod-hozzaadasa": include "uj-szallitasi-mod-hozzaadasa.html"; break;
						case "szallitasi-mod-szerkesztese": include "szallitasi-mod-szerkesztese.html"; break;
						case "fizetesi-mod-szerkesztese": include "fizetesi-mod-szerkesztese.html"; break;
						case "uj-fizetesi-mod-hozzaadasa": include "uj-fizetesi-mod-hozzaadasa.html"; break;
						case "fizetesi-modok": include "fizetesi-modok.html"; break;
						case "altalanos-beallitasok": include "altalanos-beallitasok.html"; break;
						case "rendeles-szerkesztese": include "rendeles-szerkesztese.html"; break;
						case "uj-rendeles-hozzaadasa": include "uj-rendeles-hozzaadasa.html"; break;
						case "osszes-rendeles": include "osszes-rendeles.html"; break;
						case "belepett-felhasznalo": include "belepett-felhasznalo.html"; break;

						case "controls": include "_controls.html"; break;

						default: include("dashboard.html"); break;
					}
				?>

			</div>
			<!-- end: main content -->

		</main>
		<!-- end: main -->

	</div>


	<!-- script -->
	<script type="text/javascript" src="js/webshop.js"></script>
	<script type="text/javascript" src="js/sort-table.js"></script>

	<!-- Fancybox -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.css" />
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js"></script>
	<!-- scripts -->

</body>
</html>
