<?php include('header.php'); ?>

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 1000px">
            <?php include('sidemenu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-primary">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2"></div>
                    </div>
                </div>

                <h2 class="text-secondary">Create Product</h2>
                <div class="card shadow-sm p-4 mt-4">
                    <div class="mx-auto container">
                        <form id="create-form" enctype="multipart/form-data" method="POST" action="create_product.php">
                            <p class="text-danger"><?php if (isset($_GET['error'])) { echo $_GET['error']; } ?></p>
                            <div class="form-group mt-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" id="product-name" name="name" placeholder="Enter product title" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="product-desc" name="description" rows="3" placeholder="Enter product description" required></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" id="product-price" name="price" placeholder="Enter price" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Special Offer/Sale (%)</label>
                                <input type="number" class="form-control" id="product-offer" name="offer" placeholder="Enter sale percentage" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" required name="category">
                                    <option value="exclusive">Exclusive</option>
                                    <option value="featured">Featured</option>
                                    <option value="party">Party</option>
                                    <option value="nike">Nike</option>
                                    <option value="adidas">Adidas</option>
                                    <option value="puma">Puma</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Color</label>
                                <input type="text" class="form-control" id="product-color" name="color" placeholder="Enter product color" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Image 1</label>
                                <input type="file" class="form-control" id="image1" name="image1" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Image 2</label>
                                <input type="file" class="form-control" id="image2" name="image2" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Image 3</label>
                                <input type="file" class="form-control" id="image3" name="image3" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Image 4</label>
                                <input type="file" class="form-control" id="image4" name="image4" required>
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" name="create_product" class="btn btn-primary w-100">Create Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.2/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin=
                                <input type="file" class="form-control" id="image3" name="image3" required>
                            </div>
                            <div class="form-group mt-2">
                                <label>Image 4</label>
                                <input type="file" class="form-control" id="image4" name="image4" required>
                            </div>

                            <div class="form-group mt-3">
                                <input type="submit" name="create_product" class="btn btn-primary" value="Create">
                            </div>

                        </form>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.2/dist/feather.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                    crossorigin="anonymous"></script>
</body>