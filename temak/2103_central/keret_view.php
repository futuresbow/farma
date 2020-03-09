<?php include 'tema_valtozok.php';?><!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= ws_seo('cim'); ?></title>
	<meta name="description" content="<?= ws_seo('leiras'); ?>">
    <!--

    Template 2103 Central

	http://www.tooplate.com/view/2103-central

    -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
    <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="<?= base_url().TEMAMAPPA;?>/2103_central/font-awesome-4.5.0/css/font-awesome.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url().TEMAMAPPA;?>/2103_central/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url().TEMAMAPPA;?>/2103_central/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/2103_central/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url().TEMAMAPPA;?>/2103_central/slick/slick-theme.css" />
    <link rel="stylesheet" href="<?= base_url().TEMAMAPPA;?>/2103_central/css/tooplate-style.css">
    
     <link rel="stylesheet" href="<?= base_url().TEMAMAPPA;?>/2103_central/css/extra.css">
   
    <!-- tooplate style -->
	<!-- jQuery -->
	<script src="//code.jquery.com/jquery-latest.min.js"></script>

	<!-- slick -->
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<link href="<?= base_url();?>js/slicklightbox/slick-lightbox.css" rel="stylesheet">
	<script src="<?= base_url();?>js/slicklightbox/slick-lightbox.js"></script>
	<!-- slick -->
    <script>
        var renderPage = true;

        if (navigator.userAgent.indexOf('MSIE') !== -1
            || navigator.appVersion.indexOf('Trident/') > 0) {
            /* Microsoft Internet Explorer detected in. */
            alert("Please view this in a modern browser such as Chrome or Microsoft Edge.");
            renderPage = false;
        }
    </script>

</head>

<body>
    <!-- Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <div class="container">
        <section class="tm-section-head" id="top">
            <header id="header" class="text-center tm-text-gray">
                <h1><?= $fooldalcim;?></h1>
                <p><?= $fooldalbevezeto;?></p>
            </header>

            <nav class="navbar narbar-light">
                <a class="navbar-brand tm-text-gray" href="#">
                    Menu
                </a>
                <button type="button" id="nav-toggle" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fa fa-navicon tm-fa-toggler-icon"></i>
                    </span>
                </button>
                <div id="mainNav" class="collapse navbar-collapse tm-bg-white">
                    <ul class="navbar-nav ml-auto">
						<?php foreach(ws_frontendMenupontok() as $sor):?>
						<li class="nav-item"><a href="<?= base_url().$sor->url;?>" title="<?= $sor->felirat;?>" class="nav-link tm-text-gray <?= $sor->aktiv==true?'active':'';?>"><?= $sor->felirat; ?></a></li>
						<?php endforeach; ?>
						
                        
                    </ul>
                </div>
            </nav>

            <div class="navbar navbar-default navbar-fixed-top">
                <a href="<?= base_url();?>" class="navbar-brand">logo</a>
                <div class="kosarwidget"></div>
            </div>

            <div class="collapse navbar-collapse" id="mydropdown">

                <ul class="nav navbar-nav">
                    <?php foreach(ws_frontendMenupontok() as $sor):?>
					<li ><a href="<?= base_url().$sor->url;?>" title="<?= $sor->felirat;?>" class=" <?= $sor->aktiv==true?'active':'';?>"><?= $sor->felirat; ?></a></li>
					<?php endforeach; ?>
				</ul>
            </div>
        </section>

        
		<?= $modulKimenet; ?>
        
        
        <footer class="mt-5">
            <p class="text-center">
				<?= $copyright; ?>
            </p>
        </footer>
    </div>
<script src="<?= base_url().TEMAMAPPA;?>/2103_central/js/webshop.js"></script>
    <!-- load JS files -->
    <script type="text/javascript" src="<?= base_url().TEMAMAPPA;?>/2103_central/js/jquery-1.11.3.min.js"></script>
    <script src="<?= base_url().TEMAMAPPA;?>/2103_central/js/popper.min.js"></script>
    <!-- https://popper.js.org/ -->
    <script src="<?= base_url().TEMAMAPPA;?>/2103_central/js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->
    <script type="text/javascript" src="<?= base_url().TEMAMAPPA;?>/2103_central/slick/slick.min.js"></script>
    <!-- Slick Carousel -->

    <script>
        function setCarousel() {
            var slider = $('.tm-img-slider');

            if (slider.hasClass('slick-initialized')) {
                slider.slick('destroy');
            }

            if ($(window).width() > 991) {
                // Slick carousel
                slider.slick({
                    autoplay: true,
                    fade: true,
                    speed: 800,
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                });
            } else {
                slider.slick({
                    autoplay: true,
                    fade: true,
                    speed: 800,
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                });
            }
        }

        $(document).ready(function () {
            if (renderPage) {
                $('body').addClass('loaded');
            }

            setCarousel();

            $(window).resize(function () {
                setCarousel();
            });

            // Close menu after link click
            $('.nav-link').click(function () {
                $('#mainNav').removeClass('show');
            });

            // https://css-tricks.com/snippets/jquery/smooth-scrolling/
            // Select all links with hashes
            $('a[href*="#"]')
                // Remove links that don't actually link to anything
                .not('[href="#"]')
                .not('[href="#0"]')
                .click(function (event) {
                    // On-page links
                    if (
                        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                        &&
                        location.hostname == this.hostname
                    ) {
                        // Figure out element to scroll to
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        // Does a scroll target exist?
                        if (target.length) {
                            // Only prevent default if animation is actually gonna happen
                            event.preventDefault();
                            $('html, body').animate({
                                scrollTop: target.offset().top + 1
                            }, 1000, function () {
                                // Callback after animation
                                // Must change focus!
                                var $target = $(target);
                                $target.focus();
                                if ($target.is(":focus")) { // Checking if the target was focused
                                    return false;
                                } else {
                                    $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                                    $target.focus(); // Set focus again
                                };
                            });
                        }
                    }
                });
        });
    </script>
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

</html>
