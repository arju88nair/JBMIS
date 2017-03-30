function valData(val){
    if(val == null || val == ''){
        return 0;
    }else{
        return val;
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

$.get("/merchandise_head_summary/", function(data){
    //var result = valData(data);
    var data_new = JSON.parse(data);

    $("#web_branch").removeClass('loader');
    $( "#web_branch" ).html( data_new['second']+ " %");

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
    $( "#dd" ).html( data_new['third']+ " %");

    // $("#ibtr").removeClass('loader');
    // $( "#ibtr" ).html( data_new[0]['IBT'] );

    $("#circulation").removeClass('loader');
    $( "#circulation" ).html( data_new['first']['CIRCULATION_JB']+'/'+data_new['first']['CIRCULATION_FRANCHISEE']);

    $("#collection").removeClass('loader');
    $( "#collection" ).html( data_new['first']['COLLECTION_JB']+'/'+data_new['first']['COLLECTION_FRANCHISE']);

    $("#added").removeClass('loader');
    $( "#added" ).html( data_new['first']['BOOKS_ADDED'] );

    // $("#collected").removeClass('loader');
    // $( "#collected" ).html( 'JB - '+data_new['first']['SHARE_JB']);
    // $( "#collected1" ).html( 'Branch - '+data_new['first']['SHARE_FRANCHISE']);
});