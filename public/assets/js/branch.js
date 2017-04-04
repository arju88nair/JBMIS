function valData(val) {
    if (val == null || val == '') {
        return 0;
    } else {
        return val;
    }
}
$('.editbtn').click(function() {
    var id=this.id;
    var $this = $(this);
    var tr =$this.closest('tr')
    var input=  $('td.bid',tr)
    var tds = $this.closest('tr').find('td').filter(function() {
        return $(this).find('.editbtn').length === 0;
    });
    if ($this.html() === 'Edit') {
        $this.html('Save');
        tds.prop('contenteditable', true);
    } else {
        $this.html('Edit');
        tds.prop('contenteditable', false);
        var $row = $(this).closest("tr"),       // Finds the closest row <tr>
            $tdd = $row.find("td");             // Finds all children <td> elements
        var array=[]
        $.each($tdd, function() {               // Visits every single <td> element
            array.push($(this).text())
        });
        $.ajax({
            type: "POST",
            url: "/updateUserBid/",
            data: {'array': array},
            async: true,
            dataType: 'json',
            enctype: 'multipart/form-data',
            cache: false,
            success: function (data) {
                console.log(data);
            },
            error: function (err) {
                console.log(err.responseText);
            }
        });
    }
});
function deleteID(row,BID){
    var answer = confirm ("Are you sure you want to delete from the database?");
    if (answer)
    {
        $.ajax({
            type: "POST",
            url: "/deleteBID/",
            data: {'id': BID},
            async: true,
            dataType: 'json',
            enctype: 'multipart/form-data',
            cache: false,
            success: function (data) {
                console.log(data.status);
                if(data.status==200) {
                    row.parentElement.parentElement.remove();
                    // document.getElementById("tableData").deleteRow(i);
                }
            },
            error: function (err) {
                console.log(err.responseText);
                if(err.responseText.status==200) {
                    var i = row.parentNode.parentNode.rowIndex;
                    document.getElementById("tableData").deleteRow(i);
                }
            }
        });
    }
}
//$.get( "/home_head_signups/", function( data ) {
//    var result = valData(data);
//    $("#signups").removeClass('loader');
//    $( "#signups" ).html( result );
//});
//$.get( "/home_head_collection/", function( data ) {
//    var data_new = JSON.parse(data);
//    $("#collection").removeClass('loader');
//    $( "#collection" ).html( data_new[0]['JB']+'/'+data_new[0]['FRANCHISEE']);
//});
//$.get( "/home_head_reviews/", function( data ) {
//    var result = valData(data);
//    $("#reviews").removeClass('loader');
//    $( "#reviews" ).html( result );
//});
//$.get( "/home_head_dd/", function( data ) {
//    var data_new = JSON.parse(data);
//    $("#dd").removeClass('loader');
//    $( "#dd" ).html( data_new[0]['CORPORATE_DD']+'/'+data_new[0]['BRANCHES_DD']);
//});
//$.get( "/home_head_ibtr/", function( data ) {
//    var result = valData(data);
//    $("#ibtr").removeClass('loader');
//    $( "#ibtr" ).html( result );
//});
//$.get( "/home_head_circulation/", function( data ) {
//    var data_new = JSON.parse(data);
//    $("#circulation").removeClass('loader');
//    $( "#circulation" ).html( data_new[0]['JB']+'/'+data_new[0]['FRANCHISEE']);
//});
//$.get( "/home_head_bookadded/", function( data ) {
//    var result = valData(data);
//    $("#added").removeClass('loader');
//    $( "#added" ).html( result );
//});
//$.get( "/home_head_wishlist/", function( data ) {
//    var result = valData(data);
//    $("#wishlist").removeClass('loader');
//    $( "#wishlist" ).html( result );
//});
//$.get( "/home_web_branch/", function( data ) {
//    var data_new = JSON.parse(data);
//    $("#web_branch").removeClass('loader');
//    $( "#web_branch" ).html( data_new[0]['WEB']+'/'+data_new[0]['BRANCHES']);
//});
//$.get( "/home_head_amount/", function( data ) {
//    var data_new = JSON.parse(data);
//    $("#collected").removeClass('loader');
//    $( "#collected" ).html( 'JB - '+data_new[0]['JB_AMOUNT']);
//    $( "#collected1" ).html( 'Branch - '+data_new[0]['BRANCH_AMOUNT']);
//});
//$.get( "/home_head_users/", function( data ) {
//    var result = valData(data);
//    $("#active_users").removeClass('loader');
//    $( "#active_users" ).html('45151/'+result);
//});
//$.get( "/home_head_renewals/", function( data ) {
//    var result = valData(data);
//    $("#renewals").removeClass('loader');
//    $( "#renewals" ).html(result);
//});
//$.get("/home_head_otrcount/", function(data){
//    var data_new = JSON.parse(data);
//    var total = valData(data_new[0]['TOTAL']);
//    var expiry = valData(data_new[0]['EXPIRY']);
//    $("#otrcount").removeClass('loader');
//    $( "#otrcount" ).html( total+'/'+expiry);
//});
//$.get("/home_head_otrvalue/", function(data){
//    var result = valData(data);
//    $("#otrvalue").removeClass('loader');
//    $( "#otrvalue" ).html( result);
//});
$.get("/branch_head_summary/", function (data) {
    //var result = valData(data);
    var data_new = JSON.parse(data);
    $("#web_branch").removeClass('loader');
    $("#web_branch").html(data_new['first']);
    // $("#signups").removeClass('loader');
    // $( "#signups" ).html( data_new[0]['SIGNUPS'] );
    //
    // $("#renewals").removeClass('loader');
    // $( "#renewals" ).html(data_new[0]['RENEWALS']);
    //
    // $("#active_users").removeClass('loader');
    // $( "#active_users" ).html('45151/'+data_new[0]['ACTIVE_USERS']);
    //
    // $("#otrcount").removeClass('loader');
    // $( "#otrcount" ).html( data_new[0]['OTR']+'/'+data_new[0]['OTR_EXPIRY']);
    //
    // $("#otrvalue").removeClass('loader');
    // $( "#otrvalue" ).html( data_new[0]['OTR_COLLECTION']);
    //
    $("#dd").removeClass('loader');
    $("#dd").html(data_new['second']);
    // $("#ibtr").removeClass('loader');
    // $( "#ibtr" ).html( data_new[0]['IBT'] );
    $("#circulation").removeClass('loader');
    $("#circulation").html(data_new['third'] + " %");
    $("#collection").removeClass('loader');
    $("#collection").html(data_new['fourth']);
    $("#added").removeClass('loader');
    $("#added").html(data_new['fifth']);
    // $("#collected").removeClass('loader');
    // $( "#collected" ).html( 'JB - '+data_new['first']['SHARE_JB']);
    // $( "#collected1" ).html( 'Branch - '+data_new['first']['SHARE_FRANCHISE']);
});
function drClick(val) {
    $.ajax({
        type: "POST",
        url: "/drAction/",
        data: {'dr': val},
        async: true,
        dataType: 'json',
        enctype: 'multipart/form-data',
        cache: false,
        success: function (data) {
            console.log(data);
            populateTable(data,val);
        },
        error: function (err) {
            console.log(err.responseText);
        }
    });
    // $("#one").css("background-color", "cadetblue");
    // $("#two").css("background-color", "#1ABB9C");
    // $("#three").css("background-color", "#1ABB9C");
}
$(document).ready(function () {
    var table = $("#dormancy_DR").DataTable({
        dom: 'lBfrtip',
        buttons: [
            'csv', 'excel'
        ]
    });
    $("#one").css("background-color", "cadetblue");
});
function populateTable(data,val) {
    var table = $("#dormancy_DR").DataTable();
    table.destroy();
    $("#dormancy_DR tbody").empty();
    data.forEach(function (dat) {
        $('#dormancy_DR tbody').append('<tr><td >' + dat['FIRST_NAME'] + '</td><td>' + dat['EXPIRY_DATE'] + '</td><td>' + dat['LOCALITY'] + '</td><td>' + dat['STATE'] + '</td><td>' + dat['CITY'] + '</td><td>' + dat['LPHONE'] + '</td><td>' + dat['MPHONE'] + '</td></tr>');
    });
    $("#dormancy_DR").DataTable({
        dom: 'lBfrtip',
        buttons: [
            'csv', 'excel'
        ]
    });
    if(val == -1){
        $("#one").css("background-color", "cadetblue");
        $("#two").css("background-color", "#1ABB9C");
        $("#three").css("background-color", "#1ABB9C");
        $("#tag").text("DR1 Data")
    }
    if(val == -2){
        $("#one").css("background-color", "#1ABB9C");
        $("#two").css("background-color", "cadetblue");
        $("#three").css("background-color", "#1ABB9C");
        $("#tag").text("DR2 Data")
    }
    if(val == -3){
        $("#one").css("background-color", "#1ABB9C");
        $("#two").css("background-color", "#1ABB9C");
        $("#three").css("background-color", "cadetblue");
        $("#tag").text("DR3 Data")
    }
}
