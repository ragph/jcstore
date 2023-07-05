<!--  ===================== nava bar =========================== -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<router-link to="/dashboard"> <a class="navbar-brand" href="#">POS</a></router-link>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

    <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       <i class="fa fa-plus" aria-hidden="true"></i> Inventory <span class="badge badge-dark">F1</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <router-link to="/inventory"> <a class="dropdown-item" href="#">All products</a></router-link>
          <router-link to="/transactions"> <a class="dropdown-item" href="#">Transactions</a></router-link>
          <div class="dropdown-divider"></div>
          <router-link to="/return">  <a class="dropdown-item" href="#">Returns</a></router-link>
        </div>
      </li>


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarproducts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
        Products
        <span class="badge badge-pill badge-primary">101</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarproducts">
        <router-link to="/products">
        <a class="dropdown-item" href="#">Add product</a>
        </router-link>
         <router-link to="/category">
         <a class="dropdown-item" href="#">Add category</a>
         </router-link>
        <!-- <div class="dropdown-divider"></div>
          <router-link to="/return"> <a class="dropdown-item" href="#">Return poduct</a></router-link>
        </div> -->
      </li>

      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       <i class="fa fa-shopping-cart" aria-hidden="true"></i> POS <span class="badge badge-dark">F2</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link to="/sales"> <a class="dropdown-item" href="#">Add</a></router-link>
          <a class="dropdown-item" href="#">Sales history</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Returns</a>
        </div>
      </li>

      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->

      <li class="nav-item">
        <router-link to="/branch"><a class="nav-link" href="#"> <i class="fa fa-home" aria-hidden="true"></i> Branch </a></router-link>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-th-large" aria-hidden="true"></i> Box management
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link to="/assign"> <a class="dropdown-item" href="#">Assign</a></router-link>
        <router-link to="/boxes"> <a class="dropdown-item" href="#">Boxes</a></router-link>
        </div>
      </li>

      <li class="nav-item">
      <router-link to="/resellers"> <a class="nav-link" href="#"> <i class="fa fa-users" aria-hidden="true"></i> Renters / sellers profiles </a></router-link>
      </li>

      <li class="nav-item">
      <router-link to="/usermanagement"><a class="nav-link" href="#"> <i class="fa fa-user" aria-hidden="true"></i> Users </a></router-link>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarproducts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-list-alt" aria-hidden="true"></i>
          Rent management

          </a>
          <div class="dropdown-menu" aria-labelledby="navbarproducts">
          <router-link to="/all">
          <a class="dropdown-item" href="#">All</a>
          </router-link>
          <router-link to="/duedate">
          <a class="dropdown-item" href="#">Dues</a>
          </router-link>
          <router-link to="/collected">
          <a class="dropdown-item" href="#">Collected</a>
          </router-link>

      <!-- <router-link to="/rentmanagement"><a class="nav-link" href="#"> <i class="fa fa-list-alt" aria-hidden="true"></i> Rent management </a></router-link> -->
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#"> <i class="fa fa-money" aria-hidden="true"></i> Voucher & coupons </a>
      </li>
      <li class="nav-item">
      <router-link to="/report"><a class="nav-link" href="#"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Report </a></router-link>
      </li>
      <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Hi ! Admin user
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#"><i class="fa fa-cog" aria-hidden="true"></i> Settings </a>
                <a class="dropdown-item" href="#"></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
        </li>
       </ul>
      </span>


  </div>
</nav>
<!--  ===================== nava bar =========================== -->