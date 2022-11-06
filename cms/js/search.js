const list = document.querySelector('#overview-list');

//filter all the items
const searchBar = document.forms['search-items'].querySelector('input');
searchBar.addEventListener('keyup', function(e){
    const term = e.target.value.toLowerCase();
    const items = list.getElementsByTagName('li');
    Array.from(items).forEach(function(item){
        const title = item.firstElementChild.textContent;
        if(title.toLowerCase().indexOf(term) != -1) {
            item.style.display = 'flex';
        }
        else {
            item.style.setProperty( 'display', 'none', 'important' );
        }
    })
})