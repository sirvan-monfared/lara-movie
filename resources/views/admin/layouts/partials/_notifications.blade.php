<li class="m-nav__item m-topbar__notifications m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
    <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
        <span class="m-nav__link-icon">
            <span class="m-nav__link-icon-wrapper"><i class="flaticon-alarm"></i></span>
            <span class="m-nav__link-badge m-badge m-badge--danger">{{ $unread_notifications->count() }}</span>
        </span>
    </a>
    <div class="m-dropdown__wrapper">
        <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
        <div class="m-dropdown__inner">
            <div class="m-dropdown__header m--align-center">
                <span class="m-dropdown__header-title">{{ $unread_notifications->count() }}</span>
                <span class="m-dropdown__header-subtitle">User Notifications</span>
            </div>
            <div class="m-dropdown__body">
                <div class="m-dropdown__content">
                    <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
                                خوانده نشده
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab">خوانده شده</a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">همه</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                            <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                <div class="m-list-timeline m-list-timeline--skin-light">
                                    <div class="m-list-timeline__items">
                                        @foreach($unread_notifications as $unread)
                                            <div class="m-list-timeline__item">
                                                <span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                <span class="m-list-timeline__text">
                                                    {{ $unread->data['message'] }} <span class="m-badge m-badge--danger m-badge--wide">مهم</span><br>
                                                    <a href="{{ $unread->data['link'] }}" target="_blank">{{ $unread->data['link'] }}</a><br>
                                                    {{ $unread->data['date'] }}
                                                </span>
                                                <span class="m-list-timeline__time">
                                                    {{ $unread->created_at->diffForHumans() }}<br>
                                                    <small class="dismiss-notification"><a href="#"><i class="fa fa-times"></i>  متوجه شدم </a></small>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
                            <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                <div class="m-list-timeline m-list-timeline--skin-light">
                                    <div class="m-list-timeline__items">
                                        <div class="m-list-timeline__item">
                                            <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                            <a href="" class="m-list-timeline__text">New order received</a>
                                            <span class="m-list-timeline__time">Just now</span>
                                        </div>
                                        <div class="m-list-timeline__item">
                                            <span class="m-list-timeline__badge m-list-timeline__badge--state1-danger"></span>
                                            <a href="" class="m-list-timeline__text">New invoice received</a>
                                            <span class="m-list-timeline__time">20 mins</span>
                                        </div>
                                        <div class="m-list-timeline__item">
                                            <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                            <a href="" class="m-list-timeline__text">Production server up</a>
                                            <span class="m-list-timeline__time">5 hrs</span>
                                        </div>
                                        <div class="m-list-timeline__item">
                                            <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                            <a href="" class="m-list-timeline__text">New order received</a>
                                            <span class="m-list-timeline__time">7 hrs</span>
                                        </div>
                                        <div class="m-list-timeline__item">
                                            <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                            <a href="" class="m-list-timeline__text">System shutdown</a>
                                            <span class="m-list-timeline__time">11 mins</span>
                                        </div>
                                        <div class="m-list-timeline__item">
                                            <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                            <a href="" class="m-list-timeline__text">Production server down</a>
                                            <span class="m-list-timeline__time">3 hrs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                            <div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
                                <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                    <span class="">All caught up!<br>No new logs.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
