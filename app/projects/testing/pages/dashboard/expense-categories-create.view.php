<? include('partials/left-sidebar.view.php') ?>

<div id="main-right" class="container-fluid">
                                                
<div class="card">
    <div class="card-header">
        Create Expense Category
    </div>

    <div class="card-body">
        <form action="http://demo-expense-manager.quickadminpanel.com/admin/expense-categories" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="psEEUhde8EBJvPIRpmtyBZ7obJirY7zk2YjwLQVV">            <div class="form-group ">
                <label for="name">Name*</label>
                <input type="text" id="name" name="name" class="form-control" value="" required="">
                                <p class="helper-block">
                    
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="Save">
            </div>
        </form>


    </div>
</div>

            </div>