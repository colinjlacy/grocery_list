// Making the tabs work

$('.nav-tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
})
