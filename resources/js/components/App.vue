<template>
    <div class="wrapper">
        <navbar></navbar>
        <sidebar></sidebar>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <router-view></router-view>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->

        <footerbar></footerbar>
        <rightbar></rightbar>
    </div>
</template>
