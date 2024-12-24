<?php
$title = "Edit Product";
ob_start();
?>

<div class="products mt-20">
    <div class="header">
        <h1>Edit Product</h1>
        <a href="/products" class="btn-add">
        <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 20 20"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round" style="display: inline-block; margin-right:3px;"  class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg></a>
    </div>

    <div class="form-div">
        <form action="/products/<?php echo $data['id']; ?>/update" method="POST" onsubmit="return validateForm();">
            <input type="hidden" name="_method" value="PUT">

            <div>
            <label for="name">Product Name:</label><br/>
            <input type="text" id="name" name="name" value="<?php echo $data['name'] ?>" required  placeholder="Enter product name">
            </div>
            
            <div>
            <label for="price">Price:</label><br/>
            <input type="number" id="price" name="price" min="0.01"  value="<?php echo $data['price'] ?>" step="0.01" required  placeholder="Enter price">
            </div>
            
            <div>
            <label for="available_qty">Available Quantity:</label><br/>
            <input type="number" id="available_qty" name="available_qty"  value="<?php echo $data['available_qty'] ?>" min="0" required  placeholder="Enter available quantity">
            </div>
            
            <button type="submit" class="btn btn-add mt-20">Update Product</button>
        </form>
    </div>
    
</div>

<script>
function validateForm() {
    const name = document.getElementById('name').value.trim();
    const price = parseFloat(document.getElementById('price').value);
    const availableQty = parseInt(document.getElementById('available_qty').value, 10);

    if (!name || price <= 0 || availableQty < 0) {
        alert('Please ensure all fields are valid.');
        return false;
    }
    return true;
}
</script>


<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layout.php';
?>