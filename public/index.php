<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use mikehaertl\wkhtmlto\Pdf;


require '../vendor/autoload.php';
require '../includes/functions.php';

session_start();
$app = init();


$authenticate = function ($request, $response, $next) {
    if (!isset($_SESSION['user'])) {
        return $response->withRedirect('/login/');
    } else {
        return $next($request, $response);
    }
};

$app->get('/login/', function (Request $request, Response $response) {
    $response = $this->view->render($response, 'login.mustache');
    return $response;
});


$app->post('/login_validate_normal', function(Request $request, Response $response){
    $data = $request->getParsedBody();
    $username = $data['username'];
    $password = $data['password'];
    if($username == 'jb_mis' && $password == 'misadmin'){
        $_SESSION['user'] = $username;
        return $response->withRedirect('/home/');
    }else{

    }
});

$app->post('/login_validate', function (Request $request, Response $response) {
    $con = $this->db;
    $data = $request->getParsedBody();
    $username = $data['email'];
    $password = $data['id'];



    if ($username != "" && $password != "") {
        $_SESSION['user'] = $username;
//        $domain = substr(strrchr("amitkumar.ranganath@strata.co.in", "@"), 1);
//        $stripoped = explode(".", $domain);
        $query = "select branch_id from memp.branch_email_map where email='$username'";
        $result = oci_parse($con, $query);
        oci_execute($result);
        while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
            $data_ibt[] = $rows;
        }
        if(count($data_ibt) != 0 && !empty($data_ibt)){
            $_SESSION['branch_id'] = $data_ibt[0]['BRANCH_ID'];
            return $data_ibt[0]['BRANCH_ID'];
        }
        return "400";


    } else {
        return "400";

    }
});

$app->get('/home/', function (Request $request, Response $response) {


    $con = $this->db;
    function valData($val)
    {
        if (isset($val) || !empty($val))
            return $val;
        else
            return 0;
    }

    $date_array = array();
    $date_array['day1'] = date('d-m-Y');
    $date_array['day2'] = date('d-m-Y', strtotime(' -1 day'));
    $date_array['day3'] = date('d-m-Y', strtotime(' -2 day'));
    $date_array['day4'] = date('d-m-Y', strtotime(' -3 day'));
    $date_array['day5'] = date('d-m-Y', strtotime(' -4 day'));
    $date_array['day6'] = date('d-m-Y', strtotime(' -5 day'));
    $date_array['day7'] = date('d-m-Y', strtotime(' -6 day'));

    $query = "SELECT ib.state,
                count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id in (810,811)) then ib.id end) as day1_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id not in (810,811)) then ib.id end) as day1_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id in (810,811)) then ib.id end) as day2_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id not in (810,811)) then ib.id end) as day2_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id in (810,811)) then ib.id end) as day3_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id not in (810,811)) then ib.id end) as day3_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id in (810,811)) then ib.id end) as day4_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id not in (810,811)) then ib.id end) as day4_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id in (810,811)) then ib.id end) as day5_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id not in (810,811)) then ib.id end) as day5_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id in (810,811)) then ib.id end) as day6_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id not in (810,811)) then ib.id end) as day6_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id in (810,811)) then ib.id end) as day7_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id not in (810,811)) then ib.id end) as day7_branch
                FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
                WHERE mo.order_type= 'D' AND mo.flag_destination = 'S' group by ib.state";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $data_ibt[] = $rows;
    }

    $query = "SELECT ib.state,
                count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id in (810,811)) then ib.id end) as day1_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id not in (810,811)) then ib.id end) as day1_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id in (810,811)) then ib.id end) as day2_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id not in (810,811)) then ib.id end) as day2_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id in (810,811)) then ib.id end) as day3_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id not in (810,811)) then ib.id end) as day3_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id in (810,811)) then ib.id end) as day4_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id not in (810,811)) then ib.id end) as day4_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id in (810,811)) then ib.id end) as day5_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id not in (810,811)) then ib.id end) as day5_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id in (810,811)) then ib.id end) as day6_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id not in (810,811)) then ib.id end) as day6_branch,
                count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id in (810,811)) then ib.id end) as day7_web,
                count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id not in (810,811)) then ib.id end) as day7_branch
                FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
                WHERE mo.order_type= 'D' AND mo.flag_destination = 'D' group by ib.state";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $data_dd[] = $rows;
    }

    return $this->view->render($response, 'home.mustache', ["ibt_7days" => $data_ibt, "dd_7days" => $data_dd, "date_array" => $date_array]);
})->add($authenticate);

$app->get('/dd/', function (Request $request, Response $response) {
    return $this->view->render($response, 'dd_home.mustache');
})->add($authenticate);

//$app->get('/home_ibt_data/', function(Request $request, Response $response){
//    $con = $this->db;
//    $query = "select * from FN_Mis_Home_Ibt order by day7 desc";
//    $result = oci_parse($con, $query);
//    oci_execute($result);
//    while($rows = oci_fetch_array($result, OCI_ASSOC)){
//        $data[] = $rows;
//    }
//    echo json_encode($data);
//});

$app->get('/home_ibt_data/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "SELECT ib.state,'web' as loc,
                    count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id in (810,811)) then ib.id end) as day1,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id in (810,811)) then ib.id end) as day2,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id in (810,811)) then ib.id end) as day3,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id in (810,811)) then ib.id end) as day4,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id in (810,811)) then ib.id end) as day5,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id in (810,811)) then ib.id end) as day6,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id in (810,811)) then ib.id end) as day7
                    FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
                    WHERE mo.order_type= 'D' AND mo.flag_destination = 'S' group by ib.state
                    union
                    SELECT ib.state,'branch',
                    count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id not in (810,811)) then ib.id end) as day1,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id not in (810,811)) then ib.id end) as day2,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id not in (810,811)) then ib.id end) as day3,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id not in (810,811)) then ib.id end) as day4,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id not in (810,811)) then ib.id end) as day5,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id not in (810,811)) then ib.id end) as day6,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id not in (810,811)) then ib.id end) as day7
                    FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
                    WHERE mo.order_type= 'D' AND mo.flag_destination = 'S' group by ib.state";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $data[] = $rows;
    }
    echo json_encode($data);
});

$app->get('/home_head_signups/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select count(*) signups  from signups s join jb_branches jb on s.branch_id=jb.id where created_at>=trunc(sysdate, 'mm')
and branchtype not in ('C') and s.REVERSAL_REASON_ID is null";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $data_signups = $rows['SIGNUPS'];
    }
    echo $data_signups;
});

$app->get('/home_head_collection/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_colc = "select count(case when owner_id=952 then booknumber end) as jb,
            count(case when owner_id!=952 then booknumber end) as franchisee
            from FN_book_Master where status not in ('Missing','Removed','Sell off','Lost','Returned to Publisher')";
    $result_colc = oci_parse($con, $query_colc);
    oci_execute($result_colc);
    while ($row = oci_fetch_array($result_colc, OCI_ASSOC)) {
        $colc[] = $row;

    }
    echo json_encode($colc);
});

$app->get('/home_head_circulation/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_borrow = "select count(case when owner_id=952 then booknumber end) as jb,
                count(case when owner_id!=952 then booknumber end) as franchisee
                from FN_book_Master where status in ('In Circulation')";
    $result_borrow = oci_parse($con, $query_borrow);
    oci_execute($result_borrow);
    while ($row = oci_fetch_array($result_borrow, OCI_ASSOC)) {
        $circulation[] = $row;
    }
    echo json_encode($circulation);
});

$app->get('/home_head_bookadded/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_colc_added = "select count(*) col_added from jb_books where insertdate is not null and insertdate>=trunc(sysdate,'mm')";
    $result_colc_added = oci_parse($con, $query_colc_added);
    oci_execute($result_colc_added);
    while ($row = oci_fetch_array($result_colc_added, OCI_ASSOC)) {
        $colc_added = $row['COL_ADDED'];
    }
    echo $colc_added;
});

$app->get('/home_head_reviews/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_review = "select count(*) reviews from reviews where created_at>=trunc(sysdate,'mm') ";
    $result_review = oci_parse($con, $query_review);
    oci_execute($result_review);
    while ($row = oci_fetch_array($result_review, OCI_ASSOC)) {
        $reviews = $row['REVIEWS'];
    }
    echo $reviews;
});

$app->get('/home_head_wishlist/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_wl = "select count(*) wl from wish_list_items where created_at>=trunc(sysdate,'mm')";
    $result_wl = oci_parse($con, $query_wl);
    oci_execute($result_wl);
    while ($row = oci_fetch_array($result_wl, OCI_ASSOC)) {
        $wl = $row['WL'];
    }
    echo $wl;
});

$app->get('/home_head_dd/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_dd = "SELECT count(case when branchtype='C' then mo.id end) corporate_dd,
        count(case when branchtype!='C' then mo.id end) branches_dd
        FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
        join jb_branches jb on mo.branch_id=jb.id
        WHERE mo.order_type= 'D' AND mo.flag_destination = 'D'  and trunc(mo.updated_at)>=trunc(sysdate,'mm')";
    $result_dd = oci_parse($con, $query_dd);
    oci_execute($result_dd);
    while ($row = oci_fetch_array($result_dd, OCI_ASSOC)) {
        $dd[] = $row;
    }
    echo json_encode($dd);
});

$app->get('/home_head_ibtr/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_ibtr = "SELECT count(*) ibtr FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
              WHERE mo.order_type= 'D' AND mo.flag_destination = 'S'  and trunc(mo.updated_at)>=trunc(sysdate,'mm')";
    $result_ibtr = oci_parse($con, $query_ibtr);
    oci_execute($result_ibtr);
    while ($row = oci_fetch_array($result_ibtr, OCI_ASSOC)) {
        $ibtr = $row['IBTR'];
    }
    echo $ibtr;
});

$app->get('/home_head_users/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_users = "select count(distinct membership_no) as users from fn_active_users";
    $result_users = oci_parse($con, $query_users);
    oci_execute($result_users);
    while ($row = oci_fetch_array($result_users, OCI_ASSOC)) {
        $users = $row['USERS'];
    }
    echo $users;
});

$app->get('/home_head_renewals/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_renewals = "select count(*) users from renewals where trunc(created_at)>=trunc(sysdate,'mm') and reversal_reason_id is null";
    $result_renewals = oci_parse($con, $query_renewals);
    oci_execute($result_renewals);
    while ($row = oci_fetch_array($result_renewals, OCI_ASSOC)) {
        $renewals = $row['USERS'];
    }
    echo $renewals;
});

$app->get('/home_dd_data/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "SELECT ib.state,'web' as loc,
                    count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id in (810,811)) then ib.id end) as day1,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id in (810,811)) then ib.id end) as day2,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id in (810,811)) then ib.id end) as day3,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id in (810,811)) then ib.id end) as day4,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id in (810,811)) then ib.id end) as day5,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id in (810,811)) then ib.id end) as day6,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id in (810,811)) then ib.id end) as day7
                    FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
                    WHERE mo.order_type= 'D' AND mo.flag_destination = 'D' group by ib.state
                    union
                    SELECT ib.state,'branch',
                    count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id not in (810,811)) then ib.id end) as day1,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id not in (810,811)) then ib.id end) as day2,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id not in (810,811)) then ib.id end) as day3,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id not in (810,811)) then ib.id end) as day4,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id not in (810,811)) then ib.id end) as day5,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id not in (810,811)) then ib.id end) as day6,
                    count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id not in (810,811)) then ib.id end) as day7
                    FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
                    WHERE mo.order_type= 'D' AND mo.flag_destination = 'D' group by ib.state";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $data[] = $rows;
    }
    echo json_encode($data);
});

$app->get('/home_branch_amount/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_amount_collected = "select branchname,nvl(amount_collected,0) as final_amount from
                (select branchid,
                sum(case when type not in ('closure') then jb_amount+branch_amount end) as amount_collected,
                sum(case when type='closure' then jb_amount+branch_amount end) as closure_amount
                from FN_COLLECTION_SUMMARY where trunc(tdate)>=trunc(sysdate,'mm')
                group by branchid) a join jb_branches jb on a.branchid=jb.id
                order by final_amount desc";
    $result_amount_collected = oci_parse($con, $query_amount_collected);
    oci_execute($result_amount_collected);
    while ($rows = oci_fetch_array($result_amount_collected, OCI_ASSOC)) {
        $amount_collected[] = $rows;
    }
    echo json_encode($amount_collected);
});

$app->get('/home_datewise_amount/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_amount_collected_date = "select * from fn_vCollectionDateWise order by tdate";
    $result_amount_collected_date = oci_parse($con, $query_amount_collected_date);
    oci_execute($result_amount_collected_date);
    while ($rows = oci_fetch_array($result_amount_collected_date, OCI_ASSOC)) {
        $amount_collected_date[] = $rows;
    }
    echo json_encode($amount_collected_date);
});

$app->get('/home_web_branch/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_web_bran = "select round(web/(web+branches)*100,1) as web,round(branches/(web+branches)*100,1) as branches from
            (select count(case when location in (810,811) then location end) as web,
            count(case when location not in (810,811) then location end) as branches
            from jbprod.books where status='D') t";
    $result_web_bran = oci_parse($con, $query_web_bran);
    oci_execute($result_web_bran);
    while ($rows = oci_fetch_array($result_web_bran, OCI_ASSOC)) {
        $data_web_signups[] = $rows;
    }
    echo json_encode($data_web_signups);
});

$app->get('/home_head_amount/', function (Request $request, Response $response) {
    $con = $this->db;
    $query_ibtr = "select (jb_amount-closure) as jb_amount,branch_amount from
                (select sum(case when type!='closure' then jb_amount end) as jb_amount,sum(branch_amount) branch_amount,
                sum(case when type='closure' then jb_amount end) as closure
                from fn_collection_summary where tdate>=trunc(sysdate,'mm'))";
    $result_ibtr = oci_parse($con, $query_ibtr);
    oci_execute($result_ibtr);
    while ($row = oci_fetch_array($result_ibtr, OCI_ASSOC)) {
        $payment[] = $row;
    }
    echo json_encode($payment);
});

$app->get('/ageing/', function (Request $request, Response $response) {
    $con = $this->db;

    $date_array = array();
    $date_array['day1'] = date('d-m-Y');
    $date_array['day2'] = date('d-m-Y', strtotime(' -1 day'));
    $date_array['day3'] = date('d-m-Y', strtotime(' -2 day'));
    $date_array['day4'] = date('d-m-Y', strtotime(' -3 day'));
    $date_array['day5'] = date('d-m-Y', strtotime(' -4 day'));
    $date_array['day6'] = date('d-m-Y', strtotime(' -5 day'));
    $date_array['day7'] = date('d-m-Y', strtotime(' -6 day'));


//    $query = "SELECT ib.state,
//                count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id in (810,811)) then ib.id end) as day1_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id not in (810,811)) then ib.id end) as day1_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id in (810,811)) then ib.id end) as day2_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id not in (810,811)) then ib.id end) as day2_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id in (810,811)) then ib.id end) as day3_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id not in (810,811)) then ib.id end) as day3_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id in (810,811)) then ib.id end) as day4_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id not in (810,811)) then ib.id end) as day4_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id in (810,811)) then ib.id end) as day5_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id not in (810,811)) then ib.id end) as day5_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id in (810,811)) then ib.id end) as day6_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id not in (810,811)) then ib.id end) as day6_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id in (810,811)) then ib.id end) as day7_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id not in (810,811)) then ib.id end) as day7_branch
//                FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
//                WHERE mo.order_type= 'D' AND mo.flag_destination = 'D' group by ib.state";
//    $result = oci_parse($con, $query);
//    oci_execute($result);
//    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
//        $data_dd_old[] = $rows;
//    }
//
//
//    $query = "SELECT ib.state,
//                count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id in (810,811)) then ib.id end) as day1_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate) and mo.branch_id not in (810,811)) then ib.id end) as day1_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id in (810,811)) then ib.id end) as day2_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-1) and mo.branch_id not in (810,811)) then ib.id end) as day2_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id in (810,811)) then ib.id end) as day3_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-2) and mo.branch_id not in (810,811)) then ib.id end) as day3_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id in (810,811)) then ib.id end) as day4_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-3) and mo.branch_id not in (810,811)) then ib.id end) as day4_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id in (810,811)) then ib.id end) as day5_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-4) and mo.branch_id not in (810,811)) then ib.id end) as day5_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id in (810,811)) then ib.id end) as day6_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-5) and mo.branch_id not in (810,811)) then ib.id end) as day6_branch,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id in (810,811)) then ib.id end) as day7_web,
//                count(case when (trunc(mo.created_at)=trunc(sysdate-6) and mo.branch_id not in (810,811)) then ib.id end) as day7_branch
//                FROM opac.member_orders mo INNER JOIN opac.ibtrs ib ON ib.id = mo.ibtr_id
//                WHERE mo.order_type= 'D' AND mo.flag_destination = 'S' group by ib.state";
//    $result = oci_parse($con, $query);
//    oci_execute($result);
//    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
//        $data_ibt[] = $rows;
//    }

    $query = "select dt,order_recieved,assigned,completed,unassigned,order_recieved-completed from
                (select trunc(ib.created_at) dt,count(*) order_recieved,
                count(case when ib.state='Assigned' then ib.id end) as assigned,
                count(case when ib.state='Completed' then ib.id end) as completed,
                count(case when ib.state='New' then ib.id end) as unassigned
                 from opac.ibtrs ib join opac.member_orders mo on ib.id=mo.ibtr_id
                 join jb_branches jbb on jbb.id=ib.branch_id
                 WHERE mo.order_type= 'D' AND mo.flag_destination = 'S' and company_owned=1  and operational='Y'
                 and trunc(ib.created_at)>=trunc(sysdate)-7 group by trunc(ib.created_at))";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $ibt_co_owned[] = $rows;
    }

    $query = "select dt,order_recieved,assigned,completed,unassigned,order_recieved-completed from
        (select trunc(ib.created_at) dt,count(*) order_recieved,
        count(case when ib.state='Assigned' then ib.id end) as assigned,
        count(case when ib.state='Completed' then ib.id end) as completed,
        count(case when ib.state='New' then ib.id end) as unassigned
         from opac.ibtrs ib join opac.member_orders mo on ib.id=mo.ibtr_id
         join jb_branches jbb on jbb.id=ib.branch_id
         WHERE mo.order_type= 'D' AND mo.flag_destination = 'S' and company_owned!=1 and operational='Y' and is_virtual!=1
         and trunc(ib.created_at)>=trunc(sysdate)-7 group by trunc(ib.created_at))";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $ibt_fr_owned[] = $rows;
    }
    $query = "select dt,order_recieved,assigned,completed,unassigned,order_recieved-completed from
        (select trunc(ib.created_at) dt,count(*) order_recieved,
        count(case when ib.state='Assigned' then ib.id end) as assigned,
        count(case when ib.state='Completed' then ib.id end) as completed,
        count(case when ib.state='New' then ib.id end) as unassigned
         from opac.ibtrs ib join opac.member_orders mo on ib.id=mo.ibtr_id
         join jb_branches jbb on jbb.id=ib.branch_id
         WHERE mo.order_type= 'D' AND mo.flag_destination = 'S' and is_virtual=1 and operational='Y'
         and trunc(ib.created_at)>=trunc(sysdate)-7 group by trunc(ib.created_at))";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $ibtr_virtual[] = $rows;
    }

    $query = "select dt,order_recieved,assigned,completed,unassigned,order_recieved-completed from
                (select trunc(ib.created_at) dt,count(*) order_recieved,
                count(case when ib.state='Assigned' then ib.id end) as assigned,
                count(case when ib.state='Completed' then ib.id end) as completed,
                count(case when ib.state='New' then ib.id end) as unassigned
                 from opac.ibtrs ib join opac.member_orders mo on ib.id=mo.ibtr_id
                 join jb_branches jbb on jbb.id=ib.branch_id
                 WHERE mo.order_type= 'D' AND mo.flag_destination = 'D' and company_owned=1  and operational='Y'
                 and trunc(ib.created_at)>=trunc(sysdate)-7 group by trunc(ib.created_at))";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $dd_co_owned[] = $rows;
    }

    $query = "select dt,order_recieved,assigned,completed,unassigned,order_recieved-completed from
            (select trunc(ib.created_at) dt,count(*) order_recieved,
            count(case when ib.state='Assigned' then ib.id end) as assigned,
            count(case when ib.state='Completed' then ib.id end) as completed,
            count(case when ib.state='New' then ib.id end) as unassigned
             from opac.ibtrs ib join opac.member_orders mo on ib.id=mo.ibtr_id
             join jb_branches jbb on jbb.id=ib.branch_id
             WHERE mo.order_type= 'D' AND mo.flag_destination = 'D' and company_owned!=1 and operational='Y' and is_virtual!=1
             and trunc(ib.created_at)>=trunc(sysdate)-7 group by trunc(ib.created_at))";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $dd_fr_owned[] = $rows;
    }
    $query = "select dt,order_recieved,assigned,completed,unassigned,order_recieved-completed from
            (select trunc(ib.created_at) dt,count(*) order_recieved,
            count(case when ib.state='Assigned' then ib.id end) as assigned,
            count(case when ib.state='Completed' then ib.id end) as completed,
            count(case when ib.state='New' then ib.id end) as unassigned
             from opac.ibtrs ib join opac.member_orders mo on ib.id=mo.ibtr_id
             join jb_branches jbb on jbb.id=ib.branch_id
             WHERE mo.order_type= 'D' AND mo.flag_destination = 'D' and is_virtual=1 and operational='Y'
             and trunc(ib.created_at)>=trunc(sysdate)-7 group by trunc(ib.created_at))";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $dd_virtual[] = $rows;
    }


    function hoursToDays($val)
    {
        if ($val == null || $val == '') {
            return '';
        } elseif ($val < 24) {
            return $val . ' Hrs';
        } else {
            $val_day = round(floor($val / 24), 0);
            $val_hr = $val % 24;
            return $val_day . ' Days ' . $val_hr . ' Hrs';
        }
    }

    $query = "select branch_id,branchname,order_type,
                nvl(round(avg(new_assigned_diff),0),0) new_assigned_diff,
                nvl(round(avg(new_fulfilled_diff),0),0) new_fulfilled_diff,
                nvl(round(avg(new_dispatched_diff),0),0) new_dispatched_diff,
                nvl(round(avg(new_received_diff),0),0) new_received_diff,
                nvl(round(avg(new_intransit_diff),0),0) new_intransit_diff,
                nvl(round(avg(new_completed_diff),0),0)  new_completed_diff
                from FN_ageing fa join jb_branches jb on fa.branch_id=jb.id where order_type='DD'
                group by branch_id,branchname,order_type order by new_completed_diff desc";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $data_dd['BRANCHNAME'] = $rows['BRANCHNAME'];
        if (isset($rows['NEW_ASSIGNED_DIFF']))
            $data_dd['NEW_ASSIGNED_DIFF'] = hoursToDays($rows['NEW_ASSIGNED_DIFF']);
        if (isset($rows['NEW_FULFILLED_DIFF']))
            $data_dd['NEW_FULFILLED_DIFF'] = hoursToDays($rows['NEW_FULFILLED_DIFF']);
        if (isset($rows['NEW_DISPATCHED_DIFF']))
            $data_dd['NEW_DISPATCHED_DIFF'] = hoursToDays($rows['NEW_DISPATCHED_DIFF']);
        if (isset($rows['NEW_RECEIVED_DIFF']))
            $data_dd['NEW_RECEIVED_DIFF'] = hoursToDays($rows['NEW_RECEIVED_DIFF']);
        if (isset($rows['NEW_RECEIVED_DIFF']))
            $data_dd['NEW_INTRANSIT_DIFF'] = hoursToDays($rows['NEW_RECEIVED_DIFF']);
        if (isset($rows['NEW_COMPLETED_DIFF']))
            $data_dd['NEW_COMPLETED_DIFF'] = hoursToDays($rows['NEW_COMPLETED_DIFF']);
        $data_dd_new[] = $data_dd;
    }
    $query = "select branch_id,branchname,order_type,
                nvl(round(avg(new_assigned_diff),0),0) new_assigned_diff,
                nvl(round(avg(new_fulfilled_diff),0),0) new_fulfilled_diff,
                nvl(round(avg(new_dispatched_diff),0),0) new_dispatched_diff,
                nvl(round(avg(new_received_diff),0),0) new_received_diff,
                nvl(round(avg(new_intransit_diff),0),0) new_intransit_diff,
                nvl(round(avg(new_completed_diff),0),0)  new_completed_diff
                from FN_ageing fa join jb_branches jb on fa.branch_id=jb.id where order_type='IBTR'
                group by branch_id,branchname,order_type order by new_completed_diff desc";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($rows = oci_fetch_array($result, OCI_ASSOC)) {
        $data_ibtr['BRANCHNAME'] = $rows['BRANCHNAME'];
        if (isset($rows['NEW_ASSIGNED_DIFF']))
            $data_ibtr['NEW_ASSIGNED_DIFF'] = hoursToDays($rows['NEW_ASSIGNED_DIFF']);
        if (isset($rows['NEW_FULFILLED_DIFF']))
            $data_ibtr['NEW_FULFILLED_DIFF'] = hoursToDays($rows['NEW_FULFILLED_DIFF']);
        if (isset($rows['NEW_DISPATCHED_DIFF']))
            $data_ibtr['NEW_DISPATCHED_DIFF'] = hoursToDays($rows['NEW_DISPATCHED_DIFF']);
        if (isset($rows['NEW_RECEIVED_DIFF']))
            $data_ibtr['NEW_RECEIVED_DIFF'] = hoursToDays($rows['NEW_RECEIVED_DIFF']);
        if (isset($rows['NEW_RECEIVED_DIFF']))
            $data_ibtr['NEW_INTRANSIT_DIFF'] = hoursToDays($rows['NEW_RECEIVED_DIFF']);
        if (isset($rows['NEW_COMPLETED_DIFF']))
            $data_ibtr['NEW_COMPLETED_DIFF'] = hoursToDays($rows['NEW_COMPLETED_DIFF']);
        $data_ibtr_new[] = $data_ibtr;
    }
    return $this->view->render($response, 'ageing.mustache', ['ageing_dd' => $data_dd_new, 'ageing_ibtr' => $data_ibtr_new, "date_array" => $date_array, 'ibt_co_owned' => $ibt_co_owned, 'ibt_fr_owned' => $ibt_fr_owned, 'ibtr_virtual' => $ibtr_virtual, 'dd_co_owned' => $dd_co_owned, 'dd_fr_owned' => $dd_fr_owned, 'dd_virtual' => $dd_virtual]);
});

$app->get('/home_signups/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select trunc(created_at) dt,count(*) signups from signups where trunc(created_at)>=sysdate-30 group by trunc(created_at) order by trunc(created_at)";
    $result = oci_parse($con, $query);
    oci_execute($result);
    $year = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
    while ($row = oci_fetch_array($result)) {
        $data = '';
        $dt = '';
        $dt = explode('-', $row['DT']);
        $data[] = 'Date.UTC(20' . $dt[2] . ',' . array_search($dt[1], $year) . ',' . $dt[0] . ')';
        $data[] = $row['SIGNUPS'];
        $data_new[] = $data;
    }
    echo json_encode($data_new);
})->add($authenticate);

$app->get('/home_category/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select * from
        (select categoryname,count(*) rented from fn_book_master fbm join rentals r on fbm.booknumber=r.book_id
        where trunc(created_at)>=sysdate-30 group by categoryname order by rented desc) where rownum<=10 and categoryname is not null";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
});

$app->any('/collection/', function (Request $request, Response $response) {
    $con = $this->db;
    $data = $request->getParsedBody();
    $data_collection = [];
    if (isset($data['from']))
        $from = $data['from'];
    else
        $from = date('01-M-Y');
    if (isset($data['to']))
        $to = $data['to'];
    else
        $to = date('d-M-Y');

    $query = "select branchname,nvl(signups_cnt,0) signups_cnt,nvl(signups,0) signups,nvl(renewals_cnt,0) renewals_cnt,nvl(renewals,0) renewals,nvl(others,0) others,
                    nvl(total,0) mtd_total,nvl(jb_total,0) mtd_jb_total,nvl(branch_total,0) mtd_branch_total,
                    nvl(ytd_total,0) ytd_total,nvl(ytd_jb_total,0) ytd_jb_total,nvl(ytd_branch_total,0) ytd_branch_total,nvl(stc,0) stc from
                    (select branchid,ytd_total,ytd_jb_total,ytd_branch_total from
                    (select branchid,
                    sum(jb_amount)+sum(branch_amount) as ytd_total,
                    sum(jb_amount) as ytd_jb_total,
                    sum(branch_amount) as ytd_branch_total
                    from fn_collection_summary
                    where tdate between (select '01-Apr-'||case when to_number(to_char(sysdate, 'mm')) > 3 then to_number(to_char(sysdate, 'YYYY')) else
                    to_number(to_char(sysdate, 'YYYY'))-1 end as from_date from dual) and '$to'
                    group by branchid)) a
                    left join
                    (select branchid,nvl(signups,0) signups,nvl(renewals,0) renewals,nvl(others,0) others,
                    (nvl(jb_total,0)-nvl(branch_closure,0))+branch_total total,
                    nvl(jb_total,0)-nvl(branch_closure,0) jb_total,branch_total from
                    (select branchid,
                    sum(case when type='signups' then nvl(jb_amount,0)+nvl(branch_amount,0) end) as signups,
                    sum(case when type='renewals' then nvl(jb_amount,0)+nvl(branch_amount,0) end) as renewals,
                    sum(case when type not in ('signups','renewals','closure') then nvl(jb_amount,0)+nvl(branch_amount,0) end) as others,
                    sum(case when type='closure' then nvl(jb_amount,0) end) as branch_closure,
                    sum(nvl(jb_amount,0))+sum(nvl(branch_amount,0)) as total,
                    sum(case when type!='closure' then jb_amount end) as jb_total,
                    sum(branch_amount) as branch_total
                    from fn_collection_summary
                    where tdate between '$from' and '$to' group by branchid)) b
                    on a.branchid=b.branchid
                    left join
                    (select branchid,round(nvl(sum(books_circulation),0)/nvl(sum(members_count),0),1) as stc
                    from fn_circulation_members_details where trunc(tdate) between '$from' and '$to' group by branchid) c
                    on a.branchid=c.branchid
                    left join
                    (select branch_id,count(*) signups_cnt from signups where reversal_reason_id is null and trunc(created_at) between
                    '$from' and '$to' group by branch_id) d on a.branchid=d.branch_id
                    left join
                    (select branch_id,count(*) renewals_cnt from renewals where  reversal_reason_id is null and trunc(created_at) between
                    '$from' and '$to' group by branch_id ) e on a.branchid=e.branch_id
                    join jb_branches jb on a.branchid=jb.id order by signups_cnt desc";
    $result = oci_parse($con, $query);
    oci_execute($result);
    $signups = $renewal = $others = $mtd_total = $mtd_jb = $mtd_br = $ytd_total = $ytd_jb = $ytd_br = $signups_total = $renewals_total = 0;
    while ($row = oci_fetch_assoc($result)) {
        $data_collection[] = $row;
        $signups = $signups + $row['SIGNUPS'];
        $renewal = $renewal + $row['RENEWALS'];
        $others = $others + $row['OTHERS'];
        $mtd_total = $mtd_total + $row['MTD_TOTAL'];
        $mtd_jb = $mtd_jb + $row['MTD_JB_TOTAL'];
        $mtd_br = $mtd_br + $row['MTD_BRANCH_TOTAL'];
        $ytd_total = $ytd_total + $row['YTD_TOTAL'];
        $ytd_jb = $ytd_jb + $row['YTD_JB_TOTAL'];
        $ytd_br = $ytd_br + $row['YTD_BRANCH_TOTAL'];
        $signups_total = $signups_total + $row['SIGNUPS_CNT'];
        $renewals_total = $renewals_total + $row['RENEWALS_CNT'];
    }
    return $this->view->render($response, 'collection.mustache', ['collection' => $data_collection, 'jb_sign' => $signups,
        'jb_renewal' => $renewal, 'others' => $others, 'mtd_total' => $mtd_total, 'mtd_jb' => $mtd_jb, 'mtd_br' => $mtd_br, 'ytd_total' => $ytd_total,
        'ytd_jb' => $ytd_jb, 'ytd_br' => $ytd_br, 'date_show' => 1, 'from' => $from, 'to' => $to, 'signups' => $signups_total, 'renewals' => $renewals_total]);
})->add($authenticate);

$app->get('/home_datewise_signups/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select * from fn_vSignupsDateWise order by tdate";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $data_final[] = $row;
    }
    echo json_encode($data_final);
});

$app->get('/home_datewise_renewals/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select * from fn_vRenewalsDateWise order by tdate";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $data_final[] = $row;
    }
    echo json_encode($data_final);
});

$app->get('/home_head_otrcount/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select sum(total_renewal) total,sum(expiring_member_count) expiry from otrs where track_month_date=trunc(sysdate,'mm')";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $data_final[] = $row;
    }
    echo json_encode($data_final);

});

$app->get('/home_head_otrvalue/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select sum(renewal_value)+sum(change_plan_value) as total_val from otrs where track_month_date=trunc(sysdate,'mm')";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $data_final = $row['TOTAL_VAL'];
    }
    echo $data_final;

});

$app->get('/logout/', function (Request $request, Response $response) {
    unset($_SESSION['user']);
    return $response->withRedirect('/login/');
});

$app->get('/otr/', function (Request $request, Response $response) {
    $con = $this->db;
    $from = date('01-M-Y');
    $to = date('d-M-Y');
    $query = "select branchname,
                sum(case when type='signups' then jb_amount end) as jb_signups,
                sum(case when type='signups' then branch_amount end) as branch_signups,
                sum(case when type='renewals' then jb_amount end) as jb_renewals,
                sum(case when type='renewals' then branch_amount end) as branch_renewals,
                sum(case when type='retention' then jb_amount end) as jb_retention,
                sum(case when type='retention' then branch_amount end) as branch_retention,
                sum(case when type='reopenings' then jb_amount end) as jb_reopenings,
                sum(case when type='reopenings' then branch_amount end) as branch_reopenings,
                sum(case when type='additional_cards' then jb_amount end) as jb_additional_cards,
                sum(case when type='additional_cards' then branch_amount end) as branch_additional_cards,
                sum(case when type='book_penalties' then jb_amount end) as jb_book_penalties,
                sum(case when type='book_penalties' then branch_amount end) as branch_book_penalties,
                sum(case when type='settled_dues' then jb_amount end) as jb_settled_dues,
                sum(case when type='settled_dues' then branch_amount end) as branch_settled_dues,
                sum(case when type='delivery_fees' then jb_amount end) as jb_delivery_fees,
                sum(case when type='delivery_fees' then branch_amount end) as branch_delivery_fees,
                sum(case when type='lostcards' then jb_amount end) as jb_lostcards,
                sum(case when type='lostcards' then branch_amount end) as branch_lostcards,
                sum(case when type='change_plans' then jb_amount end) as jb_change_plans,
                sum(case when type='change_plans' then branch_amount end) as branch_change_plans,
                sum(case when type='closure' then jb_amount end) as jb_closure,
                sum(case when type='closure' then branch_amount end) as branch_closure
                from fn_collection_summary fcs join jb_branches jb on fcs.branchid=jb.id
                where tdate between '$from' and '$to' group by branchname order by branchname";
    $result = oci_parse($con, $query);
    oci_execute($result);
    $jb_signups = $jb_renewal = $jb_rentention = $jb_reopen = $jb_ac = $jb_bp = $jb_sd = $jb_df = $jb_lc = $jb_cp = $jb_cl = $jb_total = 0;
    $b_signups = $b_renewal = $b_rentention = $b_reopen = $b_ac = $b_bp = $b_sd = $b_df = $b_lc = $b_cp = $b_cl = $b_total = 0;
    while ($row = oci_fetch_assoc($result)) {
        $data_collection[] = $row;
        $jb_signups = $jb_signups + $row['JB_SIGNUPS'];
        $jb_renewal = $jb_renewal + $row['JB_RENEWALS'];
        $jb_rentention = $jb_rentention + $row['JB_RETENTION'];
        $jb_reopen = $jb_reopen + $row['JB_REOPENINGS'];
        $jb_ac = $jb_ac + $row['JB_ADDITIONAL_CARDS'];
        $jb_bp = $jb_bp + $row['JB_BOOK_PENALTIES'];
        $jb_sd = $jb_sd + $row['JB_SETTLED_DUES'];
        $jb_df = $jb_df + $row['JB_DELIVERY_FEES'];
        $jb_lc = $jb_lc + $row['JB_LOSTCARDS'];
        $jb_cp = $jb_cp + $row['JB_CHANGE_PLANS'];
        $jb_cl = $jb_cl + $row['JB_CLOSURE'];
        $b_signups = $b_signups + $row['BRANCH_SIGNUPS'];
        $b_renewal = $b_renewal + $row['BRANCH_RENEWALS'];
        $b_rentention = $b_rentention + $row['BRANCH_RETENTION'];
        $b_reopen = $b_reopen + $row['BRANCH_REOPENINGS'];
        $b_ac = $b_ac + $row['BRANCH_ADDITIONAL_CARDS'];
        $b_bp = $b_bp + $row['BRANCH_BOOK_PENALTIES'];
        $b_sd = $b_sd + $row['BRANCH_SETTLED_DUES'];
        $b_df = $b_df + $row['BRANCH_DELIVERY_FEES'];
        $b_lc = $b_lc + $row['BRANCH_LOSTCARDS'];
        $b_cp = $b_cp + $row['BRANCH_CHANGE_PLANS'];
        $b_cl = $b_cl + $row['BRANCH_CLOSURE'];
    }
    $jb_total = ($jb_signups + $jb_renewal + $jb_rentention + $jb_reopen + $jb_ac + $jb_bp + $jb_sd + $jb_df + $jb_lc + $jb_cp) - $jb_cl;
    $b_total = ($b_signups + $b_renewal + $b_rentention + $b_reopen + $b_ac + $b_bp + $b_sd + $b_df + $b_lc + $b_cp) - $b_cl;
//    echo json_encode($data);DIE;
    return $this->view->render($response, 'collection.mustache', ['collection' => $data_collection, 'jb_sign' => $jb_signups,
        'jb_renewal' => $jb_renewal, 'jb_rentention' => $jb_rentention, 'jb_reopen' => $jb_reopen, 'jb_ac' => $jb_ac, 'jb_bp' => $jb_bp,
        'jb_sd' => $jb_sd, 'jb_df' => $jb_df, 'jb_lc' => $jb_lc, 'jb_cp' => $jb_cp, 'jb_cl' => $jb_cl, 'jb_total' => $jb_total, 'b_sign' => $b_signups,
        'b_renewal' => $b_renewal, 'b_rentention' => $b_rentention, 'b_reopen' => $b_reopen, 'b_ac' => $b_ac, 'b_bp' => $b_bp,
        'b_sd' => $b_sd, 'b_df' => $b_df, 'b_lc' => $b_lc, 'b_cp' => $b_cp, 'b_cl' => $b_cl, 'b_total' => $b_total]);
})->add($authenticate);

$app->get('/home_head_summary/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select Coll_MTD,coll_jb_mtd,coll_fr_mtd,fn_find_percentage(Coll_MTD,coll_ly) as percentage_diff,
            signup_revenue,fn_find_percentage(signup_revenue,signup_revenue_ly) as signup_diff,
            signup_cnt,fn_find_percentage(signup_cnt,signup_cnt_ly) as signup_cnt_diff,
            renewal_revenue,fn_find_percentage(renewal_revenue,renewal_revenue_ly) as renewal_diff,renewal_cnt,
            fn_find_percentage(renewal_cnt,renewal_cnt_ly) as renewal_cnt_diff,otr_achived,active_users
            from
            (select 
            round(nvl(sum(SHARE_JB),0)+nvl(sum(SHARE_FRANCHISE),0),0) Coll_MTD,
            round(nvl(sum(SHARE_JB),0),0) coll_jb_mtd,
            round(nvl(sum(SHARE_FRANCHISE),0),0) coll_fr_mtd,
            round(nvl(sum(collection_ly),0)) coll_ly,
            round(nvl(sum(signup_revenue),0)) signup_revenue,
            round(nvl(sum(signup_revenue_ly),0)) signup_revenue_ly,
            round(nvl(sum(signups),0)) signup_cnt,
            round(nvl(sum(signup_ly),0)) signup_cnt_ly,
            round(nvl(sum(renewals_revenue),0)) renewal_revenue,
            round(nvl(sum(renewal_revenue_ly),0)) renewal_revenue_ly,
            round(nvl(sum(renewals),0)) renewal_cnt,
            round(nvl(sum(renewal_ly),0)) renewal_cnt_ly,
            round(nvl(sum(otr)/sum(otr_expiry)*100,0)) otr_achived,
            nvl(sum(active_users),0) active_users
            from fn_home_page_summary where trunc(tdate)>=trunc(sysdate,'mm'))";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $data_final[] = $row;
    }
    echo json_encode($data_final);

});


$app->get('/merchandise/', function (Request $request, Response $response) {
    $response = $this->view->render($response, 'merchandise_analysis.mustache');
    return $response;
});


$app->get('/merchandise_head_summary/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select sum(web_perfomance) web_perfomance,sum(branch_perfomance) branch_perfomance,sum(signups) signups,sum(renewals) renewals,
        sum(active_users) active_users,sum(otr) otr,sum(otr_collection) otr_collection,sum(DD_CORPORATE) DD_CORPORATE,
        sum(DD_BRANCH) DD_BRANCH,sum(IBT) IBT,sum(CIRCULATION_JB) CIRCULATION_JB,sum(CIRCULATION_FRANCHISEE) CIRCULATION_FRANCHISEE,
        sum(COLLECTION_JB) COLLECTION_JB,sum(COLLECTION_FRANCHISE) COLLECTION_FRANCHISE,sum(BOOKS_ADDED) BOOKS_ADDED,
        sum(SHARE_JB) SHARE_JB,sum(SHARE_FRANCHISE) SHARE_FRANCHISE,sum(OTR_EXPIRY) OTR_EXPIRY from fn_home_page_summary
        where trunc(tdate)>=trunc(sysdate,'mm')";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $data_final['first'] = $row;
    }


    $second_query = "select count(case when status in ('A','P','D','T','O','W') then titleid end) as cnt,
	count(case when status='D' then titleid end) as circulation from jb_books";
    $result = oci_parse($con, $second_query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp[] = $row;
    }

    $circ = $temp[0]['CIRCULATION'];

    $count = $temp[0]['CNT'];

    $percentage = round((($circ / $count) * 100), 1);

    $data_final['second'] = $percentage;


    $third_query = "select count(case when jbk.status in ('A','P','D','T','O','W') then titleid end) as cnt,
	count(case when jbk.status='D' then titleid end) as circulation 
	from jb_books jbk join jb_branches jbb on jbk.origlocation=jbb.id 
	where active_status=1 and (company_owned!=1 or company_owned is null)";
    $result = oci_parse($con, $third_query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp2[] = $row;
    }

    $circ2 = $temp2[0]['CIRCULATION'];
    $count2 = $temp2[0]['CNT'];
    $percentage2 = round((($circ2 / $count2) * 100), 1);
    $data_final['third'] = $percentage2;

    echo json_encode($data_final);

});

$app->get('/avg_circ_mtd_data/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select to_char(tdate,'dd') tdate,avg_circulation from fn_home_page_summary where tdate>=trunc(sysdate,'mm') order by tdate
";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $data_final[] = $row;
    }

    echo json_encode($data_final);


});

$app->get('/otrview/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select branch_id,branchname,expiring_member_count,total_renewal,renewal_value,total_renewal-expiring_member_count pending 
from otrs o join jb_branches jb on o.branch_id=jb.ID 

where track_month_date=trunc(sysdate,'mm')


";
    $result = oci_parse($con, $query);
    oci_execute($result);
    $totalExpiry = 0;
    $totalRenewal = 0;
    $totalRevenue = 0;
    while ($row = oci_fetch_assoc($result)) {
        $totalExpiry = $totalExpiry + $row['EXPIRING_MEMBER_COUNT'];
        $totalRenewal = $totalRenewal + $row['TOTAL_RENEWAL'];
        $totalRevenue = $totalRevenue + $row['RENEWAL_VALUE'];
        $data_final[] = $row;
    }
    $totalPending = $totalExpiry - $totalRenewal;


    $response = $this->view->render($response, 'otr.mustache', ['otrData' => $data_final, 'totalExpiry' => $totalExpiry, 'totalRenewal' => $totalRenewal, 'totalRevenue' => $totalRevenue, 'totalPending' => $totalPending]);
    return $response;
});


$app->get('/branch/', function (Request $request, Response $response) {
    $response = $this->view->render($response, 'branchView.mustache');
    return $response;
});


$app->get('/branch_head_summary/', function (Request $request, Response $response) {
    $id=$_SESSION['branch_id'];

    $con = $this->db;
    $query = "select branch_id,
    count(case when trunc(created_at)>=add_months(trunc(sysdate,'mm'),-12) 
    and trunc(created_at)<=add_months(trunc(sysdate),-12) then branch_id end) as last_year_month,
    count(case when trunc(created_at)>=trunc(sysdate,'mm') then branch_id end) as current_month
    from signups where branch_id=$id
    group by branch_id";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp[] = $row;
    }
    $data_final['first'] = $temp[0]['CURRENT_MONTH'] . '/' . $temp[0]['LAST_YEAR_MONTH'];


    $query = "select branch_id,
count(case when trunc(created_at)>=add_months(trunc(sysdate,'mm'),-12) 
and trunc(created_at)<=add_months(trunc(sysdate),-12) then branch_id end) as last_year_month,
count(case when trunc(created_at)>=trunc(sysdate,'mm') then branch_id end) as current_month
from renewals where branch_id =$id
group by branch_id";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp1[] = $row;
    }
    $data_final['second'] = $temp1[0]['CURRENT_MONTH'] . '/' . $temp1[0]['LAST_YEAR_MONTH'];


    $query = "select a.branch_id,nvl(users,0) users,nvl(a_users,0) a_users from
(select branch_id,count(distinct membership_no)  users from member_plans  
   where expiry_date>trunc(sysdate) group by branch_id) a
left join
(select branch_id,count(distinct membership_no) a_users from returns where branch_id=1 and issue_date>=trunc(sysdate,'mm') group by branch_id) b
on a.branch_id=b.branch_id where a.branch_id =$id";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp2[] = $row;
    }
    $percentage = round(($temp2[0]['A_USERS'] / $temp2[0]['USERS']) * 100);
    $percentage = abs($percentage - 100);

    $data_final['third'] = $percentage;


    $query = "select r.branch_id,round(avg(mp.bulk_payment),1) bulk_payment from renewals r join member_plans mp on r.member_plan_id=mp.id where
        trunc(r.created_at)>=add_months(trunc(sysdate,'mm'),-6) and   r.branch_id=$id  group by  r.branch_id";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp3[] = $row;
    }
    $data_final['fourth'] = $temp3[0]['BULK_PAYMENT'];

    $query = "select branch_id,round(avg(signup_months),1) signup_months from signups where trunc(created_at)>=add_months(trunc(sysdate,'mm'),-6) and 
 branch_id=$id
group by branch_id";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp4[] = $row;
    }
    $data_final['fifth'] = $temp4[0]['SIGNUP_MONTHS'];


    echo json_encode($data_final);

});


$app->get('/configure/', function (Request $request, Response $response) {
    $con = $this->db;
    $query = "select id,branchname from JB_BRANCHES where operational = 'Y' order by id"  ;
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp[] = $row;
    }
    $query = "select id,email,branch_id,role from memp.branch_email_map ";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $final[] = $row;
    }


    $response = $this->view->render($response, 'configure.mustache', ['branches' => $temp,'data'=>$final]);
    return $response;
});


$app->post('/updated_configure/', function (Request $request, Response $response) {
    $con = $this->db;
    $data = $request->getParsedBody();
    $email = $data['email'];
    $select = $_POST['select'];
    $query = "select email,branch_id from memp.branch_email_map where email='$email'";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $validateArray[] = $row;
    }
    if ($validateArray == [] || empty($validateArray)) {
        $query = "insert into memp.branch_email_map (email,branch_id)  values ('$email','$select')";
        $compiled = oci_parse($con, $query);
        oci_execute($compiled);
        $query = "select id,branchname from JB_BRANCHES";
        $result = oci_parse($con, $query);
        oci_execute($result);
        while ($row = oci_fetch_assoc($result)) {
            $temp[] = $row;
        }

        $query = "select id,email,branch_id,role from memp.branch_email_map ";
        $result = oci_parse($con, $query);
        oci_execute($result);
        while ($row = oci_fetch_assoc($result)) {
            $final[] = $row;
        }


        $response = $this->view->render($response, 'configure.mustache', ['branches' => $temp,'data'=>$final]);
        return $response->withRedirect('/configure/');
    }

    $updateQuery = "update memp.branch_email_map set branch_id='$select' where email='$email' ";
    $compiled = oci_parse($con, $updateQuery);
    oci_execute($compiled);
    $query = "select id,branchname from JB_BRANCHES";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp[] = $row;
    }
    $query = "select id,email,branch_id,role from memp.branch_email_map ";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $final[] = $row;
    }


    $response = $this->view->render($response, 'configure.mustache', ['branches' => $temp,'data'=>$final]);
    return $response->withRedirect('/configure/');


});

$app->get('/branch_chart/', function (Request $request, Response $response) {
    $id=$_SESSION['branch_id'];
    $con = $this->db;
    $query = "select * from fn_signups_year_compare_branch where branch_id=$id order by dt";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp[] = $row;
    }

    return  json_encode($temp);

//
});

$app->get('/fn_renew_year_compare_branch/', function (Request $request, Response $response) {
    $id=$_SESSION['branch_id'];
    $con = $this->db;
    $query = "select * from fn_renew_year_compare_branch where branch_id=$id order by dt";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp[] = $row;
    }

    return  json_encode($temp);
//
});
$app->get('/fn_colc_year_compare_branch/', function (Request $request, Response $response) {
    $id=$_SESSION['branch_id'];
    $con = $this->db;
    $query = "select * from fn_colc_year_compare_branch where branchid=$id order by dt
";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp[] = $row;
    }

    return  json_encode($temp);
//
});



$app->get('/dormancy/', function (Request $request, Response $response) {
    $id=$_SESSION['branch_id'];
    $con = $this->db;
    $query = "select * from fn_dormancy_branch where branch_id=$id";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $temp[] = $row;
    }
    $dr1=$temp[0]['CNT'];
    $dr2=$temp[1]['CNT'];
    $dr3=$temp[2]['CNT'];

    $queryDR="select mp.first_name,dr1.expiry_date,nvl(mp.locality,'N/A') locality,nvl(mp.state,'N/A') state, nvl(mp.city,'N/A') city ,nvl(mp.lphone,'N/A') lphone,nvl(mp.mphone,'N/A') mphone from 
                member_plans mp join dr1_members dr1 on mp.id=dr1.member_plan_id
                where dr1.status is null and dr1.expiry_date between add_months(trunc(sysdate,'mm'),-1) 
                and last_day(add_months(trunc(sysdate,'mm'),-1))and dr1.branch_id=$id";
    $result = oci_parse($con, $queryDR);
    oci_execute($result);
    while ($row = oci_fetch_assoc($result)) {
        $data[] = $row;
    }

    $response = $this->view->render($response, 'dormancy.mustache',['dr1'=>$dr1,'dr2'=>$dr2,'dr3'=>$dr3,'data'=>$data]);
    return $response;
});

$app->post('/drAction/', function (Request $request, Response $response) {
    $id=$_SESSION['branch_id'];
    $con = $this->db;
    $data = $request->getParsedBody();
    $dr =(int) $data['dr'];
    $queryDR="select mp.first_name,dr1.expiry_date,nvl(mp.locality,'N/A') locality,nvl(mp.state,'N/A') state, nvl(mp.city,'N/A') city ,nvl(mp.lphone,'N/A') lphone,nvl(mp.mphone,'N/A') mphone from 
                member_plans mp join dr1_members dr1 on mp.id=dr1.member_plan_id
                where dr1.status is null and dr1.expiry_date between add_months(trunc(sysdate,'mm'),$dr) 
                and last_day(add_months(trunc(sysdate,'mm'),$dr))and dr1.branch_id=$id";
    $result = oci_parse($con, $queryDR);
    oci_execute($result);
    while ($row = oci_fetch_array($result)) {
        $data[] = $row;
    }


    $final=[];
    foreach ($data as $dat){
        array_push($final ,$dat);
    }
    return json_encode($final);


});

$app->any('/closureBranch/', function (Request $request, Response $response) {
    $id=$_SESSION['branch_id'];
    $con = $this->db;
    $data = $request->getParsedBody();
    $data_collection = [];
    if (isset($data['from']))
        $from = $data['from'];
    else
        $from = date('01-M-Y');
    if (isset($data['to']))
        $to = $data['to'];
    else
        $to = date('d-M-Y');
    $query="select c.membership_no,mp.first_name,nvl(mp.locality,'N/A') locality,nvl(state,'N/A') state,nvl(city,'N/A') city,nvl(lphone,'N/A') lphone,nvl(mphone,'N/A') mphone,trunc(c.created_at) closed,description
            from closures c join member_plans mp on c.member_id=mp.id join closurereasons cr on c.closure_reason_id=cr.id
            where c.branch_id=$id and trunc(c.created_at) between '$from' and '$to' ";
    $result = oci_parse($con, $query);
    oci_execute($result);
    $count=0;
    while ($row = oci_fetch_array($result)) {
        $count++;
        $data[] = $row;
    }

    $response = $this->view->render($response, 'closure.mustache',['data'=>$data,'count'=>$count,'from'=>$from,'to'=>$to]);
    return $response;
});


$app->any('/invoiceView/', function (Request $request, Response $response) {
    $con = $this->db;
    $data = $request->getParsedBody();
    if (isset($data['from']))
        $from = $data['from'];
    else
        $from = date('01-M-Y');
    if (isset($data['to']))
        $to = $data['to'];
    else
        $to = date('d-M-Y');

    $query="select bid,branchname,branchaddress,case when company_owned=1 then 'company Owned' else 'Franchise Owned' end as owned_by,
case when is_virtual=1 then 'Virtual' else 'Physical' end as branch_type,contactnumbers,hire_charges_collected,cc_charges,edc_charges,security_refund,
                        nvl(ibt_receivable,0) ibt_receivable,nvl(ibt_payable,0) ibt_payable,registration_fee,security_deposit,retention,card_fee,book_penalty,hire_charges,misc_income,misc_cost
                        from
                        (select branch_id bid,sum(reading_fee_share) as hire_charges_collected,
                        sum(web_cc_charges) as cc_charges,
                        sum(edc_charges) as edc_charges
                        from fn_invoice_summary where  invoiced=1 and tdate between '$from' and '$to' group by branch_id) a
                        join
                        (select branch_id,nvl(sum(security_refund),0) security_refund,
                        nvl(sum(registration_fee),0) registration_fee,nvl(sum(security_deposit),0) security_deposit,nvl(sum(retention),0) retention,
                        nvl(sum(card_fee),0) card_fee,nvl(sum(book_penalty),0) book_penalty,nvl(sum(hire_charges),0) hire_charges,
                        nvl(sum(misc_income),0) misc_income,nvl(sum(misc_cost),0) misc_cost
                        from fn_invoice_params where  tdate between '$from' and '$to' group by branch_id) b
                        on a.bid=b.branch_id join jb_branches jbb on a.bid=jbb.id
                        left join
                        (select txnbranch,round(nvl(sum(amount),0)-nvl(sum(commission_amount),0)) ibt_payable 
                        from ibtxns where txnbranch != accountbranch  and settlement_type = 1 and trunc(txndate)>='$from' 
                        and trunc(txndate)<='$to' group by txnbranch) c
                        on a.bid=c.txnbranch
                        left join
                        (select accountbranch,round(nvl(sum(amount),0)-nvl(sum(commission_amount),0)) ibt_receivable 
                        from ibtxns where txnbranch != accountbranch and settlement_type = 1 and trunc(txndate)>='$from' 
                        and trunc(txndate)<='$to' group by accountbranch) d
                        on a.bid=d.accountbranch";
    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_array($result)) {
        $final[] = $row;
    }


    $response = $this->view->render($response, 'invoice.mustache',['data'=>$final,'from'=>$from,'to'=>$to]);
    return $response;
});


$app->get('/pdfGenerate', function (Request $request, Response $response) {
    $con = $this->db;
    $allGetVars = $request->getQueryParams();

    $id=$allGetVars['get'];
    $from=$allGetVars['from'];
    $to=$allGetVars['to'];
    $date = date('01-M-Y');



    $query="select bid,branchname,branchaddress,contactnumbers,hire_charges_collected,cc_charges,edc_charges,security_refund,
                ibt_receivable,ibt_payable,registration_fee,security_deposit,retention,card_fee,book_penalty,hire_charges,misc_income,misc_cost
                from
                (select branch_id bid,sum(reading_fee_share) as hire_charges_collected,
                sum(web_cc_charges) as cc_charges,
                sum(edc_charges) as edc_charges
                from fn_invoice_summary where  invoiced=1 and branch_id=$id and tdate between '$from' and '$to' group by branch_id) a
                join
                (select branch_id,nvl(sum(security_refund),0) security_refund,
                nvl(sum(registration_fee),0) registration_fee,nvl(sum(security_deposit),0) security_deposit,nvl(sum(retention),0) retention,
                nvl(sum(card_fee),0) card_fee,nvl(sum(book_penalty),0) book_penalty,nvl(sum(hire_charges),0) hire_charges,
                nvl(sum(misc_income),0) misc_income,nvl(sum(misc_cost),0) misc_cost
                from fn_invoice_params where branch_id=$id and tdate between '$from' and '$to' group by branch_id) b
                on a.bid=b.branch_id join jb_branches jbb on a.bid=jbb.id
                left join
                (select txnbranch,round(nvl(sum(amount),0)-nvl(sum(commission_amount),0)) ibt_payable
                from ibtxns where txnbranch=1 and accountbranch!=1  and settlement_type = 1 and trunc(txndate)>='$from'
                and trunc(txndate)<='$to' group by txnbranch) c
                on a.bid=c.txnbranch
                left join
                (select accountbranch,round(nvl(sum(amount),0)-nvl(sum(commission_amount),0)) ibt_receivable
                from ibtxns where txnbranch!=1 and accountbranch=1 and settlement_type = 1 and trunc(txndate)>='$from'
                and trunc(txndate)<='$to' group by accountbranch) d
                on a.bid=d.accountbranch";

    $result = oci_parse($con, $query);
    oci_execute($result);
    while ($row = oci_fetch_array($result)) {
        $final[] = $row;
    }
    $hire_collected=$final[0]['HIRE_CHARGES_COLLECTED'];
    $reg_fee=$final[0]['REGISTRATION_FEE'];
    $sec_deposit=$final[0]['SECURITY_DEPOSIT'];
    $lost_book_=$final[0]['BOOK_PENALTY'];
    $lost_card=$final[0]['CARD_FEE'];
    $retention=$final[0]['RETENTION'];
    $misc_income=$final[0]['MISC_INCOME'];
    $cc=$final[0]['CC_CHARGES'];
    $door_del=0;
    $misc_cost=$final[0]['MISC_COST'];
    $ibt_pay=$final[0]['IBT_PAYABLE'];
    $mag_fee=0;
    $sec_refund=$final[0]['SECURITY_REFUND'];
    $edc=$final[0]['EDC_CHARGES'];
    $hire_charge=$final[0]['HIRE_CHARGES'];
    $ibt_Rec=$final[0]['IBT_RECEIVABLE'];

    $Atotal=$hire_collected+$reg_fee+$sec_deposit+$lost_book_+$lost_card+$retention+$misc_income+$cc+$misc_cost+$ibt_pay;
    $Btotal=$sec_refund+$edc+$hire_charge+$ibt_Rec;
$grandTotal=$Atotal-$Btotal;
$bName=$final[0]['BRANCHNAME'];
$baddress=$final[0]['BRANCHADDRESS'];
    $bid=$final[0]['BRANCHADDRESS'];

$address=explode(',',$baddress);



    $fileName=rand(1000,9999).'-inv-tmp.html';
    $res = $this->view->render($response, 'invoicePDF.mustache',['hire_collected'=>$hire_collected,
        'reg_fee'=>$reg_fee,'sec_deposit'=>$sec_deposit,'lost_book_'=>$lost_book_,
        'lost_card'=>$lost_card,'retention'=>$retention,'misc_income'=>$misc_income,
        'cc'=>$cc,'door_del'=>$door_del,'misc_cost'=>$misc_cost,
        'ibt_pay'=>$ibt_pay,'sec_refund'=>$sec_refund,'edc'=>$edc
        ,'hire_charge'=>$hire_charge,'ibt_Rec'=>$ibt_Rec,'Atotal'=>$Atotal,
        'Btotal'=>$Btotal,'grandTotal'=>$grandTotal,'date'=>$date,'name'=>$bName,'address'=>$address,'$bid'=>$bid]);
    $res = preg_replace("/^(.*\n){4}/", "", $res);
    file_put_contents('../templates/'.$fileName,$res);
    return $response->withRedirect('/pdfGenerateNew/'.$fileName.'/');

});


$app->any('/pdfGenerateNew/{filename}/', function (Request $request, Response $response,$args) {

    $data = '../templates/'.$args['filename'];

    $pdf=new Pdf();
    $options = array(
        'page-size'     => 'A3',
        'encoding'=>'UTF-8',
        // 'page-height'     => '279mm',
        'dpi'            => 72,
        'image-quality' => 100,
        //'margin-top'     => '16mm',
        'margin-right'   => '14mm',
        'margin-bottom'  => '25mm',
        'margin-left'    => '14mm',

        'replace' => array( 'myvar' => 'My String' ),
        'no-outline',

        'user-style-sheet' => '/var/www/html/myslim/public/assets/css/bootstrap.css'

    );

    $pdf->setOptions( $options );
//    $pdf = new Pdf(array(
//        'no-outline',         // Make Chrome not complain
//        'margin-top'    => 0,
//        'margin-right'  => 0,
//        'margin-bottom' => 0,
//        'margin-left'   => 0,
//        'page-width'    =>1024,
//
//        // Default page options
//    ));

// Add a page. To override above page defaults, you could add
// another $options array as second argument.
//    ));

// Add a page. To override above page defaults, you could add
// another $options array as second argument.

//    $final="hi";

   // $fileName='../templates/'.rand(1000,9999).'-inv-tmp.html';
    //$res = $this->view->render($response, 'invoicePDF.mustache',['data'=>"sgf"]);
//    $res = preg_replace("/^(.*\n){4}/", "", $res);
//    file_put_contents($fileName,$res);
//    $var =file_get_contents('../templates/invoicePDF.mustache');
//    echo $var;
//    die;
//    $params = ["title"=>"title_val", "content" => "something", "key" => "value"];
//    $pdf = new Pdf();
//    $html = file_get_contents('../templates/invoicePDF.html');
//    foreach($params as $key=>$value) {
//        $html = str_replace("{".$key."}", $value, $html);
//    }

    $pdf->addPage($data);

//    if (!$pdf->saveAs('../page.pdf')) {
//        ech
//    $pdf->addPage('../templates/test.html');


// On some systems you may have to set the path to the wkhtmltopdf executable
    $pdf->binary = '/var/www/html/inventory/vendor/bin/wkhtmltopdf-i386';
    $pdf->send('report.pdf');
    if(file_exists($data))
        unlink($data);
    if (!  $pdf->send('report.pdf')) {
        echo $pdf->getError();
    }
    // delete($fileName);

//    if (!$pdf->saveAs('../page.pdf')) {
//        echo $pdf->getError();
//    }


});



$app->post('/updateIBT/', function (Request $request, Response $response) {
    $con = $this->db;
    $data = $request->getParsedBody();
    $from=$data['from'];
    $to=$data['to'];

    $query="call fn_ibt_txn('$from','$to')";

    $result = oci_parse($con, $query);
    oci_execute($result);




});



$app->run();

?>