var startDate = '';
var endDate = '';

$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();    
    function cb(start, end) {
        startDate = start;
        endDate = end;
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        updateChart();
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);
});
var ctx = document.getElementById('Chart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Price by Time Chart',
            data: [],
            backgroundColor: [
                'rgba(0, 100, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(0, 100, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
        }]
    },
});

function updateChart(){
    if($('#ProductSelect').val() == 0 || $('#StoreSelect').val() == 0){
        $('#errorMessage').html('please insert valid data, fill all fields above');
        return;
    }
    $('#errorMessage').html('Loading...');
    $('#title').html($('#ProductSelect option:selected').html() + ' ==> ' + $('#StoreSelect option:selected').html() + ' Store <small></br>Between ' + startDate.format('YYYY-MM-DD 00:00:00') + ' And ' + endDate.format('YYYY-MM-DD 23:59:59') + '</small>');
    data = {
        'product':$('#ProductSelect').val(),
        'store':$('#StoreSelect').val(),
        'startDate':startDate.format('YYYY-MM-DD 00:00:00'),
        'endDate':endDate.format('YYYY-MM-DD 23:59:59'),
    };
    $.ajax({
        type: "POST",
        url: 'includes/ajax/chartData.php',
        data: data,
        dataType:"json",
        success: function(data){
            if(data.error == 1)
                $('#errorMessage').html(data.message);
            else{
                $('#errorMessage').html('');
                var y = [];
                var x = [];
                var more = 0;
                var small = 0;
                for(var i=0;i<data.data.length;i++){
                    y.push(data.data[i].price);
                    x.push(data.data[i].date);
                }
                for(var i=0;i<data.data.length;i = i + 24){
                    if(data.data[i].price > data.price)
                        more++;
                    else if(data.data[i].price < data.price)
                        small++;
                }
                $('#errorMessage').html(`
                    <small style='color:#f14646'>Number of days listed price > agreed price : <strong>${more}</strong></small></br>
                    <small style='color:#f14646'>Number of days listed price < agreed price : <strong>${small}</strong></small></br>
                    <small style='color:#f14646'>System price : <strong>${data.price}</strong></small>`);
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: x,
                        datasets: [{
                            label: 'Price by Time Chart',
                            data: y,
                            backgroundColor: [
                                'rgba(0, 100, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(0, 100, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                        }]
                    },
                });
            }    
        },
        error: function(xmlhttprequest, textstatus, message){
            alert(textstatus);
        }
    });
}