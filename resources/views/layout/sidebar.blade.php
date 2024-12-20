<?php
// use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\maincontroller;

$org = App\Models\Organization::all();

foreach ($org as $key => $value) {
    $organization = $value->organization_name;
    $logo = $value->logo;
}
$id = session()->get('user_id')['user_id'];
$role = session()->get('user_id')['role'];
$theme_colors = App\Models\users::where('user_id', $id)->get();

foreach ($theme_colors as $key => $value2) {
    $theme_color = $value2->theme;
}

$target = null;

?>
<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo">
                <h4 class="text-white mt-1 fw-bold">{{ $organization }}</h4>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li
                    class="nav-item {{ request()->is('organization*', '*account*', '*user*', '*buyer*', 'seller*', 'sales_officer*', 'warehouse*', 'zone*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-user"></i>
                        <p>Main</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('organization*', '*account*', '*user*', '*buyer*', '*seller*', 'sales_officer*', 'warehouse*', 'zone*') ? 'show' : '' }}"
                        id="dashboard">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ request()->is('organization*') ? ' active' : '' }}">
                                <a href="/organization" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Organization</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('*account*') ? ' active' : '' }}">
                                <a href="{{ Route('account.index', [1, 1]) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Accounts</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('*user*') ? ' active' : '' }}">
                                <a href="/users" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('*buyer*') ? ' active' : '' }}">
                                <a href="/buyers" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Customers</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item {{ request()->is('seller*') ? ' active' : '' }}">
                                <a href="/sellers" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Supplier</p>
                                </a>
                            </li> --}}
                            <li class="nav-item {{ request()->is('sales_officer*') ? ' active' : '' }}">
                                <a href="/sales_officer" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sales Officer</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('warehouse*') ? ' active' : '' }}">
                                <a href="/warehouse" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Warehouse</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('zone*') ? ' active' : '' }}">
                                <a href="/zone" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Zone</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->routeIs('*payment_voucher*', '*receipt_voucher*', '*expense_voucher*') ? ' active' : '' }}">
                    <a data-bs-toggle="collapse" href="#Voucher" class="collapsed" aria-expanded="false">
                        <i class="fas fa-money-check"></i>
                        <p>Voucher</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('*voucher*') ? 'show' : '' }}" id="Voucher">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ request()->routeIs('payment_voucher*') ? ' active' : '' }}">
                                <a href="{{ Route('payment_voucher.create_first') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Payment Voucher</p>
                                </a>
                            </li>
                            <li class="nav-item{{ request()->routeIs('receipt_voucher*') ? ' active' : '' }}">
                                <a href="{{ Route('receipt_voucher.create_first') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Reciept Voucher</p>
                                </a>
                            </li>
                            <li class="nav-item{{ request()->routeIs('expense_voucher*') ? ' active' : '' }}">
                                <a href="{{ Route('expense_voucher.create_first') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Expense Voucher</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item {{ request()->is('*invoices*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#Invoices" class="collapsed" aria-expanded="false">
                        <i class="fas fa-file-invoice"></i>
                        <p>Invoices</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('*invoice*') ? 'show' : '' }}" id="Invoices">
                        <ul class="nav nav-collapse">
                            <li class="nav-item{{ request()->is('invoice-sale*') ? ' active' : '' }}">
                                <a href="{{ Route('invoice_sale') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sale Invoice</p>
                                </a>
                            </li>
                            <li class="nav-item{{ request()->is('*sale-do*') ? ' active' : '' }}">
                                <a href="{{ Route('sale_do') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sale DO</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li
                    class="nav-item {{ request()->is('*product_category*', 'product_sub_category*', '*product_company*', '*product*', '*product_type*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#Products" class="collapsed" aria-expanded="false">
                        <i class="fas fa-prescription-bottle"></i>
                        <p>Products</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('*product_category*', 'product_sub_category*', '*product_company*', '*product*', '*product_type*') ? 'show' : '' }}"
                        id="Products">
                        <ul class="nav nav-collapse">
                            <li class="nav-item{{ request()->is('product_company*') ? ' active' : '' }}">
                                <a href="/product_company" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product Company</p>
                                </a>
                            </li>
                            <li class="nav-item{{ request()->is('*product_category*') ? ' active' : '' }}">
                                <a href="/product_category" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product Category</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item{{ request()->is('product_sub_category*') ? ' active' : '' }}">
                                <a href="/product_sub_category"
                                    class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product Sub Category</p>
                                </a>
                            </li> --}}
                            <li class="nav-item{{ request()->is('*product_type*') ? ' active' : '' }}">
                                <a href="/product_type" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product Type</p>
                                </a>
                            </li>
                            <li class="nav-item{{ request()->is('products*') ? ' active' : '' }}">
                                <a href="/products" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stock Inventory</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Reports" class="collapsed" aria-expanded="false">
                        <i class="fas fa-chart-line"></i>
                        <p>Reports</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Reports">
                        <ul class="nav nav-collapse">
                            <li class="nav-item">
                                <a href="" data-bs-toggle="modal" data-bs-target="#gen-led" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>General Ledger</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daily Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" data-bs-toggle="modal" data-bs-target="#sale-report"
                                    class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Customer Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" data-bs-toggle="modal" data-bs-target="#pur-report"
                                    class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Supplier Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" data-bs-toggle="modal" data-bs-target="#stock-report"
                                    class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stock Report</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
