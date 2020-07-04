<div class="">
	<?php if($lista) foreach($lista as $sor): ?>
	<div class="lista_sor" onclick="$(this).next().slideDown();">
		<center><b><?= $sor->nev.' '.$sor->id;?></b></center>
		
	</div>
	<div style="display:non">
		<table class="data-table" id="">



                            <tbody><tr class="table-head"> <!-- + class="items-selected" if there's selected items -->

                               
                                
                                <th><span>Név</span></th>

                                

                                
                                <th><span>Készlet</span></th>

                                

                                
                                <th><span>Foglalt</span></th>

                                

                                
                                
                            </tr>
							
							<?php if(!$sor->adatlista):?>
                            <tr data-id="0">

								
                                
                                
                                <td style="width:60%"><?= $sor->nev?> alap</td>

                                
                                
                                
                                <td class="quantity-cell">
									<div class="quantity clearfix">
										<a onclick="aJs.keszletNoveles(this, -1);$.get('<?= ADMINURL?>keszletek/ajax?tid=<?= $sor->id;?>&keszlet='+$(this).next().val());" href="javascript:void(0);" title="" class="btn btn-small decrease"></a>
										<input type="text" name="db[<?= $sor->id; ?>]" value="<?= $sor->keszlet; ?>">
										<a onclick="aJs.keszletNoveles(this, 1);$.get('<?= ADMINURL?>keszletek/ajax?tid=<?= $sor->id;?>&keszlet='+$(this).prev().val());" href="javascript:void(0);" title="" class="btn btn-small increase"></a>
									</div></td>

                                
                                
                                
                                <td>
									<div class="quantity clearfix">
										<a onclick="aJs.keszletNoveles(this, -1);$.get('<?= ADMINURL?>keszletek/ajax?tid=<?= $sor->id;?>&lefoglalt='+$(this).next().val());" href="javascript:void(0);" title="" class="btn btn-small decrease"></a>
										<input type="text" name="foglalt[<?= $sor->id; ?>]" value="<?= $sor->lefoglalva; ?>">
										<a onclick="aJs.keszletNoveles(this, 1);$.get('<?= ADMINURL?>keszletek/ajax?tid=<?= $sor->id;?>&lefoglalt='+$(this).prev().val());" href="javascript:void(0);" title="" class="btn btn-small increase"></a>
									</div></td>

                                
                                
                                

                                
                            </tr>

                           <?php else: ?>
                          
                          
							<?php  if($sor->adatlista ) foreach($sor->adatlista as $aSor): ?>
							
							
							
								  <tr data-id="0">

										
										
										
										<td style="width:60%"><?= $aSor->nev?> változat</td>

										
										
										
										<td class="quantity-cell">
											<div class="quantity clearfix">
												<a onclick="aJs.keszletNoveles(this, -1);" href="javascript:void(0);" title="" class="btn btn-small decrease"></a>
												<input type="text" name="db[<?= $aSor->id; ?>]" value="<?= $aSor->db; ?>">
												<a onclick="aJs.keszletNoveles(this, 1);alert('fejlesztés alatt');" href="javascript:void(0);" title="" class="btn btn-small increase"></a>
											</div></td>

										
										
										
										<td>
											<div class="quantity clearfix">
												<a onclick="aJs.keszletNoveles(this, -1);" href="javascript:void(0);" title="" class="btn btn-small decrease"></a>
												<input type="text" name="foglalt[<?= $aSor->id; ?>]" value="<?= $aSor->foglalt; ?>">
												<a onclick="aJs.keszletNoveles(this, 1);alert('fejlesztés alatt');" href="javascript:void(0);" title="" class="btn btn-small increase"></a>
											</div></td>

										
										
										

										
									</tr>
							
							
							
							<?php endforeach; ?>
                           
                           
                           
                           <?php endif; ?>
                      

                        </tbody></table>
	</div>

							
	<?php endforeach;?>
</div> 
