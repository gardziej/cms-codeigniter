<script src="<?=base_url('assets/libs/jquery/js/jquery-2.1.4.min.js')?>"></script>
<script src="<?=base_url('assets/admin/js/my_f.js')?>"></script>
<script src="<?=base_url('assets/libs/jquery-ui-1.12.1.custom/jquery-ui.min.js')?>"></script>
<script src="<?=base_url('assets/libs/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/libs/jquery-impromptu.3.1.min.js')?>"></script>
<script src="<?=base_url('assets/libs/datetimepicker/jquery.datetimepicker.min.js')?>"></script>
<script src="<?=base_url('assets/libs/ckeditor/ckeditor.js')?>"></script>
<script src="<?=base_url('assets/libs/jstree/dist/jstree.js')?>"></script>
<script src="<?=base_url('assets/libs/tip/tip.js')?>"></script>

<script>
    window.onload = function()
        {
        var editors = document.querySelectorAll("textarea.editor");
        var roxyFileman = '/fileman/index.html';
        if (editors.length > 0)
            {
            var CKEDITOR_BASEPATH = '<?=base_url('assets/libs/ckeditor/')?>/';
            for (i = 0; i < editors.length; ++i)
                {
                    // CKEDITOR.replace(editors[i].name, {
                    // 	filebrowserBrowseUrl: 		'<?=base_url('assets/libs/ckeditor/fileman/index.html')?>',
                    // 	filebrowserImageBrowseUrl: 	'<?=base_url('assets/libs/ckeditor/fileman/index.html?type=Images')?>',
                    // 	filebrowserFlashBrowseUrl: 	'<?=base_url('assets/libs/ckeditor/filemanager/index.html?type=Flash')?>',
                    // 	filebrowserUploadUrl: 		'<?=base_url('assets/libs/ckeditor/filemanager/connectors/php/filemanager.php')?>',
                    // 	filebrowserImageUploadUrl: 	'<?=base_url('assets/libs/ckeditor/filemanager/connectors/php/filemanager.php?command=QuickUpload&type;=Images')?>',
                    // 	filebrowserFlashUploadUrl: 	'<?=base_url('assets/libs/ckeditor/filemanager/connectors/php/filemanager.php?command=QuickUpload&type;=Flash')?>'
                    // });


                    CKEDITOR.replace( editors[i].name, { filebrowserBrowseUrl:'<?=base_url('assets/libs/ckeditor/fileman/index.html')?>',
                            filebrowserImageBrowseUrl:'<?=base_url('assets/libs/ckeditor/fileman/index.html')?>'+'?type=image',
                            removeDialogTabs: 'link:upload;image:upload'});

                }
            }
        }
</script>
<script src="<?=base_url('assets/libs/select2/js/select2.full.min.js')?>"></script>
<script src="<?=base_url('assets/libs/lightbox/js/lightbox.js')?>"></script>
<script src="<?=base_url('assets/libs/jcrop/js/jquery.Jcrop.js')?>"></script>
<script src="<?=base_url('assets/admin/js/my.js')?>"></script>
</body>
</html>
