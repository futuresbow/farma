<div class="wrap">
	<div class="homepage">
		<div class="homepage product-list-page">
			
			<form id="termlistaform">
			
				<?= widget('termek/termeklista', array('view' => 'termeklistaoldal_fejlec'));?>
					
				<div class="clearfix">

					<div class="left-side">
						<?= widget('kategoria/kategoria/szurowidget_termeklista');?>
					</div>
					
					<div class="right-side">
						<?= widget('termek/termeklista', array('view' => 'termeklistaoldal_lista.php'));?>
						
					</div>
					
				
				</div>
		
			</form>
	
		</div>
	
	</div>

</div>


