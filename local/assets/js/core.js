/**
 * @about GetCode-Integration 2021 - Copyright AllRight Reserved
 * @author Kokurkin-German
 *
 * @todo use "debugger;" for debug on script
 */
function loadLifeCart() {
    $.ajax ({
        url: '/local/ajax/life.cart/index.php?clear_cache=Y',
        method: 'GET',
        success: function (responsed_cart) {
            var $container = $('body').find('.header-top__cart_counter');
            $container.html(responsed_cart);
        }
    })
}

$(document).ready(function(){
    $('body').on('click', '.close-popup-revertoncatalog', function() {
        loadLifeCart();
        $.magnificPopup.close();
    });

});