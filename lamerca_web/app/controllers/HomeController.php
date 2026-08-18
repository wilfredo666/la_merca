<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Category.php';

class HomeController extends Controller
{
    public function index(): string
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max(1, $page);
        $search = isset($_GET['q']) ? trim((string) $_GET['q']) : '';
        $categoryName = isset($_GET['category']) ? trim((string) $_GET['category']) : '';
        $categoryName = $categoryName !== '' ? $categoryName : null;

        $categories = Category::all();
        $selectedCategoryName = null;
        if ($categoryName !== null) {
            foreach ($categories as $category) {
                if ($category['name'] === $categoryName) {
                    $selectedCategoryName = $category['name'];
                    break;
                }
            }
        }

        $pagination = Product::paginate($page, 12, $search, $categoryName);

        return $this->render('home.index', [
            'products' => $pagination['products'],
            'pageTitle' => 'La Merca - Catálogo',
            'totalProducts' => $pagination['total'],
            'currentPage' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'perPage' => $pagination['perPage'],
            'categories' => $categories,
            'q' => $search,
            'categoryName' => $categoryName,
            'selectedCategoryName' => $selectedCategoryName,
        ]);
    }
}
