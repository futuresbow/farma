<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Honda webshop</title>
	<meta name="description" content="">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

	<!-- Fonts -->

	<!-- Fonts -->

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- CSS -->

	<!-- Slick -->
	<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
	<!-- Slick -->

</head>
<body id="top">

	<!-- start: fb plugin -->
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v3.2"></script>
	<!-- end: fb plugin -->

	<!-- start: header -->
	<header class="header">
		<div class="wrap">

			<div class="header-container">

				<a href="" title="" class="logo logo-motor"></a>

				<div class="mobile-menu"></div>
				<div class="login-menu"></div>
				<div class="search-menu"></div>
				<a href="" title="" class="cart-menu"></a>

				<div class="back-to-homepage">
					<a href="" title="">Vissza a kereskedői oldalra</a>
				</div>

				<div class="search-login">
					<div class="search">
						<input type="text" id="top-search" placeholder="Keresés...">
						<label for="top-search"></label>
					</div>
					<div class="login">
						<a href="" title="">Regisztráció</a>
						<a href="" title="">Bejelentkezés</a>
					</div>
				</div>

				<nav class="nav">
					<ul>
						<li><a href="" title="" class="active">Főoldal</a></li>
						<li><a href="" title="">Termékek</a></li>
						<li><a href="" title="">Akciós termékek</a></li>
						<li><a href="" title="">Újdonságok</a></li>
						<li><a href="" title="">Márkák</a></li>
						<li><a href="" title="">Kapcsolat</a></li>
					</ul>
				</nav>

				<div class="cart">
					<div class="cart-btn">
						<div class="cart-icon"><span>99</span></div>
						<div class="cart-summ">0 Ft</div>
					</div>
					<div class="cart-dd">
						<table>
							<tr>
	                            <td class="img-container"><img src="pics/product-sample-60x60.jpg"></td>
	                            <td class="prod-name">Honda Samsonite laptoptáska</td>
	                            <td class="quantity">
	                                <div class="quantity-container clearfix">
	                                    <a href="" title class="minus del"></a> <!-- + "del" class, if quantity = 1 -->
	                                    <input type="text" name="" value="1">
	                                    <a href="" title class="plus"></a>
	                                </div>
	                            </td>
	                            <td class="all-price">1 234 Ft</td>
	                        </tr>
	                        <tr>
	                            <td class="img-container"><img src="pics/product-sample-60x60.jpg"></td>
	                            <td class="prod-name">Honda Samsonite laptoptáska</td>
	                            <td class="quantity">
	                                <div class="quantity-container clearfix">
	                                    <a href="" title class="minus"></a> <!-- + "del" class, if quantity = 1 -->
	                                    <input type="text" name="" value="3">
	                                    <a href="" title class="plus"></a>
	                                </div>
	                            </td>
	                            <td class="all-price">1 234 Ft</td>
	                        </tr>
							<tr>
	                            <td class="img-container"><img src="pics/product-sample-60x60.jpg"></td>
	                            <td class="prod-name">Honda Samsonite laptoptáska</td>
	                            <td class="quantity">
	                                <div class="quantity-container clearfix">
	                                    <a href="" title class="minus del"></a> <!-- + "del" class, if quantity = 1 -->
	                                    <input type="text" name="" value="1">
	                                    <a href="" title class="plus"></a>
	                                </div>
	                            </td>
	                            <td class="all-price">1 234 Ft</td>
	                        </tr>
							<tr>
	                            <td colspan="3" class="prod-name prod-all">Termékek összesen</td>
	                            <td class="all-price">123 456 Ft</td>
	                        </tr>
						</table>
						<div class="cart-order">
							<a href="" title="" class="cart-order-btn">Kosár &amp; megrendelés</a>
						</div>
					</div>
				</div>

			</div>

		</div>
	</header>
	<!-- end: header -->

	<!-- start: main -->
	<main class="main">
		<div class="wrap">

		<?php
			$url = @$_GET['lap'];
			switch($url)
			{

				case "checkout": include "checkout.html"; break;
				case "registration": include "registration.html"; break;
				case "new-password": include "new-password.html"; break;
				case "login": include "login.html"; break;
				case "news": include "news.html"; break;
				case "static": include "static.html"; break;
				case "product": include "product.html"; break;
				case "product-list": include "product-list.html"; break;

				default: include("home.html"); break;
			}
		?>

		</div>
	</main>
	<!-- end: main -->

	<!-- start: footer -->
	<footer class="footer">

		<div class="wrap">

			<div class="footer-boxes">

				<div class="box-container">
					<div class="box">
						<div class="box-title">Rólunk</div>
						<div class="box-content">
							<p>A Honda Szallerbeck ismételten egyedülállóan gondolkodik. Miért? Míg mások kivárással taktikáznak, addig ő új motoros ruha üzletének megnyitásával, melynek neve „Szallerbeck Motor” már a jövőt idézi. Hisz abban, hogy a motorosok idén is megállíthatatlanul fogják róni a kilométereket. S tudja, az okos motoros felkészül a szezonra. S mielőtt a végtelen kalandoknak nekivágna, nemcsak a biztonságára gondol, hanem figyelmet fordít a komfortérzetre, kényelemre is.</p>
							<p><a href="" title="" class="more">Bővebben rólunk</a></p>
						</div>
					</div>
				</div>

				<div class="box-container">
					<div class="box">
						<div class="box-title">Termékkategóriák</div>
						<div class="box-content">
							<p>
								<a href="" title="">Újdonságok</a>, <a href="" title="">Akciós termékek</a>, <a href="" title="">Kifutó termékek</a>, <a href="" title="">Motors ruházat</a>, <a href="" title="">Motorkerékpárok</a>, <a href="" title="">Bőrcsizmák</a>, <a href="" title="">Bőrkesztyűk</a>, <a href="" title="">Vásárlási utalvány</a>, <a href="" title="">Kiegészítők</a>, <a href="" title="">Ápolószerek</a>
							</p>
							<p><a href="" title="" class="more">Minden termékkategóra</a></p>
						</div>
					</div>
					<div class="box">
						<div class="box-title">Termékkategóriák</div>
						<div class="box-content">
							<p>
								<a href="" title="">Honda</a>, <a href="" title="">Kochmann</a>, <a href="" title="">Forcefield</a>, <a href="" title="">Daytona</a>, <a href="" title="">Bandit</a>, <a href="" title="">Fokt</a>, <a href="" title="">Krauser</a>, <a href="" title="">Hepco & Becker</a>, <a href="" title="">Bagster</a>, <a href="" title="">Abus</a>
							</p>
							<p><a href="" title="" class="more">Minden márka</a></p>
						</div>
					</div>
				</div>

				<div class="box-container">
					<div class="box">
						<div class="box-title">Kövess minket Facebookon!</div>
						<div class="box-content">
							<div class="fb-page" data-href="https://www.facebook.com/hondaszallerbeck/" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/hondaszallerbeck/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/hondaszallerbeck/">Honda Szallerbeck márkakereskedés és szerviz</a></blockquote></div>
						</div>
					</div>
				</div>

				<div class="box-container">
					<div class="box">
						<div class="box-title">Elérhetőségeink</div>
						<div class="box-content">
							<p><strong>Szallerbeck Motor Kft.</strong></p>
							<p>
								Cím: 1185 Budapest, Üllői út 812.<br>
								Tel., fax: <a href="" title="">+36 1 291 5555</a>, <a href="" title="">+36 1 290 3113</a><br>
								Mobil: <a href="" title="">+36 70 415 1063</a><br>
								E-mail: <a href="" title="">info@szallerbeckmotor.hu</a><br>
								Skype: <a href="" title="">@szallerbeckmotor</a>
							</p>
							<p><strong>Nyitva tartás</strong></p>
							<p>Hétfő - Péntek: 8 - 17 óráig<br>
								Szombat: 9 - 13 óráig<br>
								Vasárnap: Zárva
							</p>
						</div>
					</div>
				</div>

			</div>

		</div>

		<div class="copyright">
			<div class="wrap clearfix">
					<div class="left">&copy; 2019. Szallerbeck Motor - Minden jog fenntartva!</div>
					<div class="right">
						<a href="#top" title="" class="go-to-top"></a>
					</div>
			</div>
		</div>

	</footer>
	<!-- end: footer -->

	<!-- start: seo-content -->
	<section class="seo-content">
		<div class="wrap clearfix">
			<div class="left">
				<h1>Motoros ruha a Honda Szallerbecknél</h1>
				<p>A Honda Szallerbeck ismételten egyedülállóan gondolkodik. Miért? Míg mások kivárással taktikáznak, addig ő új motoros ruha üzletének megnyitásával, melynek neve „Szallerbeck Motor” már a jövőt idézi. Hisz abban, hogy a motorosok idén is megállíthatatlanul fogják róni a kilométereket. S tudja, az okos motoros felkészül a szezonra. S mielőtt a végtelen kalandoknak nekivágna, nemcsak a biztonságára gondol, hanem figyelmet fordít a komfortérzetre, kényelemre is.</p>
				<p>Micsoda? Lehet kényelemről beszélni a motoron? A motorozással nem jár együtt a szűk motoros ruha izzasztó szorítása? Az eső áztatta motoros ruhában való didergés? Egyáltalán, valóban képes volna egy motoros ruha megvédeni a motoros testi épségét?
				Nos kedves motoros Barátom, bízz bennünk! Emeleti motoros ruha üzletünkben teljes motoros felszerelést és motoros kiegészítőket kínálunk számodra. Üzletünk célja, egy olyan minden motoros számára elérhető magas színvonalú kínálat felvonultatása, ahol a motorosok számos felmerülő igényeire, esetleges problémáira megoldást talál.</p>
				<p>Olyan piacvezető, magas színvonalú motoros ruhák közül választhattok, mint a Bering, a BLH, a Segura vagy a Honda. Ezen márkákon belül megtaláljátok a kordura motoros kabátoktól, motoros bőrdzsekiktől, motoros csizmáktól, motoros cipőktől kezdve, a profi teljes protektoros motoros versenyruhákig, motoros nadrágig mindent. Motoros alsóruházati termékeket a Köhler palettájáról tudtok választani. Motoros bukósisak választékunkról olyan neves gyártók, mint a Shark és a Bandit gondoskodik.</p>
				<p>Motoros csizmapalettánk széles választékát a Daytona és a Kochmann modelljeiből találod meg.</p>
			</div>
			<div class="right">
				<p>Forgalmazzuk továbbá a motoros protektorgyártásban egyedülálló Forcefield protektorokat. Motorozás közben a szemed védelméről pedig a Helly vagy a Spexx motoros szemüvegeivel gondoskodhatsz.</p>
				<p>Hogy a motorodról se feledkezz meg, öltöztesdd fel az egyedi gyártású, motoros bőrdíszműves Fokt, kézzel készült termékeivel, vagy válogass a Cameron, Krauser, vagy a Hepco & Becker motoros nyeregtáskáibóll, motoros tankvédőiből, motoros hátizsákjaiból.</p>
				<p>Továbbá motorod ápolt megjelenéséről, és kifogástalan állapotáról az S100-as motoros ápolószereivel gondoskodhatsz. Biztonságáért pedig a Master Lock és Abus termékei felelnek. Csapatod menet közbeni gondtalan kommunikációját az Interphone kihangosító teszi lehetővé.</p>
				<p>Nálunk a Western/Chopper stílust képviselő motorosoktól kezdve a vagány sportmotorosokon át, egészen a rengeteget utazó túramotorosokig mindenki megtalálja a neki megfelelő motoros ruhát, kiegészítő motoros felszerelést, ráadásul mindezt egy helyen a Szallerbeck Motor-nál!</p>
				<p>Gyere el hozzánk és győződj meg magad, a minőségi és ugyanakkor biztonságos, kényelmes motoros ruha fontosságáról. Nálunk teljes körű szakértelmet, kiszolgálást, abszolút minőséget és nem utolsó sorban az igényeidet szem előtt tartó lehetőségeket kínálunk a motoros termékeink végtelen variációjával. Lehetőség van tanácsadás kérésére is, hogy Neked személy szerint, a motortípusodhoz, motorozási stílusodhoz, milyen motoros felszerelésre lenne szükséged.</p>
				<p>Tehát kedves Motoros Barátom ne tétovázz! Ha nem hiszel e sorok írójának, gyere és győződj meg a saját szemeddel mindezekről!
				<p>Motoros üdvözlettel:  Szallerbeck Motor</p>
			</div>
		</div>
	</section>
	<!-- end: seo-content -->

	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>

	<!-- Slick -->
	<script type="text/javascript" src="slick/slick.min.js"></script>

	<!-- script -->
	<script type="text/javascript" src="js/honda-webshop.js"></script>

</body>
</html>
