/**** IMAGE CROPING SCRIPT ****/

(function() {
    var $image = $(".img-container img"),
        $dataX1 = $("#data-x1"),
        $dataY1 = $("#data-y1"),
        $dataX2 = $("#data-x2"),
        $dataY2 = $("#data-y2"),
        $dataHeight = $("#data-height"),
        $dataWidth = $("#data-width"),
        $dragStart = $("#drag-start"),
        $dragMove = $("#drag-move"),
        $dragEnd = $("#drag-end");

    $image.cropper({
        aspectRatio: 16 / 9,
        preview: ".img-preview",
        done: function(data) {
            $dataX1.val(data.x1);
            $dataY1.val(data.y1);
            $dataX2.val(data.x2);
            $dataY2.val(data.y2);
            $dataHeight.val(data.height);
            $dataWidth.val(data.width);
        }
    }).on({
        dragstart: function() {
            $dragStart.addClass("btn-info").siblings().removeClass("btn-info");
        },
        dragmove: function() {
            $dragMove.addClass("btn-info").siblings().removeClass("btn-info");
        },
        dragend: function() {
            $dragEnd.addClass("btn-info").siblings().removeClass("btn-info");
        }
    });

    $("#enable").click(function() {
        $image.cropper("enable");
    });

    $("#disable").click(function() {
        $image.cropper("disable");
    });

    $("#free-ratio").click(function() {
        $image.cropper("setAspectRatio", "auto");
    });

    $("#get-data").click(function() {
        var data = $image.cropper("getData"),
            val = "";

        try {
            val = JSON.stringify(data);
        } catch (e) {
            console.log(data);
        }

        $("#get-data-input").val(val);
    });

    var $setDataX1 = $("#set-data-x1"),
        $setDataY1 = $("#set-data-y1"),
        $setDataWidth = $("#set-data-width"),
        $setDataHeight = $("#set-data-height");

    $("#set-data").click(function() {
        var data = {
            x1: $setDataX1.val(),
            y1: $setDataY1.val(),
            width: $setDataWidth.val(),
            height: $setDataHeight.val()
        }

        $image.cropper("setData", data);
    });

    $("#set-aspect-ratio").click(function() {
        var aspectRatio = $("#set-aspect-ratio-input").val();

        $image.cropper("setAspectRatio", aspectRatio);
    });

    $("#set-img-1").click(function() {
        var cropper = $image.data("cropper");
        cropper.defaults.data = {
            y1: 30
        };
        $image.cropper("setImgSrc", "assets/images/gallery/picture-1.jpg");
    });

    $("#set-img-2").click(function() {
        var cropper = $image.data("cropper");
        cropper.defaults.data = {
            y1: 30
        };
        $image.cropper("setImgSrc", "assets/images/gallery/picture-2.jpg");
    });

    $("#set-img-3").click(function() {
        var cropper = $image.data("cropper");
        cropper.defaults.data = {
            y1: 30
        };
        $image.cropper("setImgSrc", "assets/images/gallery/picture-3.jpg");
    });

    $("#get-img-info").click(function() {
        var data = $image.cropper("getImgInfo"),
            val = "";

        try {
            val = JSON.stringify(data);
        } catch (e) {
            console.log(data);
        }

        $("#get-img-info-input").val(val);
    });
}());


// Examples
// -------------------------------------------------------------------------


(function() {
    var $modal = $("#modal-croping"),
        $image = $modal.find(".bootstrap-modal-cropper img"),
        initialized = false,
        originalData = {};

    $modal.on("shown.bs.modal", function() {
        if (initialized) {
            $image.cropper("enable", function() {
                $(this).cropper("setData", originalData); // Set the data on show
            });
        } else {
            initialized = true;
            $image.cropper({
                done: function(data) {
                    console.log(data);
                }
            });
        }
    }).on("hidden.bs.modal", function() {
        originalData = $image.cropper("getData"); // Save the data on hide
        $image.cropper("disable");
    });
}());