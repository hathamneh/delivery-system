let autosize = require('autosize')

function textareaAutosize() {
    $('textarea.autosize').each(function () {
        autosize($(this));
    });
}

textareaAutosize()