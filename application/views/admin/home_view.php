    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Welcome</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3>Jumlah Data yang Sudah Masuk</h3>
                <div id="grid">
                
                </div>                
            </div>            
        </div>
	
    </div>
    <script>
        var main_url = "<?php echo base_url()?>" + "home";
    

            var urlx = main_url + '/get_all_list';
            var ds = new kendo.data.DataSource({
                    transport: {
                        read: {
                            type: 'post',
                            url: urlx,   
                            dataType: 'json'
                        }
                    },
                    error: function(e) {
                        //alert(e);
                        console.log('awww: '+e);
                    },
                    schema: {
                        data: function(data){
                            return data.Result;
                        },
                        total: function(data){
                            return data.CResult;
                        },
                               model: {
                                id: "DEPARTMENT",
                    
                                    fields: {
                                        DEPARTMENT: { type: "string" },
                                        MODULE: { type: "string" },
                                        BULAN: { type: "string" },
                                        TAHUN: { type: "string" },
                                        JUMLAH: { type: "string" }
                                    }
                                }
                    },
                    pageSize: 20,
                    serverPaging: true,
                    serverFiltering: true,
                    serverSorting: true
            });

        //$(document).ready(function () {
            $("#grid").kendoGrid({
                dataSource: ds,
                height: 500,
                filterable: {
                    extra:false
                },
                groupable: true,
                sortable: true,
                pageable: {
                    refresh: true,
                    pageSizes: true,
                    buttonCount: 5
                },
                selectable: "multiple",
                columns: [{
                    
                    field: "DEPARTMENT",
                    title: "DEPARTMENT",
                    filterable: true 
                }, 
                {
                    field: "MODULE",
                    title: "MODULE",
                    filterable: true 
                },
                {
                    field: "BULAN",
                    title: "BULAN",
                    filterable: true 
                }, 
                {
                    field: "TAHUN",
                    title: "TAHUN",
                    filterable: true 
                },
                {
                    field: "JUMLAH",
                    title: "JUMLAH DATA"
                }
                ]
            });
        //});
    </script>