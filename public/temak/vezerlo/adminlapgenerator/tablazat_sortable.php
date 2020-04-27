						<script>
        					var fixHelperModified = function(e, tr) {
								var $originals = tr.children();
								var $helper = tr.clone();

								$helper.children().each(function(num) {
									$(this).width($originals.eq(num).width())
								});
								return $helper;
							}
        				   
							
							
        				</script>
