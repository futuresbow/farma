<?php $lista = $rendeles->termekLista;?>
					
					<div class="cart-btn">
						<div class="cart-icon"><span><?= count($lista);?></span></div>
						<div class="cart-summ"><?= PN_ELO.' '.ws_arformatum($rendeles->osszBrutto() ).' '.PN_UTO;?></div>
					</div>
					<div class="cart-dd">
						<table>
							<?php if($lista) foreach($lista as $t):?>
							<tr>
	                            <td class="img-container"><img src="<?= $t->fokep()?base_url().ws_image($t->fokep(), 'smallboxed'):beallitasOlvasas('kepek.nincskepurl'); ?>"></td>
	                            <td class="prod-name"><?= $t->jellemzo('Név');?></td>
	                            <td class="quantity">
	                                <div class="quantity-container clearfix">
	                                    <a href="javascript:void(0);" onclick="siteJs.kosarDarabModositas('<?= $t->kosarId;?>',-1);" title="minus" class="minus <?= $t->kosarDarabszam()==1?' del ':''?>"></a> <!-- + "del" class, if quantity = 1 -->
	                                    <input readonly type="text" name="" value="<?= $t->kosarDarabszam(); ?>">
	                                    <a href="javascript:void(0);" onclick="siteJs.kosarDarabModositas('<?= $t->kosarId;?>',1);" title="minus"  class="plus"></a>
	                                </div>
	                            </td>
	                            <td class="all-price"><?= PN_ELO.' '.$t->kosarOsszBruttoAr().' '.PN_UTO; ?></td>
	                        </tr>
	                        <?php endforeach; ?>
	                        
	                        <tr>
	                            <td colspan="3" class="prod-name prod-all">Termékek összesen (bruttó)</td>
	                            <td class="all-price"><?= PN_ELO.' '.ws_arformatum($rendeles->osszBrutto() ).' '.PN_UTO;?></td>
	                        </tr>
						</table>
						<div class="cart-order">
							<a href="<?= base_url().beallitasOlvasas('kosar.oldal.url');?>" title="Kosár" class="cart-order-btn">Kosár &amp; megrendelés</a>
						</div>
					</div>
