<style>
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 55px;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.25s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 1rem;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 2rem;
  margin-left: 50px;
}

#main-right {
  transition: margin-left .25s;
}
/* padding: 16px; */

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>

<? include('left-sidebar.php') ?>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  <!-- <a href="#">About</a>
  <a href="#">Services</a>
  <a href="#">Clients</a>
  <a href="#">Contact</a> -->

<ul class="nav">
    <? 
    foreach($left_menu_items as $menu_item) : ?>

        <? if(isset($menu_item['items'])) :  ?>
            <? include_view($root_dir.'item-array',['item'=>$menu_item,'root_dir'=>$root_dir, 'x_shift' => $x_shift])?>
        <? else : ?>
            <? include_view($root_dir.'item-item',['item'=>$menu_item])?>
        <? endif  ?>
    <? endforeach ?>
</ul>

<ul class="nav stop-here">
    <li class="nav-item nav-dropdown">
        <a class="nav-link  nav-dropdown-toggle" href="#">
            <i class="fa-fw fas fa-users nav-icon"></i>
            User management
        </a>
        <ul class="nav-dropdown-items ml-3">
            <li class="nav-item">
                <a href="/dashboard/permissions" class="nav-link ">
                    <i class="fa-fw fas fa-unlock-alt nav-icon"></i>
                    Permissions
                </a>
            </li>
            <li class="nav-item">
                <a href="<? path('dashboard-roles') ?>" class="nav-link ">
                    <i class="fa-fw fas fa-briefcase nav-icon"></i>
                    Roles
                </a>
            </li>
            <li class="nav-item">
                <a href="<? path('dashboard-users') ?>" class="nav-link ">
                    <i class="fa-fw fas fa-user nav-icon"></i>
                    Users
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="<? path('admin-expense-categories') ?>" class="nav-link ">
            <i class="fa-fw fas fa-list nav-icon"></i>
            Expense Categories
        </a>
    </li>
    <li class="nav-item">
        <a href="<? path('admin-income-categories') ?>" class="nav-link ">
            <i class="fa-fw fas fa-list nav-icon"></i>
            Income Categories
        </a>
    </li>
    <li class="nav-item open">
        <a href="<? path('admin-expenses') ?>" class="nav-link active">
            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
            Expenses
        </a>
    </li>
    <li class="nav-item">
        <a href="<? path('admin-incomes') ?>" class="nav-link ">
            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
            Income
        </a>
    </li>
    <li class="nav-item">
        <a href="<? path('admin-mon-reports') ?>" class="nav-link ">
            <i class="fa-fw fas fa-chart-line nav-icon"></i>
            Monthly report
        </a>
    </li>
    <li class="nav-item">
        <a href="<? path('admin-login') ?>" class="nav-link">
            <i class="nav-icon fas fa-fw fa-sign-out-alt"></i>
            Login user
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
            <i class="nav-icon fas fa-fw fa-sign-out-alt"></i>
            Logout
        </a>
    </li>
</ul>
</div>

<!-- <div id="main-right">
  <h2>Sidenav Push Example</h2>
  <p>Click on the element below to open the side navigation menu, and push this content to the right.</p>
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
</div> -->

<!-- https://3dtransforms.desandro.com/perspective -->
<style>
    .perspective {
        transform: perspective(400px) rotateY(-5deg);
        height: 600px;
        overflow-y: scroll;
        width: 95%;
        margin-left: -30px;
        margin-top: 48px;
        border-radius: 10px;
        background: #abc;
        transition: all 1000ms;
    }
    .bg-color {
        background-color: #797F9B;
    }
</style>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main-right").style.marginLeft = "250px";

  $('#main-banner').addClass('perspective');  
  $('body').addClass('bg-color');

}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main-right").style.marginLeft= "0";

  $('#main-banner').removeClass('perspective');  
//   $('body').addClass('bg-color');

}
</script>

