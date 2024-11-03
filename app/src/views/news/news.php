<?php include 'src/views/includes/header.php'; ?>


<title>News</title>

<style>

.news-container {
    max-width: 800px;
    margin: 50px auto; /* Abstand oben und unten */
    padding: 0 20px; /* Abstand links und rechts */
    align-items: center;
    justify-content: center;
}

.news-item {
    background-color: rgba(255, 255, 255, 0.85); /* Leicht durchsichtiges Weiß */
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.6); /* Leicht durchsichtiger Rand */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(2px); /* Leichter Unschärfeeffekt innerhalb des Blocks */
}

.news-item h2 {
    font-size: 24px;
    
}

.read-more-overlay {
    position: absolute;
    bottom: 10px;
    right: 20px;
    background-color: rgba(0, 0, 0, 0.5); 
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
}

.news-item {
    position: relative; 
   
    background-color: rgba(255, 255, 255, 0.85);
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.6);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(2px);
}


</style>

<div class="news-container" id="news-container"></div>

<div class="news-item-template" id="news-item-template" style="display: none;">
    <div class="news-item">
        <h2 class="news-title"></h2>
        <img class="news-image" alt="News Bild" style="display: none;">
        <p class="news-content"></p>
        <div class="news-date"></div>
    </div>
</div>

<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
    <li class="page-item"><a class="page-link" href="#" onclick="loadPage('prev')">Previous</a></li>
    <li class="page-item" id="pagination-copy" style="display: none;"><a class="page-link" href="#" onclick="loadPage(1)">1</a></li>
    <li class="page-item"><a class="page-link" href="#" onclick="loadPage('next')">Next</a></li>
  </ul>
</nav>


<script src="/public/js/news.js"></script>


<?php include 'src/views/includes/footer.php'; ?>