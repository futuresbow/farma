						<script>
							$("#<?= $sortableId; ?> tbody").sortable({
								
        					    helper: fixHelperModified,
        					    axis: "y",
								containment: "parent",
								handle: ".move",
								cancel: ".editable",
		
        					    stop: function(e, ui) {
									$('td.num', ui.item.parent()).each(function (i) {
										$(this).html(i + 1);
									});
									sorok = $("#<?= $sortableId; ?> tbody tr");
									if(sorok.length>0) {
										ids='';
										for(i = 0;i < sorok.length;i++) if($(sorok[i]).attr('data-id')) ids+=$(sorok[i]).attr('data-id')+',';
										
										// ha van form, akkor azzal együtt küldjük, ha nincs, akkor csak úgy...
										
										form = ($(ui.item).parents('form'));
										if(form.length>0) {
											$(form).append('<input type="hidden" name="ddsorrend" value="'+ids+'"  ><input type="hidden"  name="ddcsoport" value="<?= $sortableId; ?>"  >').submit();
										} else {
											window.location.href='?csoport=<?= $sortableId; ?>&sorrend='+(ids);										}
									}
								}
        					}).disableSelection();
						</script>
