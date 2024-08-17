{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="Add-ons" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Authentication" />
    <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Translations" icon="la la-globe">
    <x-backpack::menu-dropdown-item title="Languages" icon="la la-flag-checkered" :link="backpack_url('language')" />
    <x-backpack::menu-dropdown-item title="Site texts" icon="la la-language" :link="backpack_url('language/texts')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-item title='Logs' icon='la la-terminal' :link="backpack_url('log')" />
<x-backpack::menu-item title="Sections" icon="la la-question" :link="backpack_url('section')" />
<x-backpack::menu-item title="Benefts" icon="la la-question" :link="backpack_url('beneft')" />
<x-backpack::menu-item title="Steps" icon="la la-question" :link="backpack_url('step')" />
<x-backpack::menu-item title="Disadvantages" icon="la la-question" :link="backpack_url('disadvantage')" />
<x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('category')" />
<x-backpack::menu-item title="Products" icon="la la-question" :link="backpack_url('product')" />
<x-backpack::menu-item title="Product images" icon="la la-question" :link="backpack_url('product-image')" />
<x-backpack::menu-item title="Contact requests" icon="la la-question" :link="backpack_url('contact-request')" />

<x-backpack::menu-item title="Emails" icon="la la-question" :link="backpack_url('email')" />