<style>
    /* Dropdown Button
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

/* The container <div> - needed to position the dropdown content */
/* .dropdown {
  position: relative;
  display: inline-block;
} */

/* Dropdown Content (Hidden by Default) */
/* .dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
} */

/* Links inside the dropdown */
/* .dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
} */

/* Change color of dropdown links on hover */
/* .dropdown-content a:hover {background-color: #ddd;} */

/* Show the dropdown menu on hover */
/* .dropdown:hover .dropdown-content {display: block;} */

/* Change the background color of the dropdown button when the dropdown content is shown */
/* .dropdown:hover .dropbtn {background-color: #3e8e41;} */
</style>


<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ route('admin.admin-dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.category.list')}}" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.sub-category.list')}}" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Sub Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.brand.list')}}" class="nav-link">
                    <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                    <p>Brands</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.product.list')}}" class="nav-link">
                    <i class="nav-icon fas fa-tag"></i>
                    <p>Products</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.shipping.list')}}" class="nav-link">
                    <!-- <i class="nav-icon fas fa-tag"></i> -->
                    <i class="fas fa-truck nav-icon"></i>
                    <p>Shipping</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.order.list')}}" class="nav-link">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>Orders</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.order.table.list')}}" class="nav-link">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>TableOrdersData</p>
                </a>
            </li>

            <!-- <li class="nav-item">
            <div class="dropdown">
                <button class="dropbtn">Dropdown</button>
                <div class="dropdown-content">
                    <a href="#" class="nav-link">Link 1</a>
                    <a href="#" class="nav-link">Link 2</a>
                    <a href="#" class="nav-link">Link 3</a>
                </div>
                </div>
            </li> -->


            <li class="nav-item">
                <a href="{{route('admin.discount.list')}}" class="nav-link">
                    <i class="nav-icon  fa fa-percent" aria-hidden="true"></i>
                    <p>Discount</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="users.html" class="nav-link">
                    <i class="nav-icon  fas fa-users"></i>
                    <p>Users</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages.html" class="nav-link">
                    <i class="nav-icon  far fa-file-alt"></i>
                    <p>Pages</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>

