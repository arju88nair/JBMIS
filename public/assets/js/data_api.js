function valData(val){
    if(val == null || val == ''){
        return 0;
    }else{
        return val;
    }
}


// function sticky_relocate() {
//     var window_top = $(window).scrollTop();
//     var div_top = $('#sticky-anchor').offset().top;
//     if (window_top > div_top) {
//         $('#sticky').addClass('stick');
//         $('#sticky-anchor').height($('#sticky').outerHeight());
//     } else {
//         $('#sticky').removeClass('stick');
//         $('#sticky-anchor').height(0);
//     }
// }
//
// $(function() {
//     $(window).scroll(sticky_relocate);
//     sticky_relocate();
// });
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

$.get("/home_head_summary/", function(data){
    //var result = valData(data);
    var data_new = JSON.parse(data);
    console.log(data_new )

    $("#web_branch").removeClass('loader');
    $( "#web_branch" ).html( data_new[0]['PERCENTAGE_DIFF'] + ' %');

    $("#signups").removeClass('loader');
    $( "#signups" ).html( data_new[0]['COLL_MTD'] );

    $("#renewals").removeClass('loader');
    $( "#renewals" ).html(data_new[0]['SIGNUP_REVENUE']+ '('+ data_new[0]['SIGNUP_DIFF']+' %)');

    $("#active_users").removeClass('loader');
    $( "#active_users" ).html(data_new[0]['ACTIVE_USERS']);

    // $("#otrcount").removeClass('loader');
    // $( "#otrcount" ).html( data_new[0]['OTR']+'/'+data_new[0]['OTR_EXPIRY']);
    //
    $("#otrvalue").removeClass('loader');
    $( "#otrvalue" ).html( data_new[0]['OTR_ACHIVED']+' %');

    // $("#dd").removeClass('loader');
    // $( "#dd" ).html( data_new[0]['DD_CORPORATE']+'/'+data_new[0]['DD_BRANCH']);
    //
    $("#ibtr").removeClass('loader');
    $( "#ibtr" ).html( data_new[0]['SIGNUP_CNT']+ '('+ data_new[0]['SIGNUP_CNT_DIFF']+' %)' );

    $("#circulation").removeClass('loader');
    $( "#circulation" ).html( data_new[0]['RENEWAL_REVENUE']+ '('+ data_new[0]['RENEWAL_DIFF']+' %)' );

    $("#collection").removeClass('loader');
    $( "#collection" ).html( data_new[0]['RENEWAL_CNT']+ '('+ data_new[0]['RENEWAL_CNT_DIFF']+' %)' );

    // $("#added").removeClass('loader');
    // $( "#added" ).html( data_new[0]['BOOKS_ADDED'] );
    //
    $("#collected").removeClass('loader');
    $( "#collected" ).html( 'JB - '+data_new[0]['COLL_JB_MTD']);
    $( "#collected1" ).html( 'Branch - '+data_new[0]['COLL_FR_MTD']);
});
