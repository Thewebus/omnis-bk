<script src="{{asset('/assets/js/jquery-3.5.1.min.js')}}"></script>
<!-- feather icon js-->
<script src="{{asset('/assets/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset('/assets/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{asset('/assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('/assets/js/config.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{asset('/assets/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('/assets/js/bootstrap/bootstrap.min.js')}}"></script>
<!-- Plugins JS start-->
@stack('scripts')
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset('/assets/js/script.js')}}"></script>
<script src="{{asset('/assets/js/theme-customizer/customizer.js')}}"></script>
<!-- Plugin used-->
<!-- Livewire script-->
@livewireScripts

<!-- Flashy script-->
<style type="text/css">
    .flashy {
        font-family: "Source Sans Pro", Arial, sans-serif;
        padding: 11px 30px;
        border-radius: 4px;
        font-weight: 400;
        position: fixed;
        bottom: 20px;
        right: 20px;
        font-size: 16px;
        color: #fff;
    }
</style>
    
<script id="flashy-template" type="text/template">
    <div class="flashy flashy--{{ Session::get('flashy_notification.type') }}">
        <i class="material-icons">speaker_notes</i>
        <a href="#" class="flashy__body" target="_blank"></a>
    </div>
</script>