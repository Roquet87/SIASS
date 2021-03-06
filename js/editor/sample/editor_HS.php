<!-- 	<link rel="stylesheet" href="sample.css">
		<script src="../ckeditor.js"></script>
-->

<script>

		var editor;

		// The instanceReady event is fired, when an instance of CKEditor has finished
		// its initialization.
		CKEDITOR.on( 'instanceReady', function( ev ) {
			editor = ev.editor;

			// Show this "on" button.
			document.getElementById( 'readOnlyOn' ).style.display = '';

			// Event fired when the readOnly property changes.
			editor.on( 'readOnly', function() {
				document.getElementById( 'readOnlyOn' ).style.display = this.readOnly ? 'none' : '';
				document.getElementById( 'readOnlyOff' ).style.display = this.readOnly ? '' : 'none';
			});
		});

		function toggleReadOnly( isReadOnly ) {
			// Change the read-only state of the editor.
			// http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-setReadOnly
			editor.setReadOnly( isReadOnly );
		}

	</script>
	
	
<!--  Ejemplo de form para usar editor by LP
	<form action="prueba_HS.php" method="post">
	<textarea class="ckeditor" name="editor1" cols="50" id="editor1" rows="20" ></textarea>
	<input type="submit" value="Guardar" name="guardarbtn">
	<input id="readOnlyOff" onclick="toggleReadOnly( false );" type="button" value="Editar" style="display:none">
	<input id="readOnlyOn" onclick="toggleReadOnly();" type="button" value="Solo Lectura" style="display:none">
	</form>
-->