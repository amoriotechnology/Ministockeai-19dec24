<?php error_reporting(1);  ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<script type="text/javascript" src="<?= base_url()?>assets/js/jquery.base64.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/drag_drop_index_table.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/html2canvas.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/jspdf.plugin.autotable"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/jspdf.umd.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>my-assets/js/invoice_tableManager.js"></script>

<!-- <script type="text/javascript" src="<?= base_url()?>my-assets/js/tableManager.js"></script> -->
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="http://mrrio.github.io/jsPDF/dist/jspdf.debug.js"></script>
<input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
<!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
<script src="<?= base_url() ?>assets/js/dashboard.js" ></script>
<link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="<?= base_url() ?>my-assets/css/style.css">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="http://www.bacubacu.com/colresizable/js/colResizable-1.5.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?= base_url()?>my-assets/css/css.css" />
<input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
<link rel="stylesheet" type="text/css" href="<?= base_url()?>my-assets/css/css.css" />
<!-- <script type="text/javascript" src="http://www.bacubacu.com/colresizable/js/colResizable-1.5.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>my-assets/css/css.css" />

<style>
   .table {
      /*display: block;*/
      overflow-x: auto;
   }
   .btnclr{
      background-color:<?= $setting_detail[0]['button_color']; ?>;
      color: white;
   }
   .Row {
      display: table;
      width: 100%; /*Optional*/
      table-layout: fixed; /*Optional*/
      border-spacing: 5px; /*Optional*/
   }
   .Column {
      display: table-cell;
   }
   th {
      padding: 10px !important;
   }
   .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
      vertical-align: middle;
   }
   .search_dropdown{
      background:center;
   }
   /*th{
      color:black;
   }*/
   .select2{
      display:none;
   }
   .logo-9 i{
      font-size:80px;
      position:absolute;
      z-index:0;
      text-align:center;
      width:100%;
      left:0;
      top:-10px;
      color:#34495e;
      -webkit-animation:ring 2s ease infinite;
      animation:ring 2s ease infinite;
   }
   .logo-9 h1{
      font-family: 'Lora', serif;
      font-weight:600;
      text-transform:uppercase;
      font-size:40px;
      position:relative;
      z-index:1;
      color:#e74c3c;
      text-shadow: 3px 3px 0 #fff, -3px -3px 0 #fff, 3px -3px 0 #fff, -3px 3px 0 #fff;
   }
   .logo-9{
      position:relative;
   } 
   /*side*/
   .bar {
      float: left;
      width: 25px;
      height: 3px;
      border-radius: 4px;
      background-color: #4b9cdb;
   }
   .load-10 .bar {
      animation: loadingJ 2s cubic-bezier(0.17, 0.37, 0.43, 0.67) infinite;
   }
   @keyframes loadingJ {
   0%, 100% {
         transform: translate(0, 0);
      }
      50% {
         transform: translate(80px, 0);
         background-color: #f5634a;
         width: 110px;
      }
   }
   .search {
position: relative;
color: #aaa;
font-size: 16px;
}

.search {display: inline-block;}

.search input {
  width: 260px;
  height: 34px;
  background: #fff;
  border: 1px solid #fff;
  border-radius: 5px;
  box-shadow: 0 0 3px #ccc, 0 10px 15px #fff inset;
  color: #000;
}

.search input { text-indent: 32px;}

.search .fa-search { 
  position: absolute;
  top: 8px;
  left: 10px;
}

.search .fa-search {left: auto; right: 10px;}
</style>

<div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
         <figure class="one">
         <img src="<?= base_url()  ?>asset/images/sales.png"  class="headshotphoto" style="height:50px;" />
      </div>
      <div class="header-title">
         <div class="logo-holder logo-9">
            <h1>  <?= display('manage_invoice') ?></h1>
         </div>
         <small><?= ""; ?></small>
         <ol class="breadcrumb"   style=" border: 3px solid #d7d4d6;"   >
            <li><a href="<?php   echo base_url(); ?>"><i class="pe-7s-home"></i> <?= display('home') ?></a></li>
            <li><a href="#"><?= display('invoice') ?></a></li>
            <li class="active" style="color:orange;"><?= display('manage_invoice') ?></li>
            <div class="load-wrapp">
               <div class="load-10">
                  <div class="bar"></div>
               </div>
            </div>
         </ol>
      </div>
   </section>

   <section class="content">
      <!-- Alert Message -->
      <?php
         $message = $this->session->userdata('show');
         if (isset($message)) { ?>
      <div class="alert alert-info alert-dismissable" style="background-color:#38469f;color:white;font-weight:bold;">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?= $message; ?>                    
      </div>
      <?php
         // $this->session->unset_userdata('message');
         }
         $error_message = $this->session->userdata('error_message');
         if (isset($error_message)) { ?>

      <div class="alert alert-danger alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?= $error_message ?>                    
      </div>
      <?php $this->session->unset_userdata('error_message'); } ?>

      <div class="panel panel-bd lobidrag" >
         <div class="panel-heading" style="height: 60px; border: 3px solid #d7d4d6;">
            <div class="row">
               <div class="col-md-6">
                  <div class="row">
                     <div class="col-md-2">
                        <?php 
                           foreach($this->session->userdata('perm_data') as $test) {
                              $split = explode('-', $test);
                              if (trim($split[0]) == 'sales' && $_SESSION['u_type'] == 3 && trim($split[1]) == '1000') { ?>
                           <a href="<?= base_url('Cinvoice') ?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal mobile_para" style="height:fit-content;"><i class="far fa-file-alt"> </i> <?= display('Create Sale') ?> </a>
                           <?php break; } }
                              if ($_SESSION['u_type'] == 2) { ?>
                           <a href="<?= base_url('Cinvoice') ?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal mobile_para" style="height:fit-content;"><i class="far fa-file-alt"> </i> <?= display('Create Sale') ?> </a>
                        <?php } ?>
                     </div>

                     <div class="col-md-10">
                        <div class="search">
                           <span class="fa fa-search"></span>
                           <input class="daterangepicker_field dateSearch" name="daterangepicker-field" autocomplete="off" id="daterangepicker-field" placeholder="Search...">
                        </div>
                        <input type="button" id="searchtrans" name="btnSave" class="btn btnclr" value="Search" style="margin-bottom: 5px; margin-left: 10px;"/>
                     </div>
                  </div>
               </div>

               <div class="col-md-6" style="float:right;">
                  <a onclick="reload();" id="removeButton"> <i class="fa fa-refresh fa-spin" style="font-size:25px;float:right;" aria-hidden="true"></i> </a>
                  <i class="fa fa-gear fa-spin" aria-hidden="true" id="myBtn" style="margin-right:20px;font-size:25px;float:right;" onClick="columnSwitchMODAL()"></i>
               </div>

            </div>
         </div>

      <!-- Manage Invoice report -->
      <div class="row">
         <div class="col-sm-12">
            <div class="error_display mb-2"></div>
               <div class="panel panel-bd lobidrag">
                  <div class="panel-body" style="border: 3px solid #D7D4D6;">
                     <table class="table table-bordered" cellspacing="0" width="100%" id="ProfarmaInvListSales">
                        <thead>
                           <tr class="btnclr">
                              <th class="text-center"><?= ('S.No') ?></th>
                              <th class="text-center"><?= ('Invoice No') ?></th>
                              <th class="text-center"><?= ('Customer Name') ?></th>
                              <th class="text-center"><?= ('Sales Invoice Date') ?></th>
                              <th class="text-center"><?= ('Total Amount') ?></th>
                              <th class="text-center"><?= ('Amount Paid') ?></th>
                              <th class="text-center"><?= ('Action') ?></th>
                           </tr>
                        </thead>
                        <tfoot>
                            <tr class="btnclr">
                                <th colspan="4" style="text-align:right">Total:</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th></th>
                            </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>     
            </div>
         </div>
   </section>
   <input type="hidden" value="Sale/New Sale" id="url"/>
   <script src="<?= base_url()?>assets/js/jquery.bootgrid.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.0-alpha.1/jspdf.plugin.autotable.js"></script>
   <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js'></script>
   <script src='https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-debug.js'></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
   <script  src="<?= base_url() ?>my-assets/js/script.js"></script> 
   <script src="<?= base_url()?>assets/js/jquery.bootgrid.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.0-alpha.1/jspdf.plugin.autotable.js"></script>

   <!-- The Modal Column Switch -->
   <div id="myModal_colSwitch" name="mysalesName" class="modal_colSwitch" >
      <div class="modal-content_colSwitch" style="width:45%;height:35%;">
      <span class="close_colSwitch">&times;</span>
         <div class="col-sm-2"></div>
            <div class="col-sm-4"><br><br>
               <div class="form-group row">
                  <input type="checkbox" data-control-column="1" class="1" value="1" />&nbsp; <span style="position: relative; "><?= display('ID') ?></span><br><br>
                  <input type="checkbox"  data-control-column="3" class="3" value="3"/>&nbsp;<span style="position: relative; "><?= ('Phone No')?></span><br><br>
                  <input type="checkbox"  data-control-column="7" class="7" value="7"/>&nbsp;<span style="position: relative; "><?= display('Grand Total')?></span><br><br>
                  <input type="checkbox"  data-control-column="13" class="13" value="13"/>&nbsp;<span style="position: relative; "><?= display('Payment type')?></span><br><br>
                  <input type="checkbox"  data-control-column="14" class="14" value="14"/>&nbsp;<span style="position: relative; "><?= display('Invoice ID')?></span><br><br>
               </div>  
            </div>
            <div class="col-sm-3"><br><br>
               <div class="form-group row">
                  <!--<input type="checkbox"  data-control-column="10"  class="10"     value="10"/>&nbsp;<span style="position: relative; top: 4px;"><?= display('Total Amount')?></span><br><br>-->
                  <input type="checkbox"  data-control-column="17"  class="17"   value="17"/>&nbsp;<span style="position: relative; "><?= display('Billing Address')?></span><br><br>
                  <input type="checkbox"  data-control-column="19"  class="19" value="19"/>&nbsp;<span style="position: relative; "><?= display('Tax Details')?></span><br><br>
                  <input type="checkbox"  data-control-column="22"  class="22" value="22"/>&nbsp;<span style="position: relative; "><?= display('Balance Amount')?></span><br><br>
                  <input type="checkbox"  data-control-column="23"  class="23" value="23"/>&nbsp;<span style="position: relative;"><?= display('Remarks/Conditions')?></span><br><br>    
                  <input type="checkbox"  data-control-column="24"  class="24" value="24"/>&nbsp;<span style="position: relative;"><?= display('Account Details')?></span><br>
               </div>
            </div>
         </div>
      </div>
   </section>
   </div> 
   </div>
   </div>
   </div>
</div>
</div>
</div>
</div>
<input type="hidden" id="total_invoice" value="<?= $total_invoice;?>" name="">
<input type="hidden" id="currency" value="{currency}" name="">
<input type="hidden" id="base_url" value="<?= base_url();  ?>">
</div>
</div>
</section>
<input type ="hidden" name="csrf_test_name" id="csrf_test_name" value="<?= $this->security->get_csrf_hash();?>">
</div>

<!-- Manage Invoice End -->
<!-- <script type="text/javascript" src="<?= base_url()?>my-assets/js/profarma.js"></script> -->
<script>
$(document).on('keyup', '#filterinput', function(){
   var value = $(this).val().toLowerCase();
   var filter=$("#filterby").val();
   $("#ProfarmaInvListSales tr:not(:eq(0))").filter(function() {
      $(this).toggle($(this).find("td."+filter).text().toLowerCase().indexOf(value) > -1)
   });
});
</script>

<script>
   function reload(){
      location.reload();
   }
   
   $editor = $('#submit'),
   $editor.on('click', function(e) {
      if (this.checkValidity && !this.checkValidity()) return;
         e.preventDefault();
         var yourArray = [];
         //loop through all checkboxes which is checked
         $('.modal-content_colSwitch input[type=checkbox]:not(:checked)').each(function() {
         yourArray.push($(this).val());//push value in array
      });
      
      values = { extralist_text: yourArray };

      var json=values;
      var data = {
         page:$('#url').val(),
         content: yourArray
      };
      var csrfName = "<?= $this->security->get_csrf_token_name();?>";
      var csrfHash = "<?= $this->security->get_csrf_hash();?>";
      data[csrfName] = csrfHash;

   $.ajax({  
       url: "<?= base_url('Cinvoice/setting');?>",
       type: "POST",
       data: data,
       dataType: "json", 
       success: function(data) {
           if(data) {
            //   console.log(data);
           }
       }  
   });
});


$( document ).ready(function() {
   var page = $('#url').val();
   page = page.split('/');
   var data = {
      'menu':page[0],
      'submenu':page[1]
   };
   var csrfName = "<?= $this->security->get_csrf_token_name();?>";
   var csrfHash = "<?= $this->security->get_csrf_hash();?>";
   data[csrfName] = csrfHash;

   $.ajax({ 
      url:"<?= base_url('Cinvoice/get_setting'); ?>",
      type: "POST", 
      data: data,
      dataType: "json", 
      success: function(data) {
         var menu=data.menu;
         var submenu=data.submenu;
         if(menu == 'Sale' && submenu == 'New Sale') {
            var s = data.setting;
            s = JSON.parse(s);
            // console.log(s);
            for (var i = 0; i < s.length; i++) {
               //  console.log(s[i]);
               $('td.'+s[i]).hide(); // hide the column header th
               $('th.'+s[i]).hide();
               $('tr').each(function(){
                  $(this).find('td:eq('+$('td.'+s[i]).index()+')').hide();
               });
            }
            for (var i = 0; i < s.length; i++) {
               if( $('.'+s[i]))
               $('.'+s[i]).prop('checked', false); //check the box from the array, note: you need to add a class to your checkbox group to only select the checkboxes, right now it selects all input elements that have the values in the array 
            }  
         }
      }, error: function(res) {
         console.log(res);
      }
   });

});
   
   
$(document).ready(function() {
   //   $('#emailmodal').modal('show');
   var localStorageName = "mysalesName"; // Set your desired localStorage name

   $("input:checkbox").each(function() {
      var columnValue = $(this).attr("value");
      var columnSelector = ".table ." + columnValue;
      //   var isChecked = localStorage.getItem(columnSelector) === "true";
      var isChecked = localStorage.getItem(localStorageName  + columnSelector) === "true";

      // Check if the checkbox is checked or the stored state is true
      if (isChecked || $(this).prop("checked")) {
         $(columnSelector).show(); // Show the column
      } else {
         $(columnSelector).hide(); // Hide the column
      }
      $(this).prop("checked", isChecked);
   });

   // When a checkbox is clicked, update localStorage and toggle column visibility
   $("input:checkbox").click(function() {
      var columnValue = $(this).attr("value");
      var columnSelector = ".table ." + columnValue; // Corrected class name construction
      var isChecked = $(this).is(":checked");
   //   localStorage.setItem(columnSelector, isChecked); // Store checkbox state in localStorage
         
      localStorage.setItem(localStorageName + columnSelector, isChecked); // Store checkbox state in localStorage
      // Toggle column visibility based on the checkbox state
      if (isChecked) {
         $(columnSelector).show(); // Show the column
      } else {
         $(columnSelector).hide(); // Hide the column
      }
   });
});
   
   
///************** */
$("#search").on("keyup", function() {
   var value = $(this).val().toLowerCase();
   $("#ProfarmaInvListSales tr:not(:eq(0))").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
   });
});

var filters = {
   user: null,
   status: null,
   milestone: null,
   priority: null,
   tags: null
};

function updateFilters() {
   $('.task-list-row').hide().filter(function() {
      var
      self = $(this),
      result = true; // not guilty until proven guilty
      
      Object.keys(filters).forEach(function (filter) {
         if (filters[filter] && (filters[filter] != 'None') && (filters[filter] != 'Any')) {
            result = result && filters[filter] == self.data(filter);
         }
      });

      return result;
   }).show();
}

function changeFilter(filterName) {
   filters[filterName] = this.value;
   updateFilters();
}
   
   // Assigned User Dropdown Filter
   $('#pname-filter').on('change', function() {
      changeFilter.call(this, 'pname');
   });
   
   // Task Status Dropdown Filter
   $('#model-filter').on('change', function() {
      changeFilter.call(this, 'model');
   });
   
   // Task Milestone Dropdown Filter
   $('#category-filter').on('change', function() {
      changeFilter.call(this, 'category');
   });
   
   // Task Priority Dropdown Filter
   $('#unit-filter').on('change', function() {
      changeFilter.call(this, 'unit');
   });
   
   // Task Tags Dropdown Filter
   $('#supplier-filter').on('change', function() {
      changeFilter.call(this, 'supplier');
   });

   
   function search() {
      var input_pname,
      input_model,
      input_category,
      input_unit,
      input_supplier,
      filter_pname,filter_model,filter_category,filter_unit,filter_supplier,
      table,
      tr,
      td,
      i,
      
      input_pname = document.getElementById("myInput1");
      input_model = document.getElementById("myInput2");
      input_category = document.getElementById("myInput3");
      input_unit = document.getElementById("myInput4");
      input_supplier = document.getElementById("myInput5");
      
      filter_pname = input_pname.value.toUpperCase();    
      filter_model = input_model.value.toUpperCase();
      filter_category = input_category.value.toUpperCase();    
      filter_unit = input_unit.value.toUpperCase();
      filter_supplier = input_supplier.value.toUpperCase();
      
      table = document.getElementById("ProfarmaInvListSales");
      tr = table.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
         td = tr[i].getElementsByTagName("td")[1];
         td1 = tr[i].getElementsByTagName("td")[2];
         td2 = tr[i].getElementsByTagName("td")[14];
         td3 = tr[i].getElementsByTagName("td")[3];
         td4 = tr[i].getElementsByTagName("td")[11];
         
         if (td && td1 && td2 && td3 && td4) {
            input_pname = (td.textContent || td.innerText).toUpperCase();
            input_model = (td1.textContent || td1.innerText).toUpperCase();
            input_category = (td2.textContent || td2.innerText).toUpperCase();
            input_unit = (td3.textContent || td3.innerText).toUpperCase();
            input_supplier = (td4.textContent || td4.innerText).toUpperCase();
            if (
            input_pname.indexOf(filter_pname) > -1 &&
            input_model.indexOf(filter_model) > -1 &&
            input_category.indexOf(filter_category) > -1 &&
            input_unit.indexOf(filter_unit) > -1 &&
            input_supplier.indexOf(filter_supplier) > -1
            ) {
               tr[i].style.display = "";
            } else {
               tr[i].style.display = "none";
            }
         }
      }
   }
   
   $(document).ready(function() { $('#search_area').hide(); });
   $('#s_icon').click(function() { $('#search_area').toggle(); });       
</script>

<script type="text/javascript">
   //  var csrfName = $('.txt_csrfname').attr('name'); 
   //  var csrfHash = $('.txt_csrfname').val();
   var csrfName = "<?= $this->security->get_csrf_token_name();?>";
   var csrfHash = "<?= $this->security->get_csrf_hash();?>";

   var base_url=$('#base_url').val();
   $('.getinvoice_id').on('click', function() {

      var rowinvoiceId = $(this).closest('tr').find('#rowinvoice_id').val();
      var pathname = window.location.pathname;
      var str = pathname.substring(pathname.lastIndexOf("/")+1);
      // alert(str)
      $('#url_id').val(str); 
      $.ajax({
         url:"<?= base_url('Cinvoice/Get_attachments'); ?>",
         type: 'POST',
         dataType: 'json',
         data: {[csrfName]: csrfHash,rowinvoiceId:rowinvoiceId,str:str},
         success: function(data){

         $('#attach').html("");
         for(var i = 0; i < data.length; i++) {
            // console.log(data[i]['files']);
            if(data[i]['files']){
               $('#attach').append('<input type="hidden" value="'+str+'" id="test"/><input type="hidden" name="files[]" class="upload" id="attachment" style="visibility: hidden; position: absolute;" multiple/> <a href='+base_url+'uploads/'+encodeURI(data[i]["files"])+' class="file-block" target=_blank><span class="file-delete"><span><i class="fa fa-trash-o"></i></span></span>'+encodeURI(data[i]["files"])+'</a>');
            }else{
               $('#attach').html("No attachment Found");
            }
         }
         }
      });
        
    });
   

$(document).ready(function() {
   // Function to store the visibility state of rows in localStorage
   function storeVisibilityState() {
      var visibilityStates = {};
      $("#ProfarmaInvListSales tr").each(function(index, element) {
            var row = $(element);
            var rowID = index;
            var isVisible = row.is(':visible');
            visibilityStates[rowID] = isVisible;
      });
      // Store the visibility states in localStorage
      localStorage.setItem("visibilityStates", JSON.stringify(visibilityStates));
   }
   
   // Apply the stored visibility state on page load
   function applyVisibilityState() {
      var storedVisibilityStates = JSON.parse(localStorage.getItem("visibilityStates")) || {};
      $("#ProfarmaInvListSales tr").each(function(index, element) {
         var row = $(element);
         var rowID = index;
         if (storedVisibilityStates.hasOwnProperty(rowID) && !storedVisibilityStates[rowID]) {
               row.hide();
         } else {
               row.show();
         }
      });
   }
   
   // Event listener for row clicks to toggle row visibility
   $(".invoice_edit").on('click', function() {
      var row = $(this);
      storeVisibilityState(); // Store the updated visibility state
   });
   
   // Event listener for submitting edited data
   $(".final_submit").on('submit', function(event) {
      event.preventDefault();
      var editedData = $("#editedData").val();
      // Store the edited data in localStorage
      localStorage.setItem("editedData", editedData);
   });
   
   // Display the stored edited data
   function displayEditedData() {
      var editedData = localStorage.getItem("editedData");
      if (editedData) {
         $("#displayEditedData").text(editedData);
      }
   }

   applyVisibilityState(); // Apply the stored visibility state on page load
   displayEditedData(); // Display the stored edited data on page load
});
   
        
function removeItemFromLocalStorage() {
      
   const keyToRemove = 'visibilityStates';
   // Check if the item exists in localStorage
   if (localStorage.getItem(keyToRemove)) {
      // Remove the item from localStorage
      localStorage.removeItem(keyToRemove);
      console.log("Item removed from localStorage");
   } else {
      console.log("Item not found in localStorage");
   }
}
        
   // Add a click event listener to the button
   const removeButton = document.getElementById('removeButton');
   removeButton.addEventListener('click', removeItemFromLocalStorage);
</script>

<!-- <script src='<?= base_url();?>assets/js/moment.min.js'></script> -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-debug.js'></script>
<script  src="<?= base_url() ?>assets/js/scripts.js"></script> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
var salesDataTable;
$(document).ready(function() {
$(".sidebar-mini").addClass('sidebar-collapse') ;
    if ($.fn.DataTable.isDataTable('#ProfarmaInvListSales')) {
      $('#ProfarmaInvListSales').DataTable().clear().destroy();
    }
    var csrfName = "<?= $this->security->get_csrf_token_name();?>";
    var csrfHash = "<?= $this->security->get_csrf_hash();?>";

    salesDataTable = $('#ProfarmaInvListSales').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        "ajax": {
            "url": "<?= base_url('Cinvoice/salesIndexData'); ?>",
            "type": "POST",
            "data": function(d) {
                d['<?= $this->security->get_csrf_token_name(); ?>'] =
                    '<?= $this->security->get_csrf_hash(); ?>';
                d.employee_name = $('.employee_name').val(); 
                d['date_search'] = $('#daterangepicker-field').val();
            },
            "dataSrc": function(json) {
               csrfHash = json[
               '<?= $this->security->get_csrf_token_name(); ?>'];
               return json.data;
            }
        },
         "columns": [
         { "data": "sno" },
         { "data": "invoice" },
         { "data": "cust_name" },
         { "data": "sale_inv_date" },
         { "data": "tot_amt" },
         { "data": "amt_paid" },
         { "data": "action" },
         ],
        "columnDefs": [{
            "orderable": false,
            "targets": [0, 6],
            searchBuilder: {
                defaultCondition: '='
            },
            "initComplete": function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $(
                            '<select><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d +
                            '">' + d + '</option>')
                    });
                });
            },
        }],
        "pageLength": 10,
        "colReorder": true,
        "stateSave": true,
        "footerCallback": function(row, data, start, end, display) {
         var api = this.api();
         function calculateTotal(columnIndex) {
               var total = 0;
               api.column(columnIndex, { page: 'current' }).data().each(function(value) {
               if (value && typeof value === 'string') {
                  total += (parseFloat(value.replace(/[^0-9.-]/g, '')) || 0); 
               }
               });
               return total;
         }
         var totalAmount = calculateTotal(4);
         var amountPaid = calculateTotal(5);
         
         $(api.column(4).footer()).html('$'+totalAmount.toFixed(2));
         $(api.column(5).footer()).html('$'+amountPaid.toFixed(2));
        },
        "stateSaveCallback": function(settings, data) {
            localStorage.setItem('quotation', JSON.stringify(data));
        },
        "stateLoadCallback": function(settings) {
            var savedState = localStorage.getItem('quotation');
            return savedState ? JSON.parse(savedState) : null;
        },
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "buttons": [{
                "extend": "copy",
                "className": "btn-sm",
                "exportOptions": {
                    "columns": ':visible'
                }
            },
            {
                "extend": "csv",
                "title": "Report",
                "className": "btn-sm",
                "exportOptions": {
                    "columns": ':visible'
                }
            },
            {
               "extend": "pdf",
               "title": "Report",
               "className": "btn-sm",
               "exportOptions": {
                  "columns": ':visible'
               }
            },
            {
               "extend": "print",
               "className": "btn-sm",
               "exportOptions": {
                  "columns": ':visible'
               },
               "customize": function(win) {
                  $(win.document.body)
                     .css('font-size', '10pt')
                     .prepend(
                           '<div style="text-align:center;"><h3>Manage Quotation</h3></div>'
                     )
                     .append(
                           '<div style="text-align:center;"><h4>amoriotech.com</h4></div>'
                     );
                  $(win.document.body).find('table')
                     .addClass('compact')
                     .css('font-size', 'inherit');
                  var rows = $(win.document.body).find('table tbody tr');
                  rows.each(function() {
                     if ($(this).find('td').length === 0) {
                           $(this).remove();
                     }
                  });
                  $(win.document.body).find('div:last-child')
                     .css('page-break-after', 'auto');
                  $(win.document.body)
                     .css('margin', '0')
                     .css('padding', '0');
               }
            },
            {
               "extend": "colvis",
               "className": "btn-sm"
            }
        ]
    });
    

    $('#searchtrans').on('click', function() {
        var dateValue = $('.dateSearch').val();

        if (dateValue === '') {
            toastr.error('Please select a date before searching.', 'Error');
            $('.dateSearch').addClass('error-border');
            return; 
        }
        toastr.clear();
        $('.dateSearch').removeClass('error-border');
        salesDataTable.draw();
    });
});

</script>


<style>
   #numrows{
   width: 75px !important;
   }
   /* pagecontroller pagecontroller-n */
   .pagecontroller {
   margin: 5px;
   }
   /* .filip-horizontal:hover{
   background-color: crimson;
   transition: all 1s;
   -webkit-transform: rotateY(-360deg);
   -ms-transform: rotateY(-360deg);
   transform: rotateY(-360deg);
   } */
   .ads{
   max-width: 0px !important;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   }
   @media (max-width:1024px){
   #insert_sale{
   display: flex !important;
   justify-content: flex-end !important;
   }
   .mob_topview{
   position: relative;
   right: 33px;
   }
   #removeButton{
   position: absolute;
   left: 145px;
   }
   .fa.fa-gear::before {
   position: absolute;
   left: 111px;
   }
 
   .mob_search{
   position: absolute;
   left: 108px;
   font-size: 11px;
   }
   .mobile_para{
   font-size: 11px !important; 
   }
   }
</style>