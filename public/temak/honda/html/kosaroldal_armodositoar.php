					
						<?php $ar = $rendeles->armodositoArBrutto($mod); if($ar == 0): ?>
						Ingyenes
						<?php else:?>						<?php if (beallitasOlvasas('armod-osszesito')=="0") $ar  = $rendeles->armodositoArNetto($mod);?>
						
						<?= PN_ELO.ws_arformatum($ar).PN_UTO;?>
						<?php endif; ?>
					
