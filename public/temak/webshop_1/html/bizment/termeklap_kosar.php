
<form method="post">
			<input type="hidden" class="kosar_db" name="k[db]" value="1"  />
			<div class="cart-interactions">

                <div class="usp">
                    <div class="item">
                        <div class="usp-name">Készlet</div>
                        <div class="usp-detail onstock">Raktáron</div>
                    </div>
                    <div class="item">
                        <div class="usp-name">Kiszállítás</div>
                        <div class="usp-detail delivery">Ingyenes</div>
                    </div>
                    <div class="item">
                        <div class="usp-name">Garancia</div>
                        <div class="usp-detail warranty">24 hónap</div>
                    </div>
                </div>
				<?php if(false) if($termek->vannakValtozatok()):?>

                    <div class="option">
						<div class="form-elements">

                <div class="form-line">

                    <div class="input-container ">

                        <label for="" class="important">Válassz méretet</label>

                        <div class="styled-select">

                           <select name="k[valtozat]" class="kosar_valtozat">

                                <?php foreach($termek->valtozatok() as $valtozat): ?>

								<option data-valtozatar="<?= $valtozat->ar; ?>" value="<?= $valtozat->id;?>"><?= $valtozat->nev;?> </option>

								<?php endforeach;?>

                            </select>

                        </div>

                        
                    </div>

                   
                </div>

				</div>
            </div>
                        

                    <?php endif;?>
                <div class="add-to">
					
                    
                    <div class="price">
                        <div class="inner">
                            <span class="prices kosar_osszar"><?= PN_ELO.ws_arformatum($termek->ar).PN_UTO; ?></span>
                            <?php if($termek->eredeti_ar!=0):?><div class="old-price"><?= PN_ELO.ws_arformatum($termek->ar).PN_UTO; ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="button-container">
						<a  data-termekid="<?= $termek->id; ?>" href="javascript:void(0);" title="Megrendelés" class="btn kosar_elkuldes">Kosárba rakom</a>
					</div>
                </div>

            </div>

				
                

	<input type="hidden" id="kosar_alapar" class="kosar_alapar" name="k[alapar]" value="<?= $termek->ar;?>" >
	
</form>
<script>
	$().ready(function() { siteJs.kosarElokeszites(); });
</script>
<?php
/*
 * a komolyabb változat vezérlői (a honda template-ban működik)

<div class="price-container">

					<?php if($termek->vannakValtozatok()):?>

                    <div class="option">

                        <label>Válassz méretet</label>

                        <div class="styled-select">

                            <select name="k[valtozat]" class="kosar_valtozat">

                                <?php foreach($termek->valtozatok() as $valtozat): ?>

								<option data-valtozatar="<?= $valtozat->ar; ?>" value="<?= $valtozat->id;?>"><?= $valtozat->nev;?> </option>

								<?php endforeach;?>

                            </select>

                        </div>

                    </div>

                    <?php endif;?>

                    <?php if($termek->vannakValtozatok2()):?>

                    <div class="option">

                        <label>Válassz színt</label>

                        <div class="styled-select">

                            <select name="k[valtozat]" class="kosar_valtozat2">

                                <?php foreach($termek->valtozatok2() as $valtozat): ?>

								<option data-valtozatar="<?= $valtozat->ar; ?>" value="<?= $valtozat->id;?>"><?= $valtozat->nev;?> </option>

								<?php endforeach;?>

                            </select>

                        </div>

                    </div>

                    <?php endif;?>

                    

				 </div>

				 <div class="price-container">

					<?php if($termek->vannakOpciok()):?>

                    <div class="option">

                        <label>Választható extrák:</label>

                        <div class="styled-select">

                            <?php foreach($termek->opciok() as $opcio): ?>

							<input  class="kosar_opcio" data-opcioar="<?= $opcio->ar; ?>" type="checkbox" value="<?= $opcio->id;?>"><?= $opcio->nev;?> (nettó <?= ws_arformatum($opcio->ar);?> Ft)<br>

							<?php endforeach;?>

                            

                        </div>

                    </div>

                    <?php endif;?>

                    <div class="option">

                        

                        <div class="styled-input" style="line-height:20px;">

                           

                            <input style="width: 50%;font-size:20px;text-align:center;" readonly type="number" class="kosar_db" name="k[db]" value="1" placeholder="Darabszám" name="db" /> DB

							<button onclick="siteJs.darabszamLapozo(-1, 0);" type="button">-</button>

							<button onclick="siteJs.darabszamLapozo(1, 0);" type="button">+</button>

                        </div>

                    </div>

                    <div class="price">

                        <a  data-termekid="<?= $termek->id; ?>" href="javascript:void();" title="Megrendelés" class="price-btn kosar_elkuldes">

                            <span class="prices kosar_osszar">

                                

                                <?= ws_arformatum($termek->ar); ?> Ft

                            </span>

                            <span class="icon">

                            </span>

                        </a>

                    </div>

                </div>
*/
