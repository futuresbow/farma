<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Webshop Admin</title>
	<meta name="description" content="">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Raleway:600,700&amp;subset=latin-ext" rel="stylesheet">
	<!-- Fonts -->

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?= $stilusUrl;?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?= $stilusUrl;?>css/extra.css">
	<!-- CSS -->

	<!-- jQuery & jQUI for sortable -->

	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>	<?= globalisMemoria('headerScripts');?>
</head>
<body>
<div class="loading">Loading&#8230;</div>
	
	<!-- start: header -->
	<header class="header">
		<div class="mobile-menu">
			<div class="menu-icon"></div>
		</div>
		<div class="logo-container">
			<a href="?lap=" title="" class="logo">
				<img src="<?= $stilusUrl;?>img/logo-sample.svg" alt="LOGO">
			</a>
		</div>
		<div class="control-container">
			
			<div class="search">
				<!--
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
					<a href="?lap=" title="Keresés törlése" class="search-delete" style="display:none"></a>
				</div>
				
				-->
			</div>
			<!--
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
			-->
			<div class="profile">
				<?php $tag = ws_belepesEllenorzes(); ?>
				<div class="profile-btn">
					<div class="img-container">
						<?= $tag->monogram();?>
						<div class="user-pic" style="background-image:url('pics/me.jpg');"></div>
					</div>
					<div class="user-name"><?= $tag->teljesNev();?></div>
				</div>
				<div class="profile-dropdown">
					<ul>
						
						<li><a href="<?= ADMINURL; ?>felhasznalok/kilepes" title="">Kijelentkezés</a></li>
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
				<?php $ci = getCI(); $foMenuk = $ci->Sql->gets('adminmenu', " WHERE szulo_id = 0 ORDER BY sorrend ASC");?>
				
				
				<?php $tag = ws_belepesEllenorzes(); foreach($foMenuk as $menupont): if(!$tag->is($menupont->jogkor)) continue;?>
				<?php $alMenuk = $ci->Sql->gets('adminmenu', " WHERE szulo_id = ".$menupont->id." ORDER BY sorrend ASC ");?>
				
				<?php if($alMenuk): ?>
				
				<li class="<?= (strtolower(globalisMemoria("Nyitott menüpont"))==strtolower($menupont->felirat))?'active':''; ?>"><a href="" class="<?= $menupont->ikonosztaly;?> <?= (!empty($alMenuk))?'nav-dropdown':'';?>"><?= $menupont->felirat;?></a>
				
				<ul>
				<?php foreach($alMenuk as $menupont): if(!$tag->is($menupont->jogkor)) continue;?>
					<?php if($menupont->modul_eleres=='elvalaszto')  {?>
					<li class="separator"></li>
					<?php } elseif($menupont->felirat=='dinamikus') { 
						ws_autoload($menupont->modul_eleres); 
						$fnc = $menupont->modul_eleres.'_adminmenu' ;
						$mlista = $fnc(); if($mlista)foreach($mlista as $msor) {?>
					
					<li class=""><a href="<?= $msor->modul_eleres?>"><?= $msor->felirat;?></a></li>

					<?php } } else { ?>
					<li><a href="<?= ADMINURL.$menupont->modul_eleres;?>" ><?= $menupont->felirat;?></a></li>
					<?php } ?>
				<?php endforeach;?>
				</ul>
				</li>
				<?php else:?>
				<li><a href="<?= ADMINURL.$menupont->modul_eleres; ?>" class="<?= $menupont->ikonosztaly;?> <?= (!empty($alMenuk))?'nav-dropdown':'';?>"><?= $menupont->felirat;?></a></li>
				
				<?php endif;?>
				
				<?php endforeach;?>
				
				
			</ul>
		</nav>
		<!-- end: nav -->

		<!-- start: main -->
		<main class="main">

			<div class="breadcrumb">
				<ul>
					<li><a href="<?= ADMINURL; ?>" title="">Központ</a></li>
					<?php $utvonal = globalisMemoria('utvonal');if($utvonal):foreach($utvonal as  $elem):?>
					<li>
						<?php if(isset($elem['url'])): ?>
						<a href="<?= ADMINURL. $elem['url'];?>" title="<?= $elem['felirat'];?>"><?= $elem['felirat'];?></a>
						<?php else: ?>
						<?= $elem['felirat'];?>
						<?php endif; ?>
					</li>
					<?php endforeach;endif; ?>
				</ul>
				<div class="public-link">
					<a href="<?= base_url();?>" target="_blank" title="">Webshop megtekintése</a>
				</div>
			</div>
			<?php if($this->input->get('m')):?>
				<div class="alert <?= ($this->input->get('c')=='hiba')?' alert-error ':'';?>"><?= $this->input->get('m'); ?></div>
			<?php endif;?>			<?php if(globalisMemoria('adminUzenet')): ?>
				<div class="alert" ><?= globalisMemoria('adminUzenet'); ?></div>
			<?php endif;?>
			<!-- start: main content -->
			<div class="content">
				
				<?= $modulKimenet; ?>

			</div>
			<!-- end: main content -->

		</main>
		<!-- end: main -->

	</div>


	<!-- script -->
	<script type="text/javascript" src="<?= $stilusUrl;?>js/webshop.js"></script>

	<!-- Fancybox -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.css" />
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js"></script>
	
	<link href="<?= $stilusUrl;?>js/bootstrap-colorpicker-2.5.3/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <script src="<?= $stilusUrl;?>js/bootstrap-colorpicker-2.5.3/dist/js/bootstrap-colorpicker.js"></script>
   
	
	<!-- scripts -->
	 <script>

function adminJs() {
	this.opcioHozzaadas = function(tid, tipus) {
		adatok = $('.termekForm').serialize() ;
		$.post('<?= ADMINURL?>termek/valtozatesopcio/'+tid+'?ajax=1&tipus='+tipus, adatok, function(r){
			$('.valtozat_es_opcio').html(r);
		});
	}
	this.opcioBetoltes = function(tid, tid2) {
		adatok = $('.termekForm').serialize() ;
		$.post('<?= ADMINURL?>termek/valtozatesopcio/'+tid+'?ajax=1&masolat='+tid2, adatok, function(r){
			$('.valtozat_es_opcio').html(r);
		});
	}
	
	this.kelFeltoltes = function(mpid) {
		 var fd = new FormData();
		var files = $('#imgupload')[0].files[0];
		fd.append('file',files);
		fd.append('request',1);
		fd.append('mpid',mpid);

		// AJAX request
		$.ajax({
			url: '<?= ADMINURL; ?>termek/imageupload/'+mpid+'?ajax=1',
			type: 'post',
			data: fd,
			contentType: false,
			processData: false,
			success: function(response){
				if(response != 0){
					aJs.kepgaleria(response);
				}else{
				alert('Nem sikerült a kép feltöltése');
				}
			}
		});
	}
	
	this.ajaxKepFeltoltes = function(id, url) {
		
		 var fd = new FormData();
		var files = $('#'+id)[0].files[0];
		fd.append('file',files);
		fd.append('request',1);
		
		// AJAX request
		$.ajax({
			url: url+'?ajax=1',
			type: 'post',
			data: fd,
			contentType: false,
			processData: false,
			success: function(response){
				if(response != 0){
					
					$('.ajaxVisszairas').html(response);
					$('.ajaxfile').val();
				}else{
					alert('A feltöltés nem sikerült');
					$('.ajaxfile').val();
				}
			}
		});
	}
	
	this.kepgaleria = function(response) {
		mpid = tid;
		var lista = JSON.parse(response);
		$('.kepkonyvtar').html('');
		console.log(lista);
		for(i = 0; i < lista.length; i++) {
			kep = lista[i];
			img = $('<img data-kep="'+kep.id+'" class="galeriakep" src="<?= base_url(); ?>'+kep.file+'" />');
			$(img).css('margin', '5px');
			$(img).click(function(){ $('#kepparamimput').val($(this).attr('data-kep'));$('.galeriakep').removeClass('kepborder');$(this).addClass('kepborder'); });
			blokk = $('<div class="keptaska"></div>');
			torlogomb = $('<button data-kep="'+kep.id+'" type="button" class="btn brn-danger btn-smal">Törlés</button>').
						click(function(){ $.post('<?= ADMINURL; ?>termek/keptorles/'+mpid+'?ajax=1', {'kep':$(this).attr('data-kep') });$(this).parent().fadeOut(); });
			$(blokk).append(img).append('<br>').append(torlogomb);
			$('.kepkonyvtar').append(blokk);
		}
	}	this.kepHuzasInditas = function(tid) {
		var dropZone = document.getElementById('dropZone');

		// Optional.   Show the copy icon when dragging over.  Seems to only work for chrome.
		dropZone.addEventListener('dragover', function(e) {
			e.stopPropagation();
			e.preventDefault();
			e.dataTransfer.dropEffect = 'copy';
		});

		// Get file data on drop
		dropZone.addEventListener('drop', function(e) {
			e.stopPropagation();
			e.preventDefault();
			var files = e.dataTransfer.files; // Array of all files
			aJs.fatyolStart();
			for (var i=0, file; file=files[i]; i++) {
				if (file.type.match(/image.*/)) {
					var reader = new FileReader();

					reader.onload = function(e2) {
						// finished reading file data.
						var img = document.createElement('img');
						// e2.target.result;
						
						$.post('<?= ADMINURL; ?>termek/imageupload/'+editedTid+'?ajax=1', {file:e2.target.result, tid:editedTid}, function(r) { 
							aJs.kepgaleria(r);
							aJs.fatyolStop();
						});
						
					}

					reader.readAsDataURL(file); // start reading the file data.
				}
			}
		});
	}
	this.termekHozzaadas = function(rid,o) {
		this.readOnly();
		id = $(o).val();
		$.get('<?= ADMINURL; ?>rendelesek/termekhozzadas/'+rid+'?tid='+id+'&ajax=1', function (r) {
			if(r!=1) {
				alert("Hiba a termék hozzáadásánál!");
			} else {
				$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termeklista/'+rid+'?&ajax=1');
			}
			aJs.nemReadOnly();
		});
	}
	this.rendelesKoltsegHozzaadas = function(rid,o) {
		id = $(o).val();
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/koltseghozzaadas/'+rid+'?koltsegtipus='+id+'&ajax=1');
	}
	this.rendelesArmodositoTorles = function(rid,mid) {
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/armodositotorles/'+rid+'?mid='+mid+'&ajax=1');
	}
	this.rendelesTermeklista = function(rid) {
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termeklista/'+rid+'?&ajax=1');
	}
	
	this.rendelesTermekDb = function(rid, tid, mod) {
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekdarabmodositas/'+rid+'?tid='+tid+'&mod='+mod+'&ajax=1');
	}
	
	this.rendelesTermekValtozatMentes = function(rid, tid, o) {
		vid = $(o).prev('select').val();
		
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekvaltozatmodositas/'+rid+'?tid='+tid+'&vid='+vid+'&ajax=1');
	}
	this.rendelesTermekValtozatMentes2 = function(rid, tid, o) {
		vid = $(o).prev('select').val();
		
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekvaltozatmodositas/'+rid+'?tid='+tid+'&vid='+vid+'&ajax=1');
	}
	
	this.rendelesValtozatTorles = function(rid, tid, vid) {
		this.readOnly();
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/rendelesvaltozattorles/'+rid+'?tid='+tid+'&vid='+vid+'&ajax=1',function(){
			aJs.nemReadOnly();
		});
	}
	
	this.rendelesValtozatTorles2 = function(rid, tid, vid) {
		this.readOnly();
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/rendelesvaltozattorles/'+rid+'?tid='+tid+'&vid='+vid+'&ajax=1',function(){
			aJs.nemReadOnly();
		});
	}
	
	this.rendelesOpcioTorles = function(rid, tid, oid) {
		this.readOnly();
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekopciotorles/'+rid+'?tid='+tid+'&oid='+oid+'&ajax=1',function(){
			aJs.nemReadOnly();
		});
	}
	this.readOnly = function() {
		$('input').attr('readonly', true).fadeTo( "slow" , 0.5);
		$('select').attr('readonly', true).fadeTo( "slow" , 0.5);
		$('textarea').attr('readonly', true).fadeTo( "slow" , 0.5);
		
	}
	this.nemReadOnly = function() {
		$('input').prop('readonly', false).fadeTo( "slow" , 1);
		$('select').attr('readonly', false).fadeTo( "slow" , 1);
		$('textarea').attr('readonly', false).fadeTo( "slow" , 1);
		
	}
	this.rendelesArmodositoModositas = function(rid) {
		this.readOnly();
		$.post('<?= ADMINURL; ?>rendelesek/armodositomodositas/'+rid+'?ajax=1', $('#rendelesForm').serialize(),function() {
			$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termeklista/'+rid+'?ajax=1', function(){
				aJs.nemReadOnly();
			});
		});

	}
	this.cikkszamGeneralas = function() {
		$('#cikkszamertek').val(this.unicID());
	}	this.unicID = function () {
  // Math.random should be unique because of its seeding algorithm.
  // Convert it to base 36 (numbers + letters), and grab the first 9 characters
  // after the decimal.
  return Math.random().toString(36).substr(2, 3).toUpperCase()+"-"+Math.random().toString().substr(2, 4);
};
	this.rendelesTermekOpcioMentes = function(rid, tid, o) {
		this.readOnly();
		oid = $(o).prev('select').val();
		
		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekopciomodositas/'+rid+'?tid='+tid+'&oid='+oid+'&ajax=1', function() {
			aJs.nemReadOnly();
		});
	}
	this.cimMasolas = function() {
		$('#szall_nev').val($('#szaml_nev').val());
		$('#szall_orszag').val($('#szaml_orszag').val());
		$('#szall_telepules').val($('#szaml_telepules').val());
		$('#szall_utca').val($('#szaml_utca').val());
		$('#szall_irszam').val($('#szaml_irszam').val());
		
	}
	this.fatyolStop = function() {
		$('.loading').fadeOut(400);
	}
	this.fatyolStart = function() {
		$('.loading').show();
	}	this.bruttoSzamitas = function() {
		
		ar = Number($('#arertek').val());
		afa = Number($('#afaertek').val());
		brutto = 0;
		if(afa!=0){
			brutto = ar + ((ar/100)*afa);
		} 
		$('#bruttoertek').val(brutto);
		return brutto;
	}
	this.jellemzoBetoltes = function(csoportid, tid) {
		
		
		$('#jellemzo_szerkeszto').load('<?= ADMINURL; ?>termek/jellemzoform/'+tid+'?ajax=1&csoportid='+csoportid );

	};
		
		
	
	this.nettoSzamitas = function() {
		
		ar = Number($('#bruttoertek').val());
		afa = Number($('#afaertek').val());
		netto = 0;
		if(afa!=0){
			netto = ar/( 1 + afa/100 );
			netto = (parseInt(netto*100))/100;
		} 
		$('#arertek').val(netto);
		return netto;
	}
	this.keszletNoveles = function(o, mod) {
		
		inp = $(o).parent().find('input') ;
		db = parseInt($(inp).val())+mod;
		console.log(db);
		if(db<=0) {
			$(inp).val(0);
		} else {
			$(inp).val(db)
		}
	}
}

var aJs = new adminJs();

	$().ready(function(){ aJs.fatyolStop(); window.onbeforeunload = function(event) {  aJs.fatyolStart(); };});
	
</script>

<script>
    $().ready(function () {
      // Basic instantiation:
      $('.cpic').colorpicker({
		   format: 'hex'
	});
});

      
    
  </script>
  
  <script>
$('.mcpic').colorpicker({
	format: 'hex'
});
</script>

</body>
</html>

