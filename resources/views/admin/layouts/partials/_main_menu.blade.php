<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav ">

            {!! $menus->render() !!}

            <li class='m-menu__item' aria-haspopup='true' m-menu-link-redirect='1'>
                <a href='<?= route('front') ?>' class='m-menu__link' target="_blank">
                    <span class='m-menu__item-here'></span>
                    <i class='m-menu__link-icon fa fa-globe'></i>
                    <span class='m-menu__link-text'>مشاهده سایت</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- END: Aside Menu -->
</div>
