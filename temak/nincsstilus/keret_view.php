<?php include 'tema_valtozok.php';?><!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title><?= ws_seo('cim'); ?></title>
	<meta name="description" content="<?= ws_seo('leiras'); ?>">
	
	
	<link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/nincsstilus/extra.css">

	
	
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

			

		<nav class="nav">
			<ul>
				<?php foreach(ws_frontendMenupontok() as $sor):?>
				<li><a href="<?= base_url().$sor->url;?>" title="<?= $sor->felirat;?>" class="<?= $sor->aktiv==true?'active':'';?>"><?= $sor->felirat; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>

	</header>
	<!-- end: header -->

	<!-- start: main -->
	<main class="main">

		<?= $modulKimenet; ?>

	</main>
	<!-- end: main -->

	<!-- start: footer -->
	<footer class="footer">

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
	</footer>
	<!-- end: footer -->

	<!-- js -->
	<script src="<?= base_url().TEMAMAPPA;?>/webshop_4/js/webshop.js"></script>
	<!-- js -->
		
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
		$('.kosar_elkuldes').click(function(){ siteJs.kosarMentes(this);})
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
		$('.kosar_osszar').html(ar+" Ft");
	};
	
	siteJs.kosarTermekTorles = function(kosarId) {
		$.post(base_url()+'/kosarajax', {'termektorles':kosarId} , function(e) {
			siteJs.kosarOldalTermeklistaFrissites();
		});
	}
	siteJs.kosarOldalTermeklistaFrissites = function() {
		$('.kosarOldalTermeklista').load('<?= base_url();?>kosar?ajax=1&termeklista=1');
	};
	siteJs.kosarMentes = function(o) {
		siteJs.fatyolStart();
		db = parseInt($('.kosar_db').val());
		if(isNaN(db)) db = 1; // lista oldali kosárgomb
		tid = ($(o).attr('data-termekid'));
		adat = {
			"termek_id" : tid,
			"db" : db,
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
	siteJs.slideClick = function() {
		$('.main-pic').addClass('fullSizeImg');
	}
	siteJs.kosarPanelFrissites();
	$().ready(function(){ siteJs.fatyolStop(); window.onbeforeunload = function(event) {  siteJs.fatyolStart(); };});
	</script>
</body>

	
