<!DOCTYPE html>
<html lang="en">

<head>
    @include('clients.admin.blocks.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @include('clients.admin.blocks.header')

    @include('clients.admin.blocks.sidebar')
    <div class="content-wrapper">

        @yield('content')
    </div>
    @include('clients.admin.blocks.footer')
</body>

</html>
