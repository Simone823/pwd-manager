// div loader
const divLoader = document.getElementById('loader');

// div page loaded
const divPageLoaded = document.getElementById('page-loaded');

// document load event
document.addEventListener('readystatechange', function(e) {
    if(document.readyState == 'complete') {
        setTimeout(() => {
            divLoader.classList.remove('d-block');
            divLoader.classList.add('d-none');

            divPageLoaded.classList.remove('d-none');
        }, 250);
    }
});