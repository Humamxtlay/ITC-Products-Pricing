<?php
include "includes/DBConnection.php";
include "includes/layouts/header.php";
?>

<div class="nav">
    <a href="index.php"><button type="button col" class="btn btn-secondary"><i class="fa fa-1x fa-shopping-cart" aria-hidden="true"></i> Products</button></a>
    <a href="users.php"><button type="button col" class="btn btn-secondary"><i class="fa fa-1x fa-users" aria-hidden="true"></i> Users</button></a>
    <a href="logout.php"><button type="button col" style="float:right" class="btn btn-secondary"><i class="fa fa-1x fa-sign-out" aria-hidden="true"></i> Sign out</button></a>
</div>
<div class="container" >
    <h2 class="text-center" id="title">Products Chart</h2>
    <div class="row" style="margin-top:35px">
        <div id="reportrange" class="col col-md-3" style="background: #fff; cursor: pointer; padding: 5px 10px; border-radius: 8px;">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
        <select id='StoreSelect' onchange="updateChart()" class="col col-md-3">
            <option value='0'>Select a store...</option> 
            <option value="1">Amazon</option>
            <option value="2">Flipkart</option>
            <option value="3">BigBasket</option>
            <option value="4">Grofers</option> 
        </select>
        <div class="col col-md-1"></div>
        <select id='ProductSelect' onchange="updateChart()" class="col col-md-4">
            <option value='0'>Select a product...</option> 
            <?php
                $query = "SELECT * FROM products ";
                $statement = $connect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $i = 0;
                foreach($result as $row){
                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }
            ?> 
        </select>
    </div>
    <h4 id="errorMessage" class="text-center" style="color:#f14646"></h4>
    <canvas id="Chart" height="100" style="margin-top:35px"></canvas>
</div>
<?php
include "includes/layouts/footer.php";
?>
<script src="js/chart10.js"></script>