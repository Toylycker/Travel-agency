<template>
  <main class="d-flex flex-nowrap">
    <h1 class="visually-hidden">Sidebars examples</h1>

    <div class="d-flex flex-column flex-shrink-0 bg-light" style="width: 4.5rem;">
      <Link href="/" class="d-block p-3 link-dark text-decoration-none" title="Icon-only" data-bs-toggle="tooltip"
        data-bs-placement="right">
      <svg class="bi pe-none" width="40" height="32">
        <use xlink:href="#bootstrap" />
      </svg>
      <span class="visually-hidden">Icon-only</span>
      </Link>
      <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
        <li>
          <Link :class="{ 'active': $page.component == 'admin/adminDashboard' }" :href="route('admin.dashboard')"
            class="nav-link py-3 border-bottom rounded-0" title="Dashboard" data-bs-toggle="tooltip"
            data-bs-placement="right">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-speedometer2"
            viewBox="0 0 16 16">
            <path
              d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z" />
            <path fill-rule="evenodd"
              d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z" />
          </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/Places/index' }" :href="route('admin.places.index')"
            class="nav-link py-3 border-bottom rounded-0" title="Places" data-bs-toggle="tooltip"
            data-bs-placement="right">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo"
            viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M8 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6zM4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z" />
          </svg>

          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/Tours/index' }" :href="route('admin.tours.index')"
            class="nav-link py-3 border-bottom rounded-0" title="Tours" data-bs-toggle="tooltip"
            data-bs-placement="right">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-signpost-2"
            viewBox="0 0 16 16">
            <path
              d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
          </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/Blog/index' }" :href="route('admin.posts.index')"
            class="nav-link py-3 border-bottom rounded-0" title="Blog" data-bs-toggle="tooltip"
            data-bs-placement="right">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
            class="bi bi-postcard-heart" viewBox="0 0 16 16">
            <path
              d="M8 4.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7Zm3.5.878c1.482-1.42 4.795 1.392 0 4.622-4.795-3.23-1.482-6.043 0-4.622ZM2.5 5a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Z" />
            <path fill-rule="evenodd"
              d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Z" />
          </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/Hotels/index' }" :href="route('admin.hotels.index')"
            class="nav-link py-3 border-bottom rounded-0" title="Hotels" data-bs-toggle="tooltip"
            data-bs-placement="right">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-building"
            viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z" />
            <path
              d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z" />
          </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component.startsWith('admin/Rooms') }" :href="route('admin.rooms.index')"
            class="nav-link py-3 border-bottom rounded-0" title="Rooms" data-bs-toggle="tooltip"
            data-bs-placement="right">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.5V15h6V1.5a.5.5 0 0 0-.066-.218L4.282.066A.5.5 0 0 0 4 1.5z"/>
            </svg>
          </Link>
        </li>
        <li>
          <Link :href="route('admin.messages.index')" class="nav-link py-3 border-bottom rounded-0" title="Messages" data-bs-toggle="tooltip"
            data-bs-placement="right">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope"
            viewBox="0 0 16 16">
            <path
              d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
          </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/Applications/index' }"
            :href="route('admin.applications.index')" class="nav-link py-3 border-bottom rounded-0" title="Applications"
            data-bs-toggle="tooltip" data-bs-placement="right">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-app"
            viewBox="0 0 16 16">
            <path
              d="M11 2a3 3 0 0 1 3 3v6a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3h6zM5 1a4 4 0 0 0-4 4v6a4 4 0 0 0 4 4h6a4 4 0 0 0 4-4V5a4 4 0 0 0-4-4H5z" />
          </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/CustomTours/index' }"
            :href="route('admin.customTour.index')" class="nav-link py-3 border-bottom rounded-0" title="Custom Tours"
            data-bs-toggle="tooltip" data-bs-placement="right">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-lightbulb" viewBox="0 0 16 16">
  <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1"/>
</svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/Categories/index' }"
            :href="route('admin.categories.index')" class="nav-link py-3 border-bottom rounded-0" title="Applications"
            data-bs-toggle="tooltip" data-bs-placement="right">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
</svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/Notes/index' }"
            :href="route('admin.notes.index')" class="nav-link py-3 border-bottom rounded-0" title="Notes"
            data-bs-toggle="tooltip" data-bs-placement="right">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-card-heading" viewBox="0 0 16 16">
              <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
              <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
            </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/transportations/index' }"
            :href="route('admin.transportations.index')" class="nav-link py-3 border-bottom rounded-0" title="Transportation"
            data-bs-toggle="tooltip" data-bs-placement="right">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
              <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
            </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/costs/index' }"
            :href="route('admin.costs.index')" class="nav-link py-3 border-bottom rounded-0" title="Costs"
            data-bs-toggle="tooltip" data-bs-placement="right">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
              <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
            </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/CustomCosts/Index' }"
            :href="route('admin.custom-costs.index')" class="nav-link py-3 border-bottom rounded-0" title="Custom Costs"
            data-bs-toggle="tooltip" data-bs-placement="right">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
              <path d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
              <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.935-1.358-1.244l-.76-.272a.5.5 0 0 1-.066-.051c-.004-.003-.007-.006-.007-.01 0-.003.002-.005.004-.006l.002-.002c.002-.002.005-.004.008-.005h.001c.002-.002.005-.003.007-.003.003 0 .005-.001.008-.001l.003-.001h.001c.004 0 .007 0 .01.001.003 0 .006 0 .009.001l.003.001h.001c.003 0 .006.001.008.001.004 0 .007.001.01.002l.002.001h.002c.002 0 .005.001.007.001.002.001.005.002.007.003l.002.001c.002.001.004.002.006.003.004.002.006.004.009.006l.002.002a.017.017 0 0 0 .005.004.02.02 0 0 0 .004.003.04.04 0 0 0 .003.002.027.027 0 0 0 .003.002.018.018 0 0 0 .002.002.023.023 0 0 0 .003.002.04.04 0 0 0 .002.001.028.028 0 0 0 .003.002.06.06 0 0 0 .002.001.048.048 0 0 0 .003.001.038.038 0 0 0 .002.001.02.02 0 0 1-.002.001.024.024 0 0 1-.002.001h-.001a.02.02 0 0 1-.002.001.012.012 0 0 1 0-.001.03.03 0 0 1 0-.001.025.025 0 0 1 0-.002.016.016 0 0 1 .002-.002.015.015 0 0 1 .002-.002.01.01 0 0 1 .002-.001.007.007 0 0 1 .003-.002.006.006 0 0 1 .002-.001.004.004 0 0 1 .003-.001.01.01 0 0 1 .002-.001.004.004 0 0 1 .003-.001c.002 0 .004 0 .005 0h.001c.002 0 .004 0 .006 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .004 0 .005 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .003 0 .005 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .003 0 .005 0h.002a.5.5 0 0 1 .006 0c.002 0 .003 0 .005 0h.001c.002 0 .004 0 .006 0l.002.001c.002 0 .004.001.005.001h-.002c.002 0 .003.001.005.001l-.002.001c.002 0 .004.001.006.001l-.002.001c.002 0 .003.001.005.002l-.002.001c.002.001.004.001.006.002l-.002.001c.002.001.003.001.004.002l-.002.001c.002.001.004.001.005.002l-.002.001c.002.001.003.001.004.002l-.002.002a.08.08 0 0 1-.004.002.03.03 0 0 1-.003.002.03.03 0 0 1-.002.002c.002.002.003.003.004.004a.03.03 0 0 1-.002.002.04.04 0 0 1-.002.003.033.033 0 0 1-.002.002.02.02 0 0 1-.002.002.02.02 0 0 1-.002.002.02.02 0 0 1-.002.002.018.018 0 0 1-.001.002.015.015 0 0 1-.002.001.013.013 0 0 1-.001.002.015.015 0 0 1-.001.001.01.01 0 0 1-.002.001.013.013 0 0 1-.001.001.013.013 0 0 1-.001.001.01.01 0 0 1-.001.001.006.006 0 0 1 0 .001c0 .001-.001.001-.001.002a.006.006 0 0 1 0 .001zm.306-1.362c.16.034.302.09.424.163l.76.272a.5.5 0 0 0 .067.05c.004.003.006.006.007.009.001.003 0 .006-.002.009l-.002.002a.018.018 0 0 1-.004.004.023.023 0 0 1-.004.003.038.038 0 0 1-.003.002.028.028 0 0 1-.003.002.018.018 0 0 1-.002.002.023.023 0 0 1-.003.002.04.04 0 0 1-.002.001.028.028 0 0 1-.003.002.06.06 0 0 1-.002.001.048.048 0 0 1-.003.001.038.038 0 0 1-.002.001.02.02 0 0 1-.002.001.024.024 0 0 1-.002.001h-.001a.02.02 0 0 1-.002.001.012.012 0 0 1 0-.001.03.03 0 0 1 0-.001.025.025 0 0 1 0-.002.016.016 0 0 1 .002-.002.015.015 0 0 1 .002-.002.01.01 0 0 1 .002-.001.007.007 0 0 1 .003-.002.006.006 0 0 1 .002-.001.004.004 0 0 1 .003-.001.01.01 0 0 1 .002-.001.004.004 0 0 1 .003-.001c.002 0 .004 0 .005 0h.001c.002 0 .004 0 .006 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .004 0 .005 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .003 0 .005 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .003 0 .005 0h.002a.5.5 0 0 1 .006 0c.002 0 .003 0 .005 0h.001c.002 0 .004 0 .006 0l.002.001c.002 0 .004.001.005.001h-.002c.002 0 .003.001.005.001l-.002.001c.002 0 .004.001.006.001l-.002.001c.002 0 .003.001.005.001l-.002.001c.002 0 .004.001.006.001h-.001c.002 0 .003.001.004.001l-.002.001c.002 0 .004.001.006.001l-.002.001c.002.001.003.001.005.002l-.002.001c.002.001.004.001.006.002l-.002.001c.002.001.003.001.004.002l-.002.001c.002.001.004.001.005.002l-.002.001c.002.001.003.001.004.002l-.002.002a.08.08 0 0 0 .004.002.03.03 0 0 0 .003.002.03.03 0 0 0 .002.002c.002.002.003.003.004.004a.03.03 0 0 0 .002.002.04.04 0 0 0 .002.003.033.033 0 0 0 .002.002.02.02 0 0 0 .002.002.02.02 0 0 0 .002.002.02.02 0 0 0 .002.002.018.018 0 0 0 .001.002.015.015 0 0 0 .002.001.013.013 0 0 0 .001.002.015.015 0 0 0 .001.001.01.01 0 0 0 .002.001.013.013 0 0 0 .001.001.013.013 0 0 0 .001.001.01.01 0 0 0 .001.001.006.006 0 0 0 0 .001c0 .001-.001.001-.001.002a.006.006 0 0 1 0 .001zm.306-1.362c.16.034.302.09.424.163l.76.272a.5.5 0 0 0 .067.05c.004.003.006.006.007.009.001.003 0 .006-.002.009l-.002.002a.018.018 0 0 1-.004.004.023.023 0 0 1-.004.003.038.038 0 0 1-.003.002.028.028 0 0 1-.003.002.018.018 0 0 1-.002.002.023.023 0 0 1-.003.002.04.04 0 0 1-.002.001.028.028 0 0 1-.003.002.06.06 0 0 1-.002.001.048.048 0 0 1-.003.001.038.038 0 0 1-.002.001.02.02 0 0 1-.002.001.024.024 0 0 1-.002.001h-.001a.02.02 0 0 1-.002.001.012.012 0 0 1 0-.001.03.03 0 0 1 0-.001.025.025 0 0 1 0-.002.016.016 0 0 1 .002-.002.015.015 0 0 1 .002-.002.01.01 0 0 1 .002-.001.007.007 0 0 1 .003-.002.006.006 0 0 1 .002-.001.004.004 0 0 1 .003-.001.01.01 0 0 1 .002-.001.004.004 0 0 1 .003-.001c.002 0 .004 0 .005 0h.001c.002 0 .004 0 .006 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .004 0 .005 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .003 0 .005 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .003 0 .005 0h.002a.5.5 0 0 1 .006 0c.002 0 .003 0 .005 0h.001c.002 0 .004 0 .006 0l.002.001c.002 0 .004.001.005.001h-.002c.002 0 .003.001.005.001l-.002.001c.002 0 .004.001.006.001l-.002.001c.002 0 .003.001.005.001l-.002.001c.002 0 .004.001.006.001h-.001c.002 0 .003.001.004.001l-.002.001c.002 0 .004.001.006.001l-.002.001c.002.001.003.001.005.002l-.002.001c.002.001.004.001.006.002l-.002.001c.002.001.003.001.004.002l-.002.001c.002.001.004.001.005.002l-.002.001c.002.001.003.001.004.002l-.002.002a.08.08 0 0 1-.004.002.03.03 0 0 1-.003.002.03.03 0 0 1-.002.002c.002.002.003.003.004.004a.03.03 0 0 1-.002.002.04.04 0 0 1-.002.003.033.033 0 0 1-.002.002.02.02 0 0 1-.002.002.02.02 0 0 1-.002.002.02.02 0 0 1-.002.002.018.018 0 0 1-.001.002.015.015 0 0 1-.002.001.013.013 0 0 1-.001.002.015.015 0 0 1-.001.001.01.01 0 0 1-.002.001.013.013 0 0 1-.001.001.013.013 0 0 1-.001.001.01.01 0 0 1-.001.001.006.006 0 0 1 0 .001c0 .001-.001.001-.001.002a.006.006 0 0 1 0 .001zm.306-1.362c.16.034.302.09.424.163l.76.272a.5.5 0 0 0 .067.05c.004.003.006.006.007.009.001.003 0 .006-.002.009l-.002.002a.018.018 0 0 1-.004.004.023.023 0 0 1-.004.003.038.038 0 0 1-.003.002.028.028 0 0 1-.003.002.018.018 0 0 1-.002.002.023.023 0 0 1-.003.002.04.04 0 0 1-.002.001.028.028 0 0 1-.003.002.06.06 0 0 1-.002.001.048.048 0 0 1-.003.001.038.038 0 0 1-.002.001.02.02 0 0 1-.002.001.024.024 0 0 1-.002.001h-.001a.02.02 0 0 1-.002.001.012.012 0 0 1 0-.001.03.03 0 0 1 0-.001.025.025 0 0 1 0-.002.016.016 0 0 1 .002-.002.015.015 0 0 1 .002-.002.01.01 0 0 1 .002-.001.007.007 0 0 1 .003-.002.006.006 0 0 1 .002-.001.004.004 0 0 1 .003-.001.01.01 0 0 1 .002-.001.004.004 0 0 1 .003-.001c.002 0 .004 0 .005 0h.001c.002 0 .004 0 .006 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .004 0 .005 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .003 0 .005 0h.002c.002 0 .004 0 .006 0h.001c.002 0 .003 0 .005 0h.002a.5.5 0 0 1 .006 0c.002 0 .003 0 .005 0h.001c.002 0 .004 0 .006 0l.002.001c.002 0 .004.001.005.001h-.002c.002 0 .003.001.005.001l-.002.001c.002 0 .004.001.006.001l-.002.001c.002 0 .003.001.005.002l-.002.001c.002.001.004.001.006.002l-.002.001c.002.001.003.001.004.002l-.002.001c.002.001.004.001.005.002l-.002.001c.002.001.003.001.004.002l-.002.002a.08.08 0 0 0 .004.002.03.03 0 0 0 .003.002.03.03 0 0 0 .002.002c.002.002.003.003.004.004a.03.03 0 0 0 .002.002.04.04 0 0 0 .002.003.033.033 0 0 0 .002.002.02.02 0 0 0 .002.002.02.02 0 0 0 .002.002.02.02 0 0 0 .002.002.018.018 0 0 0 .001.002.015.015 0 0 0 .002.001.013.013 0 0 0 .001.002.015.015 0 0 0 .001.001.01.01 0 0 0 .002.001.013.013 0 0 0 .001.001.013.013 0 0 0 .001.001.01.01 0 0 0 .001.001.006.006 0 0 0 0 .001c0-.001.001-.001.001-.002a.006.006 0 0 0 0-.001z"/>
              <path d="M1 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm2 9a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1zm-1 3.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m1.886-9.18A.5.5 0 0 1 3 3.5v1a.5.5 0 0 1-.528.495l-.727.081a.5.5 0 0 1-.492-.534V3.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .114.02zM6 13.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m.5 4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5m2.5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m.5 2a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5"/>
            </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/guides/index' }"
            :href="route('admin.guides.index')" class="nav-link py-3 border-bottom rounded-0" title="Guides"
            data-bs-toggle="tooltip" data-bs-placement="right">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
              <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
              <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492z"/>
            </svg>
          </Link>
        </li>
        <li>
          <Link :class="{ 'active': $page.component == 'admin/meals/index' }"
            :href="route('admin.meals.index')" class="nav-link py-3 border-bottom rounded-0" title="Meals"
            data-bs-toggle="tooltip" data-bs-placement="right">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cup-hot" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M.5 6a.5.5 0 0 0-.488.608l1.652 7.434A2.5 2.5 0 0 0 4.104 16h5.792a2.5 2.5 0 0 0 2.44-1.958l.131-.59a3 3 0 0 0 1.3-5.854l.221-.99A.5.5 0 0 0 13.5 6zM13 12.5a2.01 2.01 0 0 1-.316-.025l.867-3.898A2.001 2.001 0 0 1 13 12.5"/>
              <path d="m4.4.8-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 3.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 3.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 3 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 4.4.8m3 0-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 6.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 6.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 6 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 7.4.8m3 0-.003.004-.014.019a4.077 4.077 0 0 0-.204.31 2.337 2.337 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 9.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 9.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 9 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 10.4.8"/>
            </svg>
          </Link>
        </li>
        <Link :class="{ 'active': $page.component == 'admin/Users/index' }" :href="route('admin.users.index')"
          class="nav-link py-3 border-bottom rounded-0" title="Users" data-bs-toggle="tooltip"
          data-bs-placement="right">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people"
          viewBox="0 0 16 16">
          <path
            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
        </svg>
        </Link>
        <li class="nav-item" v-if="$page.props.auth != null">
          <Link class="nav-link" :class="{ 'active': $page.component == 'Auth/Logout' }" :href="route('logout')"
            method="post" as="button">
          logout</Link>
        </li>
      </ul>
      <div class="dropdown border-top">
        <Link href="#"
          class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle"
          data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="mdo" width="24" height="24" class="rounded-circle">
        </Link>
        <ul class="dropdown-menu text-small shadow">
          <li>
            <Link class="dropdown-item" href="#">New project...</Link>
          </li>
          <li>
            <Link class="dropdown-item" href="#">Settings</Link>
          </li>
          <li>
            <Link class="dropdown-item" href="#">Profile</Link>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <Link class="dropdown-item" href="#">Sign out</Link>
          </li>
        </ul>
      </div>
    </div>
    <div class="m-3 container-fluid">
      <ValidationErrorShower />
      <slot></slot>
    </div>
  </main>
</template>
  
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref, watch } from '@vue/runtime-core';
import '@splidejs/vue-splide/css';
import { Inertia } from '@inertiajs/inertia';
import ValidationErrorShower from '@/Shared/ValidationErrorShower.vue';

</script>
  
<style>
.bd-placeholder-img {
  font-size: 1.125rem;
  text-anchor: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}

@media (min-width: 768px) {
  .bd-placeholder-img-lg {
    font-size: 3.5rem;
  }
}

.b-example-divider {
  height: 3rem;
  background-color: rgba(0, 0, 0, .1);
  border: solid rgba(0, 0, 0, .15);
  border-width: 1px 0;
  box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
}

.b-example-vr {
  flex-shrink: 0;
  width: 1.5rem;
  height: 100vh;
}

.bi {
  vertical-align: -.125em;
  fill: currentColor;
}

.nav-scroller {
  position: relative;
  z-index: 2;
  height: 2.75rem;
  overflow-y: hidden;
}

.nav-scroller .nav {
  display: flex;
  flex-wrap: nowrap;
  padding-bottom: 1rem;
  margin-top: -1px;
  overflow-x: auto;
  text-align: center;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}
</style>