<style>

body {
  font-size : 14px;
}

.pe-7s-cart{
    position: absolute;
    top: -44px;
    left: 50px;
    margin-left: 769px;
}
.pe-7s-help1{
    position: absolute;
    top:-68px;
    left:95px;
    margin-left: 770px
}
.pe-7s-settings{
    position: absolute;
    top:-92px;
    left:142px;
    margin-left: 770px;
}
 .label{
    position: absolute;
    top: -79px;
    display: none;
 }
 .navbar {
    height: 40px;

 }
 .sidebar-toggle{
    margin-top: -97px;
    margin-left: -971px;
 }

.pe-7s-bell{
    position: relative;
    left: 768px;
}

  </style>


<html>
 
  <body>


  <button class="btnclr btn btn-default dropdown-toggle  boxes filip-horizontal mobile_para"  onclick="downloadPagesAsPDF()" style="margin-left:250px;" ><span  class="fa fa-download"></span>Download </button>
<body bgcolor="#A0A0A0" vlink="blue" link="blue"   >
<div id="download"  >


    <div class="page-1"  id="one">
      <!-- <img src="asset/images/uc_2a.jpg" alt="" width="100%" /> -->
      <img src="<?php echo base_url()  ?>asset/images/uc_2a.jpg"  width="100%" />

      
      <div class="sample-typed">
        <div class="grid">
            <input type="text" value="1" />
            <input type="text" value="2" />
            <input type="text" value="4" />
            <input type="text" value="5" />
            <input type="text" value="7" />
            <input type="text" value="9" />
            <input type="text" value="5" />
            <input type="text" value="7" />
            <input type="text" value="7" />
        </div>
       </div>
      <div class="sample-handwritten">
        <div class="grid">
        <input type="text" value="1" />
            <input type="text" value="2" max="1" />
            <input type="text" value="4" />
            <input type="text" value="5" />
            <input type="text" value="7" />
            <input type="text" value="9" />
            <input type="text" value="5" />
            <input type="text" value="7" />
            <input type="text" value="7" />
        </div>
      </div>
       
      <?php
      $company_name = isset($get_cominfo[0]['company_name']) ? $get_cominfo[0]['company_name'] : '';
      ?>
      <div class="ename">
        <input type="text"  value="<?php  echo $company_name;  ?>"  style="width:205px;" />
      </div>


      <div class="acc-no">
        <input type="text"  value="00000" style="text-align:center;" />
      </div>
      <div class="check-digi">
        <input type="text" />
      </div>


      <div class="year">
      <input type="text" value="<?php 
                  if ($info_for_nj[0]['quarter'] == 'Q1') {
                      echo '1';
                  } elseif ($info_for_nj[0]['quarter'] == 'Q2') {
                      echo '2';
                  } elseif ($info_for_nj[0]['quarter'] == 'Q3') {
                      echo '3';
                  } elseif ($info_for_nj[0]['quarter'] == 'Q4') {
                      echo '4';
                  } else {
                       echo 'Unknown';
                  }
              ?> / <?php echo date('Y'); ?>" />
      </div>


      <?php
        // Define an array for quarter end dates
        $quarter_end_dates = [
            'Q1' => 'last day of March',
            'Q2' => 'last day of June',
            'Q3' => 'last day of September',
            'Q4' => 'last day of December'
        ];
        // Check if the quarter is defined and exists in the array
        if (isset($info_for_nj[0]['quarter']) && array_key_exists($info_for_nj[0]['quarter'], $quarter_end_dates)) {
            $quarter_end_date = new DateTime($quarter_end_dates[$info_for_nj[0]['quarter']]);
            $return_due_date = $quarter_end_date->modify('+30 days')->format('m/d/') . date('Y');
          }
        ?>

      <div class="date">
      <input type="text" value="<?php echo $return_due_date; ?>"   style="text-align: center;"  />
      </div>


      <?php
      $mobile = isset($get_cominfo[0]['mobile']) ? $get_cominfo[0]['mobile'] : '';
      ?>
      <div class="tele-1">
        <input type="text" value="<?php echo 'Tam Doan'; ?>"    />
        <br>
         <input type="text" value="<?php echo $mobile; ?>"  style="position: absolute;top: 23px;"   />
         
      </div>
      <div class="tele-2">
        <input type="text" />
      </div>
      <div class="report">
        <input type="text" />
      </div>
      <div class="page">
        <input type="text" />
      </div>
      <div class="plant">
        <input type="text" />
      </div>
      <div class="wages">
        <!-- lek -->
      <div class="grid">
         




        <?php 
        $sum =   $overall_amount[0]['OverallTotal']; 
        ?>

         <?php 
             $one = substr($sum, 0, 1);
             $two = substr($sum, 1, 1);
             $three = substr($sum, 2, 1);
             $four = substr($sum, 3, 1);
             $five = substr($sum, 4, 1);
 
        ?>
 
          <input type="text"  value="<?php echo $one;   ?>"    />
          <input type="text"  value="<?php echo $two;   ?>"    />
          <input type="text"  value="<?php echo $three; ?>"    />
          <input type="text"  value="<?php echo $four;  ?>"    /> 
          <input type="text"  value="<?php echo $five;  ?>"    />

          <input type="text"  />
          <input type="text"   value="0" style="margin-left: 76px;" />
          <input type="text"   value="0"  />
 


         </div>








      </div>
      <div class="print">
        <input type="radio" />
      </div>
      <div>
        <div class="ssn">
          
 
          <?php 
            $ssn = $info_for_nj[0]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
        </div>

  


        <div class="last">
       
          <?php 
            $name = $info_for_nj[0]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />

 
        </div>





        <div class="example">

        <?php 
            $thisrate = $info_for_nj[0]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);

        ?>

          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />

          <input type="text" />
          <input
            type="text"
          /><input type="text" />
          <input type="text" />
        </div>



        <div class="credit">
          <input type="text" />
          <input type="text" />
        </div>
      </div>
      <div>
        <div class="ssn">
 
          <?php 
            $ssn = $info_for_nj[1]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   style="margin-left:2px;margin-top:27px;" />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />




        </div>



        <?php 
            $name = $info_for_nj[0]['first_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="fi">
            <input type="text" value="<?php echo $one; ?>" />
        </div>
         <?php 
            $name = $info_for_nj[0]['middle_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="mi">
          <input type="text"  value="<?php echo $one; ?>" />
        </div>


 



        <div class="last">
     
          <?php 
            $name = $info_for_nj[1]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"   style="margin-left:-3px;margin-top:27px;"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />



        </div>
        <div class="example">
           
 
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit">
          <input type="text" />
          <input type="text" />
        </div>
      </div>
      <!-- e1 -->
      <div class="e1">
        <div class="ssn">
            <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
        <div class="fi">
          <input type="text" />
        </div>
        <div class="mi">
          <input type="text" />
        </div>
        <div class="last">
          <input type="text" /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example">
          <input type="text" /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit">
          <input type="text" />
          <input type="text" />
        </div>
      </div>
      <!-- e2 -->
      <div class="e2">
        <div class="ssn2">
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
     

        <?php 
            $name = $info_for_nj[1]['first_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="fi2">
            <input type="text" value="<?php echo $one; ?>" />
        </div>
         <?php 
            $name = $info_for_nj[1]['middle_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="mi2">
          <input type="text"  value="<?php echo $one; ?>" />
        </div>
  
        <div class="last2">
           <input type="text"  value=""   style="width:210px;letter-spacing:8px; margin-left:5px; margin-top:25px;"   />
 
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
           </div>


 

        <div class="example2">
 
            <?php 
            $thisrate = $info_for_nj[1]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);

        ?>

          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />

          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit2">
          <input type="text" />
          <input type="text" />
        </div>
      </div>






      
      <!-- e3 -->
      <div class="e3">
        <div class="ssn3">

        <input type="text" />
        <?php 
            $ssn = $info_for_nj[2]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />

        </div>



        <?php 
            $name = $info_for_nj[2]['first_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="fi3">
            <input type="text" value="<?php echo $one; ?>" />
        </div>
         <?php 
            $name = $info_for_nj[2]['middle_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="mi3">
          <input type="text"  value="<?php echo $one; ?>" />
        </div>
 
        <div class="last3">


        <?php 
            $name = $info_for_nj[2]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />




        </div>
        <div class="example3">
           
 
          <?php 
            $thisrate = $info_for_nj[2]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);

        ?>

          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit3">
          <input type="text" />
          <input type="text" />
        </div>
      </div>







      <!-- e4 -->
      <div class="e4">
        <div class="ssn4">

        <?php 
            $ssn = $info_for_nj[3]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
        </div>
       

        <?php 
            $name = $info_for_nj[3]['first_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="fi4">
            <input type="text" value="<?php echo $one; ?>" />
        </div>
         <?php 
            $name = $info_for_nj[3]['middle_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="mi4">
          <input type="text"  value="<?php echo $one; ?>" />
        </div>

 
        <div class="last4">
           
        <?php 
            $name = $info_for_nj[3]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
      
        </div>




        <div class="example4">
           
        <?php 
            $thisrate = $info_for_nj[3]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);

        ?>

          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
       
 
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit4">
          <input type="text" />
          <input type="text" />
        </div>
      </div>
      <!-- e5 -->
      <div class="e5">
        <div class="ssn5">


        <?php 
            $ssn = $info_for_nj[4]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />



        </div>

 

        <?php 
            $name = $info_for_nj[4]['first_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="fi5">
            <input type="text" value="<?php echo $one; ?>" />
        </div>
         <?php 
            $name = $info_for_nj[4]['middle_name'];
            $one = substr($name, 0, 1);
        ?>
        <div class="mi5">
          <input type="text"  value="<?php echo $one; ?>" />
        </div>



 
        <div class="last5">

        <?php 
            $name = $info_for_nj[4]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
        </div>



        <div class="example5">

        <?php 
            $thisrate = $info_for_nj[4]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);

        ?>

          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
       

 
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit5">
          <input type="text" />
          <input type="text" />
        </div>
      </div>
      <!-- e6 -->
      <div class="e6">
        <div class="ssn6">

        <?php 
            $ssn = $info_for_nj[5]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
        </div>
         
 
<?php 
    $name = $info_for_nj[5]['first_name'];
    $one = substr($name, 0, 1);
?>
<div class="fi6">
    <input type="text" value="<?php echo $one; ?>" />
</div>
 <?php 
    $name = $info_for_nj[5]['middle_name'];
    $one = substr($name, 0, 1);
?>
<div class="mi6">
  <input type="text"  value="<?php echo $one; ?>" />
</div>


 


        <div class="last6">
        <?php 
            $name = $info_for_nj[5]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
       
       
        </div>
        <div class="example6">

        <?php 
            $thisrate = $info_for_nj[5]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
 
          <input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit6">
          <input type="text" />
          <input type="text" />
        </div>
      </div>





      <!-- e7 -->
      <div class="e7">
        <div class="ssn7">
        <?php 
            $ssn = $info_for_nj[6]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
        </div>
       

        <?php 
    $name = $info_for_nj[6]['first_name'];
    $one = substr($name, 0, 1);
?>
<div class="fi7">
    <input type="text" value="<?php echo $one; ?>" />
</div>
 <?php 
    $name = $info_for_nj[6]['middle_name'];
    $one = substr($name, 0, 1);
?>
<div class="mi7">
  <input type="text"  value="<?php echo $one; ?>" />
</div>


 
        <div class="last7">
         
        <?php 
            $name = $info_for_nj[6]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />


        </div>
        <div class="example7">
           <?php 
            $thisrate = $info_for_nj[6]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit7">
          <input type="text" />
          <input type="text" />
        </div>
      </div>
      <!-- e8 -->
      <div class="e8">
        <div class="ssn8">
        <?php 
            $ssn = $info_for_nj[7]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
        </div>
 

        <?php 
    $name = $info_for_nj[7]['first_name'];
    $one = substr($name, 0, 1);
?>
<div class="fi8">
    <input type="text" value="<?php echo $one; ?>" />
</div>
 <?php 
    $name = $info_for_nj[7]['middle_name'];
    $one = substr($name, 0, 1);
?>
<div class="mi8">
  <input type="text"  value="<?php echo $one; ?>" />
</div>



        <div class="last8">
           
        <?php 
            $name = $info_for_nj[7]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
    
    
        </div>
        <div class="example8">

        <?php 
            $thisrate = $info_for_nj[7]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />

           
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit8">
          <input type="text" />
          <input type="text" />
        </div>
      </div>



      <!-- e9  -->
      <div class="e9">
        <div class="ssn9">


        <?php 
            $ssn = $info_for_nj[8]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />


        </div>
  

        <?php 
$name = $info_for_nj[8]['first_name'];
$one = substr($name, 0, 1);
?>
<div class="fi9">
<input type="text" value="<?php echo $one; ?>" />
</div>
<?php 
$name = $info_for_nj[8]['middle_name'];
$one = substr($name, 0, 1);
?>
<div class="mi9">
<input type="text"  value="<?php echo $one; ?>" />
</div>


        <div class="last9">
      
   
        <?php 
            $name = $info_for_nj[8]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
   
   
        </div>
        <div class="example9">
          <input type="text" />
          
          <?php 
            $thisrate = $info_for_nj[8]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
           
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit9">
          <input type="text" />
          <input type="text" />
        </div>
      </div>
      <!-- e10 -->
      <div class="e10">
        <div class="ssn10">
       
        <?php 
            $ssn = $info_for_nj[9]['social_security_number'];
            $one = substr($ssn, 0, 1);
            $two = substr($ssn, 1, 1);
            $three = substr($ssn, 2, 1);
            $four = substr($ssn, 3, 1);
            $five = substr($ssn, 4, 1);
            $six = substr($ssn, 5, 1);
            $seven = substr($ssn, 6, 1);
            $eight = substr($ssn, 7, 1);
            $nine = substr($ssn, 8, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />


        </div>
       
 
                <?php 
        $name = $info_for_nj[9]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi10">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[9]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi10">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>

 
        <div class="last10">
        
        <?php 
            $name = $info_for_nj[9]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
       
       
        </div>
        <div class="example10">
           
          <?php 
            $thisrate = $info_for_nj[9]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit10">
          <input type="text" />
          <input type="text" />
        </div>
      </div>
      <!-- e11 -->
      <div class="e11">
        <div class="ssn11">

        <input type="text" value="<?php echo $info_for_nj[10]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
 
           <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
        

        <?php 
        $name = $info_for_nj[10]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi11">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[10]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi11">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>


        <div class="last11">
        <?php 
            $name = $info_for_nj[10]['last_name'];
            $one = substr($name, 0, 1);
            $two = substr($name, 1, 1);
            $three = substr($name, 2, 1);
            $four = substr($name, 3, 1);
            $five = substr($name, 4, 1);
            $six = substr($name, 5, 1);
            $seven = substr($name, 6, 1);
            $eight = substr($name, 7, 1);
            $nine = substr($name, 8, 1);
        ?>

           <input type="text"   value="<?php echo $one; ?>"     />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
          <input type="text"   value="<?php echo $six; ?>"  />
          <input type="text"   value="<?php echo $seven; ?>"  />
          <input type="text"   value="<?php echo $eight; ?>"  />
          <input type="text"   value="<?php echo $nine; ?>"  />
        </div>
        <div class="example11">
           <?php 
            $thisrate = $info_for_nj[10]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />
           
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit11">
          <input type="text" />
          <input type="text" />
        </div>
      </div>

      <!-- e12 -->
      <div class="e12">
        <div class="ssn12">
        <input type="text" value="<?php echo $info_for_nj[11]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>

 

        <?php 
        $name = $info_for_nj[11]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi12">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[11]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi12">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>






        <div class="last12">
           <input type="text"  value="<?php echo $info_for_nj[11]['last_name'] ?>"  style="width: 241px;letter-spacing: 10px;margin-left: -44px;" />

          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example12">
        <?php 
            $thisrate = $info_for_nj[11]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />          
          
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit12">
          <input type="text" />
          <input type="text" />
        </div>
      </div>

      <!-- e13 -->
      <div class="e13">
        <div class="ssn13">
        <input type="text" value="<?php echo $info_for_nj[12]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
        
        <?php 
        $name = $info_for_nj[12]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi13">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[12]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi13">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>




        <div class="last13">
           <input type="text"  value="<?php echo $info_for_nj[12]['last_name'] ?>"  style="width: 241px;letter-spacing: 10px;margin-left: -44px;" />

          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example13">
           <?php 
            $thisrate = $info_for_nj[12]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  /> 
          
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit13">
          <input type="text" />
          <input type="text" />
        </div>
      </div>

      <!-- e14 -->
      <div class="e14">
        <div class="ssn14">
        <input type="text" value="<?php echo $info_for_nj[13]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
         

        <?php 
        $name = $info_for_nj[13]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi14">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[13]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi14">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>




        <div class="last14">
           
          <input type="text"  value="<?php echo $info_for_nj[13]['last_name'] ?>"  style="width: 241px;letter-spacing: 10px;margin-left: -44px;" />

          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example14">

        <?php 
            $thisrate = $info_for_nj[13]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  /> 
          
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit14">
          <input type="text" />
          <input type="text" />
        </div>
      </div>

      <!-- e15 -->
      <div class="e15">
        <div class="ssn15">
        <input type="text" value="<?php echo $info_for_nj[14]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
    


        <?php 
        $name = $info_for_nj[14]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi15">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[14]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi15">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>




        <div class="last15">
           
          <input type="text"  value="<?php echo $info_for_nj[14]['last_name'] ?>"  style="width: 241px;letter-spacing: 10px;margin-left: -44px;" />

          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example15">

        <?php 
            $thisrate = $info_for_nj[14]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  /> 
          
          
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit15">
          <input type="text" />
          <input type="text" />
        </div>
      </div>

      <!-- e16 -->
      <div class="e16">
        <div class="ssn16">
        <input type="text" value="<?php echo $info_for_nj[15]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
       

        <?php 
        $name = $info_for_nj[15]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi16">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[15]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi16">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>





        <div class="last16">
           <input type="text"  value="<?php echo $info_for_nj[15]['last_name'] ?>"  style="width: 241px;letter-spacing: 10px;margin-left: -44px;" />

          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example16">
        <?php 
            $thisrate = $info_for_nj[15]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />           
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit16">
          <input type="text" />
          <input type="text" />
        </div>
      </div>

      <!-- e17 -->
      <div class="e17">
        <div class="ssn17">
        <input type="text" value="<?php echo $info_for_nj[16]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
      

        <?php 
        $name = $info_for_nj[16]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi17">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[16]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi17">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>



        <div class="last17">
           <input type="text"  value="<?php echo $info_for_nj[16]['last_name'] ?>"  style="width: 241px;letter-spacing: 10px;margin-left: -44px;" />

          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example17">
        <?php 
            $thisrate = $info_for_nj[16]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />           
          
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit17">
          <input type="text" />
          <input type="text" />
        </div>
      </div>

      <!-- e18 -->
      <div class="e18">
        <div class="ssn18">
        <input type="text" value="<?php echo $info_for_nj[17]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
        <?php 
        $name = $info_for_nj[17]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi18">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[17]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi18">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>
        <div class="last18">
           <input type="text"  value="<?php echo $info_for_nj[17]['last_name'] ?>"  style="width: 241px;letter-spacing: 10px;margin-left: -44px;" />

          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example18">
        <?php 
            $thisrate = $info_for_nj[17]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />           
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit18">
          <input type="text" />
          <input type="text" />
        </div>
      </div>

      <!-- e19  -->
      <div class="e19">
        <div class="ssn19">
        <input type="text" value="<?php echo $info_for_nj[18]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
        
 
        <?php 
        $name = $info_for_nj[18]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi19">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[18]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi19">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>




        <div class="last19">
           
          <input type="text"  value="<?php echo $info_for_nj[18]['last_name'] ?>"  style="width: 241px;letter-spacing: 10px;margin-left: -44px;" />

          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example19">
        <?php 
            $thisrate = $info_for_nj[18]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />           
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit19">
          <input type="text" />
          <input type="text" />
        </div>
      </div>

      <!-- e20 -->
      <div class="e20">
        <div class="ssn20">
        <input type="text" value="<?php echo $info_for_nj[19]['social_security_number'] ?>" style=" width: 167px;letter-spacing: 10px; " />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
          <input type="text" />
        </div>
    

        <?php 
        $name = $info_for_nj[19]['first_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="fi20">
        <input type="text" value="<?php echo $one; ?>" />
        </div>
        <?php 
        $name = $info_for_nj[19]['middle_name'];
        $one = substr($name, 0, 1);
        ?>
        <div class="mi20">
        <input type="text"  value="<?php echo $one; ?>" />
        </div>


        <div class="last20">
           <input type="text"     style="width: 241px;letter-spacing: 10px;margin-left: -44px;" />

          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="example20">
        <?php 
            $thisrate = $info_for_nj[19]['extra_thisrate'];
            $one = substr($thisrate, 0, 1);
            $two = substr($thisrate, 1, 1);
            $three = substr($thisrate, 2, 1);
            $four = substr($thisrate, 3, 1);
            $five = substr($thisrate, 4, 1);
        ?>
          <input type="text"   value="<?php echo $one; ?>"   />
          <input type="text"   value="<?php echo $two; ?>"   />
          <input type="text"   value="<?php echo $three; ?>" />
          <input type="text"   value="<?php echo $four; ?>"  />
          <input type="text"   value="<?php echo $five; ?>"  />           
          
          <input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" /><input
            type="text"
          /><input type="text" /><input type="text" />
        </div>
        <div class="credit20">
          <input type="text" />
          <input type="text" />
        </div>
      </div>
      <div class="l11">
        <input type="text" />
      </div>  
        <div class="l11a">
        
        <?php 
        $sum =   $overall_amount[0]['OverallTotal']; 
        ?>

         <?php 
             $one = substr($sum, 0, 1);
             $two = substr($sum, 1, 1);
             $three = substr($sum, 2, 1);
             $four = substr($sum, 3, 1);
             $five = substr($sum, 4, 1);
 
        ?>


          <input type="text"  value="<?php echo $one;   ?>"  />
          <input type="text"  value="<?php echo $two;   ?>"  style="margin-left:-4px;"  />
          <input type="text"  value="<?php echo $three; ?>"  style="margin-left:-2px;"  />
          <input type="text"  value="<?php echo $four;  ?>"  style="margin-left:-1px;"  /> 
          <input type="text"  value="<?php echo $five;  ?>"  style="margin-left:-4px;"  />

          <input type="text"  />
          
       
          <input type="text"   value="0" style="margin-left: 8px;" />
          <input type="text"   value="0"  />
        </div>
     
      <div class="l12">
        <input type="text" />
      </div>
      <div class="l13">
        <input type="text">
      </div>
      <div class="l13b">
        <input type="text">
      </div>
    </div>
  </body>
  <style>
    .page-1 {
  width: 21cm;
  height: 29.7cm;
  position: relative;
  margin: 0 auto;
  page-break-after: always;
}
.sample-typed input {
  height: 17px;
  width: 17px;
  margin-left: -4px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  text-align: center !important;
}

.sample-typed {
  position: absolute;
  top: 127px;
    left: 101px;
}
.sample-typed .grid{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 2px;
}
.sample-handwritten input {
  height: 17px;
  width: 17px;
  margin-left: -1px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  text-align: center !important;
}

.sample-handwritten {
  position: absolute;
  top: 127px;
  left: 354px;
}
.sample-handwritten .grid{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 2px;
}
.wages .grid{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 2px;   
}





.ename input {
  height: 20px;
  width: 206px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  

  
}
.ename {
  position: absolute;
  top: 192px;
  left: 46px;
}
.acc-no input {
  height: 20px;
  width: 155px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  
}

.acc-no {
  position: absolute;
  top: 192px;
  left: 260px;
}
.check-digi input {
  height: 20px;
  width: 19px;
  border: 0px !important;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  text-align: center !important;
}

.check-digi {
  position: absolute;
  top: 192px;
  left: 427px;
}
.year input {
  height: 20px;
  width: 104px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  text-align: center !important;
}

.year {
  position: absolute;
  top: 192px;
  left: 454px;
}
.date input {
  height: 20px;
  width: 174px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
 
}

.date {
  position: absolute;
  top: 192px;
  left: 575px;
}
.tele-1 input,
.tele-2 input {
  height: 20px;
  width: 297px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
 
}

.tele-1 {
  position: absolute;
  top: 246px;
  left: 47px;
}
.report input,
.page input,
.plant input {
  height: 22px;
  width: 45px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  text-align: center !important;
}

.report {
  position: absolute;
  top: 273px;
  left: 385px;
}
.page {
  position: absolute;
  top: 273px;
  left: 533px;
}
.plant {
  position: absolute;
  top: 273px;
  left: 677px;
}
.wages input {
  height: 20px;
  width: 16px;
  margin-left: -2px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  letter-spacing: 10px;

}

.wages {
  position: absolute;
  top: 345px;
  left: 43px;
}
.print input {
  height: 33px;
  width: 18px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
}
.print {
    
  position: absolute;
  top: 312px;
    left: 707px;
}
/* e1 */
.ssn input {
  height: 22px;
  width: 16px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  margin-left: -2px;
}

.ssn {
  position: absolute;
  top: 420px;
  left: 42px;
}
.fi input,
.mi input {
  height: 22px;
  width: 16px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
}
.fi {
    
  position: absolute;
  top: 420px;
  left: 213px;
}
.mi {
  position: absolute;
  top: 420px;
  left: 241px;
}
.last input,
.example input {
  height: 22px;
  width: 16.5px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  margin-left: -2px;
}

.last {
  position: absolute;
  top: 420px;
  left: 272px;
}
.example {
  position: absolute;
  top: 420px;
  left: 548px;
}
.credit input {
  height: 22px;
  width: 16px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  /* margin-left: 1px; */
}

.credit {
  position: absolute;
  top: 420px;
  left: 718px;
}
/* e2 */
.ssn2 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    
  }
  
.ssn2 {
  position: absolute;
  top: 445px;
  left: 42px;
}
.fi2 input,
.mi2 input {
  height: 22px;
  width: 16px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
}
.fi2 {
    
  position: absolute;
  top: 445px;
  left: 213px;
}
.mi2 {
  position: absolute;
  top: 445px;
  left: 241px;
}
.last2 input,
.example2 input {
  height: 22px;
  width: 16.5px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  margin-left: -2px;
}

.last2 {
  position: absolute;
  top: 445px;
  left: 270px;
}
.example2 {
  position: absolute;
  top: 445px;
  left: 548px;
}
.credit2 input {
  height: 22px;
  width: 16px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  /* margin-left: 1px; */
}

.credit2 {
  position: absolute;
  top: 445px;
  left: 718px;
}
/* e3 */
.ssn3 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
  }
  
.ssn3 {
  position: absolute;
  top: 471px;
  left: 25px;
}
.fi3 input,
.mi3 input {
  height: 22px;
  width: 16px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
}
.fi3 {
    
  position: absolute;
  top: 471px;
  left: 213px;
}
.mi3 {
  position: absolute;
  top: 471px;
  left: 241px;
}
.last3 input,
.example3 input {
  height: 22px;
  width: 16.5px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  margin-left: -3px;
}

.last3 {
  position: absolute;
  top: 471px;
  left: 274px;
}
.example3 {
  position: absolute;
  top: 471px;
  left: 550px;
}
.credit3 input {
  height: 22px;
  width: 16px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  /* margin-left: 1px; */
}

.credit3 {
  position: absolute;
  top: 498px;
  left: 718px;
}
/* e4 */
.ssn4 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
  }
  
.ssn4 {
  position: absolute;
  top: 498px;
  left: 42px;
}
.fi4 input,
.mi4 input {
  height: 22px;
  width: 16px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
}
.fi4 {
    
  position: absolute;
  top: 498px;
  left: 213px;
}
.mi4 {
  position: absolute;
  top: 498px;
  left: 241px;
}
.last4 input,
.example4 input {
  height: 22px;
  width: 16.5px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  margin-left: -2px;
}

.last4 {
  position: absolute;
  top: 498px;
  left: 270px;
}
.example4 {
  position: absolute;
  top: 498px;
  left: 548px;
}
.credit4 input {
  height: 22px;
  width: 16px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  /* margin-left: 1px; */
}

.credit4 {
  position: absolute;
  top: 498px;
  left: 718px;
}
/* e5 */
.ssn5 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
  }
  
.ssn5 {
  position: absolute;
  top: 522px;
  left: 42px;
}
.fi5 input,
.mi5 input {
  height: 22px;
  width: 16px;
  border: 0px red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
}
.fi5 {
    
  position: absolute;
  top: 522px;
  left: 213px;
}
.mi5 {
  position: absolute;
  top: 522px;
  left: 241px;
}
.last5 input,
.example5 input {
  height: 22px;
  width: 16.5px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  margin-left: -2px;
}

.last5 {
  position: absolute;
  top: 522px;
  left: 270px;
}
.example5 {
  position: absolute;
  top: 522px;
  left: 548px;
}
.credit5 input {
  height: 22px;
  width: 16px;
  border: 0 red solid;
  background-color: transparent !important;
  margin-left: -1px;
  text-align: center !important;
  /* margin-left: 1px; */
}

.credit5 {
  position: absolute;
  top: 522px;
  left: 718px;
}
/* e6 */
.ssn6 input {
    height: 22px;
    width: 16px;
    border:0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn6 {
    position: absolute;
    top: 548px;
    left: 42px;
}
.fi6 input,
.mi6 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi6 {
    
    position: absolute;
    top: 548px;
    left: 213px;
}
.mi6 {
    position: absolute;
    top: 548px;
    left: 241px;
}
.last6 input,
.example6 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.last6 {
    position: absolute;
    top: 548px;
    left: 270px;
}
.example6 {
    position: absolute;
    top: 548px;
    left: 548px;
}
.credit6 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}


.credit6 {
    position: absolute;
    top: 548px;
    left: 718px;
}
/* e7 */
.ssn7 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn7 {
    position: absolute;
    top: 572px;
    left: 42px;
}
.fi7 input,
.mi7 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi7 {
    
    position: absolute;
    top: 572px;
    left: 213px;
}
.mi7 {
    position: absolute;
    top: 572px;
    left: 241px;
}
.last7 input,
.example7 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.last7 {
    position: absolute;
    top: 572px;
    left: 270px;
}
.example7 {
    position: absolute;
    top: 572px;
    left: 572px;
}
.credit7 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit7 {
    position: absolute;
    top: 572px;
    left: 718px;
}
/* e8 */
.ssn8 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn8 {
    position: absolute;
    top: 597px;
    left: 42px;
}
.fi8 input,
.mi8 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi8 {
    
    position: absolute;
    top: 597px;
    left: 213px;
}
.mi8 {
    position: absolute;
    top: 597px;
    left: 241px;
}
.last8 input,
.example8 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    
    margin-left: 1px;
}
.last8 {
    position: absolute;
    top: 597px;
    left: 270px;
}
.example8 {
    position: absolute;
    top: 597px;
    left: 548px;
}
.credit8 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit8 {
    position: absolute;
    top: 597px;
    left: 718px;
}
/* e9 */
.ssn9 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn9 {
    position: absolute;
    top: 623px;
    left: 42px;
}
.fi9 input,
.mi9 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi9 {
    
    position: absolute;
    top: 623px;
    left: 213px;
}
.mi9 {
    position: absolute;
    top: 623px;
    left: 241px;
}
.last9 input,
.example9 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last9 {
    position: absolute;
    top: 623px;
    left: 270px;
}
.example9 {
    position: absolute;
    top: 623px;
    left: 548px;
}
.credit9 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit9 {
    position: absolute;
    top: 623px;
    left: 718px;
}
/* e10 */
.ssn10 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn10 {
    position: absolute;
    top: 649px;
    left: 42px;
}
.fi10 input,
.mi10 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi10 {
    
    position: absolute;
    top: 649px;
    left: 213px;
}
.mi10 {
    position: absolute;
    top: 649px;
    left: 241px;
}
.last10 input,
.example10 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last10 {
    position: absolute;
    top: 649px;
    left: 270px;
}
.example10 {
    position: absolute;
    top: 649px;
    left: 548px;
}
.credit10 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit10 {
    position: absolute;
    top: 649px;
    left: 718px;
}
/* e11 */
.ssn11 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn11 {
    position: absolute;
    top: 674px;
    left: 42px;
}
.fi11 input,
.mi11 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi11 {
    
    position: absolute;
    top: 674px;
    left: 213px;
}
.mi11 {
    position: absolute;
    top: 674px;
    left: 241px;
}
.last11 input,
.example11 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last11 {
    position: absolute;
    top: 674px;
    left: 270px;
}
.example11 {
    position: absolute;
    top: 674px;
    left: 548px;
}
.credit11 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit11 {
    position: absolute;
    top: 674px;
    left: 718px;
}
/* e12 */
.ssn12 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn12 {
    position: absolute;
    top: 700px;
    left: 42px;
}
.fi12 input,
.mi12 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi12 {
    
    position: absolute;
    top: 700px;
    left: 213px;
}
.mi12 {
    position: absolute;
    top: 700px;
    left: 241px;
}
.last12 input,
.example12 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last12 {
    position: absolute;
    top: 700px;
    left: 270px;
}
.example12 {
    position: absolute;
    top: 700px;
    left: 548px;
}
.credit12 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit12 {
    position: absolute;
    top: 700px;
    left: 718px;
}
/* e13 */
.ssn13 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn13 {
    position: absolute;
    top: 725px;
    left: 42px;
}
.fi13 input,
.mi13 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi13 {
    
    position: absolute;
    top: 725px;
    left: 213px;
}
.mi13 {
    position: absolute;
    top: 725px;
    left: 241px;
}
.last13 input,
.example13 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last13 {
    position: absolute;
    top: 725px;
    left: 270px;
}
.example13 {
    position: absolute;
    top: 725px;
    left: 548px;
}
.credit13 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit13 {
    position: absolute;
    top: 725px;
    left: 718px;
}
/* e14 */
.ssn14 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn14 {
    position: absolute;
    top: 750px;
    left: 42px;
}
.fi14 input,
.mi14 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi14 {
    
    position: absolute;
    top: 750px;
    left: 213px;
}
.mi14 {
    position: absolute;
    top: 750px;
    left: 241px;
}
.last14 input,
.example14 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last14 {
    position: absolute;
    top: 750px;
    left: 270px;
}
.example14 {
    position: absolute;
    top: 750px;
    left: 548px;
}
.credit14 input {
    height:22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit14 {
    position: absolute;
    top: 750px;
    left: 718px;
}
/* e15 */
.ssn15 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn15 {
    position: absolute;
    top: 774px;
    left: 42px;
}
.fi15 input,
.mi15 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi15 {
    
    position: absolute;
    top: 774px;
    left: 213px;
}
.mi15 {
    position: absolute;
    top: 774px;
    left: 241px;
}
.last15 input,
.example15 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last15 {
    position: absolute;
    top: 774px;
    left: 270px;
}
.example15 {
    position: absolute;
    top: 774px;
    left: 548px;
}
.credit15 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit15 {
    position: absolute;
    top: 774px;
    left: 718px;
}
/* e16 */
.ssn16 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn16 {
    position: absolute;
    top: 799px;
    left: 42px;
}
.fi16 input,
.mi16 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi16 {
    
    position: absolute;
    top: 799px;
    left: 213px;
}
.mi16 {
    position: absolute;
    top: 799px;
    left: 241px;
}
.last16 input,
.example16 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last16 {
    position: absolute;
    top: 799px;
    left: 270px;
}
.example16 {
    position: absolute;
    top: 799px;
    left: 548px;
}
.credit16 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit16 {
    position: absolute;
    top: 799px;
    left: 718px;
}
/* e17 */
.ssn17 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn17 {
    position: absolute;
    top: 824px;
    left: 42px;
}
.fi17 input,
.mi17 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi17 {
    
    position: absolute;
    top: 824px;
    left: 213px;
}
.mi17 {
    position: absolute;
    top: 824px;
    left: 241px;
}
.last17 input,
.example17 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last17 {
    position: absolute;
    top: 824px;
    left: 270px;
}
.example17 {
    position: absolute;
    top: 824px;
    left: 548px;
}
.credit17 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit17 {
    position: absolute;
    top: 824px;
    left: 718px;
}
/* e18 */
.ssn18 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn18 {
    position: absolute;
    top: 850px;
    left: 42px;
}
.fi18 input,
.mi18 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi18 {
    
    position: absolute;
    top: 850px;
    left: 213px;
}
.mi18 {
    position: absolute;
    top: 850px;
    left: 241px;
}
.last18 input,
.example18 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last18 {
    position: absolute;
    top: 850px;
    left: 270px;
}
.example18 {
    position: absolute;
    top: 850px;
    left: 548px;
}
.credit18 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit18 {
    position: absolute;
    top: 850px;
    left: 718px;
}
/* e19 */
.ssn19 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn19 {
    position: absolute;
    top: 876px;
    left: 42px;
}
.fi19 input,
.mi19 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi19 {
    
    position: absolute;
    top: 876px;
    left: 213px;
}
.mi19 {
    position: absolute;
    top: 876px;
    left: 241px;
}
.last19 input,
.example19 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last19 {
    position: absolute;
    top: 876px;
    left: 270px;
}
.example19 {
    position: absolute;
    top: 876px;
    left: 548px;
}
.credit19 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit19 {
    position: absolute;
    top: 876px;
    left: 718px;
}
/* e20 */
.ssn20 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: -2px;
}

.ssn20 {
    position: absolute;
    top: 903px;
    left: 42px;
}
.fi20 input,
.mi20 input {
    height: 22px;
    width: 16px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
}
.fi20 {
    
    position: absolute;
    top: 903px;
    left: 213px;
}
.mi20 {
    position: absolute;
    top: 903px;
    left: 241px;
}
.last20 input,
.example20 input {
    height: 22px;
    width: 16.5px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.last20 {
    position: absolute;
    top: 903px;
    left: 270px;
}
.example20 {
    position: absolute;
    top: 903px;
    left: 548px;
}
.credit20 input {
    height: 22px;
    width: 16px;
    border: 0 red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    /* margin-left: 1px; */
}

.credit20 {
    position: absolute;
    top: 903px;
    left: 718px;
}

.l11 input ,.l12 input,.l13 input,.l13b input{
    height: 18px;
    width: 32px;
    background-color: transparent;
    border: 0;
}

.l11{
    position: absolute;
    bottom: 158px;
    left: 360px;
}
.l11a input {
    height: 22px;
    width: 16.5px;
    border: 0px red solid;
    background-color: transparent !important;
    margin-left: -1px;
    text-align: center !important;
    margin-left: 1px;
}

.l11a {
    position: absolute;
    top: 945px;
    left: 548px;
}
.l12{
    position: absolute;
    bottom: 141px;
    left: 417px;
}
.l13{
    position: absolute;
    bottom: 111px;
    left: 389px;
}
.l13b{
    position: absolute;
    bottom: 111px;
    left: 436px;
}
input {
      border: 0;
      /* background-color: #f1f4ff; */
      background-color: transparent;
    }


  </style>
</html>



<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  
<script>
async function downloadPagesAsPDF() {
// debugger;

  const element1 = document.getElementById('one');
   
  if (!element1  ) {
      alert('One or more elements not found');
      return;
  }

  const canvas1 = await html2canvas(element1, { scale: 2 });
 
  const imgData1 = canvas1.toDataURL('image/jpeg', 1.0);
 
  const pdf = new jspdf.jsPDF({
      orientation: 'p',
      unit: 'px',
      format: [canvas1.width, canvas1.height]
  });

  pdf.addImage(imgData1, 'JPEG', 0, 0, canvas1.width, canvas1.height);
  
  pdf.save('UC_2A.pdf');
}

</script>

