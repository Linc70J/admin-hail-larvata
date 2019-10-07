function submit(form, draft, type) {
    $('<input type="hidden" name="redirect-type" />').attr("value", type).appendTo(form);
    $(form).submit();
}
