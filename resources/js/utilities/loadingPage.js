// Mostra o nascondi il carimento
$(window).ready(function() {
    const loader = $('#loader');
    const app = $('#app');

    setTimeout(() => {
        loader.hide();
        app.removeClass('is-loading');
    }, 500);
});