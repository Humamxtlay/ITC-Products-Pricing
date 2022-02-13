<?php
include "includes/DBConnection.php";
include "includes/layouts/header.php";
?>

<div class="nav">
    <a href="users.php"><button type="button col" class="btn btn-secondary"><i class="fa fa-1x fa-users" aria-hidden="true"></i> Users</button></a>
    <a href="chart.php"><button type="button col" class="btn btn-secondary"><i class="fa fa-1x fa-area-chart" aria-hidden="true"></i> Charts</button></a>
    <button type="button col" style="padding:7px" class="btn btn-secondary" onclick="viewAddNewProduct()"><i class="fa fa-1x fa-cart-plus" aria-hidden="true"></i> New Product</button>
    <a href="logout.php"><button type="button col" style="float:right" class="btn btn-secondary"><i class="fa fa-1x fa-sign-out" aria-hidden="true"></i> Sign out</button></a>
</div>

<table id="dtBasicExample" class="table table-bordered table-sm" cellspacing="0" width="100%" class="table-responsive-full">
    <thead>
        <tr>
            <th class="th-sm">#</th>
            <th class="th-sm">name</th>
            <th class="th-sm">amazon</th>
            <th class="th-sm">flipkart</th>
            <th class="th-sm">bigbasket</th>
            <th class="th-sm">grofers</th>
            <th class="th-sm">price</th>
            <th class="th-sm">date</th>
        </tr>
        <tr id="newProduct" style="display:none">
            <td class="th-sm">
                <i class="fa fa-check" onclick="addNewProduct()" aria-hidden="true" style="color:green"></i>
                <i class="fa fa-times" aria-hidden="true" onclick="$('#newProduct').attr('style','display:none');" style="color:red"></i>
            </td>            
            <td class="th-sm">
                <div class="form-group">
                    <input type="text" id="NewName0" placeholder='Enter Product Name' class="form-control"/>
                </div>
            </td>
            <td class="th-sm">
                <div class="form-group">
                    <input type="text" id="NewAmazon0" placeholder='Enter Amazon Link' class="form-control"/>
                </div>
            </td>
            <td class="th-sm">
                <div class="form-group">
                    <input type="text" id="NewFlipkart0" placeholder='Enter Flipkart Link' class="form-control"/>
                </div>
            </td>
            <td class="th-sm">
                <div class="form-group">
                    <input type="text" id="NewBigbasket0" placeholder='Enter Bigbasket Link' class="form-control"/>
                </div>
            </td>
            <td class="th-sm">
                <div class="form-group">
                    <input type="text" id="NewGrofers0" placeholder='Enter Grofers Link' class="form-control"/>
                </div>
            </td>
            <td class="th-sm">
                <div class="form-group">
                    <input type="number" id="NewPrice0" placeholder='Enter Product Price' class="form-control"/>
                </div>
            </td>
            <td class="th-sm"></td>
        </tr>
    </thead>
    <tbody id="table-rows">
        <?php
            $query = "SELECT * FROM products ";
            $statement = $connect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $i = 0;
            foreach($result as $row){
        ?>
        <tr id="row<?php echo $row['id'] ?>Edit" style="display:none;">
            <td id="row-<?php echo $i?>-control">
                <i class="fa fa-check" id="AllowAdd<?php echo $row['id'] ?>" style="display:none;" onclick="editExistingProduct('<?php echo $row['id'] ?>');" aria-hidden="true" style="color:green"></i>
                <i class="fa fa-times" aria-hidden="true" onclick="$('#row<?php echo $row['id'] ?>Edit').attr('style','display:none');$('#row<?php echo $row['id'] ?>Original').attr('style','');" style="color:red"></i>
            </td>            
            <td>
                <p style="display:none"><?php echo $row['name'] ?></p>
                <div class="form-group">
                    <input type="text" onchange="$('#AllowAdd<?php echo $row['id'] ?>').attr('style','color:green')" id="NewName<?php echo $row['id'] ?>" data-originalData="<?php echo $row['name'] ?>" class="form-control"/>
                </div>
            </td>
            <td>
                <p id="HiddenProduct<?php echo $row['id'] ?>Amazon" style="display:none"><?php echo $row['amazonPrice'] ?></p>
                <div class="form-group">
                    <input type="text" onchange="$('#AllowAdd<?php echo $row['id'] ?>').attr('style','color:green')" id="NewAmazon<?php echo $row['id'] ?>" data-originalData="<?php echo $row['amazon'] ?>" class="form-control"/>
                </div>
            </td>
            <td>
                <p id="HiddenProduct<?php echo $row['id'] ?>Flipkart" style="display:none"><?php echo $row['flipkartPrice'] ?></p>
                <div class="form-group">
                    <input type="text" onchange="$('#AllowAdd<?php echo $row['id'] ?>').attr('style','color:green')" id="NewFlipkart<?php echo $row['id'] ?>" data-originalData="<?php echo $row['flipkart'] ?>" class="form-control"/>
                </div>
            </td>
            <td>
                <p id="HiddenProduct<?php echo $row['id'] ?>Bigbasket" style="display:none"><?php echo $row['bigbasketPrice'] ?></p>
                <div class="form-group">
                    <input type="text" onchange="$('#AllowAdd<?php echo $row['id'] ?>').attr('style','color:green')" id="NewBigbasket<?php echo $row['id'] ?>" data-originalData="<?php echo $row['bigbasket'] ?>" class="form-control"/>
                </div>
            </td>
            <td>
                <p id="HiddenProduct<?php echo $row['id'] ?>Grofers" style="display:none"><?php echo $row['grofersPrice'] ?></p>
                <div class="form-group">
                    <input type="text" onchange="$('#AllowAdd<?php echo $row['id'] ?>').attr('style','color:green')" id="NewGrofers<?php echo $row['id'] ?>" data-originalData="<?php echo $row['grofers'] ?>" class="form-control"/>
                </div>
            </td>
            <td>
                <p style="display:none"><?php echo $row['price'] ?></p>
                <div class="form-group">
                    <input type="number" onchange="$('#AllowAdd<?php echo $row['id'] ?>').attr('style','color:green')" id="NewPrice<?php echo $row['id'] ?>" data-originalData="<?php echo $row['price'] ?>" class="form-control"/>
                </div>
            </td>
            <td>
                <p style="display:none"><?php echo $row['date'] ?></p>
            </td>
        </tr>
        <tr id="row<?php echo $row['id'] ?>Original">
            <td>
                <i class="fa fa-times" aria-hidden="true" onclick="deleteProduct('<?php echo $row['id'] ?>')" style="color:red"></i>
                <i class="fa fa-pencil-square-o" style="color:#366683" aria-hidden="true" onclick="editProduct('<?php echo $row['id'] ?>')"></i>
            </td>
            <td data-label="name" id="Product<?php echo $row['id'] ?>Name" class="name"><?php echo $row['name'] ?></td>
            <?php 
                $amazonColor = 'none';
                $flipkartColor = 'none';
                $bigbasketColor = 'none';
                $grofersColor = 'none';
                if(intval(str_replace("\xc2\xa0", '', $row['amazonPrice'])) > intval($row['price'])) 
                    $amazonColor = '#9be9b2';
                elseif(intval(str_replace("\xc2\xa0", '', $row['amazonPrice'])) < intval($row['price']) && str_replace("\xc2\xa0", '', $row['amazonPrice'])!='') 
                    $amazonColor = '#f59393';
                if(intval($row['flipkartPrice']) > intval($row['price'])) 
                    $flipkartColor = '#9be9b2';
                elseif(intval($row['flipkartPrice']) < intval($row['price']) && $row['flipkartPrice']!='') 
                    $flipkartColor = '#f59393';
                if(intval($row['bigbasketPrice']) > intval($row['price'])) 
                    $bigbasketColor = '#9be9b2';
                elseif(intval($row['bigbasketPrice']) < intval($row['price']) && $row['bigbasketPrice']!='') 
                    $bigbasketColor = '#f59393';
                if(intval($row['grofersPrice']) > intval($row['price'])) 
                    $grofersColor = '#9be9b2';
                elseif(intval($row['grofersPrice']) < intval($row['price']) && $row['grofersPrice']!='') 
                    $grofersColor = '#f59393';
            ?>
            <td data-label="amazon" style="background:<?php echo $amazonColor; ?>;" id="Product<?php echo $row['id'] ?>Amazon" class="amazon"><?php echo $row['amazonPrice'] ?></td>
            <td data-label="flipkart" style="background:<?php echo $flipkartColor;?>;" id="Product<?php echo $row['id'] ?>Flipkart" class="flipkart"><?php echo $row['flipkartPrice'] ?></td>
            <td data-label="bigbasket" style="background:<?php echo $bigbasketColor;?>;" id="Product<?php echo $row['id'] ?>Bigbasket" class="bigbasket"><?php echo $row['bigbasketPrice'] ?></td>
            <td data-label="grofers" style="background:<?php echo $grofersColor;?>;" id="Product<?php echo $row['id'] ?>Grofers" class="grofers"><?php echo $row['grofersPrice'] ?></td>
            <td data-label="price" id="Product<?php echo $row['id'] ?>Price" class="price"><?php echo $row['price'] ?></td>
            <td data-label="date" class="date"><?php echo $row['date'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php
include "includes/layouts/footer.php";
?>

