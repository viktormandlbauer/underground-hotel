<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-3">
            <h2 class="text-center">Filter</h2>
            <div class="p-3">
                <div class="mx-4">
                    <div class="datepicker"></div>

                    <label for="person_count" class="form-label">Personen</label>
                    <output id="personCountValue" class="form-label">1</output>
                    <input type="range" class="form-range" min="1" max="5" value="1" id="person_count" oninput="document.getElementById('personCountValue').innerText = this.value">

                    <label for="price_min" class="form-label">></label>
                    <output id="minPriceValue" class="form-label">50€</output>
                    <input type="range" class="form-range" min="50" max="300" value="50" id="price_min" oninput="document.getElementById('minPriceValue').innerText = this.value + '€'">

                    <label for="price_max" class="form-label"></label>
                    <output id="maxPriceValue" class="form-label">300€</output>
                    <input type="range" class="form-range" min="50" max="300" value="300" id="price_max" oninput="document.getElementById('maxPriceValue').innerText = this.value + '€'">

                    <a class="btn btn-success d-flex justify-content-center mt-3" role="button" onClick="load_rooms()">Search</a>
                </div>
            </div>
        </div>
        <div class="col-9">
            <h2 class="text-center">Available rooms</h2>
            <div class="p-3">
                <table id="rooms_table" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Room Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rooms will be loaded here -->
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

<link rel="stylesheet" href="/public/css/datepicker.css">
<script src="/public/js/rooms.js"></script>

<?php include 'src/views/includes/footer.php'; ?>