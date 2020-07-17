<script>
var <?= $peldany; ?> = new Jodit("<?= $id; ?>", 
    { 
        readonly: false,
        enableDragAndDropFileToEditor: true,
        uploader: {
          url: '<?= ADMINURL ?>post/imgupload',
          data: {
            dir: this.dir
          },
          baseurl: '<?= base_url();?>',
          process: (response) => {
              console.log(response);
            let files = [];
            files = response.data.images;
            /*response.list.map((file) => {
              files.push(file.name);
            });*/
            
            return { 
              files,
              path: 'assets/post',
              baseurl: '<?= base_url(); ?>assets/post',
              error: (response.success ? 0 : 1),
              msg: response.message
            };
          },
          defaultHandlerSuccess: (response) => {
            console.log(response);
            if (response.files && response.files.length) {
              for (let i = 0; i < response.files.length; i++) {
                let full_file_path = response.files[i];
                console.log(this.selection);
                <?= $peldany ?>.selection.insertImage(full_file_path,null, 500);
              }
            }
          }
        },
        "buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"
    
    });
</script>


