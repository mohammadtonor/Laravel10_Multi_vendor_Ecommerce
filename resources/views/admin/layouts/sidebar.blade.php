<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">Stisla</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">St</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="dropdown {{ setActive([
          'admin.dashboard'
        ]) }}">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
          <ul class="dropdown-menu">
            <li class='{{ setActive(['admin.dashboard']) }}'>
              <a class="nav-link" href="{{route('admin.dashboard')}}">General Dashboard</a></li>
          </ul>
        </li>

        <li class="menu-header">Starter</li>

        <li class="dropdown {{setActive([
          'admin.category.*',
          'admin.sub-category.*',
          'admin.child-category.*',
        ])}}">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Manage Categories</span></a>
          <ul class="dropdown-menu">
            <li class='{{setActive(['admin.category.*'])}}'><a class="nav-link" href="{{route('admin.category.index')}}">Category</a></li>
            <li class='{{setActive(['admin.sub-category.*'])}}'><a class="nav-link" href="{{route('admin.sub-category.index')}}">Sub Category</a></li>
            <li class='{{setActive(['admin.child-category.*'])}}'><a class="nav-link" href="{{route('admin.child-category.index')}}">Child Category</a></li>
          </ul>
        </li>

        <li class="dropdown {{setActive([
          'admin.product.*',
          'admin.brand.*',
          'admin.brand.*',
          'admin.product.*',
          'admin.product-variant.*',
          'admin.product-variant-item.*',
          'admin.products-variant-item.edit',
          'admin.product-image-gallery.*',
          'admin.seller-products.*',
          'admin.seller-pending-products.*',
        ])}}">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Manage Products</span></a>
          <ul class="dropdown-menu">
            <li class='{{setActive(['admin.brand.*'])}}'><a class="nav-link" href="{{route('admin.brand.index')}}">Brands</a></li>
            <li class='{{setActive([
                'admin.product.*',
                'admin.product-image-gallery.*',
                'admin.product-variant.*',
                'admin.product-variant-item.*',
                'admin.products-variant-item.edit'
            ])}}'><a class="nav-link" href="{{route('admin.product.index')}}">Product</a></li>
            <li class='{{setActive(['admin.seller-products.*'])}}'><a class="nav-link" href="{{route('admin.seller-products.index')}}">Seller Product</a></li>
            <li class='{{setActive(['admin.seller-pending-products.*'])}}'><a class="nav-link" href="{{route('admin.seller-pending-products.index')}}">Seller Pending Product</a></li>
          </ul>
        </li>

        <li class="dropdown {{setActive(['admin.vendor-profile.*',])}}">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Ecommerce</span></a>
          <ul class="dropdown-menu">
            <li class='{{setActive(['admin.vendor-profile.*'])}}'><a class="nav-link" href="{{route('admin.vendor-profile.index')}}">Vendor Profile</a></li>
          </ul>
        </li>

        <li class="dropdown {{setActive(['admin.slider.*'])}}">
          <a href="#" class="nav-link has-dropdown" ><i class="fas fa-columns"></i> <span>Manage Website</span></a>
          <ul class="dropdown-menu">
            <li class='{{setActive(['admin.slider.*'])}}'><a class="nav-link" href="{{route('admin.slider.index')}}">Slider</a></li>
          </ul>
        </li>
        {{-- <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
            <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
            <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
          </ul>
        </li> --}}
        {{-- <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li> --}}
    </ul>

      </aside>
  </div>
