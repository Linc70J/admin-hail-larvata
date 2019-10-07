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
