<?php $lista = $rendeles->termekLista;?>

<a href="<?= base_url();?>kosar" title=""><?= count($lista);?> termék, <span><?= PN_ELO.' '.ws_arformatum($rendeles->osszBrutto() ).' '.PN_UTO;?></span></a>
				

