<?php include('tema_valtozok.php');?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title><?= ws_seo('cim'); ?></title>
	<meta name="description" content="<?= ws_seo('leiras'); ?>">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="<?= beallitasOlvasas('google-signin-client_id')?>">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
	
	<!-- FACEBOOK LOGIN -->
		<script>
		window.fbAsyncInit = function() {
			FB.init({
			appId      : '<?= beallitasOlvasas('facebook-app-id');?>',
			cookie     : true,
			xfbml      : true,
			version    : 'v3.2'
			});
      
			FB.AppEvents.logPageView();   
      
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "https://connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>	

	<!-- Fonts -->

	<!-- Fonts -->

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/honda/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/honda/css/extra.css?r=1">
		<!-- Slick -->
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/honda/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/honda/slick/slick-theme.css"/>
	<!-- CSS -->

	<!-- jQuery & jQUI for sortable -->
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<?= globalisMemoria("fejlec-scriptek");?>
</head>
<body id="top">
	<div class="loading">Loading&#8230;</div>
	
	<!-- start: fb plugin -->
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v3.2"></script>
	<!-- end: fb plugin -->

	<!-- start: header -->
	<header class="header">
		<div class="wrap">

			<div class="header-container">

				<a href="<?= base_url();?>" title="" class="logo logo-motor"></a>
				<a href="<?= base_url();?>" title="" class="karsa-logo"></a>

				<div class="mobile-menu"></div>
				<div class="login-menu"></div>
				<div class="search-menu"></div>
				<a href="" title="" class="cart-menu"></a>
				<?php if($fejleclink_felirat!=""):?>
				<div class="back-to-homepage">
					<a href="<?= $fejleclink_url; ?>" title=""><?= $fejleclink_felirat;?></a>
				</div>
				<?php endif; ?>

				<div class="search-login">
					<div class="search">
						<input type="text" id="top-search" placeholder="Keresés..." onchange="window.location.href='<?= base_url(); ?>kereses/'+$(this).val();">
						<label for="top-search"></label>
					</div>
					<div class="login">
						<?php $tag = ws_belepesEllenorzes(); if($tag):?>
						<a href="<?= base_url();?>?logout" title="Kilépés">Kilépés</a>
						<a href="<?= base_url();?>fiokom" title="Kilépés">Fiókom</a>
						
						<?php if($tag->adminjogok>0):?>
						
						<a href="<?= base_url().beallitasOlvasas('ADMINURL');?>" target="_blank" title="Kilépés">Admin</a>
						<?php endif;?>
						<?php else : ?>
						<a href="<?= base_url();?>regisztracio" title="Regisztráció">Regisztráció</a>
						<a href="<?= base_url();?>belepes" title="">Bejelentkezés</a>
						<?php endif; ?>
					</div>
				</div>

				<nav class="nav">
					<ul>
						
						<?php foreach(ws_frontendMenupontok(1) as $sor):?>
						<li><a href="<?= base_url().$sor->url;?>" title="<?= $sor->felirat;?>" class="<?= $sor->aktiv==true?'active':'';?>"><?= $sor->felirat; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>

				<div class="cart kosarwidget">
					
				</div>

			</div>

		</div>
	</header>
	<!-- end: header -->

	<!-- start: main -->
	<main class="main">
		<div class="wrap">
			<!-- start: breadcrumb -->
			<div class="breadcrumb">
				<ul>
					<li><a href="<?= base_url(); ?>" title="">Főoldal</a></li>
					<?php $utvonal = globalisMemoria('utvonal');if($utvonal):foreach($utvonal as  $elem):?>
					<li>
						<?php if(isset($elem['url'])): ?>
						<a href="<?= base_url(). $elem['url'];?>" title="<?= $elem['felirat'];?>"><?= $elem['felirat'];?></a>
						<?php else: ?>
						<?= $elem['felirat'];?>
						<?php endif; ?>
					</li>
					<?php endforeach;endif; ?>
				</ul>
			</div>
			
			<?= $modulKimenet; ?>

		</div>
	</main>
	<!-- end: main -->

	<!-- start: footer -->
	<footer class="footer">

		<div class="wrap">

			<div class="footer-boxes">

				<div class="box-container">
					<div class="box">
						<div class="box-title"><?= $doboz1_cim;?></div>
						<div class="box-content">
							<p><?= $doboz1_szoveg;?></p>
							<p><a href="<?= base_url().$doboz1_linkurl ?>" title="<?= $doboz1_linkszoveg;?>" class="more"><?= $doboz1_linkszoveg;?></a></p>
						</div>
					</div>
				</div>

				<div class="box-container">
					<div class="box">
						<div class="box-title"><?= $doboz2_cim;?></div>
						<div class="box-content">
							<p><?= $doboz2_szoveg;?></p>
							<p><a href="<?= base_url().$doboz2_linkurl ?>" title="<?= $doboz2_linkszoveg;?>" class="more"><?= $doboz2_linkszoveg;?></a></p>
						</div>
					</div>
				</div>

				
					
				

				<div class="box-container">
					<div class="box">
						<div class="box-title"><?= $doboz3_cim;?></div>
						<div class="box-content">
							<div class="fb-page" data-href="<?= $doboz3_fburl;?>" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?= $doboz3_fburl;?>" class="fb-xfbml-parse-ignore"><a href="<?= $doboz3_fburl;?>"><?= $doboz3_fburl;?></a></blockquote></div>
						</div>
					</div>
				</div>

				<div class="box-container">
					<div class="box">
						<div class="box-title"><?= $doboz4_cim;?></div>
						<div class="box-content">
							<?= $doboz4_html;?>
						</div>
					</div>
				</div>

			</div>

		</div>

		<div class="copyright">
			<div class="wrap clearfix">
					<div class="left"><?= $footercopyright; ?></div>
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
			<?= nl2br(ws_seo('hosszuleiras'));?>
		</div>
	</section>
	<!-- end: seo-content -->



	<!-- script -->
	<script type="text/javascript" src="<?= base_url().TEMAMAPPA;?>/honda/slick/slick.min.js"></script>
	<script type="text/javascript" src="<?= base_url().TEMAMAPPA;?>/honda/js/honda-webshop.js"></script>
	
<script>
function isEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function base_url() { return '<?= base_url(); ?>';}
	
	</script>
	<script>
var siteJs = {};


	siteJs.darabszamLapozo = function(irany, maximum) {
		db = parseInt($('.kosar_db').val());
		if(irany == -1 && db == 1) return;
		if(maximum!=0){
			if((irany+db)>maximum) return;
		} 
		db += irany;
		$('.kosar_db').val(db);
		this.arKalkulacio();
	};
	siteJs.kosarElokeszites = function(){
		$('.kosar_valtozat').change(function(){ siteJs.arKalkulacio();})
		$('.kosar_opcio').change(function(){ siteJs.arKalkulacio();})
		$('.kosar_elkuldes').click(function(){ siteJs.kosarMentes();})
	};
	
	siteJs.arKalkulacio = function() {
		alapar = parseInt($('#kosar_alapar').val());
		// van valtozat?
		v = $('.kosar_valtozat');
		if(v[0]) {
			valtozatar =  parseInt($(v[0].options[v[0].selectedIndex]).attr('data-valtozatar'));
			if(valtozatar>0) alapar = valtozatar;
			
		}
		db = parseInt($('.kosar_db').val());
		ar = alapar*db;
		
		
		v = $('.kosar_opcio');
		if(v[0]) {
			for(i = 0; i < v.length; i++) {
				if($(v[i]).prop('checked')){
					ar += parseInt($(v[i]).attr('data-opcioar'))*db;
				}
			}
			
		}
		
		$('.kosar_osszar').html(this.formatMoney(ar));
	};
	siteJs.formatMoney = function(number) {
		
		if(typeof Intl.NumberFormat() !=="object") return number;
		
		const formatter = new Intl.NumberFormat('hu-HU', {
			style: 'currency',
			currency: 'HUF',
			minimumFractionDigits: 0
		})
		return formatter.format(number);
	}

	siteJs.kosarTermekTorles = function(kosarId) {
		$.post(base_url()+'/kosarajax', {'termektorles':kosarId} , function(e) {
			siteJs.kosarOldalTermeklistaFrissites();
		});
	}
	siteJs.kosarOldalTermeklistaFrissites = function() {
		$('.kosarOldalTermeklista').load('<?= base_url();?>kosar?ajax=1&termeklista=1');
	};
	siteJs.kosarMentes = function() {
		siteJs.fatyolStart();
		adat = {
			"termek_id" : $('.kosar_elkuldes').attr('data-termekid'),
			"db" : parseInt($('.kosar_db').val()),
			"opciok" : []
			
		}
		// van valtozat?
		v = $('.kosar_valtozat');
		if(v[0]) {
			adat.valtozat = parseInt($(v[0].options[v[0].selectedIndex]).val());
			
		}
		// van valtozat 2?
		v = $('.kosar_valtozat2');
		if(v[0]) {
			adat.valtozat2 = parseInt($(v[0].options[v[0].selectedIndex]).val());
			
		}
		v = $('.kosar_opcio');
		if(v[0]) {
			for(i = 0; i < v.length; i++) {
				if($(v[i]).prop('checked')){
					adat.opciok.push({ "termek_armodositok_id" : $(v[i]).val() })
					
				}
			}
			
		}
		$.post(base_url()+'/kosarajax?beepulofuttatas=1', {'kosarajax':adat} , function(e) {
			siteJs.kosarPanelFrissites() ;
			$([document.documentElement, document.body]).animate({
				scrollTop: $('.kosarwidget').offset().top
			}, 1000);
			
			$('.cart-btn').parent().toggleClass('cart-open');
		});
		
	}
	siteJs.kosarPanelFrissites = function() {
		$.post(base_url()+'/kosarwidget?beepulofuttatas=1', {} , function(html) {
			if(html!='') {
				$('.kosarwidget').html(html);
				siteJs.kosarWidgetStart();
				siteJs.fatyolStop();
			}
		});
	}
	siteJs.kosarWidgetStart = function() {
		$('.cart-btn').click(function() {
			$(this).parent().toggleClass('cart-open');
			return false;
		});
	}
	
	siteJs.kosarDarabModositas = function(id, mod ) {
		siteJs.fatyolStart();
		$.post(base_url()+'/kosardarabmod?beepulofuttatas=1', { id: id, mod: mod } , function(e) {
			siteJs.kosarPanelFrissites();
			o = $('#nagykosar');
			if(o.length>0) {
				$('#nagykosar').load(base_url()+'/nagykosarfrissites?beepulofuttatas=1', function() { siteJs.fatyolStop(); } );
				siteJs.nagykosarOsszarFrissites();
				
			} else {
				siteJs.fatyolStop();
			}
			$('.szallitasmodar').load(base_url()+'/armodositoar?beepulofuttatas=1', { mod:'szallitasmod'});
			$('.fizetesmodar').load(base_url()+'/armodositoar?beepulofuttatas=1', { mod:'fizetesmod'});
			
		});
	}
	
	siteJs.nagykosarOsszarFrissites = function () {
		$('.price-summ').load(base_url()+'/nagykosarosszar?beepulofuttatas=1' , function() {
			siteJs.fatyolStop();
		});
	}
	siteJs.kosarOsszarKalkulacio = function () {
		// szállítás, fizetés mód állításkor hívjuk
		szmod = $('#szallitasmod').val();
		fmod = $('#fizetesmod').val();
		siteJs.fatyolStart();
		
		$.post(base_url()+'/kosarosszarfrissites?beepulofuttatas=1', { szmod: szmod, fmod: fmod } , function(e) {
			siteJs.nagykosarOsszarFrissites();
			$('.szallitasmodar').load(base_url()+'/armodositoar?beepulofuttatas=1', { mod:'szallitasmod'});
			$('.fizetesmodar').load(base_url()+'/armodositoar?beepulofuttatas=1', { mod:'fizetesmod'});
			
		});
		
	}
	siteJs.kuponvizsgalat = function () {
		// szállítás, fizetés mód állításkor hívjuk
		kuponkod = $('#kuponkod').val();
		siteJs.fatyolStart();
		
		$.post(base_url()+'/kuponkod?beepulofuttatas=1', { kuponkod: kuponkod } , function(e) {
			
			json = JSON.parse(e);
			console.log(json);
			
			siteJs.nagykosarOsszarFrissites();
			siteJs.fatyolStop();
			if(json.result=='ok') {
				$('.kuponkedvezmenyosszeg').load(base_url()+'/armodositoar?beepulofuttatas=1', { mod:'kuponkod'});
			
			} else {
				$('.kuponkedvezmenyosszeg').html(json.hiba);
			}
			
		});
		
	}
	siteJs.fatyolStop = function() {
		$('.loading').fadeOut(400);
	}
	siteJs.fatyolStart = function() {
		$('.loading').show();
	}
	siteJs.validateEmail = function(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(String(email).toLowerCase());
	}
	siteJs.rendelesEllenorzes = function() {
		$('.error').removeClass('error');
		inp = $('.req');
		for(i = 0; i < inp.length; i++ ) {
			o = inp[i];
			
			hiba = false;
			
			if($(o).hasClass('checkemail')) {
				console.log(o);
				if(!siteJs.validateEmail($(o).val() )) {
					hiba = true;
				}
			} else if($(o).hasClass('checkbox')) {
				
				if(!o.checked) {
					hiba = true;
				}
			} else if($(o).val()=='') {
				hiba = true;
			}
			if(hiba) {
				$(o).parent().addClass('error');
			}
		}
		am = $('.armodositok');
		
		for(i = 0; i < am.length; i++) {
			console.log($(am[i]).val());
			if($(am[i]).val()=='0') {
				
				$(am[i]).parent().addClass('error');
				hiba = true;
			} 
		}
		if(hiba) {
			el = $('.error');
			 $([document.documentElement, document.body]).animate({
				scrollTop: $(el[0]).offset().top
			}, 1000);
		} else {
			$('#rendelesForm').submit();
		}
	}
	
	siteJs.kosarPanelFrissites();
	$().ready(function(){ siteJs.fatyolStop(); window.onbeforeunload = function(event) {  siteJs.fatyolStart(); };});
	</script>
	<?= globalisMemoria('lablec-scriptek'); ?>
</body>
</html>



	
