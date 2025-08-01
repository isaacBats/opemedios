<div class="leftpanel">
  <div class="leftpanelinner">

    <!-- ################## LEFT PANEL PROFILE ################## -->

    <div class="media leftpanel-profile">
      <div class="media-left">
        <a href="#">
          <img src="https://ui-avatars.com/api/?name={{ str_replace(' ', '+', ucwords(Auth::user()->name)) }}" alt="" class="media-object img-circle">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">{{ Auth::user()->name }} <a data-toggle="collapse" data-target="#loguserinfo" class="pull-right"><i class="fa fa-angle-down"></i></a></h4>
        <span>{{ Auth::user()->metas->where('meta_key', 'user_position')->first()->meta_value }}</span>
      </div>
    </div><!-- leftpanel-profile -->

    <div class="leftpanel-userinfo collapse" id="loguserinfo">
      <h5 class="sidebar-title">{{ __('Dirección') }}</h5>
      <address>
        {{ Auth::user()->getMetaByKey('user_address') ? Auth::user()->getMetaByKey('user_address')->meta_value : "-" }}
      </address>
      <h5 class="sidebar-title">{{ __('Contacto') }}</h5>
      <ul class="list-group">
        <li class="list-group-item">
          <label class="pull-left">{{ __('Email') }}</label>
          <span class="pull-right">{{ Auth::user()->email }}</span>
        </li>
        <li class="list-group-item">
          <label class="pull-left">{{ __('Oficina') }}</label>
          <span class="pull-right">{{ Auth::user()->getMetaByKey('user_phone') ? Auth::user()->getMetaByKey('user_phone')->meta_value : "-" }}</span>
        </li>
        <li class="list-group-item">
          <label class="pull-left">{{ __('WhatsApp') }}</label>
          <span class="pull-right">{{ Auth::user()->getMetaByKey('user_whatsapp') ? Auth::user()->getMetaByKey('user_whatsapp')->meta_value : "-" }}</span>
        </li>
        <li class="list-group-item">
          <label class="pull-left">Social</label>
          <div class="social-icons pull-right">
            @if(Auth::user()->getMetaByKey('user_facebook'))
                <a href="{{ Auth::user()->getMetaByKey('user_facebook')->meta_value }}"><i class="fa fa-facebook-official"></i></a>
            @endif
            @if(Auth::user()->getMetaByKey('user_twitter'))
                <a href="{{ Auth::user()->getMetaByKey('user_twitter')->meta_value}}"><i class="fa fa-twitter"></i></a>
            @endif
            @if(Auth::user()->getMetaByKey('user_instagram'))
                <a href="{{ Auth::user()->getMetaByKey('user_instagram')->meta_value}}"><i class="fa fa-instagram"></i></a>
            @endif
            @if(Auth::user()->getMetaByKey('user_linkedin'))
                <a href="{{ Auth::user()->getMetaByKey('user_linkedin')->meta_value}}"><i class="fa fa-linkedin"></i></a>
            @endif
          </div>
        </li>
      </ul>
    </div><!-- leftpanel-userinfo -->

    <ul class="nav nav-tabs nav-justified nav-sidebar">
      <li class="tooltips active" data-toggle="tooltip" title="Main Menu"><a data-toggle="tab" data-target="#mainmenu"><i class="tooltips fa fa-ellipsis-h"></i></a></li>
      {{-- <li class="tooltips unread" data-toggle="tooltip" title="Check Mail"><a data-toggle="tab" data-target="#emailmenu"><i class="tooltips fa fa-envelope"></i></a></li>
      <li class="tooltips" data-toggle="tooltip" title="Contacts"><a data-toggle="tab" data-target="#contactmenu"><i class="fa fa-user"></i></a></li>
      <li class="tooltips" data-toggle="tooltip" title="Settings"><a data-toggle="tab" data-target="#settings"><i class="fa fa-cog"></i></a></li> --}}
      <li class="tooltips" data-toggle="tooltip" title="Salir"><a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i></a></li>
    </ul>

    <div class="tab-content">

      <!-- ################# MAIN MENU ################### -->

      <div class="tab-pane active" id="mainmenu">
        @can('view menu')
            <h5 class="sidebar-title">Home</h5>
            <ul class="nav nav-pills nav-stacked nav-quirk">
              <li><a href="{{ route('panel') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
            </ul>

            <h5 class="sidebar-title">Catálogo</h5>
            <ul class="nav nav-pills nav-stacked nav-quirk">
                <li><a href="{{ route('users') }}"><i class="fa fa-users"></i> <span>Usuarios</span></a></li>
                <li class="nav-parent">
                    <a href="javascript:void(0)"><i class="fa fa-building"></i> <span>{{ __('Empresas') }}</span></a>
                    <ul class="children">
                        <li><a href="{{ route('companies') }}">{{ __('Empresas') }}</a></li>
                        <li><a href="{{ route('admin.turns') }}">{{ __('Giros') }}</a></li>
                    </ul>
              </li>
              <li><a href="{{ route('admin.sectors') }}"><i class="fa fa-archive"></i><span>{{ __('Sectores') }}</span></a></li>
            </ul>
        @endcan

        <h5 class="sidebar-title">Monitoreo</h5>
        <ul class="nav nav-pills nav-stacked nav-quirk">
            <li><a href="{{ route('sources') }}"><i class="fa fa-database"></i> <span>Fuentes</span></a></li>
            <li><a href="{{ route('social_networks') }}"><i class="fa fa-database"></i> <span>Redes sociales</span></a></li>
            @if(Auth::user()->isMonitor() || Auth::user()->isAdmin() || Auth::user()->isExecutive())
            <li><a href="{{ route('clientes') }}"><i class="fa fa-users"></i> <span>Tareas</span></a></li>
            @endif
            <li class="nav-parent">
                <a href="javascript:void(0)"><i class="fa fa-rss"></i> <span>{{ __('Monitoreo') }}</span></a>
                <ul class="children">
                    <li><a href="{{ route('admin.news') }}">{{ __('Noticias') }}</a></li>
                    <li><a href="{{ route('admin.new.add') }}" id="link-add-new">{{ __('Nueva noticia') }}</a></li>
                </ul>
            </li>
          <li><a href="{{ route('admin.newsletters') }}"><i class="fa fa-send-o"></i> <span>Newsletter</span></a></li>
          <li class="nav-parent">
                <a href="javascript:void(0);"><i class="fa fa-newspaper-o"></i> <span>Prensa</span></a>
                <ul class="children">
                    <li><a href="{{ route('admin.press.show') }}">{{ __('Administrar portadas') }}</a></li>
                    <li><a href="{{ route('admin.press.add') }}">{{ __('Subir portadas') }}</a></li>
                </ul>
          </li>
          <li><a href="{{ route('newspaper.index') }}"><i class="fa fa-file"></i> <span>Periodicos</span></a></li>
          {{-- <li><a href="{{ route('filemanager') }}"><i class="fa fa-cloud"></i> <span>Archivos</span></a></li> --}}
          {{--
            <li class="nav-parent">
              <a href=""><i class="fa fa-check-square"></i> <span>Forms</span></a>
              <ul class="children">
                <li><a href="general-forms.html">Form Elements</a></li>
                <li><a href="form-validation.html">Form Validation</a></li>
                <li><a href="form-wizards.html">Form Wizards</a></li>
                <li><a href="wysiwyg.html">Text Editor</a></li>
              </ul>
            </li>
            <li class="nav-parent"><a href=""><i class="fa fa-suitcase"></i> <span>UI Elements</span></a>
              <ul class="children">
                <li><a href="buttons.html">Buttons</a></li>
                <li><a href="icons.html">Icons</a></li>
                <li><a href="typography.html">Typography</a></li>
                <li><a href="alerts.html">Alerts &amp; Notifications</a></li>
                <li><a href="tabs-accordions.html">Tabs &amp; Accordions</a></li>
                <li><a href="sliders.html">Sliders</a></li>
                <li><a href="graphs.html">Graphs &amp; Charts</a></li>
                <li><a href="panels.html">Panels</a></li>
                <li><a href="extras.html">Extras</a></li>
              </ul>
            </li>
            <li class="nav-parent"><a href=""><i class="fa fa-th-list"></i> <span>Tables</span></a>
              <ul class="children">
                <li><a href="basic-tables.html">Basic Tables</a></li>
                <li><a href="data-tables.html">Data Tables</a></li>
              </ul>
            </li>
            <li class="nav-parent active"><a href=""><i class="fa fa-file-text"></i> <span>Pages</span></a>
              <ul class="children">
                <li><a href="asset-manager.html">Asset Manager</a></li>
                <li><a href="people-directory.html">People Directory</a></li>
                <li><a href="timeline.html">Timeline</a></li>
                <li><a href="profile.html">Profile</a></li>
                <li class="active"><a href="blank.html">Blank Page</a></li>
                <li><a href="notfound.html">404 Page</a></li>
                <li><a href="signin.html">Sign In</a></li>
                <li><a href="signup.html">Sign Up</a></li>
              </ul>
            </li>
          --}}
        </ul>

        @can('view menu')
            <h5 class="sidebar-title">Reportes</h5>
            <ul class="nav nav-pills nav-stacked nav-quirk">
              <li><a href="{{ route('admin.report.byclient') }}"><i class="fa fa-bar-chart"></i> <span>Noticias por Cliente</span></a></li>
              <li><a href="{{ route('admin.report.bynotes') }}"><i class="fa fa-area-chart"></i> <span>Notas por día</span></a></li>
              <li><a href="{{ route('admin.report.solicitados') }}"><i class="fa fa-download"></i> <span>En cola para descarga</span></a></li>
            </ul>
            <h5 class="sidebar-title">CMS</h5>
            <ul class="nav nav-pills nav-stacked nav-quirk">
              <li><a href="index.html"><i class="fa fa-file-text"></i> <span>Pages</span></a></li>
              {{-- <li><a href="widgets.html"><i class="fa fa-area-chart"></i> <span>Others</span></a></li> --}}
            </ul>
        @endcan
      </div><!-- tab-pane -->

      <!-- ######################## EMAIL MENU ##################### -->

      {{-- <div class="tab-pane" id="emailmenu">
        <div class="sidebar-btn-wrapper">
          <a href="compose.html" class="btn btn-danger btn-block">Compose</a>
        </div>

        <h5 class="sidebar-title">Mailboxes</h5>
        <ul class="nav nav-pills nav-stacked nav-quirk nav-mail">
          <li><a href="email.html"><i class="fa fa-inbox"></i> <span>Inbox (3)</span></a></li>
          <li><a href="email.html"><i class="fa fa-pencil"></i> <span>Draft (2)</span></a></li>
          <li><a href="email.html"><i class="fa fa-paper-plane"></i> <span>Sent</span></a></li>
        </ul>

        <h5 class="sidebar-title">Tags</h5>
        <ul class="nav nav-pills nav-stacked nav-quirk nav-label">
          <li><a href="#"><i class="fa fa-tags primary"></i> <span>Communication</span></a></li>
          <li><a href="#"><i class="fa fa-tags success"></i> <span>Updates</span></a></li>
          <li><a href="#"><i class="fa fa-tags warning"></i> <span>Promotions</span></a></li>
          <li><a href="#"><i class="fa fa-tags danger"></i> <span>Social</span></a></li>
        </ul>
      </div> --}}<!-- tab-pane -->

      <!-- ################### CONTACT LIST ################### -->

      {{-- <div class="tab-pane" id="contactmenu">
        <div class="input-group input-search-contact">
          <input type="text" class="form-control" placeholder="Search contact">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
          </span>
        </div>
        <h5 class="sidebar-title">My Contacts</h5>
        <ul class="media-list media-list-contacts">
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user1.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Christina R. Hill</h4>
                <span><i class="fa fa-phone"></i> 386-752-1860</span>
              </div>
            </a>
          </li>
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user2.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Floyd M. Romero</h4>
                <span><i class="fa fa-mobile"></i> +1614-650-8281</span>
              </div>
            </a>
          </li>
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user3.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Jennie S. Gray</h4>
                <span><i class="fa fa-phone"></i> 310-757-8444</span>
              </div>
            </a>
          </li>
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user4.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Alia J. Locher</h4>
                <span><i class="fa fa-mobile"></i> +1517-386-0059</span>
              </div>
            </a>
          </li>
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user5.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Nicholas T. Hinkle</h4>
                <span><i class="fa fa-skype"></i> nicholas.hinkle</span>
              </div>
            </a>
          </li>
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user6.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Jamie W. Bradford</h4>
                <span><i class="fa fa-phone"></i> 225-270-2425</span>
              </div>
            </a>
          </li>
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user7.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Pamela J. Stump</h4>
                <span><i class="fa fa-mobile"></i> +1773-879-2491</span>
              </div>
            </a>
          </li>
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user8.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Refugio C. Burgess</h4>
                <span><i class="fa fa-mobile"></i> +1660-627-7184</span>
              </div>
            </a>
          </li>
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user9.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Ashley T. Brewington</h4>
                <span><i class="fa fa-skype"></i> ashley.brewington</span>
              </div>
            </a>
          </li>
          <li class="media">
            <a href="#">
              <div class="media-left">
                <img class="media-object img-circle" src="../images/photos/user10.png" alt="">
              </div>
              <div class="media-body">
                <h4 class="media-heading">Roberta F. Horn</h4>
                <span><i class="fa fa-phone"></i> 716-630-0132</span>
              </div>
            </a>
          </li>
        </ul>
      </div> --}}<!-- tab-pane -->

      <!-- #################### SETTINGS ################### -->

      {{-- <div class="tab-pane" id="settings">
        <h5 class="sidebar-title">General Settings</h5>
        <ul class="list-group list-group-settings">
          <li class="list-group-item">
            <h5>Daily Newsletter</h5>
            <small>Get notified when someone else is trying to access your account.</small>
            <div class="toggle-wrapper">
              <div class="leftpanel-toggle toggle-light success"></div>
            </div>
          </li>
          <li class="list-group-item">
            <h5>Call Phones</h5>
            <small>Make calls to friends and family right from your account.</small>
            <div class="toggle-wrapper">
              <div class="leftpanel-toggle-off toggle-light success"></div>
            </div>
          </li>
        </ul>
        <h5 class="sidebar-title">Security Settings</h5>
        <ul class="list-group list-group-settings">
          <li class="list-group-item">
            <h5>Login Notifications</h5>
            <small>Get notified when someone else is trying to access your account.</small>
            <div class="toggle-wrapper">
              <div class="leftpanel-toggle toggle-light success"></div>
            </div>
          </li>
          <li class="list-group-item">
            <h5>Phone Approvals</h5>
            <small>Use your phone when login as an extra layer of security.</small>
            <div class="toggle-wrapper">
              <div class="leftpanel-toggle toggle-light success"></div>
            </div>
          </li>
        </ul>
      </div> --}}<!-- tab-pane -->


    </div><!-- tab-content -->

  </div><!-- leftpanelinner -->
</div><!-- leftpanel -->
