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
	siteJs.kosarMentes = function() {
		siteJs.fatyolStart();
		adat = {
			"termek_id" : $('.kosar_elkuldes').attr('data-termekid'),
			"db" : parseInt($('.kosar_db').val()),
			"opciok" : []
			
		}
		if(isNaN(adat.db)) adat.db = 1;
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
			$('#nagykosar').load(base_url()+'/nagykosarfrissites?beepulofuttatas=1');
				
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
