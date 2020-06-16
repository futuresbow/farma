				<div class="input-line">					<?php $armod =  (beallitasOlvasas('armod-osszesito')=="1")?'Bruttó':'Nettó';?>
                    
                    <div class="input-container">Fizetendő mindösszesen (<?= $armod;?>)</div>					<div class="input-container price-container"><?= PN_ELO.ws_arformatum(($armod=="Bruttó")?$rendeles->kosarOsszBrutto():$rendeles->kosarOsszNetto() ).PN_UTO;?></div>
                </div>
