 					

						<?php $ar = $rendeles->armodositoArBrutto('kupon'); if($ar == 0): ?>
						
						Nincs kupon érvényesítve

						<?php else:?>
						<?php if (beallitasOlvasas('armod-osszesito')=="0") $ar  = $rendeles->armodositoArNetto('kupon');?>
						
						<?= PN_ELO.ws_arformatum($ar).PN_UTO;?>

						<?php endif; ?>

					


