<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Upload for Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url()?>assets/admin/css/bootstrap.min.css" rel="stylesheet">    
    <link href="<?php echo base_url('assets/css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-theme.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?= base_url() ?>assets/admin/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?= base_url() ?>assets/admin/css/dataTables.responsive.css" rel="stylesheet">
        
    <!-- MetisMenu CSS -->
    <link href="<?=base_url()?>assets/admin/css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=base_url()?>assets/admin/css/sb-admin-2.css" rel="stylesheet">    
    <link href="<?php echo base_url('assets/css/jquery-ui.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/jquery-ui.structure.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/jquery-ui.theme.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/jquery.dataTables.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/datepicker3.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">

    <!--kendo ui basic css setting>-->
    <link href="<?php echo base_url('assets/css/kendo.common.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/kendo.default.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/kendo.rtl.min.css') ?>" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="<?=base_url()?>assets/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- JS Sections -->
    <!--<script src="<?php echo base_url('assets/js/jquery-1.11.1.js')?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/script.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.dataTables.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/moment-with-locales.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/select2.min.js') ?>"></script>-->
    <script src="<?php echo base_url('assets/js/jquery-1.11.1.js')?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/moment-with-locales.js') ?>"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap-datetimepicker.min.js"></script>

    <!--kendo ui basic js setting>-->
    <script src="<?= base_url() ?>assets/js/angular.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jszip.min.js"></script>
    <script src="<?= base_url() ?>assets/js/kendo.all.min.js"></script>
    <script src="<?= base_url() ?>assets/js/console.js"></script>




        <script type="text/javascript">
            $(document).ready( function () {
                $('#table').DataTable();
            } );
        </script>
    <script src="<?php echo base_url('assets/js/hovernav.js')?>"></script>

</head>
<body>
     <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= site_url('') ?>">Business Intelligence Data Warehouse TTL</a>
                </div>
                <!-- /.navbar-header -->
                <?php if($this->session->userdata('logged_in')) {?>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="<?= site_url('home') ?>"><i class="fa fa-dashboard fa-fw"></i> Check Upload Status</a>
                    </li>
                                        
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-gear fa-fw"></i> Master <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?= site_url('user'); ?>"><i class="fa fa-user fa-fw"></i> User</a>
                            </li>
                            <li><a href="<?= site_url('group'); ?>"><i class="fa fa-group fa-fw"></i> Group</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="divider"></li>
                        <li><a href="<?= site_url('welcome/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="<?= site_url('home') ?>"><i class="fa fa-dashboard fa-fw"></i> Check Upload Status</a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-briefcase fa-fw"></i> Corporate Planning and Communication
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level collapse in">
                                    <li><a href="<?= site_url('cpc/upload_investasi'); ?>"><i class="fa fa-line-chart fa-fw"></i> Investasi</a>
                                    </li>
                                    <li><a href="<?= site_url('cpc/upload_rkm'); ?>"><i class="fa fa-folder-open-o fa-fw"></i> Rencana Kerja Management</a>
                                    </li>
                                </ul>
                                <!-- /.cpc -->
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-money fa-fw"></i> Finance and Accounting
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level collapse in">
                                    <li><a href="<?= site_url('fa/upload_kas'); ?>"><i class="fa fa-bank fa-fw"></i> Kas</a>
                                    </li>
                                    <li><a href="<?= site_url('fa/upload_neraca'); ?>"><i class="fa fa-balance-scale fa-fw"></i> Neraca</a>
                                    </li>
                                </ul>
                                <!-- /.fa -->
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-building fa-fw"></i> General Affair and Procurement
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level collapse in">
                                    <li><a href="<?= site_url('gap/upload_procurement'); ?>"><i class="fa fa-legal fa-fw"></i> Procurement</a>
                                    </li>
                                </ul>
                                <!-- /.gap -->
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-group fa-fw"></i> Human Capital
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level collapse in">
                                    <li><a href="<?= site_url('hc/upload_pegawai'); ?>"><i class="fa fa-user fa-fw"></i> Pegawai</a>
                                    </li>
                                    <li><a href="<?= site_url('hc/upload_rkap'); ?>"><i class="fa fa-user fa-fw"></i> RKAP</a>
                                    </li>
                                    <li><a href="<?= site_url('hc/upload_training'); ?>"><i class="fa fa-graduation-cap fa-fw"></i> Training</a>
                                    </li>
                                </ul>
                                <!-- /.hc -->
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-life-ring fa-fw"></i> QHSSE
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level collapse in">
                                    <li><a href="<?= site_url('qhsse/upload_k3'); ?>"><i class="fa fa-universal-access fa-fw"></i> K3</a>
                                    </li>
                                    <li><a href="<?= site_url('qhsse/upload_lingkungan'); ?>"><i class="fa fa-tree fa-fw"></i> Lingkungan</a>
                                    </li>
                                    <li><a href="<?= site_url('qhsse/upload_mutu'); ?>"><i class="fa fa-thumbs-o-up fa-fw"></i> Mutu</a>
                                    </li>
                                    <li><a href="<?= site_url('qhsse/upload_kepuasan'); ?>"><i class="fa fa-smile-o fa-fw"></i> Kepuasan</a>
                                    </li>
                                </ul>
                                <!-- /.qhsse -->
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
                <?php } else {?>
                <ul class="nav navbar-top-links navbar-right">
                    <li><a href="<?= site_url('') ?>"><i class="fa fa-sign-in fa-fw"></i> Login</a>
                </ul>
                <?php } ?>
            </nav>
    </div>