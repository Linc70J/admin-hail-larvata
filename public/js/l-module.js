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
        $fileSelect = $(modalId + ' .lar-crop_image_file_select'), $fileDrag = $(modalId + ' .lar-crop_image_file_drag'),
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
            currentElement.children('.lar-crop_image-input').val(JSON.stringify({type: 'base64', file_name: fileName, url: resp}));
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

/**
 * @file 圖片處理
 * @author Linc
 */
(function () {
    let defaultOptions = {
        debug: false,
        autoProceed: true,
        showProgressDetails: true,
        restrictions: {
            maxFileSize: 1000000, // 1mb
            maxNumberOfFiles: 5,
            minNumberOfFiles: 1
        }
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////
    let Plugin = function (element, options) {
        let the = this;
        let elemId = $(element).attr('id');
        let id = '#' + elemId;
        let $statusBar = $(id + ' .lar-multiple-files__status');
        let $uploadedList = $(id + ' .lar-multiple-files__list');
        let timeout;

        // Set Uppy
        let uppyMin = Uppy.Core(options);

        uppyMin.use(Uppy.FileInput, {target: id + ' .lar-multiple-files__wrapper', pretty: false});
        uppyMin.use(Uppy.Informer, {target: id + ' .lar-multiple-files__informer'});
        uppyMin.use(Uppy.StatusBar, {
            target: id + ' .lar-multiple-files__status',
            hideUploadButton: true,
            hideAfterFinish: false
        });

        let $fileInput = $(id + ' .uppy-FileInput-input');
        let $fileLabel = $(id + ' .lar-multiple-files__input-label');

        $fileInput.addClass('lar-multiple-files__input-control').attr('id', elemId + '_input_control');
        $(id + ' .uppy-FileInput-container').append('<label class="lar-multiple-files__input-label btn btn-label-brand btn-bold btn-font-sm" for="' + (elemId + '_input_control') + '">新增</label>');

        // upload server
        uppyMin.use(Uppy.XHRUpload, {
            endpoint: '/api/file-upload',
            formData: true,
            fieldName: 'fileData'
        });

        uppyMin.on('upload', function (data) {
            $fileLabel.text("上傳中...");
            $fileInput.attr('disabled', true);
            $statusBar.addClass('lar-multiple-files__status--ongoing');
            $statusBar.removeClass('lar-multiple-files__status--hidden');
            clearTimeout(timeout);
        });

        uppyMin.on('complete', function (file) {
            $.each(file.successful, function (index, value) {
                let json_data = JSON.stringify(value.response.body.data);
                let clone = $('<div class="lar-multiple-files__list-item"><input type="hidden" name="' + elemId + '[]" value="@json_data"><div class="lar-multiple-files__list-label">' + value.name + '</div><span class="lar-multiple-files__list-remove"><i class="flaticon2-cancel-music"></i></span></div>');
                clone.find('input[type="hidden"]').val(json_data);
                $uploadedList.append(clone);
            });

            $fileLabel.text("新增");
            $fileInput.removeAttr('disabled');
            $statusBar.addClass('lar-multiple-files__status--hidden');
            $statusBar.removeClass('lar-multiple-files__status--ongoing');
        });

        $(document).on('click', id + ' .lar-multiple-files__list .lar-multiple-files__list-remove', function () {
            $(this).parent('.lar-multiple-files__list-item').remove();
        });
    };

    /**
     * 進入點
     */
    $.fn.LMultipleFiles = function () {
        return this.each(function () {
            let $this = $(this);

            if (!$this.data('multiple_files')) {
                if ($this.is('[data-option]')) {
                    let customOption;
                    try {
                        customOption = JSON.parse($this.attr('data-option'))
                    } catch (e) {
                        customOption = {};
                    }
                    defaultOptions = Object.assign(defaultOptions, customOption);
                }

                $this.data('multiple_files', new Plugin(this, defaultOptions));
            }
        });
    };
})();

$(".lar-datepicker-input").datepicker({
    format: 'yyyy-mm-dd',
    autoClose: true,
    zIndexOffset: 100,
    templates: {
        leftArrow: '<i class="la la-angle-left"></i>',
        rightArrow: '<i class="la la-angle-right"></i>'
    }
});

$(".lar-daterange > .lar-datepicker-start").on('change', function () {
    let endDate = $(this).siblings().filter('.lar-datepicker-end');
    if ($(this).val()) {
        if (endDate.val()) {
            if (moment($(this).val()).isAfter(endDate.val()))
                endDate.val('');
        }
        endDate.datepicker('setStartDate', $(this).val());
    }
});

$(".lar-daterange > .lar-datepicker-end").on('change', function () {
    let startDate = $(this).siblings().filter('.lar-datepicker-start');
    if ($(this).val()) {
        if (startDate.val()) {
            if (moment($(this).val()).isBefore(startDate.val()))
                startDate.val('');
        }
        startDate.datepicker('setEndDate', $(this).val());
    }
});

$(".lar-datetimepicker-input").datetimepicker({
    format: 'yyyy-mm-dd hh:ii',
    autoClose: true,
    zIndexOffset: 100
});


$(".lar-daterange > .lar-datetimepicker-start").on('change', function () {
    let endDate = $(this).siblings().filter('.lar-datetimepicker-end');
    if ($(this).val()) {
        if (endDate.val()) {
            if (moment($(this).val()).isAfter(endDate.val()))
                endDate.val('');
        }
        endDate.datetimepicker('setStartDate', $(this).val());
    }
});

$(".lar-daterange > .lar-datetimepicker-end").on('change', function () {
    let startDate = $(this).siblings().filter('.lar-datetimepicker-start');
    if ($(this).val()) {
        if (startDate.val()) {
            if (moment($(this).val()).isBefore(startDate.val()))
                startDate.val('');
        }
        startDate.datetimepicker('setEndDate', $(this).val());
    }
});

$('.lar-editor-textarea').summernote({height: 300});

let selectItem = $('.lar-select2-select');
selectItem.select2();
selectItem.each(function () {
    if ($(this).attr('data-value') !== '' && $(this).attr('data-value') !== '0') {
        $(this).val($(this).attr('data-value')).trigger('change');
    }
});

$('.lar-crop_image').LCropImage();

$('.lar-multiple-files').LMultipleFiles();
