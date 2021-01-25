(function () {
    var current = location.pathname;
    var menuItems = document.querySelectorAll('#accordionSidebar li a');
    for (var i = 0, len = menuItems.length; i < len; i++) {
        if (menuItems[i].getAttribute("href").indexOf(current) !== -1) {
            menuItems[i].parentElement.className += " active";
        }
    }
})();
