'use_strict';
// disable restaurant when on boisson and dessert
(function () {

    // on initialization
    var sel = document.getElementById('type');
    var selected = sel.options[sel.selectedIndex].dataset.produit;
    disable(selected);

    //when it changes
    sel.addEventListener('change', function () {
        var result = this.options[sel.selectedIndex].dataset.produit;
        disable(result);
    });

    function disable(data) {
        if (data == 0) {
            return document.getElementById('restau').disabled = true;
        }
        document.getElementById('restau').disabled = false;

    }
})();


