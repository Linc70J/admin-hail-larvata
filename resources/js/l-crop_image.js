/**
 * @file 圖片裁切
 * @author Linc
 */
(function () {
    // 裁切 Modal

    let cropImageModal = [
        '<div class="modal fade" id="lar-crop_image_modal" role="dialog">',
        '<div class="modal-dialog" role="document">',
        '<div class="modal-content">',
        '<div class="modal-header">',
        '<h5 class="modal-title">選擇圖片</h5>',
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">',
        '</button>',
        '</div>',
        '<div class="modal-body">',
        '<div class="lar-crop_image_upload">',
        '<h3>01. 上傳</h3>',
        '<div class="block">',
        '<div class="stage">',
        '<label class="lar-crop_image_file_drag">',
        '<input type="file" class="lar-crop_image_file_select" accept="image/*"/>',
        '</label>',
        '</div>',
        '</div>',
        '</div>',
        '<div class="lar-crop_image_crop">',
        '<h3>02. 裁切 / 預覽</h3>',
        '<div class="block">',
        '<div class="stage">',
        '<div class="croppie"></div>',
        '</div>',
        '</div>',
        '</div>',
        '</div>',
        '<div class="modal-footer">',
        '<button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>',
        '<button type="button" class="btn btn-warning lar-crop_image_prev">上一步</button>',
        '<button type="button" class="btn btn-primary lar-crop_image_result">選擇</button>',
        '</div>',
        '</div>',
        '</div>',
        '</div>'
    ].join('');
    $('body').append(cropImageModal);

    const modalId = '#lar-crop_image_modal';
    const $upload = $(modalId + ' .lar-crop_image_upload'), $crop = $(modalId + ' .lar-crop_image_crop'),
        $fileSelect = $(modalId + ' .lar-crop_image_file_select'),
        $fileDrag = $(modalId + ' .lar-crop_image_file_drag'),
        $prev = $(modalId + ' .lar-crop_image_prev'), $result = $(modalId + ' .lar-crop_image_result'),
        $croppie = $(modalId + ' .croppie');

    $prev.on('click', cropCancel);
    $result.on('click', cropResult);

    let cr, fileName, currentElement;

    //********* file select/drop *********
    function fileInit() {
        // file select
        $fileSelect.on('change', FileSelectHandler);
        // is XHR2 available?
        let xhr = new XMLHttpRequest();
        // file drop
        if (xhr.upload) {
            $fileDrag.on('dragover', FileDragHover);
            $fileDrag.on('dragleave', FileDragHover);
            $fileDrag.on('drop', FileSelectHandler);
        }
    }

    // file drag hover
    function FileDragHover(e) {
        e.stopPropagation();
        e.preventDefault();
        $fileDrag.className = (e.type === "dragover" ? "hover" : "");
    }

    // file selection
    function FileSelectHandler(e) {
        // cancel event and hover styling
        FileDragHover(e);
        // fetch FileList object
        let files = e.target.files || e.dataTransfer.files;
        if (files[0] && files[0].type.match('image.*')) {
            let reader = new FileReader();
            reader.onload = function (e) {
                // Set image
                cr.croppie('bind', {
                    url: e.target.result
                });

                fileName = files[0].name;
                $upload.hide();
                $crop.fadeIn(300);
                $prev.show();
            };
            reader.readAsDataURL(files[0]);
        }
    }

    //********* crop *********
    //裁切設定
    function cropInit(options, element) {
        currentElement = element;
        $croppie.croppie('destroy');
        cr = $croppie.croppie(options);
        $(".cr-slider-wrap").append('<button class="cr-rotate">↻ Rotate</button>');
        $(modalId + ' .cr-rotate').on('click', cropRotate);
        cropCancel();
    }

    //旋轉按鈕
    function cropRotate() {
        cr.croppie('rotate', -90);
    }

    //取消裁切
    function cropCancel() {
        $fileSelect.val('');
        $prev.hide();
        $upload.show();
        $crop.hide();
    }

    //圖片裁切
    function cropResult() {
        cr.croppie('result', {
            type: 'base64',
            size: 'original'
        }).then(function (resp) {
            // Update image input
            currentElement.children('.lar-crop_image-input').val(JSON.stringify({
                type: 'base64',
                file_name: fileName,
                url: resp
            }));
            currentElement.children('.lar-crop_image__holder').css("background-image", 'url(' + resp + ')');
            currentElement.addClass('lar-crop_image--changed');
            $('#lar-crop_image_modal').modal('hide');
        });
    }

    // Croppie 參數
    let defaultOptions = {
        viewport: {
            width: 320,
            height: 320
        },
        //enforceBoundary: false,
        checkCrossOrigin: false,
        enableOrientation: true,
        enableResize: false,
        enableExif: true
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////
    let Plugin = function (element, options) {
        let root = $(element);
        let input = root.children('.lar-crop_image-input');
        let holder = root.children('.lar-crop_image__holder');
        let uploadBtn = root.children('.lar-crop_image__upload');
        let cancelBtn = root.children('.lar-crop_image__cancel');

        // RWD 調整
        let maxWidth = root.parent().width();
        let width = parseFloat(options.viewport.width);
        let height = parseFloat(options.viewport.height);
        if (width > maxWidth) {
            height = height * maxWidth / width;
            width = maxWidth;
        }
        holder.css('width', width);
        holder.css('height', height);

        width = parseFloat(options.viewport.width);
        height = parseFloat(options.viewport.height);

        if (width > height) {
            options.viewport.height = height * 320 / width;
            options.viewport.width = 320;
        } else {
            options.viewport.width = width * 320 / height;
            options.viewport.height = 320;
        }

        try {
            let imageInput = Object.assign({}, JSON.parse(input.val()));
            if (imageInput.hasOwnProperty('url')) {
                holder.css("background-image", 'url(' + imageInput.url + ')');
                root.addClass('lar-crop_image--changed');
            } else {
                // TODO:Set default image
            }
        } catch (e) {
            // TODO:Set default image
        }

        // Handle image upload
        uploadBtn.on('click', function (e) {
            e.preventDefault();
            cropInit(options, root);
            $('#lar-crop_image_modal').modal('show');
        });

        // Handle image cancel
        cancelBtn.on('click', function (e) {
            e.preventDefault();
            root.removeClass('lar-crop_image--changed');
            holder.css("background-image", 'none');
            input.val(JSON.stringify({}));
        });
    };

    /**
     * 進入點
     */
    $.fn.LCropImage = function () {
        return this.each(function () {
            let $this = $(this);
            let currentOptions = defaultOptions;

            if (!$this.data('crop-image')) {
                if ($this.is('[data-width]'))
                    currentOptions.viewport.width = $this.attr('data-width');

                if ($this.is('[data-height]'))
                    currentOptions.viewport.height = $this.attr('data-height');

                if ($this.is('[data-option]')) {
                    let customOption;
                    try {
                        customOption = JSON.parse($this.attr('data-option'))
                    } catch (e) {
                        customOption = {};
                    }
                    currentOptions = Object.assign(currentOptions, customOption);
                }

                $this.data('crop-image', new Plugin(this, currentOptions));
            }
        });
    };


    //支援上傳檔案判斷
    if (window.File && window.FileList && window.FileReader)
        fileInit();
})();
