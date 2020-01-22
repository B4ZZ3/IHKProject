if('serviceWorker' in navigator){
    navigator.serviceWorker.register('serviceWorker.js')
        .then(() => console.log('service worker registered'));
}