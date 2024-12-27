<?php include 'src/views/includes/header.php'; ?>
<link rel="stylesheet" href="/public/css/pagination.css">
</link>

<body>
    <?php include 'src/views/includes/navbar.php'; ?>
    <div class="container my-5">
        <div class="row bg-dark text-white py-4 rounded">
            <div class="col-3">
                <div class="p-3">
                    <form method="GET" action="/rooms">
                        <div class="d-flex align-items-center flex-column">

                            <h2 class="text-center display-4" id="Pages">Filter</h2>
                            <?php include 'src/views/includes/datepicker.php'; ?>

                            <div class="w-75">
                                <div class="mt-2">
                                    Personenanzahl:
                                    <span id="personCountSpan">1</span>
                                    <input type="hidden" id="personCount">
                                    <div id="personCountSlider" class="w-100 my-1"></div>
                                </div>
                                <div class="mt-5">
                                    Preisbereich:
                                    <span id="minPriceSpan">0</span>€ - <span id="maxPriceSpan">300</span>€
                                    <input type="hidden" id="minPrice">
                                    <input type="hidden" id="maxPrice">
                                    <div id="priceRangeSlider" class="w-100 my-1"></div>
                                </div>
                            </div>
                            <link rel="stylesheet" href="/public/css/slider.css">
                            <script src="/public/js/slider.js"></script>


                            <button type="submit"
                                class="btn btn-success d-flex justify-content-center mt-3">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-9">
                <h2 class="text-center display-3" id="Pages">Zimmer</h2>
                <div class="p-3">
                    <table id="sortedTable"
                        class="table table-dark table-bordered table-striped align-middle table-hover tablesorter">
                        <thead>
                            <tr>
                                <th scope="col">Bezeichnung</th>
                                <th scope="col">Beschreibung</th>
                                <th scope="col">Typ</th>
                                <th scope="col">Preis pro Nacht</th>
                                <th scope="col">Bild</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rooms as $room): ?>
                                <tr>
                                    <td><?= $room['name'] ?></td>
                                    <td><?= $room['description'] ?></td>
                                    <td><?= $room['type'] ?></td>
                                    <td><?= $room['price_per_night'] ?>€</td>
                                    <td><img src="<?= $room['image_path'] ?>" alt="No Image" width="100"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item bg-success  active">
                                <a class="page-link" href="#">2 <span class=" bg-success sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <?php include 'src/views/includes/footer.php'; ?>
</body>