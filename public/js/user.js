let filterInput = $('.filter-input');
let table = $('#user-datatable');

// DataTable 設定
let config = {
    serverSide: true,
    processing: true,
    ordering: false,
    responsive: true,
    autoWidth: true,
    searching: false,
    lengthChange: false,
    pageLength: 20,
    ajax: {
        data: function (aoData) {
            //把分頁的參數與自訂的搜尋結合
            filterInput.each(function () {
                if ($(this).val())
                    aoData[$(this).attr('name')] = $(this).val();
            });
            return aoData;
        },
        url: table.attr('data-url') + '/query',
    },
    // columns definition
    columns: [
        {
            data: null,
            render: function (data) {
                let html = `<div class="ellipsis"><label class="kt-checkbox kt-checkbox--single kt-checkbox--solid" style="width: auto;"> <input type="checkbox" value="` + data.id + `" class="kt-checkable data-check-target"><span></span>`;
                html += `<a href="#">` + data.email + `</a><br>(` + data.name + `)</label></div>`;
                return html;
            },
        },
        {
            data: null,
            render: function (data) {
                let html = ``;
                if (data.roles)
                    data.roles.forEach(function (item) {
                        html += `<span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--pill kt-badge--rounded">` + item.name + `</span> `;
                    });
                return html;
            }
        },
        {
            data: null,
            render: function (data) {
                let html = ``;
                if (data.permissions)
                    data.permissions.forEach(function (item) {
                        html += `<span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--pill kt-badge--rounded">` + item.display_name + `</span> `;
                    });
                return html;
            }
        },
        {
            data: null,
            width: '150px',
            render: function (data) {
                switch (data.display_status) {
                    case '1':
                        return `<span class="kt-badge kt-badge--unified-dark kt-badge--inline kt-badge--pill kt-badge--rounded">停用</span>&nbsp;<span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--pill kt-badge--rounded">信箱已驗證</span>`;
                    case '2':
                        return `<span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--pill kt-badge--rounded">啟用</span>&nbsp;<span class="kt-badge kt-badge--unified-dark kt-badge--inline kt-badge--pill kt-badge--rounded">信箱未驗證</span>`;
                    case '3':
                        return `<span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--pill kt-badge--rounded">啟用</span>&nbsp;<span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--pill kt-badge--rounded">信箱已驗證</span>`;
                    default:
                        return `<span class="kt-badge kt-badge--unified-dark kt-badge--inline kt-badge--pill kt-badge--rounded">停用</span>&nbsp;<span class="kt-badge kt-badge--unified-dark kt-badge--inline kt-badge--pill kt-badge--rounded">信箱未驗證</span>`;
                }
            }
        },
        {
            data: null,
            width:
                '100px',
            defaultContent:
                '',
            render:
                function (data) {
                    let html = ``;
                    html += `<a href="` + table.attr('data-url') + `/` + data.id + `/edit` + `" title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>`;
                    html += `<button title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md delete-btn" data-id="` + data.id + `"><i class="la la-trash"></i></button>`;
                    return html;
                }
        }
    ]
};

let dataTable = table.DataTable(config);

// 全選
table.on('change', '.kt-group-checkable', function () {
    let set = $(this).closest('table').find('td .kt-checkable.data-check-target');
    let checked = $(this).is(':checked');

    $(set).each(function () {
        if (checked) {
            $(this).prop('checked', true);
            $(this).closest('tr').addClass('active');
        } else {
            $(this).prop('checked', false);
            $(this).closest('tr').removeClass('active');
        }
    });
});

// 搜尋
$('#search-btn').on('click', function (e) {
    e.preventDefault();
    dataTable.ajax.reload();
});

// 取消篩選
$('#reset-btn').on('click', function (e) {
    e.preventDefault();
    filterInput.each(function () {
        $(this).val('');
    });
    dataTable.ajax.reload();
});

// 批次刪除
$('#batch-delete-btn').on('click', function (e) {
    e.preventDefault();
    let ids = Array();
    $(table.find('td .kt-checkable.data-check-target:checked')).each(function () {
        ids.push($(this).val());
    });

    if (ids.length) {
        ajaxDelete(ids);
    } else {
        toastr.options = {"timeOut": "2000"};
        toastr.error('沒有選擇任何資料');
    }
});

// 行刪除
dataTable.on('click', '.delete-btn', function (e) {
    e.preventDefault();
    let ids = Array($(this).attr('data-id'));
    ajaxDelete(ids);
});

// 刪除功能
function ajaxDelete(ids) {
    swal.fire({
        title: '確認刪除嗎?',
        text: "你將無法恢復!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: '好, 刪除吧!',
        cancelButtonText: '不, 取消!',
        reverseButtons: true
    }).then(function (result) {
        if (result.value) {
            let loading = swal.fire({
                title: '正在刪除中!',
                text: '請稍候...',
                onOpen: function () {
                    swal.showLoading()
                }
            });
            $.ajax({
                url: table.attr('data-url'),
                type: "delete",
                dataType: "json",
                data: {
                    ids: ids,
                },
                statusCode: {
                    404: function () {
                        loading.close();
                        toastr.options = {"timeOut": "0"};
                        toastr.error('找不到頁面!');
                    },
                    403: function () {
                        loading.close();
                        toastr.options = {"timeOut": "0"};
                        toastr.error('無查詢權限!');
                    },
                    500: function () {
                        loading.close();
                        toastr.options = {"timeOut": "0"};
                        toastr.error('系統發生錯誤!');
                    },
                }
            }).done(function (response) {
                dataTable.ajax.reload();
                loading.close();
                if (response.errors) {
                    toastr.options = {"timeOut": "0"};
                    toastr.error(response.message);
                } else {
                    toastr.options = {"timeOut": "5000"};
                    toastr.success(response.message);
                }
            });
        }
    });
}

function submit(form, draft, type){
    $('<input type="hidden" name="draft" />').attr("value", draft).appendTo(form);
    $('<input type="hidden" name="redirect-type" />').attr("value", type).appendTo(form);
    $(form).submit();
}
