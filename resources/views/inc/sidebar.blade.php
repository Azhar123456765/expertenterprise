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
<style>
    @media only screen and (max-width: 2000px) {
        a {
            target-name: '_blank';
        }
    }
</style>



@if ($role != 'farm_user')
    <aside class="main-sidebar sidebar-light-teal elevation-4">
        <a href="/" class="brand-link">
            <img src="{{ asset($logo) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                style="opacity: 0.8" />
            <span class="brand-text font-weight-light">{{ $organization }}</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('images/avatar011.png') }}" class="img-circle elevation-2" alt="User Image" />
                </div>
                <div class="info">
                    <a href="#"
                        class="d-block">{{ session()->get('user_id')['username'] }}&nbsp;&nbsp;({{ session()->get('user_id')['user_id'] == 1 ? 'Super Admin' : session()->get('user_id')['role'] }})</a>
                </div>
            </div>

            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search" />
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact nav-collapse-hide-child"
                    data-widget="treeview" role="menu" data-accordion="false">
                    <li
                        class="nav-item {{ request()->is('organization*', 'account_account=1*', 'users*', 'buyers*', 'seller*', 'sales_officer*', 'warehouse*', 'zone*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('organization*', 'account_account=1*', 'users*', 'buyers*', 'seller*', 'sales_officer*', 'warehouse*', 'zone*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Setup
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/organization"
                                    class="nav-link{{ request()->is('organization*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Organization</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ Route('account.index', [1, 1]) }}"
                                    class="nav-link{{ request()->is('account_account=1*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Accounts</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/users" class="nav-link{{ request()->is('users*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/buyers" class="nav-link{{ request()->is('buyers*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Customers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/sellers" class="nav-link{{ request()->is('seller*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Supplier</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/sales_officer"
                                    class="nav-link{{ request()->is('sales_officer*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sales Officer</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/warehouse"
                                    class="nav-link{{ request()->is('warehouse*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Warehouse</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/zone" class="nav-link{{ request()->is('zone*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Zone</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                    {{-- 
        <li class="nav-item {{ request()->is('sale-invoice*', 'purchase-invoice*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('sale-invoice*', 'purchase-invoice*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
            <p>
              Invoice
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item  {{ request()->is('sale-invoice*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-money-bill"></i>
                <p>
                  Sale Invoice
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/s_med_invoice" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Sale Invoice</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/ars_med_invoice" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Return Invoice</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/sale-invoice" class="nav-link{{ request()->is('sale-invoice*') ? ' active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage Sale Invoice</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="" data-bs-toggle="modal" data-bs-target="#si-search" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Search Sale Invoice</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item {{ request()->is('purchase-invoice*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-exclamation-circle"></i>
                <p>
                  Purchase Invoice
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/p_med_invoice" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Pur Invoice</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/arp_med_invoice" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Return Invoice</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/purchase-invoice" class="nav-link{{ request()->is('purchase-invoice*') ? ' active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage Pur Invoice</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="" data-bs-toggle="modal" data-bs-target="#pi-search" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Search Pur Invoice</p>
                  </a>
                </li>
              </ul>
            </li>

          </ul>
        </li> --}}

                    <li
                        class="nav-item {{ request()->routeIs('payment_voucher*', 'receipt_voucher*', 'expense_voucher*') ? ' menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('payment_voucher*', 'receipt_voucher*') ? ' active' : '' }}">
                            <i class="nav-icon fas fa-money-check"></i>
                            <p>
                                Voucher
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ Route('journal-voucher.create_first') }}"
                                    class="nav-link{{ request()->routeIs('journal-voucher*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Journal Voucher</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ Route('payment_voucher.create_first') }}"
                                    class="nav-link{{ request()->routeIs('payment_voucher*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Payment Voucher</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ Route('receipt_voucher.create_first') }}"
                                    class="nav-link{{ request()->is('receipt_voucher*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Reciept Voucher</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ Route('expense_voucher.create_first') }}"
                                    class="nav-link{{ request()->routeIs('expense_voucher*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Expense Voucher</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li
                        class="nav-item {{ request()->is('product_category*', 'product_sub_category*', 'product_company*', 'products*', 'product_type*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('product_category*', 'product_sub_category*', 'product_company*', 'products*', 'product_type*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-prescription-bottle"></i>
                            <p>
                                Products
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/product_company"
                                    class="nav-link{{ request()->is('product_company*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product Company</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/product_category"
                                    class="nav-link{{ request()->is('product_category*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/product_sub_category"
                                    class="nav-link{{ request()->is('product_sub_category*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product Sub Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/product_type"
                                    class="nav-link{{ request()->is('product_type*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product Type</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/products"
                                    class="nav-link{{ request()->is('products*') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manage Products</p>
                                </a>
                            </li>
                        </ul>

                    </li>




                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                                Reports
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Standard Reports
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#p-user" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#p-supplier"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>supplier</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#p-buyer" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Buyer</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#p-zone" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>zone</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#p-warehouse"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>warehouse</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#p-sales_officer"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>sales officer</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                            {{-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Legder Reports
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#gen-led" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>General Ledger</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#cus-led" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Customer Ledger</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#supplier-led"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Supllier Ledger</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                            {{-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Voucher Reports
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#p_voucher_report"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Payment Voucher</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#r_voucher_report"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Receipt Voucher</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>
                                        Farm Reports
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#farm-report"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Farm Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#farm-daily-report"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Farm Daily Report</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>
                                        Ledger Reports
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#gen-led"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>General Ledger</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#bal-sheet"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Balance Sheet</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#profit-led"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Profit Report</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>
                                        Voucher Reports
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#p-voucher-report"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Payment Voucher Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#r-voucher-report"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Receipt Voucher Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#e-voucher-report"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Expense Voucher Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#j-voucher-report"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Journal Voucher Report</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>
                                        Company Reports
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#sale-pur-report"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Customer+Supplier Report</p>
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
                                </ul>
                            </li>


                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>
                                        Other Reports
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#expense-report"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Expense Report</p>
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
                            </li>


                            {{-- <li class="nav-item">
                            <a href="" data-bs-toggle="modal" data-bs-target="#sale-r-report" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sale Return Report</p>
                            </a>
                        </li> --}}

                            {{-- <li class="nav-item">
                            <a href="" data-bs-toggle="modal" data-bs-target="#pur-r-report" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Return Report</p>
                            </a>
                        </li> --}}


                        </ul>
                    </li>

                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-circle"></i>
                            <p>
                                Main Module
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>
                                        Invoices
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ Route('invoice_chicken') }}"
                                            class="nav-link {{ request()->routeIs('invoice_chicken') ? ' active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Chicken Invoice</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ Route('invoice_chick') }}"
                                            class="nav-link {{ request()->routeIs('invoice_chick') ? ' active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Chick Invoice</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ Route('invoice_feed') }}"
                                            class="nav-link {{ request()->routeIs('invoice_feed') ? ' active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Feed Invoice</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item menu-open">
                                <a href="{{ Route('farm.index') }}"
                                    class="nav-link{{ request()->routeIs('farm') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Farms</p>
                                </a>
                            </li>
                            <li class="nav-item menu-open">
                                <a href="{{ Route('farming_period.index') }}"
                                    class="nav-link{{ request()->routeIs('farming_period') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Farming Periods</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ Route('daily_reports') }}"
                                    class="nav-link{{ request()->routeIs('daily_reports') ? ' active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Farm Daily Report</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
                <br>
                <div class="bg-blue" style="
    height: 6vh;
    padding: 6px;
">
                    <a href="/logout" class="active text-center">
                        <i class="fas fa-login"></i>
                        <p>Logout</p>
                    </a>
                </div>
            </nav>
        </div>
    </aside>
@else
    <aside class="main-sidebar sidebar-light-teal elevation-4">
        <a href="/" class="brand-link">
            <img src="{{ asset($logo) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                style="opacity: 0.8" />
            <span class="brand-text font-weight-light">{{ $organization }}</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('images/avatar011.png') }}" class="img-circle elevation-2"
                        alt="User Image" />
                </div>
                <div class="info">
                    <a href="#"
                        class="d-block">{{ session()->get('user_id')['username'] }}&nbsp;&nbsp;({{ session()->get('user_id')['user_id'] == 1 ? 'Super Admin' : session()->get('user_id')['role'] }})</a>
                </div>
            </div>

            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search" />
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact nav-collapse-hide-child"
                    data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item menu-open">
                        <a href="{{ Route('daily_reports') }}"
                            class="nav-link{{ request()->routeIs('daily_reports') ? ' active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Farm Daily Report</p>
                        </a>
                    </li>
                </ul>
                <br>
                <div class="bg-blue" style="
    height: 6vh;
    padding: 6px;
">
                    <a href="/logout" class="active text-center">
                        <i class="fas fa-login"></i>
                        <p>Logout</p>
                    </a>
                </div>
            </nav>
        </div>
    </aside>
@endif
