
<form method="post">


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
                

	<input type="hidden" id="kosar_alapar" class="kosar_alapar" name="k[alapar]" value="<?= $termek->ar;?>" >
	
</form>
<script>
	$().ready(function() { siteJs.kosarElokeszites(); });
</script>
