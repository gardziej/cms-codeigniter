jQuery.extend(jQuery.expr[':'], {
    inview: function (elem) {
        var el = $(elem);
        var elemTop = el[0].getBoundingClientRect().top;
        var elemBottom = el[0].getBoundingClientRect().bottom;

        var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
        return isVisible;
    }
});
