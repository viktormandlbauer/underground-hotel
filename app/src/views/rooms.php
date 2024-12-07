<?php include 'src/views/includes/header.php'; ?>

<body>
    <?php include 'src/views/includes/navbar.php'; ?>
    <div class="container mt-5 vh-100">
        <div class="row">
            <div class="col-3">
                <h2 class="text-center">Filter</h2>
                <div class="p-3">
                    <form method="GET" action="/rooms">
                        <div class="mx-4">

                            <?php include 'src/views/includes/datepicker.php'; ?>

                            <label for="person_count" class="form-label">Personen</label>
                            <output id="personCountValue" class="form-label"><?= $person_count ?? 1 ?></output>
                            <input type="range" class="form-range" min="1" max="5" value="<?= $person_count ?? 1 ?>"
                                id="person_count" name="person_count"
                                oninput="document.getElementById('personCountValue').innerText = this.value">

                            <label for="price_min" class="form-label">min </label>
                            <output id="minPriceValue" class="form-label"><?= $price_min ?? 1 ?>€</output>
                            <input type="range" class="form-range" min="0" max="300" value="<?= $price_min ?? 1 ?>"
                                id="price_min" name="price_min"
                                oninput="document.getElementById('minPriceValue').innerText = this.value + '€'">

                            <label for="price_max" class="form-label">max </label>
                            <output id="maxPriceValue" class="form-label"><?= $price_max ?? 300 ?>€</output>
                            <input type="range" class="form-range" min="0" max="300" value="<?= $price_max ?? 300 ?>"
                                id="price_max" name="price_max"
                                oninput="document.getElementById('maxPriceValue').innerText = this.value + '€'">

                            <button type="submit"
                                class="btn btn-success d-flex justify-content-center mt-3">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-9">
                <h2 class="text-center">Verfügbare Zimmer</h2>
                <div class="p-3">
                    <table id="rooms_table" class="table table-striped">
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
                            <?php foreach ($rooms as $article): ?>
                                <tr>
                                    <td><?= $article['name'] ?></td>
                                    <td><?= $article['description'] ?></td>
                                    <td><?= $article['type'] ?></td>
                                    <td><?= $article['price_per_night'] ?>€</td>
                                    <td><img src="<?= $article['image_path'] ?>" alt="No Image" width="100"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <?php include 'src/views/includes/footer.php'; ?>
</body>