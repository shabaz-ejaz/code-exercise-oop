<?php
if (!empty($products)) {

    if (!empty($products->error)) {
        ?>
        <h2>There was an error with the data source: <?php echo $products->error; ?></h2>
        <?php
    } else {
        ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Action</th>
            </tr>

            <?php
            foreach ($products->products as $key => $value) {
                ?>
                <tr>
                    <td><?php echo $key ?></td>
                    <td><?php echo $value ?></td>
                    <td>
                        <form action="index.php" method='get'>
                            <input type="submit" class="btn" value="View more">
                            <input type="hidden" name="product_id" value="<?php echo $key ?>">
                        </form>
                    </td>
                </tr>

                <?php
            }

            ?>

        </table>
        <br>
        <br>

        <?php

    }
}