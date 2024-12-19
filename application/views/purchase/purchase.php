<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/calanderstyle.css">
<div class="content-wrapper">
   <section class="content-header" style="height: 60px;">
      <div class="header-icon">
         <figure class="one">
            <img src="<?php echo base_url() ?>asset/images/expenses.png" class="headshotphoto" style="height:50px;" />
         </figure>
      </div>
      <div class="header-title">
         <div class="logo-holder logo-9">
         <h1><?php echo display('manage_purchase') ?></h1>
         </div>
            <ol class="breadcrumb" style=" border: 3px solid #d7d4d6;" >
               <li><a href="<?php echo base_url()?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
               <li><a href="#"><?php echo display('purchase') ?></a></li>
               <li class="active" style="color:orange"><?php echo display('manage_purchase') ?></li>
            <div class="load-wrapp">
               <div class="load-10">
                  <div class="bar"></div>
               </div>
            </div>
         </ol>
      </div>
   </section>
   <section class="content">
      <?php
         $message = $this->session->userdata('message');
         if (isset($message)) { 
      ?>
      <div class="alert alert-info alert-dismissable" style="background-color:#38469f;color:white;font-weight:bold;">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?php echo $message ?>                    
      </div>
      <?php $this->session->unset_userdata('message'); }
         $error_message = $this->session->userdata('error_message');
         if (isset($error_message)) {
      ?>
      <div class="alert alert-danger alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?php echo $error_message ?>                    
      </div>
      <?php $this->session->unset_userdata('error_message');}?>
      <div class="panel panel-bd lobidrag">
         <div class="panel-heading" style="height: 60px;border: 3px solid #D7D4D6;">
            <div class="col-sm-12">
            <a href="<?php echo base_url('Cpurchase') ?>" class="btnclr btn btn-default dropdown-toggle boxes filip-horizontal"   style="height:fit-content;"  ><i class="far fa-file-alt"> </i> <?php echo display('Create Expense') ?> </a>
                <div class="col-md-2 col-sm-3" style="display: flex; align-items: center;">
                    <label>Invoice No</label>&nbsp;&nbsp;&nbsp;
                    <select id="customer-name-filter" name="chalanno" class="form-control chalanno">
                        <option value="All">All</option>
                        <?php
                          foreach ($expenses as $expense) {
                          ?>
                        <option value="<?php echo $expense['chalan_no']; ?>"><?php echo $expense['chalan_no']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-3" style="display: flex; align-items: center;">
                    <label>Vendor Type</label>&nbsp;&nbsp;&nbsp;
                    <select  name="vendorType" class="form-control vendorType">
                        <option value="All">All</option>
                        <option value="Service Provider">Service Provider</option>
                        <option value="Product Supplier">Product Supplier</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-3" style="display: flex; align-items: center;">
                    <label>Vendor</label>&nbsp;&nbsp;&nbsp;
                    <select  name="vendor" class="form-control vendor">
                        <option value="All">All</option>
                        <?php
                          foreach ($expenses as $expense) {
                          ?>
                        <option value="<?php echo $expense['supplier_id']; ?>"><?php echo $expense['supplier_id']; ?></option>
                        <?php } ?>
                    </select>
                </div>              
                <div class="col-md-3 col-sm-3">
                    <div class="search">
                      <span class="fa fa-search"></span>
                      <input class="daterangepicker_field dateSearch" name="daterangepicker-field" autocomplete="off" id="daterangepicker-field" placeholder="Search...">
                    </div>
                    <input type="button" id="searchtrans" name="btnSave" class="btn btnclr" value="Search" style="margin-bottom: 5px; margin-left: 10px;"/>
                </div>
            </div> 

         </div>
         <div class="row">
            <div class="col-sm-12">
               <div class="error_display mb-2"></div>
               <div class="panel panel-bd lobidrag">
                  <div class="panel-body" style="border: 3px solid #D7D4D6;">
                     <table class="table table-bordered" cellspacing="0" width="100%" id="expensedata_list">
                        <thead>
                           <tr class="btnclr">
                              <th class="text-center"><?php echo display('ID')?></th>
                              <th class="text-center"><?php echo ('Invoice No')?></th>
                              <th class="text-center"><?php echo ('Name') ?></th>
                              <th class="text-center"><?php echo display('purchase_date')?></th>
                              <th class="text-center"><?php echo ('Vendor Type')?></th>
                              <th class="text-center"><?php echo ('Grand Total')?></th>
                              <th class="text-center"><?php echo display('Amount Paid')?></th>
                              <th class="text-center"><?php echo display('Balance Amount')?></th>
                              <th class="text-center"><?php echo display('purchase_id')?></th>
                              <th class="text-center"><?php echo display('Payment Terms')?></th>
                              <th class="text-center"><?php echo ('Tax Details')?></th>
                              <th class="text-center"><?php echo display('Service Provider Address')?></th>
                              <th class="text-center"><?php echo ('Phone Number')?></th>
                              <th class="text-center"><?php echo display('Account Category Name')?></th>
                              <th class="text-center"><?php echo display('Account Sub category')?></th>
                              <th class="text-center"><?php echo display('Account Category')?></th>
                              <th class="text-center"><?php echo display('action')?></th>
                           </tr>
                        </thead>
                       <!--  <tfoot>
                            <tr class="btnclr">
                                <th colspan="6" style="text-align:right">Total:</th>
                                <th class="text-center"></th>
                            </tr>
                        </tfoot> -->
                     </table>
                  </div>
               </div>     
            </div>
         </div>
      </div>
   </section>
</div>


<script src='<?php echo base_url();?>assets/js/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-debug.js'></script>
<script  src="<?php echo base_url() ?>assets/js/scripts.js"></script> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
var expenseDataTable;
$(document).ready(function() {
$(".sidebar-mini").addClass('sidebar-collapse') ;
    if ($.fn.DataTable.isDataTable('#expensedata_list')) {
        $('#expensedata_list').DataTable().clear().destroy();
    }
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    expenseDataTable = $('#expensedata_list').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        "ajax": {
            "url": "<?php echo base_url('Cpurchase/expenseRetrieveData'); ?>",
            "type": "POST",
            "data": function(d) {
                d['<?php echo $this->security->get_csrf_token_name(); ?>'] =
                    '<?php echo $this->security->get_csrf_hash(); ?>';
                d.chalanno = $('.chalanno').val(); 
                d.vendortype = $('.vendorType').val(); 
                d.vendor = $('.vendor').val(); 
                d['federal_date_search'] = $('#daterangepicker-field').val();
            },
            "dataSrc": function(json) {
               csrfHash = json[
                    '<?php echo $this->security->get_csrf_token_name(); ?>'];
                return json.data;
            }
        },
         "columns": [
         { "data": "id" },
         { "data": "chalan_no" },
         { "data": "supplier_id" },
         { "data": "purchase_date" },
         { "data": "vtype" },
         { "data": "grand_total_amount" },
         { "data": "paid_amount" },
         { "data": "balance" },
         { "data": "purchase_id" },
         { "data": "payment_terms" },
         { "data": "tax_detail" },
         { "data": "sp_address" },
         { "data": "phone_num" },
         { "data": "account_category" },
         { "data": "amount_pay_usd" },
         { "data": "acc_cat" },

         { "data": "action" },
         ],
        "columnDefs": [{
            "orderable": false,
            "targets": [0, 16],
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
                            var val = $.fn.dataTable.util
                                .escapeRegex(
                                    $(this).val()
                                );
                            column.search(val ? '^' + val + '$' :
                                '', true, false).draw();
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
        "stateSaveCallback": function(settings, data) {
            localStorage.setItem('expense', JSON.stringify(data));
        },
        "stateLoadCallback": function(settings) {
            var savedState = localStorage.getItem('expense');
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
                            '<div style="text-align:center;"><h3>Manage Expense</h3></div>'
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
    
    $('.chalanno').on('change', function() {
        expenseDataTable.ajax.reload();
    });

    $('.vendorType').on('change', function() {
        expenseDataTable.ajax.reload();
    });

    $('.vendor').on('change', function() {
        expenseDataTable.ajax.reload();
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
        expenseDataTable.draw();
    });
});

</script>

<style type="text/css">
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

.btnclr{
    background-color: #424f5c;
    color: #fff;
}

.select2-container{
    display: none !important;
}
.form-control{
    width: 40% !important;
}

.table.dataTable thead th{
    border-bottom: 1px solid #e1e6ef  !important;
}

.table.dataTable tfoot th{
    border-top: 1px solid #e1e6ef  !important;
}

tbody{
    text-align: center !important;
}

.error-border {
    border: 2px solid red;
}


</style>
