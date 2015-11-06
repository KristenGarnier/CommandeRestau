'use_strict';
// Show primary product from restaurant
(function(){

    // on initialization
    var sel = document.getElementById('restau');
    var selected = sel.options[sel.selectedIndex];
    var slect = selected.dataset.canonical;
    hide(slect);

    //when it changes
    sel.addEventListener('change', function () {
        var result = this.options[sel.selectedIndex].dataset.canonical;
        hide(result);
    });

    function hide(canon) {
        var options = document.querySelectorAll('#primary option');
        [].forEach.call(options, function(option) {
            if (option.dataset.canonical != canon){
                option.style.display ='none';
            }else{
                option.style.display = 'block';
                option.selected = true;
            }
        });
    }
})();
