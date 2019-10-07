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
