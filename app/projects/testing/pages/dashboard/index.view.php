<? include('partials/left-sidebar.view.php') ?>

<div id="main-right" class="container-fluid">
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/create">
                Add Expense
            </a>
        </div>
    </div>
    <div class="card">
    <div class="card-header">
        Expense List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div class="dt-buttons"><a class="btn buttons-copy buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Copy</span></a><a class="btn buttons-csv buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>CSV</span></a><a class="btn buttons-excel buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Excel</span></a><a class="btn buttons-pdf buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>PDF</span></a><a class="btn buttons-print btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Print</span></a><a class="btn buttons-collection buttons-colvis btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Column visibility</span></a><a class="btn btn-danger" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Delete selected</span></a></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_0"></label></div><div class="dataTables_scroll"><div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;"><div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 692.8px; padding-right: 17px;"><table class="table table-bordered table-striped table-hover datatable datatable-Expense dataTable no-footer" role="grid" style="margin-left: 0px; width: 692.8px;"><thead>
                    <tr role="row"><th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10.2px;" aria-label="

                        ">

                        </th><th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 15px;" aria-sort="descending" aria-label="
                            ID
                        : activate to sort column ascending">
                            ID
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 97.4px;" aria-label="
                            Expense Category
                        : activate to sort column ascending">
                            Expense Category
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 55.8px;" aria-label="
                            Entry Date
                        : activate to sort column ascending">
                            Entry Date
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 55px;" aria-label="
                            Amount
                        : activate to sort column ascending">
                            Amount
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 75.8px;" aria-label="
                            Description
                        : activate to sort column ascending">
                            Description
                        </th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 64px;" aria-label="
                            &amp;nbsp;
                        ">
                            &nbsp;
                        </th></tr>
                </thead></table></div></div><div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;"><table class="table table-bordered table-striped table-hover datatable datatable-Expense dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 694px;"><thead>
                    <tr role="row" style="height: 0px;"><th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10.2px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="

                        "><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">

                        </div></th><th class="sorting_desc" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 15px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-sort="descending" aria-label="
                            ID
                        : activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            ID
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 97.4px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="
                            Expense Category
                        : activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Expense Category
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 55.8px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="
                            Entry Date
                        : activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Entry Date
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 55px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="
                            Amount
                        : activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Amount
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 75.8px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="
                            Description
                        : activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Description
                        </div></th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 64px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="
                            &amp;nbsp;
                        "><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            &nbsp;
                        </div></th></tr>
                </thead>
                
                <tbody>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                    <tr data-entry-id="15" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                15
                            </td>
                            <td>
                                Et.
                            </td>
                            <td>
                                2021-04-07
                            </td>
                            <td>
                                359.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/15">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/15/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/15" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="14" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                14
                            </td>
                            <td>
                                Molestiae.
                            </td>
                            <td>
                                2021-05-24
                            </td>
                            <td>
                                66.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/14">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/14/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/14" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="13" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                13
                            </td>
                            <td>
                                Et nihil.
                            </td>
                            <td>
                                2021-04-25
                            </td>
                            <td>
                                196.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/13">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/13/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/13" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="12" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                12
                            </td>
                            <td>
                                Consectetur.
                            </td>
                            <td>
                                2021-03-30
                            </td>
                            <td>
                                215.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/12">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/12/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/12" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="11" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                11
                            </td>
                            <td>
                                Excepturi.
                            </td>
                            <td>
                                2021-05-06
                            </td>
                            <td>
                                156.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/11">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/11/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/11" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="10" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                10
                            </td>
                            <td>
                                Molestiae.
                            </td>
                            <td>
                                2021-04-16
                            </td>
                            <td>
                                363.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/10">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/10/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/10" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="9" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                9
                            </td>
                            <td>
                                Doloremque.
                            </td>
                            <td>
                                2021-04-28
                            </td>
                            <td>
                                130.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/9">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/9/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/9" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="8" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                8
                            </td>
                            <td>
                                Aperiam magni.
                            </td>
                            <td>
                                2021-03-01
                            </td>
                            <td>
                                286.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/8">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/8/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/8" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="7" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                7
                            </td>
                            <td>
                                Et nihil.
                            </td>
                            <td>
                                2021-04-09
                            </td>
                            <td>
                                498.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/7">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/7/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/7" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="6" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                6
                            </td>
                            <td>
                                Excepturi.
                            </td>
                            <td>
                                2021-04-27
                            </td>
                            <td>
                                118.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/6">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/6/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/6" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="5" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                5
                            </td>
                            <td>
                                Et.
                            </td>
                            <td>
                                2021-03-29
                            </td>
                            <td>
                                398.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/5">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/5/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/5" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="4" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                4
                            </td>
                            <td>
                                Id nobis.
                            </td>
                            <td>
                                2021-03-01
                            </td>
                            <td>
                                132.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/4">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/4/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/4" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="3" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                3
                            </td>
                            <td>
                                Aliquam.
                            </td>
                            <td>
                                2021-03-29
                            </td>
                            <td>
                                127.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/3">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/3/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/3" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="2" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                2
                            </td>
                            <td>
                                Et nihil.
                            </td>
                            <td>
                                2021-05-01
                            </td>
                            <td>
                                106.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/2">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/2/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/2" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="1" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                1
                            </td>
                            <td>
                                Doloremque.
                            </td>
                            <td>
                                2021-04-12
                            </td>
                            <td>
                                285.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/1">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/1/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/1" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr></tbody>
            </table></div></div><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 15 of 15 entries</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><ul class="pagination"><li class=" previous disabled" id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class=" active"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class=" next disabled" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div><div class="actions"></div></div>
        </div>


    </div>
</div>
</div>

<form id="logoutform" action="http://demo-expense-manager.quickadminpanel.com/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" value="qmUUR5FeiM7l9JoMVdkocuFggZjljusgPmxcofmJ">
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="http://demo-expense-manager.quickadminpanel.com/js/main.js"></script>
    <script>
        $(function() {
  let copyButtonTrans = 'Copy'
  let csvButtonTrans = 'CSV'
  let excelButtonTrans = 'Excel'
  let pdfButtonTrans = 'PDF'
  let printButtonTrans = 'Print'
  let colvisButtonTrans = 'Column visibility'

  let languages = {
    'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages['en']
    },
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }, {
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pageLength: 100,
    dom: 'lBfrtip<"actions">',
    buttons: [
      {
        extend: 'copy',
        className: 'btn-default',
        text: copyButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'colvis',
        className: 'btn-default',
        text: colvisButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';
});

    </script>
    
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = 'Delete selected'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "http://demo-expense-manager.quickadminpanel.com/admin/expenses/destroy",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('No rows selected')

        return
      }

      if (confirm('Are you sure?')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Expense:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>

</div>