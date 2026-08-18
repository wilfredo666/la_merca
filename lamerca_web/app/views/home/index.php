<?php

/** @var array $products */
/** @var int $totalProducts */
/** @var int $currentPage */
/** @var int $totalPages */
/** @var int $perPage */
/** @var string|null $q */
/** @var string|null $categoryName */
/** @var string|null $selectedCategoryName */
?>
<section class="home-slider mb-5">
    <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/lamerca_web/assets/dist/img/slider1.png" class="d-block w-100" alt="Mejor colección">
                <div class="carousel-caption d-none d-md-block text-start">
                    <h2 class="display-6 fw-bold">Descubre lo mejor</h2>
                    <p class="lead">Productos seleccionados con diseño moderno y envío rápido.</p>
                    <a href="#catalog" class="btn btn-primary btn-lg">Ver catálogo</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/lamerca_web/assets/dist/img/slider2.png" class="d-block w-100" alt="Ofertas especiales">
                <div class="carousel-caption d-none d-md-block text-start">
                    <h2 class="display-6 fw-bold">Ofertas especiales</h2>
                    <p class="lead">Aprovecha descuentos exclusivos en nuestra tienda.</p>
                    <a href="#catalog" class="btn btn-primary btn-lg">Ver ofertas</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/lamerca_web/assets/dist/img/slider3.png" class="d-block w-100" alt="Calidad y confianza">
                <div class="carousel-caption d-none d-md-block text-start">
                    <h2 class="display-6 fw-bold">Calidad y confianza</h2>
                    <p class="lead">Compra con seguridad en nuestra tienda en línea.</p>
                    <a href="#catalog" class="btn btn-primary btn-lg">Comprar ahora</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</section>


<section id="catalog" class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Nuestro catálogo</h2>
            <?php if (!empty($q) || !empty($selectedCategoryName)): ?>
                <p class="text-muted">
                    <?php if (!empty($q) && !empty($selectedCategoryName)): ?>
                        Resultados para "<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>" en categoría <?= htmlspecialchars($selectedCategoryName, ENT_QUOTES, 'UTF-8') ?>.
                    <?php elseif (!empty($q)): ?>
                        Resultados para "<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>".
                    <?php else: ?>
                        Productos en categoría <?= htmlspecialchars($selectedCategoryName, ENT_QUOTES, 'UTF-8') ?>.
                    <?php endif; ?>
                </p>
            <?php else: ?>
                <p class="text-muted">Productos destacados para tu hogar, estilo y tecnología.</p>
            <?php endif; ?>
        </div>
        <span class="badge bg-primary py-2 px-3"><?= htmlspecialchars((string) $totalProducts, ENT_QUOTES, 'UTF-8') ?> productos</span>
    </div>

    <?php if (empty($products)): ?>
        <div class="alert alert-warning" role="alert">
            <?php if (!empty($q) || !empty($selectedCategoryName)): ?>
                <?php if (!empty($q) && !empty($selectedCategoryName)): ?>
                    No se encontraron productos para "<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>" en la categoría <?= htmlspecialchars($selectedCategoryName, ENT_QUOTES, 'UTF-8') ?>.
                <?php elseif (!empty($q)): ?>
                    No se encontraron productos para "<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>".
                <?php else: ?>
                    No se encontraron productos en la categoría <?= htmlspecialchars($selectedCategoryName, ENT_QUOTES, 'UTF-8') ?>.
                <?php endif; ?>
            <?php else: ?>
                No hay productos disponibles en este momento.
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <?php
                $imageName = trim((string) ($product['image'] ?? ''));
                $imageUrl = $imageName
                    ? 'https://lamercabolivia.com/assest/dist/img/producto/' . rawurlencode($imageName)
                    : '/lamerca_web/assets/dist/img/product_default.png';
                ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card product-card h-100 shadow-sm border-0">
                        <img src="<?= htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" onerror="this.onerror=null;this.src='/lamerca_web/assets/dist/img/product_default.png';">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h5>
                            <p class="text-muted mb-2"><?= htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text mb-4"><?= htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-5 fw-bold">$<?= number_format((float)$product['price'], 2) ?></span>
                                </div>
                                <form action="/lamerca_web/index.php?route=cart/add" method="post" class="w-100">
                                    <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                    <button type="submit" class="btn btn-primary w-100">Agregar al carrito</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <?php
            $maxPagesToShow = 7;
            $startPage = max(1, $currentPage - 3);
            $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);
            if ($endPage - $startPage + 1 < $maxPagesToShow) {
                $startPage = max(1, $endPage - $maxPagesToShow + 1);
            }
            ?>
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Paginación de productos">
                    <ul class="pagination pagination-lg flex-wrap justify-content-center">
                        <?php
                            $queryString = '';
                            if (!empty($q)) {
                                $queryString .= '&q=' . rawurlencode($q);
                            }
                            if (!empty($categoryId)) {
                                $queryString .= '&category=' . intval($categoryId);
                            }
                        ?>
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $currentPage - 1 ?><?= $queryString ?>" aria-label="Anterior">&laquo;</a>
                            </li>
                        <?php endif; ?>

                        <?php if ($startPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1<?= $queryString ?>">1</a>
                            </li>
                            <?php if ($startPage > 2): ?>
                                <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
                            <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $page ?><?= $queryString ?>"><?= $page ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($endPage < $totalPages): ?>
                            <?php if ($endPage < $totalPages - 1): ?>
                                <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $totalPages ?><?= $queryString ?>"><?= $totalPages ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $currentPage + 1 ?><?= $queryString ?>" aria-label="Siguiente">&raquo;</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</section>