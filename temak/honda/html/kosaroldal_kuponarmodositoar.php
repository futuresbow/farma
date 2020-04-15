 					

						<?php $ar = $rendeles->armodositoArBrutto('kupon'); if($ar == 0): ?>

						Nincs kupon érvényesítve

						<?php else:?>

						<?= PN_ELO.ws_arformatum($ar).PN_UTO;?>

						<?php endif; ?>

					


