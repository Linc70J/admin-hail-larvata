function submit(form, draft, type) {
    $('<input type="hidden" name="draft" />').attr("value", draft).appendTo(form);
    $('<input type="hidden" name="redirect-type" />').attr("value", type).appendTo(form);
    $(form).submit();
}
