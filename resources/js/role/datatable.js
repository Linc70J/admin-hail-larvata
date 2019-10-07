let filterInput = $('.filter-input');
let table = $('#role-datatable');

// DataTable 設定
let config = {
    serverSide: true,
    processing: true,
    ordering: false,
    responsive: true,
    rowReorder: {
        selector: 'tr td span.reorder',
    },
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
                return `<label class="kt-checkbox kt-checkbox--single kt-checkbox--solid" style="width: auto;"> <input type="checkbox" value="` + data.id + `" class="kt-checkable data-check-target"><span></span>` + data.name + `</label>`;
            },
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

// 行排序
dataTable.on('click', '.sort-btn', function (e) {
    e.preventDefault();
    let id = $(this).attr('data-id');

    swal.fire({
        text: '請問您要移動到?',
        input: 'number',
        showCancelButton: true,
        confirmButtonText: '移動',
        cancelButtonText: '取消'
    }).then(function (result) {
        if (result.value) {
            let data = {
                type: 'insert',
                id: id,
                position: result.value
            };
            ajaxOrder(data);
        }
    });
});

// 拖曳排序
dataTable.on('row-reorder', function (e, diff) {
    let ids = Array();
    let orders = Array();

    for (let i = 0; i < diff.length; i++) {
        let row = dataTable.row(diff[i].node).data();
        ids.push(row.id);
        orders.push(row.order);
    }

    if (ids.length) {
        let data = {
            type: 'drag',
            ids: ids,
            orders: orders,
        };
        ajaxOrder(data);
    }
});

function ajaxOrder(data) {
    $.ajax({
        url: table.attr('data-url') + '/order',
        type: "POST",
        dataType: "json",
        data: data,
        statusCode: {
            404: function () {
                toastr.options = {"timeOut": "0"};
                toastr.error('找不到頁面!');
            },
            500: function () {
                toastr.options = {"timeOut": "0"};
                toastr.error('系統發生錯誤!');
            },
        }
    }).done(function (response) {
        dataTable.ajax.reload();
        if (response.errors) {
            toastr.options = {"timeOut": "0"};
            toastr.error(response.message);
        } else {
            toastr.options = {"timeOut": "5000"};
            toastr.success(response.message);
        }
    });
}

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
