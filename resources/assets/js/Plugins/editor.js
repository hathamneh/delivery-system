let ClassicEditor = require("@ckeditor/ckeditor5-build-classic")

/****  CKE Editor  ****/
function editorCKE() {
    ClassicEditor.create(document.querySelector('#cke-editor'))
        .catch(error => {
            console.error(error);
        });
}

editorCKE()