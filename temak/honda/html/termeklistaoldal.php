<!-- start: prod list -->

<div class="product-list clearfix">

    <?= widget('kategoria/kategoria/szurowidget_termeklista');?>

    

    <div class="prod-container">

		
	
		

		

		<?php $ci = getCI();?>
        
		<form id="termlistaform" >
		

		<?= widget('termek/termeklista', array('view' => 'termeklistaoldal_fejlec'));?>
				

        
		<?= widget('termek/termeklista', array('view' => 'termeklistaoldal_lista.php'));?>
		
		</form>
		

    </div>

</div>

<!-- end: prod list -->

