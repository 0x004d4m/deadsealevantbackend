{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="Products" icon="la la-box-open">
    <x-backpack::menu-item title="Categories" icon="la la-tags" :link="backpack_url('category')" />
    <x-backpack::menu-item title="Products" icon="la la-box-open" :link="backpack_url('product')" />
    <x-backpack::menu-item title="Product images" icon="la la-photo-video" :link="backpack_url('product-image')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-item title="Emails" icon="la la-mail-bulk" :link="backpack_url('email')" />
<x-backpack::menu-item title="Orders" icon="la la-shopping-cart" :link="backpack_url('order')" />
<x-backpack::menu-item title="Contact requests" icon="la la-comment-dots" :link="backpack_url('contact-request')" />

<x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />

<x-backpack::menu-dropdown title="Translations" icon="la la-globe">
    <x-backpack::menu-dropdown-item title="Languages" icon="la la-flag-checkered" :link="backpack_url('language')" />
    <x-backpack::menu-dropdown-item title="Site texts" icon="la la-language" :link="backpack_url('language/texts')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Settings" icon="la la-cog">
    <x-backpack::menu-item title="Settings" icon="la la-cogs" :link="backpack_url('setting')" />
    <x-backpack::menu-item title='Logs' icon='la la-terminal' :link="backpack_url('log')" />
    <x-backpack::menu-item title="images" icon="la la-image" :link="backpack_url('images')" />
    <x-backpack::menu-item title="Countries" icon="la la-globe" :link="backpack_url('country')" />
    <x-backpack::menu-item title="Order statuses" icon="la la-stream" :link="backpack_url('order-status')" />
</x-backpack::menu-dropdown>
