<iframe id="iframepage" src="/adminb/default/phpinfoframe" width="100%" onload="changeFrameHeight()">

</iframe>
<script>
    function changeFrameHeight(){
        var ifm= document.getElementById("iframepage");
        ifm.height=document.documentElement.clientHeight-100;
    }
    window.onresize=function(){
        changeFrameHeight();
    }
</script>