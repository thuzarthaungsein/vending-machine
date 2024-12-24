<?php
$title = "Products";
ob_start();
?>

<div class="products mt-20">
    <div class="header">
        <h1>Product Management</h1>
        <a href="/products/create" class="btn-add">+ Add New</a>
    </div>

    <table class="product-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Available Qty</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data ?? [] as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td>$<?php echo number_format($product['price'], 2); ?></td>
                <td><?php echo htmlspecialchars($product['available_qty']); ?></td>
                
                <td>
                    <div class="actions">
                        <a href="/products/<?php echo $product['id']; ?>/edit" 
                            class="btn btn-edit">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline inline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                        </a>
                        <form method="POST" action="/products/<?php echo $product['id']; ?>/delete" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-delete" >
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline inline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layout.php';
?>