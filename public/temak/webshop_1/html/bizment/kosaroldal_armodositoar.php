					
						<?php $ar = $rendeles->armodositoArBrutto($mod); if($ar == 0): ?>
						Ingyenes
						<?php else:?>
						<?= PN_ELO.ws_arformatum($ar).PN_UTO;?>
						<?php endif; ?>
					
