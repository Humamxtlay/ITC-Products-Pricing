function viewAddNewProduct(){
    $('#newProduct').attr('style' , '');
    $('#NewName0').val('');
    $('#NewAmazon0').val('');
    $('#NewFlipkart0').val('');
    $('#NewBigbasket0').val('');
    $('#NewGrofers0').val('');
    $('#NewPrice0').val('');
}

function addNewProduct(id = 0){
    var name = $('#NewName' + id).val().trim();
    var amazon = $('#NewAmazon' + id).val().trim();
    var flipkart = $('#NewFlipkart' + id).val().trim();
    var bigbasket = $('#NewBigbasket' + id).val().trim();
    var grofers = $('#NewGrofers' + id).val().trim();
    var price = $('#NewPrice' + id).val().trim();
    if(name == '' || (amazon == '' && flipkart == '' && bigbasket == '' && grofers == '') || price == ''){
        alert('please fill the name gap and the price gap and at least one store');
        return;
    }
    sendQuery('add' , name , amazon , flipkart , bigbasket , grofers , price);
    if(id > 0){
        $('#AllowAdd' + id).attr('style','display:none');
    }
}

function editExistingProduct(id){
    var name = $('#NewName' + id).val().trim();
    var amazon = $('#NewAmazon' + id).val().trim();
    var flipkart = $('#NewFlipkart' + id).val().trim();
    var bigbasket = $('#NewBigbasket' + id).val().trim();
    var grofers = $('#NewGrofers' + id).val().trim();
    var price = $('#NewPrice' + id).val().trim();
    if(name == '' || (amazon == '' && flipkart == '' && bigbasket == '' && grofers == '') || price == ''){
        alert('please fill the name gap and the price gap and at least one store');
        return;
    }
    $('#AllowAdd' + id).attr('style','display:none');
    $('#row' + id + 'Edit').attr('style','display:none');
    $('#row' + id + 'Original').attr('style','');
    $('#Product'+id+'Price').html(price);
    $('#Product'+id+'Name').html(name);
    $('#Product' + id + 'Amazon').html('Loading...');
    $('#Product' + id + 'Flipkart').html('Loading...');
    $('#Product' + id + 'Bigbasket').html('Loading...');
    $('#Product' + id + 'Grofers').html('Loading...');
    sendQuery('edit' , name , amazon , flipkart , bigbasket , grofers , price , id);
}

function editProduct(id){
    $('#row' + id + 'Edit').attr('style','');
    $('#row' + id + 'Original').attr('style','display:none');
    $('#NewName' + id).val($('#NewName' + id).attr('data-originalData'));
    $('#NewAmazon' + id).val($('#NewAmazon' + id).attr('data-originalData'));
    $('#NewFlipkart' + id).val($('#NewFlipkart' + id).attr('data-originalData'));
    $('#NewBigbasket' + id).val($('#NewBigbasket' + id).attr('data-originalData'));
    $('#NewGrofers' + id).val($('#NewGrofers' + id).attr('data-originalData'));
    $('#NewPrice' + id).val($('#NewPrice' + id).attr('data-originalData'));
    $('#AllowAdd' + id).attr('style','display:none');
}

function deleteProduct(id){
    var r = confirm("Are you sure you want to remove this product ?!");
    if (r == true) {
        sendQuery('remove',id);
    }
}

$(document).ready(function () {
    $('#dtBasicExample').DataTable({
        "ordering": false // false to disable sorting (or any other option)
    });
    $('.dataTables_length').addClass('bs-select');
    $("#ProductSelect").select2();
    $("#StoreSelect").select2();
    $('input[name="dates"]').daterangepicker();
});

function updateColors(id){
    if($('#Product' + id + 'Amazon').html()!=''){
        if(Number($('#Product' + id + 'Price').html()) <  Number($('#Product' + id + 'Amazon').html().replace(/\&nbsp;/g, '')))
            $('#Product' + id + 'Amazon').attr('style','background:#9be9b2;font-weight: 900;');
        else
            $('#Product' + id + 'Amazon').attr('style','background:#f59393;font-weight: 900;');
    }
    if($('#Product' + id + 'Flipkart').html()!=''){
        if(Number($('#Product' + id + 'Price').html()) <    Number($('#Product' + id + 'Flipkart').html()))
            $('#Product' + id + 'Flipkart').attr('style','background:#9be9b2;font-weight: 900;');
        else
            $('#Product' + id + 'Flipkart').attr('style','background:#f59393;font-weight: 900;');
    }
    if($('#Product' + id + 'Bigbasket').html()!=''){
        if(Number($('#Product' + id + 'Price').html()) <    Number($('#Product' + id + 'Bigbasket').html()))
            $('#Product' + id + 'Bigbasket').attr('style','background:#9be9b2;font-weight: 900;');
        else
            $('#Product' + id + 'Bigbasket').attr('style','background:#f59393;font-weight: 900;');
    }
    if($('#Product' + id + 'Grofers').html()!=''){
        if(Number($('#Product' + id + 'Price').html()) <    Number($('#Product' + id + 'Grofers').html()))
            $('#Product' + id + 'Grofers').attr('style','background:#9be9b2;font-weight: 900;');
        else
            $('#Product' + id + 'Grofers').attr('style','background:#f59393;font-weight: 900;');
    }
}

function sendQuery(type, name , amazon = '' , flipkart = '' , bigbasket = '' , grofers = '' ,  price = '' , id = 0){
    var data;
    if(type == 'add'){
        data = {'name':name , 'amazon':amazon , 'flipkart':flipkart , 'bigbasket':bigbasket , 'grofers':grofers , 'price':price};
    }
    else if(type == 'remove' || type == 'removeUser'){
        data = {'id':name};
    }
    else if(type == 'edit'){
        $('#Product' + id + 'Amazon').attr('style','');
        $('#Product' + id + 'Flipkart').attr('style','');
        $('#Product' + id + 'Bigbasket').attr('style','');
        $('#Product' + id + 'Grofers').attr('style','');
        data = {'name':name , 'amazon':amazon , 'flipkart':flipkart , 'bigbasket':bigbasket , 'grofers':grofers , 'price':price , 'id':id};
    }
    $.ajax({
        type: "POST",
        url: 'includes/ajax/' + type + '.php',
        data: data,
        dataType:"json",
        success: function(data){
            if(data['error'] == 1)
                alert(data['message']);
            else{
                if(type == 'add'){
                    updateOnce(data['id']);
                    $('#NewName').val('');
                    $('#NewAmazon').val('');
                    $('#NewFlipkart').val('');
                    $('#NewBigbasket').val('');
                    $('#NewGrofers').val('');
                    $('#NewPrice').val('');
                    $('#newProduct').attr('style' , 'display:none');
                    $('#table-rows').append(`
                            <tr id="row${data['id']}Edit" style="display:none">
                            <td>
                                <i class="fa fa-check" onclick="addNewProduct('${data['id']}');sendQuery('remove','${data['id']}')" aria-hidden="true" style="color:green"></i>
                                <i class="fa fa-times" aria-hidden="true" onclick="$('#row${data['id']}Edit').attr('style','display:none');$('#row${data['id']}Original').attr('style','');" style="color:red"></i>
                            </td>            
                            <td>
                                <p style="display:none">${name}</p>
                                <div class="form-group">
                                    <input type="text" id="NewName${data['id']}" data-originalData="${name}" class="form-control"/>
                                </div>
                            </td>
                            <td>
                                <p id="HiddenProduct${data['id']}Amazon" style="display:none">Loading...</p>
                                <div class="form-group">
                                    <input type="text" id="NewAmazon${data['id']}" data-originalData="${amazon}" class="form-control"/>
                                </div>
                            </td>
                            <td>
                                <p id="HiddenProduct${data['id']}Flipkart" style="display:none">Loading...</p>
                                <div class="form-group">
                                    <input type="text" id="NewFlipkart${data['id']}" data-originalData="${flipkart}" class="form-control"/>
                                </div>
                            </td>
                            <td>
                                <p id="HiddenProduct${data['id']}Bigbasket" style="display:none">Loading...</p>
                                <div class="form-group">
                                    <input type="text" id="NewBigbasket${data['id']}" data-originalData="${bigbasket}" class="form-control"/>
                                </div>
                            </td>
                            <td>
                                <p id="HiddenProduct${data['id']}Grofers" style="display:none">Loading...</p>
                                <div class="form-group">
                                    <input type="text" id="NewGrofers${data['id']}" data-originalData="${grofers}" class="form-control"/>
                                </div>
                            </td>
                            <td>
                                <p style="display:none">${price}</p>
                                <div class="form-group">
                                    <input type="number" id="NewPrice${data['id']}" data-originalData="${price}" class="form-control"/>
                                </div>
                            </td>
                            <td>
                                <p style="display:none"></p>
                            </td>
                        </tr>
                        <tr id="row${data['id']}Original">
                            <td>
                                <i class="fa fa-times" aria-hidden="true" onclick="deleteProduct('${data['id']}')" style="color:red"></i>
                                <i class="fa fa-pencil-square-o" aria-hidden="true" onclick="editProduct('${data['id']}')"></i>
                            </td>
                            <td data-label="name" style="font-weight: 900;" id="Product${data['id']}Name" class="name">${name}</td>
                            <td data-label="amazon" style="font-weight: 900;" id="Product${data['id']}Amazon" class="amazon">Loading...</td>
                            <td data-label="flipkart" style="font-weight: 900;" id="Product${data['id']}Flipkart" class="flipkart">Loading...</td>
                            <td data-label="bigbasket" style="font-weight: 900;" id="Product${data['id']}Bigbasket" class="bigbasket">Loading...</td>
                            <td data-label="grofers" style="font-weight: 900;" id="Product${data['id']}Grofers" class="grofers">Loading...</td>
                            <td data-label="price" style="font-weight: 900;" id="Product${data['id']}Price" class="price">${price}</td>
                            <td data-label="date" style="font-weight: 900;" class="date"></td>
                        </tr>
                    `);
                }
                else if(type == 'remove'){
                    $('#row' + name + 'Edit').remove();
                    $('#row' + name + 'Original').remove();
                }
                else if(type == 'removeUser'){
                    $('#row' + name).remove();
                }
                else if(type == 'edit'){
                    updateOnce(id);
                }
            }
        },
        error: function(xmlhttprequest, textstatus, message){
            alert(textstatus);
        }
    });
}

function updateOnce(id){
    data = {'id':id};
    $.ajax({
        type: "GET",
        url: 'API/UpdateOne.php',
        data: data,
        dataType:"json",
        success: function(data){
            $('#Product' + id + 'Amazon').html(data['amazon']);
            $('#Product' + id + 'Flipkart').html(data['flipkart']);
            $('#Product' + id + 'Bigbasket').html(data['bigbasket']);
            $('#Product' + id + 'Grofers').html(data['grofers']);
            $('#HiddenProduct' + id + 'Amazon').html(data['amazon']);
            $('#HiddenProduct' + id + 'Flipkart').html(data['flipkart']);
            $('#HiddenProduct' + id + 'Bigbasket').html(data['bigbasket']);
            $('#HiddenProduct' + id + 'Grofers').html(data['grofers']);
            updateColors(id);
        },
        error: function(xmlhttprequest, textstatus, message){
            $('#Product' + id + 'Amazon').html('Error');
            $('#Product' + id + 'Flipkart').html('Error');
            $('#Product' + id + 'Bigbasket').html('Error');
            $('#Product' + id + 'Grofers').html('Error');
        }
    });
}