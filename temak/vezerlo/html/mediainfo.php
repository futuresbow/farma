 <b>Információk</b><br><br>
 <input style="padding: 10px 20px;width:100%" type="text" onclick="$(this).select();" readonly value="<?= base_url().'assets/'.$utvonal;?>" >


<br><br><a href="<?= base_url().'assets/'.$utvonal;?>" target="_blank">Letöltés</a><br><br>
<?php if($kep): ?>
<a href="<?= ADMINURL.'media/kepvago?file='.$utvonal; ?>"><img src="<?= base_url().'assets/'.$utvonal;?>" style="width:100%;" /></a>
<?php endif;?>
