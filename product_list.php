<?php
function renderProductList($products, $isAdmin = false)
{
    foreach ($products as $product) { ?>
        <div class="form-container">
            <?php if ($isAdmin): ?>
                <?= renderProductForm($product) ?>
            <?php else: ?>
                <img src="<?= $product['image_path'] ?>" width="150" height="150" style="object-fit: cover;">
                <h3>Title: <?= $product['title'] ?></h3>
                <p>Category: <?= $product['name'] ?></p>
                <p>Description: <?= $product['description'] ?></p>
                <p>Price: <?= $product['price'] ?></p>
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            <?php endif; ?>
        </div>
    <?php }
}

function renderProductForm($product)
{ ?>
    <form class="admin-form" method="POST" action="product_crud.php">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

        <label>Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($product['title']) ?>" required>

        <label>Description:</label>
        <input type="text" name="description" value="<?= htmlspecialchars($product['description']) ?>" required>

        <label>Category ID:</label>
        <input type="number" name="category_id" value="<?= $product['category_id'] ?>" required>

        <label>Price:</label>
        <input type="text" name="price" value="<?= number_format($product['price'], 2, '.', '') ?>" required>

        <label style="margin-bottom: 10px;">Current Image:</label>
        <img src="<?= htmlspecialchars($product['image_path']) ?>" width="200px" style="margin-bottom: 10px;">

        <label>Change Image:</label>
        <input type="file" name="image">

        <button type="submit" name="update">Update</button>
        <button type="submit" name="delete">Delete</button>
    </form>
<?php } ?>