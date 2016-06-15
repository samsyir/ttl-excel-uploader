<?php
    set_time_limit(1000);
    $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.110.0.3)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=tos)))"; 
    $conn = ocilogon("MTOS","mtos1",$db); 
    
    if (!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    if(isset($_POST['txt-seq']))
    {
        session_start();
        $_SESSION["VES_ID"] = $_POST['txt-seq'];
        $_SESSION["VES_NAME"] = $_POST['txt-vessel'];       
    }
    else
    {
        $query_max_ves = oci_parse($conn, "SELECT VES_NAME, VES_ID  FROM VESSEL_VOYAGE WHERE VESSEL_HISTORY_YN = 'N' AND ARRIVAL_DATE = (SELECT MAX(ARRIVAL_DATE) FROM VESSEL_VOYAGE WHERE ARRIVAL_DATE < SYSDATE)"); 
        oci_execute($query_max_ves);
        session_start();
        while (($row = oci_fetch_array($query_max_ves, OCI_BOTH)) != false) 
        {
            $_SESSION["VES_ID"] = $row['VES_ID'];
            $_SESSION["VES_NAME"] = $row['VES_NAME'];
        }
    }


?>    
<html>
    <head>
        <meta http-equiv="refresh" content="120" >  
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Monitoring Kegiatan Bongkar Muat Curah  - PT. Terminal Teluk Lamong</title>
        
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="assets/css/dataTables.tableTools.css">
        <link rel="stylesheet" type="text/css" href="assets/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="assets/css/ui.progress-bar.css">
        <link rel="stylesheet" type="text/css" href="assets/css/custom.css">
        <link rel="stylesheet" type="text/css" href="assets/css/highslide.css">

        <script type="text/javascript" language="javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/modernizr.js"></script>
        <script>
            $(window).load(function() {
                $(".se-pre-con").fadeOut("slow");
            });
        </script>
        <script type="text/javascript" language="javascript" src="assets/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/dataTables.tableTools.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/jquery-ui.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/highcharts.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/highslide-full.min.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/highslide.config.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/drilldown.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/number_format.js"></script>
        <script type="text/javascript" language="javascript" src="assets/js/dataTables.fixedColumns.min.js"></script>
        <script type="text/javascript" charset="utf-8">         
            $(document).ready(function() {
                $('#tabel-get-data').DataTable( {
                    "dom": 'T<"clear">lfrtip',
                    "fixedHeader": true,
                    "bSort": false,
                    "bAutoWidth": true,
                    "iDisplayLength": 100,
                    "aaSorting": [ ],
                    "tableTools": {
                        "sSwfPath": "assets/swf/copy_csv_xls_pdf.swf"
                    },

                    "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
                    if(typeof(api) != 'undefined'){
                        var column = 6;
                    }
                    else{
                        var column = api.row(0).data().length;
                    }
                                        
                    var total = new Array();
                    total['total']= new Array();
                    var groupid = -1;
                    var subtotal = new Array();

                    api.column(0, {page:'current'} ).data().each( function ( group, i ) {     
                        if ( last !== group ) {
                            groupid++;
                            $(rows).eq( i ).before(
                                '<tr class="group"><td>'+group+'</td></tr>'
                            );
                            last = group;
                        }
                
                                
                        val = api.row(api.row($(rows).eq( i )).index()).data();      //current order index

                        $.each(val,function(index2,val2){
                                if (typeof subtotal[groupid] =='undefined'){
                                    subtotal[groupid] = new Array();
                                }
                                if (typeof subtotal[groupid][index2] =='undefined'){
                                    subtotal[groupid][index2] = 0;
                                }
                                if (typeof total['total'][index2] =='undefined'){ total['total'][index2] = 0; }
                                
                                value = Number(val2.replace(".","").replace(".","").replace(",","."));
                                subtotal[groupid][index2] += value;
                                total['total'][index2] += value;
                        });                          
                    });

                    $('tbody').find('.group').each(function (i,v) {
                        var rowCount = $(this).nextUntil('.group').length;
                        $(this).find('td:first').append($('<span />', { 'class': 'rowCount-grid' }).append($('<b />', { 'text': ' ('+rowCount+')' })));
                            var subtd = '';
                            for (var a=2;a<column;a++)
                            { 
                                subtd += '<td>'+'&nbsp;'+'</td>';
                                if (a == 5) {
                                    subtd += '<td style="text-align:right;">'+number_format(subtotal[i][a], 0, ',', '.')+'</td>';
                                };
                            }
                            $(this).append(subtd);
                        }); 
                    }});
 
            // Collapse / Expand Click Groups
            $('#tabel-get-data').on( 'click', 'tr.group', function () {
                var rowsCollapse = $(this).nextUntil('.group');
                $(rowsCollapse).toggleClass('hidden');
            });

            $('#tabel-get-tonase').dataTable( {
                    "dom": 'T<"clear">lfrtip',
                    "bAutoWidth": true,
                    "iDisplayLength": 10,
                    "aaSorting": [ [0,'desc'] ],
                    "tableTools": {
                "sSwfPath": "assets/swf/copy_csv_xls_pdf.swf"
                }
            });
                $('#tabel-get-summary').dataTable( {
                    "dom": 'T<"clear">lfrtip',
                    "bAutoWidth": true,
                    "iDisplayLength": 10,
                    "aaSorting": [ [0,'desc'] ],
                    "tableTools": {
                "sSwfPath": "assets/swf/copy_csv_xls_pdf.swf"
                }   
            });
        });

    </script>
    
    </head>
    <body style="padding-top:0px; font-family:Verdana, Geneva, sans-serif;">
    <div class="se-pre-con"></div>
    <div style="background-color:#669933; height:17px;"></div>
    <div class="starter-template" style="font-weight:1300px; background-color:#fff; margin-top:5px; padding-bottom:5px; margin-bottom:15px; padding-left:110px; 
    -webkit-box-shadow: 0 7px 6px -6px black;
       -moz-box-shadow: 0 7px 6px -6px black;
            box-shadow: 0 7px 6px -6px black;">
        <h3 style="font-weight:bolder; font-family:Verdana, Geneva, sans-serif; color:#006699;">
            <img src="assets/images/logo.jpg" style="width:150px; padding-right:20px; " />Monitoring Kegiatan Bongkar Muat Curah  - PT. Terminal Teluk Lamong</h3>
      </div>
    
    <div class="container">
        <form name="form-input" id="form-input" method="POST" enctype='multipart/form-data' action="index.php">
        <?php
            $query_ves_name = oci_parse($conn, "SELECT DISTINCT(VES_NAME) VES_NAME FROM VESSEL_VOYAGE WHERE VESSEL_HISTORY_YN = 'N' ORDER BY VES_NAME"); 
            oci_execute($query_ves_name);
        ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-2" style="vertical-align: middle;">
                <label>Pilih Vessel </label>
                </div>
                <div class="col-md-10">
                    <select class="form-control" name="txt-vessel" id="txt-vessel"> 
                        <option value="" selected disabled> -- Pilih vessel -- </option>
                        <?php
                            while (($row = oci_fetch_array($query_ves_name, OCI_BOTH)) != false) 
                            {   
                                echo "<option>".$row['VES_NAME']."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-2" style="vertical-align: middle;">
                <label>Sequence </label>
                </div>
                <div class="col-md-10">
                    <select class="form-control" name="txt-seq" id="txt-seq">
                        <option value="" selected disabled> -- Pilih vessel terlebih dahulu kemudian pilih sequence -- </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2" style="vertical-align: middle;"></div>
            <div class="col-md-10">
                <div class="btn-group">
                    <input type="submit" class="btn btn-primary" value="Update">
                </div>
            </div>
         </div>
         </form>

      <?php         
        $truck_no = array();
        $date_in = array();
        $gross_truck = array();
        $date_out = array();
        $gross_bruto = array();
        $gross_net = array();
        $palka = array();
        $full_name = array();
        $ves_name = array();
        $commodity_name = array();
        $i = 0;
        $ton_ves_name = array();
        $ton_palka = array();
        $tonase = array();
        $ton_commodity = array();
        $ton_gross_net = array();
        $j = 0;
        $sum_ves_name = array();
        $sum_tonase = array();
        $sum_gross_net = array();
        $k = 0;
        $l = 0;
        $date_in1 = array();
        $date_in2 = array();
        $nonops = array();
        $gsu1nonops = array();
        $gsu2nonops = array();
        $gsu1prod = array();
        $gsu2prod = array();
        $m = 0;
        $n = 0;
        $dated1 = array();
        $dated2 = array();
        $jam = array();
        $gsu1nethari = array();
        $gsu1netjam = array();
        $gsu2nethari = array();
        $gsu2netjam = array();                                  
        $drilldown_data = array();
        $getdrilldown_series = '';
        $keys = array();
        $getseries = array();
        $c = 0;
        $customer = array();
        $discharged = array();
        $ordered = array();

        $query_get_data = oci_parse($conn, "SELECT TRUNC(DATE_OUT) DATE_IN, SUM(GROSS_TRUCK) GROSS_TRUCK, SUM(GROSS_BRUTO) GROSS_BRUTO, SUM (GROSS_NET) GROSS_NET, PALKA, FULL_NAME, VES_NAME, COMMODITY_NAME FROM VIEW_MONITORING_CUKER WHERE VESSEL_ID = '".$_SESSION['VES_ID']."'GROUP BY TRUNC(DATE_OUT),PALKA,FULL_NAME,VES_NAME,COMMODITY_NAME ORDER BY TRUNC(DATE_OUT) DESC, PALKA ASC");
        oci_execute($query_get_data);

        $vessel_id = substr($_SESSION['VES_ID'],0,4).substr($_SESSION['VES_ID'],-3,3);
        $query_get_produksi = oci_parse($conn,"SELECT TO_DATE (TO_CHAR (DATE_IN, 'dd/mm/yyyy'), 'dd/mm/yyyy')
                       DATE_IN,
                    NVL (SUM (DECODE (equipment, 'GSU1', nonops)), 0) GSU1NONOPS,
                    NVL (SUM (DECODE (equipment, 'GSU1', nett)), 0) GSU1PROD,
                    NVL (SUM (DECODE (equipment, 'GSU2', nonops)), 0) GSU2NONOPS,
                    NVL (SUM (DECODE (equipment, 'GSU2', nett)), 0) GSU2PROD
               FROM v_prod_alat_curah
               where vess_id = '".$vessel_id."'
           GROUP BY TO_DATE (TO_CHAR (DATE_IN, 'dd/mm/yyyy'), 'dd/mm/yyyy')
           ORDER BY DATE_IN");
        oci_execute($query_get_produksi);

        $query_get_produksi_per_hari = oci_parse($conn, "SELECT DATED||' '||JAM DATED,
                   NVL (SUM (DECODE (trim(kd_alat), 'GSU1', net)), 0) GSU1,
                   NVL (SUM (DECODE (trim(kd_alat), 'GSU2', net)), 0) GSU2
            FROM v_prod_alat_per_jam
            WHERE vessel_id = '".$_SESSION['VES_ID']."'
            GROUP BY DATED,JAM
            ORDER BY DATED");
        oci_execute($query_get_produksi_per_hari);

        $query_get_produksi_per_jam = oci_parse($conn, "SELECT DATED,JAM,
               NVL (SUM (DECODE (trim(kd_alat), 'GSU1', net)), 0) GSU1,
               NVL (SUM (DECODE (trim(kd_alat), 'GSU2', net)), 0) GSU2
            FROM v_prod_alat_per_jam
            WHERE vessel_id = '".$_SESSION['VES_ID']."'
            GROUP BY DATED,JAM
            ORDER BY DATED");
        oci_execute($query_get_produksi_per_jam);

        $query_get_tonase = oci_parse($conn, "SELECT A.VES_NAME VES_NAME, A.PALKA PALKA, A.TONASE TONASE, A.VES_CODE, A.COMMODITY_NAME, NVL(B.GROSS_NET,0) GROSS_NET FROM (SELECT PALKA, TONASE, VES_NAME, VES_CODE, COMMODITY_NAME FROM VIEW_MON_TONASE_VESS) A LEFT OUTER JOIN (SELECT SUM(GROSS_NET) GROSS_NET, VES_NAME, VESSEL_ID, PALKA FROM VIEW_MONITORING_CUKER GROUP BY PALKA, VES_NAME, VESSEL_ID) B ON (A.PALKA = B.PALKA AND A.VES_NAME = B.VES_NAME) WHERE B.VESSEL_ID = '".$_SESSION['VES_ID']."' ORDER BY A.PALKA");
        oci_execute($query_get_tonase);

        $query_get_summary = oci_parse($conn, "SELECT A.VES_NAME VES_NAME, B.TONASE TONASE, A.GROSS_NET GROSS_NET FROM (SELECT SUM(GROSS_NET) GROSS_NET, VES_NAME, VESSEL_ID FROM VIEW_MONITORING_CUKER GROUP BY VES_NAME, VESSEL_ID) A, (SELECT SUM(TONASE) TONASE, VES_NAME FROM VIEW_MON_TONASE_VESS GROUP BY VES_NAME) B WHERE A.VES_NAME = B.VES_NAME AND A.VESSEL_ID = '".$_SESSION['VES_ID']."' ORDER BY A.VES_NAME");
        oci_execute($query_get_summary);

        $query_get_tonase_customer = oci_parse($conn, "select full_name, nvl(sum(GROSS_NET),0) DISCHARGED, nvl(ORDERED,0) ORDERED from view_monitoring_cuker a
            left outer join (select customer, sum(tonase) ordered from nonpk_pemilik_barang
            where ves_id = '".$_SESSION['VES_ID']."'
            group by customer) b
            on a.customer = b.customer
            where vessel_id = '".$_SESSION['VES_ID']."'
            group by full_name,ordered
            order by full_name");
        oci_execute($query_get_tonase_customer);


      
      while (($row = oci_fetch_array($query_get_data, OCI_BOTH)) != false) 
      {
          
          $date_in1[$i] = $row['DATE_IN'];
          $gross_truck[$i] = $row['GROSS_TRUCK'];
          $gross_bruto[$i] = $row['GROSS_BRUTO'];
          $gross_net[$i] = $row['GROSS_NET'];
          $palka[$i] = $row['PALKA'];
          $full_name[$i] = $row['FULL_NAME'];
          $ves_name[$i] = $row['VES_NAME'];
          $commodity_name[$i] = $row['COMMODITY_NAME'];

          $i+=1;
      }

      while (($row = oci_fetch_array($query_get_tonase, OCI_BOTH)) != false) 
      {
          $ton_ves_name[$j] = $row['VES_NAME'];
          $ton_palka[$j] = $row['PALKA'];
          $tonase[$j] = $row['TONASE'];
          $ton_commodity[$j] = $row['COMMODITY_NAME'];
          $ton_gross_net[$j] = $row['GROSS_NET'];
 
          $j+=1;
      }


      while (($row = oci_fetch_array($query_get_summary, OCI_BOTH)) != false) 
      {
          $sum_ves_name[$k] = $row['VES_NAME'];
          $sum_tonase[$k] = $row['TONASE'];
          $sum_gross_net[$k] = $row['GROSS_NET'];
 
          $k+=1;
      }

      while (($row = oci_fetch_array($query_get_produksi, OCI_BOTH)) != false) 
      {
          $date_in2[$l] =$row['DATE_IN'];
          $gsu1nonops[$l] = $row['GSU1NONOPS'];
          $gsu1prod[$l] = $row['GSU1PROD'];
          $gsu2nonops[$l] = $row['GSU2NONOPS'];
          $gsu2prod[$l] = $row['GSU2PROD'];
 
          $l+=1;
      }

      while (($row = oci_fetch_array($query_get_produksi_per_hari, OCI_BOTH)) != false)
      {
          $dated1[$m] = $row['DATED'];
          $gsu1nethari[$m] = $row['GSU1'];
          $gsu2nethari[$m] = $row['GSU2'];

          $m+=1;
      }

      while (($row = oci_fetch_array($query_get_produksi_per_jam, OCI_BOTH)) !=false) {
          $dated2[$n] = $row['DATED'];
          $jam[$n] = $row['JAM'];
          $gsu1netjam[$n] = $row['GSU1'];
          $gsu2netjam[$n] = $row['GSU2'];

          $n+=1;
      }

      while (($row = oci_fetch_array($query_get_tonase_customer, OCI_BOTH)) !=false) {
          $customer[$c] = $row['FULL_NAME'];
          $discharged[$c] = $row['DISCHARGED'];
          $ordered[$c] = $row['ORDERED'];

          $c+=1;
      }

    for ($z = 0; $z < $n; $z++) {
        $drilldown_series = array($dated2[$z] => array("['".$jam[$z]."',".$gsu1netjam[$z]."]"));
    };

    for ($p=0; $p<$m; $p++) {
        $keys = array_keys($drilldown_series,$dated1[$p]);
        $length = count($keys);
        for ($key= 0; $key< $length; $key++) {
            $getseries[] = $drilldown_series[$keys[$key]];
        };
        $getdrilldown_series = implode(", ", $getseries);
        $drilldown_data[] = "'".strftime("%#d %b %Y",strtotime($dated1[$p]))."':{ name:'".strftime("%#d %b %Y",strtotime($dated1[$p]))."',data:[".$getdrilldown_series.'] }';
    } ;
    ?>
      
     <div class="table-border">
    <div style="text-align:center; padding-top:5px; font-family:Verdana, Geneva, sans-serif;"><h3>Monitoring Total Vessel <?php echo ucwords(strtolower($_SESSION['VES_NAME'])); ?></h3></div>
      <table id="tabel-get-summary" class="table table-striped" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color:#008000;">
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Nama Vessel</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Total di Palka (Kg)</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Total Bongkar (Kg)</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Sisa (Kg)</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Progress</th>
            </tr>
        </thead>
        <tbody>
            <?php       
                for ($x=0; $x<$k; $x++)
                {
                    $progress = (($sum_gross_net[$x]/$sum_tonase[$x])*100);
                    if ($progress > 100) {
                        $progress = 100;
                    }
                echo "<tr>
                        <td>".$ton_ves_name[$x]."</td>
                        <td style='text-align:right;'>".number_format($sum_tonase[$x], 0, ',', '.')."</td>
                        <td style='text-align:right;'>".number_format($sum_gross_net[$x], 0, ',', '.')."</td>";     
                        if(($sum_tonase[$x]-$sum_gross_net[$x]) < 0)
                        {
                            echo "<td style='text-align:right;'>".number_format(($sum_tonase[$x]-$sum_gross_net[$x]), 0, ',', '.')."</td>";
                        }
                        else
                        {
                            echo "<td style='text-align:right;'>".number_format(($sum_tonase[$x]-$sum_gross_net[$x]), 0, ',', '.')."</td>";
                        }
                        
                        echo "
                        <td style='width:400px;'>
                            <div id='progress_bar' class='ui-progress-bar ui-container'>
                              <div class='ui-progress' style='width:".$progress."% '>
                                <span class='ui-label' style='display:display;'>Progress <b class='value'>".round($progress)."%</b></span>
                              </div>
                            </div>
                        </td>
                    </tr>
                    ";              
                }
            ?>
        </tbody>
      </table>
    </div>

        <!--<div class="table-border">
          <div id="productionchart"></div>
        </div>-->

        <div class="table-border">
          <div id="container"></div>
        </div>

      <div class="table-border">
      <div style="text-align:center; font-family:Verdana, Geneva, sans-serif;"><h3>Monitoring Komoditi Per Palka Vessel <?php echo ucwords(strtolower($_SESSION['VES_NAME'])); ?></h3></div>
      <table id="tabel-get-tonase" class="table table-striped" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color:#008000;">
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Nama Vessel</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">No Palka</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Komoditi</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Total di Palka (Kg)</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Total Bongkar (Kg)</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Sisa (Kg)</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Progress</th>
            </tr>
        </thead>
        <tbody>
            <?php       
                for ($x=0; $x<$j; $x++)
                {
                    $progress = (($ton_gross_net[$x]/$tonase[$x])*100);
                    if ($progress > 100) {
                        $progress = 100;
                    }
                echo "<tr>
                        <td>".$ton_ves_name[$x]."</td>
                        <td>".$ton_palka[$x]."</td>
                        <td>".$ton_commodity[$x]."</td>
                        <td style='text-align:right;'>".number_format($tonase[$x], 0, ',', '.')."</td>
                        <td style='text-align:right;'>".number_format($ton_gross_net[$x], 0, ',', '.')."</td>";
                        if(($tonase[$x]-$ton_gross_net[$x]) < 0)
                        {
                            echo "<td style='text-align:right;'>".number_format(($tonase[$x]-$ton_gross_net[$x]), 0, ',', '.')."</td>";
                        }
                        else
                        {
                            echo "<td style='text-align:right;'>".number_format(($tonase[$x]-$ton_gross_net[$x]), 0, ',', '.')."</td>";
                        }
                        echo "
                        <td style='width:400px;'>
                            <div id='progress_bar' class='ui-progress-bar ui-container'>
                              <div class='ui-progress' style='width:".$progress."% '>
                                <span class='ui-label' style='display:display;'>Progress <b class='value'>".round($progress)."%</b></span>
                              </div>
                            </div>
                        </td>
                    </tr>
                    ";              
                }
            ?>
        </tbody>
      </table>
      </div>

      <div class="table-border">
      <div style="text-align:center; font-family:Verdana, Geneva, sans-serif;"><h3>Monitoring Komoditi Per Customer Vessel <?php echo ucwords(strtolower($_SESSION['VES_NAME'])); ?></h3></div>
      <table id="tabel-get-tonase-customer" class="table table-striped" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color:#008000;">
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Nama Customer</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Jumlah Booking (Kg)</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Jumlah Dibongkar (Kg)</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Sisa (Kg)</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Progress</th>
            </tr>
        </thead>
        <tbody>
            <?php       
                for ($x=0; $x<$c; $x++)
                {
                    $progress = (($discharged[$x]/$ordered[$x])*100);
                    if ($progress > 100) {
                        $progress = 100;
                    }
                echo "<tr>
                        <td>".$customer[$x]."</td>
                        <td style='text-align:right;'>".number_format($ordered[$x], 0, ',', '.')."</td>
                        <td style='text-align:right;'>".number_format($discharged[$x], 0, ',', '.')."</td>";
                        if(($ordered[$x]-$discharged[$x]) < 0)
                        {
                            echo "<td style='text-align:right;'>".number_format(($ordered[$x]-$discharged[$x]), 0, ',', '.')."</td>";
                        }
                        else
                        {
                            echo "<td style='text-align:right;'>".number_format(($ordered[$x]-$discharged[$x]), 0, ',', '.')."</td>";
                        }
                        echo "
                        <td style='width:400px;'>
                            <div id='progress_bar' class='ui-progress-bar ui-container'>
                              <div class='ui-progress' style='width:".$progress."% '>
                                <span class='ui-label' style='display:display;'>Progress <b class='value'>".round($progress)."%</b></span>
                              </div>
                            </div>
                        </td>
                    </tr>
                    ";              
                }
            ?>
        </tbody>
      </table>
      </div>

      <div class="table-border">
      <div style="text-align:center; font-family:Verdana, Geneva, sans-serif;"><h3>Monitoring Komoditi Customer Per Hari - Vessel <?php echo ucwords(strtolower($_SESSION['VES_NAME'])); ?></h3></div>
      <table id="tabel-get-data" class="table " cellspacing="0" width="100%">
        <thead>
            <tr style="background-color:#008000;">
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Tanggal</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Nama Vessel</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Nama Customer</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">No Palka</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Komoditi</th>
              <th style="vertical-align:middle; text-align:center; border-bottom: 1px solid #000000;">Berat Bersih (Kg)</th>
            </tr>
        </thead>
        <tbody>
            <?php       
                for ($y=0; $y<$i; $y++)
                {
                    $time = strtotime($date_in1[$y]);
                    $newformat = date('d-m-Y',$time);

                    echo "<tr>
                            <td>".strftime("%#d %b %Y",strtotime($date_in1[$y]))."</td>
                            <td>".$ves_name[$y]."</td>
                            <td>".$full_name[$y]."</td>
                            <td>".$palka[$y]."</td>
                            <td>".$commodity_name[$y]."</td>
                            <td style='text-align:right;'>".number_format($gross_net[$y], 0, ',', '.')."</td>
                        </tr>
                        ";
                }
            ?>
        </tbody>
      </table>
      </div>
    </div>
    </body>
</html>

<script>
        $('#txt-vessel').change(function(){
            selectSequence();
        });
        
        function selectSequence(){
            var option = $('#txt-vessel').find(':selected').val();
            dataString = "option="+option;
            if(option != '')
            {
                $.ajax({
                    type     : 'GET',
                    url      : 'get.php',
                    data     :  dataString,
                    dataType : 'JSON',
                    cache: false,
                    success  : function(data) {            
                    var output;
                        $.each(data.data, function(i,s){
                            var newOption = s;
                            output += '<option value="' + newOption.substr(0, 8)+ '">Kunjungan ke-' + newOption.substr(8) + '</option>';
                        });
                        $('#txt-seq').empty().append(output);
                    },
                    error: function(){
                        console.log("Error");
                    }
                }); 
            }
            else
            {
                console.log("Error");
            }
    }
</script>
<script type="text/javascript">
    $(function () {
    $('#productionchart').highcharts({
        title: {
            text: 'Produksi Alat Vessel <?php echo trim(ucwords(strtolower($_SESSION['VES_NAME']))); ?>',
            x: -20 //center
        },
        xAxis: {
            title:{
                text: 'Tanggal'
            },
            categories: [<?php $n=0; $tanggal_operasi = array();
            for ($y=0; $y<$l; $y++) { $tanggal_operasi[] = strftime("%#d %b %Y",strtotime($date_in2[$y])); }
            echo "'".implode("', '", $tanggal_operasi)."'";
             ?>]
        },
        yAxis: {
            title: {
                text: 'Produksi (Ton / h)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                }
            },
            series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function (e) {
                                hs.htmlExpand(null, {
                                    pageOrigin: {
                                        x: e.pageX || e.clientX,
                                        y: e.pageY || e.clientY
                                    },
                                    headingText: this.series.name,
                                    maincontentText: "Produksi : "+this.y+" Ton/Hour <br/>Operation Time : "+this.ops+" <br/>No Operation Time : "+this.noops,
                                    width: 200
                                });
                            }
                        }
                    },
                    marker: {
                        lineWidth: 1
                    }
            }
        },
        tooltip: {
            formatter: function() {
                var value = "Produksi : "+this.y+" Ton/Hour <br/>Operation Time : "+this.point.ops+" <br/>No Operation Time : "+this.point.noops;
                               
                return value;
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'GSU 1',
            data: [<?php $n=0; $gsu1prod_data = array();
            for ($y=0; $y<$l; $y++) {
            $gsu1opstime = '"'.floor(round(((24*60)-$gsu1nonops[$y])/60,2)).':'.sprintf('%02d',(((24*60)-$gsu1nonops[$y])%60)).'"';
            $gsu1noopstime = '"'.floor($gsu1nonops[$y]/60).':'.sprintf('%02d',($gsu1nonops[$y]%60)).'"';
            $gsu1prod_data[] = '{ y:'.round($gsu1prod[$y]/round(((24*60)-$gsu1nonops[$y])/60,2)/1000,2).', noops:'.$gsu1noopstime.', ops:'.$gsu1opstime.'}';
            }
            echo implode(", ", $gsu1prod_data);
             ?>]
        },{
            name: 'GSU 2',
            data: [<?php $n=0; $gsu2prod_data = array();
            for ($y=0; $y<$l; $y++) {
            $gsu2opstime = '"'.floor(round(((24*60)-$gsu2nonops[$y])/60,2)).':'.sprintf('%02d',(((24*60)-$gsu2nonops[$y])%60)).'"'; 
            $gsu2noopstime = '"'.floor($gsu2nonops[$y]/60).':'.sprintf('%02d',($gsu2nonops[$y]%60)).'"';
            $gsu2prod_data[] = '{ y:'.round($gsu2prod[$y]/round(((24*60)-$gsu2nonops[$y])/60,2)/1000,2).', noops:'.$gsu2noopstime.', ops:'.$gsu2opstime.'}';
            }
            echo implode(", ", $gsu2prod_data);
             ?>]
        }]
    });
});
</script>
<script type="text/javascript">
$(function () {

       var chart = {
          type :'line',
          zoomType: 'x'
       }; 
       var title = {
            text: 'Produktivitas Alat Vessel <?php echo trim(ucwords(strtolower($_SESSION['VES_NAME']))); ?> Per Jam',
            x: -20 //center   
       };
       var subtitle = {
          text: document.ontouchstart === undefined ?
                        'Click and drag in the chart to zoom in' :
                        'Pinch the chart to zoom in',
          x: -20 //center   
       };
       var xAxis = {
            title:{
                text: 'Tanggal'
            },
            categories: [<?php $getdated = array();
            for ($y=0; $y<$m; $y++) { $getdated[] = $dated1[$y]; }
            echo "'".implode("', '", $getdated)."'";
            ?>]
       };
       var yAxis = {
          title: {
                text: 'Produksi (Ton)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
       };
        var legend = {
          enabled: true 
        };
        var tooltip = {
            formatter: function() {
                var value = "Alat : "+this.series.name+"<br/>Produksi : "+this.y+" Ton";
                               
                return value;
            }
        };
        var plotOptions = {
          line: {
                dataLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y +' Ton';
                        }
                }
            }
       };
    var series= [{
            name: 'GSU1',            
            data: [<?php $n=0; $gsu1_datahari = array();
            $n = 0;
            for ($y=0; $y<$m; $y++) {
            $n = round($gsu1nethari[$y]/1000,2);
            $gsu1_datahari[] = "{ y:".number_format($n, 0, ',', '.')."}";
            }
            echo implode(", ", $gsu1_datahari);
             ?>]
        },{
            name: 'GSU2',
            data: [<?php $n=0; $gsu2_datahari = array();
            $n = 0;
            for ($y=0; $y<$m; $y++) {
            $n = round($gsu2nethari[$y]/1000,2);
            $gsu2_datahari[] = "{ y:".$n."}";
            }
            echo implode(", ", $gsu2_datahari);
             ?>]
        }];

    var json = {};
    json.chart = chart;
    json.title = title;
    json.subtitle = subtitle;
    json.legend = legend;
    json.tooltip = tooltip;
    json.xAxis = xAxis;
    json.yAxis = yAxis;  
    json.series = series;
    json.plotOptions = plotOptions;

    $('#container').highcharts(json);
});
</script>
<script type="text/javascript">
/**
 * Grid-light theme for Highcharts JS
 * @author Torstein Honsi
 */

// Load the fonts
Highcharts.createElement('link', {
   href: '//fonts.googleapis.com/css?family=Dosis:400,600',
   rel: 'stylesheet',
   type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

Highcharts.theme = {
   colors: ["#7cb5ec", "#f7a35c", "#90ee7e", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: null,
      style: {
         fontFamily: "Dosis, sans-serif"
      }
   },
   title: {
      style: {
         fontSize: '16px',
         fontWeight: 'bold',
         textTransform: 'uppercase'
      }
   },
   tooltip: {
      borderWidth: 0,
      backgroundColor: 'rgba(219,219,216,0.8)',
      shadow: false
   },
   legend: {
      itemStyle: {
         fontWeight: 'bold',
         fontSize: '13px'
      }
   },
   xAxis: {
      gridLineWidth: 1,
      labels: {
         style: {
            fontSize: '12px'
         }
      }
   },
   yAxis: {
      minorTickInterval: 'auto',
      title: {
         style: {
            textTransform: 'uppercase'
         }
      },
      labels: {
         style: {
            fontSize: '12px'
         }
      }
   },
   plotOptions: {
      candlestick: {
         lineColor: '#404048'
      }
   },


   // General
   background2: '#F0F0EA'

};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);
</script>   