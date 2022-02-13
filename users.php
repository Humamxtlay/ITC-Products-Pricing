<?php
include "includes/DBConnection.php";
include "includes/layouts/header.php";
?>

<div class="nav">
    <a href="index.php"><button type="button col" class="btn btn-secondary"><i class="fa fa-1x fa-shopping-cart" aria-hidden="true"></i> Products</button></a>
    <a href="chart.php"><button type="button col" class="btn btn-secondary"><i class="fa fa-1x fa-area-chart" aria-hidden="true"></i> Charts</button></a>
    <a href="logout.php"><button type="button col" style="float:right" class="btn btn-secondary"><i class="fa fa-1x fa-sign-out" aria-hidden="true"></i> Sign out</button></a>
    <?php 
        if($_SESSION['role'] == '1'){
    ?>
    <a href="register.php"><button type="button col" class="btn btn-secondary"><i class="fa fa-1x fa-user-plus" aria-hidden="true"></i> New User</button></a>
    <?php } ?>

</div>

<table id="dtBasicExample" class="table table-bordered table-sm" cellspacing="0" width="100%" class="table-responsive-full">
    <thead>
        <tr>
            <?php 
                if($_SESSION['role'] == '1') 
                    echo '<th class="th-sm">#</th>';
            ?>
            <th class="th-sm">username</th>
            <th class="th-sm">email</th>
            <th class="th-sm">phone</th>
            <th class="th-sm">role</th>
        </tr>
    </thead>
    <tbody id="table-rows">
        <?php
            $query = "SELECT * FROM users ";
            $statement = $connect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $i = 0;
            foreach($result as $row){
        ?>
        <tr id="row<?php echo $row['id'] ?>">
            <?php 
                if($_SESSION['role'] == '1'){
            ?>
                <td>
                    <i class="fa fa-times" aria-hidden="true" onclick="sendQuery('removeUser','<?php echo $row['id'] ?>')" style="color:red"></i>
                </td>
            <?php } ?>
            <td data-label="username" class="username"><?php echo $row['userName'] ?></td>
            <td data-label="email" class="email"><?php echo $row['email'] ?></td>
            <td data-label="phone" class="phone"><?php echo $row['phone'] ?></td>
            <td data-label="role" class="role">
                <?php 
                    if($row['role'] == '1') echo "Admin";
                    else echo "User";
                ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php
include "includes/layouts/footer.php";
?>
