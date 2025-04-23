<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark text-white sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link text-white active" aria-current="page" href="index.php">
                    <i class="bi bi-house-door-fill me-2"></i>
                    <strong>Dashboard</strong>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="index.php">
                    <i class="bi bi-file-earmark-text-fill me-2"></i>
                    <strong>Orders</strong>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="products.php">
                    <i class="bi bi-cart-fill me-2"></i>
                    <strong>Products</strong>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="add_product.php">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    <strong>Add New Product</strong>
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
    #sidebarMenu {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        min-height: 100vh;
    }
    #sidebarMenu .nav-link {
        transition: all 0.3s ease;
    }
    #sidebarMenu .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
    }
    #sidebarMenu .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }
</style>