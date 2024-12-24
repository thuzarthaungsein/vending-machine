<?php
$title = "Vending Machine";
ob_start();

?>

<h1 class="mt-20">Vending Machine</h1>
<div class="products product-grid">
    <?php foreach ($data ?? [] as $product): ?>
        <div class="product">
            <img src="/public/product.png" alt=""  class="product-image">
            <div style="display:flex;width:100%;margin-bottom:10px;">
            <h2 style="width:70%;"><?= htmlspecialchars($product['name']) ?></h2>         
            
            <p class="price">$<?= number_format($product['price'], 2) ?></p>
            </div>
            
            <form action="/products/purchase" method="POST"  style="display:flex;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="number" name="quantity" min="1" max="<?= $product['available_qty'] ?>" placeholder="Enter Quantity" style="display:inline-block; margin-top:0;margin-bottom:0; margin-right:5px;" required>

                <button type="submit" class="btn btn-add" style="display:flex;padding: 7px 10px !important;">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-bag-check" style="display:inline-block; margin-right:3px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-2.926a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304h11.339a2 2 0 0 1 1.977 2.304l-.5 3.248" /><path d="M9 11v-5a3 3 0 0 1 6 0v5" /><path d="M15 19l2 2l4 -4" /></svg>
                </button>
            </form>
            
        </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>


