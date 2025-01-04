
  <div class="navigationbar">

    <a href="/admin/dashboard"><h1>logo</h1></a>
    
    <ul class="vertical-menu">   
        <li>
            <a href="javaScript:void();">
              <img src=" {{ asset('assets/images/svg-icon/dashboard.svg') }} " class="img-fluid" alt="dashboard"><span>Master</span><i class="feather icon-chevron-right pull-right"></i>
            </a>
            <ul class="vertical-submenu">
                <li><a href="/add/category"><i class="mdi mdi-circle"></i>Add Category</a></li>
                <li><a href="/add/subcategory"><i class="mdi mdi-circle"></i>Add Sub Category</a></li>
                <li><a href="/banners/create"><i class="mdi mdi-circle"></i>Add App Banner</a></li>
                <li><a href="/create/promocode"><i class="mdi mdi-circle"></i>Add PromoCode</a></li>
            </ul>
        </li>
               
        
        
        <li>
          <a href="javaScript:void();">
            <img src="{{ asset('assets/images/svg-icon/dashboard.svg') }}" class="img-fluid" alt="apps"><span>Report</span><i class="feather icon-chevron-right pull-right"></i>
          </a>
          <ul class="vertical-submenu">
            <li><a href="/vendor/view"><i class="mdi mdi-circle"></i>Vendors</a></li>
            <li><a href="/user/view"><i class="mdi mdi-circle"></i>Users</a></li>
          </ul>
      </li>

    </ul>

    
</div>

