<!DOCTYPE html>
<html>
<head>
    <title>Customer Orders</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css2/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.6.1.min.js"></script>  
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js2/bootstrap.min.js"></script>

  </head>
  <body>
    
  <div class="container text-center">
        <button class="btn btn-success col-sm-4" id="customer">Customer</button>
        <button class="btn btn-success col-sm-4" id="customersFeedback">Customers FeedBack</button>
        <script>
            document.getElementById("customer").onclick = function () {window.location.replace('customer.php'); };    
            document.getElementById("customersFeedback").onclick = function () {window.location.replace('customerFeedbackList.php'); };    
        </script> 
        
        <div class="col-lg-12">
            <table class="table table-striped" border="10">
            <tr>	
            <th scope="col">name</th>
            <th scope="col">status</th>
            <th scope="col">email</th>
            <th scope="col"></th>
            <th scope="col">FeedBack</th>
            <th scope="col">Date</th>
            </tr>
              <tbody>
                <?php
                session_start();
                include_once('orderClass.php');
                $orderlist = orderList::withUsername($_SESSION["username"]);  //Scope Resolution Operator (::) double colon = jump to search 
                $resultSet =  $orderlist -> getOrderListByCustomer(); 
                if($resultSet != null)
                foreach($resultSet as $rows){ ?>
                <tr>	   
                <td><?php echo $rows['name']; ?></td>
                <td><?php echo ($rows['status'] == 1 ? "Approved": "Pending"); 
                ?></td>
                <td><?php echo $rows['email']; ?></td>
                <td><a href="customerOrders.php?idAndPic=<?php echo $rows['ordersLinkId'].','.$rows['proofOfPayment']?>">View Order</a></td>
                <td><?php 
                  $orderlist =  orderList::withUsersAndOrdersLinkId($rows['userlinkId'],$rows['ordersLinkId']);
                  if($rows['status'] == 1 && $orderlist->CustomerFeedback() == null){
                    ?>  <a href="customerFeedBack.php?ordersLinkIdAndUserLinkId=<?php echo $rows['ordersLinkId'].','.$rows['userlinkId']?>">feedback</a>  <?php
                  }
                  elseif($rows['status'] == 1){
                    echo "You have already feedback!";
                  }
                  else{
                    echo "you cannot give feedback yet </br> please wait for approvation";
                  }
                ?>
                </td>
                <td><?php echo date('m/d/Y h:i:s a ', strtotime($rows['date'])); ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
	    </div>
    </body>
</html>
<?php 
  if(isset($_GET['status'])){
    $arr = explode(',',$_GET['status']);  
    $ordersLinkId = $arr[0];
    $email = $arr[1];
    $order = new order($ordersLinkId,$email);
    $order-> computeOrder(); 
    $order-> sendReceiptToEmail(); 
    $order-> approveOrder();
  }
?>