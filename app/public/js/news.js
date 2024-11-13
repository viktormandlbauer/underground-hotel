const newsContainer = document.getElementById('news-container');
const newsTemplate = document.getElementById('news-item-template');
let currentPage = 1;
let limit = 20; 
let totalPages;

function fetchTotalPages() {
    fetch(`/news/get/count`)
        .then(response => response.json())
        .then(data => {
            totalPages = data.totalPages;
            console.log('Total pages:', totalPages);
            renderPagination(totalPages);
            fetchNews(currentPage);
        })
        .catch(error => console.error('Error fetching total pages:', error));
}

function loadPage(page) {
    if (page === 'next') {
        if (currentPage < totalPages) currentPage++;
    } else if (page === 'prev') {
        if (currentPage > 1) currentPage--;
    } else {
        currentPage = page;
    }
    fetchNews(currentPage);
}

function fetchNews(page) {
    fetch(`/get/news?page=${page}&limit=${limit}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                newsContainer.innerHTML = `<p>Fehler beim Laden der News: ${data.error}</p>`;
                return;
            }
            renderNews(data.news);
        })
        .catch(error => {
            newsContainer.innerHTML = `<p>Fehler beim Laden der News: ${error.message}</p>`;
        });
}

function renderNews(newsItems) {
    newsContainer.innerHTML = '';  
    newsItems.forEach(post => {
        const newsItemClone = newsTemplate.cloneNode(true);
        newsItemClone.style.display = 'block';
        
        newsItemClone.querySelector('.news-title').textContent = post.title || '';
        const imageElement = newsItemClone.querySelector('.news-image');
        if (post.image_path) {
            imageElement.src = `/${post.image_path}`;
            imageElement.style.display = 'block';
        }
        newsItemClone.querySelector('.news-content').innerHTML = nl2br(escapeHtml(post.content || ''));
        newsItemClone.querySelector('.news-date').textContent = `Veröffentlicht am ${post.date || ''}`;

        newsContainer.appendChild(newsItemClone);
    });
}

function renderPagination(total) {
    const paginationContainer = document.querySelector('.pagination');
    const paginationCopy = document.getElementById('pagination-copy');

    Array.from(paginationContainer.querySelectorAll('.page-item.page-number')).forEach(el => el.remove());

    for (let i = 1; i <= total; i++) {
        const pageItem = paginationCopy.cloneNode(true);
        pageItem.style.display = 'block';
        pageItem.classList.add('page-number'); // Klasse hinzufügen, um die Seitennummern einfach zu löschen
        pageItem.querySelector('a').textContent = i;
        pageItem.querySelector('a').setAttribute('onclick', `loadPage(${i})`);
        paginationContainer.insertBefore(pageItem, paginationContainer.querySelector('.page-item:last-child'));
    }
}

// Hilfsfunktionen
function escapeHtml(string) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(string));
    return div.innerHTML;
}

function nl2br(str) {
    return str.replace(/\n/g, '<br>');
}

// Initiales Laden der News
fetchTotalPages();
fetchNews(currentPage);
